{{-- Home - Our Philosophy --}}

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Jost:wght@300;400;500;600&display=swap');

    #home-philosophy-transition {
        width: 100vw;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        height: 130px;
        background: linear-gradient(
            to bottom,
            #2c3829 0%,
            #4a5445 25%,
            #b8bfb4 60%,
            #edeee8 85%,
            #f6f6f1 100%
        );
    }

    #home-philosophy {
        background: #F6F6F1;
        padding: 50px 0 100px;
        width: 100vw;
        margin-left: calc(50% - 50vw);
        margin-right: calc(50% - 50vw);
        margin-top: 0;
        box-sizing: border-box;
        overflow: hidden;
    }

    #home-philosophy .phil-inner {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 72px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: start;
        box-sizing: border-box;
    }

    /* ── LEFT ── */
    .phil-left {
        display: flex;
        flex-direction: column;
        padding-top: 32px;
    }

    .phil-eyebrow {
        font-family: 'Jost', sans-serif;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: #4b9960;
        margin: 0 0 16px;
    }

    .phil-heading {
        font-family: 'Cormorant Garamond', serif;
        font-weight: 400;
        font-size: clamp(32px, 2.8vw, 42px);
        line-height: 1.12;
        color: #1a3d0a;
        margin: 0 0 28px;
        letter-spacing: -0.01em;
    }

    .phil-body {
        font-family: 'Jost', sans-serif;
        font-weight: 300;
        font-size: 13.5px;
        line-height: 1.85;
        color: #444;
        margin: 0 0 14px;
    }
    .phil-body:last-of-type { margin-bottom: 44px; }

    .phil-features { display: flex; flex-direction: column; }

    .phil-feature-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 0;
        border-bottom: 1px solid rgba(26, 61, 10, 0.10);
    }
    .phil-feature-item:first-child { border-top: 1px solid rgba(26, 61, 10, 0.10); }

    .phil-feature-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #b8d9a0;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 1px;
    }
    .phil-feature-icon svg {
        width: 14px;
        height: 14px;
        fill: #1a3d0a;
    }

    .phil-feature-text h4 {
        font-family: 'Jost', sans-serif;
        font-size: 12.5px;
        font-weight: 500;
        color: #1a3d0a;
        margin: 0 0 2px;
    }
    .phil-feature-text p {
        font-family: 'Jost', sans-serif;
        font-size: 12.5px;
        font-weight: 300;
        color: #666;
        margin: 0;
        line-height: 1.55;
    }

    /* ── RIGHT ── */
    .phil-right {
        position: relative;
        margin-right: -72px;
    }

    .phil-img-wrap {
        width: 100%;
        overflow: hidden;
        position: relative;
        line-height: 0;
    }

    /* Lebih tinggi & lebih sempit — aspect ratio portrait */
    .phil-img-wrap img {
        width: 100%;
        height: 700px;
        object-fit: cover;
        object-position: center top;
        display: block;
    }

    /* ── Badge ── */
    .phil-badge {
        position: absolute;
        bottom: 16px;
        left: 16px;
        right: 16px;
        background: rgba(246, 246, 241, 0.92);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        padding: 14px 18px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    /* Icon badge: logo leaf.png saja, tanpa background/frame */
    .phil-badge-icon {
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .phil-badge-icon img {
        width: 26px;
        height: 26px;
        object-fit: contain;
        display: block;
    }

    .phil-badge-text {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .phil-badge-text .badge-label {
        font-family: 'Jost', sans-serif;
        font-size: 9px;
        font-weight: 600;
        letter-spacing: 0.20em;
        text-transform: uppercase;
        color: #4b9960;
        line-height: 1;
        display: block;
    }
    .phil-badge-text .badge-value {
        font-family: 'Jost', sans-serif;
        font-size: 15px;
        font-weight: 400;
        color: #1a3d0a;
        letter-spacing: 0.01em;
        line-height: 1;
        display: block;
    }

    /* ── Mobile ── */
    @media (max-width: 768px) {
        #home-philosophy-transition { height: 90px; }
        #home-philosophy { padding: 32px 0 64px; }

        #home-philosophy .phil-inner {
            grid-template-columns: 1fr;
            gap: 0;
            padding: 0;
        }

        .phil-left {
            padding: 36px 24px 0;
            order: 2;
        }

        .phil-right {
            order: 1;
            margin-right: 0;
        }

        .phil-img-wrap img { height: 340px; }
        .phil-badge { bottom: 10px; left: 10px; right: 10px; }
    }
</style>

<div id="home-philosophy-transition"></div>

<section id="home-philosophy">
    <div class="phil-inner">

        {{-- LEFT --}}
        <div class="phil-left">
            <p class="phil-eyebrow">Our Philosophy</p>
            <h2 class="phil-heading">Breathing with the Earth</h2>

            <p class="phil-body">At AlasAre, we believe true luxury is space. From our 500 sqm land,<br>only 100 sqm is used for buildings. The remaining 400 sqm is intentionally returned to nature as a private, breathing forest.</p>

            <p class="phil-body">This mindful 4:1 ratio ensures that our traditional Javanese structures<br>do not dominate the landscape, but rather nestle within it, allowing<br>the ancient rhythms of the jungle to remain undisturbed.</p>

            <div class="phil-features">
                <div class="phil-feature-item">
                    <div class="phil-feature-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 8C8 10 5.9 16.17 3.82 19.34c-.65 1.01.8 2 1.64 1.12C7 19 7.5 17 12 17c5 0 8-4 8-9 0 0-1 0-3 0z"/>
                        </svg>
                    </div>
                    <div class="phil-feature-text">
                        <h4>Minimal Footprint</h4>
                        <p>Elevated structures preserving the natural topography and soil integrity.</p>
                    </div>
                </div>
                <div class="phil-feature-item">
                    <div class="phil-feature-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17 8C8 10 5.9 16.17 3.82 19.34c-.65 1.01.8 2 1.64 1.12C7 19 7.5 17 12 17c5 0 8-4 8-9 0 0-1 0-3 0z"/>
                        </svg>
                    </div>
                    <div class="phil-feature-text">
                        <h4>Rewilding Project</h4>
                        <p>Over 200 native species planted to restore the local ecosystem.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT --}}
        <div class="phil-right">
            <div class="phil-img-wrap">
                <img src="{{ asset('images/philosophy.png') }}" alt="AlasAre forest view">

                <div class="phil-badge">
                    <div class="phil-badge-icon">
                        <img src="{{ asset('images/leaf.png') }}" alt="">
                    </div>
                    <div class="phil-badge-text">
                        <span class="badge-label">Conservation</span>
                        <span class="badge-value">80% Forest Cover</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

