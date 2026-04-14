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
            ?>

        @endif

        <div class="col-12" style="" wire:key="parr_{{ $txt_id }}">
            <!-- párrafo tipo título 1 -->
            @if($txt_tipo == 'h1')
                <div style="margin-top: 50px;">
                    <h3 style="display:inline;">
                        <a name="IrA{{ $txt_id }}tit">{!! $txt_txt !!}</a>
                    </h3>
                    <i class="bi bi-caret-down mx-2 PaClick" onclick="VerNoVer('parrafo','{{ $txt_id }}')" style="color:#87796d;"></i>
                    @if($txt_audio != '')
                        <audio id="SpAudio{{ $txt_id }}" style="display:inline-block;">
                            <source src="{{ $txt_audio }}" type="audio/ogg" /> El navegador no soporta el audio
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

            <!-- párrafo tipo título 2 -->
            @elseif($txt_tipo=='h2')
                <div style="margin-top: 30px;">
                    <h4 style="display:inline;">
                        <a name="IrA{{ $txt_id }}tit">{!! $txt_txt !!}</a>
                    </h4>
                    <i class="bi bi-caret-down mx-2 PaClick" onclick="VerNoVer('parrafo','{{ $txt_id }}')" style="color:#87796d;"></i>
                    @if($txt_audio != '')
                        <audio id="SpAudio{{ $txt_id }}" style="display:inline-block;">
                            <source src="{{ $txt_audio }}" type="audio/ogg" /> El navegador no soporta el audio
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

            <!-- párrafo tipo título 1 -->
            @elseif($txt_tipo=='h3')
                <div style="margin-top: 30px;">
                    <h5 style="display:inline;">
                        <a name="IrA{{ $txt_id }}tit">{!! $txt_txt !!}</a>
                    </h5>
                    <i class="bi bi-caret-down mx-2 PaClick" onclick="VerNoVer('parrafo','{{ $txt_id }}')" style="color:#87796d;"></i>
                    @if($txt_audio != '')
                        <audio id="SpAudio{{ $txt_id }}" style="display:inline-block;">
                            <source src="{{ $txt_audio }}" type="audio/ogg" /> El navegador no soporta el audio
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
            @endif
            <!-- párrafo tipo parrafo -->
            @if($txt_tipo=='p')
                <div class="my-2" style="display:inline;">
                    {!! $txt_txt !!}
                    <i class="bi bi-caret-down mx-2 PaClick" onclick="VerNoVer('parrafo','{{ $txt_id }}')" style="color:#87796d;"></i>

                    @if($txt_audio != '')
                        <audio id="SpAudio{{ $txt_id }}" style="display:inline-block;">
                            <source src="{{ $txt_audio }}" type="audio/ogg"> El navegador no soporta el audio
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
            @endif
        </div>
    @endforeach
@endif
