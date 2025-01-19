<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieReviewLike extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'movie_review_id',
        'user_id',
    ];
}