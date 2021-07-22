<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') · {{ config('app.name') }} OPDS
        @else
            {{ config('app.name') }} OPDS
        @endif
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Handlee&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @yield('style')
</head>

<body class="font-sans antialiased relative {{ config('app.env') === 'local' ? 'debug-screens' : '' }}">
    @include('components.blocks.hero', ['route' => 'opds.index', 'title' => 'Bookshelves OPDS', 'text' => 'Open
    Publication Distribution System'])
    <nav>
        <table class="mx-auto" cellpadding="20px" cellspacing="0" height="100%" class="table-fixed">
            <tbody>
                <tr>
                    <td class="text-xl font-semibold">
                        <a href="{{ route('opds', ['version' => 'v1.2']) }}">
                            v1.2
                        </a>
                    </td>
                    <td class="text-xl font-semibold">
                        <a href="{{ route('catalog.index') }}">
                            Catalog
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </nav>
    <div class="max-w-5xl p-5 mx-auto">
        @yield('content')
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>

</html>
