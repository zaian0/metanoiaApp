<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $status = $request->query('status');

        $query = Product::query()->with('category')->ordered();

        if ($status && array_key_exists($status, Product::STATUSES)) {
            $query->where('status', $status);
        }

        $products = $query->paginate(15)->withQueryString()->through(fn (Product $p) => [
            'id' => $p->id,
            'name' => $p->name_en,
            'slug' => $p->slug,
            'category' => $p->category?->name_en,
            'status' => $p->status,
            'featured' => $p->featured,
            'image' => $p->images()->orderBy('sort_order')->first()?->path,
            'updated_at' => $p->updated_at->format('Y-m-d H:i'),
        ]);

        return Inertia::render('admin/Products', [
            'products' => $products,
            'filters' => ['status' => $status],
            'statuses' => Product::STATUSES,
            'total' => Product::count(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/ProductForm', [
            'product' => null,
            'categories' => $this->categoryOptions(),
            'statuses' => Product::STATUSES,
        ]);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($this->payload($request));
        $this->syncImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product): Response
    {
        $product->load('images');

        return Inertia::render('admin/ProductForm', [
            'product' => [
                'id' => $product->id,
                'product_category_id' => $product->product_category_id,
                'slug' => $product->slug,
                'name_en' => $product->name_en,
                'name_ar' => $product->name_ar,
                'summary_en' => $product->summary_en,
                'summary_ar' => $product->summary_ar,
                'description_en' => $product->description_en,
                'description_ar' => $product->description_ar,
                'tags' => collect($product->tags ?? [])->implode(', '),
                'specs' => $product->specs ?? [],
                'status' => $product->status,
                'featured' => $product->featured,
                'sort_order' => $product->sort_order,
                'images' => $product->images->map(fn ($i) => ['id' => $i->id, 'path' => $i->path])->all(),
            ],
            'categories' => $this->categoryOptions(),
            'statuses' => Product::STATUSES,
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($this->payload($request, $product));
        $this->syncImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            $this->deleteFile($image->path);
        }
        $product->delete(); // cascades image rows

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    /** Add new uploads, remove flagged existing images. */
    private function syncImages(ProductRequest $request, Product $product): void
    {
        foreach ((array) $request->input('removed_images', []) as $id) {
            if ($image = $product->images()->find($id)) {
                $this->deleteFile($image->path);
                $image->delete();
            }
        }

        $next = (int) $product->images()->max('sort_order');
        foreach ((array) $request->file('images', []) as $file) {
            $product->images()->create([
                'path' => Storage::url($file->store('products', 'public')),
                'sort_order' => ++$next,
            ]);
        }
    }

    private function deleteFile(?string $url): void
    {
        if ($url && str_starts_with($url, '/storage/')) {
            Storage::disk('public')->delete(substr($url, strlen('/storage/')));
        }
    }

    /** @return array<string, mixed> */
    private function payload(ProductRequest $request, ?Product $product = null): array
    {
        $data = $request->validated();
        unset($data['images'], $data['removed_images']);

        $data['slug'] = ! empty($data['slug'])
            ? Product::uniqueSlug($data['slug'], $product?->id)
            : Product::uniqueSlug($data['name_en'], $product?->id);

        // Tags: comma-separated string → clean array.
        $data['tags'] = collect(explode(',', (string) ($data['tags'] ?? '')))
            ->map(fn ($t) => trim($t))->filter()->unique()->values()->all();

        // Specs: drop fully-empty rows.
        $data['specs'] = collect($data['specs'] ?? [])
            ->filter(fn ($s) => filled($s['label_en'] ?? null) || filled($s['label_ar'] ?? null) || filled($s['value'] ?? null))
            ->values()->all();

        $data['featured'] = $request->boolean('featured');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }

    private function categoryOptions()
    {
        return ProductCategory::ordered()->get()->map(fn (ProductCategory $c) => [
            'id' => $c->id,
            'name' => $c->name_en,
        ]);
    }
}
