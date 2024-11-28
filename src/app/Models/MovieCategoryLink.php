<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class MovieCategoryLink extends Model
{
    //
    use SoftDeletes;
    use HasUuids;


    protected $fillable = [

        'movie_id',
        'category_id',

    ];
}
