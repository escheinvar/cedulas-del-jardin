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

    @if($edit=='1')
        <div class="m-4" style="text-align:right;">
            <button class="btn btn-sm btn-primary" wire:click="AbrirModalDeListaEspecie('0')">
                <i class="bi bi-plus-circle"></i> Agregar
            </button>
        </div>
    @endif

    @if($lista->count() == 0)
        <div class="" style="text-align: center; padding: 50px; ">
            {{ $url->urlj_cjarsiglas }}     aún no genera su  listado.
        </div>
    @else
        @php $num='1'; @endphp
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th> <!-- img --> </th>
                    <th> <!-- url --> </th>
                    <th>Nombre(s)</th>
                    <th>Nombre científico</th>
                    <th> <!-- notas --> </th>
                    <th> <!-- acciones --> </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lista as $l)
                    <tr class="@if($l->lst_act == '0') inact @endif" >
                        <!-- número orden  -->
                        <td>
                            @if($edit=='1') {{ $l->lst_orden }} @else {{ $num++ }} @endif
                        </td>

                        <!-- imagen -->
                        <td>
                            <center>
                                @if($l->lst_img != '')
                                    <a href="{{ $l->lst_img }}" target="_blank">
                                        <img src="{{ $l->lst_img }}" style="max-width:70px; max-height:90px;">
                                    </a>
                                @else
                                    <img src="/imagenes/icono-hoja.png" style="max-width:50px; max-height:70px;">
                                @endif
                            </center>
                        </td>

                        <td>
                            @if($l->lst_url != '')
                                <a href="{{ $l->lst_url }}" target="new">
                                    <i class="bi bi-arrow-up-right-circle-fill" style="font-size: 150%;color:#87796d"></i>
                                </a>
                            @endif
                        </td>

                        <!-- Nombre(s) -->
                        <td>
                            @foreach ($l->nombres as $n)
                                <div class="@if($l->nombres->count() > 1)elemento @endif">
                                    {!!   $n->lstn_name !!}

                                    <!-- audio titulo -->
                                    @if($n->lstn_audio != '' )
                                        <audio id="SpAudio{{ $n->lstn_id }}Tit" style="display:inline-block;">
                                            <source src="{{ $n->lstn_audio }}" type="audio/ogg" /> El navegador no soporta el audio
                                        </audio>
                                        <i class="audioTxtPlay" id="IconPlay{{ $n->lstn_id }}Tit" onclick="playAudio('{{ $n->lstn_id }}Tit')"></i>
                                        <i class="audioTxtStop" id="IconStop{{ $n->lstn_id }}Tit" onclick="pauseAudio('{{ $n->lstn_id }}Tit')"></i>
                                    @endif

                                    <sub style="color: #CD7B34;" title="{{ $n->lstn_lengua }}">{{ $n->lstn_lencode }}</sub>
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
                            {{ $l->lst_notas }}
                        </td>

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


    @if($edit=='1' AND $SumCant != $SumReal)
        <div class="m-4" style="text-align:right;">
            <button class="btn btn-sm btn-primary" wire:click="Renumerar()">
                <i class="bi bi-plus-circle"></i> Renumerar
            </button>
        </div>
    @endif

    <livewire:sistema.modal-lista-especie-component />


</div>
