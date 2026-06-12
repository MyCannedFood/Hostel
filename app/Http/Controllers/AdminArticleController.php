<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Parsedown;

class AdminArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::with('admin')->orderBy('created_at', 'desc')->get();

        $stats = [
            'total'     => $articles->count(),
            'published' => $articles->where('status', 'Published')->count(),
            'drafts'    => $articles->where('status', 'Draft')->count(),
            'views'     => $articles->sum('views_count'),
        ];

        return view('admin.article', compact('articles', 'stats'));
    }

    public function show(Article $article): View
    {
        $article->content = (new Parsedown())->text($article->content);
        
        return view('article.show', compact('article'));
    }

    public function create(): View
    {
        return view('admin.article-create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'title_en'         => 'nullable|string|max:255',
            'content'          => 'required|string',
            'content_en'       => 'nullable|string',
            'category'         => 'required|string|max:255',
            'source'           => 'nullable|string|max:255',
            'status'           => 'required|string|in:Draft,Published',
            'publish_at'       => 'nullable|date',
            'meta_description' => 'nullable|string',
            'thumbnail'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('public/articles/thumbnails');
            $thumbnailPath = Storage::url($thumbnailPath);
        }

        Article::create([
            'admin_id'         => Auth::guard('admin')->id(),
            'title'            => $validated['title'],
            'title_en'         => $validated['title_en'] ?? null,
            'content'          => $validated['content'],
            'content_en'       => $validated['content_en'] ?? null,
            'category'         => $validated['category'],
            'source'           => $validated['source'] ?? null,
            'status'           => $validated['status'],
            'publish_at'       => $validated['publish_at'] ?? now(),
            'meta_description' => $validated['meta_description'] ?? null,
            'thumbnail'        => $thumbnailPath,
        ]);

        return redirect()->route('admin.article')->with('success', 'Article created successfully!');
    }

    public function edit(Article $article): View
    {
        return view('admin.article-create', compact('article'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'title_en'         => 'nullable|string|max:255',
            'content'          => 'required|string',
            'content_en'       => 'nullable|string',
            'category'         => 'required|string|max:255',
            'source'           => 'nullable|string|max:255',
            'status'           => 'required|string|in:Draft,Published',
            'publish_at'       => 'nullable|date',
            'meta_description' => 'nullable|string',
            'thumbnail'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $thumbnailPath = $article->thumbnail;
        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail) {
                $oldPath = str_replace('/storage/', 'public/', $article->thumbnail);
                Storage::delete($oldPath);
            }
            $thumbnailPath = $request->file('thumbnail')->store('public/articles/thumbnails');
            $thumbnailPath = Storage::url($thumbnailPath);
        }

        $article->update([
            'title'            => $validated['title'],
            'title_en'         => $validated['title_en'] ?? null,
            'content'          => $validated['content'],
            'content_en'       => $validated['content_en'] ?? null,
            'category'         => $validated['category'],
            'source'           => $validated['source'] ?? null,
            'status'           => $validated['status'],
            'publish_at'       => $validated['publish_at'] ?? $article->publish_at,
            'meta_description' => $validated['meta_description'] ?? null,
            'thumbnail'        => $thumbnailPath,
        ]);

        return redirect()->route('admin.article')->with('success', 'Article updated successfully!');
    }

    public function destroy(Article $article): RedirectResponse
    {
        if ($article->thumbnail) {
            $oldPath = str_replace('/storage/', 'public/', $article->thumbnail);
            Storage::delete($oldPath);
        }

        $article->delete();

        return redirect()->route('admin.article')->with('success', 'Article deleted successfully!');
    }

    public function uploadImage(Request $request)
    {
        $request->validate(['image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120']);
        $path = $request->file('image')->store('public/articles/content');
        return response()->json(['url' => Storage::url($path)]);
    }
}