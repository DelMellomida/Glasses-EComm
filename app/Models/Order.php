<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';
    protected $fillable = [
        'user_id',
        'order_total',
        'purchase_date',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(\App\Models\OrderDetail::class, 'order_id', 'order_id');
    }
}
