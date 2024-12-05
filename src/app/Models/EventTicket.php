<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class EventTicket extends Model
{
    //
    use SoftDeletes;


    protected $fillable = [

        'event_id',
        'category',
        'price',
        'ticket_thumbnail_url',
        'available_quantity'

    ];
}
