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
        'submitted_by',
        'parent_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($review) {
            $review->replies()->delete();
        });

        static::restoring(function ($review) {
            $review->replies()->restore();
        });

        // on creating a review we will set the submitted_by attribute as the first parts of logged in user's email
        static::creating(function ($review) {
            $review->submitted_by = explode('@', auth()->user()->email)[0];
        });
    }

    public function replies()
    {
        return $this->hasMany(MovieReview::class, 'parent_id');
    }
}