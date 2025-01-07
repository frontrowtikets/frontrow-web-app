<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class Movie extends Model implements HasMedia
{

    use InteractsWithMedia;
    use SoftDeletes;


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
        'thumbnail_url',
        'is_active',
        'status',
        'movie_status',
        'currency',
        'maturity_rating',

    ];

    protected $appends = ['overallRating', 'hasSeatMap'];

    public function getoverallRatingAttribute()
    {
        $averageRating = MovieRating::where('movie_id', $this->id)->avg('rating');
        return round($averageRating);
    }
    public function gethasSeatMapAttribute()
    {
        $seatMap = SeatMap::where('movie_id', $this->id)->where('deleted_at', null)->first();

        if (is_null($seatMap)) {
            return false;
        } else {
            return true;
        }
    }
    public function beneficiary()
    {
        return $this->belongsTo(User::class, 'beneficiary_id', 'id');
    }

    public function showTimes()
    {
        return $this->hasMany(MovieShowTime::class);
    }
    public function moviecasts()
    {
        return $this->hasMany(MovieCast::class);
    }

    public function reviews()
    {
        return $this->hasMany(MovieReview::class);
    }

    public function tickets(){
        return $this->hasMany(MovieTicket::class);
    }

    public function seatmap() {
        return $this->hasMany(SeatMap::class);
    }

    public function genres()
    {
        return $this->belongsToMany(MovieCategory::class, 'movie_category_links', 'movie_id', 'category_id');
    }


}
