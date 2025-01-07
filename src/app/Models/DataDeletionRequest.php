<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataDeletionRequest extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'reason',
        'status',
        'completed_at',
        'data_to_delete',
    ];
}