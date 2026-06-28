<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    /** Catalog landing — categories (with counts) + featured products. */
    public function index(): Response
    {
        $categories = ProductCategory::ordered()
            ->withCount(['products' => fn ($q) => $q->published()])
            ->get()
            ->map(fn (ProductCategory $c) => [
                'slug' => $c->slug,
                'name' => $c->localized('name'),
                'icon' => $c->icon,
                'count' => $c->products_count,
            ]);

        $featured = Product::published()->where('featured', true)->ordered()
            ->with(['category', 'images'])
            ->take(6)->get()
            ->map(fn (Product $p) => $this->card($p));

        return Inertia::render('public/Products', [
            'categories' => $categories,
            'featured' => $featured,
        ]);
    }

    /** Products within a category, with an optional tag filter. */
    public function category(Request $request, ProductCategory $category): Response
    {
        $tag = $request->query('tag');

        $products = $category->products()->published()->ordered()
            ->with('images')
            ->when($tag, fn ($q) => $q->whereJsonContains('tags', $tag))
            ->get()
            ->map(fn (Product $p) => $this->card($p, $category));

        // Tags present across this category's published products (for filter chips).
        $tags = $category->products()->published()->pluck('tags')
            ->flatten()->filter()->unique()->sort()->values();

        return Inertia::render('public/ProductCategory', [
            'category' => ['slug' => $category->slug, 'name' => $category->localized('name'), 'icon' => $category->icon],
            'products' => $products,
            'tags' => $tags,
            'filters' => ['tag' => $tag],
            'categories' => $this->categoryNav(),
        ]);
    }

    /** Product detail with gallery, specs, and related products. */
    public function show(ProductCategory $category, Product $product)
    {
        abort_unless($product->product_category_id === $category->id && $product->status === 'published', 404);

        $product->load('images', 'category');

        $related = Product::published()
            ->where('product_category_id', $category->id)
            ->where('id', '!=', $product->id)
            ->ordered()->with('images')->take(4)->get()
            ->map(fn (Product $p) => $this->card($p, $category));

        return Inertia::render('public/Product', [
            'product' => [
                'slug' => $product->slug,
                'name' => $product->localized('name'),
                'summary' => $product->localized('summary'),
                'description_html' => $product->renderedDescription(),
                'tags' => $product->tags ?? [],
                'specs' => $product->localizedSpecs(),
                'images' => $product->images->map(fn ($i) => ['path' => $i->path, 'alt' => $i->alt])->all(),
                'category' => ['slug' => $category->slug, 'name' => $category->localized('name')],
            ],
            'related' => $related,
        ]);
    }

    /** @return array<string, mixed> */
    private function card(Product $p, ?ProductCategory $category = null): array
    {
        $category ??= $p->category;

        return [
            'slug' => $p->slug,
            'name' => $p->localized('name'),
            'summary' => $p->localized('summary'),
            'tags' => $p->tags ?? [],
            'image' => $p->images->first()?->path,
            'category_slug' => $category?->slug,
            'category_name' => $category?->localized('name'),
        ];
    }

    /** Compact category list for in-page navigation. */
    private function categoryNav()
    {
        return ProductCategory::ordered()->get()->map(fn (ProductCategory $c) => [
            'slug' => $c->slug,
            'name' => $c->localized('name'),
            'icon' => $c->icon,
        ]);
    }
}
