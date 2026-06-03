<?php

namespace App\Http\Controllers;

use App\Models\Article;
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

            $data['heroData']             = $get('hero');
            $data['philosophyData']       = $get('philosophy');
            $data['floraData']            = $get('flora');
            $data['mapData']              = $get('map');
            $data['featuredRoomsData']    = $get('featured_rooms');
            $data['guestStoriesData']     = $get('guest_stories');
            $data['awardsData']           = $get('awards');
            $data['featuredArticlesData'] = $get('featured_articles');

            // ── Featured Rooms ──────────────────────────────────────────────
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

            // ── Featured Articles ───────────────────────────────────────────
            $articleIds       = $data['featuredArticlesData']['article_ids'] ?? [];
            $featuredArticles = collect();

            if (!empty($articleIds)) {
                $byId = Article::whereIn('id', $articleIds)
                    ->where('status', 'Published')
                    ->where(function ($q) {
                        $q->whereNull('publish_at')->orWhere('publish_at', '<=', now());
                    })
                    ->get()
                    ->keyBy('id');

                // Preserve urutan sesuai admin setting
                foreach ($articleIds as $id) {
                    if ($byId->has($id)) {
                        $featuredArticles->push($byId->get($id));
                    }
                }
            }

            // Fallback: kalau tidak ada IDs, ambil 3 artikel terbaru
            if ($featuredArticles->isEmpty()) {
                $featuredArticles = Article::where('status', 'Published')
                    ->where(function ($q) {
                        $q->whereNull('publish_at')->orWhere('publish_at', '<=', now());
                    })
                    ->orderBy('publish_at', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get();
            }

            $data['featuredArticles'] = $featuredArticles;
        }

        return view('pages.stub', $data);
    }

    public function showAdmin(Request $request, string $page)
    {
        return view('pages.admin_stub', ['page' => $page]);
    }
}