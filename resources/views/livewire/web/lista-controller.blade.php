@section('banner') banner-3lineas @endsection <!-- banner-1linea banner-2lineas banner-3lineas -->
@section('MenuPublico') x @endsection
@section('title') El listado  @endsection
@section('meta-description') {{ $url->urlj_descrip }} @endsection
@section('banner-img'){{ $url->urlj_bannerimg }}@endsection
@section('banner-title')El listado  @endsection

@section('logo') {{ $url->jardin->cjar_logo }} @endsection
@section('siglas') {{ $url->urlj_cjarsiglas }} @endsection
@section('siglasMin'){{ strtolower($url->urlj_cjarsiglas) }}@endsection
@section('jardin') {{ $url->jardin->cjar_nombre }} @endsection

@section('red_facebook') {{ $url->jardin->cjar_face }} @endsection
@section('red_instagram') {{ $url->jardin->cjar_insta }} @endsection
@section('red_youtube') {{ $url->jardin->cjar_youtube }}  @endsection
@section('ubicacion') {{ $url->jardin->cjar_ubica }}  @endsection
@section('mail') {{ $url->jardin->cjar_mail }} @endsection
@section('web') {{ $url->jardin->cjar_www }} @endsection

<div>
    <h2>Listado del {{ $url->urlj_cjarsiglas }}</h2>

    <!-- Tipo de visualización -->
    <div style="clear:both;">
        @if($tipoVer=='cuadro')
            <button wire:click='CambiarModoVista()' class="btn btn-secondary bi bi-table" style="float: right;"> Ver modo tabla </button>
        @else
            <button wire:click='CambiarModoVista()' class="btn btn-secondary bi bi-ui-radios-grid" style="float: right;"> Ver modo cuadros </button>
        @endif
    </div>

    {{-- <!-- Botón de edición superior --> --}}
    @if($edit=='1')
        <div class="row" style="clear: both;">
            <div class="m-4" style="text-align:right;">
                <button class="btn btn-sm btn-primary" wire:click="AbrirModalDeListaEspecie('0')">
                    <i class="bi bi-plus-circle"></i> Agregar
                </button>
            </div>
            @if($SumCant != $SumReal)
                <div class="m-4" style="text-align:right;">
                    <button class="btn btn-sm btn-primary" wire:click="Renumerar()">
                        <i class="bi bi-plus-circle"></i> Renumerar
                    </button>
                </div>
            @endif
        </div>
    @endif
<br>
    @if($lista->count() == 0)
        <div class="row">
            <div class="" style="text-align: center; padding: 50px; ">
                {{ $url->urlj_cjarsiglas }}     aún no genera su  listado.
            </div>
        </div>
    @else
        @if($tipoVer=='cuadro')
            <!-- -------------------------------------------------------------------- -->
            <!-- ------------------ INICIA ELEMENTO DE LISTA ------------------------ -->
            <div class="row" style="width:100%;">
                @foreach ($lista  as $l)
                    <div class="col-md-5 col-sm-12 m-2" style="@if($l->lst_act=='1')background-color:#CDC6B9; border:1px solid #202d2d; @else border:1px solid black;color:gray; @endif border-radius:15px;">
                        <!-- NOMBRES -->
                        <div class=""  style="">
                            @foreach ($l->nombres as $n)
                                <div class="@if($l->nombres->count() > 1)elemento2 @endif" style="font-weight:900; font-size: 120%;text-align:center; vertical-align:bottom;">
                                    <!-- nombre -->
                                    {!!   $n->lstn_name !!}
                                    <!-- audio -->
                                    @if($n->lstn_audio != '' )
                                        <audio id="SpAudio{{ $n->lstn_id }}Tit" style="display:inline-block;">
                                            <source src="{{ $n->lstn_audio }}" type="audio/ogg" /> El navegador no soporta el audio
                                        </audio>
                                        <i class="audioTxtPlay" id="IconPlay{{ $n->lstn_id }}Tit" onclick="playAudio('{{ $n->lstn_id }}Tit')" style="vertical-align:bottom;"></i>
                                        <i class="audioTxtStop" id="IconStop{{ $n->lstn_id }}Tit" onclick="pauseAudio('{{ $n->lstn_id }}Tit')"></i>
                                    @endif
                                    <!-- lengua -->
                                    <sub class="PaClick" style="color: #87796d;" title="{{ $n->lstn_lengua }}" data-toggle="tooltip" >
                                        {{ $n->lstn_lencode }}
                                    </sub>
                                </div>
                            @endforeach
                        </div>

                        <!-- IMAGEN -->
                        <div class="m-2" style="">
                            <center>
                                @if($l->imagenes->where('lstimg_act','1')->count() > 0)
                                    <!-- -------------------------Inicia carrusel de img---------------------------- -->
                                    <div id="miCarrusel" class="carousel slide" data-bs-ride="carousel">
                                        <!-- Indicadores (opcional) -->
                                        {{--
                                        <div class="carousel-indicators">
                                            @foreach($l->imagenes->chunk(1) as $index => $chunk)
                                                <button type="button"
                                                        data-bs-target="#miCarrusel"
                                                        data-bs-slide-to="{{ $index }}"
                                                        class="{{ $index == 0 ? 'active' : '' }}"
                                                        aria-current="{{ $index == 0 ? 'true' : 'false' }}">
                                                </button>
                                            @endforeach
                                        </div>
                                        --}}

                                        <!-- Contenedor de las diapositivas -->
                                        <div class="carousel-inner">
                                            @foreach($l->imagenes->chunk(1) as $index => $chunk)
                                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                    <div class="row">
                                                        @foreach($chunk as $img)
                                                            <a href="{{ $img->lstimg_img }}" target="_blank">
                                                                <img src="{{ $img->lstimg_img }}" style="max-width:100%; max-height: 200px;border-radius:5px; @if($l->lst_act=='0') opacity:0.4; @endif">
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Botones de siguiente y anterior -->
                                        @if($l->imagenes->where('lstimg_act','1')->count() > 1)
                                            <button class="carousel-control-prev" type="button" data-bs-target="#miCarrusel" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Anterior</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#miCarrusel" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Siguiente</span>
                                            </button>
                                        @endif
                                    </div>
                                    <!-- -------------------------Termina carrusel de img---------------------------- -->
                                @else
                                    <img src="/imagenes/icono-hoja.png" style="height:200px; ">
                                @endif
                            </center>

                        </div>

                        <!-- NOMBRE CIENTÍFICO -->
                        <div class="" style="">
                            @foreach ($l->nombrescient as $sp)
                                <div class="@if($l->nombrescient->count() > '1')elemento2 @endif" style="@if($l->lst_act=='0') color:gray; @endif font-weight:700; font-size:110%;text-align:center;">
                                    <i title="Familia {{ $sp->lstsc_familia }}">{{   $sp->lstsc_scname }}</i>
                                </div>
                            @endforeach
                            <i>{{ $l->lst_scname }}</i>
                        </div>

                        <!-- EXPLICACIÓN -->
                        <div id="textin" onclick="CortarOmostrarTexto()" class="my-2 multilinea cortaTresLineas" style="font-family:'Roboto Condensed', sans-serif; @if($l->lst_act=='0') color:gray; @endif">
                            {{ $l->lst_notas }}
                        </div>

                        <!-- Liga -->
                        <div style="margin-left:20px; float: left;" >
                            @if($l->lst_url != '')
                                <a href="{{ $l->lst_url }}">
                                    <i class="bi bi-sign-turn-slight-right" style="font-size: 250%;color:gray;"></i>
                                </a>
                            @endif
                        </div>

                        <!-- Aportar -->
                        <div wire:click="AbrirModalYoTengoAlgoQueAportar('{{ $l->lst_id }}')" style="margin-left:20px; float: right;" >
                            <img src="/imagenes/BotonAportar.png" class="PaClick my-2" style="height:40px;border:2px solid rgb(61, 41, 33);border-radius:15px; opacity: 0.6;">
                        </div>

                        <!-- ACCIONES -->
                        <div class="" style="">
                            @if($edit=='1')
                                <center>
                                    <!-- Editar -->
                                    <i class="bi bi-pencil-square mx-1" style="cursor: pointer;" title="Editar" wire:click="AbrirModalDeListaEspecie({{ $l->lst_id }})"></i>

                                    <!-- Ocultar -->
                                    @if($l->lst_act == '0')
                                        <i class="bi bi-eye mx-1" style="cursor: pointer;" title="Mostrar" wire:click="ActivarInactivar({{ $l->lst_id }})"></i>
                                    @else
                                        <i class="bi bi-eye-slash mx-1" style="cursor: pointer;" title="Ocultar" wire:click="ActivarInactivar({{ $l->lst_id }})"></i>
                                    @endif

                                    <!-- Eliminar -->
                                    <i class="bi bi-trash mx-1" style="cursor: pointer;" title="Eliminar" wire:click="Eliminar({{ $l->lst_id }})" wire:confirm='Vas a eliminar este registro de la lista. ¿Quieres continuar?'></i>
                                </center>
                            @endif
                        </div>
                    </div>

                @endforeach
            </div>

        @elseif($tipoVer=='tabla')
            <!-- -------------------------------------------------------------------- -->
            <!-- ------------------ INICIA LA TABLA --------------------------------- -->
            @php $num='1'; @endphp
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        {{-- <th>Id</th> --}}
                        <th> <!-- img --> </th>
                        <th> <!-- url --> </th>
                        <th>Nombre(s)</th>
                        <th>Nombre científico</th>
                        <th> <!-- notas --> </th>
                        <th> <!-- aportar --> </th>
                        <th> <!-- acciones --> </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($lista as $l)
                        <tr class="@if($l->lst_act == '0') inact @endif" >
                            <!-- número orden  -->
                            {{-- <td>
                                @if($edit=='1') {{ $l->lst_orden }} @else {{ $num++ }} @endif
                            </td> --}}

                            <!-- imagen -->
                            <td>
                                <center>
                                    @if($l->imagenes->where('lstimg_act','1')->count() > 0)
                                        <!-- -------------------------Inicia carrusel de img---------------------------- -->
                                        <div id="miCarrusel" class="carousel slide" data-bs-ride="carousel">
                                            <!-- Contenedor de las diapositivas -->
                                            <div class="carousel-inner">
                                                @foreach($l->imagenes->chunk(1) as $index => $chunk)
                                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                        <div class="row">
                                                            @foreach($chunk as $img)
                                                                <a href="{{ $img->lstimg_img }}" target="_blank">
                                                                    <img src="{{ $img->lstimg_img }}" style="max-width:70px; max-height: 90px;border-radius:5px; @if($l->lst_act=='0') opacity:0.4; @endif">
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <!-- -------------------------Termina carrusel de img---------------------------- -->

                                    @else
                                        <img src="/imagenes/icono-hoja.png" style="max-width:50px; max-height:70px;">
                                    @endif
                                </center>
                            </td>

                            <!-- URL -->
                            <td>
                                @if($l->lst_url != '')
                                    <a href="{{ $l->lst_url }}">
                                    <i class="bi bi-sign-turn-slight-right" style="font-size: 250%;color:gray;"></i>
                                </a>
                                @endif
                            </td>

                            <!-- Nombre(s) -->
                            <td>
                                @foreach ($l->nombres as $n)
                                    <div class="@if($l->nombres->count() > 1)elemento @endif">
                                        <!-- nombre -->
                                        {!!   $n->lstn_name !!}

                                        <!-- audio titulo -->
                                        @if($n->lstn_audio != '' )
                                            <audio id="SpAudio{{ $n->lstn_id }}Tit" style="display:inline-block;">
                                                <source src="{{ $n->lstn_audio }}" type="audio/ogg" /> El navegador no soporta el audio
                                            </audio>
                                            <i class="audioTxtPlay" id="IconPlay{{ $n->lstn_id }}Tit" onclick="playAudio('{{ $n->lstn_id }}Tit')"></i>
                                            <i class="audioTxtStop" id="IconStop{{ $n->lstn_id }}Tit" onclick="pauseAudio('{{ $n->lstn_id }}Tit')"></i>
                                        @endif
                                        <!-- lengua -->
                                        <sub class="PaClick" style="color: #87796d;" title="{{ $n->lstn_lengua }}" data-toggle="tooltip" >
                                            {{ $n->lstn_lencode }}
                                        </sub>
                                    </div>
                                @endforeach
                            </td>

                            <!-- Nombre científico -->
                            <td>
                                @foreach ($l->nombrescient as $sp)
                                    <div class="@if($l->nombrescient->count() > 1)elemento @endif">
                                        <i title="Familia {{ $sp->lstsc_familia }}">{{   $sp->lstsc_scname }}</i>
                                    </div>
                                @endforeach
                                <i>{{ $l->lst_scname }}</i>
                            </td>


                            <!-- Razón de incorporación -->
                            <td>
                                <div id="textin" onclick="CortarOmostrarTexto()" class="multilinea cortaTresLineas" style="max-width:200px;font-size:80%;">
                                    {{ $l->lst_notas }}
                                </div>
                            </td>

                            <!-- Yo puedo aportar -->
                            <td>
                                <div wire:click="AbrirModalYoTengoAlgoQueAportar('{{ $l->lst_id }}')" style="margin-left:20px; float: right;" >
                                    <img src="/imagenes/BotonAportar.png" class="PaClick my-2" style="height:40px;border:2px solid rgb(61, 41, 33);border-radius:15px; opacity: 0.6;">
                                </div>
                            </td>

                            <!-- Edit -->
                            <td style="text-align: right;">
                                @if($edit=='1')
                                    <!-- Editar -->
                                    <i class="bi bi-pencil-square mx-1" style="cursor: pointer;" title="Editar" wire:click="AbrirModalDeListaEspecie({{ $l->lst_id }})"></i>

                                    <!-- Ocultar -->
                                    @if($l->lst_act == '0')
                                        <i class="bi bi-eye mx-1" style="cursor: pointer;" title="Mostrar" wire:click="ActivarInactivar({{ $l->lst_id }})"></i>
                                    @else
                                        <i class="bi bi-eye-slash mx-1" style="cursor: pointer;" title="Ocultar" wire:click="ActivarInactivar({{ $l->lst_id }})"></i>
                                    @endif

                                    <!-- Eliminar -->
                                    <i class="bi bi-trash mx-1" style="cursor: pointer;" title="Eliminar" wire:click="Eliminar({{ $l->lst_id }})" wire:confirm='Vas a eliminar este registro de la lista. ¿Quieres continuar?'></i>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif


    {{-- <!-- Botón de edición inferior --> --}}
    @if($edit=='1')
        <div class="row" style="clear: both;">
            <div class="m-4" style="text-align:right;">
                <button class="btn btn-sm btn-primary" wire:click="AbrirModalDeListaEspecie('0')">
                    <i class="bi bi-plus-circle"></i> Agregar
                </button>
            </div>
            @if($SumCant != $SumReal)
                <div class="m-4" style="text-align:right;">
                    <button class="btn btn-sm btn-primary" wire:click="Renumerar()">
                        <i class="bi bi-plus-circle"></i> Renumerar
                    </button>
                </div>
            @endif
        </div>
    @endif


    <livewire:sistema.modal-lista-especie-component />
    <livewire:web.modal-cedula-yo-tengo-que-aportar />

    <script >
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });


        function CortarOmostrarTexto() {
            var element = document.getElementById("textin");
            element.classList.toggle("cortaTresLineas");

        }
    </script>
</div>
