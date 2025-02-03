@extends('emails.layout')

@section('content')
    <h4>Hello {{ $userName }},</h4>

    <p>A new event has been created on the FrontRow platform. Please log in to review and activate it.</p>
   
    <p>Best regards,<br>Frontrow</p>
@endsection

@section('footer')
    © {{ date('Y') }} FRONTROW. All rights reserved.</a>
@endsection
