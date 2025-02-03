@extends('emails.layout')

@section('content')
    <h4>Hello {{ $userName }},</h4>

    <p>Your request to become a beneficiary on frontrow has been accepted </p>
    <p>You can now start creating movies and events.
    </p>

    <p>Best regards,<br>Frontrow</p>
@endsection

@section('footer')
    © {{ date('Y') }} FRONTROW. All rights reserved.</a>
@endsection
