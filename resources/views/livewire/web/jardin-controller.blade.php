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

            @if($url->urlj_urltxt=='inicio')
                {{ $url->jardin->cjar_nombre }}
            @elseif($url->urlj_urltxt=='autores')
                Autores del {{ $url->jardin->cjar_siglas }}

            @elseif($url->urlj_urltxt=='cedulas')
                Cédulas del {{ $url->jardin->cjar_siglas }}
            @else
                {{ $url->urlj_titulo }}
            @endif
        </h1>


        <!-- ---------------------------------------------------------------------- -->
        <!-- ------------------- INICIAN TEXTOS DE PÁRRAFOS ----------------------- -->
        <!-- ---------------------------------------------------------------------- -->
        <!-- ---------------------------------------------------------------------- -->

        <?php $TablaDeTexto=$txt; $modulo='jardin'?>
        @include('plantillas.texto')


        <!-- ------------------------------------------------------------------------- -->
        <!-- ---------------------------------------------------------------------------- -->
        <!-- --------------------- INICIA BOTÓN AGREGAR NUEVO PÁRRAFO ------------------------- -->
        @if($edit=='1')
            <div class="row my-4" style="background-color: #CDC6B9;">
                <div class="col-2">
                    <i wire:click="AbreModalEditaParrafo('0','')" class="bi bi-plus-square PaClick" style="display:inline;"> Nuevo párrafo</i>
                </div>
            </div>
        @endif



        <!-- ------------------------------------------------------------------------ -->
       <!-- --------------------- INICIA PAGINA DE AUTORES ------------------------- -->
        <!-- ------------------------------------------------------------------------ -->
        <!-- ------------------------------------------------------------------------ -->
        @if($url->urlj_urltxt=='autores')
            @foreach ($autores as $a)
                <ul>
                    <li>
                        @if($a->urlautor->count() > '0')<a href="/autor/{{ $url->urlj_cjarsiglas }}/{{ $a->caut_url }}" target="autor" class="nolink"> @endif
                            <!-- nombre -->
                            <b>
                                {{ $a->caut_nombre }} {{ $a->caut_apellido1 }} {{ $a->caut_apellido2 }}
                                @if($a->urlautor->count() > '0')<i class="bi bi-arrow-up-right-square"></i> @endif.
                            </b>
                            <!-- cantidad -->
                            {{-- {{ $a->cedulas->count() }} @if($a->cedulas->count() == '1')cedula @else cedulas @endif: --}}
                            <!-- listado de cédulas -->
                            <?php $num=0; ?>
                            @foreach($a->cedulas as $ced)
                                <?php $num++; ?>
                                <a href="{{ url('/cedula') }}/{{ $ced->url_cjarsiglas }}/{{ $ced->url_url }}" class="nolink">
                                    {{ $ced->url_titulo }}<sup>{{ substr($ced->aut_tipo,0,1) }}</sup>
                                    <i>
                                        {{ $ced->url_lencode }}
                                        {{ $ced->url_cjarsiglas }}
                                    </i>
                                </a>
                                @if($num < $a->cedulas->count())&nbsp; || &nbsp; @endif
                            @endforeach

                        @if($a->urlautor->count() > '0')</a>@endif
                    </li>
                </ul>
            @endforeach
        @endif




        <!-- ------------------------------------------------------------------------ -->
       <!-- --------------------- INICIA PAGINA DE CÉDULAS ------------------------- -->
        <!-- ------------------------------------------------------------------------ -->
        <!-- ------------------------------------------------------------------------ -->
        @if($url->urlj_urltxt=='cedulas')
            @foreach ($cedulas as $c)
                <ul>
                    <li>
                        <a href="/cedula/{{ $c->url_cjarsiglas }}/{{ $c->url_url }}" target="cedula" class="nolink">
                            <b>{{ $c->url_titulo }}: {{ $c->lenguas->len_autonimias }} ({{ $c->lenguas->len_lengua }})</b>.
                            <span id="sale_copiaurl">
                                {{ url('/cedula') }}/{{ $c->url_cjarsiglas }}/{{ $c->url_url }}
                            </span>
                        </a>
                        <i onclick="CopiarContenido('copia','url')" class="bi bi-clipboard PaClick"></i>
                    </li>
                </ul>
            @endforeach
        @endif


        <livewire:sistema.modal-edita-parrafo-component />
        <livewire:sistema.modal-inserta-objeto-component />

    @endif


    <script>

    </script>
</div>
