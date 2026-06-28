<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductCategory;
use Inertia\Inertia;
use Inertia\Response;

class ProductCategoryController extends Controller
{
    public function index(): Response
    {
        $categories = ProductCategory::ordered()->withCount('products')->get()->map(fn (ProductCategory $c) => [
            'id' => $c->id,
            'name_en' => $c->name_en,
            'name_ar' => $c->name_ar,
            'slug' => $c->slug,
            'icon' => $c->icon,
            'sort_order' => $c->sort_order,
            'products_count' => $c->products_count,
        ]);

        return Inertia::render('admin/ProductCategories', [
            'categories' => $categories,
            'icons' => ProductCategory::ICONS,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/ProductCategoryForm', [
            'category' => null,
            'icons' => ProductCategory::ICONS,
        ]);
    }

    public function store(ProductCategoryRequest $request)
    {
        ProductCategory::create($this->payload($request));

        return redirect()->route('admin.product-categories.index')->with('success', 'Category created.');
    }

    public function edit(ProductCategory $productCategory): Response
    {
        return Inertia::render('admin/ProductCategoryForm', [
            'category' => $productCategory->only(['id', 'name_en', 'name_ar', 'slug', 'icon', 'sort_order']),
            'icons' => ProductCategory::ICONS,
        ]);
    }

    public function update(ProductCategoryRequest $request, ProductCategory $productCategory)
    {
        $productCategory->update($this->payload($request, $productCategory));

        return redirect()->route('admin.product-categories.index')->with('success', 'Category updated.');
    }

    public function destroy(ProductCategory $productCategory)
    {
        if ($productCategory->products()->exists()) {
            return back()->with('error', 'Move or delete this category\'s products before deleting it.');
        }

        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')->with('success', 'Category deleted.');
    }

    /** @return array<string, mixed> */
    private function payload(ProductCategoryRequest $request, ?ProductCategory $category = null): array
    {
        $data = $request->validated();

        $data['slug'] = ! empty($data['slug'])
            ? ProductCategory::uniqueSlug($data['slug'], $category?->id)
            : ProductCategory::uniqueSlug($data['name_en'], $category?->id);

        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
