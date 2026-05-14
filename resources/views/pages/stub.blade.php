<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $page }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('components.navbar')

<main>
    @if ($page === 'Home' || $page === 'home')
        @include('home.home_section')
    @else
        <h1 style="margin: 0;">{{ $page }}</h1>
    @endif
</main>

</body>
</html>



