<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class QuoteController extends Controller
{
    public function index(Request $request): Response
    {
        $status = $request->query('status');

        $query = QuoteRequest::query()->latest();

        if ($status && array_key_exists($status, QuoteRequest::STATUSES)) {
            $query->where('status', $status);
        }

        $quotes = $query->paginate(15)->withQueryString()->through(fn ($q) => [
            'id' => $q->id,
            'name' => $q->name,
            'phone' => $q->phone,
            'segment' => QuoteRequest::SEGMENTS[$q->segment] ?? $q->segment,
            'service' => QuoteRequest::SERVICES[$q->service] ?? $q->service,
            'location' => $q->location,
            'status' => $q->status,
            'created_at' => $q->created_at->format('Y-m-d H:i'),
        ]);

        return Inertia::render('admin/Quotes', [
            'quotes' => $quotes,
            'filters' => ['status' => $status],
            'statuses' => QuoteRequest::STATUSES,
            'counts' => collect(QuoteRequest::STATUSES)->keys()->mapWithKeys(
                fn ($s) => [$s => QuoteRequest::where('status', $s)->count()]
            ),
            'total' => QuoteRequest::count(),
        ]);
    }

    public function show(QuoteRequest $quote): Response
    {
        return Inertia::render('admin/QuoteShow', [
            'quote' => $quote,
            'labels' => [
                'segment' => QuoteRequest::SEGMENTS,
                'service' => QuoteRequest::SERVICES,
                'system_type' => QuoteRequest::SYSTEM_TYPES,
                'monthly_bill' => QuoteRequest::MONTHLY_BILLS,
                'timeline' => QuoteRequest::TIMELINES,
                'preferred_contact' => QuoteRequest::CONTACT_METHODS,
            ],
            'statuses' => QuoteRequest::STATUSES,
            'whatsapp' => 'https://wa.me/2'.ltrim($quote->phone, '0'),
        ]);
    }

    public function updateStatus(Request $request, QuoteRequest $quote)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(QuoteRequest::STATUSES))],
        ]);

        $quote->update($data);

        return back()->with('success', 'Status updated.');
    }
}
