<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieReview extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'movie_id',
        'user_id',
        'review',
        'submitted_by'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
