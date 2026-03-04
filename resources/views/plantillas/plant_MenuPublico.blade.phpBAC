    <!--NAVBAR-->
<nav class="navbar navbar-expand-lg texto-nav fondo-nav" aria-label="Offcanvas navbar large">
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
                    <!-- ----- Inicio ----- -->
                    <li class="nav-item">
                        <a class="nav-link @if(request()->path() == '/') active @endif" href="/">
                            @if(session('locale')=='en')
                                Home
                            @elseif(session('locale')=='pt')
                                Home
                            @elseif(session('locale')=='es_mix_bj')
                                Nùú kíxáá ña
                            @else
                                Inicio
                            @endif
                        </a>
                    </li>
                    <!-- ----- Visita el Jardín ----- -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if(in_array(request()->path(),['recorridos','mapa'])) active @endif" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if(session('locale')=='en')
                                Visit the garden
                            @elseif(session('locale')=='pt')
                                Visite o Jardim
                            @elseif(session('locale')=='es_mix_bj')
                                Kixi ún kuni ún jardîn
                            @else
                                Visita el Jardín
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item @if(request()->path() == 'recorridos') active @endif" href="/recorridos">
                                @if(session('locale')=='en')
                                    Tours
                                @elseif(session('locale')=='pt')
                                    Passeios
                                @elseif(session('locale')=='es_mix_bj')
                                    Ña kuvi kèe ndó
                                @else
                                    Recorridos
                                @endif
                        </a></li>
                            <li><a class="dropdown-item @if(request()->path() == 'mapa') active @endif" href="/mapa">
                                @if(session('locale')=='en')
                                    Map
                                @elseif(session('locale')=='pt')
                                    Mapa
                                @elseif(session('locale')=='es_mix_bj')
                                    Ñá’à ñà nùú yó nùú íyo iin iin ñà’a
                                @else
                                    Mapa y atractivos
                                @endif
                        </a></li>
                        </ul>
                    </li>
                    <!-- ----- Conócenos ----- -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if(in_array(request()->path(),['historia','servicios','directorio','colaboradores'])) active @endif" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if(session('locale')=='en')
                                About us
                            @elseif(session('locale')=='pt')
                                Conheça-nos
                            @elseif(session('locale')=='es_mix_bj')
                                Conócenos
                            @else
                                Conócenos
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item @if(request()->path() == 'historia') active @endif" href="/historia">
                                @if(session('locale')=='en')
                                    History
                                @elseif(session('locale')=='pt')
                                    História
                                @elseif(session('locale')=='es_mix_bj')
                                    História
                                @else
                                    Historia
                                @endif
                            </a></li>
                            <li><a class="dropdown-item @if(request()->path() == 'servicios') active @endif" href="/servicios">
                                @if(session('locale')=='en')
                                    Services
                                @elseif(session('locale')=='pt')
                                    Serviços
                                @elseif(session('locale')=='es_mix_bj')
                                    Servicios
                                @else
                                    Servicios
                                @endif
                            </a></li>
                            <li><a class="dropdown-item @if(request()->path() == 'colecciones') active @endif" href="/colecciones">
                                @if(session('locale')=='en')
                                    Collections
                                @elseif(session('locale')=='pt')
                                    Coleções
                                @elseif(session('locale')=='es_mix_bj')
                                    Colecciones
                                @else
                                    Colecciones
                                @endif
                            </a></li>
                            <li><a class="dropdown-item @if(request()->path() == 'directorio') active @endif" href="/directorio">
                                @if(session('locale')=='en')
                                    Directory
                                @elseif(session('locale')=='pt')
                                    Diretório
                                @elseif(session('locale')=='es_mix_bj')
                                    Directorio
                                @else
                                    Directorio
                                @endif
                            </a></li>
                            <li><a class="dropdown-item @if(request()->path() == 'colaboradores') active @endif" href="/colaboradores">
                                @if(session('locale')=='en')
                                    Collaborators
                                @elseif(session('locale')=='pt')
                                    Colaboradores
                                @elseif(session('locale')=='es_mix_bj')
                                    Colaboradores
                                @else
                                    Colaborador@s
                                @endif
                            </a></li>
                        </ul>
                    </li>
                    {{-- <!-- ----- Educación ----- -->
                    <li class="nav-item">
                        <a class="nav-link @if(request()->path() == 'educacion') active @endif" href="/educacion">
                            @if(session('locale')=='en')
                                Education
                            @elseif(session('locale')=='pt')
                                Educação
                            @elseif(session('locale')=='es_mix_bj')
                                Educación
                            @else
                                Educación
                            @endif
                        </a>
                    </li> --}}
                    <!-- ----- Las especies ----- -->

                    <li class="nav-item">
                        <a class="nav-link @if(request()->path() == 'actividades') active @endif" href="/especies">
                            @if(session('locale')=='en')
                                The species
                            @elseif(session('locale')=='pt')
                                As espécies
                            @elseif(session('locale')=='es_mix_bj')
                                Las especies
                            @else
                                Las especies
                            @endif
                        </a>
                    </li>

                    <!-- ----- Eventos ----- -->
                    <li class="nav-item">
                        <a class="nav-link @if(request()->path() == 'actividades') active @endif" href="/actividades">
                            @if(session('locale')=='en')
                                Events
                            @elseif(session('locale')=='pt')
                                Eventos
                            @elseif(session('locale')=='es_mix_bj')
                                Eventos
                            @else
                                Eventos
                            @endif
                        </a>
                    </li>

                    <!-- ----- Home ----- -->

                    @if(auth()->user())
                        <li class="nav-item">
                            <a class="nav-link @if(request()->path() == 'baseDeDatos') active @endif" href="/baseDeDatos">
                                BD
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link @if(request()->path() == 'home') active @endif" href="/home">
                                @if(session('locale')=='en')
                                    System
                                @elseif(session('locale')=='pt')
                                    Sistema
                                @elseif(session('locale')=='es_mix_bj')
                                    Sistema
                                @else
                                    Sistema
                                @endif
                            </a>
                        </li>




                        <!-- ----- Salir ----- -->
                        <li class="nav-item">
                            <form action="{{route('logout')}}" method="post">
                                @csrf
                                <button type="submit" class="nolink btn" style="padding:0 20px; margin:0; font-size:20px;font-family: 'Roboto Condensed', sans-serif;">
                                    @if(session('locale')=='en')
                                        Out
                                    @elseif(session('locale')=='pt')
                                        Sair
                                    @elseif(session('locale')=='es_mix_bj')
                                        Salir
                                    @else
                                        Salir
                                    @endif
                                </button>
                            </form>
                        </li>
                    {{-- @else
                        <li class="nav-item">
                                <a class="nav-link @if(request()->path() == 'ingreso') active @endif" href="/ingreso">
                                    @if(session('locale')=='en')
                                        System
                                    @elseif(session('locale')=='pt')
                                        Sistema
                                    @elseif(session('locale')=='es_mix_bj')
                                        Sistema
                                    @else
                                        Sistema
                                    @endif
                                </a>
                        </li> --}}
                    @endif


                </ul>

                <div class="col iconos-nav">
                    <a href="https://www.facebook.com/jardinoaxaca" target="_blank">
                        <img src="/imagenes/icono-facebook.png" alt="icono facebook">
                    </a>
                    <a href="https://www.instagram.com/jardinetnobotanicodeoaxaca/" target="_blank">
                        <img src="/imagenes/icono-instagram.png" alt="icono instagram ">
                    </a>
                    <a href="https://goo.gl/maps/vdvcHAUMTHQaDZ676" target="_blank">
                        <img src="/imagenes/icono-mapa.png" alt="icono mapa">
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

