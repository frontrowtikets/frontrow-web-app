<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MovieCategory extends Model
{
    //
    use SoftDeletes;


    protected $fillable = [
        'name'
    ];

    // public function movies()
    // {
    //     return $this->belongsToMany(Movie::class, 'movies_categories_links', 'category_id', 'movie_id');
    // }
}
