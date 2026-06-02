<?php

namespace App\Http\Controllers;

use App\Models\LandingPageSetting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Request $request, string $page)
    {
        $data = ['page' => $page];

        if (in_array(strtolower($page), ['home', ''])) {
            // Satu query untuk semua section sekaligus
            $settings = LandingPageSetting::whereIn('section', LandingPageSetting::SECTIONS)
                ->get()
                ->keyBy('section');

            // Helper: ambil data section, merge dengan DEFAULTS supaya key baru selalu ada
            $get = fn(string $s) => array_merge(
                LandingPageSetting::DEFAULTS[$s] ?? [],
                $settings->get($s)?->data ?? []
            );

            $data['heroData']         = $get('hero');
            $data['philosophyData']   = $get('philosophy');
            $data['floraData']        = $get('flora');
            $data['mapData']          = $get('map');
            $data['guestStoriesData'] = $get('guest_stories');
            $data['awardsData']       = $get('awards');
        }

        return view('pages.stub', $data);
    }

    public function showAdmin(Request $request, string $page)
    {
        return view('pages.admin_stub', ['page' => $page]);
    }
}