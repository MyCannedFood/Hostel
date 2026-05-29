<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->query('category');

        $query = Article::where('status', 'Published')
            ->where(function ($q) {
                $q->whereNull('publish_at')
                  ->orWhere('publish_at', '<=', now());
            })
            ->orderBy('publish_at', 'desc')
            ->orderBy('created_at', 'desc');

        if ($selectedCategory && $selectedCategory !== 'All') {
            $query->where('category', $selectedCategory);
        }

        $articles = $query->get();

        $categories = Article::where('status', 'Published')
            ->where(function ($q) {
                $q->whereNull('publish_at')
                  ->orWhere('publish_at', '<=', now());
            })
            ->distinct()
            ->pluck('category')
            ->filter();

        return view('pages.journal', compact('articles', 'categories', 'selectedCategory'));
    }

    public function show(Article $article)
    {
        if ($article->status !== 'Published' || ($article->publish_at && $article->publish_at->isFuture())) {
            if (!auth()->guard('admin')->check()) {
                abort(404);
            }
        }

        $article->increment('views_count');

        return view('pages.journal-detail', compact('article'));
    }
}
