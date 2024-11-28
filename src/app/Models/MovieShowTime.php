<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class MovieShowTime extends Model
{
    //
    use SoftDeletes;
    use HasUuids;


    protected $fillable = [
        'movie_id',
        'theatre',
        'screening_date',
        'start_time',
        'end_time',
        'ticket_price',

    ];
}
