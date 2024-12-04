<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class MovieTicket extends Model
{
    //
    use SoftDeletes;


    protected $fillable = [

        'movie_id',
        'user_email',
        'movie_show_time_id',
        'movie_show_time_seat_id',
        'total_price',
        'purchase_date',
        'used_at',
        'ticket_status',
        'ticket_url',
        'ticket_id',
        'booking_id'

    ];
}
