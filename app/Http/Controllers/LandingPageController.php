<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateHeroRequest;
use App\Http\Requests\UpdatePhilosophyRequest;
use App\Http\Requests\UpdateFloraRequest;
use App\Http\Requests\UpdateFeaturedRoomsRequest;
use App\Http\Requests\UpdateFeaturedArticlesRequest;
use App\Http\Requests\UpdateMapRequest;
use App\Http\Requests\UpdateGuestStoriesRequest;
use App\Http\Requests\UpdateAwardsRequest;
use App\Http\Requests\UpdateMediaPartnersRequest;
use App\Models\LandingPageSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /* ══════════════════════════════════════════ HERO ══ */
    public function updateHero(UpdateHeroRequest $request): RedirectResponse
    {
        $setting = LandingPageSetting::firstOrNew(['section' => 'hero']);
        $data    = array_merge(LandingPageSetting::DEFAULTS['hero'], $setting->data ?? []);

        // EN values (untouched by ID inputs)
        $data['headline']    = $request->headline;
        $data['subheadline'] = $request->subheadline;

        // ID values (from bilingual inputs)
        $data['headline_id']    = $request->headline_id ?? ($data['headline_id'] ?? null);
        $data['subheadline_id'] = $request->subheadline_id ?? ($data['subheadline_id'] ?? null);

        // Ensure ID keys are stored (so home hero can translate)
        $data['headline_id']    = $data['headline_id'] ?? '';
        $data['subheadline_id'] = $data['subheadline_id'] ?? '';

        if ($request->hasFile('bg_image')) {
            if (!empty($data['bg_image'])) Storage::disk('public')->delete($data['bg_image']);
            $data['bg_image'] = $request->file('bg_image')->store('landing/hero', 'public');
        }
        if ($request->boolean('remove_bg_image') && !$request->hasFile('bg_image')) {
            if (!empty($data['bg_image'])) Storage::disk('public')->delete($data['bg_image']);
            $data['bg_image'] = null;
        }

        $setting->data = $data; $setting->updated_by = auth('admin')->id(); $setting->save();

        return redirect()->route('admin.settings', ['section' => 'landing', 'sub' => 'hero'])
            ->with('success', 'Hero section berhasil diperbarui.');
    }

    /* ══════════════════════════════════════ PHILOSOPHY ══ */
    public function updatePhilosophy(UpdatePhilosophyRequest $request): RedirectResponse
    {
        $setting = LandingPageSetting::firstOrNew(['section' => 'philosophy']);
        $data    = array_merge(LandingPageSetting::DEFAULTS['philosophy'], $setting->data ?? []);

        // EN
        $data['tagline'] = $request->tagline; $data['heading']     = $request->heading;
        $data['body_1']  = $request->body_1;  $data['body_2']      = $request->body_2;
        $data['badge_label'] = $request->badge_label; $data['badge_value'] = $request->badge_value;

        // ID (bindo)
        $data['tagline_id'] = $request->tagline_id; $data['heading_id'] = $request->heading_id;
        $data['body_1_id']  = $request->body_1_id;  $data['body_2_id']  = $request->body_2_id;
        $data['badge_label_id'] = $request->badge_label_id;

        if ($request->hasFile('side_image')) {
            if (!empty($data['side_image'])) Storage::disk('public')->delete($data['side_image']);
            $data['side_image'] = $request->file('side_image')->store('landing/philosophy', 'public');
        }
        if ($request->boolean('remove_side_image') && !$request->hasFile('side_image')) {
            if (!empty($data['side_image'])) Storage::disk('public')->delete($data['side_image']);
            $data['side_image'] = null;
        }

        $features = [];
        foreach ($request->features ?? [] as $i => $feat) {
            $iconPath = $feat['icon_path'] ?? null;

            if (isset($request->allFiles()['features'][$i]['icon'])) {
                $file = $request->allFiles()['features'][$i]['icon'];
                if ($iconPath) Storage::disk('public')->delete($iconPath);
                $iconPath = $file->store('landing/philosophy/icons', 'public');
            }
            $features[] = ['icon_path' => $iconPath, 'icon_label' => $feat['title'] ?? '',
                           'title' => $feat['title'] ?? '', 'description' => $feat['description'] ?? ''];
        }
        
        // ID fields for features
        $features = array_map(function ($feat) {
            return $feat;
        }, $features);

        foreach (($request->features ?? []) as $i => $feat) {
            if (isset($features[$i])) {
                $features[$i]['title_id'] = $request->features[$i]['title_id'] ?? ($features[$i]['title_id'] ?? '');
                $features[$i]['description_id'] = $request->features[$i]['description_id'] ?? ($features[$i]['description_id'] ?? '');
            }
        }

        $data['features'] = $features;
        $setting->data = $data; $setting->updated_by = auth('admin')->id(); $setting->save();

        return redirect()->route('admin.settings', ['section' => 'landing', 'sub' => 'philosophy'])
            ->with('success', 'Our Philosophy section berhasil diperbarui.');
    }

    /* ══════════════════════════════════════════ FLORA ══ */
    public function updateFlora(UpdateFloraRequest $request): RedirectResponse
    {
        $setting = LandingPageSetting::firstOrNew(['section' => 'flora']);
        $data    = array_merge(LandingPageSetting::DEFAULTS['flora'], $setting->data ?? []);

        $data['eyebrow'] = $request->eyebrow; $data['title'] = $request->title;
        $data['description'] = $request->description;

        // ID fields (bindo)
        $data['eyebrow_id'] = $request->eyebrow_id;
        $data['title_id'] = $request->title_id;
        $data['description_id'] = $request->description_id;

        $cards = []; $allFiles = $request->allFiles();
        foreach ($request->cards ?? [] as $i => $card) {
            $imagePath = $card['image_path'] ?? null;
            if (isset($allFiles['cards'][$i]['image'])) {
                $file = $allFiles['cards'][$i]['image'];
                if ($imagePath) Storage::disk('public')->delete($imagePath);
                $imagePath = $file->store('landing/flora', 'public');
            }
            $cards[] = [
                'image_path' => $imagePath,
                'eyebrow' => $card['eyebrow'] ?? '',
                'eyebrow_id' => $card['eyebrow_id'] ?? '',
                'title' => $card['title'] ?? '',
                'title_id' => $card['title_id'] ?? '',
                'description' => $card['description'] ?? '',
                'description_id' => $card['description_id'] ?? '',
            ];
        }
        $data['cards'] = $cards;
        $setting->data = $data; $setting->updated_by = auth('admin')->id(); $setting->save();

        return redirect()->route('admin.settings', ['section' => 'landing', 'sub' => 'flora'])
            ->with('success', 'The Flora Concept berhasil diperbarui.');
    }

    /* ══════════════════════════════════════════ MAP ══ */
    public function updateMap(UpdateMapRequest $request): RedirectResponse
    {
        $setting = LandingPageSetting::firstOrNew(['section' => 'map']);
        $data    = array_merge(LandingPageSetting::DEFAULTS['map'], $setting->data ?? []);

        $data['subtitle'] = $request->subtitle ?? $data['subtitle'];
        $data['title']    = $request->title    ?? $data['title'];

        // ID (bindo)
        $data['subtitle_id'] = $request->subtitle_id ?? ($data['subtitle_id'] ?? '');
        $data['title_id']    = $request->title_id    ?? ($data['title_id'] ?? '');

        if ($request->hasFile('map_image')) {
            if (!empty($data['map_image'])) Storage::disk('public')->delete($data['map_image']);
            $data['map_image'] = $request->file('map_image')->store('landing/map', 'public');
        }
        if ($request->boolean('remove_map_image') && !$request->hasFile('map_image')) {
            if (!empty($data['map_image'])) Storage::disk('public')->delete($data['map_image']);
            $data['map_image'] = null;
        }
        $data['updated_by_name'] = auth('admin')->user()?->name ?? 'Admin';
        $setting->data = $data; $setting->updated_by = auth('admin')->id(); $setting->save();

        return redirect()->route('admin.settings', ['section' => 'landing', 'sub' => 'map'])
            ->with('success', 'AlaSare Map berhasil diperbarui.');
    }

    /* ═══════════════════════════════ FEATURED ROOMS ══ */
    public function updateFeaturedRooms(UpdateFeaturedRoomsRequest $request): RedirectResponse
    {
        $setting = LandingPageSetting::firstOrNew(['section' => 'featured_rooms']);
        $data    = array_merge(LandingPageSetting::DEFAULTS['featured_rooms'], $setting->data ?? []);

        // English Content
        $data['title']       = $request->title;
        $data['description'] = $request->description;

        // Indonesian Content (Tambahkan 2 baris ini agar tersimpan)
        $data['title_id']       = $request->title_id ?? ($data['title_id'] ?? '');
        $data['description_id'] = $request->description_id ?? ($data['description_id'] ?? '');

        $data['room_ids']    = collect($request->input('room_ids', []))
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values()
            ->all();

        $setting->data       = $data;
        $setting->updated_by = auth('admin')->id();
        $setting->save();

        return redirect()
            ->route('admin.settings', ['section' => 'landing', 'sub' => 'featured-rooms'])
            ->with('success', 'Featured Rooms berhasil diperbarui.');
    }

    /* ═════════════════════ FEATURED ARTICLES ═════════════════════ */
    public function updateFeaturedArticles(UpdateFeaturedArticlesRequest $request): RedirectResponse
    {
        $setting = LandingPageSetting::firstOrNew([
            'section' => 'featured_articles'
        ]);

        $data = array_merge(
            LandingPageSetting::DEFAULTS['featured_articles'],
            $setting->data ?? []
        );

        // English Content
        $data['section_title']       = $request->section_title;
        $data['section_description'] = $request->section_description;

        // Indonesian Content (Tambahkan 2 baris ini)
        $data['section_title_id']       = $request->section_title_id ?? ($data['section_title_id'] ?? '');
        $data['section_description_id'] = $request->section_description_id ?? ($data['section_description_id'] ?? '');

        $data['article_ids'] = collect(
            $request->input('article_ids', [])
        )
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->take(3)
            ->values()
            ->all();

        $setting->data       = $data;
        $setting->updated_by = auth('admin')->id();
        $setting->save();

        return redirect()
            ->route('admin.settings', [
                'section' => 'landing',
                'sub' => 'featured-articles'
            ])
            ->with('success', 'Featured Articles berhasil diperbarui.');
    }

    /* ══════════════════════════════════ GUEST STORIES ══ */
    public function updateGuestStories(UpdateGuestStoriesRequest $request): RedirectResponse
    {
        $setting = LandingPageSetting::firstOrNew(['section' => 'guest_stories']);
        // Menggabungkan dengan default untuk menjaga struktur data jika ada field baru
        $data    = array_merge(LandingPageSetting::DEFAULTS['guest_stories'], $setting->data ?? []);

        // Simpan judul & subtitle (Bilingual)
        $data['title']        = $request->title ?? $data['title'];
        $data['title_id']     = $request->title_id ?? ($data['title_id'] ?? '');
        $data['subtitle']     = $request->subtitle ?? ($data['subtitle'] ?? '');
        $data['subtitle_id']  = $request->subtitle_id ?? ($data['subtitle_id'] ?? '');

        $stories = []; 
        $allFiles = $request->allFiles();

        foreach ($request->stories ?? [] as $i => $story) {
            $imagePath = $story['image_path'] ?? null;
            
            // Handle file upload per item
            if (isset($allFiles['stories'][$i]['image'])) {
                $file = $allFiles['stories'][$i]['image'];
                if ($imagePath) Storage::disk('public')->delete($imagePath);
                $imagePath = $file->store('landing/guest-stories', 'public');
            }
            
            $stories[] = [
                'image_path'   => $imagePath, 
                'name'         => $story['name'] ?? '',
                'origin'       => $story['origin'] ?? '', 
                'quote'        => $story['quote'] ?? '',
                'origin_id'    => $story['origin_id'] ?? '', 
                'quote_id'     => $story['quote_id'] ?? '',
            ];
        }
        
        $data['stories'] = $stories;

        // Simpan ke database
        $setting->data = $data; 
        $setting->updated_by = auth('admin')->id(); 
        $setting->save();

        return redirect()->route('admin.settings', ['section' => 'landing', 'sub' => 'guest-stories'])
            ->with('success', 'Guest Stories berhasil diperbarui.');
    }

    /* ══════════════════════════════════════════ AWARDS ══ */
    public function updateAwards(UpdateAwardsRequest $request): RedirectResponse
    {
        $setting = LandingPageSetting::firstOrNew(['section' => 'awards']);
        $data    = array_merge(LandingPageSetting::DEFAULTS['awards'], $setting->data ?? []);

        // EN & ID Titles tingkat atas
        $data['section_title']    = $request->section_title ?? $data['section_title'];
        $data['section_title_id'] = $request->section_title_id ?? ($data['section_title_id'] ?? '');

        $items    = [];
        $allFiles = $request->allFiles();
        $visible  = 0;

        foreach ($request->items ?? [] as $i => $item) {
            $iconPath   = $item['icon_path'] ?? null;
            $isVisible  = !empty($item['is_visible']) && $visible < 4;
            if ($isVisible) $visible++;

            if (isset($allFiles['items'][$i]['icon'])) {
                $file = $allFiles['items'][$i]['icon'];
                if ($iconPath) Storage::disk('public')->delete($iconPath);
                $iconPath = $file->store('landing/awards', 'public');
            }

            $items[] = [
                'icon_path'  => $iconPath,
                'title'      => $item['title']      ?? '',
                'title_id'   => $item['title_id']   ?? '',
                'sub'        => $item['sub']        ?? '',
                'sub_id'     => $item['sub_id']     ?? '',
                'is_visible' => $isVisible,
            ];
        }

        $data['items']       = $items;
        $setting->data       = $data;
        $setting->updated_by = auth('admin')->id();
        $setting->save();

        return redirect()
            ->route('admin.settings', ['section' => 'landing', 'sub' => 'awards'])
            ->with('success', 'Awards & Recognition berhasil diperbarui.');
    }

    /* ══════════════════════════════ MEDIA PARTNERS ══ */
    public function updateMediaPartners(UpdateMediaPartnersRequest $request): RedirectResponse
    {
        $setting = LandingPageSetting::firstOrNew(['section' => 'media_partners']);
        $data    = array_merge(LandingPageSetting::DEFAULTS['media_partners'], $setting->data ?? []);

        // EN & ID Section Titles
        $data['title']    = $request->title ?? $data['title'];
        $data['title_id'] = $request->title_id ?? ($data['title_id'] ?? ''); // 👈 Tambahkan ini

        $partners = [];
        $allFiles = $request->allFiles();

        foreach ($request->partners ?? [] as $i => $partner) {
            $logoPath = $partner['logo_path'] ?? null;
            
            if (isset($allFiles['partners'][$i]['logo'])) {
                $file = $allFiles['partners'][$i]['logo'];
                if ($logoPath) Storage::disk('public')->delete($logoPath);
                $logoPath = $file->store('landing/media-partners', 'public');
            }

            $partners[] = [
                'logo_path' => $logoPath,
                'name'      => $partner['name'] ?? '',
                'url'       => $partner['url']  ?? '',
                'style'     => $partner['style'] ?? '',
            ];
        }

        $data['partners']    = $partners;
        $setting->data       = $data;
        $setting->updated_by = auth('admin')->id();
        $setting->save();

        return redirect()
            ->route('admin.settings', ['section' => 'landing', 'sub' => 'media-partners'])
            ->with('success', 'Media & Partners berhasil diperbarui.');
    }
}