<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MovieCast extends Model implements HasMedia
{
    //
    use InteractsWithMedia;
    use SoftDeletes;


    protected $fillable = [

        'movie_id',
        'name',
        'role',
        'profile_image_url',
        'type'

    ];
}
