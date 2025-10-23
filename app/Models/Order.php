<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table      = 'orders';
    protected $primaryKey = 'idOrder';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'code',
        'full_name',
        'phone',
        'email',
        'address',
        'payment_method',
        'note',
        'subtotal',
        'shipping',
        'discount',
        'total',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'idOrder');
    }
}
