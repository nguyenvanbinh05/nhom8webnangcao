<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingArea extends Model
{
    protected $table = 'shipping_areas';

    protected $fillable = [
        'province_id',
        'province_name',
        'district_id',
        'district_name',
        'ward_id',
        'ward_name',
        'shipping_cost',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'shipping_cost' => 'integer',
    ];

    /**
     * Kiểm tra địa chỉ có được hỗ trợ giao hàng không
     * Tìm theo thứ tự: Ward -> District -> Province
     * Trả về phí ship, NULL nếu không hỗ trợ
     */
    public static function getShippingCost($provinceId, $districtId = null, $wardId = null)
    {
        // Nếu chọn đủ Ward
        if ($wardId) {
            $area = self::where('province_id', $provinceId)
                ->where('district_id', $districtId)
                ->where('ward_id', $wardId)
                ->where('is_active', true)
                ->first();
            if ($area) {
                return $area->shipping_cost; // Trả về phí (có thể là 0 = miễn phí)
            }
        }

        // Nếu chỉ chọn District
        if ($districtId) {
            $area = self::where('province_id', $provinceId)
                ->where('district_id', $districtId)
                ->whereNull('ward_id')
                ->where('is_active', true)
                ->first();
            if ($area) {
                return $area->shipping_cost;
            }
        }

        // Nếu chỉ chọn Province
        $area = self::where('province_id', $provinceId)
            ->whereNull('district_id')
            ->where('is_active', true)
            ->first();
        if ($area) {
            return $area->shipping_cost;
        }

        return null; // Không hỗ trợ
    }

    /**
     * Lấy danh sách tất cả tỉnh được hỗ trợ
     */
    public static function getSupportedProvinces()
    {
        return self::where('is_active', true)
            ->whereNull('district_id')
            ->distinct('province_id')
            ->pluck('province_name', 'province_id');
    }

    /**
     * Lấy danh sách huyện trong tỉnh được hỗ trợ
     */
    public static function getSupportedDistricts($provinceId)
    {
        return self::where('province_id', $provinceId)
            ->where('is_active', true)
            ->whereNotNull('district_id')
            ->whereNull('ward_id')
            ->distinct('district_id')
            ->pluck('district_name', 'district_id');
    }
}
