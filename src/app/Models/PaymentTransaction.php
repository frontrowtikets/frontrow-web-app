<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTransaction extends Model
{
    //
    use SoftDeletes, HasUuids;

    protected $fillable = [
        'txn_ref',
        'mfscode',
        'txn_type',
        'txn_channel',
        'txn_status',
        'amount',
        'currency',
        'reason',
        'phone_number',
        'user_id',
        'txn_hash'
    ];
}