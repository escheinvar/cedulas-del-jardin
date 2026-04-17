<div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cédulas del Jardín en Lenguas Originarias</title>

    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
 <!--- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>


    <!-- HOJA DE ESTILOS  y JS -->
    <link rel="stylesheet" href="{{ public_path('style.css') }}">
    <link rel="stylesheet" href="{{ public_path('style2.css') }}">
    <style>
        @page{
            border: 0.5 cm;
        }
        body{
            background-color:#efebe8;
            border:0.5 cm;

        }
    </style>

</head>
<body>

    <!-- -------------------------------------- CINTILLO SUPERIOR  ----------------------------------------------->
    <!-- -------------------------------------- CINTILLO SUPERIOR  ----------------------------------------------->
    <!-- -------------------------------------- CINTILLO SUPERIOR  ----------------------------------------------->
    <div style="margin:0.8cm;">
        <div class="row" >
            <div class="col-12 col-md-12 ced-cintillo" style="font-size:90%;">
                <div class="d-none d-sm-none d-md-inline-block">
                    Cédula {{ $url->url_url }} &nbsp; | &nbsp;
                    Lengua {{ $url->lenguas->len_lengua }}
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
                        <img @if($url->jardin->cjar_logo=='') src="{{ public_path('/avatar/jardines/default.png') }}" @else src="{{ public_path($url->jardin->cjar_logo) }}" @endif" style="width:80px;" alt="logo {{ $url->jardin->cjar_logo }}"><br>
                    </a>
                </div>
            </div>
            <!--  BarraLatIzq: Título de cédula -->
            <div style="color:#202d2d; font-family: 'Noto Serif JP', serif; text-align:center;font-weigth:bold;" >
                <div class="py-4" style="padding:8px;font-size:140%;"> {{ $url->url_titulo }}</div>
            </div>

            <!--  BarraLatIzq: Nombre común y Lengua -->
            <div style="color:#202d2d; font-family: 'Noto Serif JP', serif; text-align:center; font-weight:100;" >
                <div class="py-1" style="padding:5px; font-size:120%;">{{ $url->lenguas->len_autonimias }} ({{ $url->lenguas->len_lengua }})</div>

                <div class="" style="font-size:90%;">
                    @if($especies->count() > '0')
                        @foreach ($especies as $e)
                            @if($e->sp_scname != '')
                                <div style="padding-bottom:10px;">
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
            {{-- @if($traducciones->count() > 0) <!-- OJO:puse traducciones, pero hay que poner el match de temas -->
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
                                            <img class="iconoWWW" @if($t->jardin->cjar_logo=='') src="{{ public_path('/avatar/jardines/default.png') }}" @else src="{{ public_path($t->jardin->cjar_logo) }}" @endif><br>
                                            {{ $t->jardin->cjar_siglas }}
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif --}}
        </div>

        <!-- ------------------------- FOTO DE LA PORTADA ------------------------>
        <!-- ------------------------- FOTO DE LA PORTADA ------------------------>
        <div class="col-12 col-md-5 col-lg-6">
            <div class="" style="width:100%;padding:10px;">
                <!-- muestra portada -->
                @if($objs->where('img_cimgtipo','portada')->count() >'0')
                    <center>
                        <img style="max-width:8cm;max-heigth:5cm; margin:7px;"  src="{{ public_path($objs->where('img_cimgtipo','portada')->value('img_file')) }}">
                    </center>
                @endif
            </div>
        </div>



        {{-- <br><br> --}}
        <!-- ------------------------- BARRA LATERAL DERECHA ------------------------>
        <!-- ------------------------- BARRA LATERAL DERECHA ------------------------>
        <div class="col-12 col-md-3 col-lg-3 center">
            <!-- imagenes laterales ppal1, ppal2 y ppal3 -->
            @foreach (['ppal1','ppal2','ppal3','ppal'] as $ppal)
                <img style="max-width:6cm; padding:7px;" src="{{ public_path($objs->where('img_cimgtipo',$ppal)->value('img_file')) }}" alt="imagen: {{ public_path($objs->where('img_cimgtipo',$ppal)->value('img_file')) }}">
            @endforeach
            <!-- ----------------------------------- Termina imágenes superiores izquierdas ------------------------------------------------------ -->
        </div>
    </div>

    {{-- <div style="page-break-after: always;"></div> --}}

    <!-- -------------------------------------- ZONA DE CUERPO DE CÉDULA ----------------------------------------------->
    <!-- -------------------------------------- ZONA DE CUERPO DE CÈDULA ----------------------------------------------->
    <!-- -------------------------------------- ZONA DE CUERPO DE CÈDULA ----------------------------------------------->
    <div class="row" style="margin-top:5px; border-bottom-left-radius:8px;height:100%;">
        <!-- -------------- Zona de texto principal  ----------------->
        <div class="col-12 col-md-8 col-lg-7 ced-parrafos" style="margin:0.8cm;padding:6px;">
            <!--  Título de cédula  -->
            <div class="row" style="">
                <div class="col-12" style="text-align: center;margin:30px;">
                    <h2 style="display:inline">{{ $url->url_titulo }}</h2>
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
                                <a href="/autor/{{ $url->url_cjarsiglas }}/{{ $a->autor->caut_url }}" class="nolink">
                                    {{ $a->autor->caut_nombre }} {{ $a->autor->caut_apellido1 }} {{ $a->autor->caut_apellido2 }}
                                </a>
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

                <!-- muestra último párrafo -->
                @if($edit=='1')
                    <span class="cedEdo{{ $url->url_edo }} PaClick my-5" wire:click="AbreModalEditaParrafo('0','0', '', '', '', '1')">
                        <i class="bi bi-plus-circle"></i> Nuevo párrafo
                    </span>
                @endif
            </div>

            <!-- Zona de traductor-->
            <div class="row" style="width:70%;">
                @if($cedula->traductores->count() != '0')
                    <div class="col-10" style="margin-top:70px;border-top:1px solid #64383E;">
                        Traducción y voz en lengua <b>{{ $url->lenguas->len_autonimias }}</b> ({{ $url->lenguas->len_lengua }}):<br>
                        @foreach($cedula->traductores as $trad)
                            <span wire:key="trad_{{ $trad->autor->caut_id }}">
                                <a href="/autor/{{ $url->url_cjarsiglas }}/{{ $trad->autor->caut_url }}" class="nolink">
                                    <b>{{ $trad->autor->caut_nombre }} {{ $trad->autor->caut_apellido1 }} {{ $trad->autor->caut_apellido2 }}</b>@if($trad->aut_corresponding=='1')*@endif
                                </a>
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
                            <a href="/autor/{{ $url->url_cjarsiglas }}/{{ $e->autor->caut_url }}" class="nolink">
                                {{ $e->autor->caut_nombre }} {{ $e->autor->caut_apellido1 }} {{ $e->autor->caut_apellido2 }}
                            </a>,
                            {{ $e->aut_correo }}
                        @endforeach
                    @endif
                </div>
            </div>
            <br>
            <br>
        </div>

        {{-- <div style="page-break-after: always;"></div> --}}

        <!-- -------------- Zona de objetos laterales  ----------------->
        <div class="col-12 col-md-2 col-lg-3" style="background-color:#CDC6B9;padding:5px;">
            <br><br>
            @foreach (['lat1','lat2','lat3','lat4','lat5','lat'] as $posi)
                @if($objs->where('img_cimgtipo',$posi)->count() > '0')
                    <img style="max-width:6cm; max-height:4cm; padding:7px;" src="{{ public_path($objs->where('img_cimgtipo',$posi)->value('img_file')) }}" alt="imagen: {{ public_path($objs->where('img_cimgtipo',$posi)->value('img_file')) }}">
                @endif
            @endforeach
        </div>
    </div>



        <!-- -------------------------------------- BLOQUE INFERIOR AUTORÍAS ----------------------------------------------->
        <!-- -------------------------------------- BLOQUE INFERIOR AUTORÍAS ----------------------------------------------->
        <!-- -------------------------------------- BLOQUE INFERIOR AUTORÍAS ----------------------------------------------->
        <div class="row my-4" style="margin-top:5px; border-radius:8px; background-color:#87796d;">
            <!-- Cita -->
            <div class="col-12 p-3">
                <h4>Forma de citar:</h4>
                    <b>{{ $url->url_cita_aut }}</b> {{ $url->url_anio }}. <u>{{ $url->url_titulo }}</u>
                    @if($url->url_tradid > '0')
                        {{ $url->url_cita_trad }}
                    @endif
                    v.{{ $url->url_version }}
                    <i>Cédulas del Jardín en lenguas originarias</i>.
                    @if($url->url_doi != '')
                        <a href="https://doi.org/{{ $url->url_doi }}" target="new" class="nolink">
                            https://doi.org/{{ $url->url_doi }}
                        </a>
                    @else
                        <a href="{{ url('/') }}cedula/{{ $url->url_cjarsiglas }}/{{ $url->url }}" target="new" class="nolink">
                            {{ url('/') }}cedula/{{ $url->url_cjarsiglas }}/{{ $url->url_url }}
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
                <!-- Yo tengo algo que aportar -->
                <div wire:click="AbrirModalYoTengoAlgoQueAportar()" style="margin-left:20px; display:inline-block;" >
                    <img src="{{ public_path('/imagenes/BotonAportar.png') }}" class="PaClick" style="height:90px;border:2px solid rgb(61, 41, 33);border-radius:15px;">
                </div>

                <!-- Redes sociales-->
                {{-- <div style="width:300px; display:inline-block;margin:15px;vertical-align:middle;text-align:center;">
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
                </div> --}}

                <!-- Código QR -->
                {{-- <div  style="display: inline;">
                    <span wire:click="VerQR()" class="PaClick">
                        {!! QrCode::margin(2)
                            ->size($qrSize)
                            ->backgroundColor(205,198,185)
                            ->color(32,45,45)
                            ->generate( url('/').'/cedula/'.$url->url_cjarsiglas.'/'.$url->url_url)
                            !!}
                    </span>
                    <span wire:click="BajarQR()" class="PaClick" style="margin:5px;vertical-align:bottom;">
                        <i class="bi bi-cloud-download"> </i>
                    </span>

                </div> --}}
            {{-- </div>
            <div class="col-12 p-3" style="margin:20px;"> --}}
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
</div>


</body>
</html>
</div>

