<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Gallery;
use App\Models\LandingPageSetting;
use App\Models\Role;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(Request $request)
    {
        $section = $request->get('section', 'gallery');
        $data    = ['section' => $section];

        /* ── Gallery ── */
        if ($section === 'gallery') {
            $query = Gallery::query();
            if ($request->filled('category') && $request->category !== 'all')
                $query->where('category', $request->category);
            if ($request->filled('status') && $request->status !== 'all')
                $query->where('status', $request->status);

            $data['photos']         = $query->orderBy('column_placement')->orderBy('order_number')
                                            ->paginate(10)->appends($request->except('page'));
            $data['totalPhotos']    = Gallery::count();
            $data['filterCategory'] = $request->get('category', 'all');
            $data['filterStatus']   = $request->get('status', 'all');
        }

        /* ── Staff ── */
        if ($section === 'staff') {
            $tab = $request->get('tab', 'staff-list');
            if ($tab === 'staff-list') {
                $query = Admin::with('role');
                if ($request->filled('search'))
                    $query->where('name', 'like', '%' . $request->search . '%');
                $data['staffList'] = $query->orderBy('name')->get();
            }
            if ($tab === 'access-info')
                $data['roles'] = Role::withCount('admins')->orderBy('name')->get();
            $data['roleOptions'] = Role::orderBy('name')->get();
        }

        /* ── Landing Page ── */
        if ($section === 'landing') {
            $sub = $request->get('sub');

            match ($sub) {
                'hero'          => $data['heroSettings']          = LandingPageSetting::getSection('hero'),
                'philosophy'    => $data['philosophySettings']    = LandingPageSetting::getSection('philosophy'),
                'flora'         => $data['floraSettings']         = LandingPageSetting::getSection('flora'),
                'map'           => $data['mapSettings']           = LandingPageSetting::getSection('map'),
                'guest-stories' => $data['guestStoriesSettings']  = LandingPageSetting::getSection('guest_stories'),
                'awards'        => $data['awardsSettings']        = LandingPageSetting::getSection('awards'),
                default         => null,
            };
        }

        return view('admin.settings.settings', $data);
    }
}