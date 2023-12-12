<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TUFI Store') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts 1: vite de laravel; 2: iconos de botones; 3:mensaje de accion satisfactoria que desaparece 4: hover del carrito-->

        @vite([
            'resources/sass/app.scss',
            'resources/css/styles.css',
            'resources/js/app.js'
        ])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script type="text/javascript">

    $(document).ready(function () {

        $(".alert-dismissible").fadeTo(2000, 500).slideUp(500, function(){
            $(".alert-dismissible").alert('close');
        });

        $('[data-toggle="tooltip"]').tooltip({
            trigger : 'hover'
        });
    });
    </script>

    <script>
    $(document).ready(function() {
        // Hover para activar el dropdown en Bootstrap
        $('#navbarDropdownCart').parent('.dropdown').hover(
            function() {
                $(this).find('.dropdown-toggle').dropdown('toggle');
            },
            function() {
                $(this).find('.dropdown-toggle').dropdown('toggle');
            }
        );
    });
    </script>
    

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-custom shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                <img src="/img/LogoTufiStore.png" alt="Logo" style="height: 30px;">
                    {{ config('app.name', 'TUFI Store') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/*') ? 'active' : '' }}" href="{{ url('/') }}">Inicio</a>
                    </li>

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ route('checkout') }}" id="navbarDropdownCart" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-shopping-cart"></i>
                                <span class="badge bg-danger">{{ \Cart::count() }}</span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownCart">
                                <!-- Aquí irán los artículos del carrito -->
                                @foreach (Cart::content() as $item)
                                    <a class="dropdown-item" href="{{ route('articulos.show', $item->id) }}">
                                        <img src="{{ asset('/storage/' . $item->options->img) }}" width="30" height="30" class="rounded-circle">
                                        {{ $item->name }} - ${{ $item->price }}
                                    </a>
                                @endforeach
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-center" href="{{ route('checkout') }}">Ver Carrito</a>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('tienda*') ? 'active' : '' }}" href="{{ route('tiendas.index') }}">Tienda</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('nosotros') ? 'active' : '' }}" href="{{ route('nosotros') }}">Nosotros</a>
                        </li>


                        <!-- Links para usuarios autenticados y administradores -->
                        @auth
                            @if(Auth::user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('articulos*') ? 'active' : '' }}" aria-current="page" href="{{ route('articulos.index') }}">Artículos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('categorias*') ? 'active' : '' }}" href="{{ route('categorias.index') }}">Categorías</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('consulta*') ? 'active' : '' }}" href="{{ route('consultas.index') }}">Consultas</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('user*') ? 'active' : '' }}" href="{{ route('users.index') }}">Usuarios</a>
                                </li>
                            @endif

                            <!-- Cerrar Sesión -->
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endauth

                        <!-- Links para visitantes no autenticados -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                            </li>
                        @endguest

                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @yield('js')


</body>
</html>
