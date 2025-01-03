<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPaymentDetail extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [

        'user_id',
        'full_name',
        'user_email',
        'user_phone_number',
        'visa_card',
        'bank_name',
        'cvv',
        'card_expiry_date',
        'payment_type',
    ];
}
