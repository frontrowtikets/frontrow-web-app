<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventAttendee extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'event_id',
        'user_id',
        'reg_status',
        'email',
    ];
}
