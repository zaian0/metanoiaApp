<?php

namespace App\Http\Requests;

use App\Models\Article;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null; // admin-only routes are auth-gated
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $articleId = $this->route('article')?->id;

        return [
            'locale' => ['required', Rule::in(array_keys(Article::LOCALES))],
            'translate_of' => ['nullable', 'integer', 'exists:articles,id'],
            'title' => ['required', 'string', 'max:200'],
            'slug' => [
                'nullable', 'string', 'max:220', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                Rule::unique('articles', 'slug')->ignore($articleId),
            ],
            'category' => ['nullable', 'string', 'max:60'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'string', 'max:500'],
            'author' => ['nullable', 'string', 'max:120'],
            'meta_title' => ['nullable', 'string', 'max:200'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'status' => ['required', Rule::in(array_keys(Article::STATUSES))],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'slug.regex' => 'The slug may only contain lowercase letters, numbers, and hyphens.',
        ];
    }
}
