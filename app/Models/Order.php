<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'id',
        'order_code',
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'shipping_address',
        'shipping_method',
        'note',
        'total_amount',
        'payment_method',
        'payment_status',
        'order_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
            $order->order_code = 'ORD-' . time();
        });
    }
}
