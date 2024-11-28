<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEventTicket extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'event_id',
        'quantity',
        'total_amount',
        'ticket_status',
        'booking_date'

    ];
}
