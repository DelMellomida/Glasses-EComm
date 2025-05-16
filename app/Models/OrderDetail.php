<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    //
    use HasFactory;
    protected $primaryKey = 'purchase_id';
    protected $fillable = [
        'order_id',
        'user_id',
        'product_id',
        'quantity',
        'payment_type',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}
