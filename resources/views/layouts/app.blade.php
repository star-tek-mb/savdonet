<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name') }}</title>
    @stack('js')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('css')
</head>

<body class="preload">
    <div id="app" class="d-flex">
        <div id="sidebar-wrapper">
            <div class="navbar-dark bg-primary text-light sidebar-heading sticky-top">{{ __('Menu') }}
                <button class="float-right close"
                    onclick="event.preventDefault(); $('#sidebar-wrapper').trigger('toggled');">
                        <i class="fas fa-times"></i>
                    </button>
            </div>
            <h5 class="text-center h4 py-2">{{ __('Categories') }}</h5>
            <ul class="sidebar-menu">
                @each('category-menu', $categories, 'category')
            </ul>
            <h5 class="text-center h4 py-2">{{ __('Shop') }}</h5>
            <ul class="sidebar-menu">
                <li><a href="#">Пользовательское соглашение</a></li>
                <li><a href="#">Доставка</a></li>
                <li><a href="#">О нас</a></li>
            </ul>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-md navbar-dark bg-primary">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name') }}
                    </a>
                    <div class="d-inline ml-auto clearfix">
                        <a class="btn" href="{{ route('cart.index') }}">
                            <span class="badge badge-danger badge-pill">@if (session('cart')) {{ count(session('cart')) }} @else 0 @endif</span>
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                        <button class="btn" onclick="event.preventDefault(); $('#sidebar-wrapper').trigger('toggled');">
                            <i class="fas fa-bars"></i>
                        </button>
                        <button class="btn" type="button" data-toggle="collapse" data-target="#searchContent" aria-controls="searchContent" aria-expanded="false" aria-label="Toggle search">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    
                </div>
            </nav>
            <form class="collapse mt-4" id="searchContent">
            <div class="container">
                <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                <button class="d-none" type="submit">Search</button></div>
            </form>

            <main class="py-4">
                @yield('content')
            </main>
        </div>
        <footer class="navbar bg-dark text-light">
            Copyright
        </footer>
    </div>
</body>

</html>