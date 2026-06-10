<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $article->title }} - AlaSare Journal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; padding: 0; background: var(--color-bg-light); color: #111;">

@include('components.navbar')

<article>
    <div class="journal-detail-hero">
        @if($article->thumbnail)
            <img src="{{ asset($article->thumbnail) }}" alt="{{ $article->title }}">
        @else
            <img src="{{ asset('images/journal/The harmony islamic.png') }}" alt="{{ $article->title }}">
        @endif
    </div>

    <div class="journal-detail-content">
        <div class="journal-meta">
            BY {{ strtoupper($article->admin?->name ?? 'ADMIN') }} 
            • {{ strtoupper($article->publish_at ? $article->publish_at->format('d M Y') : $article->created_at->format('d M Y')) }}
            • {{ $article->views_count }} {{ Str::plural('VIEW', $article->views_count) }}
            @if($article->source)
                • SOURCE: <a href="{{ Str::startsWith($article->source, ['http://', 'https://']) ? $article->source : '#' }}" target="_blank" style="color: inherit; text-decoration: underline;">{{ $article->source }}</a>
            @endif
        </div>
        <h1>{{ $article->title }}</h1>
        
        <div class="journal-body">
            {!! $article->content !!}
        </div>
    </div>
</article>

@include('components.footer')

<x-whatsapp_floating />
</body>
</html>
