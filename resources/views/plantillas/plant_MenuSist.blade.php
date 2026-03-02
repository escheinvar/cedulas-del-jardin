<nav class="navbar navbar-expand-md texto-nav fondo-nav" aria-label="Offcanvas navbar large">
    <div class="container-fluid px-4 py-1" id="header">

        <!--Logo-->
        <a class="navbar-brand p-0 ms-3" href="/">
            <img src="/imagenes/logo-nav.png" alt="logo del Jardín Etnobotánico" style="width:90px;">
        </a>

        <!--botón hamburguesa-->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
        </button>

        <!--Menú superior   -->
        <div class="offcanvas offcanvas-end text-bg-light" tabindex="-1" id="offcanvasNavbar2"
            aria-labelledby="offcanvasNavbar2Label">
            <div class="offcanvas-header">
                <a class="offcanvas-logo" href="index.html" id="offcanvasNavbar2Label">
                   <img src="/imagenes/logo-nav.png" alt="logo del Jardín Etnobotánico">
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->path() == '/') active @endif" href="/">ir->Web</a>
                    </li>


                    <li class="nav-item">
                    <a class="nav-link @if(request()->path() == 'actividades') active @endif" href="/especies">
                        Ir->Las especies
                    </a>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->path() == 'baseDeDatos') active @endif" href="/baseDeDatos">
                            BD
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link @if(request()->path() == 'home') active @endif" href="/home">
                            Home
                        </a>
                    </li>
                    <!--dropdown 1-->
                    @if(in_array('admin',session('rol')))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle @if(in_array(request()->path(),['recorridos','mapa'])) active @endif" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Admin
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item @if(request()->path() == 'usuarios') active @endif" href="/usuarios">Usuarios y roles</a></li>
                                <li><a class="dropdown-item @if(request()->path() == 'catalogo/campus') active @endif" href="/catalogo/campus">Catálogo de Jardines y Campus</a></li>
                            </ul>
                        </li>
                    @endif

                    <!--dropdown 1-->

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if(in_array(request()->path(),['recorridos','mapa'])) active @endif" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Cédulas
                        </a>
                        @if(in_array('cedulas',session('rol')) or in_array('traduce',session('rol')))
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item @if(request()->path() == 'catCedulas') active @endif" href="/catCedulas">Catálogo de Cédulas</a></li>
                                {{-- <li><a class="dropdown-item @if(request()->path() == 'especies') active @endif" href="/especies">Especies del jardín</a></li> --}}
                                {{-- <li><a class="dropdown-item @if(request()->path() == 'especiesixmx') active @endif" href="/especiesixmx">Especies de IxMx</a></li> --}}
                            </ul>
                        @endif
                    </li>
                </li>

                    <!--dropdown 1-->
                    {{-- <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if(in_array(request()->path(),['recorridos','mapa'])) active @endif" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Ejemplos
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item @if(request()->path() == 'elmapa') active @endif" href="/elmapa">Mapa</a></li>
                            <li><a class="dropdown-item @if(request()->path() == 'laespecie') active @endif" href="/laespecie">Especie</a></li>
                            <li><a class="dropdown-item @if(request()->path() == 'elclavo/busca') active @endif" href="/elclavo/busca">Clavo</a></li>
                        </ul>
                    </li> --}}

                     <li class="nav-item">
                        <a class="nav-link @if(request()->path() == 'acercade') active @endif" href="/acercade">
                            Info
                        </a>

                    </li>


                    {{-- <li class="nav-item">
                        <a class="nav-link @if(request()->path() == 'elclavo') active @endif" href="/elclavo/busca">
                            Clavo
                        </a>
                    </li> --}}


                    <!---->
                    <li class="nav-item">
                        @if(auth()->user())
                            <form action="{{route('logout')}}" method="post">
                                @csrf
                                <button type="submit" class="nolink btn" style="padding:0;margin:0;">
                                        Salir
                                </button>
                            </form>
                        @else
                            <a class="nav-link @if(request()->path() == 'ingreso') active @endif" href="/ingreso">Ingresar</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
