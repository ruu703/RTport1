<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>match - エンジニア案件マッチングサービス @yield('title', 'TOPページ')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
    <body>
        <div>
            <header class="l-header">
                @include('layouts.header')
            </header>
            <main class="l-main"  id="app">
                @yield('content')
            </main>
            <footer class="l-footer" id="footer">
                @include('layouts.footer')
            </footer>
        </div>
    </body>
</html>
