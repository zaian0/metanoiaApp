<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    /** Public articles index — published, current locale, newest first, optional category filter. */
    public function index(Request $request): Response
    {
        $locale = app()->getLocale();
        $category = $request->query('category');

        $query = Article::published()->locale($locale)->latest('published_at');

        if ($category) {
            $query->where('category', $category);
        }

        $articles = $query->paginate(9)->withQueryString()->through(fn (Article $a) => $this->card($a));

        $categories = Article::published()->locale($locale)
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

    /** Public article detail by slug — published, matching the active locale. */
    public function show(Article $article)
    {
        abort_unless($article->isPublished(), 404);

        $locale = app()->getLocale();

        // The slug belongs to the other locale → send the reader to its correct URL.
        if ($article->locale !== $locale) {
            return redirect($this->articleUrl($article));
        }

        $related = Article::published()->locale($locale)
            ->where('id', '!=', $article->id)
            ->when($article->category, fn ($q) => $q->where('category', $article->category))
            ->latest('published_at')
            ->take(3)
            ->get()
            ->map(fn (Article $a) => $this->card($a));

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
                'published_at' => $article->published_at?->translatedFormat('M j, Y'),
                'published_at_iso' => $article->published_at?->toIso8601String(),
                'meta_title' => $article->meta_title ?: $article->title,
                'meta_description' => $article->meta_description ?: $article->excerpt,
            ],
            'related' => $related,
            // hreflang + language switcher target this article's translation when it exists.
            'alternates' => $this->articleAlternates($article),
        ]);
    }

    /** @return array<string, mixed> */
    private function card(Article $a): array
    {
        return [
            'title' => $a->title,
            'slug' => $a->slug,
            'category' => $a->category,
            'excerpt' => $a->excerpt,
            'cover_image' => $a->cover_image,
            'author' => $a->author,
            'read_minutes' => $a->readMinutes(),
            'published_at' => $a->published_at?->translatedFormat('M j, Y'),
        ];
    }

    /** @return array{en: string, ar: string} */
    private function articleAlternates(Article $article): array
    {
        $other = $article->locale === 'ar' ? 'en' : 'ar';
        $sibling = $article->translationIn($other);

        $alternates = ['en' => '', 'ar' => ''];
        $alternates[$article->locale] = $this->articleUrl($article);
        $alternates[$other] = $sibling ? $this->articleUrl($sibling) : $this->indexUrl($other);

        return $alternates;
    }

    private function articleUrl(Article $a): string
    {
        return $a->locale === 'ar' ? url("ar/articles/{$a->slug}") : url("articles/{$a->slug}");
    }

    private function indexUrl(string $locale): string
    {
        return $locale === 'ar' ? url('ar/articles') : url('articles');
    }
}
