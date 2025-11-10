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
        'cancel_reason',
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

    
    public function getStatusLabelAttribute()
    {
        $labels = [
            'Pending' => 'Chờ xác nhận',
            'Processing' => 'Đang xử lý',
            'Completed' => 'Hoàn thành',
            'Cancelled' => 'Đã hủy',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'Pending' => 'pending',    
            'Processing' => 'processing',    
            'Completed' => 'completed', 
            'Cancelled' => 'cancelled',  
        ];

        return $colors[$this->status] ?? 'pending';
    }
}
