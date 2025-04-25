@extends('emails.layout')

@section('content')
    <h4>Hello {{ $userName }},</h4>

    <p>Use the One-Time Password (OTP) below to complete your authentication:</p>

    <div style="font-size: 32px; font-weight: bold; letter-spacing: 4px; margin: 20px 0; text-align: center;">
        {{ $otp }}
    </div>

    <p>This OTP is valid for 5 minutes. Please do not share it with anyone.</p>

    <p>Best regards,<br>Frontrow</p>
@endsection

@section('footer')
    © {{ date('Y') }} FRONTROW. All rights reserved.
@endsection
