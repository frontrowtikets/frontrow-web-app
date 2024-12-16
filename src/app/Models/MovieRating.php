<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieRating extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [

        'movie_id',
        'user_id',
        'rating',
    ];
}
