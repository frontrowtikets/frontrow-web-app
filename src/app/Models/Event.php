<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;



class Event extends Model implements HasMedia
{
    use InteractsWithMedia;
    use SoftDeletes;

    protected $fillable = [

        'beneficiary_id',
        'title',
        'description',
        'location_name',
        'gps_location',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'thumbnail_url',
        'banner_image_url',
        'currency',
        'access_type',
        'status',
    ];

    // protected $appends = ['files'];

    // public function getFilesAttribute()
    // {
    //     return $this->getMedia('event_files');
    // }

}
