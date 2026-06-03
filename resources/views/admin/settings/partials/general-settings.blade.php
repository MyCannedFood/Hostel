{{-- resources/views/admin/settings/partials/general-settings.blade.php --}}

@php
    $sub = request('sub');
    $backUrl = route('admin.settings', ['section' => 'general']);
@endphp

@if(!$sub)
    <div class="section-header">
        <h2 class="section-title" style="font-size:26px;">General Settings</h2>
    </div>
    <p style="color:#7a857f; font-size:14px; margin:-8px 0 20px;">Manage general hostel information and operational policies</p>

    <div class="lp-section-list">
        <a href="{{ route('admin.settings', ['section' => 'general', 'sub' => 'hostel-info']) }}" class="lp-section-row">
            <span>Hostel Information</span>
            <span class="lp-section-row-chevron">›</span>
        </a>
        <a href="{{ route('admin.settings', ['section' => 'general', 'sub' => 'operational-policies']) }}" class="lp-section-row">
            <span>Operational Policies</span>
            <span class="lp-section-row-chevron">›</span>
        </a>
    </div>

@elseif($sub === 'hostel-info')
    @include('admin.settings.partials.general-settings.hostel-information')

@elseif($sub === 'operational-policies')
    @include('admin.settings.partials.general-settings.operational-policies')
@endif