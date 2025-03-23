<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessSetting extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [

        'service_fee',
        'share_percentage',
        'wallet_credit',
        'shareholder_wallet_id',
    ];

    protected $casts = [
        'service_fee' => 'integer',
        'share_percentage' => 'integer',
        'wallet_credit' => 'integer',
        'shareholder_wallet_id' => 'integer',
    ];

    public function wallet()
    {
        return $this->belongsTo(UserWallet::class, 'shareholder_wallet_id');
    }
}
