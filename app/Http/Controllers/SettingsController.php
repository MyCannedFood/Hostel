<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Gallery;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $section = $request->get('section', 'gallery');
        $sub     = $request->get('sub');
        $data    = ['section' => $section, 'sub' => $sub];

        /* ── Gallery ── */
        if ($section === 'gallery') {
            $query = Gallery::query();

            if ($request->filled('category') && $request->category !== 'all') {
                $query->where('category', $request->category);
            }
            if ($request->filled('status') && $request->status !== 'all') {
                $query->where('status', $request->status);
            }

            $data['photos'] = $query->orderBy('column_placement')
                ->orderBy('order_number')
                ->paginate(10)
                ->appends($request->except('page'));
            $data['totalPhotos'] = Gallery::count();
            $data['filterCategory'] = $request->get('category', 'all');
            $data['filterStatus'] = $request->get('status', 'all');
        }

        /* ── Staff & Access Rights ── */
        if ($section === 'staff') {
            $tab = $request->get('tab', 'staff-list');

            if ($tab === 'staff-list') {
                $query = Admin::with('role');

                // Search by name
                if ($request->filled('search')) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                }

                $data['staffList'] = $query->orderBy('name')->get();
            }

            if ($tab === 'access-info') {
                $data['roles'] = Role::withCount('admins')->orderBy('name')->get();
            }

            // Roles untuk dropdown di modal Add/Edit Account
            $data['roleOptions'] = Role::orderBy('name')->get();
        }

        /* ── Landing Page Settings ── */
        if ($section === 'landing') {
            // Saat ini belum ada model khusus landing-map/hero di repo,
            // jadi kita berikan fallback agar partial bisa render.
            // Partial akan membaca $mapSettings/$heroSettings/$... sesuai kebutuhan.
            $data['mapSettings'] = (object) [
                'map_image' => null,
                'updated_at' => null,
                'updatedBy' => null,
            ];

            $data['heroSettings'] = (object) [
                'bg_image' => null,
                'headline' => null,
                'subheadline' => null,
                'updated_at' => null,
                'updatedBy' => null,
            ];

            $data['philosophySettings'] = (object) [
                'bg_image' => null,
                'title' => null,
                'content' => null,
                'updated_at' => null,
                'updatedBy' => null,
            ];

            $data['floraSettings'] = (object) [
                'title' => null,
                'content' => null,
                'updated_at' => null,
                'updatedBy' => null,
            ];

            $data['guestStoriesSettings'] = (object) [
                'updated_at' => null,
                'updatedBy' => null,
            ];

            // Pastikan sub valid (biar tidak error di partial lain)
            if ($sub && !in_array($sub, ['hero', 'philosophy', 'flora', 'map', 'guest-stories'], true)) {
                $data['sub'] = null;
            }
        }

        /* ── General Settings (existing views) ── */
        if ($section === 'general') {
            // Tidak ada data spesifik untuk general saat ini (view kemungkinan manage via frontend)
        }

        return view('admin.settings.settings', $data);
    }
}

