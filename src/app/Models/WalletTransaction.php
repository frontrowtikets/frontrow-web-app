<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class WalletTransaction extends Model
{
    use SoftDeletes;
    use HasUuids;

    protected $fillable = [
        'user_id',
        'amount',
        'transaction_type',
        'reference',
        'description'
    ];
}
