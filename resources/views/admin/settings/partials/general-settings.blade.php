{{-- resources/views/admin/settings/partials/general-settings.blade.php --}}

@php
    $sub = request('sub');
    $backUrl = route('admin.settings', ['section' => 'general']);
@endphp

{{-- ── Route ke sub-section ── --}}
@if(!$sub)
    <div class="section-header">
        <h2 class="section-title" style="font-size:26px;">General Setting</h2>
    </div>
    <p style="color:#7a857f; font-size:14px; margin:-8px 0 20px;">Manage general content structure</p>

    <div class="lp-section-list">
        @php
        $sections = [
            ['key' => 'hostel-information',  'label' => 'Hostel Information'],
            ['key' => 'operational-policies', 'label' => 'Operational Policies'],
            ['key' => 'payment-methods',     'label' => 'Payment Methods'],
            ['key' => 'footer',              'label' => 'Footer'],
            ['key' => 'profile',             'label' => 'Profile'],
        ];
        @endphp
        @foreach($sections as $s)
        <a href="{{ route('admin.settings', ['section' => 'general', 'sub' => $s['key']]) }}"
           class="lp-section-row">
            <span>{{ $s['label'] }}</span>
            <span class="lp-section-row-chevron">›</span>
        </a>
        @endforeach
    </div>

@elseif($sub === 'hostel-information')
    @include('admin.settings.partials.General.hostel-information')

@elseif($sub === 'operational-policies')
    @include('admin.settings.partials.General.operational-policies')

@elseif($sub === 'payment-methods')
    @include('admin.settings.partials.General.payment-methods')

@elseif($sub === 'footer')
    @include('admin.settings.partials.General.footer')

@elseif($sub === 'profile')
    @include('admin.settings.partials.General.profile')

@endif