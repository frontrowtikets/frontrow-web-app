
@extends('emails.layout')

@section('content')
    <h4>Hello {{ $userName }},</h4>

    <p>You have successfuly registered for the {{$eventName}} event, We will notify you once your invitation has been approved.</p>


    <p>Best regards,<br>Frontrow</p>
@endsection

@section('footer')
    © {{ date('Y') }} FRONTROW. All rights reserved.</a>
@endsection
