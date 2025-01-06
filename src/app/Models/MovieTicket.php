<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class MovieTicket extends Model
{
    //
    use SoftDeletes;


    protected $fillable = [

        'movie_id',
        'user_email',
        'movie_show_time_id',
        'movie_show_time_seat_id',
        'purchase_date',
        'used_at',
        'ticket_status',
        'ticket_url',
        'ticket_id',
        'booking_id',
        'user_payment_detail_id',
        'payment_transaction_id'
    ];


    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
    public function userPaymentDetail()
    {
        return $this->belongsTo(UserPaymentDetail::class);
    }
    public function paymentTransaction()
    {
        return $this->belongsTo(PaymentTransaction::class);
    }
    public function theatre(){
        return $this->belongsTo(MovieShowTime::class, 'movie_show_time_id');
    }
    public function showTimeSeats(){
        return $this->belongsTo(MovieShowTimeSeat::class, 'movie_show_time_seat_id');
    }


}
