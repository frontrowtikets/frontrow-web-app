<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SeatsConfig extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'seat_map_config_tables_id',
        'row',
        'seat_count',
    ];

    public function seatMap()
    {
        return $this->belongsTo(SeatMapConfigTable::class);
    }
}
