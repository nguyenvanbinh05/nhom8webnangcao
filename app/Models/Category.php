<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'Category';
    protected $primaryKey = 'idCategory'; 

    protected $fillable = [
        'NameCategory',
    ];

    // Quan hệ 1-n với Product
    public function products()
    {
        return $this->hasMany(Product::class, 'CategoryId', 'idCategory');
    }
}
