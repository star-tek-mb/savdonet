<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <script src="{{ asset('js/pace.min.js') }}"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pace.min.css') }}" rel="stylesheet">
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
            <nav class="navbar navbar-dark bg-primary">
                <div class="container">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        {{ config('app.name') }}
                    </a>
                    <div class="navbar-nav ml-auto">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle text-white" type="button" id="languageMenu"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ config('app.locale') }}
                            </button>
                            <div class="position-absolute dropdown-menu" aria-labelledby="languageMenu">
                                @foreach (config('app.locales') as $locale)
                                <a class="text-decoration-uppercase dropdown-item"
                                    href="/{{ $locale }}">{{ __($locale) }}</a>
                                @endforeach
                            </div>
                        </div>
                        <a class="btn" href="{{ route('cart.index') }}">
                            <span class="badge badge-danger badge-pill">@if (session('cart'))
                                {{ count(session('cart')) }} @else 0 @endif</span>
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                        <button class="btn" type="button" data-toggle="collapse" data-target="#searchContent"
                            aria-controls="searchContent" aria-expanded="false" aria-label="Toggle search">
                            <i class="fas fa-search"></i>
                        </button>
                        <button class="btn" onclick="event.preventDefault(); $('#sidebar-wrapper').trigger('toggled');">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>

                </div>
            </nav>
            <form action="{{ route('search') }}" method="GET" class="collapse mt-4 @if (isset($results)) show @endif"
                id="searchContent">
                <div class="container">
                    <input name="q" class="form-control" type="search" placeholder="{{ __('Search') }}"
                        aria-label="Search" value="{{ old('q') }}">
                    <button class="d-none" type="submit">{{ __('Search') }}</button>
                </div>
            </form>

            <main class="py-4">
                @if (Route::currentRouteName() != 'home')
                <nav class="container" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                        @include('layouts.breadcrumb-category')
                        @include('layouts.breadcrumb-product')
                        @if (!in_array(Route::currentRouteName(), ['category.show', 'product.show']))
                        <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                        @endif
                    </ol>
                </nav>
                @endif
                @yield('content')
            </main>
        </div>
        <footer class="navbar bg-dark text-light">
            Copyright
        </footer>
    </div>
    @stack('js')
</body>

</html>