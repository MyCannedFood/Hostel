{{-- resources/views/admin/settings/partials/general-settings/operational-policies.blade.php --}}

@vite(['resources/css/admin/settings/general-settings/operational-policies.css'])

<div class="op-page">

    {{-- Back link --}}
    <a href="{{ route('admin.settings.general') }}" class="op-back">
        <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round">
            <polyline points="10 12 6 8 10 4"/>
        </svg>
        Back to General Settings
    </a>

    {{-- Page header --}}
    <div class="op-header">
        <h1>Operational Policies</h1>
        <p>Manage check-in timings, tax configurations, and house rules.</p>
    </div>

    <div class="op-content">

        {{-- ── Check-in & Check-out Timings ── --}}
        <div class="op-card">
            <h3 class="op-card-title">
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="8" cy="8" r="7"/>
                    <polyline points="8 4 8 8 11 10"/>
                </svg>
                Check-in &amp; Check-out Timings
            </h3>

            {{-- Time selects --}}
            <div class="op-row-2">
                <div class="op-field" style="margin-bottom:0;">
                    <label class="op-label" for="checkin_time">Standard Check-in Time</label>
                    <div class="op-select-wrapper">
                        <select class="op-select" id="checkin_time" name="checkin_time">
                            @foreach (range(0, 23) as $h)
                                @php $val = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00'; @endphp
                                <option value="{{ $val }}"
                                    {{ ($settings['checkin_time'] ?? '14:00') === $val ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="op-field" style="margin-bottom:0;">
                    <label class="op-label" for="checkout_time">Standard Check-out Time</label>
                    <div class="op-select-wrapper">
                        <select class="op-select" id="checkout_time" name="checkout_time">
                            @foreach (range(0, 23) as $h)
                                @php $val = str_pad($h, 2, '0', STR_PAD_LEFT) . ':00'; @endphp
                                <option value="{{ $val }}"
                                    {{ ($settings['checkout_time'] ?? '12:00') === $val ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Late check-out & early check-in policy --}}
            <div class="op-field" style="margin-bottom:0;">
                <label class="op-label" for="late_policy">Late Check-out &amp; Early Check-in Policy</label>
                <textarea
                    class="op-textarea"
                    id="late_policy"
                    name="late_policy"
                    placeholder="Subject to availability…"
                >{{ old('late_policy', $settings['late_policy'] ?? 'Subject to availability…') }}</textarea>
            </div>
        </div>

        {{-- ── Prices Include Tax & Service ── --}}
        <div class="op-card">

            <div class="op-toggle-row">
                <div class="op-toggle-info">
                    <strong>Prices Include Tax &amp; Service</strong>
                    <span>If active, listed room prices already include the taxes below.</span>
                </div>
                <label class="op-toggle">
                    <input
                        type="checkbox"
                        id="tax_toggle"
                        name="tax_included"
                        value="1"
                        {{ ($settings['tax_included'] ?? true) ? 'checked' : '' }}
                    >
                    <span class="op-toggle-slider"></span>
                </label>
            </div>

            <div class="op-row-2" id="tax-fields-row" style="margin-bottom:0;">
                <div class="op-field" style="margin-bottom:0;">
                    <label class="op-label" for="government_tax">Government Tax (PPN)</label>
                    <div class="op-input-suffix">
                        <input
                            type="number"
                            id="government_tax"
                            name="government_tax"
                            min="0" max="100" step="0.01"
                            value="{{ old('government_tax', $settings['government_tax'] ?? 11) }}"
                        >
                        <span class="op-suffix">%</span>
                    </div>
                </div>

                <div class="op-field" style="margin-bottom:0;">
                    <label class="op-label" for="service_charge">Service Charge</label>
                    <div class="op-input-suffix">
                        <input
                            type="number"
                            id="service_charge"
                            name="service_charge"
                            min="0" max="100" step="0.01"
                            value="{{ old('service_charge', $settings['service_charge'] ?? 5) }}"
                        >
                        <span class="op-suffix">%</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── House Rules ── --}}
        <div class="op-card">
            <h3 class="op-card-title">
                <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 9 L8 2 L15 9 V15 H10 V11 H6 V15 H1 Z"/>
                </svg>
                House Rules
            </h3>

            <div class="op-field">
                <label class="op-label" for="house_rules">General Property Rules</label>
                <textarea class="op-textarea" id="house_rules" name="house_rules"
                          maxlength="1000" placeholder="List your house rules…"
                          data-counter="rules-counter">{{ old('house_rules', $settings['house_rules'] ?? "No smoking inside rooms\nQuiet hours after 22:00\nGuests must register at reception") }}</textarea>
                <div class="op-counter-row">
                    <span class="op-hint">One rule per line</span>
                    <span class="op-counter"><span id="rules-counter">0</span> / 1000</span>
                </div>
            </div>
        </div>

    </div>{{-- /.op-content --}}

    {{-- Sticky footer --}}
    <div class="op-footer">
        <button type="button" class="op-btn op-btn-cancel"
            onclick="window.location='{{ route('admin.settings.general') }}'">
            Cancel
        </button>
        <button type="button" class="op-btn op-btn-save" id="op-save-btn">
            Save Policies
        </button>
    </div>

</div>{{-- /.op-page --}}

@push('scripts')
    <script>
        window.OP_CONFIG = {
            updateUrl: "{{ route('admin.settings.operational-policies.update') }}",
        };
    </script>
    @vite(['resources/js/admin/settings/general-settings/operational-policies.js'])
@endpush