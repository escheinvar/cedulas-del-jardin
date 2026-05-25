@section('title') Admin Imágenes @endsection
@section('meta-description') Módulo administrador de imágenes @endsection
@section('cintillo-ubica') &nbsp; @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection

<div>
    <h2>Tablero de Publicaciones</h2>

    <!-- ----------------- El ciclo de la cédula -------------------- -->
    <div class="row">
        <div class="col-12" style="background-color:#CDC6B9;text-align:center;"><b>El ciclo de publicación</b></div>
        <div class="col-0 col-md-3"> &nbsp; </div>

        <div class="col-3 col-md-1 cedEdoIcon0" style="text-align:center;font-size:80%;">
            <div class="cedEdo0" style="font-size: 80%;">0 Autor/Traductor</div>
        </div>
        <div class="col-3 col-md-1 cedEdoIcon1" style="text-align:center;font-size:80%;">
            <div class="cedEdo1" style="font-size: 80%;">1 Editor</div>
        </div>
        <div class="col-3 col-md-1 cedEdoIcon2" style="text-align:center;font-size:80%;">
            <div class="cedEdo2" style="font-size: 80%;">2 Autor/Traductor</div>
        </div>
        <div class="col-3 col-md-1 cedEdoIcon3" style="text-align:center;font-size:80%;">
            <div class="cedEdo3" style="font-size: 80%;">3 Editor</div>
        </div>
        <div class="col-3 col-md-1 cedEdoIcon4" style="text-align:center;font-size:80%;">
            <div class="cedEdo4" style="font-size: 80%;">4 Administrador</div>
        </div>
        <div class="col-3 col-md-1 cedEdoIcon5" style="text-align:center;font-size:80%;">
            <div class="cedEdo5" style="font-size: 80%;">5Administrador</div>
        </div>
        <div class="col-3 col-md-1 cedEdoIcon6" style="text-align:center;font-size:80%;">
            <div class="cedEdo6" style="font-size: 80%;">6</div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-3">
            Total de cédulas: {{ $orig->count()+$trad->count() }}
        </div>
        <div class="col-12 col-md-3">
            Cédulas originales: {{ $orig->count() }}
        </div>
        <div class="col-12 col-md-3">
            Cédulas traducidas: {{ $trad->count() }}
        </div>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th></th>
                <th>Cédula (URL)</th>
                @foreach($len as $l)
                    <!-- cada lengua -->
                    <th style="text-align: center;" wire:ignore>
                        <button type="button" wire:ignore class="btn btn-sm" data-bs-toggle="popover"
                            data-bs-title="{{ $l->len_code }}: {{ $l->len_autonimias }}"
                            data-bs-content="{{ $l->len_lengua }}">
                            <b>{{ $l->len_code }}</b>
                        </button>
                        <div>
                            {{ $orig->where('url_lencode',$l->len_code)->count()+$trad->where('url_lencode',$l->len_code)->count() }}
                        </div>
                    </th>
                @endforeach
                <th>Total<br> &nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @php $num=1; $jar=null; @endphp
            @foreach( $orig as $o)
                <tr>
                    <!-- número de publicación del jardín -->
                    <td style="font-size: 80%;font-weight: bold;">
                        @if($num=='1' OR $jar == $o->url_cjarsiglas)
                            {{ $num++ }}
                        @else
                            @php $num=1; @endphp
                            {{ $num++ }}
                        @endif
                    </td>

                    <!-- Jardín, estado, nombre, lengua -->
                    <td>
                        <a href="/cedula/{{ $o->url_cjarsiglas }}/{{ $o->url_url }}" target="new_" class="nolink">
                            <!-- jardín-->
                            <span style="color:gray; font-size: 80%;">
                                <img src="{{ $o->jardin->cjar_logo}}" width="40px">
                            </span>

                            <!-- estado -->
                            <span class="cedEdo{{ $o->url_edo }}"><i class="bi bi-{{ $o->url_edo }}-circle-fill"></i></sub></span>

                            <!-- url -->
                            {{ $o->url_url }}

                            <!-- lengua -->
                            <span style="color:gray; font-size: 80%;">
                                {{ $o->url_lencode }}
                            </span>
                        </a>
                    </td>

                    @foreach($len as $l2)
                        <td>
                            @if($trad->where('url_key',$o->url_key)->where('url_lencode',$l2->len_code)->count() == '1')
                                @php
                                    $Estado= $trad->where('url_key',$o->url_key)
                                    ->where('url_lencode',$l2->len_code)
                                    ->value('url_edo');
                                @endphp
                                <a href="/cedula/{{ $o->url_cjarsiglas }}/{{$trad->where('url_key',$o->url_key)->where('url_lencode',$l2->len_code)->value('url_url')}}" target="new_" class="nolink">
                                    <span class="cedEdo{{ $Estado }}">
                                        <i class="bi bi-{{ $Estado }}-circle-fill"></i>
                                        <div style="font-size: 60%;">
                                        {{ $trad->where('url_key',$o->url_key)
                                            ->where('url_lencode',$l2->len_code)
                                            ->value('url_lencode') }}
                                        </div>
                                    </span>
                                </a>
                            @endif
                        </td>
                    @endforeach
                    <td style="text-align: center;">
                        <b>
                            {{ $orig->where('url_key',$o->url_key)->count() + $trad->where('url_key',$o->url_key)->count() }}
                        </b>
                    </td>
                    @php $jar=$o->url_cjarsiglas; @endphp
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        /* ############## Script para activar popovers de bootstrap en Livewire ############## */
        document.addEventListener('livewire:init', () => {
            const initPopovers = () => {
                const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
                const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
            }
            initPopovers();
            Livewire.hook('morph.updated', (el, component) => {
                initPopovers();
            });
        });
    </script>
</div>
