<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Experience Reservation - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>

@include('components.navbar')

<main class="experience-booking-page">
    
    {{-- Stepper --}}
    <nav class="exp-stepper">
        <div class="exp-step active">
            <span>1. DETAIL</span>
        </div>
        <div class="exp-step-divider">></div>
        <div class="exp-step">
            <span>PAYMENT METHOD</span>
        </div>
        <div class="exp-step-divider">></div>
        <div class="exp-step">
            <span>PAYMENT</span>
        </div>
        <div class="exp-step-divider">></div>
        <div class="exp-step">
            <span>SUCCESS</span>
        </div>
    </nav>

    {{-- Hero --}}
    <div class="exp-hero">
        <img src="{{ asset('images/experience/Lush Experience Sanctuary.png') }}" alt="Nature Experience">
        <div class="badge">NATURE EXPERIENCE</div>
    </div>

    {{-- Header --}}
    <div class="exp-header">
        <span class="exp-header-tag">NURTURE THE EARTH</span>
        <h1>Experience Reservation</h1>
        <div class="exp-header-line"></div>
        <p>Join us in a soulful ritual of restoration. Rooted in Javanese wisdom, this experience invites you to reconnect with the soil and contribute to the living legacy of our sanctuary.</p>
    </div>

    {{-- Form --}}
    <form class="exp-form" action="/confirm-payment" method="GET">
        
        <div class="exp-form-row">
            <div class="exp-form-group">
                <label class="exp-label">SELECT DATE</label>
                <input type="text" class="exp-input" placeholder="mm/dd/yyyy" required>
            </div>
            <div class="exp-form-group">
                <label class="exp-label">SESSION TIME</label>
                <div class="session-buttons">
                    <button type="button" class="session-btn active" onclick="selectSession(this)">07:00 AM</button>
                    <button type="button" class="session-btn" onclick="selectSession(this)">10:00 AM</button>
                    <input type="hidden" name="session_time" id="sessionTimeInput" value="07:00 AM">
                </div>
            </div>
        </div>

        <div class="exp-form-row">
            <div class="exp-form-group">
                <label class="exp-label">NUMBER OF GUESTS</label>
                <div class="guest-counter">
                    <button type="button" class="counter-btn" onclick="decreaseGuests()">−</button>
                    <span class="counter-value" id="guestCount">2</span>
                    <button type="button" class="counter-btn" onclick="increaseGuests()">+</button>
                    <input type="hidden" name="guests" id="guestInput" value="2">
                </div>
            </div>
            <div class="exp-form-group">
                <label class="exp-label">FULL NAME</label>
                <input type="text" class="exp-input" placeholder="Your Name" name="fullname" required>
            </div>
        </div>

        <div class="exp-form-row">
            <div class="exp-form-group">
                <label class="exp-label">WHATSAPP NUMBER</label>
                <input type="text" class="exp-input" placeholder="+62 ..." name="whatsapp" required>
            </div>
            <div class="exp-form-group">
                <label class="exp-label">SPECIAL NOTES / ALLERGIES</label>
                <input type="text" class="exp-input" placeholder="Dietary restrictions or special requests." name="notes">
            </div>
        </div>

        <div class="exp-form-group" style="margin-top: 16px;">
            <label class="exp-label">WHAT'S INCLUDED</label>
            <div class="includes-grid">
                <div class="include-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 22C12 22 20 18 20 12C20 6 12 2 12 2C12 2 4 6 4 12C4 18 12 22 12 22Z"/><path d="M12 22V12"/></svg>
                    Sapling Included
                </div>
                <div class="include-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                    Tools & Gear
                </div>
                <div class="include-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Local Guide
                </div>
                <div class="include-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                    Refreshments
                </div>
            </div>
        </div>

        <div class="exp-form-group" style="margin-top: 16px;">
            <label class="exp-label">SANCTUARY RULES</label>
            <div class="rules-box">
                <ol>
                    <li>Respect the silence of the forest.</li>
                    <li>No outside food or plastic allowed.</li>
                    <li>Participate in the digital detox.</li>
                    <li>Respect the local flora and fauna.</li>
                </ol>
            </div>
        </div>

        <div class="exp-checkbox-group" style="margin-top: 16px;">
            <input type="checkbox" id="agree" required>
            <label for="agree">I have read and agree to the <a href="#">Sanctuary Rules</a> and <a href="#">Terms & Conditions</a>.</label>
        </div>

        <div class="exp-footer">
            <p>A brief digital detox begins with your intention.</p>
            <button type="submit" class="btn-proceed">PROCEED TO PAYMENT</button>
            <div class="secure-badge">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                SECURE ECOLOGICAL TRANSACTION
            </div>
        </div>
    </form>
</main>

<script>
    function selectSession(btn) {
        document.querySelectorAll('.session-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.getElementById('sessionTimeInput').value = btn.innerText;
    }

    function increaseGuests() {
        let val = parseInt(document.getElementById('guestInput').value);
        val++;
        document.getElementById('guestInput').value = val;
        document.getElementById('guestCount').innerText = val;
    }

    function decreaseGuests() {
        let val = parseInt(document.getElementById('guestInput').value);
        if (val > 1) {
            val--;
            document.getElementById('guestInput').value = val;
            document.getElementById('guestCount').innerText = val;
        }
    }
</script>

</body>
</html>
