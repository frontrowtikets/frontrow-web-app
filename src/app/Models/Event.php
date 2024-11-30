<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Event extends Model
{
    //
    use SoftDeletes;
    use HasUuids;

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
    ];
}
