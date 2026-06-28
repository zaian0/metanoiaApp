@php use App\Models\QuoteRequest; @endphp
<x-mail::message>
# Thank you, {{ trim(($quote->salutation ? $quote->salutation.' ' : '').$quote->name) }}

We've received your request for a solar quotation. Our team is reviewing it and will get back to you shortly — usually within one business day.

<x-mail::panel>
**Your request**

- **Segment:** {{ QuoteRequest::SEGMENTS[$quote->segment] ?? $quote->segment }}
- **Service:** {{ QuoteRequest::SERVICES[$quote->service] ?? $quote->service }}
- **Location:** {{ $quote->location }}
@if($quote->system_type)
- **System type:** {{ QuoteRequest::SYSTEM_TYPES[$quote->system_type] ?? $quote->system_type }}
@endif
</x-mail::panel>

Prefer to talk now? Message us on WhatsApp and mention your name — we'll pick up from there.

<x-mail::button :url="'https://wa.me/201037444473'" color="success">
Chat with us on WhatsApp
</x-mail::button>

You can also reach us at **01037444473** or **info@metanoiaenergy.com**.

_Think Beyond Energy,_<br>
**The Metanoia Energy team**
</x-mail::message>
