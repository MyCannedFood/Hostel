<section id="home-media-and-partners" style="background:#F6F6F1; padding:56px 40px 60px; text-align:center; font-family:Georgia,'Times New Roman',serif;">

    {{-- TANDA SECTION: media_and_partners --}}

    @php
        $mediaPartners = [
            ['name' => 'Condé Nast Traveller', 'style' => 'font-family:Georgia,serif; font-size:17px; font-weight:400; letter-spacing:0.02em;'],
            ['name' => 'TRAVEL + LEISURE',     'style' => 'font-family:Arial,sans-serif; font-size:15px; font-weight:700; letter-spacing:0.12em;'],
            ['name' => 'Tatler Asia',           'style' => 'font-family:Georgia,serif; font-size:17px; font-style:italic; font-weight:400;'],
            ['name' => 'National Geographic',  'style' => 'font-family:Arial,sans-serif; font-size:17px; font-weight:700; letter-spacing:0.01em; color:#6b8f6b;'],
            ['name' => 'VOGUE LIVING',          'style' => 'font-family:Arial,sans-serif; font-size:14px; font-weight:400; letter-spacing:0.18em;'],
            ['name' => 'the guardian',          'style' => 'font-family:Georgia,serif; font-size:19px; font-weight:400; font-style:italic; color:#9aaa90;'],
            ['name' => 'Forbes',                'style' => 'font-family:Arial,sans-serif; font-size:16px; font-weight:700; letter-spacing:0.06em;'],
            ['name' => 'The New York Times',    'style' => 'font-family:Georgia,serif; font-size:17px; font-weight:400; letter-spacing:0.04em; font-style:italic;'],
            ['name' => 'Lonely Planet',         'style' => 'font-family:Arial,sans-serif; font-size:13px; font-weight:700; letter-spacing:0.1em;'],
            ['name' => 'Monocle',               'style' => 'font-family:Arial,sans-serif; font-size:15px; font-weight:400; letter-spacing:0.08em;'],
            ['name' => 'Wallpaper*',            'style' => 'font-family:Georgia,serif; font-size:15px; font-style:italic;'],
            ['name' => 'BBC Travel',            'style' => 'font-family:Arial,sans-serif; font-size:15px; font-weight:700; letter-spacing:0.01em; color:#6b8f6b;'],
        ];

        $perRow     = 5;   // jumlah logo per baris
        $maxRows    = 2;   // maksimal baris yang tampil
        $maxVisible = $perRow * $maxRows; // = 10
        $row1       = array_slice($mediaPartners, 0, $perRow);
        $row2       = array_slice($mediaPartners, $perRow, $perRow);
        $hasMore    = count($mediaPartners) > $maxVisible;
    @endphp

    <p style="font-family:Arial,sans-serif; font-size:11px; font-weight:700; letter-spacing:0.18em; color:#6b8f6b; text-transform:uppercase; margin:0 0 40px;">
        As Seen In
    </p>

    {{-- Baris 1 --}}
    <div style="display:flex; align-items:center; justify-content:center; gap:0 48px; margin-bottom:28px; flex-wrap:nowrap;">
        @foreach($row1 as $media)
            <span style="color:#a8a89e; white-space:nowrap; {{ $media['style'] }}">{{ $media['name'] }}</span>
        @endforeach
    </div>

    {{-- Baris 2 --}}
    <div style="display:flex; align-items:center; justify-content:center; gap:0 48px; flex-wrap:nowrap;">
        @foreach($row2 as $media)
            <span style="color:#a8a89e; white-space:nowrap; {{ $media['style'] }}">{{ $media['name'] }}</span>
        @endforeach
    </div>

    @if($hasMore)
        <div style="margin-top:28px;">
            <button
                onclick="document.getElementById('mediaModal').style.display='flex'"
                style="font-family:Arial,sans-serif; font-size:11px; font-weight:700; letter-spacing:0.14em; text-transform:uppercase; color:#6b8f6b; background:none; border:1.5px solid #6b8f6b; padding:9px 28px; border-radius:2px; cursor:pointer;"
            >
                View All Media
            </button>
        </div>
    @endif

</section>

{{-- MODAL: All Media & Partners --}}
<div
    id="mediaModal"
    onclick="if(event.target===this) this.style.display='none'"
    style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.38); z-index:9999; align-items:center; justify-content:center;"
>
    <div style="background:#F6F6F1; border-radius:6px; width:90%; max-width:620px; max-height:78vh; display:flex; flex-direction:column; overflow:hidden;">

        <div style="padding:24px 28px 16px; border-bottom:1px solid #d4d1c8; display:flex; align-items:center; justify-content:space-between; flex-shrink:0;">
            <h3 style="font-family:Arial,sans-serif; font-size:11px; font-weight:700; letter-spacing:0.16em; text-transform:uppercase; color:#6b8f6b; margin:0;">
                All Media &amp; Partners
            </h3>
            <button
                onclick="document.getElementById('mediaModal').style.display='none'"
                style="background:none; border:none; cursor:pointer; font-size:22px; color:#9a9890; line-height:1; padding:0;"
                aria-label="Close"
            >&times;</button>
        </div>

        <div style="overflow-y:auto; padding:24px 28px 28px; flex:1;">
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(160px, 1fr)); gap:16px 20px;">
                @foreach($mediaPartners as $media)
                    <div style="background:#eceae3; border-radius:4px; padding:18px 12px; display:flex; align-items:center; justify-content:center; min-height:60px; text-align:center;">
                        <span style="color:#a8a89e; {{ $media['style'] }}; font-size:13px;">
                            {{ $media['name'] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>