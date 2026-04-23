@section('title')Las cédulas del SiCedJar @endsection
@section('meta-description')Cédulas de información de los jardínes, instituciones y organizaciones partícipes del sistema @endsection
@section('banner') banner-2lineas @endsection
@section('banner-title') Las cédulas @endsection
@section('banner-img') imagen5 @endsection <!-- imagen1 a imagen10 -->
@section('MenuPublico') xaa @endsection
@section('MenuPrivado')  @endsection


<div>
    <h2 class="subtitulo">Las cédulas</h2>

    <!-- ------------ Formulario de búsqueda -------------------------- -->
    <div class="row my-4">
        <div class="col-sm-12 col-md-3 form-group">
            <label class="form-label">Buscar: </label>
            <input wire:model.live="buscaText" type="text" class="form-control">
            @error('buscaText')<error>{{ $message }}</error>@enderror
        </div>

        <div class="col-sm-12 col-md-3 form-group">
            <label class="form-label">Jardín:</label>
            <select wire:model.live="buscaJardin" class="form-select">
                <option value="%"> Todos</option>
                @foreach ($jardines as $i)
                    <option value="{{ $i->url_cjarsiglas }}"> {{ $i->cjar_nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-12 col-md-3 form-group">
            <label class="form-label">Lengua:</label>
            <select wire:model.live="buscaLengua" class="form-select">
                <option value="%"> Todas</option>
                @foreach ($lenguas as $i)
                    <option value="{{ $i->len_code }}"> {{ $i->len_autonimias }} ({{ $i->len_lengua }})</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row my-5">
        @foreach ($cedulas as $c)
            <?php $ElUrl= url('/cedula').'/'. $c->url_cjarsiglas .'/'. $c->url_url; ?>
            <div class="col-12 col-md-3 p-1 m-1" style="background-color:#CDC6B9; border:1px solid #202d2d;border-radius:15px;">
                <a href="{{ $ElUrl }}" class="nolink">
                    <div>
                        <div style="float: right;">
                            <img src="{{ $c->jardin->cjar_logo }}" style="width:30px;">
                        </div>
                        <b>{!!  $c->url_titulo !!}</b>
                    </div>
                    <div class="cortaTexto" style="color:#87796d;font-family:'Roboto Condensed'">
                        {{-- {!! $c->url_tituloorig!!} --}}
                        {{ $c->lenguas->len_autonimias }} ({{ $c->lenguas->len_lengua }})
                    </div>
                </a>
                    <div style="clear:both">

                        @if( $c->objetos->whereIn('img_cimgtipo',['portada','ppal1','ppal2','ppal3'])->count() > '0' )
                            <div style="float: left;">
                                <a href="{{ $ElUrl }}" class="nolink">
                                    <img src="{{ $c->objetos->whereIn('img_cimgtipo',['portada','ppal1','ppal2','ppal3'])->value('img_file') }}"
                                        style="max-width:90%; max-height:100px; margin:10px;">
                                </a>
                            </div>
                        @endif

                        <div style="display:inline-block; margin:10px;">
                            @if($c->especies->count() >'0')
                                <a href="{{ $ElUrl }}" class="nolink">
                                    <b><i>{{ implode(',  ',$c->especies->pluck('sp_scname')->toArray()) }}</b></i>
                                </a>
                            @endif
                        </div>
                        <div style="font-size: 80%;">
                            <a href="{{ $ElUrl }}" class="nolink">
                                @if($c->alias->count() >'0')
                                    {{ implode(',  ',$c->alias->pluck('ali_txt')->toArray()) }},
                                @endif

                                @if($c->usos->count() >'0')
                                    {{ implode(',  ',$c->usos->pluck('uso_uso')->toArray()) }},
                                @endif
                                @if($c->ubicaciones->count() >'0')
                                    {{ implode(',  ',$c->ubicaciones->pluck('ubi_ubicacion')->toArray()) }},
                                @endif
                            </a>
                            <div>
                                <span id="sale_copiaurl" style="display:none;">
                                    {{ url('/cedula') }}/{{ $c->url_cjarsiglas }}/{{ $c->url_url }}
                                </span>
                                <i onclick="CopiarContenido('copia','url')" class="bi bi-clipboard PaClick"> URL</i>

                                <a href="{{ $ElUrl }}" class="nolink">
                                    <i class="bi bi-box-arrow-up-right mx-2"> {{ $ElUrl }}</i>
                                </a>
                            </div>


                        </div>

                    </div>


            </div>
        @endforeach

        {{-- @foreach ($cedulas as $c)
            <ul>
                <li>
                    <a href="/cedula/{{ $c->url_cjarsiglas }}/{{ $c->url_url }}" target="cedula" class="nolink">
                        <b>{!! $c->url_titulo !!}: {{ $c->lenguas->len_autonimias }} ({{ $c->lenguas->len_lengua }})</b>.
                        <span id="sale_copiaurl">
                            {{ url('/cedula') }}/{{ $c->url_cjarsiglas }}/{{ $c->url_url }}
                        </span>
                    </a>
                    <i onclick="CopiarContenido('copia','url')" class="bi bi-clipboard PaClick"></i>
                </li>
            </ul>
        @endforeach --}}
    </div>





    @section('scripts')
        <script>
            function copiar($base,$url,$jar,$len){
                var copyText = $base+"/len/"+$url+"/"+$jar+"/"+$len

                console.log(copyText)
                navigator.clipboard.writeText(copyText);
                // Alert the copied text
                alert(copyText + " copiada al escritorio");
            }
        </script>
    @endsection

</div>


