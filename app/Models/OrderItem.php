<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table      = 'order_items';
    protected $primaryKey = 'idOrderItem';

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_image',
        'size',
        'unit_price',
        'quantity',
        'line_total'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'idOrder');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'idProduct');
    }
    public function getLineTotalAttribute($value)
    {
        if (!is_null($value)) {
            return (int) $value;
        }
        return (int) $this->unit_price * (int) $this->quantity;
    }
}
