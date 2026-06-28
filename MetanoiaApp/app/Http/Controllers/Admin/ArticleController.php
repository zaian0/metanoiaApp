<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
            'locale' => $a->locale,
            'category' => $a->category,
            'status' => $a->status,
            'published_at' => $a->published_at?->format('Y-m-d'),
            'updated_at' => $a->updated_at->format('Y-m-d H:i'),
        ]);

        return Inertia::render('admin/Articles', [
            'articles' => $articles,
            'filters' => ['status' => $status],
            'statuses' => Article::STATUSES,
            'locales' => Article::LOCALES,
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
            'locales' => Article::LOCALES,
            'linkable' => $this->linkable(),
        ]);
    }

    public function store(ArticleRequest $request)
    {
        Article::create($this->payload($request));

        return redirect()->route('admin.articles.index')->with('success', 'Article created.');
    }

    public function edit(Article $article): Response
    {
        // Pre-select the existing translation in the other locale, if linked.
        $otherLocale = $article->locale === 'ar' ? 'en' : 'ar';
        $sibling = $article->group_id
            ? Article::where('group_id', $article->group_id)->where('id', '!=', $article->id)->where('locale', $otherLocale)->first()
            : null;

        return Inertia::render('admin/ArticleForm', [
            'article' => [
                'id' => $article->id,
                'locale' => $article->locale,
                'translate_of' => $sibling?->id,
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
            'locales' => Article::LOCALES,
            'linkable' => $this->linkable($article->id),
        ]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->update($this->payload($request, $article));

        return redirect()->route('admin.articles.index')->with('success', 'Article updated.');
    }

    public function destroy(Article $article)
    {
        $this->deleteCover($article->cover_image);
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article deleted.');
    }

    /** Articles that can be linked as a translation (id, title, locale). */
    private function linkable(?int $exceptId = null): \Illuminate\Support\Collection
    {
        return Article::query()
            ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
            ->orderByDesc('updated_at')
            ->get(['id', 'title', 'locale', 'group_id'])
            ->map(fn (Article $a) => ['id' => $a->id, 'title' => $a->title, 'locale' => $a->locale, 'group_id' => $a->group_id]);
    }

    /** Delete a previously uploaded cover image from the public disk. */
    private function deleteCover(?string $url): void
    {
        if ($url && str_starts_with($url, '/storage/')) {
            Storage::disk('public')->delete(substr($url, strlen('/storage/')));
        }
    }

    /** Normalize input: auto-slug, default publish date/author, and resolve the translation group. */
    private function payload(ArticleRequest $request, ?Article $article = null): array
    {
        $data = $request->validated();

        // Cover image: store a new upload, clear it, or leave the existing one untouched.
        unset($data['cover'], $data['remove_cover']);
        if ($file = $request->file('cover')) {
            $this->deleteCover($article?->cover_image);
            $data['cover_image'] = Storage::url($file->store('articles', 'public'));
        } elseif ($request->boolean('remove_cover')) {
            $this->deleteCover($article?->cover_image);
            $data['cover_image'] = null;
        }

        $data['slug'] = ! empty($data['slug'])
            ? Article::uniqueSlug($data['slug'], $article?->id)
            : Article::uniqueSlug($data['title'], $article?->id);

        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $data['author'] = $data['author'] ?: 'Metanoia Energy';

        // Resolve the translation group: link to the chosen article's group, keep the
        // current one on edit, or start a fresh group for a brand-new article.
        $translateOf = $data['translate_of'] ?? null;
        unset($data['translate_of']);

        if ($translateOf && ($target = Article::find($translateOf))) {
            $data['group_id'] = $target->group_id ?: (string) Str::uuid();
        } else {
            $data['group_id'] = $article?->group_id ?: (string) Str::uuid();
        }

        return $data;
    }
}
