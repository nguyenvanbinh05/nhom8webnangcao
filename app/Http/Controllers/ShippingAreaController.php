<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ShippingArea;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShippingAreaController extends Controller
{
    /**
     * Danh sách các khu vực giao hàng
     */
    public function index(Request $request)
    {
        $query = ShippingArea::query();

        // Tìm kiếm theo tỉnh
        if ($request->filled('province')) {
            $query->where('province_name', 'like', '%' . $request->province . '%');
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $areas = $query->orderBy('province_name')
            ->orderBy('district_name')
            ->orderBy('ward_name')
            ->paginate(20);

        return view('admin.shipping.index', compact('areas'));
    }

    /**
     * Form thêm khu vực
     */
    public function create()
    {
        try {
            // Lấy danh sách tỉnh/huyện/xã từ API
            $provinces = $this->getProvincesList();

            // Debug
            if (empty($provinces)) {
                dd('Provinces trống! API không trả về dữ liệu.');
            }

            return view('admin.shipping.create', compact('provinces'));
        } catch (\Exception $e) {
            dd('Lỗi create: ' . $e->getMessage() . ' - ' . $e->getFile() . ':' . $e->getLine());
        }
    }

    /**
     * Lưu khu vực mới
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'province_id' => 'required|string',
            'province_name' => 'required|string|max:120',
            'district_id' => 'nullable|string',
            'district_name' => 'nullable|string|max:120',
            'ward_id' => 'nullable|string',
            'ward_name' => 'nullable|string|max:120',
            'shipping_cost' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ], [
            'province_id.required' => 'Vui lòng chọn tỉnh/thành phố',
            'shipping_cost.required' => 'Vui lòng nhập phí giao hàng',
            'shipping_cost.integer' => 'Phí giao hàng phải là số nguyên',
        ]);

        // Chuyển string "0" hoặc "1" thành boolean
        $validated['is_active'] = (bool) ($request->input('is_active', 1));

        // Kiểm tra trùng lặp
        $exists = ShippingArea::where('province_id', $validated['province_id'])
            ->where('district_id', $validated['district_id'])
            ->where('ward_id', $validated['ward_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['message' => 'Khu vực này đã tồn tại'])->withInput();
        }

        ShippingArea::create($validated);

        return redirect()->route('shipping.index')
            ->with('success', 'Thêm khu vực giao hàng thành công');
    }

    /**
     * Form chỉnh sửa
     */
    public function edit(ShippingArea $shipping)
    {
        $provinces = $this->getProvincesList();
        $districts = [];
        $wards = [];

        if ($shipping->district_id) {
            $districts = $this->getDistrictsList($shipping->province_id);
        }
        if ($shipping->ward_id) {
            $wards = $this->getWardsList($shipping->province_id, $shipping->district_id);
        }

        return view('admin.shipping.edit', compact('shipping', 'provinces', 'districts', 'wards'));
    }

    /**
     * Cập nhật khu vực
     */
    public function update(Request $request, ShippingArea $shipping)
    {
        $validated = $request->validate([
            'shipping_cost' => 'required|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Chuyển string "0" hoặc "1" thành boolean
        $validated['is_active'] = (bool) ($request->input('is_active', 0));

        $shipping->update($validated);

        return redirect()->route('shipping.index')
            ->with('success', 'Cập nhật khu vực thành công');
    }

    /**
     * Xóa khu vực
     */
    public function destroy(ShippingArea $shipping)
    {
        $shipping->delete();
        return redirect()->route('shipping.index')
            ->with('success', 'Xóa khu vực thành công');
    }

    /**
     * Helper: Lấy danh sách tỉnh từ API
     */
    private function getProvincesList()
    {
        try {
            $response = Http::timeout(10)
                ->connectTimeout(5)
                ->get('https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json');

            if (!$response->successful()) {
                throw new \Exception('API returned status: ' . $response->status());
            }

            return $response->json() ?? [];
        } catch (\Throwable $e) {
            Log::error('ShippingArea getProvincesList error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Helper: Lấy danh sách huyện theo tỉnh
     */
    private function getDistrictsList($provinceId)
    {
        try {
            $response = Http::timeout(10)
                ->connectTimeout(5)
                ->get('https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json');

            if (!$response->successful()) {
                throw new \Exception('API returned status: ' . $response->status());
            }

            $data = $response->json() ?? [];
            $province = collect($data)->firstWhere('Id', $provinceId);
            return $province ? ($province['Districts'] ?? []) : [];
        } catch (\Throwable $e) {
            Log::error('ShippingArea getDistrictsList error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Helper: Lấy danh sách phường/xã theo huyện
     */
    private function getWardsList($provinceId, $districtId)
    {
        try {
            $response = Http::timeout(10)
                ->connectTimeout(5)
                ->get('https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json');

            if (!$response->successful()) {
                throw new \Exception('API returned status: ' . $response->status());
            }

            $data = $response->json() ?? [];
            $province = collect($data)->firstWhere('Id', $provinceId);
            if ($province) {
                $district = collect($province['Districts'] ?? [])->firstWhere('Id', $districtId);
                return $district ? ($district['Wards'] ?? []) : [];
            }
            return [];
        } catch (\Throwable $e) {
            Log::error('ShippingArea getWardsList error: ' . $e->getMessage());
            return [];
        }
    }
}
