<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $page }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial; background:#fff; color:#111;">

@include('components.navbar')

<main style="padding: 0; margin: 0;">
    @if ($page === 'Home' || $page === 'home')
        @include('home.home_section')
    @else
        <h1 style="margin: 0;">{{ $page }}</h1>
    @endif
</main>

</body>
</html>



