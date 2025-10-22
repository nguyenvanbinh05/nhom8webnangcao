<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_items';
    protected $primaryKey = 'idCartItem';
    protected $fillable = ['cart_id', 'product_id', 'size', 'price', 'quantity'];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'idCart');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'idProduct');
    }
}
