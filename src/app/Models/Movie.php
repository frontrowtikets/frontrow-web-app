<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Movie extends Model
{
    //
    use SoftDeletes;
    use HasUuids;


    protected $fillable = [

        'beneficiary_id',
        'title',
        'description',
        'release_date',
        'duration',
        'rating',
        'genre',
        'languange',
        'poster_url',
        'trailer_url',
        'is_active',
        'status',
        'movie_status',
        'currency',
        'maturity_rating',
    ];
}
