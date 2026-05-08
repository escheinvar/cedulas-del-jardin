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
            <div class="row">
                @foreach ($autores as $a)
                    <div class="col-12 col-md-2" style="text-align: center;">
                        <div style="">
                            <a href="/autor/{{ $url->urlj_cjarsiglas }}/{{ $a->caut_url }}" target="autor" class="nolink">
                                <div>
                                    @if($a->objetos->count() > '0')
                                        <img src="{{ $a->objetos->value('img_file') }}" style="height:200px;">
                                    @else
                                        <img src="/avatar/usr1.png" style="height:200px;">
                                    @endif
                                </div>
                                <b>{{ $a->caut_nombre }} {{ $a->caut_apellido1 }} {{ $a->caut_apellido2 }}</b>
                            </a>
                            {{-- <div>
                                {{ $a->cedulas->count() }} @if($a->cedulas->count() > '1') cédulas @else cedula @endif
                            </div> --}}
                            <div style="font-size:70%;">
                                <a href="/autor/{{ $url->urlj_cjarsiglas }}/{{ $a->caut_url }}" id="sale_autor{{ $a->caut_id }}" target="autor" class="nolink">
                                    {{ url('/autor') }}/{{ $url->urlj_cjarsiglas }}/{{ $a->caut_url }}
                                </a>
                                <i onclick="CopiarContenido('autor',{{ $a->caut_id }})" class="bi bi-clipboard PaClick"> URL</i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif




        <!-- ------------------------------------------------------------------------ -->
       <!-- --------------------- INICIA PAGINA DE CÉDULAS ------------------------- -->
        <!-- ------------------------------------------------------------------------ -->
        <!-- ------------------------------------------------------------------------ -->
        @if($url->urlj_urltxt=='cedulas')
            <!-- ------------ Formulario de búsqueda -------------------------- -->
            <div class="row my-4">
                <div class="col-sm-12 col-md-3 form-group">
                    <label class="form-label">Buscar: </label>
                    <input wire:model.live="buscaText" type="text" class="form-control">
                    @error('buscaText')<error>{{ $message }}</error>@enderror
                </div>


                <div class="col-sm-12 col-md-3 form-group">
                    <label class="form-label">Lengua:</label>
                    <select wire:model.live="buscaLengua" class="form-select">
                        <option value="%"> Todas</option>
                        {{-- @foreach ($lenguas as $i)
                            <option value="{{ $i->len_code }}"> {{ $i->len_autonimias }} ({{ $i->len_lengua }})</option>
                        @endforeach --}}
                    </select>
                </div>
            </div>

            {{-- <div class="row">
                @foreach ($cedulas as $c)
                    <?php $ElUrl= url('/cedula').'/'. $c->url_cjarsiglas .'/'. $c->url_url; ?>
                    <!-- Título, lengua y logo -->
                    <div class="col-12 col-md-3 p-1 m-1" style="background-color:#CDC6B9; border:1px solid #202d2d;border-radius:15px;">
                        <a href="{{ $ElUrl }}" class="nolink">
                            <div>
                                <!-- logo -->
                                <div style="float: right;">
                                    <img src="{{ $c->jardin->cjar_logo }}" style="width:30px;">
                                </div>
                                <!-- título -->
                                <b>{!!  $c->url_titulo !!}</b>
                            </div>
                            <!-- lengua -->
                            <div class="cortaTexto" style="color:#87796d;font-family:'Roboto Condensed'">
                                {{ $c->lenguas->len_autonimias }} ({{ $c->lenguas->len_lengua }})
                            </div>
                        </a>
                        <div style="clear:both">
                            <!-- imagen de portada -->
                            @if( $c->objetos->whereIn('img_cimgtipo',['portada'])->count() > '0' )
                                <div style="float: left;">
                                    <a href="{{ $ElUrl }}" class="nolink">
                                        @if( $c->objetos->whereIn('img_cimgtipo',['portada'])->count() > '0')
                                            <img src="{{ $c->objetos->whereIn('img_cimgtipo',['portada'])->value('img_file') }}"
                                                style="max-width:90%; max-height:100px; margin:10px;">
                                        @else
                                            <img src="{{ $c->objetos->whereIn('img_cimgtipo',['portada','ppal1','ppal2','ppal3'])->value('img_file') }}"
                                                    style="max-width:90%; max-height:100px; margin:10px;">
                                        @endif
                                    </a>
                                </div>
                            @endif

                            <!-- especie -->
                            <div style="display:inline-block; margin:10px;">
                                @if($c->especies->count() >'0')
                                    <a href="{{ $ElUrl }}" class="nolink">
                                        <b><i>{{ implode(',  ',$c->especies->pluck('sp_scname')->toArray()) }}</b></i>
                                    </a>
                                @endif
                            </div>

                            <div style="font-size: 80%;" id="sale_ced{{ $c->url_id }}" onclick="VerNoVerUnaLinea('ced','{{ $c->url_id }}')" class="cortaUnaLinea PaClick">
                                @if($c->alias->count() >'0')
                                    {{ implode(',  ',$c->alias->where('ali_calitipo','Nombre común')->pluck('ali_txt')->toArray()) }},
                                    {{ implode(',  ',$c->alias->where('ali_calitipo','!=','Nombre común')->pluck('ali_txt')->toArray()) }},
                                @endif

                                @if($c->usos->count() >'0')
                                    uso:{{ implode(',  ',$c->usos->pluck('uso_uso')->toArray()) }},
                                @endif
                            </div>
                            <div style="font-size: 80%;">
                                <a href="{{ $ElUrl }}" class="nolink">
                                    {{ $ElUrl }}
                                </a>
                            </div>

                        </div>


                    </div>
                @endforeach
            </div> --}}

            @include('plantillas.cedula')
        @endif


        <livewire:sistema.modal-edita-parrafo-component />
        <livewire:sistema.modal-inserta-objeto-component />

    @endif


    <script>

    </script>
</div>
