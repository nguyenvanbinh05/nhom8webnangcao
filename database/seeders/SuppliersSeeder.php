<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SuppliersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Công ty TNHH Cà phê Trung Nguyên',
                'phone' => '0905123456',
                'email' => 'trungnguyen@gmail.com',
                'address' => 'Buôn Ma Thuột, Đắk Lắk',
                'note' => 'Nhà cung cấp cà phê rang xay và bột nguyên chất',
            ],
            [
                'name' => 'Công ty Cổ phần Cà phê Highlands',
                'phone' => '0938456789',
                'email' => 'contact@highlands.vn',
                'address' => 'Quận 1, TP. Hồ Chí Minh',
                'note' => 'Chuyên cung cấp cà phê hạt và dụng cụ pha chế',
            ],
            [
                'name' => 'Công ty TNHH Vinacafé Biên Hòa',
                'phone' => '0912233445',
                'email' => 'info@vinacafe.com.vn',
                'address' => 'Biên Hòa, Đồng Nai',
                'note' => 'Nhà cung cấp cà phê hòa tan, cà phê bột và nguyên liệu pha chế',
            ],
            [
                'name' => 'Công ty TNHH Phúc Long',
                'phone' => '0977556677',
                'email' => 'support@phuclong.vn',
                'address' => 'TP. Hồ Chí Minh',
                'note' => 'Chuyên cung cấp trà, cà phê, và thiết bị pha chế',
            ],
            [
                'name' => 'Công ty TNHH An Nam Coffee',
                'phone' => '0988123456',
                'email' => 'annamcoffee@gmail.com',
                'address' => 'Đà Nẵng',
                'note' => 'Nhà cung cấp cà phê hạt Arabica và Robusta chất lượng cao',
            ],
            [
                'name' => 'Công ty TNHH Cà phê Sơn Tùng',
                'phone' => '0918123988',
                'email' => 'sontungcoffee@gmail.com',
                'address' => 'Lâm Đồng',
                'note' => 'Cung cấp cà phê hạt nhân, cà phê chế biến ướt',
            ],
            [
                'name' => 'Công ty Cổ phần The Coffee House',
                'phone' => '0909988776',
                'email' => 'info@thecoffeehouse.vn',
                'address' => 'TP. Hồ Chí Minh',
                'note' => 'Chuỗi cung ứng cà phê và nguyên liệu pha chế nội địa',
            ],
            [
                'name' => 'Công ty TNHH Olam Việt Nam',
                'phone' => '0915667788',
                'email' => 'olamvn@olam.com',
                'address' => 'Gia Lai',
                'note' => 'Nhà cung cấp cà phê xuất khẩu lớn nhất Việt Nam',
            ],
            [
                'name' => 'Công ty TNHH Hương Việt',
                'phone' => '0977554433',
                'email' => 'huongvietcoffee@gmail.com',
                'address' => 'Hà Nội',
                'note' => 'Phân phối cà phê bột, hạt, và máy pha cà phê',
            ],
            [
                'name' => 'Công ty TNHH Cà phê L’amant',
                'phone' => '0966778899',
                'email' => 'contact@lamantcoffee.com',
                'address' => 'Cần Thơ',
                'note' => 'Cà phê hữu cơ đạt chuẩn xuất khẩu châu Âu',
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

    }
}
