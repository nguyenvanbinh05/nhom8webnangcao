<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $table = 'Product_Size';
    protected $primaryKey = 'idProductSize';
    protected $fillable = ['Size', 'Price', 'ProductId'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId', 'idProduct');
    }
}