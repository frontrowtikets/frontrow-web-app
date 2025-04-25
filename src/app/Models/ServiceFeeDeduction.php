<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceFeeDeduction extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'payment_transaction_id',
        'amount',
        'actioned_by',
    ];
}
