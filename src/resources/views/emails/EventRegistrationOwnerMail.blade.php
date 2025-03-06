
@extends('emails.layout')

@section('content')
    <h4>Hello {{ $userName }},</h4>

    <p>A new attendant has registered for your event. Please log in to the platform to review and activate their invitation.</p>


    <p>Best regards,<br>Frontrow</p>
@endsection

@section('footer')
    © {{ date('Y') }} FRONTROW. All rights reserved.</a>
@endsection
