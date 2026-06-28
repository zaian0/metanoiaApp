@php use App\Models\QuoteRequest; @endphp
<x-mail::message>
# New quote request

A new quotation request was submitted on the website.

**Contact**
- Name: {{ $quote->salutation }} {{ $quote->name }}
- Phone / WhatsApp: {{ $quote->phone }}
- Email: {{ $quote->email ?: '—' }}
- Company: {{ $quote->company ?: '—' }}

**Business**
- Segment: {{ QuoteRequest::SEGMENTS[$quote->segment] ?? $quote->segment }}
- Location: {{ $quote->location }}

**Request**
- Service: {{ QuoteRequest::SERVICES[$quote->service] ?? $quote->service }}
- System type: {{ $quote->system_type ? (QuoteRequest::SYSTEM_TYPES[$quote->system_type] ?? $quote->system_type) : '—' }}
- Monthly bill: {{ $quote->monthly_bill ? (QuoteRequest::MONTHLY_BILLS[$quote->monthly_bill] ?? $quote->monthly_bill) : '—' }}
- Timeline: {{ $quote->timeline ? (QuoteRequest::TIMELINES[$quote->timeline] ?? $quote->timeline) : '—' }}
- Preferred contact: {{ $quote->preferred_contact ? (QuoteRequest::CONTACT_METHODS[$quote->preferred_contact] ?? $quote->preferred_contact) : '—' }}

@if($quote->details)
**Details**

{{ $quote->details }}
@endif

<x-mail::button :url="route('admin.quotes.show', $quote)">
Open in dashboard
</x-mail::button>

Submitted {{ $quote->created_at->format('Y-m-d H:i') }} · IP {{ $quote->ip }}
</x-mail::message>
