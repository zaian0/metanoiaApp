<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Mail\NewQuoteRequest;
use App\Mail\QuoteConfirmation;
use App\Models\QuoteRequest;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class QuoteController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('public/Quote', [
            'options' => QuoteRequest::options(),
        ]);
    }

    public function store(StoreQuoteRequest $request)
    {
        $quote = QuoteRequest::create([
            ...$request->safe()->except('website'),
            'status' => 'new',
            'source' => 'website',
            'ip' => $request->ip(),
        ]);

        // Notify the team.
        if ($notify = config('mail.quote_notify_to')) {
            Mail::to($notify)->send(new NewQuoteRequest($quote));
        }

        // Send the customer a branded confirmation (if they gave an email).
        if ($quote->email) {
            Mail::to($quote->email)->send(new QuoteConfirmation($quote));
        }

        return back()->with('success', 'Thanks — your request has been received. Our team will get back to you shortly.');
    }
}
