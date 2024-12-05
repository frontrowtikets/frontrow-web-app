<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MovieCast extends Model
{
    //
    use SoftDeletes;


    protected $fillable = [

        'movie_id',
        'name',
        'role',
        'profile_image_url',

    ];
}
