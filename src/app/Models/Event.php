<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Event extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [

        'beneficiary_id',
        'title',
        'description',
        'location_name',
        'gps_location',
        'status',
        'start_date',
        'end_date',
        'thumbnail_url',
        'currency',
        'access_type',
    ];
}
