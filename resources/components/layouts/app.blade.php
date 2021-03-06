<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {!! SEO::generate() !!}

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">

    <script src="{{ asset('assets/js/color-mode.js') }}"></script>

    @livewireStyles

    @vite('front', 'app.ts', 3100)
    {{-- @production
        @dump('production')
    @else
        @dump('local')
    @endproduction --}}
</head>

<body class="antialiased bg-gray-900 min-h-screen {{ config('app.env') === 'local' ? 'debug-screens' : '' }}">
    <div class="flex flex-col min-h-screen m-0">
        {{ $slot }}
    </div>

    @livewireScripts
</body>

</html>
