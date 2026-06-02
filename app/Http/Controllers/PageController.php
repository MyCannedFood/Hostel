<?php

namespace App\Http\Controllers;

use App\Models\LandingPageSetting;
use App\Models\Room;
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
            $data['featuredRoomsData'] = $get('featured_rooms');
            $data['guestStoriesData'] = $get('guest_stories');
            $data['awardsData']       = $get('awards');

            $hasFeaturedRoomsSetting = $settings->has('featured_rooms');
            $featuredRoomIds = collect($data['featuredRoomsData']['room_ids'] ?? [])
                ->map(fn ($id) => (int) $id)
                ->filter()
                ->unique()
                ->values();

            $featuredRoomsQuery = Room::withCount('beds');
            if ($featuredRoomIds->isNotEmpty()) {
                $data['featuredRooms'] = $featuredRoomsQuery
                    ->whereIn('id', $featuredRoomIds)
                    ->get()
                    ->sortBy(fn ($room) => $featuredRoomIds->search($room->id))
                    ->values();
            } elseif (!$hasFeaturedRoomsSetting) {
                $data['featuredRooms'] = $featuredRoomsQuery
                    ->where('is_active', true)
                    ->latest()
                    ->take(3)
                    ->get();
            } else {
                $data['featuredRooms'] = collect();
            }
        }

        return view('pages.stub', $data);
    }

    public function showAdmin(Request $request, string $page)
    {
        return view('pages.admin_stub', ['page' => $page]);
    }
}
