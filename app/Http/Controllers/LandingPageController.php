<?php
// FILE: app/Http/Controllers/LandingPageController.php  (ganti seluruh isi)

namespace App\Http\Controllers;

use App\Http\Requests\UpdateHeroRequest;
use App\Http\Requests\UpdatePhilosophyRequest;
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
        $data    = $setting->data ?? LandingPageSetting::DEFAULTS['hero'];

        $data['headline']    = $request->headline;
        $data['subheadline'] = $request->subheadline;

        if ($request->hasFile('bg_image')) {
            if (!empty($data['bg_image'])) {
                Storage::disk('public')->delete($data['bg_image']);
            }
            $data['bg_image'] = $request->file('bg_image')
                ->store('landing/hero', 'public');
        }

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
       PHILOSOPHY
    ══════════════════════════════════════════ */
    public function updatePhilosophy(UpdatePhilosophyRequest $request): RedirectResponse
    {
        $setting = LandingPageSetting::firstOrNew(['section' => 'philosophy']);
        $data    = $setting->data ?? LandingPageSetting::DEFAULTS['philosophy'];

        // ── Text fields ──
        $data['tagline']     = $request->tagline;
        $data['heading']     = $request->heading;
        $data['body_1']      = $request->body_1;
        $data['body_2']      = $request->body_2;
        $data['badge_label'] = $request->badge_label;
        $data['badge_value'] = $request->badge_value;

        // ── Side image ──
        if ($request->hasFile('side_image')) {
            if (!empty($data['side_image'])) {
                Storage::disk('public')->delete($data['side_image']);
            }
            $data['side_image'] = $request->file('side_image')
                ->store('landing/philosophy', 'public');
        }
        if ($request->boolean('remove_side_image') && !$request->hasFile('side_image')) {
            if (!empty($data['side_image'])) {
                Storage::disk('public')->delete($data['side_image']);
            }
            $data['side_image'] = null;
        }

        // ── Features ──
        $features    = [];
        $oldFeatures = collect($data['features'] ?? []);

        foreach ($request->features ?? [] as $i => $feat) {
            $iconPath = $feat['icon_path'] ?? null; // existing path

            // Upload icon baru kalau ada
            if (isset($request->allFiles()['features'][$i]['icon'])) {
                $file = $request->allFiles()['features'][$i]['icon'];
                // Hapus ikon lama
                if ($iconPath) {
                    Storage::disk('public')->delete($iconPath);
                }
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

        $setting->data       = $data;
        $setting->updated_by = auth('admin')->id();
        $setting->save();

        return redirect()
            ->route('admin.settings', ['section' => 'landing', 'sub' => 'philosophy'])
            ->with('success', 'Our Philosophy section berhasil diperbarui.');
    }
}