<!--
    Requiere la variable $TablaDeTexto que contiene la salida ->get() de alguno
    de los siguientes modelos:  jardin_txt, autor_txt, cedulas_txt
    y de la variable $modulo con alguno de los siguientes: 'cedula','jardin','autor'
-->

@if(!isset($TablaDeTexto))
    <div class="alert alert-warning">
        No hay variable de tabla de texto!!
    </div>
@else
    @foreach($TablaDeTexto as $t)
        @if($modulo=='cedula')
            <?php
                $txt_id = $t->txt_id;
                $txt_tipo = $t->txt_tipo;
                $txt_txt = $t->txt_txt;
                $txt_txtoriginal = $t->txt_txtoriginal;
                $txt_audio = $t->txt_audio;
                $txt_orden = $t->txt_orden;
                $edo= $t->url->url_edo;
                $trad=$t->url->url_tradid;
            ?>

        @elseif($modulo=='autor')
            <?php
                $txt_id = $t->autxt_id;
                $txt_tipo = $t->autxt_tipo;
                $txt_txt = $t->autxt_txt;
                $txt_txtoriginal = $t->autxt_txtoriginal;
                $txt_audio = $t->autxt_audio;
                $txt_orden = $t->autxt_orden;
                $edo= $t->url->aurl_edo;
                $trad=$t->url->aurl_tradid;
            ?>

        @else
            <?php
                $txt_id = $t->jar_id;
                $txt_tipo = $t->jar_tipo;
                $txt_txt = $t->jar_txt;
                $txt_txtoriginal = $t->jar_txtoriginal;
                $txt_audio = $t->jar_audio;
                $txt_orden = $t->jar_orden;
                $edo= $t->url->urlj_edo;
                $trad= $t->url->urlj_tradid;
            ?>

        @endif

        <?php
            //Defino var. para omitir partes en el pdf
            if(!isset($EsUnPdf)){$EsUnPdf='FALSE';}
        ?>

        <div class="col-12" style="" wire:key="parr_{{ $txt_id }}">
            <!-- Títulos h1 h2 o h3 -->
            @if($txt_tipo == 'h1' OR $txt_tipo == 'h2' OR $txt_tipo == 'h3' )
                <div style="margin-top: @if($txt_tipo=='h1') 50px; @else 30px; @endif">
                    @if($txt_tipo=='h1')
                        <h3 style="display:inline;">
                            <a name="IrA{{ $txt_id }}tit">{!! $txt_txt !!}</a>
                        </h3>
                    @elseif($txt_tipo=='h2')
                        <h4 style="display:inline;">
                            <a name="IrA{{ $txt_id }}tit">{!! $txt_txt !!}</a>
                        </h4>
                    @elseif($txt_tipo=='h3')
                        <h5 style="display:inline;">
                            <a name="IrA{{ $txt_id }}tit">{!! $txt_txt !!}</a>
                        </h5>
                    @endif

                    @if($EsUnPdf=='FALSE' AND $trad > '0')
                        <i class="bi bi-caret-down mx-2 PaClick" onclick="VerNoVer('parrafo','{{ $txt_id }}')" style="color:#87796d;"></i>
                    @endif
                    @if($txt_audio != '' and $EsUnPdf=='FALSE')
                        <audio id="SpAudio{{ $txt_id }}" style="display:inline-block;">
                            <source src="{{ $txt_audio }}" type="audio/ogg" /> @if($EsUnPdf=='FALSE')El navegador no soporta el audio @endif
                        </audio>
                        <i class="audioTxtPlay" id="IconPlay{{ $txt_id }}" onclick="playAudio('{{ $txt_id }}')"></i>
                        <i class="audioTxtStop" id="IconStop{{ $txt_id }}" onclick="pauseAudio('{{ $txt_id }}')"></i>
                    @endif
                    @if($edit=='1')
                        <span class="cedEdo{{ $edo }} PaClick" wire:click="AbreModalEditaParrafo('{{ $txt_id }}',' {{ $txt_orden }}', '', '', '', '1')">
                            <i  class="bi bi-pencil-square"></i><sup>{{ $txt_orden }}</sup>
                        </span>
                    @endif
                    <!-- texto original -->
                    <div class="" style="color:#87796d; display:none;" id="sale_parrafo{{ $txt_id }}">
                        {!!  $txt_txtoriginal !!}
                    </div>

                </div>

            <!-- párrafo tipo parrafo -->
            @elseif($txt_tipo=='p')
                <div class="my-2">
                    <div style="display:inline;">
                        {!! $txt_txt !!}
                        @if($EsUnPdf=='FALSE' AND $trad > '0')
                            <i class="bi bi-caret-down mx-2 PaClick" onclick="VerNoVer('parrafo','{{ $txt_id }}')" style="color:#87796d;"></i>
                        @endif

                        @if($txt_audio != '' and $EsUnPdf=='FALSE')
                            <audio id="SpAudio{{ $txt_id }}" style="display:inline-block;">
                                <source src="{{ $txt_audio }}" type="audio/ogg"> @if($EsUnPdf=='FALSE')El navegador no soporta el audio @endif
                            </audio>
                            <i class="audioTxtPlay" id="IconPlay{{ $txt_id }}" onclick="playAudio('{{ $txt_id }}')"></i>
                            <i class="audioTxtStop" id="IconStop{{ $txt_id }}" onclick="pauseAudio('{{ $txt_id }}')"></i>
                        @endif
                        @if($edit=='1')
                            <span class="cedEdo{{ $edo }} PaClick" wire:click="AbreModalEditaParrafo('{{ $txt_id }}',' {{ $txt_orden }}', '', '', '', '1')">
                                <i  class="bi bi-pencil-square"></i><sup>{{ $txt_orden }}</sup>
                            </span>
                        @endif
                        <!-- texto original -->
                        <div class="" style="color:#87796d; display:none;" id="sale_parrafo{{ $txt_id }}">
                            {!!  $txt_txtoriginal !!}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @endforeach
@endif
