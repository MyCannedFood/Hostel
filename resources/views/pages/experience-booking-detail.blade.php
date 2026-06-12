<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title data-en="Experience Reservation - AlaSare" data-id="Reservasi Pengalaman - AlaSare">{{ __('experience.reservation_title') }} - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('components.navbar')

<main class="experience-booking-page">

    {{-- Stepper --}}
    <nav class="exp-stepper">
        <div class="exp-step exp-step--active">
            <span class="exp-step-number">1.</span>
            <span class="exp-step-label" data-en="Detail" data-id="Detail">{{ __('experience.step_detail') }}</span>
            <span class="exp-step-arrow">›</span>
        </div>
        <div class="exp-step exp-step--pending">
            <span class="exp-step-label" data-en="Payment Method" data-id="Metode Pembayaran">{{ __('experience.step_payment_method') }}</span>
            <span class="exp-step-arrow">›</span>
        </div>
        <div class="exp-step exp-step--pending">
            <span class="exp-step-label" data-en="Payment" data-id="Pembayaran">{{ __('experience.step_payment') }}</span>
            <span class="exp-step-arrow">›</span>
        </div>
        <div class="exp-step exp-step--pending">
            <span class="exp-step-label" data-en="Success" data-id="Sukses">{{ __('experience.step_success') }}</span>
        </div>
    </nav>

    {{-- Hero --}}
    <div class="exp-hero">
        @if($experience->cover_image)
            <img src="{{ asset($experience->cover_image) }}" alt="{{ $experience->name }}">
        @else
            <img src="https://images.unsplash.com/photo-1596431976070-13f59049a4f4?auto=format&fit=crop&q=80&w=800"
                 alt="{{ $experience->name }}">
        @endif
        @php
            $catEn = $experience->category;
            $catId = match($experience->category) {
                'Wellness' => 'Wellness',
                'Culture'  => 'Budaya',
                'Nature'   => 'Alam',
                default    => $experience->category,
            };
        @endphp
        <div class="badge" data-en="{{ $catEn }} Experience" data-id="{{ $catId }} Pengalaman">{{ strtoupper($experience->category) }} {{ strtoupper(__('experience.experience_label')) }}</div>
    </div>

    {{-- Header --}}
    <div class="exp-header">
        <span class="exp-header-tag">{{ strtoupper($experience->name) }}</span>
        <h1 data-en="Experience Reservation" data-id="Reservasi Pengalaman">{{ __('experience.reservation_title') }}</h1>
        <div class="exp-header-line"></div>
        <p>{{ $experience->short_description }}</p>
    </div>

    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="exp-errors" style="max-width:720px;margin:0 auto 16px;padding:12px 16px;background:#fef2f2;border:1px solid #fca5a5;border-radius:8px;color:#dc2626;font-size:13px;">
            <ul style="margin:0;padding-left:16px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form class="exp-form" action="{{ route('experience.booking-detail.store', $experience->id) }}" method="POST">
        @csrf

        <div class="exp-form-row">
            <div class="exp-form-group">
                <label class="exp-label" data-en="SELECT DATE" data-id="PILIH TANGGAL">{{ __('experience.select_date') }}</label>
                <input
                    type="date"
                    class="exp-input"
                    name="scheduled_date"
                    min="{{ date('Y-m-d') }}"
                    value="{{ old('scheduled_date', $old['scheduled_date'] ?? '') }}"
                    required
                >
            </div>
            <div class="exp-form-group">
                <label class="exp-label" data-en="SESSION TIME" data-id="WAKTU SESI">{{ __('experience.session_time') }}</label>
                <div class="session-buttons">
                    @php
                        $slots = $experience->time_slots && count($experience->time_slots)
                            ? $experience->time_slots
                            : ['07:00 AM', '10:00 AM'];
                        $selectedSlot = old('time_slot', $old['time_slot'] ?? $slots[0]);
                    @endphp
                    @foreach($slots as $slot)
                        <button
                            type="button"
                            class="session-btn {{ $selectedSlot === $slot ? 'active' : '' }}"
                            onclick="selectSession(this)"
                        >{{ $slot }}</button>
                    @endforeach
                    <input type="hidden" name="time_slot" id="sessionTimeInput" value="{{ $selectedSlot }}">
                </div>
            </div>
        </div>

        <div class="exp-form-row">
            <div class="exp-form-group">
                <label class="exp-label" data-en="NUMBER OF GUESTS" data-id="JUMLAH TAMU">{{ __('experience.number_of_guests') }}</label>
                <div class="guest-counter">
                    <button type="button" class="counter-btn" onclick="decreaseGuests()">−</button>
                    <span class="counter-value" id="guestCount">{{ old('guest_count', $old['guest_count'] ?? 1) }}</span>
                    <button type="button" class="counter-btn" onclick="increaseGuests()">+</button>
                    <input type="hidden" name="guest_count" id="guestInput" value="{{ old('guest_count', $old['guest_count'] ?? 1) }}">
                </div>
                {{-- Harga per orang & total dinamis --}}
                <p class="exp-price-hint" id="priceHint" style="margin-top:8px;font-size:12px;color:rgba(26,61,10,0.6);">
                    <span data-en="IDR {{ number_format($experience->price, 0, ',', '.') }} / person" data-id="IDR {{ number_format($experience->price, 0, ',', '.') }} / orang">
                        {{ __('experience.price_per_orang', ['price' => number_format($experience->price, 0, ',', '.')]) }}
                    </span>
                    &nbsp;→&nbsp;
                    <strong id="totalPrice">IDR {{ number_format($experience->price * (old('guest_count', $old['guest_count'] ?? 1)), 0, ',', '.') }}</strong>
                </p>
            </div>
            <div class="exp-form-group">
                <label class="exp-label" data-en="FULL NAME" data-id="NAMA LENGKAP">{{ __('experience.full_name') }}</label>
                <input
                    type="text"
                    class="exp-input"
                    placeholder="{{ __('experience.full_name') }}"
                    name="guest_name"
                    value="{{ old('guest_name', $old['guest_name'] ?? '') }}"
                    required
                >
            </div>
        </div>

        <div class="exp-form-row">
            <div class="exp-form-group">
                <label class="exp-label" data-en="WHATSAPP NUMBER" data-id="NOMOR WHATSAPP">{{ __('experience.whatsapp_number') }}</label>
                <input
                    type="tel"
                    class="exp-input"
                    placeholder="{{ __('experience.whatsapp_placeholder') }}"
                    name="guest_whatsapp"
                    value="{{ old('guest_whatsapp', $old['guest_whatsapp'] ?? '') }}"
                    inputmode="numeric"
                    pattern="[0-9+\-\s()]+"
                    maxlength="20"
                    required
                >
            </div>
            <div class="exp-form-group">
                <label class="exp-label" data-en="SPECIAL NOTES / ALLERGIES" data-id="CATATAN KHUSUS / ALERGI">{{ __('experience.special_notes') }}</label>
                <input
                    type="text"
                    class="exp-input"
                    placeholder="{{ __('experience.notes_placeholder') }}"
                    name="special_notes"
                    value="{{ old('special_notes', $old['special_notes'] ?? '') }}"
                >
            </div>
        </div>

        {{-- What's Included --}}
        @if($experience->inclusions && count($experience->inclusions) > 0)
        <div class="exp-form-group" style="margin-top: 16px;">
            <label class="exp-label" data-en="WHAT'S INCLUDED" data-id="YANG TERMASUK">{{ __('experience.whats_included') }}</label>
            <div class="includes-grid">
                @foreach($experience->inclusions as $inclusion)
                <div class="include-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ $inclusion }}
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Sanctuary Rules --}}
        <div class="exp-form-group" style="margin-top: 16px;">
            <label class="exp-label" data-en="SANCTUARY RULES" data-id="ATURAN SANCTUARY">{{ __('experience.sanctuary_rules') }}</label>
            <div class="rules-box">
                <ol>
                    <li data-en="Respect the silence of the forest." data-id="Hormati kesunyian hutan.">{{ __('experience.rule_1') }}</li>
                    <li data-en="No outside food or plastic allowed." data-id="Tidak diperbolehkan membawa makanan atau plastik dari luar.">{{ __('experience.rule_2') }}</li>
                    <li data-en="Participate in the digital detox." data-id="Ikuti digital detox.">{{ __('experience.rule_3') }}</li>
                    <li data-en="Respect the local flora and fauna." data-id="Hormati flora dan fauna setempat.">{{ __('experience.rule_4') }}</li>
                </ol>
            </div>
        </div>

        <div class="exp-checkbox-group" style="margin-top: 16px;">
            <input type="checkbox" id="agree" name="agree" value="1" {{ old('agree') ? 'checked' : '' }} required>
            <label for="agree">
                <span data-en="I have read and agree to " data-id="Saya telah membaca dan menyetujui "></span>
                <a href="#"><span data-en="Sanctuary Rules" data-id="Aturan Sanctuary">{{ __('experience.sanctuary_rules_link') }}</span></a>
                <span data-en=" and " data-id=" dan "></span>
                <a href="#"><span data-en="Terms & Conditions" data-id="Syarat & Ketentuan">{{ __('experience.terms_conditions') }}</span></a>
                <span data-en="." data-id="."></span>
            </label>
        </div>

        <div class="exp-footer">
            <p data-en="A brief digital detox begins with your intention." data-id="Digital detox singkat dimulai dari niat Anda.">{{ __('experience.digital_detox_note') }}</p>
            <button type="submit" class="btn-proceed" data-en="PROCEED TO PAYMENT" data-id="LANJUTKAN KE PEMBAYARAN">{{ __('experience.proceed_to_payment') }}</button>
            <div class="secure-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
                <span data-en="SECURE ECOLOGICAL TRANSACTION" data-id="TRANSAKSI EKOLOGIS AMAN">{{ __('experience.secure_eco_transaction') }}</span>
            </div>
        </div>
    </form>
</main>

<script>
    const pricePerPerson = {{ $experience->price }};

    function formatRupiah(amount) {
        return 'IDR ' + amount.toLocaleString('id-ID');
    }

    function updateTotal() {
        const count = parseInt(document.getElementById('guestInput').value) || 1;
        document.getElementById('totalPrice').textContent = formatRupiah(pricePerPerson * count);
    }

    function selectSession(btn) {
        document.querySelectorAll('.session-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('sessionTimeInput').value = btn.innerText.trim();
    }

    function increaseGuests() {
        let val = parseInt(document.getElementById('guestInput').value);
        val++;
        document.getElementById('guestInput').value = val;
        document.getElementById('guestCount').innerText = val;
        updateTotal();
    }

    function decreaseGuests() {
        let val = parseInt(document.getElementById('guestInput').value);
        if (val > 1) {
            val--;
            document.getElementById('guestInput').value = val;
            document.getElementById('guestCount').innerText = val;
            updateTotal();
        }
    }

    // Init total on load
    updateTotal();

    // WhatsApp — hanya izinkan angka, +, spasi, tanda kurung
    const waInput = document.querySelector('input[name="guest_whatsapp"]');
    if (waInput) {
        waInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9+\-\s()]/g, '');
        });
        waInput.addEventListener('keydown', function (e) {
            const allowed = [
                'Backspace','Delete','ArrowLeft','ArrowRight','ArrowUp','ArrowDown',
                'Tab','Home','End','+','-','(',' ',')'
            ];
            if (allowed.includes(e.key)) return;
            if (e.key >= '0' && e.key <= '9') return;
            e.preventDefault();
        });
    }
</script>

</body>
</html>
