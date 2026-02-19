<div class="container">
    <!-- -------------------------------------- FRANJA SUPERIOR CLASIFICACIÓN ----------------------------------------------->
    <!-- -------------------------------------- FRANJA SUPERIOR CLASIFICACIÓN ----------------------------------------------->
    <!-- -------------------------------------- FRANJA SUPERIOR CLASIFICACIÓN ----------------------------------------------->
    <div style="overflow:auto; background-color:#CDC6B9; border-radius:8px; margin:5px; padding:15px; color: #87796d; font-family: 'Roboto Condensed', sans-serif;">
        <div class="d-none d-sm-none d-md-inline-block" style="display:inline-block;">
            <b> Reino {{ $taxo['reino'] }} &nbsp; | &nbsp;
                @if($taxo['familia']!='') Familia {{ $taxo['familia'] }} &nbsp; | &nbsp;  @endif
                @if($taxo['sp'] != '') <i>{{ $taxo['sp'] }}</i></b> &nbsp; &nbsp; @endif
                {{ $taxo['nombrecomun'] }}</b>
                @if(Auth::user()) &nbsp; &nbsp; || &nbsp; &nbsp; <b>{{ Auth::user()->usrname }}</b> @endif
        </div>


        <!-- -------------------- Menú de lenguas ------------------------------------ -->
        <div style="float: right;">
            <!-- regresar -->
            <b><a href="/especies" class="nolink">
                <i class="bi bi-arrow-left-short"></i>Regresar
            </a></b> &nbsp; &nbsp;
            <!-- selector de idioma -->
            <b style="color:#87796d; font-weight:bolder;">Lengua:</b>
            <select wire:change="idiomas()" wire:model="idioma" id="MiIdioma" class="form-select lenguas" style="width:180px; display:inline-block; background-color:#efebe8;border:2px solid #87796d;">
                @foreach ($lenguas as $len)
                    <option value="{{ $len->clen_code }}"> @if($len->clen_autonimias != '') {{ $len->clen_autonimias }}  @endif {{ $len->clen_lengua }} </option>
                @endforeach
            </select>
            &nbsp; &nbsp;
            <!-- Ícono de pdf -->
            <a href="/sppdf/{{ $CedId }}/pdf" target="new" class="nolink">
                <i class="bi bi-filetype-pdf PaClick"></i>
            </a>
        </div>
    </div>


    <!-- -------------------------------------- BLOQUE SUPERIOR FICHA E IMAGENES ----------------------------------------------->
    <!-- -------------------------------------- BLOQUE SUPERIOR FICHA E IMAGENES ----------------------------------------------->
    <!-- -------------------------------------- BLOQUE SUPERIOR FICHA E IMAGENES ----------------------------------------------->
    <div class="row" style="margin:5px; border-radius:8px; ">
        <!-- ------------------------- FICHA GENERAL IZQUIERDA ------------------------>
        <div class="col-12 col-md-4 col-lg-3 text-wrap" style="position:relative; padding:10px; border-top-left-radius:8px; background-color:#CDC6B9;">
            <!-- ------------------------- GralIzq: Nombre y Logo del Jardín propietario de la cédula ------------------------>
            <div class="row pb-2" style="">
                @foreach ($jardinData->where('cjar_siglas',$jardin) as $jar)
                    <div class="col-12 py-2" style="text-align: center; color:#202d2d; font-family: 'Noto Serif JP', serif; text-align:center; font-size:130%; font-weigth:bold;">
                        <a href="/sp/{{ $url }}/{{ $jar->cjar_siglas }}" class="nolink">
                            {{ $jar->cjar_nombre }}<br>
                            <img src="@if($jar->cjar_logo=='')/avatar/jardines/default.png @else /avatar/jardines/{{ $jar->cjar_logo }} @endif" style="width:80px;"><br>
                        </a>
                    </div>
                @endforeach
            </div>
            <!-- ------------------------- GralIzq: Nombre científico ------------------------>
            <div style="color:#202d2d; font-family: 'Noto Serif JP', serif; text-align:center;font-weigth:bold;" >
                <div class="py-4" style="font-size:140%;">{{ $taxo['sp'] }}</div>
            </div>

            <!-- ------------------------- GralIzq: Nombre Común / lengua ------------------------>
            <div style="color:#202d2d; font-family: 'Noto Serif JP', serif; text-align:center; font-weight:100;" >
                <div class="py-1" style="font-size:120%;">{{ $taxo['nombrecomun'] }}</div>
                <div class="" style="font-size:90%;">{{ $idioma2 }}</div>
            </div>

            <!-- ------------------------- GralIzq: Categoría de riesgo ------------------------>

            <div style="text-align: center;">
                @if($nom054sem->count() =='1')
                    <div class="CategoriaDeRiesgo">
                        NOM-059-Sem
                        <BR>
                        {{ $nom054sem->value('nom_distri') }}
                        @if($nom054sem->value('nom_cat')=='P') En Peligro de Extinción
                        @elseif($nom054sem->value('nom_cat')=='A') Amenazada
                        @elseif($nom054sem->value('nom_cat')=='Pr') Sujeta a Protección Especial
                        @endif
                        {{ $nom054sem->value('nom_cat') }}
                    </div>
                @endif


                @if($cites['estatus']=='200' & in_array('taxon_concepts',$cites['dato'])  )
                    @if(count($cites['dato']['taxon_concepts']) > 0 )
                        <div class="CategoriaDeRiesgo">
                            CITES <br>
                            Apéndice {{ $cites['dato']['taxon_concepts'][0]['cites_listing'] }}
                        </div>
                    @endif
                @endif

                <!-- ------------------ API DE UICN RED LIST ------------- -->
                @if($redList['estatus']=='200')
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
                @endif
            </div>

            @if(Auth::user() )
                {{-- <center>
                <div style="display:inline-block;"> &nbsp; | &nbsp;
                    <span class="d-none d-xl-inline-block">xl ExtraGrande</span>
                    <span class="d-none d-lg-inline-block d-xl-none">lg Grande</span>
                    <span class="d-none d-md-inline-block d-lg-none">md Mediano</span>
                    <span class="d-none d-sm-inline-block d-md-none ">sm Chico</span>
                    <span class="d-xs-block d-sm-none">xs Extrachico</span>
                </div>
                </center> --}}
            @endif

            <!-- ------------------------- GralIzq: Otras cédulas de otros jardines ------------------------>
            @if($jardinData->where('cjar_siglas','!=',$jardin)->count() > 0)
                <div class="py-5" style="width:100%;text-align:center;">
                    <div style="font-size: 120%;font-weight:bold;" >
                        Otros jardines
                    </div>
                    <div class="row" style="">
                        <div class="col-12" style="text-align: center; color:#64383E;font-size:90%;">
                            @foreach ($jardinData->where('cjar_siglas','!=',$jardin) as $jar)
                                <div class="px-1" style="display: inline-block;">
                                    <a href="/sp/{{ $url }}/{{ $jar->cjar_siglas }}" class="nolink">
                                        <img src="@if($jar->cjar_logo=='')/avatar/jardines/default.png @else /avatar/jardines/{{ $jar->cjar_logo }} @endif" style="width:20px;">
                                        {{ $jar->cjar_siglas }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- ------------------------- FOTO DE LA PORTADA ------------------------>
        <div class="col-sm-12 col-md-4 col-lg-5" style="vertical-align:middle;center">
            <center>
                @if($fotos->where('imgsp_cimgname','portada')->value('imgsp_file') != '')
                    <div class="ContenedorImg" style="width:100%">
                        <img class="img-fluid PaClick" style="max-height:30%;" src="/cedulas/{{ $fotos->where('imgsp_cimgname','portada')->value('imgsp_file') }}" onclick="VerNoVer('foto','{{ $fotos->where('imgsp_cimgname','portada')->value('imgsp_id') }}')">
                        <div style="display:none; font-size:90%;" id="sale_foto{{ $fotos->where('imgsp_cimgname','portada')->value('imgsp_id') }}">
                            <b style="padding:3px;">{{ $fotos->where('imgsp_cimgname','portada')->value('imgsp_titulo') }}</b><br>
                            <p>{{ $fotos->where('imgsp_cimgname','portada')->value('imgsp_pie') }}</p>
                            <b>Autor:</b> {{ $fotos->where('imgsp_cimgname','portada')->value('imgsp_autor') }}<br>
                            <b>Fecha:</b> {{ $fotos->where('imgsp_cimgname','portada')->value('imgsp_date') }} &nbsp;
                            <a href="/cedulas/{{ $fotos->where('imgsp_cimgname','portada')->value('imgsp_file') }}" target="new">Abrir imagen</a>
                        </div>
                    </div>
                @endif
            </center>
        </div>

        <!-- ------------------------- GALERÍA DE FOTOGRAFÍAS ------------------------>
        <div class="col-12 col-md-3 col-lg-3 center">
            <!-- ----------------------------------- Inicia imágenes superiores izquierdas ------------------------------------------------------ -->
            <!-- flecha -->
            <!--div class="center" style="text-align: center;">
                <i class="bi bi-arrow-up-circle" style="font-size: 170%; color:#87796d;; cursor: pointer;"></i>
            </div-->
            @foreach (['ppal1','ppal2','ppal3','ppal4','ppal5'] as $ppal)
                @if($fotos->where('imgsp_cimgname',$ppal)->value('imgsp_file') != '' )
                    <div class="ContenedorImg">
                        <img class="img-fluid mt-1 mt-sm-1 mt-md-1 mt-lg-1 PaClick" src="/cedulas/{{ $fotos->where('imgsp_cimgname',$ppal)->value('imgsp_file') }}" onclick="VerNoVer('foto','{{ $fotos->where('imgsp_cimgname',$ppal)->value('imgsp_id') }}')" style="width:100%;">
                        <div style="display:none; font-size:90%;" id="sale_foto{{ $fotos->where('imgsp_cimgname',$ppal)->value('imgsp_id') }}">
                            <b style="padding:3px;">{{ $fotos->where('imgsp_cimgname',$ppal)->value('imgsp_titulo') }}</b><br>
                            <p>{{ $fotos->where('imgsp_cimgname',$ppal)->value('imgsp_pie') }}</p>
                            <b>Autor:</b> {{ $fotos->where('imgsp_cimgname',$ppal)->value('imgsp_autor') }}<br>
                            <b>Fecha:</b> {{ $fotos->where('imgsp_cimgname',$ppal)->value('imgsp_date') }} &nbsp;
                            <a href="/cedulas/{{ $fotos->where('imgsp_cimgname',$ppal)->value('imgsp_file') }}" target="new">Abrir imagen</a>
                        </div>
                    </div>
                @endif
            @endforeach
            <!-- flecha -->
            <!--div class="center" style="text-align: center;">
                <i class="bi bi-arrow-down-circle" style="font-size: 170%; color:#87796d;; cursor: pointer;"></i>
            </div-->
            <!-- ----------------------------------- Termina imágenes superiores izquierdas ------------------------------------------------------ -->
        </div>
    </div>




    <!-- -------------------------------------- BLOQUE MEDIO FICHA E IMAGENES ----------------------------------------------->
    <!-- -------------------------------------- BLOQUE MEDIO FICHA E IMAGENES ----------------------------------------------->
    <!-- -------------------------------------- BLOQUE MEDIO FICHA E IMAGENES ----------------------------------------------->
    <div class="row" style="margin:5px; border-bottom-left-radius:8px;">

        <!-- -------------- CentroIzq: Menú izquierdo ----------------->
        <div class="col-12 col-sm-12 col-md-2" style="color:#efebe8;padding:40px;font-size:1.3em;background-color:#CDC6B9;">
            <H3>
                {{ $lenguas->where('clen_code',session('locale2'))->value('clen_autonimias') }}
            </H3>

            <nav class="navbar navbar-expand-md">

                <!-- --------- CentroIzq:  Menú Hamburguesa -------------- -->
                <button class="navbar-toggler"
                    data-toggle="collapse" type="button" data-bs-toggle="offcanvas" data-bs-target="#MenuEspecifico">
                    <span style="font-size:50%;">Menú</span><span class="navbar-toggler-icon"></span>
                </button>

                <!-- --------- CentroIzq: Menú Extendido -------------- -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="MenuEspecifico">
                    <div class="offcanvas-header">
                        <a class="offcanvas-logo" href="index.html" id="offcanvasNavbar2Label">
                            <img src="imagenes/logo-nav.png" alt="logo del Jardín Etnobotánico">
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <!-- titulos -->
                    @foreach ($titulos as $titulo)
                        <div class="px-0 py-2" style="font-size:90%;">
                            <a class="nolink" href="#IrA{{ $titulo->txt_id }}tit">
                                {!! $titulo->txt_codigo !!}
                            </a>
                        </div>
                    @endforeach
                </div>
            </nav>
        </div>

        <!-- -------------- CentroCtro: Texto central ----------------->
        <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7" style="background-color:#CDC6B9;">
            <?php $num=0; ?>
            @foreach($texto as $text)
                @if($text->txt_titulo == '1')
                    <div style="margin-top: 30px;">
                        <h4>
                            <a name="IrA{{ $text->txt_id }}tit">{!! $text->txt_codigo !!}</a>
                            @if($text->txt_audio != '')
                                <?php $num++; ?>
                                <i class="bi bi-volume-down-fill" style="cursor:pointer;display:inline; font-size:200%;vertical-align:middle;" onclick="Escucha('/cedulas/audios/{{ $text->txt_audio }}')"></i><span style="font-size:10px;">{{ $num }} {{-- $text->txt_audio --}}</span>
                            @endif
                        </h4>
                    </div>
                @else
                    <div class="my-2">
                        {!! $text->txt_codigo !!}
                        @if($text->txt_audio != '')
                            <?php $num++; ?>
                            {{-- <i class="bi bi-volume-down-fill" style="cursor:pointer;display:inline; font-size:200%;vertical-align:top;" onclick="Escucha('/cedulas/audios/{{ $text->txt_audio }}')"></i> --}}
                            <audio id="SpAudio{{ $text->txt_id }}">
                                <source src='/cedulas/audios/{{ $text->txt_audio }}' type="audio/ogg">
                                <source src='/cedulas/audios/{{ $text->txt_audio }}' type="audio/mpeg">
                                El navegador no soporta el audio
                            </audio>
                            <i class="bi bi-volume-down-fill" id="IconPlay{{ $text->txt_id }}" onclick="playAudio('{{ $text->txt_id }}')" style="cursor:pointer;display:inline; font-size:200%;vertical-align:top;"></i>
                            <i class="bi bi-volume-mute-fill" id="IconStop{{ $text->txt_id }}" onclick="pauseAudio('{{ $text->txt_id }}')" style="cursor:pointer;display:none; font-size:200%;vertical-align:top;"></i>
                            <span style="font-size:10px;">{{ $num }} {{-- $text->txt_audio --}}</span>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>

        <!-- -------------- CentroDerecha: Imágenes derecha ----------------->
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3" style="background-color:#CDC6B9;">
            <!-- lateralvideo1 -->
            @if($fotos->where('imgsp_cimgname','lateralvideo1')->value('imgsp_file') != '')
                <video width="40" height="40" controls>
                    <source src="" type="video/ogg">
                    Tu navegador no soporta el video
                </video>

            @endif

            <!-- Imágenes laterales -->
            @foreach (['lateral1','lateral2','lateral3','lateral4','lateral5','lateral6','lateral7','lateral8','lateral9','lateral10'] as $lat)
                @if($fotos->where('imgsp_cimgname',$lat)->value('imgsp_file') != '')
                    <div class="ContenedorImg" style="padding:15px;">
                        <img class="PaClick" src="/cedulas/{{ $fotos->where('imgsp_cimgname',$lat)->value('imgsp_file') }}" onclick="VerNoVer('foto','{{ $fotos->where('imgsp_cimgname',$lat)->value('imgsp_id') }}')" style="width:100%;">
                        <div style="display:none; font-size:90%;" id="sale_foto{{ $fotos->where('imgsp_cimgname',$lat)->value('imgsp_id') }}">
                            <b style="padding:3px;">{{ $fotos->where('imgsp_cimgname',$lat)->value('imgsp_titulo') }}</b><br>
                            <p>{{ $fotos->where('imgsp_cimgname',$lat)->value('imgsp_pie') }}</p>
                            <b>Autor:</b> {{ $fotos->where('imgsp_cimgname',$lat)->value('imgsp_autor') }}<br>
                            <b>Fecha:</b> {{ $fotos->where('imgsp_cimgname',$lat)->value('imgsp_date') }} &nbsp;
                            <a href="/cedulas/{{ $fotos->where('imgsp_cimgname',$lat)->value('imgsp_file') }}" target="new">Abrir imagen</a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>


    </div>

    <!-- -------------------------------------- BLOQUE INFERIOR AUTORÍAS ----------------------------------------------->
    <!-- -------------------------------------- BLOQUE INFERIOR AUTORÍAS ----------------------------------------------->
    <!-- -------------------------------------- BLOQUE INFERIOR AUTORÍAS ----------------------------------------------->
    <div class="row my-4 p-3" style="margin:5px; border-radius:8px; background-color:#87796d;">
        <!-- Cita -->
        <div class="col-12" style="margin:20px;">
            <h4>Forma de citar:</h4>
            <!-- autores -->    <b> @if($version['ced_cita']!=''){{ $version['ced_cita'] }} @else {{ $version['jardin'] }}@endif</b>.
            <!-- año -->        {{ date('Y', strtotime($version['ced_versiondate'])) }}.
            <!-- nombre/lengua --> <u>{{ $version['ced_nombre'] }} / {{ $idioma }}</u>
            <!-- version -->    (V. {{ $version['ced_version'] }}).
            <!-- jardin --> Cédulas de {{ $version['jardin'] }}
            <!-- lengua --> en {{ $idioma2 }}<br>
            <!-- registro doi-->
            <!-- url --> @if($version['ced_doi'] != '') https://doi.org/{{ $version['ced_doi'] }} @else {{ url()->current() }} @endif accesado el {{ date('d') }} de {{ ['0','enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'][date('n')] }} de {{ date('Y') }}
        </div>
        <div class="col-12" style="margin:20px;">
            <b>Versiones previas:</b>
                @if(count($version['versiones']) > 0)
                    @foreach ($version['versiones'] as $i)
                        {{ $i->cedv_cedversion }},
                    @endforeach
                @else
                    Aún no existen versiones previas.
                @endif

        </div>



        <div class="col-12" style="margin:20px;">
            <!-- Yo tengo algo que aportar -->
            <a href="#AporteUsrs" class="nolink">
                <div class=""style="margin-left:20px; display:inline-block;" >
                    <img src="/cedulas/BotonAportar.png" wire:click="VerMensaje('1')" class="PaClick" style="height:90px;border:2px solid rgb(61, 41, 33);border-radius:15px;">
                </div>
            </a>

            <!-- Redes sociales -->
            <div style="width:300px; display:inline-block;margin:15px;vertical-align:middle;text-align:center;">
                <div style="background-color: rgb(66, 42, 20);color:white;padding:4px;padding:2px; font-size:90%;text-align:center;" class="center">
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
                </div>
            </div>
            <!-- Código QR -->
            <div  style="display: inline;">
                <span wire:click="VerQR()" class="PaClick">
                    {!! QrCode::margin(2)
                        ->size($qrSize)
                        ->backgroundColor(205,198,185)
                        ->color(32,45,45)
                        ->generate( url('/').'/sp/'.$url.'/'.$jardin)
                        !!}
                </span>
                <span wire:click="BajarQR()" class="PaClick" style="margin:5px;vertical-align:bottom;">
                    <i class="bi bi-cloud-download"> </i>
                </span>
            </div>
            <!-- Licencia GNU -->
            <div class="col-12" style="margin:20px; font-size:80%;">
                Copyright(C), {{ date('Y', strtotime($version['ced_versiondate'])) }} @if($version['ced_cita']!=''){{ $version['ced_cita'] }} @else {{ $version['jardin'] }}@endif.
                Se concede permiso para copiar, distribuir y/o modificar este documento
                bajo los términos de la <a href="https://www.gnu.org/licenses/fdl-1.3.html" target="new" class="nolink"><u>Licencia de Documentación Libre de GNU</u></a>, Versión 1.3
                o cualquier versión posterior publicada por la Free Software Foundation;
                sin Secciones Invariantes, Textos de Portada y Textos de Contraportada.<br>
                <!--Se incluye una copia de la licencia en la sección titulada "Licencia de Documentación Libre de GNU". -->

            </div>
        </div>
    </div>


    <div>
        @if($verMsg=='1')
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
                    </div>aaa{{ $CedId }}
                </div>
            @else
                Para poder aportar o ver los comentarios aportados, debes registrarte primero  en el sitio.<br>
                <a href="/ingreso">Ingresar con mi cuenta</a> &nbsp; &nbsp; <a href="/nuevousr">Crear una cuenta</a>
            @endif
        @endif
    </div>

    <div>
        @if($aportes->count() > 0)
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
        @endif
    </div>

    @section('scripts')
        <script>
            $('.owl-carousel').owlCarousel({
                loop:true,
                margin:10,
                nav:true,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:3
                    },
                    1000:{
                        items:5
                    }
                }
            })
        </script>

    @endsection

</div>
