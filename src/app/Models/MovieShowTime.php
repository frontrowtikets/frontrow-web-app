<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MovieShowTime extends Model
{
    //
    use SoftDeletes;


    protected $fillable = [
        'movie_id',
        'theatre',
        'screening_date',
        'start_time',
        'end_time',
        'ticket_price',
        'currency',

    ];
}
