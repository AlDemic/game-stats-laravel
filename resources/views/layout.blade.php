<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>

        <!-- Styles / Scripts -->
        @vite('resources/css/styles.css')
        @vite('resources/js/header.js')
    </head>
    <body>
        <div class="layout">
            <header class='header'>
                <nav class='nav'></nav>
                <div class='header__title'>
                    <h1 class='header__title'><a href='/'>Game Stats</a></h1>
                </div>
                <div class="logo__pic"></div>
            </header>
            <main class="main">@yield('main')</main>
        </div>
    
    @yield('scripts')
    </body>
</html>