<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $page }}</title>
    @if (file_exists(public_path('css/app.css')))
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @else
        {{-- Fallback or direct link if using Vite --}}
        @vite(['resources/css/app.css'])
    @endif
</head>
<body class="antialiased">

@include('components.navbar')

<main>
    @if ($page === 'Home' || $page === 'home')
        @include('home.home_section')
    @else
        <h1 style="margin: 0;">{{ $page }}</h1>
    @endif
</main>

@include('components.footer')

</body>
</html>



