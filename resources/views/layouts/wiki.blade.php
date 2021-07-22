<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') · {{ config('app.name') }} Wiki
        @else
            {{ config('app.name') }} Wiki
        @endif
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/markdown.css') }}">
    <link rel="stylesheet" href="{{ mix('css/code.css') }}">
    @yield('style')
</head>

<body class="font-sans antialiased markdown-body relative {{ config('app.env') === 'local' ? 'debug-screens' : '' }}">
    {{-- @include('components.layout.navbar') --}}
    <div id="top" class="container max-w-3xl p-5 mx-auto prose prose-lg">
        <div class="flex items-center justify-center mt-4 font-handlee">
            <img src="{{ asset('images/bookshelves.svg') }}" alt="Bookshelves" class="w-24">
            <div class="ml-4">
                <div class="text-4xl">
                    Bookshelves Wiki
                </div>
                <div class="text-sm">
                    Documentation about Bookshelves
                </div>
            </div>
        </div>
        <div class="mt-20">
            @yield('content')
        </div>
        <a href="#top"
            class="fixed bottom-5 right-5 z-10 hover:bg-gray-300 transition-colors duration-100 p-2 rounded-full bg-opacity-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
        </a>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>

</html>
