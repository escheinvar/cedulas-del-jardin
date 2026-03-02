<!DOCTYPE html>
<html lang="es">

<head>
    @include('plantillas.plant_Head')
</head>

<body>
    @livewireScripts

    <header>
         <!--NAVBAR-->
         @include('plantillas.plant_MenuPublico')

        <!--BANNER INDEX-->
        <section class="@yield  ('banner') pb-5">
            <div class="container-fluid p-0">
                <div class="row inicio">
                    <div class="col-12 text-end p-0">
                        <h1>@yield('banner-title')</h1>
                    </div>
                </div>
                <div class="row redes-header text-start">
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

                    </div>
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

    </header>

    @if(isset($slot))
        <!-- ---------------------- CARGA DE LIVEWIRE ------------------------------->
        {{ $slot }}
    @else
        @yield('main-contenidoSinLivewire')
    @endif




    <!-- ---------------------- MAIN SUP ------------------------------->
    @yield('main-superior')




    <!-- ---------------------- MAIN INF ------------------------------->
    @yield('main-inferior')





    <!-- ------------------------ FOOTTER------------------------------->
    @include('plantillas.plant_Footer')






    <!-- ---------------------- SCRIPTS ------------------------------->
    @include('plantillas.SistemaScripts')
    @yield('scripts')

</body>

</html>
