<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleController extends Controller
{
    /** Public articles index — published only, newest first, optional category filter. */
    public function index(Request $request): Response
    {
        $category = $request->query('category');

        $query = Article::published()->latest('published_at');

        if ($category) {
            $query->where('category', $category);
        }

        $articles = $query->paginate(9)->withQueryString()->through(fn (Article $a) => [
            'title' => $a->title,
            'slug' => $a->slug,
            'category' => $a->category,
            'excerpt' => $a->excerpt,
            'cover_image' => $a->cover_image,
            'author' => $a->author,
            'read_minutes' => $a->readMinutes(),
            'published_at' => $a->published_at?->format('M j, Y'),
        ]);

        $categories = Article::published()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return Inertia::render('public/Articles', [
            'articles' => $articles,
            'categories' => $categories,
            'filters' => ['category' => $category],
        ]);
    }

    /** Public article detail by slug — published only. */
    public function show(Article $article): Response
    {
        if (! $article->isPublished()) {
            throw new NotFoundHttpException;
        }

        $related = Article::published()
            ->where('id', '!=', $article->id)
            ->when($article->category, fn ($q) => $q->where('category', $article->category))
            ->latest('published_at')
            ->take(3)
            ->get()
            ->map(fn (Article $a) => [
                'title' => $a->title,
                'slug' => $a->slug,
                'category' => $a->category,
                'excerpt' => $a->excerpt,
                'cover_image' => $a->cover_image,
                'read_minutes' => $a->readMinutes(),
                'published_at' => $a->published_at?->format('M j, Y'),
            ]);

        return Inertia::render('public/Article', [
            'article' => [
                'title' => $article->title,
                'slug' => $article->slug,
                'category' => $article->category,
                'excerpt' => $article->excerpt,
                'body_html' => $article->renderedBody(),
                'cover_image' => $article->cover_image,
                'author' => $article->author,
                'read_minutes' => $article->readMinutes(),
                'published_at' => $article->published_at?->format('M j, Y'),
                'published_at_iso' => $article->published_at?->toIso8601String(),
                'meta_title' => $article->meta_title ?: $article->title,
                'meta_description' => $article->meta_description ?: $article->excerpt,
            ],
            'related' => $related,
        ]);
    }
}
