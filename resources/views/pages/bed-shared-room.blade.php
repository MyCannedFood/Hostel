<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bed & Shared Room - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

@include('components.navbar')

<main class="bed-room-page">
    <div class="bed-room-container">
        <x-booking-stepper :currentStep="3" />

        <x-booking-header 
            title="Choose Your Private Space" 
            subtitle="Kami menyediakan tempat tidur/kamar dengan fasilitas terbaik untuk kenyamanan Anda." 
        />

        <div style="margin-bottom: 40px;">
            <x-booking-summary-bar 
                checkIn="15/05/2026"
                checkOut="20/05/2026"
                guests="1 Male Guest"
            />
        </div>

        {{-- Room Detail Card --}}
        <div class="room-detail-card">
            <span class="room-type-tag">Room Type: Male Dorm</span>
            <img src="{{ asset('images/sharedroom/room_1.png') }}" alt="Serene Haven Room" class="room-detail-image" onerror="this.src='https://images.unsplash.com/photo-1555854877-bab0e564b8d5?auto=format&fit=crop&q=80&w=800'">
            <div class="room-detail-info">
                <h2 class="room-detail-title">Serene Haven</h2>
                <p class="room-detail-desc">A functional and minimalist space designed for maximum comfort and simplicity.</p>
                
                <div class="room-detail-features">
                    <div class="feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        <span>4 Room Capacity</span>
                    </div>
                    <div class="feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M2 20h20"/><path d="M5 20V4a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/><path d="M9 14h6"/><path d="M9 10h6"/></svg>
                        <span>Shared Bathroom</span>
                    </div>
                    <div class="feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M5 12.55a11 11 0 0 1 14.08 0"/><path d="M1.42 9a16 16 0 0 1 21.16 0"/><path d="M8.53 16.11a6 6 0 0 1 6.95 0"/><line x1="12" y1="20" x2="12.01" y2="20"/></svg>
                        <span>Wi-Fi</span>
                    </div>
                    <div class="feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                        <span>No Smoking Room</span>
                    </div>
                    <div class="feature-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        <span>AC</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Floor Plan Section --}}
        <div class="floor-plan-section">
            <img src="{{ asset('images/sharedroom/serene-haven-floorplan.png') }}" alt="Floor Plan" class="floor-plan-image" onerror="this.src='https://images.unsplash.com/photo-1593696140826-c58b021acf8b?auto=format&fit=crop&q=80&w=800'">
            {{-- Interactive points would go here, maybe handled by JS later --}}
        </div>

        {{-- Room Rules Section --}}
        <div class="room-rules-section">
            <div class="rules-banner-wrap">
                <img src="{{ asset('images/sharedroom/locker.png') }}" alt="Secure storage locker" class="rules-banner">
                <span class="rules-secure-badge">Secure Storage</span>
            </div>
            <div class="rules-content">
                <h3 class="rules-title">Room Rules</h3>
                <ul class="rules-list">
                    <li class="rule-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><line x1="23" y1="9" x2="17" y2="15"/><line x1="17" y1="9" x2="23" y2="15"/></svg>
                        <span>Quiet hours (22:00 - 07:00)</span>
                    </li>
                    <li class="rule-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                        <span>Strictly no smoking</span>
                    </li>
                    <li class="rule-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span>One person per bed</span>
                    </li>
                    <li class="rule-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 8h1a4 4 0 0 1 0 8h-1"/><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/><line x1="6" y1="1" x2="6" y2="4"/><line x1="10" y1="1" x2="10" y2="4"/><line x1="14" y1="1" x2="14" y2="4"/></svg>
                        <span>No food inside the beds</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Roommates Section --}}
        <div class="roommates-section">
            <h3 class="section-title">Kenali Calon Teman Sekamar</h3>
            
            <div class="roommate-card">
                <img src="{{ asset('images/sharedroom/julian.png') }}" alt="Julian Harrison" class="roommate-photo">
                <div class="roommate-info">
                    <div class="roommate-header-row">
                        <h4 class="roommate-name">Julian Harrison</h4>
                        <span class="roommate-bed-tag">Bed: 1 Top Bed</span>
                    </div>
                    <p class="roommate-role">29 years old &bull; Senior Architect</p>
                    <p class="roommate-desc">Focusing on sustainable urban spaces during my stay. Love to start the day with a jog and find the best local espresso. Looking forward to sharing the space!</p>
                    <div class="roommate-tags">
                        <span class="roommate-tag">Sustainability</span>
                        <span class="roommate-tag">Urban Design</span>
                        <span class="roommate-tag">Coffee Connoisseur</span>
                    </div>
                </div>
            </div>

            <div class="roommate-card">
                <img src="{{ asset('images/sharedroom/liam.png') }}" alt="Liam Smith" class="roommate-photo">
                <div class="roommate-info">
                    <div class="roommate-header-row">
                        <h4 class="roommate-name">Liam Smith</h4>
                        <span class="roommate-bed-tag">Bed: 2 Bottom Bed</span>
                    </div>
                    <p class="roommate-role">25 years old &bull; Full-stack Developer</p>
                    <p class="roommate-desc">Working remotely while exploring Southeast Asia. Usually quiet when working, but always up for a sunset drink or exploring the night markets.</p>
                    <div class="roommate-tags">
                        <span class="roommate-tag">Code & Coffee</span>
                        <span class="roommate-tag">Digital Nomad</span>
                        <span class="roommate-tag">Hiking</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Bottom Bar Component --}}
    <x-booking-bottom-bar 
        title="Serene Haven - 1 × Bottom Bed"
        label="EST.Total"
        value="IDR 625.000"
        backUrl="/room-selection"
        backText="Back To Calender"
        continueUrl="/guest-details"
        continueText="Continue To Details"
    />

</main>

<a href="https://wa.me/..." class="whatsapp-float">
    <svg width="32" height="32" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
</a>

</body>
</html>