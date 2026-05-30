<?php
// FILE: app/Http/Controllers/LandingPageController.php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateHeroRequest;
use App\Models\LandingPageSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class LandingPageController extends Controller
{
    /* ══════════════════════════════════════════
       HERO SECTION
    ══════════════════════════════════════════ */
    public function updateHero(UpdateHeroRequest $request): RedirectResponse
    {
        $setting = LandingPageSetting::firstOrNew(['section' => 'hero']);
        $data    = $setting->data ?? LandingPageSetting::DEFAULTS['hero'];

        // Update teks
        $data['headline']    = $request->headline;
        $data['subheadline'] = $request->subheadline;

        // Upload bg_image kalau ada file baru
        if ($request->hasFile('bg_image')) {
            // Hapus gambar lama
            if (!empty($data['bg_image'])) {
                Storage::disk('public')->delete($data['bg_image']);
            }
            $data['bg_image'] = $request->file('bg_image')
                ->store('landing/hero', 'public');
        }

        // Hapus bg_image kalau user klik Remove
        if ($request->boolean('remove_bg_image') && !$request->hasFile('bg_image')) {
            if (!empty($data['bg_image'])) {
                Storage::disk('public')->delete($data['bg_image']);
            }
            $data['bg_image'] = null;
        }

        $setting->data       = $data;
        $setting->updated_by = auth('admin')->id();
        $setting->save();

        return redirect()
            ->route('admin.settings', ['section' => 'landing', 'sub' => 'hero'])
            ->with('success', 'Hero section berhasil diperbarui.');
    }

    /* ══════════════════════════════════════════
       PHILOSOPHY — placeholder, aktifkan nanti
    ══════════════════════════════════════════ */
    // public function updatePhilosophy(Request $request): RedirectResponse { ... }

    /* ══════════════════════════════════════════
       FLORA — placeholder, aktifkan nanti
    ══════════════════════════════════════════ */
    // public function updateFlora(Request $request): RedirectResponse { ... }

    /* ══════════════════════════════════════════
       MAP — placeholder, aktifkan nanti
    ══════════════════════════════════════════ */
    // public function updateMap(Request $request): RedirectResponse { ... }
}