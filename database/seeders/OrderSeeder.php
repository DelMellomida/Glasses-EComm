<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $orders = [
            [
                'order_total' => 1499,
                'purchase_date' => '2025-05-29 00:00:00',
                'status' => 'successful',
            ],
            [
                'order_total' => 1499,
                'purchase_date' => '2025-05-29 00:00:00',
                'status' => 'pending',
            ],
            [
                'order_total' => 1499,
                'purchase_date' => '2025-05-29 00:00:00',
                'status' => 'failed',
            ],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
