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
                    <th>No.</th>
                    <th>Especie</th>
                    <th>Nombre(s)</th>
                    <th></th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lista as $l)
                    <tr class="@if($l->lst_act == '0') inact @endif" >
                        <td> @if($edit=='1') {{ $l->lst_orden }} @else {{ $num++ }} @endif </td>
                        <td> {{ $l->lst_sp }} </td>
                        <td> {{ $l->lst_name }}</td>
                        <td> {{ $l->lst_notas }}</td>
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


    <livewire:sistema.modal-lista-especie-component />

</div>
