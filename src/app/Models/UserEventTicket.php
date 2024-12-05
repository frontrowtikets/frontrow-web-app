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
        'booking_date',
         'user_email',
        'ticket_id',
        'booking_id',
        'event_ticket_id',
    ];
}
