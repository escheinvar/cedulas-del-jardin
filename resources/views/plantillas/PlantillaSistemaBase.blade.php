<!DOCTYPE html>
<html lang="es">

<head>
    @include('plantillas.plant_Head')
    @livewireStyles
</head>

<body>
    @livewireScripts
    <!-- ---------------------- Menú -------------------------->
    <header>
        <!--NAVBAR-->
        @include('plantillas.plant_MenuSist')
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
    @include('plantillas.plant_Footer')

    <!-- ------------------------ SCRIPTS------------------------------->
    @include('plantillas.SistemaScripts')
    @yield('scripts')



</body>

</html>
