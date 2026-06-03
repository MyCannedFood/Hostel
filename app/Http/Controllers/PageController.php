<?php
// FILE: app/Http/Controllers/PageController.php  (ganti seluruh isi)

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\LandingPageSetting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show(Request $request, string $page)
    {
        $data = ['page' => $page];

        if (in_array(strtolower($page), ['home', ''])) {
            // Satu query untuk semua section
            $settings = LandingPageSetting::whereIn('section', LandingPageSetting::SECTIONS)
                ->get()
                ->keyBy('section');

            $get = fn(string $s) => array_merge(
                LandingPageSetting::DEFAULTS[$s] ?? [],
                $settings->get($s)?->data ?? []
            );

            $data['heroData']              = $get('hero');
            $data['philosophyData']        = $get('philosophy');
            $data['floraData']             = $get('flora');
            $data['mapData']               = $get('map');
            $data['guestStoriesData']      = $get('guest_stories');
            $data['awardsData']            = $get('awards');
            $data['featuredArticlesData']  = $get('featured_articles');

            // Ambil Article models berdasarkan stored IDs, preserve order
            $ids             = $data['featuredArticlesData']['article_ids'] ?? [];
            $featuredArticles = collect();

            if (!empty($ids)) {
                $byId = Article::whereIn('id', $ids)
                    ->where('status', 'Published')
                    ->where(function ($q) {
                        $q->whereNull('publish_at')->orWhere('publish_at', '<=', now());
                    })
                    ->get()
                    ->keyBy('id');

                // Preserve urutan sesuai admin setting
                foreach ($ids as $id) {
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