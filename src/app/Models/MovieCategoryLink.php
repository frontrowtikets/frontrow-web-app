<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MovieCategoryLink extends Model
{
    //
    use SoftDeletes;


    protected $fillable = [

        'movie_id',
        'category_id',

    ];
}
