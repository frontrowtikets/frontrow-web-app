@extends('emails.layout')

@section('content')
    <h4>Hello {{ $userName }},</h4>

    <p>Your request has been submitted successfully.</p>
    <p>You will be notified once your request has been approved.
    </p>

    <p>Best regards,<br>Frontrow</p>
@endsection

@section('footer')
    © {{ date('Y') }} FRONTROW. All rights reserved.</a>
@endsection
