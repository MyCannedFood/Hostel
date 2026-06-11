@php
    $mapData  ??= \App\Models\LandingPageSetting::DEFAULTS['map'];
    $mapData  = array_merge(\App\Models\LandingPageSetting::DEFAULTS['map'], $mapData);

    // English (dari DB)
    $subtitle    = $mapData['subtitle'] ?? 'Explore the Ground';
    $title       = $mapData['title']    ?? 'AlaSare Map';

    // Indonesian (dari DB, fallback ke hardcode)
    $subtitleId  = $mapData['subtitle_id'] ?? 'Jelajahi Kawasan';
    $titleId     = $mapData['title_id']    ?? 'Peta AlaSare';

    $mapImageUrl = !empty($mapData['map_image'])
                   ? asset('storage/' . $mapData['map_image'])
                   : asset('map-alasare.png');
@endphp

<section id="home-map">
    <div class="header-group">
        <span class="subtitle"
              data-en="{{ $subtitle }}"
              data-id="{{ $subtitleId }}">{{ $subtitle }}</span>

        <h2 class="title"
            data-en="{{ $title }}"
            data-id="{{ $titleId }}">{{ $title }}</h2>
    </div>

    <div class="map-container">
        <img src="{{ $mapImageUrl }}" alt="AlaSare Hostel Illustrated Map">

        {{-- Hotspots tetap static --}}
        <div class="map-hotspots">
            <a href="#area-hutan"  class="hotspot" style="top:30%;left:38.5%;width:10%;height:5%;"
               title="Area Hutan"></a>
            <a href="#the-villas"  class="hotspot" style="top:55.5%;left:54.5%;width:10%;height:5%;"
               title="The Villas"></a>
            <a href="#kebun-sayur" class="hotspot" style="top:64%;left:69.5%;width:10%;height:5%;"
               title="Kebun Sayur"></a>
        </div>

        {{-- Legend --}}
        <div class="map-legend">
            <h4 data-en="Map Legend" data-id="Keterangan Peta">Map Legend</h4>
            <ul class="legend-list">
                <li class="legend-item">
                    <span class="legend-color" style="background:#419662;"></span>
                    <span data-en="Pakis Braga Points"
                          data-id="Titik Pakis Braga">Pakis Braga Points</span>
                </li>
                <li class="legend-item">
                    <span class="legend-color" style="background:#D37D4F;"></span>
                    <span data-en="Living Pharmacy"
                          data-id="Apotek Hidup">Living Pharmacy</span>
                </li>
                <li class="legend-item">
                    <span class="legend-color" style="background:#fff;border:1px solid #ddd;"></span>
                    <span data-en="Restored Structures"
                          data-id="Bangunan Dipulihkan">Restored Structures</span>
                </li>
            </ul>
        </div>
    </div>
</section>

<script>
document.addEventListener('alas:langchange', function (e) {
    applyMapLang(e.detail.lang);
});

function applyMapLang(lang) {
    document.querySelectorAll('#home-map [data-en][data-id]').forEach(function (el) {
        el.textContent = lang === 'id' ? el.dataset.id : el.dataset.en;
    });
}

(function () {
    var lang = (window.AlasLang ? window.AlasLang.current() : null)
               || localStorage.getItem('alas_lang')
               || 'en';
    applyMapLang(lang);
})();
</script>