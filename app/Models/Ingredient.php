<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'unit',
        'supplier_id',
        'import_date',
        'expiry_date',
    ];

    // Quan hệ với nhà cung cấp
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
