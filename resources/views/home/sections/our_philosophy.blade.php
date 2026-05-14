{{-- Home - Our Philosophy --}}

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500&family=Jost:wght@300;400;500;600&display=swap');

    #home-philosophy-transition{
        width:100vw;
        margin-left:calc(50% - 50vw);
        margin-right:calc(50% - 50vw);
        height:130px;
        background:linear-gradient(
            to bottom,
            #2c3829 0%,
            #4b5546 24%,
            #b8bfb4 58%,
            #ecece6 84%,
            #f6f6f1 100%
        );
    }

    #home-philosophy{
        width:100vw;
        margin-left:calc(50% - 50vw);
        margin-right:calc(50% - 50vw);
        background:#f6f6f1;
        padding:58px 0 100px;
        overflow:hidden;
        box-sizing:border-box;
    }

    #home-philosophy .phil-inner{
        max-width:1180px;
        margin:0 auto;
        padding:0 58px;
        display:grid;
        grid-template-columns: 0.95fr 1.05fr;
        gap:78px;
        align-items:start;
        box-sizing:border-box;
    }

    /* ───────── LEFT ───────── */
    .phil-left{
        padding-top:68px;
    }

    .phil-eyebrow{
        font-family:'Jost',sans-serif;
        font-size:11px;
        font-weight:600;
        letter-spacing:0.22em;
        text-transform:uppercase;
        color:#7e9a75;
        margin:0 0 18px;
    }

    .phil-heading{
        font-family:'Cormorant Garamond',serif;
        font-size:56px;
        line-height:1.02;
        font-weight:400;
        color:#213c17;
        margin:0 0 30px;
        letter-spacing:-0.02em;
    }

    .phil-body{
        font-family:'Jost',sans-serif;
        font-size:15px;
        line-height:2;
        font-weight:300;
        color:#5d645d;
        margin:0 0 20px;
        max-width:470px;
    }

    .phil-body:last-of-type{
        margin-bottom:42px;
    }

    .phil-features{
        max-width:500px;
    }

    .phil-feature-item{
        display:flex;
        align-items:flex-start;
        gap:14px;
        padding:18px 0;
        border-bottom:1px solid rgba(33,60,23,0.10);
    }

    .phil-feature-item:first-child{
        border-top:1px solid rgba(33,60,23,0.10);
    }

    /* icon PNG */
    .phil-feature-icon{
        width:30px;
        height:30px;
        flex-shrink:0;
        margin-top:2px;
        display:flex;
        align-items:center;
        justify-content:center;
        background:#edf1e6;
        border-radius:50%;
    }

    .phil-feature-icon img{
        width:15px;
        height:15px;
        object-fit:contain;
        display:block;
    }

    .phil-feature-text h4{
        font-family:'Cormorant Garamond',serif;
        font-size:24px;
        font-weight:400;
        color:#213c17;
        margin:0 0 4px;
        line-height:1;
    }

    .phil-feature-text p{
        font-family:'Jost',sans-serif;
        font-size:14px;
        line-height:1.7;
        font-weight:300;
        color:#737973;
        margin:0;
        max-width:420px;
    }

    /* ───────── RIGHT ───────── */
    .phil-right{
        position:relative;
    }

    .phil-img-wrap{
        position:relative;
        overflow:hidden;
        width:100%;
        line-height:0;
    }

    .phil-img-wrap img{
        width:100%;
        height:760px;
        object-fit:cover;
        object-position:center;
        display:block;
    }

    /* Badge */
    .phil-badge{
        position:absolute;
        left:18px;
        right:18px;
        bottom:18px;
        background:rgba(248,248,244,0.94);
        backdrop-filter:blur(10px);
        -webkit-backdrop-filter:blur(10px);
        padding:16px 20px;
        display:flex;
        align-items:center;
        gap:14px;
    }

    .phil-badge-icon{
        width:34px;
        height:34px;
        display:flex;
        align-items:center;
        justify-content:center;
        flex-shrink:0;
    }

    .phil-badge-icon img{
        width:28px;
        height:28px;
        object-fit:contain;
        display:block;
    }

    .phil-badge-text{
        display:flex;
        flex-direction:column;
        gap:5px;
    }

    .phil-badge-text .badge-label{
        font-family:'Jost',sans-serif;
        font-size:10px;
        letter-spacing:0.22em;
        text-transform:uppercase;
        color:#7e9a75;
        line-height:1;
    }

    .phil-badge-text .badge-value{
        font-family:'Cormorant Garamond',serif;
        font-size:24px;
        font-weight:400;
        color:#213c17;
        line-height:1;
    }

    /* ───────── MOBILE ───────── */
    @media(max-width:768px){

        #home-philosophy-transition{
            height:90px;
        }

        #home-philosophy{
            padding:34px 0 70px;
        }

        #home-philosophy .phil-inner{
            grid-template-columns:1fr;
            gap:0;
            padding:0;
        }

        .phil-right{
            order:1;
        }

        .phil-left{
            order:2;
            padding:40px 24px 0;
        }

        .phil-heading{
            font-size:42px;
        }

        .phil-body{
            max-width:100%;
            font-size:14px;
            line-height:1.9;
        }

        .phil-feature-text h4{
            font-size:22px;
        }

        .phil-img-wrap img{
            height:420px;
        }

        .phil-badge{
            left:10px;
            right:10px;
            bottom:10px;
            padding:14px 16px;
        }

        .phil-badge-text .badge-value{
            font-size:21px;
        }
    }
</style>

<div id="home-philosophy-transition"></div>

<section id="home-philosophy">
    <div class="phil-inner">

        {{-- LEFT --}}
        <div class="phil-left">

            <p class="phil-eyebrow">OUR PHILOSOPHY</p>

            <h2 class="phil-heading">
                Breathing with the Earth
            </h2>

            <p class="phil-body">
                At AlasAre, we believe true luxury is space.
                From our 500 sqm land, only 100 sqm is used
                for buildings. The remaining 400 sqm is intentionally
                returned to nature as a private, breathing forest.
            </p>

            <p class="phil-body">
                This mindful 4:1 ratio ensures that our traditional
                Javanese structures do not dominate the landscape,
                but rather nestle within it, allowing the ancient
                rhythms of the jungle to remain undisturbed.
            </p>

            <div class="phil-features">

                <div class="phil-feature-item">

                    <div class="phil-feature-icon">
                        <img src="{{ asset('images/Footprint.png') }}" alt="">
                    </div>

                    <div class="phil-feature-text">
                        <h4>Minimal Footprint</h4>
                        <p>
                            Elevated structures preserving the natural
                            topography and soil integrity.
                        </p>
                    </div>

                </div>

                <div class="phil-feature-item">

                    <div class="phil-feature-icon">
                        <img src="{{ asset('images/Rewilding.png') }}" alt="">
                    </div>

                    <div class="phil-feature-text">
                        <h4>Rewilding Project</h4>
                        <p>
                            Over 200 native species planted to restore
                            the local ecosystem.
                        </p>
                    </div>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="phil-right">

            <div class="phil-img-wrap">

                <img src="{{ asset('images/Philosophy.png') }}" alt="AlasAre Forest View">

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