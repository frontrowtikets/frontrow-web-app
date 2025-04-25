<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
            margin: 0;
        }
        .container {
            background: #fff;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: left;
            padding-bottom: 20px;
        }
        .header img {
            height: 70px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .amount {
            font-size: 24px;
            font-weight: bold;
            color: #000;
            margin: 20px 0;
        }
        .details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .details th, .details td {
            padding: 8px 12px;
            text-align: left;
        }
        .details th {
            background: #f4f4f4;
            font-weight: bold;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('/large.png') }}" alt="Frontrow Logo">
            <p style="float: right; font-size: 12px; text-align: right;">
                <a href="https://www.frontrow.com">www.frontrowtikets.com</a> <br>
                info@frontrowtikets.com <br>
                sales@frontrowtikets.com
            </p>
        </div>

        <!-- Greeting -->
        <p class="title">Hello {{$clientName}},</p>
        <p>Thank you for making your payment to <strong>FRONTROW</strong>. Please find your ticket attached to this email.</p>

        <!-- Amount -->
        <p class="amount">UGX {{ number_format($amount) }}</p>

        <!-- Transaction Details -->
        <table class="details">
            <tr>
                <th>Merchant Ref</th>
                <td>{{$merchant_reference}}</td>
            </tr>
            <tr>
                <th>Code</th>
                <td>{{$confirmation_code}}</td>
            </tr>
            <tr>
                <th>Channel</th>
                <td>{{$payment_method}}</td>
            </tr>
            <tr>
                <th>Platform</th>
                <td>FRONTROW TIKETS</td>
            </tr>
            <tr>
                <th>Transaction Time</th>
                <td>{{$paymentDate}}</td>
            </tr>
        </table>

        <!-- Footer -->
        <p class="footer">
            Thank you for using frontrow.
        </p>
    </div>
</body>
</html>
