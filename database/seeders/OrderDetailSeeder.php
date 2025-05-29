<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderDetail;

class OrderDetailSeeder extends Seeder
{
    public function run(): void
    {
        $orderDetails = [
            [
                'order_id' => 1,
                'user_id' => 2,
                'product_id' => 3,
                'quantity' => 1,
                'payment_type' => null,
            ],
            [
                'order_id' => 2,
                'user_id' => 2,
                'product_id' => 1,
                'quantity' => 1,
                'payment_type' => null,
            ],
            [
                'order_id' => 3,
                'user_id' => 2,
                'product_id' => 2,
                'quantity' => 1,
                'payment_type' => null,
            ],
        ];

        foreach ($orderDetails as $detail) {
            OrderDetail::create($detail);
        }
    }
}
