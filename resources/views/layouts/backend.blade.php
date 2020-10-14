<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ config('app.name') }}</title>
    <script src="{{ asset('js/pace.min.js') }}"></script>
    <script src="{{ asset('js/backend.js') }}"></script>
    @stack('js')
    <link href="{{ asset('css/backend.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pace.min.css') }}" rel="stylesheet">
    @stack('css')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link">{{ __('Go to Shop') }}</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="/" class="brand-link">
                <img src="/favicon.ico" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim(Auth::user()->email))) }}?s=128"
                            alt="User Avatar" class="img-size-50 mr-3 img-circle">
                    </div>
                    <div class="info">
                        <a class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column">
                        <li class="nav-item">
                            <a href="{{ route('backend.dashboard') }}"
                                class="nav-link {{ Route::currentRouteName() == 'backend.dashboard' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>{{ __('Dashboard') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.categories.index') }}"
                                class="nav-link {{ strpos(Route::currentRouteName(), 'backend.categories') !== false ? 'active' : '' }}">
                                <i class="nav-icon fas fa-folder"></i>
                                <p>{{ __('Categories') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.options.index') }}"
                                class="nav-link {{ Route::currentRouteName() == 'backend.options.index' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>{{ __('Options') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.products.index') }}"
                                class="nav-link {{ (Route::currentRouteName() == 'backend.products.index' || Route::currentRouteName() == 'backend.products.edit') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tshirt"></i>
                                <p>{{ __('Products') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.products.create.single') }}"
                                class="nav-link {{ Route::currentRouteName() == 'backend.products.create.single' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>{{ __('Add Single Product') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.products.create.variable') }}"
                                class="nav-link {{ Route::currentRouteName() == 'backend.products.create.variable' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plus"></i>
                                <p>{{ __('Add Variable Product') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.orders.index') }}"
                                class="nav-link {{ Route::currentRouteName() == 'backend.orders.index' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>{{ __('Orders') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.suppliers.index') }}"
                                class="nav-link {{ strpos(Route::currentRouteName(), 'backend.suppliers') !== false ? 'active' : '' }}">
                                <i class="nav-icon fas fa-industry"></i>
                                <p>{{ __('Suppliers') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('backend.settings') }}"
                                class="nav-link {{ Route::currentRouteName() == 'backend.settings' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-cog"></i>
                                <p>{{ __('Settings') }}</p>
                            </a>
                        </li>
                    </ul>
                </nav>

            </div>

        </aside>

        <div class="content-wrapper">

            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">@yield('title') </h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content">
                @yield('content')
            </div>
        </div>

        <aside class="control-sidebar control-sidebar-dark">
            @yield('sidebar')
        </aside>

        <footer class="main-footer">
            Copyright <strong>star-tek-mb</strong>. All rights
            reserved.
        </footer>
    </div>

</body>

</html>