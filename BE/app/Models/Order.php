<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'id_goi',
        'order_code',
        'amount',
        'status',
        'customer_name',
        'customer_email',
        'sepay_transaction_id',
        'sepay_reference_number',
        'paid_at',
        'payment_meta',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'payment_meta' => 'array',
    ];
}