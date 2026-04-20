<?php

namespace Database\Seeders;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = [
            [
                'id_goi' => 1,
                'order_code' => 'ORD-20260420-001',
                'amount' => 199000,
                'status' => 'pending',
                'customer_name' => 'Nguyen Van A',
                'customer_email' => 'nguyenvana@gmail.com',
                'sepay_transaction_id' => null,
                'sepay_reference_number' => null,
                'paid_at' => null,
                'payment_meta' => null,
            ],
            [
                'id_goi' => 2,
                'order_code' => 'ORD-20260420-002',
                'amount' => 599000,
                'status' => 'paid',
                'customer_name' => 'Tran Thi B',
                'customer_email' => 'tranthib@gmail.com',
                'sepay_transaction_id' => 'SEPAY-TXN-0002',
                'sepay_reference_number' => 'REF-0002',
                'paid_at' => Carbon::now()->subDays(2),
                'payment_meta' => [
                    'provider' => 'sepay',
                    'method' => 'bank_transfer',
                ],
            ],
            [
                'id_goi' => 4,
                'order_code' => 'ORD-20260420-003',
                'amount' => 399000,
                'status' => 'failed',
                'customer_name' => 'Le Van C',
                'customer_email' => 'levanc@gmail.com',
                'sepay_transaction_id' => 'SEPAY-TXN-0003',
                'sepay_reference_number' => 'REF-0003',
                'paid_at' => null,
                'payment_meta' => [
                    'provider' => 'sepay',
                    'reason' => 'timeout',
                ],
            ],
        ];

        foreach ($orders as $order) {
            Order::updateOrCreate(
                ['order_code' => $order['order_code']],
                $order
            );
        }
    }
}
