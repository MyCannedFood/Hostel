{{-- resources/views/admin/settings/partials/LandingPage/LandingPagePartials/gallery-section.blade.php --}}

@php
    $gallerySettings ??= null;
    $d = array_merge(
        \App\Models\LandingPageSetting::DEFAULTS['gallery'],
        $gallerySettings?->data ?? []
    );
@endphp

{{-- ── Flash Messages ── --}}
@if(session('success'))
    <div style="margin-bottom:16px; padding:12px 16px; background:#e6f4e6; border:1px solid #a3d4a3; border-radius:10px; color:#2e7d32; font-size:13px; font-weight:600;">
        ✓ {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div style="margin-bottom:16px; padding:12px 16px; background:#fdecea; border:1px solid #f5a5a5; border-radius:10px; color:#c62828; font-size:13px;">
        @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
    </div>
@endif

<a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="lp-back-link">
    ← Back to Landing Page Settings
</a>

<h2 class="section-title" style="margin-bottom:4px;">Gallery Text Settings</h2>
<form method="POST" action="{{ route('admin.landing.gallery.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- ══════════════════════════════════════════════════════
         SECTION 1: HERO
    ══════════════════════════════════════════════════════ --}}
    <div class="lp-card" style="margin-bottom:24px;">
        <h3 style="font-size:15px; font-weight:700; color:#1a3d0a; margin:0 0 6px;">
            1. Hero
        </h3>
        <p style="font-size:12px; color:#7a857f; margin:0 0 16px;">
            Judul besar dan deskripsi di bagian atas halaman Gallery.
        </p>

        {{-- Preview label --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

            {{-- EN --}}
            <div>
                <p style="font-size:11px; font-weight:700; color:#3a7d44; letter-spacing:.08em; margin:0 0 10px;">🇬🇧 ENGLISH</p>
                <div class="lp-field">
                    <label class="lp-field-label">Title Line 1</label>
                    <input class="lp-input" type="text" name="hero_title_line_1"
                           value="{{ old('hero_title_line_1', $d['hero_title_line_1']) }}"
                           maxlength="120" required
                           placeholder="A Javanese Sanctuary,">
                    <span class="lp-hint">Baris pertama judul hero. Contoh: <em>A Javanese Sanctuary,</em></span>
                </div>
                <div class="lp-field">
                    <label class="lp-field-label">Title Line 2</label>
                    <input class="lp-input" type="text" name="hero_title_line_2"
                           value="{{ old('hero_title_line_2', $d['hero_title_line_2']) }}"
                           maxlength="120" required
                           placeholder="Woven by Nature">
                </div>
                <div class="lp-field">
                    <label class="lp-field-label">Description</label>
                    <textarea class="lp-textarea" name="hero_description" rows="3" maxlength="600" required
                              placeholder="Explore the textures...">{{ old('hero_description', $d['hero_description']) }}</textarea>
                </div>
            </div>

            {{-- ID --}}
            <div>
                <p style="font-size:11px; font-weight:700; color:#b45309; letter-spacing:.08em; margin:0 0 10px;">🇮🇩 INDONESIA</p>
                <div class="lp-field">
                    <label class="lp-field-label">Title Line 1 (ID)</label>
                    <input class="lp-input" type="text" name="hero_title_line_1_id"
                           value="{{ old('hero_title_line_1_id', $d['hero_title_line_1_id']) }}"
                           maxlength="200" required
                           placeholder="Sebuah Sanctuary Jawa,">
                </div>
                <div class="lp-field">
                    <label class="lp-field-label">Title Line 2 (ID)</label>
                    <input class="lp-input" type="text" name="hero_title_line_2_id"
                           value="{{ old('hero_title_line_2_id', $d['hero_title_line_2_id']) }}"
                           maxlength="200" required
                           placeholder="Terjalin oleh Alam">
                </div>
                <div class="lp-field">
                    <label class="lp-field-label">Description (ID)</label>
                    <textarea class="lp-textarea" name="hero_description_id" rows="3" maxlength="800" required
                              placeholder="Jelajahi tekstur...">{{ old('hero_description_id', $d['hero_description_id']) }}</textarea>
                </div>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════
         SECTION 2: INTRO
    ══════════════════════════════════════════════════════ --}}
    <div class="lp-card" style="margin-bottom:24px;">
        <h3 style="font-size:15px; font-weight:700; color:#1a3d0a; margin:0 0 6px;">
            2. Intro
        </h3>
        <p style="font-size:12px; color:#7a857f; margin:0 0 16px;">
            Label kecil, judul, dan deskripsi di bawah grid gallery.<br>
            Contoh: <em>VISUAL SANCTUARY · Moments of Zen, Woven in Nature.</em>
        </p>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

            <div>
                <p style="font-size:11px; font-weight:700; color:#3a7d44; letter-spacing:.08em; margin:0 0 10px;">🇬🇧 ENGLISH</p>
                <div class="lp-field">
                    <label class="lp-field-label">Label</label>
                    <input class="lp-input" type="text" name="intro_label"
                           value="{{ old('intro_label', $d['intro_label']) }}"
                           maxlength="100" required
                           placeholder="VISUAL SANCTUARY">
                    <span class="lp-hint">Teks kecil berwarna oranye di atas judul intro.</span>
                </div>
                <div class="lp-field">
                    <label class="lp-field-label">Title</label>
                    <input class="lp-input" type="text" name="intro_title"
                           value="{{ old('intro_title', $d['intro_title']) }}"
                           maxlength="200" required
                           placeholder="Moments of Zen, Woven in Nature.">
                </div>
                <div class="lp-field">
                    <label class="lp-field-label">Description</label>
                    <textarea class="lp-textarea" name="intro_description" rows="3" maxlength="600" required>{{ old('intro_description', $d['intro_description']) }}</textarea>
                </div>
            </div>

            <div>
                <p style="font-size:11px; font-weight:700; color:#b45309; letter-spacing:.08em; margin:0 0 10px;">🇮🇩 INDONESIA</p>
                <div class="lp-field">
                    <label class="lp-field-label">Label (ID)</label>
                    <input class="lp-input" type="text" name="intro_label_id"
                           value="{{ old('intro_label_id', $d['intro_label_id']) }}"
                           maxlength="200" required
                           placeholder="SANCTUARY VISUAL">
                </div>
                <div class="lp-field">
                    <label class="lp-field-label">Title (ID)</label>
                    <input class="lp-input" type="text" name="intro_title_id"
                           value="{{ old('intro_title_id', $d['intro_title_id']) }}"
                           maxlength="250" required
                           placeholder="Momen Zen, Terjalin dalam Alam.">
                </div>
                <div class="lp-field">
                    <label class="lp-field-label">Description (ID)</label>
                    <textarea class="lp-textarea" name="intro_description_id" rows="3" maxlength="800" required>{{ old('intro_description_id', $d['intro_description_id']) }}</textarea>
                </div>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════
         SECTION 3: OUR STORY
    ══════════════════════════════════════════════════════ --}}
    <div class="lp-card" style="margin-bottom:24px;">
        <h3 style="font-size:15px; font-weight:700; color:#1a3d0a; margin:0 0 6px;">
            3. Our Story
        </h3>
        <p style="font-size:12px; color:#7a857f; margin:0 0 16px;">
            Bagian narasi di bawah map. Terdiri dari judul, 2 paragraf, dan tanda tangan.
        </p>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">

            <div>
                <p style="font-size:11px; font-weight:700; color:#3a7d44; letter-spacing:.08em; margin:0 0 10px;">🇬🇧 ENGLISH</p>
                <div class="lp-field">
                    <label class="lp-field-label">Story Title</label>
                    <input class="lp-input" type="text" name="story_title"
                           value="{{ old('story_title', $d['story_title']) }}"
                           maxlength="200" required
                           placeholder="Our Story, Hand-Crafted.">
                </div>
                <div class="lp-field">
                    <label class="lp-field-label">Paragraph 1</label>
                    <textarea class="lp-textarea" name="story_paragraph_1" rows="4" maxlength="800" required
                              placeholder="At AlasAre, we don't just build...">{{ old('story_paragraph_1', $d['story_paragraph_1']) }}</textarea>
                </div>
                <div class="lp-field">
                    <label class="lp-field-label">Paragraph 2</label>
                    <textarea class="lp-textarea" name="story_paragraph_2" rows="3" maxlength="800" required
                              placeholder="Every guest is part of an intimate circle...">{{ old('story_paragraph_2', $d['story_paragraph_2']) }}</textarea>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div class="lp-field">
                        <label class="lp-field-label">Signature Line</label>
                        <input class="lp-input" type="text" name="story_signature_line"
                               value="{{ old('story_signature_line', $d['story_signature_line']) }}"
                               maxlength="120" required
                               placeholder="In Serenity,">
                        <span class="lp-hint">Teks miring di atas nama. Contoh: <em>In Serenity,</em></span>
                    </div>
                    <div class="lp-field">
                        <label class="lp-field-label">Signature Title</label>
                        <input class="lp-input" type="text" name="story_signature_title"
                               value="{{ old('story_signature_title', $d['story_signature_title']) }}"
                               maxlength="200" required
                               placeholder="The AlaSare Guardians">
                        <span class="lp-hint">Nama/jabatan di bawah. Contoh: <em>The AlaSare Guardians</em></span>
                    </div>
                </div>
            </div>

            <div>
                <p style="font-size:11px; font-weight:700; color:#b45309; letter-spacing:.08em; margin:0 0 10px;">🇮🇩 INDONESIA</p>
                <div class="lp-field">
                    <label class="lp-field-label">Story Title (ID)</label>
                    <input class="lp-input" type="text" name="story_title_id"
                           value="{{ old('story_title_id', $d['story_title_id']) }}"
                           maxlength="250" required
                           placeholder="Kisah Kami, Dipahat dengan Tangan.">
                </div>
                <div class="lp-field">
                    <label class="lp-field-label">Paragraph 1 (ID)</label>
                    <textarea class="lp-textarea" name="story_paragraph_1_id" rows="4" maxlength="1000" required
                              placeholder="Di AlasAre, kami tidak hanya membangun...">{{ old('story_paragraph_1_id', $d['story_paragraph_1_id']) }}</textarea>
                </div>
                <div class="lp-field">
                    <label class="lp-field-label">Paragraph 2 (ID)</label>
                    <textarea class="lp-textarea" name="story_paragraph_2_id" rows="3" maxlength="1000" required
                              placeholder="Setiap tamu adalah bagian dari lingkaran intim...">{{ old('story_paragraph_2_id', $d['story_paragraph_2_id']) }}</textarea>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div class="lp-field">
                        <label class="lp-field-label">Signature Line (ID)</label>
                        <input class="lp-input" type="text" name="story_signature_line_id"
                               value="{{ old('story_signature_line_id', $d['story_signature_line_id']) }}"
                               maxlength="200" required
                               placeholder="Dalam Serenity,">
                    </div>
                    <div class="lp-field">
                        <label class="lp-field-label">Signature Title (ID)</label>
                        <input class="lp-input" type="text" name="story_signature_title_id"
                               value="{{ old('story_signature_title_id', $d['story_signature_title_id']) }}"
                               maxlength="250" required
                               placeholder="The AlaSare Guardians">
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════
         INFO BOX: Filter Buttons
    ══════════════════════════════════════════════════════ --}}
    {{-- Action buttons --}}
    <div style="display:flex; justify-content:flex-end; gap:10px;">
        <a href="{{ route('admin.settings', ['section' => 'landing']) }}" class="btn btn-orange-outline">Cancel</a>
        <button type="submit" class="btn btn-dark">Save Changes</button>
    </div>
</form>

{{-- Inline style untuk lp-hint --}}
<style>
.lp-hint {
    display: block;
    font-size: 11px;
    color: #9aaa90;
    margin-top: 3px;
    line-height: 1.4;
}
</style>