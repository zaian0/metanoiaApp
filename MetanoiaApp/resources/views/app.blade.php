<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Title + per-page meta are injected by Inertia via @inertiaHead (SSR), driven by each page's <Head>. --}}

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        {{-- Metanoia brand fonts: Outfit (display) + Inter (body) + Tajawal (Arabic, future) --}}
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|outfit:400,500,600,700,800|tajawal:400,500,700" rel="stylesheet" />

        <link rel="icon" type="image/png" href="/brand/sun.png" />

        @routes
        @vite(['resources/js/app.ts'])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
