<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieShowTimeSeat extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'movie_show_time_id',
        'seat_number',
        'row_name',
        'seat_status',
        'seat_map_id',
    ];
}
