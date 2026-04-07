@section('MenuPublico') x @endsection
@section('title') {{ $url->url_titulo }} @endsection
@section('meta-description') {{ $url->url_descrip }} @endsection

@section('logo') {{ $url->jardin->cjar_logo }} @endsection
@section('siglas') {{ $url->url_cjarsiglas }} @endsection
@section('siglasMin'){{ strtolower($url->url_cjarsiglas) }}@endsection
@section('jardin') {{ $url->jardin->cjar_nombre }} @endsection

@section('red_facebook') {{ $url->jardin->cjar_face }} @endsection
@section('red_instagram') {{ $url->jardin->cjar_insta }} @endsection
@section('red_youtube') {{ $url->jardin->cjar_youtube }}  @endsection
@section('ubicacion') {{ $url->jardin->cjar_ubica }}  @endsection
@section('mail') {{ $url->jardin->cjar_mail }} @endsection
@section('web') {{ $url->jardin->cjar_www }} @endsection



<div>
    <!-- -------------------------------------- CINTILLO SUPERIOR  ----------------------------------------------->
    <!-- -------------------------------------- CINTILLO SUPERIOR  ----------------------------------------------->
    <!-- -------------------------------------- CINTILLO SUPERIOR  ----------------------------------------------->
    <div class="row ">
        <div class="col-12 col-md-12 ced-cintillo">
            <a href="/jardin/{{ $url->url_cjarsiglas }}/cedulas/" class="nolink">
                <i class="bi bi-arrow-left-short"></i>Regresar
            </a> &nbsp; | &nbsp;
            <div class="d-none d-sm-none d-md-inline-block">
                Cédula {{ $url->url_url }} &nbsp; | &nbsp;
                Lengua {{ $url->lenguas->len_lengua }}
            </div>
            <!-- -------------------- Indicador de edición ------------------------------ -->
            @if($edit=='1' )
                | &nbsp; <error>Modo edición @if($editMaster=='1')1 @endif</error>
            @endif
            @if($url->url_edo <='4')
                <i class="cedEdoIcon{{ $url->url_edo }}"></i>
                <span class="cedEdo{{ $url->url_edo }}">
                    @if(Auth::user())
                        {{ Auth::user()->usrname }}: <i>{{ implode(', ', session('rol')) }}</i>
                    @endif
                </span>
            @endif

            <!-- -------------------- Menú de lenguas ------------------------------------ -->
            <div style="float: right;">
                <!-- selector de idioma -->
                @if($traducciones->count() > '0')
                    Traducciones:
                    <select wire:change="CambiaIdiomaCedula()" wire:model.live="idiomaSelected" id="MiIdioma" class="form-select ced-selectorLengua">
                        <option value="">Ver traducciones..</option>
                        @foreach ($traducciones as $t)
                            <option value="{{ $t->url_url }}">
                                @if($t->lenguas->len_autonimias != '') {{ $t->lenguas->len_autonimias }} @endif
                                ({{ $t->lenguas->len_lengua }}) {{ $t->lenguas->len_code }}
                            </option>
                        @endforeach
                    </select>
                @endif

                <!-- Ícono de pdf -->
                <a href="" target="new" class="nolink mx-1">
                    <i class="bi bi-filetype-pdf PaClick"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- -------------------------------------- PÁGINA NO DISPONIBLE ------------------------------------------ -->
    @if( ($enEdit=='1' or $edit=='0') and !Auth::user())
        <div class="row m-5">
            <div class="col-12">
                <div class=" m-6" style="background-color:#CDC6B9; padding:40px; font-size: 120%; text-align:center;">
                    <h2>!Lo sentimos¡</h2>
                    La cédula <b>{{ $url->url_titulo }}</b> en lengua {{ $url->lenguas->len_autonimias }} ({{ $url->lenguas->len_lengua }})<br>

                    <span style="font-size:80%;">
                        <div>
                            de @foreach($url->autores as $a){{ $a->aut_name }},  @endforeach
                            @foreach($url->traductores as $a)<sup>T</sup>{{ $a->aut_name }},   @endforeach
                        </div>
                        <div>
                            @foreach($url->editores as $a)<sup>E</sup>{{ $a->aut_name }},  @endforeach
                        </div>
                    </span>
                    del jardín {{ $url->jardin->cjar_nombre }}<br><br>
                    <b>se encuentra en proceso de mantenimiento</b>.<br><br>
                    Por favor, intenta de nuevo en otro momento.
                </div>
            </div>
        </div>
    @else

        <!-- -------------------------------------- ZONA DE CABEZA DE CÉDULA  ----------------------------------------------->
        <!-- -------------------------------------- ZONA DE CABEZA DE CÉDULA  ----------------------------------------------->
        <!-- -------------------------------------- ZONA DE CABEZA DE CÉDULA  ----------------------------------------------->
        <div class="row" style="margin-top:5px; border-radius:8px; ">
            <!-- ------------------------- BARRA LATERAL IZQUIERDA ------------------------>
            <!-- ------------------------- BARRA LATERAL IZQUIERDA ------------------------>
            <div class="col-12 col-md-4 col-lg-3 ced-barraLatIzq" style="">
                <!-- Nombre y Logo del Jardín -->
                <div class="row pb-2">
                    <div class="col-12 py-2" style="text-align: center; color:#202d2d; font-family: 'Noto Serif JP', serif; text-align:center; font-size:130%; font-weigth:bold;">
                        <a href="" class="nolink">
                            {{ $url->jardin->cjar_nombre }}<br>
                            <img src="@if($url->jardin->cjar_logo=='')/avatar/jardines/default.png @else {{ $url->jardin->cjar_logo }} @endif" style="width:80px;"><br>
                        </a>
                    </div>
                </div>
                <!--  BarraLatIzq: Título de cédula -->
                <div style="color:#202d2d; font-family: 'Noto Serif JP', serif; text-align:center;font-weigth:bold;" >
                    <div class="py-4" style="font-size:140%;"> {{ $url->url_titulo }}</div>
                </div>

                <!--  BarraLatIzq: Nombre común y Lengua -->
                <div style="color:#202d2d; font-family: 'Noto Serif JP', serif; text-align:center; font-weight:100;" >
                    <div class="py-1" style="font-size:120%;">{{ $url->lenguas->len_autonimias }} ({{ $url->lenguas->len_lengua }})</div>

                    <div class="" style="font-size:90%;">
                        @if($especies->count() > '0')
                            @foreach ($especies as $e)
                                @if($e->sp_scname != '')
                                    <div>
                                        <!-- Nombre de especie -->
                                        {{ $e->sp_scname }}<br>
                                        <!-- NOM-054 Semarnat -->
                                        @if($e->nom_cat != '')
                                            <span style="border:1px solid #CD7B34;color:#CD7B34;padding:3px;font-size:60%; border-radius:3px;">
                                                NOM-059<b>
                                                    @if($e->nom_cat=='E') Extinta silvestre
                                                    @elseif($e->nom_cat=='P') Peligro extinción
                                                    @elseif($e->nom_cat=='A') Amenazada
                                                    @elseif($e->nom_cat=='Pr') Protección especial
                                                    @endif
                                                </b>
                                            </span>
                                        @endif
                                        <!-- CITES -->
                                        {{-- @if($cites['estatus']=='200' & in_array('taxon_concepts',$cites['dato'])  )
                                            @if(count($cites['dato']['taxon_concepts']) > 0 )
                                                <div class="CategoriaDeRiesgo">
                                                    CITES <br>
                                                    Apéndice {{ $cites['dato']['taxon_concepts'][0]['cites_listing'] }}
                                                </div>
                                            @endif
                                        @endif --}}

                                        <!--UICN RED LIST -->
                                        {{-- @if($redList['estatus']=='200')
                                            <div class="CategoriaDeRiesgo">
                                                <a href="{{ $redList['dato']['url'] }}" class="nolink" target="new">
                                                    UICN Red List:
                                                    {{ $redList['dato']['red_list_category_code'] }}<br>
                                                    @if( $redList['dato']['red_list_category_code'] == 'NE' ) No evaluado
                                                    @elseif($redList['dato']['red_list_category_code']=='DD') Datos deficientes
                                                    @elseif($redList['dato']['red_list_category_code']=='LC') Preocupación menor
                                                    @elseif($redList['dato']['red_list_category_code']=='NT') Casi amenazada
                                                    @elseif($redList['dato']['red_list_category_code']=='VU') Vulnerable
                                                    @elseif($redList['dato']['red_list_category_code']=='EN') En peligro
                                                    @elseif($redList['dato']['red_list_category_code']=='CR') Peligro crítico
                                                    @elseif($redList['dato']['red_list_category_code']=='EW') Extinto en silvestre
                                                    @elseif($redList['dato']['red_list_category_code']=='EX') Extinto
                                                    @endif
                                                </a>
                                            </div>
                                        @endif --}}
                                        <!-- Botón agregar nueva especie -->
                                        {{-- @if($edit=='1' AND $editMaster=='1')
                                            <center>
                                                <button wire:click="" class="btn"  style="margin-top:30px;">
                                                    <i class="bi bi-plus-circle" style="color:#87796d;">Sp</i>
                                                </button>
                                            </center>
                                        @endif --}}
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- ------------------------- GralIzq: Categoría de riesgo ------------------------>


                <!-- ------------------------- GralIzq: Otras cédulas de otros jardines ------------------------>
                @if($traducciones->count() > 0) <!-- OJO:puse traducciones, pero hay que poner el match de temas -->
                    <div class="py-5" style="width:100%;text-align:center;">
                        <div style="font-size: 120%; font-weight:bold;" >
                            En otros jardines
                        </div>
                        <div class="row" style="">
                            <div class="col-12" style="text-align: center; color:#64383E;font-size:90%;">
                                @foreach ($traducciones as $t)<!-- OJO:puse traducciones, pero hay que poner el match de temas -->
                                    <div class="px-1" style="display: inline-block;">
                                        <a href="" class="nolink">
                                            <div class="iconoWWW">
                                                <img class="iconoWWW" src="@if($t->jardin->cjar_logo=='')/avatar/jardines/default.png @else {{ $t->jardin->cjar_logo }} @endif"><br>
                                                {{ $t->jardin->cjar_siglas }}
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- apoyo tamaño para diseño -->
                @if($edit=='1')
                    <div style="display:inline-block;" class="cedEdo{{ $url->url_edo }}">
                        <span class="d-none d-xl-inline-block">xl ExtraGrande</span>
                        <span class="d-none d-lg-inline-block d-xl-none">lg Grande</span>
                        <span class="d-none d-md-inline-block d-lg-none">md Mediano</span>
                        <span class="d-none d-sm-inline-block d-md-none ">sm Chico</span>
                        <span class="d-xs-block d-sm-none">xs Extrachico</span>
                    </div>
                @endif
            </div>

            <!-- ------------------------- FOTO DE LA PORTADA ------------------------>
            <!-- ------------------------- FOTO DE LA PORTADA ------------------------>
            <div class="col-12 col-md-5 col-lg-6 ced-Portada">
                <div class="ContendorImg" style="width:100%">
                    <!-- muestra portada -->
                    @if($objs->where('img_cimgtipo','portada')->count() >'0')
                        @include('plantillas.cedulaImagenPlantilla',['objetos'=>$objs->where('img_cimgtipo','portada'),'TipoDeObjeto'=>'portada'])
                    @else
                        @if($editMaster=='1')
                            <i wire:click="AbrirModalPaIncertarObjeto('0','cedula','portada','','1')" class="bi bi-file-image PaClick" style="color:#87796d">portada</i>
                            {{-- <i wire:click="AbreModalVerObjetos('img')" class="bi bi-file-image PaClick" style="color:#87796d">portada</i> --}}

                        @endif
                    @endif



                </div>
            </div>

            <!-- ------------------------- BARRA LATERAL DERECHA ------------------------>
            <!-- ------------------------- BARRA LATERAL DERECHA ------------------------>
            <div class="col-12 col-md-3 col-lg-3 center">
                <!-- ----------------------------------- Inicia imágenes superiores izquierdas ------------------------------------------------------ -->
                <!-- flecha -->
                <!-- <div class="center" style="text-align: center;">
                    <i class="bi bi-arrow-up-circle" style="font-size: 170%; color:#87796d;; cursor: pointer;"></i>
                </div> -->

                <!-- imagenes laterales ppal1, ppal2 y ppal3 -->
                @foreach (['ppal1','ppal2','ppal3','ppal'] as $ppal)
                    @if($objs->where('img_cimgtipo',$ppal)->count() >'0')
                        @include('plantillas.cedulaImagenPlantilla',['objetos'=>$objs->where('img_cimgtipo',$ppal),'TipoDeObjeto'=>$ppal])
                    @else
                        @if($editMaster=='1')
                            <div wire:click="AbrirModalPaIncertarObjeto('0','cedula','{{ $ppal }}','','1')" class="bi bi-image PaClick my-3 p-2" style="color:#87796d">{{ $ppal }}
                            </div>
                        @endif
                    @endif
                @endforeach
                @if($editMaster=='1')
                    <div wire:click="AbrirModalPaIncertarObjeto('0','cedula','ppal','','1')" class="bi bi-image PaClick my-3 p-2" style="color:#87796d">ppal</div>
                @endif

                <!-- flecha -->
                <!-- <div class="center" style="text-align: center;">
                    <i class="bi bi-arrow-down-circle" style="font-size: 170%; color:#87796d;; cursor: pointer;"></i>
                </div> -->
                <!-- ----------------------------------- Termina imágenes superiores izquierdas ------------------------------------------------------ -->
            </div>
        </div>




        <!-- -------------------------------------- ZONA DE CUERPO DE CÉDULA ----------------------------------------------->
        <!-- -------------------------------------- ZONA DE CUERPO DE CÈDULA ----------------------------------------------->
        <!-- -------------------------------------- ZONA DE CUERPO DE CÈDULA ----------------------------------------------->
        <div class="row" style="margin-top:5px; border-bottom-left-radius:8px;">
            <!-- -------------- Zona de Menú  ----------------->
            <div class="col-12 col-md-2 col-lg-2 p-1 p-md-4" style="font-size:1.2em;background-color:#CDC6B9;">
                <!-- Título de lengua -->
                <b style="color:#64383E;">{{ $url->lenguas->len_autonimias }}</b>
                <!-- menú -->
                <nav class="navbar navbar-expand-md">
                    <!-- Menú hamb comprimido-->
                    <button class="navbar-toggler" data-toggle="collapse" type="button" data-bs-toggle="offcanvas" data-bs-target="#MenuEspecifico">
                        <span style="font-size:50%;"></span><span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Menú hamb desplegado -->
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="MenuEspecifico">
                        <div class="offcanvas-header">
                            <a class="offcanvas-logo" href="index.html" id="offcanvasNavbar2Label">
                                <img src="{{ $url->jardin->cjar_logo }}" style="width:50%;" alt="logo del Jardín">
                            </a>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <!-- elementos del menú -->
                        @if($txt)
                            @foreach ($txt->whereIn('txt_tipo',['h1','h2','h3']) as $titulo)
                                <div class="px-0 py-2">
                                    @if($titulo->txt_tipo=='h1')
                                        <a class="nolink" href="#IrA{{ $titulo->txt_id }}tit" style="font-size:110%;font-weight:700;">
                                            {!! $titulo->txt_txt !!}
                                        </a>
                                    @elseif($titulo->txt_tipo=='h2')
                                        <a class="nolink" href="#IrA{{ $titulo->txt_id }}tit" style="font-size:100%;">
                                            <i>{!! $titulo->txt_txt !!}</i>
                                        </a>
                                    @elseif($titulo->txt_tipo=='h3')
                                        <a class="nolink" href="#IrA{{ $titulo->txt_id }}tit" style="font-size:80%;">
                                            <i>{!! $titulo->txt_txt !!}</i>
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    </div>
                </nav>
            </div>

            <!-- -------------- Zona de texto principal  ----------------->
            <div class="col-12 col-md-8 col-lg-7 ced-parrafos" style="">
                <!--  Título de cédula  -->
                <div class="row" style="">
                    <div class="col-12" style="text-align: center;margin:30px;">
                        <h2 style="display:inline">{{ $url->url_titulo }}</h2>
                        @if($edit=='1')
                            <span class="cedEdo{{ $url->url_edo }} PaClick" wire:click="AbirModalTraduceTitulo()">
                                <i  class="bi bi-pencil-square"></i><sup></sup>
                            </span>
                        @endif
                    </div>
                </div>

                <!--  Autores de cédula  -->
                <?php $total=$cedula->autores->count(); ?>
                @if($total > '0')
                    <div class="row" style="margin-bottom:50px;margin-right:7px;">
                        <div class="col-12 col-md-4" style=""> &nbsp; </div>
                        <div class="col-12 col-md-8" style="text-align: right;">
                            <?php $num='0'; ?>
                            <div style="font-weight:700;">
                                @foreach ($cedula->autores as $a)
                                    <?php $num++; ?>
                                    {{ $a->autor->caut_nombre }} {{ $a->autor->caut_apellido1 }} {{ $a->autor->caut_apellido2 }}
                                    @if($total > '1' AND ($a->aut_comunidad != '' OR $a->aut_institucion != '' or $a->aut_corresponding=='1'))
                                        <sup>{{ $num }}</sup>
                                    @endif

                                    @if($total > '1' and $num==($total-1) ) y
                                    @elseif($total > '1' and $num < ($total-1)),
                                    @endif
                                @endforeach
                            </div>

                            <?php $num='1'; ?>
                            <div style="font-size: 70%;">
                            @foreach ($cedula->autores as $a)
                                @if($a->aut_comunidad != '' OR $a->aut_institucion != '' or $a->aut_corresponding=='1')
                                    @if($total > '1' )<sup>{{ $num++ }}</sup>@endif {{ $a->aut_comunidad }} {{ $a->aut_institucion }}
                                    @if($a->aut_corresponding=='1') <b>{{ $a->aut_correo }}</b>&nbsp; |@endif
                                @endif
                            @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!--  Párrafos de cédula  -->
                <div class="row" >
                    <?php $TablaDeTexto=$txt; $modulo='cedula'?>
                    @include('plantillas.texto')
                    {{--
                    @foreach($txt as $t)
                        <div class="col-12" style="" wire:key="parr_{{ $t->txt_id }}">
                            <!-- párrafo tipo título 1 -->
                            @if($t->txt_tipo == 'h1')
                                <div style="margin-top: 50px;">
                                    <h3 style="display:inline;">
                                        <a name="IrA{{ $t->txt_id }}tit">{!! $t->txt_txt !!}</a>
                                    </h3>
                                    @if($t->txt_audio != '')
                                        <audio id="SpAudio{{ $t->txt_id }}" style="display:inline-block;">
                                            <source src="{{ $t->txt_audio }}" type="audio/ogg" /> El navegador no soporta el audio
                                        </audio>
                                        <i class="audioTxtPlay" id="IconPlay{{ $t->txt_id }}" onclick="playAudio('{{ $t->txt_id }}')"></i>
                                        <i class="audioTxtStop" id="IconStop{{ $t->txt_id }}" onclick="pauseAudio('{{ $t->txt_id }}')"></i>
                                    @endif
                                    @if($edit=='1')
                                        <span class="cedEdo{{ $url->url_edo }} PaClick" wire:click="AbreModalEditaParrafo('{{ $t->txt_id }}',' {{ $t->txt_orden }}', '', '', '', '1')">
                                            <i  class="bi bi-pencil-square"></i><sup>{{ $t->txt_orden }}</sup>
                                        </span>
                                    @endif
                                </div>

                            <!-- párrafo tipo título 2 -->
                            @elseif($t->txt_tipo=='h2')
                                <div style="margin-top: 30px;">
                                    <h4 style="display:inline;">
                                        <a name="IrA{{ $t->txt_id }}tit">{!! $t->txt_txt !!}</a>
                                    </h4>
                                    @if($t->txt_audio != '')
                                        <audio id="SpAudio{{ $t->txt_id }}" style="display:inline-block;">
                                            <source src="{{ $t->txt_audio }}" type="audio/ogg" /> El navegador no soporta el audio
                                        </audio>
                                        <i class="audioTxtPlay" id="IconPlay{{ $t->txt_id }}" onclick="playAudio('{{ $t->txt_id }}')"></i>
                                        <i class="audioTxtStop" id="IconStop{{ $t->txt_id }}" onclick="pauseAudio('{{ $t->txt_id }}')"></i>
                                    @endif
                                    @if($edit=='1')
                                        <span class="cedEdo{{ $url->url_edo }} PaClick" wire:click="AbreModalEditaParrafo('{{ $t->txt_id }}',' {{ $t->txt_orden }}', '', '', '', '1')">
                                            <i  class="bi bi-pencil-square"></i><sup>{{ $t->txt_orden }}</sup>
                                        </span>
                                    @endif
                                </div>

                            <!-- párrafo tipo título 1 -->
                            @elseif($t->txt_tipo=='h3')
                                <div style="margin-top: 30px;">
                                    <h5 style="display:inline;">
                                        <a name="IrA{{ $t->txt_id }}tit">{!! $t->txt_txt !!}</a>
                                    </h5>
                                    @if($t->txt_audio != '')
                                        <audio id="SpAudio{{ $t->txt_id }}" style="display:inline-block;">
                                            <source src="{{ $t->txt_audio }}" type="audio/ogg" /> El navegador no soporta el audio
                                        </audio>
                                        <i class="audioTxtPlay" id="IconPlay{{ $t->txt_id }}" onclick="playAudio('{{ $t->txt_id }}')"></i>
                                        <i class="audioTxtStop" id="IconStop{{ $t->txt_id }}" onclick="pauseAudio('{{ $t->txt_id }}')"></i>
                                    @endif
                                    @if($edit=='1')
                                        <span class="cedEdo{{ $url->url_edo }} PaClick" wire:click="AbreModalEditaParrafo('{{ $t->txt_id }}',' {{ $t->txt_orden }}', '', '', '', '1')">
                                            <i  class="bi bi-pencil-square"></i><sup>{{ $t->txt_orden }}</sup>
                                        </span>
                                    @endif
                                </div>
                            @endif
                            <!-- párrafo tipo parrafo -->
                            @if($t->txt_tipo=='p')
                                <div class="my-2" style="display:inline;">
                                    {!! $t->txt_txt !!}
                                    @if($t->txt_audio != '')
                                        <audio id="SpAudio{{ $t->txt_id }}" style="display:inline-block;">
                                            <source src="{{ $t->txt_audio }}" type="audio/ogg"> El navegador no soporta el audio
                                        </audio>
                                        <i class="audioTxtPlay" id="IconPlay{{ $t->txt_id }}" onclick="playAudio('{{ $t->txt_id }}')"></i>
                                        <i class="audioTxtStop" id="IconStop{{ $t->txt_id }}" onclick="pauseAudio('{{ $t->txt_id }}')"></i>
                                    @endif
                                    @if($edit=='1')
                                        <span class="cedEdo{{ $url->url_edo }} PaClick" wire:click="AbreModalEditaParrafo('{{ $t->txt_id }}',' {{ $t->txt_orden }}', '', '', '', '1')">
                                            <i  class="bi bi-pencil-square"></i><sup>{{ $t->txt_orden }}</sup>
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                    --}}

                    <!-- muestra último párrafo -->
                    @if($edit=='1')
                        <span class="cedEdo{{ $url->url_edo }} PaClick my-5" wire:click="AbreModalEditaParrafo('0','0', '', '', '', '1')">
                            <i class="bi bi-plus-circle"></i> Nuevo párrafo
                        </span>
                    @endif
                </div>

                <!-- Zona de traductor-->
                <div class="row">
                    @if($cedula->traductores->count() != '0')
                        <div class="col-10" style="margin-top:70px;border-top:1px solid #64383E;">
                            Traducción y voz en lengua <b>{{ $url->lenguas->len_autonimias }}</b> ({{ $url->lenguas->len_lengua }}):
                            @foreach($cedula->traductores as $trad)
                                <span wire:key="trad_{{ $trad->autor->caut_id }}">
                                    <b>{{ $trad->autor->caut_nombre }} {{ $trad->autor->caut_apellido1 }} {{ $trad->autor->caut_apellido2 }}</b>@if($trad->aut_corresponding=='1')*@endif
                                    @if($trad->aut_comunidad!='')({{ $trad->aut_comunidad }})@endif<br>
                                    @if($trad->aut_institucion!=''){{ $trad->aut_institucion }}@endif
                                    @if($trad->aut_corresponding=='1')<br>*{{ $trad->aut_correo }}@endif
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Zona de editor -->
                <div class="row my-5">
                    <div class="col-12" style="margin-top:20px; font-size:70%;">
                        @if($cedula->editores->count() > '0')
                            @if($cedula->editores->count() =='1')Editor responsable: @else Editores responsables:@endif
                            @foreach ($cedula->editores as $e)
                                {{ $e->autor->caut_nombre }} {{ $e->autor->caut_apellido1 }} {{ $e->autor->caut_apellido2 }},
                                {{ $e->aut_correo }}
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- ------------------ Zona de edición -------------------- -->
                @if($edit=='1')
                    <div class="row my-5">
                        <!-- Zona de palabras clave -->
                        <div class="col-12 col-md-8">
                            <div class="cedEdo{{ $url->url_edo }}">
                                <b>Palabras clave:</b>
                            </div>
                            @foreach ($alias as $a)
                                <div class="elemento2" style="padding:5px;">
                                    {{ $a->ali_txt_tr }}
                                    <i wire:click="AbrirModalDeAlias('{{ $a->ali_id }}')" class="bi bi-pencil-square cedEdo{{ $url->url_edo }} PaClick"></i>
                                </div>
                            @endforeach
                        </div>

                        <!-- Zona de Ubicaciones -->
                        <div class="col-12 col-md-4">
                            <div class="cedEdo{{ $url->url_edo }}">
                                <b>Ubicaciones:</b>
                            </div>
                            @foreach ($ubicaciones as $l)
                                <div class="elemento2" style="padding:5px;">
                                    {{ $l->ubi_ubicacion_tr }}
                                    <i wire:click="AbrirModalDeUbicacion('{{ $l->ubi_id }}')" class="bi bi-pencil-square cedEdo{{ $url->url_edo }} PaClick"></i>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row my-4">
                        <div class="col-12">
                            <center>
                                <button wire:click="AbreModalDeCambioDeEstado('{{ $url->url_id }}')" class="btn cedEdo{{ $url->url_edo }}" style="border:1px solid #524942">
                                    Finalizar revisión y turnar id {{ $url->url_id }}
                                </button>
                            </center>
                        </div>
                    </div>


                @endif
            </div>


            <!-- -------------- Zona de objetos laterales  ----------------->
            <div class="col-12 col-md-2 col-lg-3" style="background-color:#CDC6B9;">
                @foreach (['lat1','lat2','lat3','lat4','lat5','lat'] as $posi)
                    @if($objs->where('img_cimgtipo',$posi)->count() > '0')
                        @include('plantillas.cedulaImagenPlantilla',['objetos'=>$objs->where('img_cimgtipo',$posi),'TipoDeObjeto'=>$posi])
                    @else
                        @if($editMaster=='1')
                            <div wire:click="AbrirModalPaIncertarObjeto('0','cedula','{{ $posi }}','','1')" class="bi bi-image PaClick my-3 p-2" style="color:#87796d">{{ $posi }}
                            </div>
                        @endif
                    @endif
                @endforeach
                @if($editMaster=='1')
                    <div wire:click="AbrirModalPaIncertarObjeto('0','cedula','{{ $posi }}','','1')" class="bi bi-image PaClick my-3 p-2" style="color:#87796d">lat</div>
                @endif
            </div>
        </div>






        <!-- -------------------------------------- BLOQUE INFERIOR AUTORÍAS ----------------------------------------------->
        <!-- -------------------------------------- BLOQUE INFERIOR AUTORÍAS ----------------------------------------------->
        <!-- -------------------------------------- BLOQUE INFERIOR AUTORÍAS ----------------------------------------------->
        <div class="row my-4" style="margin-top:5px; border-radius:8px; background-color:#87796d;">
            <!-- Cita -->
            <div class="col-10 p-3">
                <h4>Forma de citar:</h4>
                    <b>{{ $url->url_cita_aut }}</b> {{ $url->url_anio }}. <u>{{ $url->url_titulo }}</u>
                    @if($url->url_tradid > '0')
                        {{ $url->url_cita_trad }}
                    @endif
                    v.{{ $url->url_version }}
                    <i>Cédulas del Jardín en lenguas originarias</i>.
                    @if($url->url_doi == '')
                        <a href="https://doi.org/{{ $url->url_doi }}" target="new" class="nolink">
                            https://doi.org/{{ $url->url_doi }}
                        </a>
                    @else
                        <a href="{{ url('/') }}cedula/{{ $url->url_cjarsiglas }}/{{ $url->url }}" target="new" class="nolink">
                            {{ url('/') }}cedula/{{ $url->url_cjarsiglas }}/{{ $url->url }}
                        </a>
                    @endif
                accesado el {{ date('i') }} de {{ $meses[date('n')] }} de {{ date('Y') }}
                <span id="sale_citaCedula" style="display:none">{{ $url->url_cita }} accesado el {{ date('i') }} de {{ $meses[date('n')] }} de {{ date('Y') }} </span>
                <i class="bi bi-clipboard PaClick" onclick="CopiarContenido('cita','Cedula')"></i>
            </div>

            <!-- Versiones -->
            <div class="col-12 p-3">
                <b>Versiones previas:</b>
                @if($url->versiones->count() > '0')
                    @foreach($url->versiones->where('ver_version','!=', $url->url_version) as $v)
                        <span style="padding:7px;" class="PaClick">
                            <i class="bi bi-filetype-pdf">v.{{ $v->ver_version }} </i>
                        </span>
                    @endforeach
                @else
                    No hay versiones previas
                @endif
            </div>


            <!-- Redes sociales,  QR y licencia-->
            <div class="col-12 p-3" style="margin:20px;">
                <!-- Redes sociales-->
                <div style="width:300px; display:inline-block;margin:15px;vertical-align:middle;text-align:center;">
                    <div style="background-color: rgb(66, 42, 20);color:white;padding:4px;padding:2px; font-size:90%;text-align:center;" class="center">
                        Compartir esta cédula en tus redes
                    </div>

                    <div style="font-size:150%;">
                        <!-- redes facebook-->
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $UrlRedes }}&text=jaja" target="_blank" class="nolink" style="margin:7px; pading:5px;">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <!-- redes instagra -->
                        <i class="bi bi-instagram"></i>
                        <!-- redes X -->
                        <a href="https://x.com/intent/tweet?text={{ $url->url_titulo }}&url={{$UrlRedes }}" target="_blank" class="nolink"  style="margin:7px; pading:5px;">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <!-- redes linkedin -->
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $UrlRedes }}&title={{ $url->url_titulo }}"  target="_blank" class="nolink"  style="margin:7px; pading:5px;">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <!-- redes reddit -->
                        <!--a href="https://www.reddit.com/submit?url={{ $UrlRedes }}&title={{ $url->url_titulo }}" target="_blank" class="nolink"  style="margin:7px; pading:5px;">
                            <img src="https://icon.png" alt="Share on Reddit">
                        </a-->
                        <!-- redes Whatsapp-->
                        <a href="https://wa.me/?text={{ $url->url_titulo }}%20{{ $UrlRedes }}" target="_blank" class="nolink"  style="margin:7px; pading:5px;">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <!-- redes Tumblr-->
                        <!--a href="https://www.tumblr.com/share/link?url={{ $UrlRedes }}&name={{ $url->url_titulo }}&description=Mira lo que encontré" target="_blank" class="nolink"  style="margin:7px; pading:5px;">
                        <img src="https://icon.png" alt="Share on Tumblr">
                        </a-->
                        <!-- redes Pinterest-->
                        <a href="https://pinterest.com/pin/create/button/?url=[{{ $UrlRedes }}]&media=[{{ $UrlRedes }}]&description=[$url->url_titulo]" target="_blank" class="nolink"  style="margin:7px; pading:5px;">
                            <i class="bi bi-pinterest"></i>
                        </a>

                        <!-- redes google+-->
                        <!--script async defer src="//assets.pinterest.com/js/pinit.js"></script>
                        <a href="https://plus.google.com/share?url=<URL>" target="_blank">
                        Share on Google+
                        </a-->
                        <!-- redes Mail-->
                        <a href="mailto:?subject={{ $url->url_titulo }}&body=Mira lo que encontré: {{ $UrlRedes }}" class="nolink">
                            <i class="bi bi-envelope"></i>
                        </a>
                    </div>
                </div>

                <!-- Código QR -->
                <div  style="display: inline;">
                    <span wire:click="VerQR()" class="PaClick">
                        {{-- {!! QrCode::margin(2)
                            ->size($qrSize)
                            ->backgroundColor(205,198,185)
                            ->color(32,45,45)
                            ->generate({{ $UrlRedes }})
                            !!} --}}
                    </span>
                    <span wire:click="BajarQR()" class="PaClick" style="margin:5px;vertical-align:bottom;">
                        <i class="bi bi-cloud-download"> </i>
                    </span>
                </div>

                <!-- Licencia GNU -->
                <div class="col-12" style="margin:20px; font-size:80%;">
                    {{-- Copyright(C), {{ date('Y', strtotime($version['ced_versiondate'])) }} @if($version['ced_cita']!=''){{ $version['ced_cita'] }} @else {{ $version['jardin'] }}@endif. --}}
                    <b>Licencia.</b> Se concede permiso para copiar, distribuir y/o modificar este documento
                    bajo los términos de la <a href="https://www.gnu.org/licenses/fdl-1.3.html" target="new" class="nolink"><u>Licencia de Documentación Libre de GNU</u></a>, Versión 1.3
                    o cualquier versión posterior publicada por la Free Software Foundation;
                    sin Secciones Invariantes, Textos de Portada y Textos de Contraportada.<br>
                </div>
            </div>
        </div>



        <!-- -------------------------------------- BLOQUE EXTRA DE EXTERNOS  ----------------------------------------------->
        <!-- -------------------------------------- BLOQUE EXTRA DE EXTERNOS  ----------------------------------------------->
        <!-- -------------------------------------- BLOQUE EXTRA DE EXTERNOS  ----------------------------------------------->
        <div @if($aportes->count() > 0)style="border:1px solid #64383E; border-radius:8px;padding:10px;" @endif>
            <!-- Yo tengo algo que aportar -->
            <a href="#AporteUsrs" class="nolink">
                <div wire:click="AbrirModalYoTengoAlgoQueAportar()" class="" style="margin-left:20px; display:inline-block;" >
                    <img src="/imagenes/BotonAportar.png" class="PaClick" style="height:90px;border:2px solid rgb(61, 41, 33);border-radius:15px;">
                </div>
            </a>

            @if($aportes->count() > 0)
                <h3>Aporte de visitantes</h3>
                @foreach ($aportes as $a)
                    <div style="padding:15px;">
                        @if($a->msg_edo < '3')
                            <span style="color:red">En espera de autorización</span>
                        @endif
                        <p style="@if($a->msg_edo <'3') color:gray; @endif">
                            {{ $a->msg_mensaje }}<br>
                            <b>{{ $a->msg_usuario }}</b>

                            @if($a->msg_origen != '') de {{ $a->msg_origen }} @endif
                            @if($a->msg_edad != '') ({{ $a->msg_edad }} años) @endif
                            <span style="font-size:90%;">{{ $a->msg_date }}</span>
                        </p>
                        <hr>
                    </div>
                @endforeach
            @endif

            @if($cedula->autores->count() > 0)
                <div class="my-4">
                    <h3>Otras ligas</h3>
                    <table class="table table-striped">
                        <thead>
                        </thead>
                        <tbody>
                        </tbody>
                    @foreach($cedula->autores as $a)
                        <tr>
                            <td>{{ $a->aut_correo }}</td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            @endif
        </div>
    @endif













    <!-- ------------------------------------------------------------------------------------------ -->
    <!-- ----------------------------------- MODAL DE TRADUCCIÓN DE TÍTULO ------------------------ -->
    <!-- ------------------------------------------------------------------------------------------ -->
    <!-- ------------------------------------------------------------------------------------------ -->
    <div wire:ignore.self class="modal fade" id="ModalTraduceTitulo" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Traduce el título</h3>
                    <button wire:click="CerrarModalTraduceTitulo()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- ----------------------------  cuerpo del modal --------------------------->
                <div class="modal-body" style="">
                    <div class="form-group">
                        <b>Título original:</b>
                        <input type="text" class="form-control" value="{{ $url->url_tituloorig }}" readonly>
                    </div>

                    <div class="form-group">
                        <b>Título en {{ $url->lenguas->len_autonimias }}</b>:<br>
                        <input  wire:model="NuevoTituloTraducido" type="text" class="@error('NuevoTituloTraducido') is-invalid @enderror form-control" >
                        @error('NuevoTituloTraducido')<error>{{ $message }}</error>@enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button wire:click="CerrarModalTraduceTitulo()" class="btn btn-secondary">
                        Cerrar
                    </button>

                    <button wire:click="GuardaTituloTraducido()" wire:loading.attr="disabled" class="btn btn-primary">
                        Guardar
                    </button>
                    <span wire:loading style="display:none;"> <red>..guardando...</red> </span>
                </div>
            </div>
        </div>
    </div>
    <!-- ---------------------- TERMINA MODAL DE TRADUCCIÓN DE TÍTULO ------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    @if($edit=='1')

        <livewire:sistema.modal-edita-parrafo-component />
        <livewire:sistema.modal-cedula-ubicaciones-component />
        <livewire:sistema.modal-cedula-alias-component />
        <livewire:sistema.modal-cedula-cambia-estado-component />
        <livewire:web.modal-cedula-yo-tengo-que-aportar />
        <livewire:sistema.modal-inserta-objeto-component />


    @endif



    <script>
        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoCedula',()=>{
            alert(event.detail.msj);
        })

        /* ### Script para abrir y cerrar modal */
        Livewire.on('AbreModalTraduceTitulo', () => {
            $('#ModalTraduceTitulo').modal('show');
        });
        Livewire.on('CierraModalTraduceTitulo', () => {
            $('#ModalTraduceTitulo').modal('hide');
        });

        Livewire.on('RecibeVariablesDeUbicacion',() => {
            @this.set('ubicaciones',event.detail.dato, live=true);
        });

        Livewire.on('RecargarPagina',() => {
            location.reload();
            // window.location.href;
        });

    </script>
</div>
