<?php

use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuoteController as AdminQuoteController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\QuoteController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// --- Public marketing site (bilingual: English at root, Arabic under /ar) ---
// Registered twice: unprefixed (English) and under /ar (Arabic, names prefixed "ar.").
$publicRoutes = function () {
    Route::get('/', fn () => Inertia::render('public/Home'))->name('home');
    Route::get('about', fn () => Inertia::render('public/About'))->name('about');
    Route::get('contact', fn () => Inertia::render('public/Contact'))->name('contact');

    // Articles / blog
    Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('articles/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

    // Request a quote
    Route::get('quote', [QuoteController::class, 'create'])->name('quote.create');
    Route::post('quote', [QuoteController::class, 'store'])
        ->middleware('throttle:10,1')->name('quote.store');
};

Route::middleware(SetLocale::class)->group($publicRoutes);                          // English (root)
Route::prefix('ar')->name('ar.')->middleware(SetLocale::class)->group($publicRoutes); // Arabic (/ar)

// --- Admin (auth-gated) ---
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('dashboard')->name('admin.')->group(function () {
        Route::get('quotes', [AdminQuoteController::class, 'index'])->name('quotes.index');
        Route::get('quotes/{quote}', [AdminQuoteController::class, 'show'])->name('quotes.show');
        Route::patch('quotes/{quote}/status', [AdminQuoteController::class, 'updateStatus'])->name('quotes.status');

        Route::resource('articles', AdminArticleController::class)->except('show');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
