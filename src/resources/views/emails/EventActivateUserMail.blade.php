@extends('emails.layout')

@section('content')
    <h4>Hello {{ $userName }},</h4>

    <p>Your event <b>{{$eventName}}</b> has been activated and made live on the platform.</p>
    <p>Thank you for using FrontRow.
    </p>

    <p>Best regards,<br>Frontrow</p>
@endsection

@section('footer')
    © {{ date('Y') }} FRONTROW. All rights reserved.</a>
@endsection
