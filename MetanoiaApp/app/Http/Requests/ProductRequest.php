<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $id = $this->route('product')?->id;

        return [
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'slug' => [
                'nullable', 'string', 'max:220', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('products', 'slug')->ignore($id),
            ],
            'name_en' => ['required', 'string', 'max:200'],
            'name_ar' => ['nullable', 'string', 'max:200'],
            'summary_en' => ['nullable', 'string', 'max:500'],
            'summary_ar' => ['nullable', 'string', 'max:500'],
            'description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],

            'tags' => ['nullable', 'string', 'max:500'], // comma-separated; split in the controller

            'specs' => ['nullable', 'array'],
            'specs.*.label_en' => ['nullable', 'string', 'max:120'],
            'specs.*.label_ar' => ['nullable', 'string', 'max:120'],
            'specs.*.value' => ['nullable', 'string', 'max:200'],

            'status' => ['required', Rule::in(array_keys(Product::STATUSES))],
            'featured' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],

            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
            'removed_images' => ['nullable', 'array'],
            'removed_images.*' => ['integer'],
        ];
    }
}
