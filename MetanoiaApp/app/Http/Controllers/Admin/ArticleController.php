<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function index(Request $request): Response
    {
        $status = $request->query('status');

        $query = Article::query()->latest();

        if ($status && array_key_exists($status, Article::STATUSES)) {
            $query->where('status', $status);
        }

        $articles = $query->paginate(15)->withQueryString()->through(fn (Article $a) => [
            'id' => $a->id,
            'title' => $a->title,
            'slug' => $a->slug,
            'category' => $a->category,
            'status' => $a->status,
            'published_at' => $a->published_at?->format('Y-m-d'),
            'updated_at' => $a->updated_at->format('Y-m-d H:i'),
        ]);

        return Inertia::render('admin/Articles', [
            'articles' => $articles,
            'filters' => ['status' => $status],
            'statuses' => Article::STATUSES,
            'counts' => collect(Article::STATUSES)->keys()->mapWithKeys(
                fn ($s) => [$s => Article::where('status', $s)->count()]
            ),
            'total' => Article::count(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/ArticleForm', [
            'article' => null,
            'statuses' => Article::STATUSES,
            'categories' => Article::CATEGORIES,
        ]);
    }

    public function store(ArticleRequest $request)
    {
        Article::create($this->payload($request));

        return redirect()->route('admin.articles.index')->with('success', 'Article created.');
    }

    public function edit(Article $article): Response
    {
        return Inertia::render('admin/ArticleForm', [
            'article' => [
                'id' => $article->id,
                'title' => $article->title,
                'slug' => $article->slug,
                'category' => $article->category,
                'excerpt' => $article->excerpt,
                'body' => $article->body,
                'cover_image' => $article->cover_image,
                'author' => $article->author,
                'meta_title' => $article->meta_title,
                'meta_description' => $article->meta_description,
                'status' => $article->status,
                'published_at' => $article->published_at?->format('Y-m-d\TH:i'),
            ],
            'statuses' => Article::STATUSES,
            'categories' => Article::CATEGORIES,
        ]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->update($this->payload($request, $article));

        return redirect()->route('admin.articles.index')->with('success', 'Article updated.');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article deleted.');
    }

    /** Normalize the validated input: auto-slug, default publish date, default author. */
    private function payload(ArticleRequest $request, ?Article $article = null): array
    {
        $data = $request->validated();

        $data['slug'] = $data['slug']
            ? Article::uniqueSlug($data['slug'], $article?->id)
            : Article::uniqueSlug($data['title'], $article?->id);

        // Stamp a publish date when an article goes live without one set.
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $data['author'] = $data['author'] ?: 'Metanoia Energy';

        return $data;
    }
}
