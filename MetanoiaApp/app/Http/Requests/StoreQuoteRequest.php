<?php

namespace App\Http\Requests;

use App\Models\QuoteRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // public form
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'salutation' => ['nullable', Rule::in(QuoteRequest::SALUTATIONS)],
            'name' => ['required', 'string', 'max:120'],
            'phone' => ['required', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:160'],
            'company' => ['nullable', 'string', 'max:160'],

            'segment' => ['required', Rule::in(array_keys(QuoteRequest::SEGMENTS))],
            'location' => ['required', 'string', 'max:120'],

            'service' => ['required', Rule::in(array_keys(QuoteRequest::SERVICES))],
            'system_type' => ['nullable', Rule::in(array_keys(QuoteRequest::SYSTEM_TYPES))],
            'monthly_bill' => ['nullable', Rule::in(array_keys(QuoteRequest::MONTHLY_BILLS))],
            'timeline' => ['nullable', Rule::in(array_keys(QuoteRequest::TIMELINES))],
            'preferred_contact' => ['nullable', Rule::in(array_keys(QuoteRequest::CONTACT_METHODS))],
            'details' => ['nullable', 'string', 'max:4000'],

            // honeypot — must stay empty
            'website' => ['nullable', 'max:0'],
        ];
    }

    public function messages(): array
    {
        return ['website.max' => 'Spam detected.'];
    }
}
