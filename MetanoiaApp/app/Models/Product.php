<?php

namespace App\Models;

use App\Models\Concerns\HasTranslatableFields;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasTranslatableFields;

    protected $fillable = [
        'product_category_id', 'slug',
        'name_en', 'name_ar', 'summary_en', 'summary_ar', 'description_en', 'description_ar',
        'tags', 'specs', 'status', 'featured', 'sort_order',
    ];

    protected $casts = [
        'tags' => 'array',
        'specs' => 'array',
        'featured' => 'boolean',
    ];

    public const STATUSES = [
        'draft' => 'Draft',
        'published' => 'Published',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->latest('id');
    }

    /** Render the current-locale Markdown description to safe HTML. */
    public function renderedDescription(): string
    {
        return Str::markdown($this->localized('description') ?? '', [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }

    /** Localized specs: [{label, value}] for the active locale. */
    public function localizedSpecs(): array
    {
        $locale = app()->getLocale();

        return collect($this->specs ?? [])->map(fn ($s) => [
            'label' => $s["label_{$locale}"] ?? $s['label_en'] ?? '',
            'value' => $s['value'] ?? '',
        ])->filter(fn ($s) => $s['label'] !== '' || $s['value'] !== '')->values()->all();
    }

    public static function uniqueSlug(string $value, ?int $ignoreId = null): string
    {
        $base = Str::slug($value) ?: 'product';
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }
}
