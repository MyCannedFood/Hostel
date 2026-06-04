{{-- resources/views/admin/settings/partials/hostel-information.blade.php --}}

@vite(['resources/css/admin/settings/general-settings/hostel-information.css'])

<div class="hi-page">

    {{-- Back link --}}
    <a href="{{ route('admin.settings.general') }}" class="hi-back">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round">
            <polyline points="10 12 6 8 10 4"/>
        </svg>
        Back to General Settings
    </a>

    {{-- Page header --}}
    <div class="hi-header">
        <h1>Hostel Information</h1>
        <p>Manage core identity, localization, and search visibility.</p>
    </div>

    <div class="hi-content">

        {{-- ── Brand Identity ── --}}
        <div class="hi-card">
            <h3 class="hi-card-title">
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="3" width="14" height="10" rx="1.5"/>
                    <path d="M1 6h14"/>
                </svg>
                Brand Identity
            </h3>

            {{-- Hostel Name --}}
            <div class="hi-field">
                <label class="hi-label" for="hostel_name">Hostel Name</label>
                <input
                    class="hi-input"
                    id="hostel_name"
                    name="hostel_name"
                    type="text"
                    value="{{ old('hostel_name', $settings['hostel_name'] ?? 'AloSore Eco Hostel') }}"
                    placeholder="Enter hostel name"
                >
            </div>

            {{-- Logo + Favicon --}}
            <div class="hi-row-2">
                <div class="hi-field">
                    <span class="hi-label">Main Logo</span>
                    <label class="hi-upload-box" for="main_logo">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        <span class="hi-upload-label">+ Upload Logo (PNG/SVG)</span>
                        <input id="main_logo" name="main_logo" type="file" accept=".png,.svg" hidden>
                    </label>
                </div>

                <div class="hi-field">
                    <span class="hi-label">Favicon (Browser Icon)</span>
                    <label class="hi-upload-box" for="favicon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                            <polyline points="17 8 12 3 7 8"/>
                            <line x1="12" y1="3" x2="12" y2="15"/>
                        </svg>
                        <span class="hi-upload-label">+ Upload</span>
                        <input id="favicon" name="favicon" type="file" accept=".png,.ico,.svg" hidden>
                    </label>
                </div>
            </div>
        </div>

        {{-- ── Localization ── --}}
        <div class="hi-card">
            <h3 class="hi-card-title">
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="8" cy="8" r="7"/>
                    <path d="M1 8h14M8 1a11 11 0 0 1 0 14M8 1a11 11 0 0 0 0 14"/>
                </svg>
                Localization
            </h3>

            {{-- Languages + Default Language --}}
            <div class="hi-row-2" style="margin-bottom: 18px;">
                <div class="hi-field" style="margin-bottom: 0;">
                    <label class="hi-label">Supported Languages (Website Toggle)</label>
                    <div class="hi-tags-wrapper" id="lang-tags-wrapper">
                        <span class="hi-tag">
                            English (EN)
                            <button type="button" title="Remove">×</button>
                        </span>
                        <span class="hi-tag">
                            Indonesian (ID)
                            <button type="button" title="Remove">×</button>
                        </span>
                        <input class="hi-tags-input" id="lang-input" placeholder="Type to add more…">
                    </div>
                </div>

                <div class="hi-field" style="margin-bottom: 0;">
                    <label class="hi-label" for="default_language">Default Language (Fallback)</label>
                    <div class="hi-select-wrapper">
                        <select class="hi-select" id="default_language" name="default_language">
                            <option value="en" {{ ($settings['default_language'] ?? 'en') === 'en' ? 'selected' : '' }}>English (EN)</option>
                            <option value="id" {{ ($settings['default_language'] ?? '') === 'id' ? 'selected' : '' }}>Indonesian (ID)</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Currency + Timezone --}}
            <div class="hi-row-2">
                <div class="hi-field" style="margin-bottom: 0;">
                    <label class="hi-label" for="currency">Default Currency</label>
                    <div class="hi-select-wrapper">
                        <select class="hi-select" id="currency" name="currency">
                            <option value="IDR" {{ ($settings['currency'] ?? 'IDR') === 'IDR' ? 'selected' : '' }}>IDR – Indonesian Rupiah</option>
                            <option value="USD" {{ ($settings['currency'] ?? '') === 'USD' ? 'selected' : '' }}>USD – US Dollar</option>
                            <option value="EUR" {{ ($settings['currency'] ?? '') === 'EUR' ? 'selected' : '' }}>EUR – Euro</option>
                            <option value="SGD" {{ ($settings['currency'] ?? '') === 'SGD' ? 'selected' : '' }}>SGD – Singapore Dollar</option>
                            <option value="AUD" {{ ($settings['currency'] ?? '') === 'AUD' ? 'selected' : '' }}>AUD – Australian Dollar</option>
                        </select>
                    </div>
                </div>

                <div class="hi-field" style="margin-bottom: 0;">
                    <label class="hi-label" for="timezone">Timezone</label>
                    <div class="hi-select-wrapper">
                        <select class="hi-select" id="timezone" name="timezone">
                            <option value="Asia/Makassar" {{ ($settings['timezone'] ?? 'Asia/Makassar') === 'Asia/Makassar' ? 'selected' : '' }}>WITA (Bali)</option>
                            <option value="Asia/Jakarta"  {{ ($settings['timezone'] ?? '') === 'Asia/Jakarta'  ? 'selected' : '' }}>WIB (Jakarta)</option>
                            <option value="Asia/Jayapura" {{ ($settings['timezone'] ?? '') === 'Asia/Jayapura' ? 'selected' : '' }}>WIT (Jayapura)</option>
                            <option value="UTC"           {{ ($settings['timezone'] ?? '') === 'UTC'           ? 'selected' : '' }}>UTC</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Basic SEO & Metadata ── --}}
        <div class="hi-card">
            <h3 class="hi-card-title">
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="6.5" cy="6.5" r="5"/>
                    <line x1="10.5" y1="10.5" x2="15" y2="15"/>
                </svg>
                Basic SEO &amp; Metadata
            </h3>

            {{-- Global Site Title --}}
            <div class="hi-field">
                <label class="hi-label" for="site_title">Global Site Title</label>
                <input
                    class="hi-input"
                    id="site_title"
                    name="site_title"
                    type="text"
                    value="{{ old('site_title', $settings['site_title'] ?? 'AloSore Eco Hostel | Sanctuary in Nature') }}"
                    placeholder="Site title for browser tabs and search engines"
                >
            </div>

            {{-- Meta Description --}}
            <div class="hi-field">
                <label class="hi-label" for="meta_description">Meta Description (for Google &amp; Social Sharing)</label>
                <textarea
                    class="hi-textarea"
                    id="meta_description"
                    name="meta_description"
                    maxlength="160"
                    placeholder="A short summary of your hostel for search engines…"
                    data-counter="meta-counter"
                >{{ old('meta_description', $settings['meta_description'] ?? 'Experience ecological mindfulness…') }}</textarea>
                <div class="hi-counter-row">
                    <span class="hi-hint">Recommended length: 150–160 characters</span>
                    <span class="hi-counter"><span id="meta-counter">0</span> / 160</span>
                </div>
            </div>
        </div>

    </div>{{-- /.hi-content --}}

    {{-- Sticky footer --}}
    <div class="hi-footer">
        <button type="button" class="hi-btn hi-btn-cancel"
            onclick="window.location='{{ route('admin.settings.general') }}'">
            Cancel
        </button>
        <button type="button" class="hi-btn hi-btn-save" id="hi-save-btn">
            Save Changes
        </button>
    </div>

</div>{{-- /.hi-page --}}

@push('scripts')
    {{-- Pass server-side URLs to JS --}}
    <script>
        window.HI_CONFIG = {
            updateUrl: "{{ route('admin.settings.hostel-information.update') }}",
        };
    </script>
    @vite(['resources/js/admin/settings/general-settings/hostel-information.js'])
@endpush