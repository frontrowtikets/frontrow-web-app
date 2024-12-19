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

    public function beneficiary()
    {
        return $this->belongsTo(User::class, 'beneficiary_id', 'id');
    }
    public function reviews()
    {
        return $this->hasMany(EventReview::class);
    }
    public function categories()
    {
        return $this->belongsToMany(EventCategory::class, 'event_category_links', 'event_id', 'category_id');
    }
    public function eventTickets(){
        return $this->hasMany(EventTicket::class);
    }

}
