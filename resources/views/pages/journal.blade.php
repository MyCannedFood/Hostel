<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Journal & Story - AlaSare</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; padding: 0; background: var(--color-bg-light); color: #111;">

@include('components.navbar')

<main class="journal-container">
    <div class="journal-header">
        <h1>Journal & Story</h1>
        <div class="journal-categories">
            <a href="#" class="category-link active">All</a>
            <a href="#" class="category-link">Travel Tips</a>
            <a href="#" class="category-link">Culture & Serenity</a>
            <a href="#" class="category-link">Events</a>
        </div>
    </div>

    <div class="journal-grid">
        <!-- Article 1 -->
        <article class="journal-card">
            <div class="journal-card-image">
                <img src="{{ asset('images/journal/The harmony islamic.png') }}" alt="The Harmony of Islamic Values and Javanese Wisdom">
            </div>
            <div class="journal-card-category">Culture & Serenity</div>
            <h3>The Harmony of Islamic Values and Javanese Wisdom</h3>
            <p class="journal-card-excerpt">Finding a moment to breathe through tafakkur (nature reflection), where the whispers of mountain breezes meet ...</p>
            <a href="/journal/detail" class="discover-more">
                Discover More
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 1L17 6L12 11M1 6H17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </article>

        <!-- Article 2 -->
        <article class="journal-card">
            <div class="journal-card-image">
                <img src="{{ asset('images/journal/Traditional Indonesian herbs.png') }}" alt="The Healing Power of Archipelago Rhizomes">
            </div>
            <div class="journal-card-category">Taste of AlaSare</div>
            <h3>The Healing Power of Archipelago Rhizomes</h3>
            <p class="journal-card-excerpt">Tracing the history of traditional herbal remedies passed down through generations, warming the body and soul...</p>
            <a href="/journal/detail" class="discover-more">
                Discover More
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 1L17 6L12 11M1 6H17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </article>

        <!-- Article 3 -->
        <article class="journal-card">
            <div class="journal-card-image">
                <img src="{{ asset('images/journal/Crafting with local community.png') }}" alt="Connecting Through Handcrafted Art">
            </div>
            <div class="journal-card-category">Travel Tips</div>
            <h3>Connecting Through Handcrafted Art</h3>
            <p class="journal-card-excerpt">A guide to deep interaction with the local community, where you are not merely a guest but a part of the family...</p>
            <a href="/journal/detail" class="discover-more">
                Discover More
                <svg width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 1L17 6L12 11M1 6H17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </article>
    </div>

    <!-- Subscription Section -->
    <section class="journal-subscription">
        <div class="subscription-icon">
            <img src="{{ asset('images/journal/Icon.png') }}" alt="AlaSare Leaf" style="width: 30px; height: auto;">
        </div>
        <h2>Get your AlaSare inspiration.</h2>
        <p>Subscribe to our latest updates on natural serenity, local wisdom, and exclusive offers delivered straight to your inbox.</p>
        <form class="subscription-form">
            <input type="email" placeholder="Your email address" required>
            <button type="submit">Subscribe</button>
        </form>
    </section>
</main>

@include('components.footer')

</body>
</html>
