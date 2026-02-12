<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingOrder extends Model
{
    protected $fillable = [
        'order_tracking_id',
        'order_type',
        'customer_name',
        'customer_email',
        'customer_phone',
        'order_payload',
        'amount',
        'status',
    ];

    protected $casts = [
        'order_payload' => 'array',
    ];
}
