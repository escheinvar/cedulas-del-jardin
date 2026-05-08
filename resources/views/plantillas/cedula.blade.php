<!-- ##############################################################
    {{--
    Esta plantilla, muestra al público las  cédulas, tanto las generales del sistema,
    como las de cada jardín.
    Requiere
    $cedulas=cedulas_url::where('url_cjarsiglas',$this->url->urlj_cjarsiglas)
            ->where('url_del','0')  ->with('lenguas')
            ->with('objetos')       ->with('ubicaciones')
            ->with('especies')      ->with('alias')
            ->with('usos')          ->with('jardin')
            ->inRandomOrder()
            ->get();
    --}}
-->
<div class="row">
    @foreach ($cedulas as $c)
    <?php
        $ElUrl= url('/cedula').'/'. $c->url_cjarsiglas .'/'. $c->url_url;
    ?>
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
                {{-- @if($c->ubicaciones->count() >'0')
                    {{ implode(',  ',$c->ubicaciones->pluck('ubi_ubicacion')->toArray()) }},
                @endif --}}
            </div>
            <div style="font-size: 80%;">
                <a href="{{ $ElUrl }}" class="nolink">
                    {{ $ElUrl }}
                </a>
            </div>

        </div>


    </div>
    @endforeach
</div>
