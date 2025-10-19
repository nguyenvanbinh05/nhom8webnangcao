<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditationImage extends Model
{
    use HasFactory;

    protected $table = 'Additation_Image';
    protected $primaryKey = 'idAdditationImage';
    protected $fillable = ['AdditationLink', 'ProductId'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'ProductId', 'idProduct');
    }
}
