<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class EventTicket extends Model
{
    //
    use SoftDeletes;
    use HasUuids;


    protected $fillable = [

        'event_id',
        'category',
        'price',
        'ticket_thumbnail_url',
        'available_quantity'

    ];
}
