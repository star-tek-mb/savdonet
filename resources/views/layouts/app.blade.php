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
    <div id="app">
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
                @foreach ($pages as $page)
                <li><a href="{{ route('page', $page->slug) }}">{{ $page->title }}</a></li>
                @endforeach
            </ul>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-dark bg-primary px-0">
                <div class="container">
                    <a class="navbar-brand mr-0" href="{{ route('home') }}">{{ config('app.name') }}</a>
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
            <div style="flex-grow:1"></div>
            <div class="px-2 py-4 bg-dark text-light">
                <div class="row container mx-auto">
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2 text-center">
                        <ul class="list-group">
                            <li class="nav-link p-0"><b>{{ __('Shop') }}</b></li>
                            @foreach ($pages as $page)
                            <li class="nav-link p-0"><a href="{{ route('page', $page->slug) }}"
                                    class="text-light">{{ $page->title }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2 text-center">
                        <b>{{ __('Contacts') }}</b>:<br> +998 99 410 11 18
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2 text-center">
                        <b>{{ __('Subscribe to Us') }}</b><br>
                        <a class="p-1 fab fa-facebook text-light h4"></a>
                        <a class="p-1 fab fa-telegram text-light h4"></a>
                        <a class="p-1 fab fa-instagram text-light h4"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stack('js')
</body>

</html>