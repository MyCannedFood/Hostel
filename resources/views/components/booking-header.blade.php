@props(['title', 'subtitle', 'titleId' => '', 'subtitleId' => ''])

<header class="booking-header">
    <h1 data-en="{{ $title }}" data-id="{{ $titleId ?: $title }}">{{ $title }}</h1>
    <p  data-en="{{ $subtitle }}" data-id="{{ $subtitleId ?: $subtitle }}">{{ $subtitle }}</p>
</header>