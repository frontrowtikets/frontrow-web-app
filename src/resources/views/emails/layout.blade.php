<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Email from Frontrow')</title>
    <style>
        body {
            font-family: Poppins, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 0.6em;

        }

        .content {
            padding: 20px;
            font-size: 0.9em;

        }

        .logo {
            max-width: 100px;
            height: auto;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            background-color: #3490dc;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .footer {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 0.6em;
        }
        .supportLine{
            margin-bottom:10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="{{ url('/large.png') }}" alt="frontrow" height="45px" width="auto">

        <div>The Art of Making Memories</div>

    </div>

    <div class="content">
        @yield('content')
    </div>

    <div class="footer">
    <div class="supportLine">Support: sales@frontrowtikets.com</div>

        @yield('footer', '© ' . date('Y') . ' FRONTROW. All rights reserved.')
    </div>
</body>

</html>
