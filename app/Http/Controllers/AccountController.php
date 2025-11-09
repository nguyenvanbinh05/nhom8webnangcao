<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role'); // role filter

        $query = User::query();

        // Nếu có từ khóa search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Nếu có role filter
        if ($role && in_array($role, ['admin', 'staff', 'customer'])) {
            $query->where('role', $role);
        }

        // Lấy danh sách tất cả account
        $accounts = $query->orderBy('role')->get();

        return view('admin.accountViews.accountManagement', compact('accounts', 'search', 'role'));
    }
    public function overview(Request $request)
    {
        $user = $request->user();

        // Có thể lấy địa chỉ mặc định từ bảng orders gần nhất
        $lastOrder = Order::where('user_id', $user->id)->latest()->first();

        return view('customer.account.overview', [
            'user'      => $user,
            'lastOrder' => $lastOrder,
        ]);
    }
    public function passwordForm()
    {
        return view('customer.account.password');
    }
    public function passwordUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->letters()->numbers()->mixedCase()->symbols()
            ],
        ], [], [
            'current_password' => 'Mật khẩu hiện tại',
            'password'          => 'Mật khẩu mới',
        ]);

        $user = $request->user();
        $user->password = Hash::make($request->password);
        $user->save(); // sẽ tự set updated_at

        return back()->with('status', 'password-updated');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:15|unique:users,phone',
            'password' => 'required|min:8|confirmed',
            'role'     => 'required|in:admin,staff,customer',
            'status'   => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('form', 'create'); // đánh dấu form create bị lỗi
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => $request->status,
        ]);

        return redirect()->route('accounts.index')->with('success', 'Tạo tài khoản thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('accounts.index')->with('error', 'Tài khoản không tồn tại!');
        }

        return view('admin.accountViews.accountEdit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('accounts.index')->with('error', 'Tài khoản không tồn tại!');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15|unique:users,phone,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:admin,staff,customer',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('form', 'edit'); // đánh dấu form edit bị lỗi
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->status = $request->status;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('accounts.index')->with('success', 'Cập nhật tài khoản thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Kiểm tra xem có đơn hàng nào liên quan không
        $orderCount = Order::where('user_id', $user->id)->count();

        if ($orderCount > 0) {
            return redirect()->route('accounts.index')
                ->with('error', 'Không thể xóa tài khoản, vì còn đơn hàng liên quan.');
        }

        // Nếu không có đơn hàng, xóa tài khoản
        $user->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'Xóa tài khoản thành công.');
    }
    public function orders(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->latest('idOrder')   // hoặc ->latest()
            ->paginate(10);

        return view('customer.account.orders', compact('orders'));
    }
    public function orderShow(Order $order, Request $request)
    {
        // Chặn xem đơn của người khác
        if ($order->user_id !== $request->user()->id) {
            abort(404);
        }

        $order->load(['items.product:idProduct,NameProduct,MainImage']); // để view hiển thị tên sp, ảnh...

        return view('customer.account.order_show', compact('order'));
    }
}
