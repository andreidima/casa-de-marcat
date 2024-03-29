<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/andrei.css') }}" rel="stylesheet">

    <!-- Font Awesome links -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        @auth
        <nav class="navbar navbar-expand-md navbar-dark shadow py-0" style="background-color:darkcyan">
            <div class="container">
                <a href='/'>
                    <img src="{{ asset('images/cropped-gsmobile-logo-red.jpg') }}" height="40"
                        class="mr-4 border border-10 border-dark rounded-pill"
                    >
                </a>
                {{-- <a class="navbar-brand mr-4" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a> --}}
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        {{-- <li class="nav-item active mr-4">
                            <a class="nav-link" href="/produse">
                                <i class="fas fa-list-ul mr-1"></i>Produse
                            </a>
                        </li>
                        <li class="nav-item active mr-4">
                            <a class="nav-link" href="/produse/gestiune">
                                <i class="fas fa-list-ul mr-1"></i>Gestiune
                            </a>
                        </li> --}}
                        <li class="nav-item dropdown active mr-4">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-list-ul mr-1"></i>Produse
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/produse">
                                    <i class="fas fa-list-ul mr-1"></i>Produse
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/suplimenteaza-stocuri/adauga">
                                    <i class="fas fa-cart-plus mr-1"></i>Suplimentează stocuri
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/produse/gestiune">
                                    <i class="fas fa-warehouse mr-1"></i>Gestiune
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/furnizori">
                                    <i class="fas fa-store mr-1"></i>Furnizori
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/produse-stocuri">
                                    <i class="fas fa-list-ul mr-1"></i>Produse - stocuri
                                </a>
                                <div class="dropdown-divider"></div>
                                {{-- <a class="dropdown-item dropdown-toggle" href="#" id="nir" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-truck-loading mr-1"></i>Nir
                                </a>
                                    <div class="dropdown-menu" aria-labelledby="nir"
                                        style="
                                            top: 74%;
                                            left: 100%;
                                            "
                                    >
                                        <a class="dropdown-item" href="/niruri/produse-stocuri-fara-nir">
                                            <i class="fas fa-truck-loading mr-1"></i>Produse fără nir
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="/niruri">
                                            <i class="fas fa-truck-loading mr-1"></i>Listă niruri
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="/niruri/export">
                                            <i class="fas fa-truck-loading mr-1"></i>Export PDF
                                        </a>
                                    </div>                                     --}}
                                <a class="dropdown-item" href="/niruri/produse-stocuri-fara-nir">
                                    <i class="fas fa-truck-loading mr-1"></i>Produse fără nir
                                </a>
                                <a class="dropdown-item" href="/niruri">
                                    <i class="fas fa-truck-loading mr-1"></i>Listă niruri
                                </a>
                                <a class="dropdown-item" href="/niruri/export">
                                    <i class="fas fa-truck-loading mr-1"></i>Export PDF
                                </a>
                                {{-- <a class="dropdown-item" href="nir/produse-stocuri-fara-nir">
                                    <i class="fas fa-truck-loading mr-1"></i>Nir
                                </a> --}}
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/produse-inventar-verificare">
                                    <i class="fas fa-boxes mr-1"></i>Produse inventar
                                </a>
                                <a class="dropdown-item" href="/produse-inventar-verificare/produse-lipsa">
                                    <i class="fas fa-boxes mr-1"></i>Produse lipsă
                                </a>
                                <a class="dropdown-item" href="/produse-inventar-verificare/lista-inventar/lista-inventar-html">
                                    <i class="fas fa-boxes mr-1"></i>Export PDF
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="produse/rapoarte/export-saga/html">
                                    <i class="fas fa-boxes mr-1"></i>Export SAGA
                                </a>
                            </div>
                        </li>
                        <li class="nav-item active mr-4">
                            <a class="nav-link" href="/produse/vanzari">
                                <i class="fas fa-shopping-cart mr-1"></i>Vânzări
                            </a>
                        </li>

                        <li class="nav-item dropdown active mr-4">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-dollar-sign mr-1"></i>Tranzacții
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/avansuri">
                                    <i class="fas fa-hand-holding-usd mr-1"></i>Avansuri
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/plati">
                                    <i class="fas fa-money-bill-wave mr-1"></i></i>Plăți
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/casa">
                                    <i class="fas fa-wallet mr-1"></i></i>Casa
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown active mr-4">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-users mr-1"></i>Clienți
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/clienti">
                                    <i class="fas fa-users mr-1"></i>Clienți
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/facturi">
                                    <i class="fas fa-file-invoice mr-1"></i></i>Facturi
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown active mr-4">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-file-pdf mr-1"></i>Rapoarte
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/produse-vandute">
                                    <i class="fas fa-list-ul mr-1"></i>Produse vândute
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/produse-vandute/rapoarte/raport-zilnic">
                                    <i class="fas fa-file-pdf mr-1"></i>Raport zilnic
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/raport-gestiune-accesorii">
                                    <i class="fas fa-file-pdf mr-1"></i>Raport gestiune accesorii
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/rapoarte/miscari-stocuri">
                                    <i class="fas fa-people-carry mr-1"></i>Mișcări stocuri
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/rapoarte/miscari-produs">
                                    <i class="fas fa-box mr-1"></i>Mișcări produs
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/produse/rapoarte/lista-inventar/lista-inventar-html" target="_blank">
                                    <i class="fas fa-file-pdf mr-1"></i>Listă inventar
                                </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown active mr-4">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-tools mr-1"></i>Lucrări
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/lucrari/vizualizare">
                                    Vizualizare
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/lucrari">
                                    Administrare
                                </a>
                            </div>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @endauth

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
