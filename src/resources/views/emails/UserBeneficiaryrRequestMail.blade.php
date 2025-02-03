@extends('emails.layout')

@section('content')
    <h4>Hello {{ $userName }},</h4>

    <p>{{$originator}} has submitted a request to become a beneficiary.</p>
    <p>Please log onto the platform to approve their request.
    </p>

    <p>Best regards,<br>Frontrow</p>
@endsection

@section('footer')
    © {{ date('Y') }} FRONTROW. All rights reserved.</a>
@endsection
