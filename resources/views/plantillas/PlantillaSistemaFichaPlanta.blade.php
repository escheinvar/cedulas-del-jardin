<!DOCTYPE html>
<html lang="es">

<head>
    @include('plantillas.plant_Head')
</head>

<body>
    @livewireScripts
    <!-- ---------------------- Menú -------------------------->
    <header>
        <!--NAVBAR-->
        @include('plantillas.plant_MenuSist')
    </header>





    <!-- ---------------------- slot de livewire  -------------------------->
    <div class="p-5" style="background-color:#efebe8;">
        @if(isset($slot))
            <!-- ---------------------- CARGA DE LIVEWIRE ------------------------------->
            {{ $slot }}
        @endif
    </div>




    <!-- ------------------------ FOOTTER------------------------------->
    @include('plantillas.plant_Footer')

    <!-- ------------------------ SCRIPTS------------------------------->
    @include('plantillas.SistemaScripts')
    @yield('scripts')

</body>

</html>
