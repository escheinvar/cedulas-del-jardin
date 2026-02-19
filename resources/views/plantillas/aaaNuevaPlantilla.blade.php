<!DOCTYPE html>
<html lang="es">

<head>
    {{-- @include('plantillas.plant_Head') --}}
    <!-- ------------------------------------------------------------------------------------------------------------------- -->
    <!-- -------------------------- INICIA PLANT_HEAD ---------------------------------------------------------------------- -->
        <meta charset="UTF-8" http-equiv="Content-Type" content="text/html">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Diseño Alma Lizeth Pérez Bautista, 2023 -->
    <!-- Programación Enrique Scheinvar, 2024 -->

    <!--META DESCRIPCIÓN-->
    <meta name="description" content=@yield('meta-description')>
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
    <!--GOOGLE FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP:wght@600;700&family=Roboto&family=Roboto+Condensed&display=swap" rel="stylesheet">

    <!-- ------------------------------------ Boostrap Enri------------------------------------ -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!--CSS OWL CAROUSEL-->
    <link rel="stylesheet" href="/owlcarousel/assets/owl.carousel.css">
    <link rel="stylesheet" href="/owlcarousel/assets/owl.theme.default.css">

    <!--css FANCYBOX-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css">

    <!-- ----------------------------------- LEAFLET -------------------------------------------->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!--- ----------------------- JQuery ----------------------- -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>


    <!--HOJA DE ESTILOS-->
    {{-- <link rel="stylesheet" href="/style3.css"> --}}

    <!-- ------------------------------------ Mi CSS y Mi js------------------------------------ -->
    {{-- <link rel="stylesheet" href="/style2.css"> --}}
    <script src="{{asset('MyJs.js')}}"></script>

    <!-- --------------------------------------- TERMINA PLANT_HEAD ----------------------------------------------------------------------- -->
    <!-- ---------------------------------------------------------------------------------------------------------------------------------- -->
    @livewireStyles
</head>

<body>
    @livewireScripts
    <!-- ---------------------- Menú -------------------------->
    <header>
        <!--NAVBAR-->
        {{-- @include('plantillas.plant_MenuSist') --}}
        <!-- -------------------------------------------------------------------------------------------------------------------------------- -->
        <!-- ---------------------------------------- INICIA MENÚSISTEMA -------------------------------------------------------------------- -->

        <!-- ---------------------------------------- TERMINA MENÚSISTEMA -------------------------------------------------------------------- -->
        <!-- -------------------------------------------------------------------------------------------------------------------------------- -->
    </header>

    <!-- ---------------------- Barra de sistema -------------------------->
    <div style="background-color:#CDC6B9;  padding-left:15px; color: #87796d; font-family: 'Roboto Condensed', sans-serif;padding:3px;">
        <b>Las Cédulas del Jardín</b> &nbsp; | &nbsp; <b>{{ Auth::user()->usrname }}</b> &nbsp; | &nbsp;
        {{-- @include('plantillas.plant_tamanios') | --}}

        <!-- Indicador de Buzón -->
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
                <i class="bi bi-envelope"></i> Buzón &nbsp; |
            </a>
        @endif

        <!-- Indicador de  Aportes -->
        @if(in_array('cedulas',session('rol')) and session('aportes') > 0)
            <span style="border:1px solid #64383E;padding:1px;color:#64383E; font-weight:bold" class="mx-3">
                <a href="/aportes" class="nolink">
                    <i class="bi bi-hand-index-fill"></i> {{ session('aportes') }} Aportes
                </a>
            </span> &nbsp;
        @elseif(in_array('cedulas',session('rol')) and session('aportes') == 0)
            <a href="/aportes" class="nolink">
                <i class="bi bi-hand-index"></i> Aportes &nbsp; |
            </a>
        @endif

        @yield('cintillo')
    </div>

    <!-- ---------------------- slot de livewire  -------------------------->
    @if(isset($slot))
        <div class="p-5" style="background-color:#efebe8;">
            <!-- ---------------------- CARGA DE LIVEWIRE ------------------------------->
            {{ $slot }}
        </div>
    @endif


    <!-- ------------------------ FOOTTER------------------------------->
    {{-- @include('plantillas.plant_Footer') --}}
    <!-- ------------------------------------------------------------------------------------------------------------------------------------------ -->
    <!-- ---------------------------------- INICIA PLANT-FOOTER ----------------------------------------------------------------------------------- -->
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
                        {{-- <div class="col">
                            <a href="/recorridos" class="recorridos-2">Recorridos</a>
                        </div> --}}
                    </div>

                    <div class="row pt-2 justify-content-center redes_footer">
                        <div class="col iconos">
                            <a href="https://www.facebook.com/jardinoaxaca" target="_blank">
                                <img src="/imagenes/icono-facebook.png" alt="icono facebook">
                            </a>
                            <a href="https://www.instagram.com/jardinetnobotanicodeoaxaca/" target="_blank">
                                <img src="/imagenes/icono-instagram.png" alt="icono instagram ">
                            </a>
                            <a href="https://goo.gl/maps/vdvcHAUMTHQaDZ676" target="_blank">
                                <img src="/imagenes/icono-mapa.png" alt="icono mapa">
                            </a>
                            <a href="mailto:etnobotanico@infinitummail.com" target="_blank">
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
                                <h5>Dirección</h5>
                                <p>Reforma Sur s/n, esquina Constitución,<br> Col. Centro, 68000 Oaxaca de
                                    Juárez,<br>México.</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <h5>Contacto</h5>
                            <p>Oficina 516 5325 <br> Biblioteca y Colecciones 516 9017</p>
                        </div>
                    </div>
                </div>

                <!--Tercera columna-->

                {{-- <div class="col-sm-6 col-md-6 col-lg-4 col-xl-3 col-xxl-3 mt-4">
                    <h5><a href="/recorridos" class="nolink">Visitas</a></h5>
                    <p>Recorridos guiados<br>de lunes a viernes 10:00, 11:00, 12:00 y 17:00 hrs.<br>Sábados 10:00, 11:00 y 12:00 hrs. <br>

                    </p>
                    <p>Reservaciones<br>No hay reservaciones ni venta de boletos con anticipación.</p>
                </div> --}}

                <!--Cuarta columna-->

                <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 col-xxl-2 mt-4">
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
                </div>

                <!--Quinta columna-->

                <div class="col-sm-12 col-lg-12 col-xl-1 col-xxl-1 mt-4 mb-4 pt-5">
                    <a href="#header">
                        <div class="button-scroll-up">
                            <p>SUBIR</p>
                        </div>
                    </a>
                </div>

            </div>
            <div>
                <img src="/pleca.png" style="width:100%;">
            </div>
        </div>
    </footer>
    <!-- ---------------------------------- TERMINA PLANT-FOOTER ----------------------------------------------------------------------------------- -->
    <!-- ------------------------------------------------------------------------------------------------------------------------------------------ -->




    <!-- ------------------------ SCRIPTS------------------------------->
    @include('plantillas.SistemaScripts')
    @yield('scripts')



</body>

</html>
