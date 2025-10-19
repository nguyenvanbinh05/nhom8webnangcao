<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'Product';
    protected $primaryKey = 'idProduct';
    protected $fillable = ['NameProduct', 'MainImage', 'Description', 'CategoryId', 'Status'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'CategoryId', 'idCategory');
    }

    public function sizes()
    {
        return $this->hasMany(ProductSize::class, 'ProductId', 'idProduct');
    }

    public function additationImages()
    {
        return $this->hasMany(AdditationImage::class, 'ProductId', 'idProduct');
    }
}
