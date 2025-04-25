<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeatMapConfigTable extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'theatre',
            'room',
    ];

    public function seatMap()
    {
        return $this->hasMany(SeatsConfig::class,'seat_map_config_tables_id');
    }
}
