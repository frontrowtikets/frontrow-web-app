<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
                @if (request()->getHost() === 'frontrow.cinemaug.com')
            <meta name="robots" content="noindex, nofollow">
        @endif
        @php
            $event = $page['props']['eventDetails'] ?? null;
            $movie = $page['props']['movieDetails'] ?? null;
        @endphp
        
        @if ($event)
        @php
            $start_date_and_time = $event['start_date'] . ' ' . $event['start_time'];
            $start_date = \Carbon\Carbon::parse($start_date_and_time)->format('jS M Y');
            $start_time = \Carbon\Carbon::parse($start_date_and_time)->format('H:i');
            $event_description = $event['title'] . ' | ' . $event['location_name'] . ' | ' . $start_date . ', ' . $start_time;
            $event_url = url('/home/event/' . \Illuminate\Support\Str::slug($event['title']) . '/' . $event['id']);
        @endphp
        {{-- Dynamic meta for event --}}
        <title inertia>{{ $event['title'] }}</title>
        <meta name="description" content="{{ $event_description }}">
        <meta name="keywords" content="{{ $event['title'] }}, event tickets, FrontRow Tikets">

        <meta property="og:title" content="{{ $event['title'] }}" />
        <meta property="og:description" content="{{ $event_description }}" />
        <meta property="og:image" content="{{ $event['thumbnail_url']}}" />
        <meta property="og:url" content="{{ $event_url }}" />
        <meta property="og:type" content="website"/>

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="{{ $event['title'] }}" />
        <meta name="twitter:description" content="{{ $event_description }}" />
        <meta name="twitter:image" content="{{ $event['thumbnail_url'] }}" />

    @elseif($movie)
        @php
            $release_date = \Carbon\Carbon::parse($movie['release_date'])->format('jS M Y');
            $movie_description = $movie['title'] . ' | ' . $movie['viewing_format'] . ' | ' . $release_date;
            $movie_url = url('/home/movie/' . \Illuminate\Support\Str::slug($movie['title']) . '/' . $movie['id']);
        @endphp
        {{-- Dynamic meta for event --}}
        <title inertia>{{ $movie['title'] }}</title>
        <meta name="description" content="{{ $movie_description }}">
        <meta name="keywords" content="{{ $movie['title'] }}, movie tickets, FrontRow Tikets">

        <meta property="og:title" content="{{ $movie['title'] }}" />
        <meta property="og:description" content="{{ $movie_description }}" />
        <meta property="og:image" content="{{ $movie['thumbnail_url']}}" />
        <meta property="og:url" content="{{ $movie_url }}" />
        <meta property="og:type" content="website"/>

        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="{{ $movie['title'] }}" />
        <meta name="twitter:description" content="{{ $movie_description }}" />
        <meta name="twitter:image" content="{{ $movie['thumbnail_url'] }}" />
    @else
        {{-- Default meta tags --}}
        <title inertia>{{ config('app.name', 'FrontRow Tikets') }}</title>
        <meta name="description" content="FrontRow Tikets - Your gateway to the best movies and events. Book tickets seamlessly and enjoy premium entertainment.">
        <meta name="keywords" content="FrontRow Tikets, movie tickets, event tickets, online booking, entertainment">
        <meta name="author" content="FrontRow Tikets">
        <meta name="robots" content="index, follow">

        <meta property="og:title" content="FrontRow Tikets - Your Front-Row Seat to Unforgettable Entertainment!">
        <meta property="og:description" content="Discover and book tickets for the latest movies and events with ease.">
        <meta property="og:image" content="{{ asset('large.png') }}">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="FrontRow Tikets - Book Your Tickets Now">
        <meta name="twitter:description" content="Discover and book tickets for the latest movies and events with ease.">
        <meta name="twitter:image" content="{{ asset('large.png') }}">
    @endif
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="/small.png">
        <link rel="apple-touch-icon" href="/small.png">
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="/small.png">
        <link rel="apple-touch-icon" href="/small.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQKw2vj3Wjow-0p69Wz8okjJ470gVOhNo&libraries=places,visualization"></script>
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
