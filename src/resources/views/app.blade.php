<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="FrontRow Tikets - Your gateway to the best movies and events. Book tickets seamlessly and enjoy premium entertainment.">
        <meta name="keywords" content="FrontRow Tikets, movie tickets, event tickets, online booking, entertainment">
        <meta name="author" content="FrontRow Tikets">
        <meta name="robots" content="index, follow">
        <meta property="og:title" content="FrontRow Tikets - Book Your Tickets Now">
        <meta property="og:description" content="Discover and book tickets for the latest movies and events with ease.">
        <meta property="og:image" content="/path-to-social-image.jpg">
        <meta property="og:url" content="https://frontrowtikets.com">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="FrontRow Tikets - Book Your Tickets Now">
        <meta name="twitter:description" content="Discover and book tickets for the latest movies and events with ease.">
        <meta name="twitter:image" content="/path-to-social-image.jpg">

        <title inertia>{{ config('app.name', 'FrontRow Tikets') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="/small.png">
        <link rel="apple-touch-icon" href="/small.png">
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>