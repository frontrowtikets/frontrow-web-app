<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserWallet extends Model
{
    //
    use SoftDeletes;


    protected $fillable = [

        'user_id',
        'balance',
        'wallet_pin'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
