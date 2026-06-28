<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'total' => QuoteRequest::count(),
                'new' => QuoteRequest::where('status', 'new')->count(),
                'week' => QuoteRequest::where('created_at', '>=', now()->subWeek())->count(),
            ],
            'recent' => QuoteRequest::latest()->take(6)->get()->map(fn ($q) => [
                'id' => $q->id,
                'name' => $q->name,
                'segment' => QuoteRequest::SEGMENTS[$q->segment] ?? $q->segment,
                'service' => QuoteRequest::SERVICES[$q->service] ?? $q->service,
                'status' => $q->status,
                'created_at' => $q->created_at->diffForHumans(),
            ]),
            'statuses' => QuoteRequest::STATUSES,
        ]);
    }
}
