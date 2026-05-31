<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateHeroRequest;
use App\Http\Requests\UpdatePhilosophyRequest;
use App\Http\Requests\UpdateFloraRequest;
use App\Http\Requests\UpdateMapRequest;
use App\Models\LandingPageSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class LandingPageController extends Controller
{
    /* ══════════════════════════════════════════
       HERO
    ══════════════════════════════════════════ */
    public function updateHero(UpdateHeroRequest $request): RedirectResponse
    {
        $setting = LandingPageSetting::firstOrNew(['section' => 'hero']);
        $data    = array_merge(LandingPageSetting::DEFAULTS['hero'], $setting->data ?? []);

        $data['headline']    = $request->headline;
        $data['subheadline'] = $request->subheadline;

        if ($request->hasFile('bg_image')) {
            if (!empty($data['bg_image'])) Storage::disk('public')->delete($data['bg_image']);
            $data['bg_image'] = $request->file('bg_image')->store('landing/hero', 'public');
        }
        if ($request->boolean('remove_bg_image') && !$request->hasFile('bg_image')) {
            if (!empty($data['bg_image'])) Storage::disk('public')->delete($data['bg_image']);
            $data['bg_image'] = null;
        }

        $setting->data = $data;
        $setting->updated_by = auth('admin')->id();
        $setting->save();

        return redirect()
            ->route('admin.settings', ['section' => 'landing', 'sub' => 'hero'])
            ->with('success', 'Hero section berhasil diperbarui.');
    }

    /* ══════════════════════════════════════════
       PHILOSOPHY
    ══════════════════════════════════════════ */
    public function updatePhilosophy(UpdatePhilosophyRequest $request): RedirectResponse
    {
        $setting = LandingPageSetting::firstOrNew(['section' => 'philosophy']);
        $data    = array_merge(LandingPageSetting::DEFAULTS['philosophy'], $setting->data ?? []);

        $data['tagline']     = $request->tagline;
        $data['heading']     = $request->heading;
        $data['body_1']      = $request->body_1;
        $data['body_2']      = $request->body_2;
        $data['badge_label'] = $request->badge_label;
        $data['badge_value'] = $request->badge_value;

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
            $features[] = [
                'icon_path'   => $iconPath,
                'icon_label'  => $feat['title'] ?? '',
                'title'       => $feat['title'] ?? '',
                'description' => $feat['description'] ?? '',
            ];
        }
        $data['features'] = $features;

        $setting->data = $data;
        $setting->updated_by = auth('admin')->id();
        $setting->save();

        return redirect()
            ->route('admin.settings', ['section' => 'landing', 'sub' => 'philosophy'])
            ->with('success', 'Our Philosophy section berhasil diperbarui.');
    }

    /* ══════════════════════════════════════════
       FLORA
    ══════════════════════════════════════════ */
    public function updateFlora(UpdateFloraRequest $request): RedirectResponse
    {
        $setting = LandingPageSetting::firstOrNew(['section' => 'flora']);
        $data    = array_merge(LandingPageSetting::DEFAULTS['flora'], $setting->data ?? []);

        $data['eyebrow']     = $request->eyebrow;
        $data['title']       = $request->title;
        $data['description'] = $request->description;

        $cards    = [];
        $allFiles = $request->allFiles();

        foreach ($request->cards ?? [] as $i => $card) {
            $imagePath = $card['image_path'] ?? null;
            if (isset($allFiles['cards'][$i]['image'])) {
                $file = $allFiles['cards'][$i]['image'];
                if ($imagePath) Storage::disk('public')->delete($imagePath);
                $imagePath = $file->store('landing/flora', 'public');
            }
            $cards[] = [
                'image_path'  => $imagePath,
                'eyebrow'     => $card['eyebrow']     ?? '',
                'title'       => $card['title']       ?? '',
                'description' => $card['description'] ?? '',
            ];
        }

        $data['cards'] = $cards;
        $setting->data = $data;
        $setting->updated_by = auth('admin')->id();
        $setting->save();

        return redirect()
            ->route('admin.settings', ['section' => 'landing', 'sub' => 'flora'])
            ->with('success', 'The Flora Concept berhasil diperbarui.');
    }

    /* ══════════════════════════════════════════
       MAP
    ══════════════════════════════════════════ */
    public function updateMap(UpdateMapRequest $request): RedirectResponse
    {
        $setting = LandingPageSetting::firstOrNew(['section' => 'map']);
        $data    = array_merge(LandingPageSetting::DEFAULTS['map'], $setting->data ?? []);

        // ── Text fields ──
        $data['subtitle'] = $request->subtitle ?? $data['subtitle'];
        $data['title']    = $request->title    ?? $data['title'];

        // ── Map image ──
        if ($request->hasFile('map_image')) {
            if (!empty($data['map_image'])) {
                Storage::disk('public')->delete($data['map_image']);
            }
            $data['map_image'] = $request->file('map_image')
                ->store('landing/map', 'public');
        }

        if ($request->boolean('remove_map_image') && !$request->hasFile('map_image')) {
            if (!empty($data['map_image'])) {
                Storage::disk('public')->delete($data['map_image']);
            }
            $data['map_image'] = null;
        }

        // Simpan nama admin yang update untuk metadata footer
        $data['updated_by_name'] = auth('admin')->user()?->name ?? 'Admin';

        $setting->data       = $data;
        $setting->updated_by = auth('admin')->id();
        $setting->save();

        return redirect()
            ->route('admin.settings', ['section' => 'landing', 'sub' => 'map'])
            ->with('success', 'AlaSare Map berhasil diperbarui.');
    }
}