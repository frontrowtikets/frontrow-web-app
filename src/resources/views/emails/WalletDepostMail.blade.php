@extends('emails.layout')

@section('content')
    <h4>Hello {{ $userName }},</h4>

    <p>You have successfully deposited <b>{{$currency}} {{$amount}}</b> to your wallet, you can now buy tickets directly from your wallet.</p>

    <p>Best regards,<br>Frontrow</p>
@endsection

@section('footer')
    © {{ date('Y') }} FRONTROW. All rights reserved.</a>
@endsection
