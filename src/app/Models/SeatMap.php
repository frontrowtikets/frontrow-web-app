<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeatMap extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [

        'movie_id',
        'movie_show_time_id',
        'room_name',
    ];
    protected $appends = ['showTime', 'showTimeSeats'];

    public function getshowTimeSeatsAttribute()
    {
        $showTimeSeats = MovieShowTimeSeat::where('seat_map_id', $this->id)->where('deleted_at', null)->get();
        return $showTimeSeats;
    }

    public function getshowTimeAttribute()
    {
        $showTime = MovieShowTime::where('id', $this->movie_show_time_id)->get();
        return $showTime;
    }
}
