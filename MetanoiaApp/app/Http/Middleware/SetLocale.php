<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /** Locales the public site is available in. First is the default (no URL prefix). */
    public const SUPPORTED = ['en', 'ar'];

    public const DEFAULT = 'en';

    public function handle(Request $request, Closure $next): Response
    {
        // Arabic lives under the /ar prefix; everything else is English.
        $locale = $request->segment(1) === 'ar' ? 'ar' : self::DEFAULT;

        app()->setLocale($locale);

        // hreflang + language-switch targets: toggle the locale prefix on the current path.
        // Rendered in PublicLayout's <Head>; article pages override this in their controller.
        Inertia::share('alternates', $this->alternates($request));

        return $next($request);
    }

    /**
     * Build the equivalent URL for each locale from the current path.
     *
     * @return array<string, string>
     */
    private function alternates(Request $request): array
    {
        $path = trim($request->path(), '/');                 // '', 'about', 'ar/about'
        $bare = preg_replace('#^ar(/|$)#', '', $path) ?? ''; // strip a leading ar segment
        $bare = trim($bare, '/');

        return [
            'en' => $bare === '' ? url('/') : url($bare),
            'ar' => $bare === '' ? url('ar') : url("ar/{$bare}"),
        ];
    }
}
