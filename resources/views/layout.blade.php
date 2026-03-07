<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Styles / Scripts -->
        @vite('resources/css/styles.css')
    </head>
    <body>
        <div class="layout">
            @include('header')
            <main class="main">@yield('main')</main>
        </div>
    
    @yield('scripts')
    </body>
</html>