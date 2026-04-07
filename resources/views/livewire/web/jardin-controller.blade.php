@section('banner') banner-3lineas @endsection <!-- banner-1linea banner-2lineas banner-3lineas -->
@section('MenuPublico') x @endsection
@section('title') {{ $url->urlj_titulo }} @endsection
@section('meta-description') {{ $url->urlj_descrip }} @endsection
@section('banner-img'){{ $url->urlj_bannerimg }}@endsection
@section('banner-title'){{ $url->urlj_bannertitle }}  @endsection

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

    <!-- --------------------- Menú de traducciones ------------------------------ -->
    @if($traducciones->count() > 0)
        <div class="row">
            <div class="col-4 col-md-6 "> &nbsp; </div>

            <div class="col-4 col-md-3 form-group" style="text-align:right;">
                <div>
                    <h3>{{ $url->lenguas->len_autonimias }}</h3>
                    <span style="font-size: 70%;">{{ $url->lenguas->len_lengua }}</span>
                </div>
            </div>

            <div class="col-4 col-md-3 form-group">
                <label class="form-label">Hay {{ $traducciones->count() }} @if($traducciones->count()=='1') traducción @else traducciones @endif</label>
                <select wire:change="CambiaAunaTraduccion()" wire:model.live="traduccion" class="form-select">
                    <option value="">Selecciona ...</option>
                    @foreach ($traducciones as $t)
                        <option value="{{ $t->urlj_id }}">{{ $t->lenguas->len_autonimias }} ({{ $t->lenguas->len_lengua }}) {{ $t->lenguas->len_code }}</optio>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    <!-- -------------------- Aviso de mantenimiento ----------------------------- -->
    @if($url->urlj_edit=='1' and $edit=='0')
        @include('plantillas.PaginaEnMtto')

    <!-- -------------------- Muestra página ----------------------------- -->
    @else
        <!-- muestra título -->
        <h1>
            @if($edit=='1')
                <error><i class="bi bi-record-circle" style="font-size:150%;"></i></error>
            @endif

            @if($url->urlj_url=='inicio')
                {{ $url->jardin->cjar_nombre }}
            @elseif($url->urlj_url=='autores')
                Autores del {{ $url->jardin->cjar_siglas }}

            @elseif($url->urlj_url=='cedulas')
                Cédulas del {{ $url->jardin->cjar_siglas }}
            @else
                {{ $url->urlj_titulo }}
            @endif
        </h1>


        <!-- ---------------------------------------------------------------------- -->
        <!-- --------------------- INICIA TEXTO DEL JARDÍN ------------------------- -->
        <!-- ---------------------------------------------------------------------- -->
        <!-- ---------------------------------------------------------------------- -->
        @foreach ($txt as $l)
            <div wire:key="txt{{ $l->jar_id }}">
                <!-- muestra opción de edición -->
                @if($edit=='1')
                    <i wire:click="AbreModalEditaTextoWebJardin('{{ $l->jar_id }}','{{ $l->jar_orden }}')" class="bi bi-pencil-square PaClick agregar" style="display:inline;">
                        <sup>{{ $l->jar_orden }}</sup>
                    </i>
                @endif

                <!-- muestra código html -->
                {!! $l->jar_txt !!}

                <!-- muestra audio -->
                @if($l->jar_audio !='')
                    <audio id="SpAudio{{ $l->jar_id }}" style="display:inline-block;">
                        <source src="{{ $l->jar_audio }}" type="audio/ogg"> El navegador no soporta el audio
                    </audio>
                    <i class="audioTxtPlay" id="IconPlay{{ $l->jar_id }}" onclick="playAudio('{{ $l->jar_id }}')"></i>
                    <i class="audioTxtStop" id="IconStop{{ $l->jar_id }}" onclick="pauseAudio('{{ $l->jar_id }}')"></i>
                @endif
            </div>
        @endforeach
        <!-- --------------------- TERMINA TEXTO DEL JARDÍN ------------------------ -->
        <!-- ----------------------------------------------------------------------- -->


        <!-- ------------------------------------------------------------------------- -->
        <!-- ---------------------------------------------------------------------------- -->
        <!-- --------------------- INICIA AGREGAR NUEVO PÁRRAFO ------------------------- -->
        @if($edit=='1')
            <div class="row my-4" style="background-color: #CDC6B9;">
                <div class="col-2">
                    <i wire:click="AbreModalEditaTextoWebJardin('0','')" class="bi bi-plus-square PaClick" style="display:inline;"> Nuevo párrafo</i>
                </div>
            </div>
            <div class="row my-4" style="background-color: #CDC6B9;">

            </div>
        @endif
        <!-- --------------------- TERMINA AGREGAR NUEVO PÁRRAFO ------------------------- -->
        <!-- ----------------------------------------------------------------------------- -->


        <!-- ------------------------------------------------------------------------ -->
       <!-- --------------------- INICIA PAGINA DE AUTORES ------------------------- -->
        <!-- ------------------------------------------------------------------------ -->
        <!-- ------------------------------------------------------------------------ -->
        @if($url->urlj_url=='autores')
            @foreach ($autores as $a)
                <ul>
                    <li>
                        @if($a->caut_web=='1')
                            <a href="/autor/{{ $a->caut_cjarsiglas }}/{{ $a->caut_url }}" target="autor" class="nolink">
                        @endif
                            {{ $a->caut_nombre }} {{ $a->caut_apellido1 }} {{ $a->caut_apellido2 }}
                        @if($a->caut_web=='1')
                            </a>
                        @endif
                        # cédulas: bla, ble, bli.
                    </li>
                </ul>
            @endforeach
        @endif
        <!-- --------------------- TERMINA PAGINA DE AUTORES ------------------------- -->
        <!-- ------------------------------------------------------------------------ -->



        <!-- ------------------------------------------------------------------------ -->
       <!-- --------------------- INICIA PAGINA DE CÉDULAS ------------------------- -->
        <!-- ------------------------------------------------------------------------ -->
        <!-- ------------------------------------------------------------------------ -->
        @if($url->urlj_url=='cedulas')
            @foreach ($cedulas as $c)
                <ul>
                    <li>
                        <a href="/cedula/{{ $c->url_cjarsiglas }}/{{ $c->url_url }}" target="cedula" class="nolink">
                            {{ $c->url_url }}
                        </a>
                    </li>
                </ul>
            @endforeach
        @endif
        <!-- --------------------- TERMINA PAGINA DE CÉDULAS ------------------------- -->
        <!-- ------------------------------------------------------------------------ -->


        <!-- ------------------------------------------------------------------------- -->
        <!-- ---------------------------------------------------------------------------- -->
        <!-- --------------------- INICIA AGREGAR NUEVO PÁRRAFO ------------------------- -->
        {{-- @if($edit=='1')
            <div class="row my-4" style="background-color: #CDC6B9;">
                <div class="col-2">
                    <i wire:click="AbreModalEditaTextoWebJardin('0','')" class="bi bi-plus-square PaClick" style="display:inline;"> Nuevo párrafo</i>
                </div>
            </div>
            <div class="row my-4" style="background-color: #CDC6B9;">

            </div>
        @endif --}}
        <!-- --------------------- TERMINA AGREGAR NUEVO PÁRRAFO ------------------------- -->
        <!-- ----------------------------------------------------------------------------- -->

        <livewire:sistema.modal-edita-parrafo-component />
        <livewire:sistema.modal-inserta-objeto-component />

    @endif


    <script>

    </script>
</div>
