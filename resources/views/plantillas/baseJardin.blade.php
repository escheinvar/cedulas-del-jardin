<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- TITULO -->
    <title>@yield('title')</title>

    <!--META DESCRIPCIÓN-->
    <meta name="description" content="@yield('meta-description')">

    <!--FAVICON-->
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">



<!-- Editor -->
 <!-- include libraries(jQuery, bootstrap) -->
    {{-- <script type="text/javascript" src="//code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
    <script type="text/javascript" src="cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> --}}

    <!-- include summernote css/js-->
    {{-- <link href="https://summernote-bs5.min.css" rel="stylesheet">
    <script src="https://summernote-bs5.min.js"></script> --}}
<!-- fin de editor -->


    <!--GOOGLE FONTS-->
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@600;700&family=Roboto&family=Roboto+Condensed&display=swap" rel="stylesheet"> --}}

    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- <!--CSS OWL CAROUSEL-->
    <link rel="stylesheet" href="/owlcarousel/assets/owl.carousel.css">
    <link rel="stylesheet" href="/owlcarousel/assets/owl.theme.default.css"> --}}

    <!--css FANCYBOX-->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"> --}}

    <!--  LEAFLET -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!--- JQuery -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script> --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



    <!-- HOJA DE ESTILOS  y JS -->
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="/style2.css">
    <link rel="stylesheet" href="/style3_linguistica.css">
    <script src="{{asset('MyJs.js')}}"></script>

    @livewireStyles
</head>

<body>
    @livewireScripts
    <header>
        <!-- ------------------------------------------------------------------------------------------------------ -->
        <!-- -------------------------------- INICIA BARRA DE MENÚ ------------------------------------------------ -->
        <nav class="navbar navbar-expand-md texto-nav fondo-nav" aria-label="Offcanvas navbar large">
            <div class="container-fluid px-4 py-1" id="header">
                <!--Logo-->
                <a class="navbar-brand p-0 ms-3" href="/">
                    <div style="">
                        <div style="display: inline-block; vertical-align:top;">
                            <img src="@yield('logo')" alt="logo del sistema" style="width:90px;">
                        </div>
                        <div style="display: inline-block;">
                            <center>
                                <span class="mx-2" style="font-size:200%;">@yield('siglas')</span><br>
                                <span class="" style="font-size:80%;">@yield('jardin')</span>
                            </center>
                        </div>
                    </div>
                </a>

                <!--botón hamburguesa-->
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar2" aria-controls="offcanvasNavbar2" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!--Menú superior   -->
                <div class="offcanvas offcanvas-end text-bg-light" tabindex="-1" id="offcanvasNavbar2" aria-labelledby="offcanvasNavbar2Label">
                    <div class="offcanvas-header">
                        <a class="offcanvas-logo" href="index.html" id="offcanvasNavbar2Label">
                            <img src="/imagenes/logo-nav.png" alt="logo del Jardín Etnobotánico">
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        @hasSection('MenuPublico')
                            <ul class="navbar-nav justify-content-end flex-grow-1">
                                <!-- -------------------------------------------------------------------------------- -->
                                <!-- -------------------- INICIA MENÚ PÚBLICO --------------------------------------- -->
                                <!-- El jardín (inicio) -->
                                <li class="nav-item">
                                    <a class="nav-link @if(preg_match("/en\/.*\/inicio/", request()->path()) ) active @endif" href="/jardin/@yield('siglasMin')">
                                        Inicio
                                    </a>
                                </li>


                                <!-- Los autores -->
                                <li class="nav-item">
                                    <a class="nav-link @if(preg_match("/jardin.*autores/", request()->path()) ) active @endif" href="/jardin/@yield('siglasMin')/autores">
                                        Autores
                                    </a>
                                </li>

                                <!-- Las cédulas -->
                                <li class="nav-item">
                                    <a class="nav-link @if(request()->path() == 'cedulasdeljardin') active @endif" href="/jardin/@yield('siglasMin')/cedulas/">
                                        cédulas
                                    </a>
                                </li>

                                <!-- Otros jardines -->
                                <li class="nav-item">
                                    <a class="nav-link @if(request()->path() == 'cedulasdeljardin') active @endif" href="/jardiness">
                                        Otros jardines
                                    </a>
                                </li>

                                    @if(Auth::user())
                                    <li class="nav-item">
                                        <a class="nav-link @if(request()->path() == 'home') active @endif" href="/home">
                                            Home
                                        </a>
                                    </li>

                                    <!-- Salir de sistema -->
                                    <li class="nav-item">
                                        <form action="{{route('logout')}}" method="post">
                                            @csrf
                                            <button type="submit" class="nolink btn" style="padding:0;margin:0;">
                                                    Salir
                                            </button>
                                        </form>
                                    </li>
                                @else
                                    <!-- Ingresar al sistema -->
                                    <li class="nav-item">
                                        <a class="nav-link @if(request()->path() == 'ingreso') active @endif" href="/ingreso">
                                            Ingresar
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                        <!-- -------------------- TERMINA MENÚ PÚBLICO --------------------------------------- -->
                        <!-- -------------------------------------------------------------------------------- -->




                    </div>
                </div>
            </div>
        </nav>
        <!-- -------------------------------- TERMINA BARRA DE MENÚ ----------------------------------------------- -->
        <!-- ------------------------------------------------------------------------------------------------------ -->


        <!-- ------------------------------------------------------------------------------------------------- -->
        <!-- -------------------------------- INICIA BANNER -------------------------------------------------- -->
        @hasSection('banner')
            <section class="@yield('banner') pb-5">
                <div class="container-fluid p-0">
                    <div class="row inicio @yield('banner-imgBAC')" style="background-image: url('@yield('banner-img')')">
                        <div class="col-12 text-end p-0">
                            <h1>@yield('banner-title')</h1>
                        </div>
                    </div>
                    <div class="row redes-header text-start">
                        <!-- ----------------------- INICIA REDES SOCIALES ----------------------- -->
                        <!-- --------------------------------------------------------------------- -->
                        <div class="col iconos">
                            @hasSection('red_facebook')
                                <a href="@yield('red_facebook')" target="_blank">
                                    <img src="/imagenes/icono-facebook.png" alt="icono facebook">
                                </a>
                            @endif

                            @hasSection('red_instagram')
                                <a href="@yield('red_instagram')" target="_blank">
                                    <img src="/imagenes/icono-instagram.png" alt="icono instagram ">
                                </a>
                            @endif
                            @hasSection('red_youtube')
                                <a href="@yield('red_youtube')" target="_blank">
                                    <img src="/imagenes/icono-youtube.png" alt="icono mapa">
                                </a>
                            @endif
                            @hasSection('ubicacion')
                                <a href="@yield('ubicacion')" target="_blank">
                                    <img src="/imagenes/icono-mapa.png" alt="icono mapa">
                                </a>
                            @endif
                            @hasSection('web')
                                <a href="@yield('web')" target="_blank">
                                    <img src="/imagenes/icono-web.png" alt="icono web">
                                </a>
                            @endif
                            @hasSection('mail')
                                <a href="mailto:@yield('mail')" target="_blank">
                                    <img src="/imagenes/icono-correo.png" alt="icono correo">
                                </a>
                            @endif
                        </div>
                        <!-- ----------------------- TERMINA REDES SOCIALES ----------------------- -->
                        <!-- --------------------------------------------------------------------- -->
                        <div class="col">
                            <a href="#bienvenido">
                                <div class="button-scroll-down">
                                    <p>SCROLL</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        <!-- -------------------------------- TERMINA BANNER -------------------------------------------------- -->
        <!-- -------------------------------------------------------------------------------------------------- -->
    </header>

    <!-- ------------------------------------------------------------------------------------------------------ -->
    <!-- -------------------------------- INICIA BARRA DE SISTEMA --------------------------------------------- -->
    <a name="bienvenido"></a>
    @hasSection('cintillo-ubica')
        <div style="background-color:#CDC6B9;  padding-left:15px; color: #87796d; font-family: 'Roboto Condensed', sans-serif;padding:3px;" class="nolink">
            <a href="/home" class="nolink">
                <b>Cédulas del Jardín</b>
            </a>
            @yield('cintillo-ubica')&nbsp; |
            @if(Auth::user())&nbsp; <b>{{ Auth::user()->usrname }}</b> &nbsp; | @endif &nbsp;

            <!-- Indicador de Buzón -->
            @if(Auth::user())
                @if( session('buzon') > 0 )
                    <a href="/buzon" class="nolink">
                        <span style="border:1px solid #CD7B34;padding:1px;color:#CD7B34; font-weight:bold">
                            <i class="bi bi-envelope-fill"></i>
                            {{ session('buzon') }}
                            @if(session('buzon') =='1')mensaje @else mensajes @endif
                        </span>
                    </a>
                @else
                    <a href="/buzon" class="nolink">
                        <i class="bi bi-envelope"></i> Buzón &nbsp;
                    </a> |
                @endif
            @endif

            @yield('cintillo')
        </div>
    @endif
    <!-- -------------------------------- TERMINA BARRA DE SISTEMA --------------------------------------------- -->
    <!-- ------------------------------------------------------------------------------------------------------ -->

    <!-- ------------------------------------------------------------------------------------------------------ -->
    <!-- ----------------------------------- INICIA ZONA DE CONTENIDO  ---------------------------------------- -->
    <div class="p-5" style="background-color:#efebe8;">
        <div class="container py-5 px-1">
            @if(isset($slot))
                <!--  CARGA SLOT DE LIVEWIRE -->
                {{ $slot }}
            @else
                @yield('main-Nolivewire')
            @endif
        </div>
    </div>
    <!-- ----------------------------------- TERMINA ZONA DE CONTENIDO  ---------------------------------------- -->
    <!-- ------------------------------------------------------------------------------------------------------ -->



    <!-- ------------------------------------------------------------------------------------------------------ -->
    <!-- ------------------------------------------ INICIA FOOTER  -------------------------------------------- -->
    <footer>
        <div class="container-fluid ">
            <div class="row justify-content-around p-5">
                <!--Primera columna-->
                <div class="col-sm-12 col-xl-12 col-xxl-3 mb-4 botones">
                    <div class="row pb-3">
                        <div class="col">
                            <a href="/">
                                <img src="/imagenes/logo-footer.png" class="logo" alt="Logo del Jardín" style="width:100px;">
                            </a>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col">
                            <a href="/" class="nolink">Sistema Gestor de Jardines</a>
                        </div>
                    </div>

                    <div class="row pt-2 justify-content-center redes_footer">
                        <div class="col iconos">
                            <a href="https://www.facebook.com/jardinoaxaca" target="_blank">
                                <img src="/imagenes/icono-facebook.png" alt="icono facebook">
                            </a>
                            <a href="https://www.instagram.com/jardinetnobotanicodeoaxaca/" target="_blank">
                                <img src="/imagenes/icono-instagram.png" alt="icono instagram ">
                            </a>
                            <a href="https://www.youtube.com/@jardinetnobiologicodeoaxaca" target="_blank">
                                <img src="/imagenes/icono-youtube.png" alt="icono mapa">
                            </a>
                            <a href="https://goo.gl/maps/vdvcHAUMTHQaDZ676" target="_blank">
                                <img src="/imagenes/icono-mapa.png" alt="icono mapa">
                            </a>
                            <a href="mailto:escheinvar@gmail.com" target="_blank">
                                <img src="/imagenes/icono-correo.png" alt="icono correo">
                            </a>
                        </div>
                    </div>
                </div>

                <!--Segunda columna-->
                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-3 mt-4">
                    <div class="row">
                        <div class="col">
                            <div class="col pb-2">
                                <h5>Programación y mantenimiento</h5>
                                <p>Enrique Scheinvar <br> Investigador por México, Secihti/JebOax<br>enrique.scheinvar@secihti.mx</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <h5>Diseño web</h5>
                            <p>Alma Lizeth Pérez Bautista<br> Servicio social, JebOax, 2023<br></p>
                            <p>Enrique Scheinvar<br>Investigador por México Secihti/JebOax, 2025</p>
                        </div>
                    </div>
                </div>

                <!--Tercera columna-->
                <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 col-xxl-3 mt-4">
                    <h5><a href="#" class="nolink">Licencia</a></h5>
                    <p>Este software se distribuye bajo la Licencia Pública General de GNU (GPL) versión 3, lo que significa que es software libre: puedes usarlo, copiarlo, modificarlo y redistribuirlo bajo los términos de la licencia. El código fuente está disponible públicamente para fomentar la transparencia, la auditoría técnica y el desarrollo colaborativo.</p>
                </div>

                <!--Cuarta columna-->
                {{-- <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2 mt-4">
                    <div class="row">
                        <div class="col">
                            <h5>Horario de oficinas</h5>
                            <p>Oficina<br>Lunes - Viernes: 10:00 a 17:00 horas<br></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <p>Biblioteca<br>Lunes-Viernes: 9:00 a 17:00 horas<br></p>
                        </div>
                    </div>
                </div> --}}

                <!--Quinta columna-->
                <div class="col-sm-12 col-lg-12 col-xl-1 col-xxl-1 mt-4 mb-4 pt-5">
                    <a href="#header">
                        <div class="button-scroll-up">
                            <p>SUBIR</p>
                        </div>
                    </a>
                </div>
            </div>
            <div style="width: 100%; background-color:white; ">
                <center>
                    {{-- <img src="/imagenes/pleca.png" style=" width:70%;center;"> --}}
                </center>
            </div>
        </div>
    </footer>
    <!-- ------------------------------------------ TERMINA FOOTER  -------------------------------------------- -->
    <!-- ------------------------------------------------------------------------------------------------------ -->




    <!-- ------------------------------------------------------------------------------------------------------ -->
    <!-- ------------------------------------- INICIA ZONA DE SCRIPTS  ---------------------------------------- -->
    <!--BOOTSTRAP 5-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <!--CDN JQUERY-->
    {{-- <script src="https://code.jquery.com/jquery-3.7.0.js"
        integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script> --}}



    @yield('scripts')
    <!-- ------------------------------------- TERMINA ZONA DE SCRIPTS  ---------------------------------------- -->
    <!-- ------------------------------------------------------------------------------------------------------ -->
</body>

{{-- <script>
    $('#summernote').summernote({
        placeholder: 'Hello Bootstrap 5',
        tabsize: 2,
        height: 100
      });
</script> --}}
</html>
