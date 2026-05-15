<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>The Harmony of Islamic Values and Javanese Wisdom - AlaSare Journal</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; padding: 0; background: var(--color-bg-light); color: #111;">

@include('components.navbar')

<article>
    <div class="journal-detail-hero">
        <img src="{{ asset('images/journal/The harmony islamic.png') }}" alt="The Harmony of Islamic Values and Javanese Wisdom">
    </div>

    <div class="journal-detail-content">
        <div class="journal-meta">BY ADMIN • 14 MEI 2026</div>
        <h1>Embracing Serenity: The Harmony of Islamic Values and Javanese Wisdom amidst Nature’s Lush Embrace</h1>
        
        <div class="journal-body">
            <p>On the mist-covered hillsides of dawn, AlaSare stands not merely as a place of rest, but as a visual narrative of balance. Here, the "Tropical Zen" philosophy is translated through the humble touch of Javanese vernacular architecture, blending intimately with the principles of spiritual tranquility.</p>
            
            <p>The experience at AlaSare begins even before your feet touch the warm teak floors. It starts as your senses catch the scent of damp earth and your ears hear the honest symphony of nature. Every corner is designed to facilitate tafakkur—a profound reflection on God’s creation through the beauty of tropical flora, allowed to grow with the utmost respect.</p>
            
            <blockquote class="journal-blockquote">
                "True serenity is found not in the absence of sound, but in the harmony between the human heartbeat and the rhythm of the universe."
            </blockquote>
            
            <p>The Islamic values of earthly stewardship (Khalifah fil Ardh) form the foundation of every service we provide. From our organic waste management systems to the use of local materials with a minimal carbon footprint, AlaSare strives to be an ethical oasis. We believe that true luxury lies in the ability to silence digital notifications and reconnect with one’s own soul.</p>
            
            <h2>A Modern Javanese Touch</h2>
            
            <p>Though embracing a modern concept, the Javanese soul remains deeply felt in the smallest details. From the minimalist carvings on room partitions to the herbal tea brewed from our own garden's handpicked spices, we are reminded of the concept of "Sangkan Paraning Dumadi"—understanding the origin and destination of life's journey in a tranquil atmosphere.</p>
            
            <div class="journal-gallery">
                <div class="gallery-item">
                    <img src="{{ asset('images/journal/Tradisional Javanese carving detail.png') }}" alt="Javanese Details">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('images/journal/Herbal Javanese jamu.png') }}" alt="Herbal Tea">
                </div>
            </div>
            
            <p>Ultimately, AlaSare is an invitation. An invitation to slow down, breathe deeper, and embrace the serenity that has long been hidden behind the hustle and bustle of the modern world. Come as a guest, return as a renewed soul.</p>
        </div>
    </div>
</article>

@include('components.footer')

</body>
</html>
