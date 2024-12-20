@extends('emails.layout')

@section('content')
    <h4>Hello {{ $userName }},</h4>
    <p>Your account on <b>Frontrow</b>has been created. Use the password below to log in and access your tickets:</p>

    <p><b>Password:</b>{{ $radomPassword }}</p>
    <p>We strongly recommend resetting your password after your first login to ensure the security of your account.
    </p>

    <p>Best regards,<br>Frontrow</p>
@endsection

@section('footer')
    © {{ date('Y') }} FRONTROW. All rights reserved.</a>
@endsection
