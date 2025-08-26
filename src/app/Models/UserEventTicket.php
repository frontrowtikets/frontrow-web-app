<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEventTicket extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'event_id',
        'quantity',
        'total_amount',
        'ticket_status',
        'booking_date',
        'user_email',
        'ticket_id',
        'booking_id',
        'event_ticket_id',
        'user_payment_detail_id',
        'payment_transaction_id',
        'beneficiary_credited'
    ];

    protected $casts = [
        'beneficiary_credited' => 'boolean',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function userPaymentDetail()
    {
        return $this->belongsTo(UserPaymentDetail::class);
    }
    public function paymentTransaction()
    {
        return $this->belongsTo(PaymentTransaction::class);
    }
}
