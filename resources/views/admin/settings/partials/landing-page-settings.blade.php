{{-- resources/views/admin/settings/partials/landing-page-settings.blade.php --}}

@php
    $sub = request('sub');
    $backUrl = route('admin.settings', ['section' => 'landing']);
@endphp

{{-- ── Route ke sub-section ── --}}
@if(!$sub)
    <div class="section-header">
        <h2 class="section-title" style="font-size:26px;">Landing Page Settings</h2>
    </div>
    <p style="color:#7a857f; font-size:14px; margin:-8px 0 20px;">Manage homepage sections and content structure</p>

    <div class="lp-section-list">
        @php
        $sections = [
            ['key' => 'hero',            'label' => 'Hero Section'],
            ['key' => 'philosophy',      'label' => 'Our Philosophy'],
            ['key' => 'flora',           'label' => 'The Flora Concept'],
            ['key' => 'map',             'label' => 'AlaSare Map'],
            ['key' => 'featured-rooms',  'label' => 'Featured Rooms'],
            ['key' => 'featured-articles','label' => 'Featured Articles'],
            ['key' => 'guest-stories',   'label' => 'Guest Stories'],
            ['key' => 'awards',          'label' => 'Awards & Recognition'],
            ['key' => 'media-partners',  'label' => 'Media & Partners'],
        ];
        @endphp
        @foreach($sections as $s)
        <a href="{{ route('admin.settings', ['section' => 'landing', 'sub' => $s['key']]) }}"
           class="lp-section-row">
            <span>{{ $s['label'] }}</span>
            <span class="lp-section-row-chevron">›</span>
        </a>
        @endforeach
    </div>

@elseif($sub === 'hero')
    @include('admin.settings.partials.LandingPage.LandingPagePartials.hero-section')

@elseif($sub === 'philosophy')
    @include('admin.settings.partials.LandingPage.LandingPagePartials.philosophy-section')

@elseif($sub === 'flora')
    @include('admin.settings.partials.LandingPage.LandingPagePartials.flora-concept')

@elseif($sub === 'map')
    @include('admin.settings.partials.LandingPage.LandingPagePartials.alasare-map')

@elseif($sub === 'rooms')
    @include('admin.settings.partials.LandingPage.LandingPagePartials.featured-rooms')

@elseif($sub === 'articles')
    @include('admin.settings.partials.LandingPage.LandingPagePartials.featured-articles')

@elseif($sub === 'guest-stories')
    @include('admin.settings.partials.LandingPage.LandingPagePartials.guest-stories')

@elseif($sub === 'featured-rooms')
    @include('admin.settings.partials.LandingPage.LandingPagePartials.featured-rooms')

@elseif($sub === 'featured-articles')
    @include('admin.settings.partials.LandingPage.LandingPagePartials.featured-articles')

@elseif($sub === 'awards')
    @include('admin.settings.partials.LandingPage.LandingPagePartials.awards-recognition')

@elseif($sub === 'media-partners')
    @include('admin.settings.partials.LandingPage.LandingPagePartials.media-partners')

@endif