<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


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
    // protected $appends = ['files'];

    // public function getFilesAttribute()
    // {
    //     return $this->getMedia('movie_files');
    // }
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain,)
            ->nonQueued();
    }
}
