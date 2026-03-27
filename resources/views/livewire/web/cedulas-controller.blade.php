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
                @include('plantillas.cedulaImagenPlantilla',['objetos'=>$objs->where('img_cimgtipo','portada'),'TipoDeObjeto'=>'portada'])
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
            @foreach (['ppal1','ppal2','ppal3'] as $ppal)
                @include('plantillas.cedulaImagenPlantilla',['objetos'=>$objs->where('img_cimgtipo',$ppal),'TipoDeObjeto'=>$ppal])
            @endforeach

            <!-- demás imágenes laterales ppal -->
            @include('plantillas.cedulaImagenPlantilla',['objetos'=>$objs->where('img_cimgtipo','ppal'),'TipoDeObjeto'=>'ppal'])
            @if($edit=='1')
                <div class="margin:20px; text-align:center;">
                    <center>
                        <button class="btn" wire:click="AbreModalObjetoEnCedula('0','{{ 'ppal' }}')" style="margin-top:30px;">
                            <i class="bi bi-image" style="color:#87796d;">ppal</i>
                        </button>
                    </center>
                </div>
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

                <!-- Menú hamb desplegado-->
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
                    <h2 style="display:inline   ">{{ $url->url_titulo }}</h2>
                    @if($edit=='1')
                        <span class="cedEdo{{ $url->url_edo }} PaClick" wire:click="AbirModalTraduceTitulo()">
                            <i  class="bi bi-pencil-square"></i><sup>{{ $t->txt_orden }}</sup>
                        </span>
                    @endif
                </div>
            </div>

            <!--  Autores de cédula  -->
            <?php $total=$autores->count(); ?>
            @if($total > '0')
                <div class="row" style="margin-bottom:50px;margin-right:7px;">
                    <div class="col-12 col-md-4" style=""> &nbsp; </div>
                    <div class="col-12 col-md-8" style="text-align: right;">
                        <?php $num='0'; ?>
                        <div style="font-weight:700;">
                            @foreach ($autores as $a)
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
                        @foreach ($autores as $a)
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
                @foreach($txt as $t)
                    <div class="col-12" style="" wire:key="parr_{{ $t->txt_id }}">
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
                                    <span class="cedEdo{{ $url->url_edo }} PaClick" wire:click="AbreModalEditaTextoWebJardin('{{ $t->txt_id }}',' {{ $t->txt_orden }}')">
                                        <i  class="bi bi-pencil-square"></i><sup>{{ $t->txt_orden }}</sup>
                                    </span>
                                @endif
                            </div>
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
                                    <span class="cedEdo{{ $url->url_edo }} PaClick" wire:click="AbreModalEditaTextoWebJardin('{{ $t->txt_id }}',' {{ $t->txt_orden }}')">
                                        <i  class="bi bi-pencil-square"></i><sup>{{ $t->txt_orden }}</sup>
                                    </span>
                                @endif
                            </div>
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
                                    <span class="cedEdo{{ $url->url_edo }} PaClick" wire:click="AbreModalEditaTextoWebJardin('{{ $t->txt_id }}',' {{ $t->txt_orden }}')">
                                        <i  class="bi bi-pencil-square"></i><sup>{{ $t->txt_orden }}</sup>
                                    </span>
                                @endif
                            </div>
                        @endif
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
                                    <span class="cedEdo{{ $url->url_edo }} PaClick" wire:click="AbreModalEditaTextoWebJardin('{{ $t->txt_id }}',' {{ $t->txt_orden }}')">
                                        <i  class="bi bi-pencil-square"></i><sup>{{ $t->txt_orden }}</sup>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Zona de traductor-->
            <div class="row">
                @if($traductores->count() != '0')
                    <div class="col-10" style="margin-top:70px;border-top:1px solid #64383E;">
                        Traducción y voz en lengua <b>{{ $url->lenguas->len_autonimias }}</b> ({{ $url->lenguas->len_lengua }}):
                        @foreach($traductores as $trad)
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
                    @if($editores->count() > '0')
                        @if($editores->count() =='1')Editor responsable: @else Editores responsables:@endif
                        @foreach ($editores as $e)
                            {{ $e->autor->caut_nombre }} {{ $e->autor->caut_apellido1 }} {{ $e->autor->caut_apellido2 }},
                            {{ $e->aut_correo }}
                        @endforeach
                    @endif
                </div>
            </div>

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
            @endif
        </div>


        <!-- -------------- Zona de objetos laterales  ----------------->
        <div class="col-12 col-md-2 col-lg-3" style="background-color:#CDC6B9;">
            @foreach (['lat1','lat2','lat3','lat4','lat5'] as $posi)
                @include('plantillas.cedulaImagenPlantilla',['objetos'=>$objs->where('img_cimgtipo',$posi),'TipoDeObjeto'=>$posi])
            @endforeach

            @include('plantillas.cedulaImagenPlantilla',['objetos'=>$objs->where('img_cimgtipo','lat'),'TipoDeObjeto'=>'lat'])
            @if($edit=='1')
                <div class="margin:20px; text-align:center;">
                    <center>
                        <button class="btn" wire:click="AbreModalObjetoEnCedula('0','{{ 'lat' }}')" style="margin-top:30px;">
                            <i class="bi bi-image" style="color:#87796d;">lat</i>
                        </button>
                    </center>
                </div>
            @endif

        </div>
    </div>






    <!-- -------------------------------------- BLOQUE INFERIOR AUTORÍAS ----------------------------------------------->
    <!-- -------------------------------------- BLOQUE INFERIOR AUTORÍAS ----------------------------------------------->
    <!-- -------------------------------------- BLOQUE INFERIOR AUTORÍAS ----------------------------------------------->
    <div class="row my-4 p-3" style="margin:5px; border-radius:8px; background-color:#87796d;">
        <!-- Cita -->
        <div class="col-12" style="margin:20px;">
            <h4>Forma de citar:</h4>
            {{-- <!-- autores -->    <b> @if($version['ced_cita']!=''){{ $version['ced_cita'] }} @else {{ $version['jardin'] }}@endif</b>.
            <!-- año -->        {{ date('Y', strtotime($version['ced_versiondate'])) }}.
            <!-- nombre/lengua --> <u>{{ $version['ced_nombre'] }} / {{ $idioma }}</u>
            <!-- version -->    (V. {{ $version['ced_version'] }}).
            <!-- jardin --> Cédulas de {{ $version['jardin'] }}
            <!-- lengua --> en {{ $idioma2 }}<br>
            <!-- registro doi-->
            <!-- url --> @if($version['ced_doi'] != '') https://doi.org/{{ $version['ced_doi'] }} @else {{ url()->current() }} @endif accesado el {{ date('d') }} de {{ ['0','enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'][date('n')] }} de {{ date('Y') }} --}}
        </div>
        <!-- Versiones -->
        <div class="col-12" style="margin:20px;">
            <b>Versiones previas:</b>
                {{-- @if(count($version['versiones']) > 0)
                    @foreach ($version['versiones'] as $i)
                        {{ $i->cedv_cedversion }},
                    @endforeach
                @else
                    Aún no existen versiones previas.
                @endif --}}

        </div>


        <!-- aporte-->
        <div class="col-12" style="margin:20px;">
            <!-- Yo tengo algo que aportar -->
            <a href="#AporteUsrs" class="nolink">
                <div class=""style="margin-left:20px; display:inline-block;" >
                    <img src="/cedulas/BotonAportar.png" wire:click="VerMensaje('1')" class="PaClick" style="height:90px;border:2px solid rgb(61, 41, 33);border-radius:15px;">
                </div>
            </a>

            <!-- Redes sociales -->
            <div style="width:300px; display:inline-block;margin:15px;vertical-align:middle;text-align:center;">
                {{-- <div style="background-color: rgb(66, 42, 20);color:white;padding:4px;padding:2px; font-size:90%;text-align:center;" class="center">
                    Compartir esta cédula en tus redes
                </div>
                <?php $MyUrl=url('/').'/sp/'.$url.'/'.$jardin; $MyTitle=$version['ced_nombre'];?>
                <div style="font-size:150%;">
                    <!-- redes facebook-->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $MyUrl }}&text=jaja" target="_blank" class="nolink" style="margin:7px; pading:5px;">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <!-- redes instagra -->
                    <i class="bi bi-instagram"></i>
                    <!-- redes X -->
                    <a href="https://x.com/intent/tweet?text={{ $MyTitle }}&url={{$MyUrl }}" target="_blank" class="nolink"  style="margin:7px; pading:5px;">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <!-- redes linkedin -->
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ $MyUrl }}&title={{ $MyTitle }}"  target="_blank" class="nolink"  style="margin:7px; pading:5px;">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <!-- redes reddit -->
                    <!--a href="https://www.reddit.com/submit?url={{ $MyUrl }}&title={{ $MyTitle }}" target="_blank" class="nolink"  style="margin:7px; pading:5px;">
                        <img src="https://icon.png" alt="Share on Reddit">
                    </a-->
                    <!-- redes Whatsapp-->
                    <a href="https://wa.me/?text={{ $MyTitle }}%20{{ $MyUrl }}" target="_blank" class="nolink"  style="margin:7px; pading:5px;">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                    <!-- redes Tumblr-->
                    <!--a href="https://www.tumblr.com/share/link?url={{ $MyUrl }}&name={{ $MyTitle }}&description=Mira lo que encontré" target="_blank" class="nolink"  style="margin:7px; pading:5px;">
                    <img src="https://icon.png" alt="Share on Tumblr">
                    </a-->
                    <!-- redes Pinterest-->
                    <a href="https://pinterest.com/pin/create/button/?url=[{{ $MyUrl }}]&media=[{{ $MyUrl }}]&description=[$MyTitle]" target="_blank" class="nolink"  style="margin:7px; pading:5px;">
                        <i class="bi bi-pinterest"></i>
                    </a>

                    <!-- redes google+-->
                    <!--script async defer src="//assets.pinterest.com/js/pinit.js"></script>
                    <a href="https://plus.google.com/share?url=<URL>" target="_blank">
                    Share on Google+
                    </a-->
                    <!-- redes Mail-->
                    <a href="mailto:?subject={{ $MyTitle }}&body=Mira lo que encontré: {{ $MyUrl }}" class="nolink">
                        <i class="bi bi-envelope"></i>
                    </a>
                </div> --}}
            </div>

            <!-- Código QR -->
            <div  style="display: inline;">
                {{-- <span wire:click="VerQR()" class="PaClick">
                    {!! QrCode::margin(2)
                        ->size($qrSize)
                        ->backgroundColor(205,198,185)
                        ->color(32,45,45)
                        ->generate( url('/').'/sp/'.$url.'/'.$jardin)
                        !!}
                </span> --}}
                <span wire:click="BajarQR()" class="PaClick" style="margin:5px;vertical-align:bottom;">
                    <i class="bi bi-cloud-download"> </i>
                </span>
            </div>

            <!-- Licencia GNU -->
            <div class="col-12" style="margin:20px; font-size:80%;">
                {{-- Copyright(C), {{ date('Y', strtotime($version['ced_versiondate'])) }} @if($version['ced_cita']!=''){{ $version['ced_cita'] }} @else {{ $version['jardin'] }}@endif. --}}
                Se concede permiso para copiar, distribuir y/o modificar este documento
                bajo los términos de la <a href="https://www.gnu.org/licenses/fdl-1.3.html" target="new" class="nolink"><u>Licencia de Documentación Libre de GNU</u></a>, Versión 1.3
                o cualquier versión posterior publicada por la Free Software Foundation;
                sin Secciones Invariantes, Textos de Portada y Textos de Contraportada.<br>
                <!--Se incluye una copia de la licencia en la sección titulada "Licencia de Documentación Libre de GNU". -->

            </div>
        </div>
    </div>


    <div>
        {{-- @if($verMsg=='1') --}}
            <a name="AporteUsrs"> </a>
            @if(Auth::user())
                <div class="row">
                    <div class="col-12 col-md-4 form-group">
                        <label class="form-label">Usuario <red>*</red>:</label>
                        <input type="text" value="{{ Auth::user()->usrname }}" class="form-control" readonly>
                    </div>
                    <div class="col-12 col-md-4 form-group">
                        <label class="form-label">Soy originario de (opcional): </label>
                        <input wire:model="MsgOrigen" type="text" class="form-control">
                    </div>
                    <div class="col-12 col-md-4 form-group">
                        <label class="form-label">Edad (opcional):</label>
                        <input wire:model="MsgEdad"  type="text" class="form-control">
                    </div>
                    <div class="col-12 form-group">
                        <label class="form-label">Sobre este tema, quiero aportar lo siguiente<red>*</red>:</label>
                        <textarea wire:model="MsgMensaje" class="form-control" placeholder="En mi comunidad, esta planta se utiliza para ..."></textarea>
                        @error('MsgMensaje')<error>{{ $message }}</error>@enderror
                        <span>Tu aporte debe ser revisado por los editores antes de ser publicado.</span>
                    </div>
                    <div class="col-12 form-group my-4">
                        <buton type="button" wire:click="EntraMensajeUsr()" class="btn btn-primary">Enviar mi aporte</buton>
                        <buton type="button" wire:click="CancelaMensajeUsr()" onclick="VerNoVer('ver','Aportes')" class="btn btn-secondary">Cancelar</buton>
                    </div>
                </div>
            @else
                Para poder aportar o ver los comentarios aportados, debes registrarte primero  en el sitio.<br>
                <a href="/ingreso">Ingresar con mi cuenta</a> &nbsp; &nbsp; <a href="/nuevousr">Crear una cuenta</a>
            @endif
        {{-- @endif --}}
    </div>

    <div>
        {{-- @if($aportes->count() > 0)
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
            <!-- botón  Yo tengo algo que aportar -->
            <a href="#AporteUsrs" class="nolink">
                <div class="" style="margin-left:20px;float:right;">
                    <img src="/cedulas/BotonAportar.png" wire:click="VerMensaje('1')" class="PaClick" style="height:90px;border:2px solid rgb(61, 41, 33);border-radius:15px;">
                </div>
            </a>
        @endif --}}
    </div>



    <!-- -------------------------------------- BLOQUE DE ADMINISTRACIÓN ----------------------------------------------->
    <!-- -------------------------------------- BLOQUE DE ADMINISTRACIÓN ----------------------------------------------->
    <!-- -------------------------------------- BLOQUE DE ADMINISTRACIÓN ----------------------------------------------->
    {{-- <div class="row" style="margin-top:5px; border-bottom-left-radius:8px; border:1px solid gray;">
        @if($edit=='1')
            <!-- -------------------- Indicador de edición ------------------------------ -->
            <center>
                <error>Modo edición @if($editMaster=='1')1 @endif</error>
                @if($url->url_edo <='4')
                    <i class="cedEdoIcon{{ $url->url_edo }}"></i>
                @endif
            </center>
        @endif
    </div> --}}











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

@if($editMaster=='1')
    <livewire:web.modal-imagen-controller>
    <livewire:sistema.jardin-web-modal-component>

    <livewire:sistema.modal-cedula-ubicaciones-component >
    <livewire:sistema.modal-cedula-alias-component >
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

        Livewire.on('RecibeVariablesDeAlias',() => {
            @this.set('alias',event.detail.dato, live=true);
        });


    </script>
</div>
