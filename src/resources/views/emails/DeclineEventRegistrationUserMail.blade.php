@extends('emails.layout')

@section('content')
    <h4>Hello {{ $userName }},</h4>

    <p>Your invitation to the {{$event}} has been declined.</p>
    <p>Thank you for using FrontRow.
    </p>

    <p>Best regards,<br>Frontrow</p>
@endsection

@section('footer')
    © {{ date('Y') }} FRONTROW. All rights reserved.</a>
@endsection
