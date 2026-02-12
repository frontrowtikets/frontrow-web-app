<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminCreateEventTicket extends FormRequest
{
    public function authorize(): bool
    {
        $permissions = [];
        foreach (Auth::user()->getAllPermissions() as $perm) {
            array_push($permissions, $perm->name);
        }
        return in_array('admin', $permissions);
    }

    public function rules(): array
    {
        return [
            'event_id' => 'required|exists:events,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'event_ticket_id' => 'required|exists:event_tickets,id',
            'quantity' => 'required|integer|min:1|max:50',
            'payment_reference' => 'required|string|max:255',
            'payment_method' => 'required|in:cash,mobile_money,bank_transfer,admin_manual',
            'amount' => 'required|numeric|min:0',
        ];
    }
}
