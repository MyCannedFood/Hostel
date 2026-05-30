<?php
// FILE: app/Http/Controllers/PageController.php  (ganti seluruh isi)

namespace App\Http\Controllers;

use App\Models\LandingPageSetting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Request $request, string $page)
    {
        $data = ['page' => $page];

        if (in_array(strtolower($page), ['home', ''])) {
            // Ambil semua section sekaligus — satu query
            $settings = LandingPageSetting::whereIn('section', ['hero', 'philosophy', 'flora', 'map', 'guest_stories'])
                ->get()
                ->keyBy('section');

            // Helper: ambil data section, fallback ke DEFAULTS kalau belum ada di DB
            $get = fn(string $s) => $settings->get($s)?->data
                ?? LandingPageSetting::DEFAULTS[$s]
                ?? [];

            $data['heroData']        = $get('hero');
            $data['philosophyData']  = $get('philosophy');
            $data['floraData']       = $get('flora');
            $data['mapData']         = $get('map');
            $data['guestStoriesData']= $get('guest_stories');
        }

        return view('pages.stub', $data);
    }

    public function showAdmin(Request $request, string $page)
    {
        return view('pages.admin_stub', ['page' => $page]);
    }
}