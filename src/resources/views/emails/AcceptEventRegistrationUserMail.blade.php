@extends('emails.layout')

@section('content')
    <h4>Hello {{ $userName }},</h4>

    <p>Your invitation to the {{$event}} has been accepted.</p>
    <p>Login to the platform  to access your ticket.
    </p>

    <p>Best regards,<br>Frontrow</p>
@endsection

@section('footer')
    © {{ date('Y') }} FRONTROW. All rights reserved.</a>
@endsection
