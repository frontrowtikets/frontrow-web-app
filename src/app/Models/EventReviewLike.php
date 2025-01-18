<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventReviewLike extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'event_review_id',
        'user_id',
    ];
}