<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = [
        'locale', 'group_id',
        'title', 'slug', 'category', 'excerpt', 'body',
        'cover_image', 'author',
        'meta_title', 'meta_description',
        'status', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public const STATUSES = [
        'draft' => 'Draft',
        'published' => 'Published',
    ];

    /** Locales an article can be authored in (keys match the public site locales). */
    public const LOCALES = [
        'en' => 'English',
        'ar' => 'Arabic',
    ];

    /** Suggested editorial categories (free-form; used as datalist hints). */
    public const CATEGORIES = [
        'Guides',
        'Industry',
        'Projects',
        'Company News',
        'Sustainability',
    ];

    /** Only published articles whose publish date has arrived. */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function isPublished(): bool
    {
        return $this->status === 'published'
            && $this->published_at !== null
            && $this->published_at->lessThanOrEqualTo(now());
    }

    /** Render the Markdown body to safe HTML for the public page. */
    public function renderedBody(): string
    {
        return Str::markdown($this->body ?? '', [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }

    /** Rough read time in minutes from the body word count. */
    public function readMinutes(): int
    {
        $words = str_word_count(strip_tags($this->body ?? ''));

        return max(1, (int) ceil($words / 200));
    }

    /** Build a unique slug from a title, ignoring an optional current id. */
    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'article';
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
