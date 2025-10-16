<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredient;
use App\Models\Supplier;

class IngredientSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy một số nhà cung cấp có sẵn
        $suppliers = Supplier::all();

        // Tạo dữ liệu mẫu
        Ingredient::create([
            'name' => 'Trà đen',
            'quantity' => 10,
            'unit' => 'kg',
            'supplier_id' => $suppliers->random()->id ?? null,
            'import_date' => '2025-01-01',
            'expiry_date' => '2025-12-30',
        ]);

        Ingredient::create([
            'name' => 'Đường',
            'quantity' => 20,
            'unit' => 'kg',
            'supplier_id' => $suppliers->random()->id ?? null,
            'import_date' => '2025-02-01',
            'expiry_date' => '2026-02-01',
        ]);

        Ingredient::create([
            'name' => 'Sữa tươi',
            'quantity' => 50,
            'unit' => 'lít',
            'supplier_id' => $suppliers->random()->id ?? null,
            'import_date' => '2025-03-01',
            'expiry_date' => '2025-03-30',
        ]);

        Ingredient::create([
            'name' => 'Trà xanh',
            'quantity' => 15,
            'unit' => 'kg',
            'supplier_id' => $suppliers->random()->id ?? null,
            'import_date' => '2025-04-01',
            'expiry_date' => '2025-12-31',
        ]);
    }
}
