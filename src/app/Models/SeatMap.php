<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeatMap extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [

        'movie_id',
        'movie_show_time_id',
        'room_name',
        'from',
        'to',
        'seats_per_row',
    ];
}
