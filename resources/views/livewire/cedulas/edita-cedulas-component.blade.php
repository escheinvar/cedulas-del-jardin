<div>
    <div class="container">
        <!-- -------------------------------------- BLOQUE SUPERIOR FICHA E IMAGENES ----------------------------------------------->
        <!-- -------------------------------------- BLOQUE SUPERIOR FICHA E IMAGENES ----------------------------------------------->
        <!-- -------------------------------------- BLOQUE SUPERIOR FICHA E IMAGENES ----------------------------------------------->
        <div class="row" style="margin:5px; border-radius:8px; ">
            <!-- ------------------------- FICHA GENERAL IZQUIERDA ------------------------>
            <div class="col-12 col-md-4 col-lg-3 text-wrap" style="position:relative; padding:10px; border-top-left-radius:8px; background-color:#CDC6B9;">
                <center>
                    <a href="/catCedulas" class="nolink"> <i class="bi bi-arrow-left"></i>
                        Regresar al catálogo
                    </a>
                    <h1>Editor de cédulas</a></h1>
                </center>
                <!-- ------------------------- Logo del Jardín propietario de la cédula ------------------------>
                <div class="row pb-2" style="">
                    <div class="col-12 py-2" style="text-align: center; color:#202d2d; font-family: 'Noto Serif JP', serif; text-align:center; font-size:130%; font-weigth:bold;">
                        <a href="/sp/{{ $urlced->ced_urlurl }}/{{ $jardinData->cjar_siglas }}" class="nolink">
                            {{ $jardinData->cjar_nombre }}<br>
                            <img src="@if($jardinData->cjar_logo=='')/avatar/jardines/default.png @else /avatar/jardines/{{ $jardinData->cjar_logo }} @endif" style="width:80px;"><br>
                        </a>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-12">
                        <center>
                            <!-- Datos de cédlula: nombre y lengua -->
                            <h3>{{ $urlced->url_nombre }}<br>
                            {{ $urlced->clen_lengua }} ({{ $urlced->ced_clencode }})</h3>
                            <!-- Datos y botón de estado -->
                            <h3 class="my-4">
                                <div style="">
                                    @if($urlced->ced_edo=='0')
                                        <i class="bi bi-0-circle-fill" style="color:red;"> En elaboración</i><br>
                                        <button wire:click="EnviarCedula('2')" wire:confirm="Estás por iniciar el proceso de edición. ¿Deseas continuar?" class="btn btn-primary my-2">
                                            Terminar elaboración
                                        </button>
                                    @elseif($urlced->ced_edo=='1')
                                        <i class="bi bi-1-circle-fill" style="color: #CD7B34;">En corrección</i><br>
                                        <button wire:click="EnviarCedula('2')" wire:confirm="Estás por iniciar el proceso de publicación. No podrás ver la cédula hasta que concluya este proceso. ¿Deseas continuar?" class="btn btn-primary my-2">
                                            Terminar corrección
                                        </button>
                                    @elseif($urlced->ced_edo=='2'  OR $urlced->ced_edo=='4')
                                        @if($urlced->ced_edo=='2') <i class="bi bi-2-circle-fill" style="color:purple;"> @else <i class="bi bi-4-circle-fill" style="color:purple;"> @endif En revisión</i><br>
                                        <button wire:click="EnviarCedula('5')" wire:confirm="Estás por liberar al público esta cédula. ¿Deseas continuar?" class="btn btn-primary my-2">
                                            Publicar
                                        </button>
                                        <button onclick="VerNoVer('Notas','Correccion')" class="btn btn-primary my-2">
                                            Corregir
                                        </button>
                                        <!-- notas de correccion-->
                                        <div id="sale_NotasCorreccion" style="display:none;">
                                            <span style="font-size: 80%">Describe las correcciones solicitadas</span><br>
                                            <textarea wire:model="NotasDeCorreccion" class="form-control"></textarea>
                                            <button wire:click="@if($urlced->ced_edo=='2') EnviarCedula('1') @else EnviarCedula('3') @endif"  class="btn btn-primary my-2">
                                                Solicitar corrección
                                            </button>
                                        </div>
                                    @elseif($urlced->ced_edo=='3')
                                        <i class="bi bi-3-circle-fill" style="color:#CD7B34;">En edición</i>
                                        <button wire:click="EnviarCedula('4')" wire:confirm="Estás por iniciar el proceso de publicación. No podrás ver la cédula hasta que concluya este proceso. ¿Deseas continuar?" class="btn btn-primary my-2">
                                            Terminar edición
                                        </button>
                                    @elseif($urlced->ced_edo=='4') <i class="bi bi-4-circle-fill" style="color:purple;">En autorización</i>
                                        <button wire:click="EnviarCedula('5')" wire:confirm="Estás por liberar al público esta cédula. ¿Deseas continuar?" class="btn btn-primary my-2">
                                            Publicar
                                        </button>
                                        <button onclick="VerNoVer('Notas','Correccion')" class="btn btn-primary my-2">
                                            Corregir
                                        </button>
                                    @elseif($urlced->ced_edo=='5') <i class="bi bi-5-circle-fill" style="color:darkgreen;"> Públicada</i>
                                    @endif


                                </div>
                            </h3>
                        </center>
                    </div>
                </div>

                <div class="row">
                    <!-- ---------- subir nueva imagen --------------------- -->
                    @if($cedulas >'0')
                        <h5>Imágenes</h5>
                        <div class="col-12 ">
                            <input type="file" wire:model="NvaImagen" class="form-control my-2" style="width:100%;" accept="image/*, video/*"  enctype="multipart/form-data" >
                            @error('NvaImagen')<error>{{ $message }}</error>@enderror
                            <div wire:loading.attr="block" wire:target="NvaImagen" style="display: none;">
                                Cargando imágen...
                            </div>
                        </div>
                        <div class="col-12">
                            <select wire:model.live="NvaImagenTipo" class="form-select">
                                <option value="">Indica el lugar en el que va la imagen</option>
                                @foreach ($tipoImgs as $img)
                                    <option value="{{ $img->cimg_name }}">{{ $img->cimg_name }}</option>
                                @endforeach
                            </select>
                            @error('NvaImagenTipo')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Metadatos de imagen -->
                        @if($NvaImagen != '' AND $NvaImagenTipo != '')
                            <div class="col-6">
                                <label class="form-label">Fecha</label>
                                <input wire:model='NvaImgDate' type="date" class="form-control">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Autor</label>
                                <input wire:model='NvaImgAutor' type="text" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Titulo</label>
                                <input wire:model='NvaImgTitulo' type="text" class="form-control">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Descripción</label>
                                <textarea wire:model='NvaImgDescr' class="form-control"></textarea>
                            </div>
                            <div class="col-12">
                                <button wire:click="SubirFoto()" wire:loadding.attr="disabled" class="btn btn-sm btn-secondary" style="margin:5px;">Subir</button>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- ------------------------- FOTO DE LA PORTADA ------------------------>
            <div class="col-sm-12 col-md-4 col-lg-5" style="vertical-align:middle;center">
                <center>
                    @if($fotos->where('imgsp_cimgname','portada')->value('imgsp_file') != '')
                        <!-- foto -->
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

                        @if($cedulas >'0')
                            <!-- botón borrar -->
                            <div class="PaClick" wire:click="BorraFoto('portada')" wire:confirm="Estás por elminar PERMANENTEMENTE una foto para todo el Jardín. ¿Deseas continuar?" style="display:inline;vertical-align:bottom;">
                                <i class="bi bi-trash" style="color:gray;"><small>portada</small></i>
                            </div>
                        @endif
                    @else
                        <!-- subir nueva imagen -->
                        <div class="form-group" style="border:1px dotted gray;color:gray; padding:10px;">
                            Imagen portada
                        </div>
                    @endif
                </center>
            </div>

            <!-- ------------------------- GALERÍA DE FOTOGRAFÍAS ------------------------>
            <div class="col-sm-12 col-md-3 col-lg-3 center">
                <!-- ----------------------------------- Inicia imágenes superiores izquierdas ------------------------------------------------------ -->
                @foreach (['ppal1','ppal2','ppal3','ppal4','ppal5','ppal6'] as $ppal)
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
                        @if($cedulas >'0')
                            <!-- botón borrar -->
                            <div class="PaClick" wire:click="BorraFoto('{{ $ppal }}')"  wire:confirm="Estás por elminar PERMANENTEMENTE una foto para todo el Jardín. ¿Deseas continuar?"  style="display:block;vertical-align:bottom;color:gray;">
                                <i class="bi bi-trash"><small>{{ $ppal }}</small></i>
                            </div>
                        @endif
                    @else
                        <div class="form-group" style="border:1px dotted gray;color:gray; padding:10px;">
                            Imagen {{ $ppal }}
                        </div>
                    @endif
                @endforeach
                <!-- ----------------------------------- Termina imágenes superiores izquierdas ------------------------------------------------------ -->
            </div>
        </div>




        <!-- -------------------------------------- BLOQUE MEDIO FICHA E IMAGENES ----------------------------------------------->
        <!-- -------------------------------------- BLOQUE MEDIO FICHA E IMAGENES ----------------------------------------------->
        <!-- -------------------------------------- BLOQUE MEDIO FICHA E IMAGENES ----------------------------------------------->
        <div class="row" style="margin:5px; border-bottom-left-radius:8px;">
            <!-- -------------- Menú izquierdo ----------------->
            <div class="col-12 col-sm-12 col-md-2" style="color:#efebe8;  padding:20px; font-size:1.3em; background-color:#CDC6B9;">
                {{-- <H3>
                    {{ $lenguas->where('clen_code',session('locale2'))->value('clen_autonimias') }}
                </H3> --}}

                <nav class="navbar navbar-expand-md" >

                    <!-- --------- Menú Hamburguesa -------------- -->
                    <button class="navbar-toggler"
                        data-toggle="collapse" type="button" data-bs-toggle="offcanvas" data-bs-target="#MenuEspecifico">
                        <span style="font-size:50%;">Menú</span><span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- --------- Menú Extendido -------------- -->
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="MenuEspecifico">
                        <div class="offcanvas-header">
                            <a class="offcanvas-logo" href="index.html" id="offcanvasNavbar2Label">
                                <img src="/imagenes/logo-nav.png" alt="logo del Jardín Etnobotánico">
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

            <!-- -------------- Texto central ----------------->
            <!-- -------------- Texto central ----------------->
            <!-- -------------- Texto central ----------------->
            <div class="col-12 col-sm-12 col-md-7 col-lg-7" style="background-color:#CDC6B9;">
                @foreach($texto as $text)
                    <div class="row" style="@if($text->txt_id==$TxtIdEnEdicion) border:3px solid #CD7B34; @endif">
                            <!-- muestra número de orden del párrafo e ícono de editar  -->
                            <div wire:click="DeterminaParrafoAeditar('{{ $text->txt_id }}')" class="PaClick" style="color:#CD7B34;">
                                <i class="bi bi-arrow-90deg-down"></i>
                                Orden {{ $text->txt_order }} &nbsp; | &nbsp;
                                ID: {{ $text->txt_id}} &nbsp; | &nbsp;
                                V: {{ $text->txt_version }}
                                    <i class="bi bi-pencil-square"></i>
                                    <i class="bi bi-arrow-down"></i>
                            </div>
                            <!-- muestra título (en su caso) -->
                            @if($text->txt_titulo == '1')
                                <div class="col-12" style="margin-top: 30px;">
                                    <!-- muestra título -->
                                    <h4>
                                        <a name="IrA{{ $text->txt_id }}tit">{!! $text->txt_codigo !!}</a>
                                        @if($text->txt_audio != '')
                                            <i class="bi bi-volume-down-fill" style="cursor:pointer;display:inline; font-size:200%;vertical-align:middle;" onclick="Escucha('/cedulas/audios/{{ $text->txt_audio }}')"></i><span style="font-size:10px;">{{ $text->txt_id }}</span>
                                        @endif
                                    </h4>
                                </div>
                            <!-- muestra párrafo (en su caso)-->
                            @else
                                <div class="col-12 my-2">
                                    {!! $text->txt_codigo !!}
                                    <!-- audio-->
                                    @if($text->txt_audio != '')
                                        {{-- <i class="bi bi-volume-down-fill" style="cursor:pointer;display:inline; font-size:200%;vertical-align:top;" onclick="Escucha('/cedulas/audios/{{ $text->txt_audio }}')"></i> --}}
                                        <audio id="SpAudio{{ $text->txt_id }}">
                                            <source src='/cedulas/audios/{{ $text->txt_audio }}' type="audio/ogg">
                                            <source src='/cedulas/audios/{{ $text->txt_audio }}' type="audio/mpeg">
                                            El navegador no soporta el audio
                                        </audio>
                                        <i class="bi bi-volume-down-fill" id="IconPlay{{ $text->txt_id }}" onclick="playAudio('{{ $text->txt_id }}')" style="cursor:pointer;display:inline; font-size:200%;vertical-align:top;"></i>
                                        <i class="bi bi-volume-mute-fill" id="IconStop{{ $text->txt_id }}" onclick="pauseAudio('{{ $text->txt_id }}')" style="cursor:pointer;display:none; font-size:200%;vertical-align:top;"></i>
                                        <span style="font-size:10px;">{{$text->txt_id }}</span>
                                    @endif
                                </div>
                            @endif

                            <!-- --------------------------------------- -->
                            <!-- ------------- EDITOR DE PÁRRAFO ------- -->
                            <!-- --------------------------------------- -->
                            @if($text->txt_id == $TxtIdEnEdicion)
                                <div class="col-12" style="background-color:#87796d;">
                                    <div class="row my-1">
                                        <!-- selector titulo/parrafo -->
                                        <div class="col-6 col-md-4 form-group">
                                            <label class="form-label">Tipo</label><br>
                                            <div class="form-check" style="display:inline-block">
                                                <input wire:model.live="NvoTitulo" class="form-check-input" type="radio" value="1">
                                                <label class="form-check-label">Título</label>
                                            </div>
                                            <div class="form-check" style="display:inline-block">
                                                <input wire:model.live="NvoTitulo" class="form-check-input" type="radio" value="0">
                                                <label class="form-check-label">Párrafo</label>
                                            </div>
                                        </div>
                                        <!-- Orden -->
                                        <div class="col-6 col-md-4 form-group">
                                            <label class="form-label">Orden:</label><br>
                                            <input wire:model="NvoOrder" type="number" class="form-control" style="width:120px; display:inline-block;">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <small onclick="VerNoVer('ver','Manual')" class="PaClick"><i class="bi bi-info-circle"></i> Manual HTML</small>
                                        </div>
                                        <!-- manual HTML -->
                                        <div id="sale_verManual" class="col-12 my-2" style="display:none;">
                                            <center><b>Manual Rápido de HTML:</b></center><br>                                            <div style="display:inline-block; width:45%;">
                                                Negritas: &#60;b&#62;<b>negritas</b>&#60;/b&#62;<br>
                                                Cursivas: &#60;i&#62;<i>cursiva</i>&#60;/i&#62;<br>
                                                Subrayado: &#60;u&#62;<u>subrayado</u>&#60;/u&#62;<br>
                                            </div>
                                            <div style="display:inline-block; width:45%;">
                                                Tachado: &#60;s&#62;<s>subrayado</s>&#60;/s&#62;<br>
                                                Superíndice: A&#60;sup&#62;<sup>superí.</sup>&#60;/sup&#62;<br>
                                                Subíndice: A&#60;sub&#62;<sub>subí.</sub>&#60;/sub&#62;<br>
                                                Salto de línea: &#60;br&#62;<br>
                                            </div>
                                        </div>
                                        <!-- editor del texto de título o de párrafo -->
                                        <div class="col-12 my-2 form-group">
                                            <label class="form-label">Texto html:</label><br>
                                            @if($NvoTitulo=='1')
                                                <input wire:model="NvoCodigo" type="text" class="form-control">
                                            @else
                                                <textarea rows="7" wire:model="NvoCodigo" class="form-control"></textarea>
                                            @endif
                                            <hr>
                                        </div>
                                        <!-- audio -->
                                        <div class="col-12 col-md-6 form-group">
                                            @if($text->txt_audio != '')
                                                <audio controls>
                                                    <source src='/cedulas/audios/{{ $text->txt_audio }}' type="audio/ogg">
                                                    <source src='/cedulas/audios/{{ $text->txt_audio }}' type="audio/mpeg">
                                                    Your browser does not support the audio element.
                                                </audio>
                                                <!-- borrar audio -->
                                                <div class="form-check" style="display:inline-block;">
                                                    <input wire:model="DelAudio" class="form-check-input" type="checkbox" value="false">
                                                    <label class="form-check-label"> Eliminar audio</label>
                                                </div>
                                                <!-- oir audio -->
                                            @else
                                                <!-- nuevo audio -->
                                                <label class="form-label">Audio</label>
                                                <input type="file" wire:model="NvoAudio" class="form-control">
                                            @endif
                                            {{-- @if($NvoTitulo=='1') <br>Se sugiere no crear audios en los títulos y leer el título como parte del primer párrafo siguiente @endif --}}
                                        </div>

                                        @if($cedulas >'0')
                                            <!-- video -->
                                            <div class="col-12 col-md-6 form-group">
                                                @if($text->txt_video != '')
                                                    <!-- ver video-->
                                                    <label class="label" style="font-size: 60%;">{{ $text->txt_video }}</label>
                                                    <video width='95%' controls wire:ignore>
                                                        <source src='/cedulas/{{ $text->txt_video }}' type='video/mp4'>
                                                    </video>
                                                    <!-- eliminar video-->
                                                    <div class="form-check" style="display:inline-block;">
                                                        <input wire:model="DelVideo" class="form-check-input" type="checkbox" value="false">
                                                        <label class="form-check-label">Eliminar video</label>
                                                    </div>
                                                @else
                                                    <!-- nuevo video-->
                                                    <label class="form-label">Video</label>
                                                    <input type="file" wire:model="NvoVideo" class="form-control">
                                                @endif
                                            </div>

                                            <!-- img1 -->
                                            <div class="col-12 col-md-4 form-group">
                                                @if($text->txt_img1 != '')
                                                    <!-- ver img1 -->
                                                    <label class="label" style="font-size: 60%;">{{ $text->txt_img1 }}</label>
                                                    <img src="/cedulas/{{ $text->txt_img1 }}" style="width:95%;">
                                                    <!-- eliminar img1-->
                                                    <div class="form-check" style="display:inline-block;">
                                                        <input wire:model="DelImg1" class="form-check-input" type="checkbox" value="false">
                                                        <label class="form-check-label">Eliminar img1</label>
                                                    </div>
                                                @else
                                                    <!-- nuevo img1 -->
                                                    <label class="form-label">Imagen 1</label>
                                                    <input type="file" wire:model="NvoImg1" class="form-control">
                                                @endif
                                            </div>

                                            <!-- img2 -->
                                            <div class="col-12 col-md-4 form-group">
                                                @if($text->txt_img2 != '')
                                                    <!-- ver img2 -->
                                                    <label class="form-label" style="font-size: 60%;">{{ $text->txt_img2 }}</label>
                                                    <img src="/cedulas/{{ $text->txt_img2 }}" style="width:95%;">
                                                    <!-- eliminar img2-->
                                                    <div class="form-check" style="display:inline-block;">
                                                        <input wire:model="DelImg2" class="form-check-input" type="checkbox" value="false">
                                                        <label class="form-check-label">Eliminar img2</label>
                                                    </div>
                                                @else
                                                    <!-- nuevo img2 -->
                                                    <label class="form-label">Imagen 2</label>
                                                    <input type="file" wire:model="NvoImg2" class="form-control">
                                                @endif
                                            </div>

                                            <!-- img3 -->
                                            <div class="col-12 col-md-4 form-group">
                                                @if($text->txt_img3 != '')
                                                    <!-- ver img3 -->
                                                    <label class="form-label">{{ $text->txt_img3 }}</label>
                                                    <img src="/cedulas/{{ $text->txt_img3 }}" style="width:95%;">
                                                    <!-- eliminar img3 -->
                                                    <div class="form-check" style="display:inline-block;">
                                                        <input wire:model="DelImg3" class="form-check-input" type="checkbox" value="false">
                                                        <label class="form-check-label">Eliminar img3</label>
                                                    </div>
                                                @else
                                                    <!-- nueva img3 -->
                                                    <label class="form-label" style="font-size: 60%;">Imagen 3</label>
                                                    <input type="file" wire:model="NvoImg3" class="form-control">
                                                @endif
                                            </div>
                                        @endif


                                        <!-- botón de guardar-->
                                        <div class="col-4 my-4">
                                            <button wire:click="GuardarCambios()" wire:loading.attr="disabled" class="btn btn-primary"><i class="bi bi-save"></i>
                                                <span wire:loading.remove>Guardar cambios</span>
                                                <span wire:loading style="display:none;"> <red> ... guardando ...</red> </span>
                                            </button>
                                        </div>
                                        <div class="col-4 my-4">
                                            <button wire:click="CancelaCambio()" class="btn btn-secondary"><i class="bi bi-x-circle"></i>
                                                Cancelar cambios
                                            </button>
                                        </div>
                                        <div class="col-4 my-4">
                                            <button wire:click="BorrarParrafo('{{ $text->txt_id }}')" wire:confirm="Estas por eliminar PERMANENTEMENTE este párrafo. ¿Quieres continuar?" class="btn btn-danger">
                                                <span wire:loading.remove> <i class="bi bi-trash"></i> Eliminar párrafo </span>
                                                <span wire:loading style="display:none;"> <red> ... eliminando ...</red> </span>

                                            </button>
                                        </div>
                                        <span style="font-size: 80%;">Versión del párrafo: {{ $text->txt_version }} &nbsp; &nbsp;
                                        <div class="form-check" style="display:inline-block;">
                                            <!-- input class="form-check-input" type="checkbox" value="false" wire:model="NvaVersion">
                                            <label class="form-check-label">Avanzar versión</label -->
                                        </div>
                                        </span>
                                    </div>
                                </div>
                            @endif
                    </div>
                @endforeach

                <div class="row m-4">
                    <button wire:click="NuevoParrafo()" wire:loadding.attr="disabled" class="boton2" style="height:90px;font-size:150%;">
                        <span wire:loading.remove>Crear Nuevo Párrrafo</span>
                        <span wire:loading style="display:none;"> <red> ... creando ...</red> </span>
                    </button>
                </div>
            </div>


            <!-- -------------- Imágenes derecha ----------------->
            <div class="col-12 col-sm-12 col-md-3 col-lg-3" style="background-color:#CDC6B9;">

                <!-- lateralvideo1 -->
                @if($fotos->where('imgsp_cimgname','lateralvideo1')->value('imgsp_file') != '')
                    <video width="100%"  controls wire:ignore>
                        <source src="/cedulas/{{ $fotos->where('imgsp_cimgname','lateralvideo1')->value('imgsp_file') }} }}" type="video/ogg">
                        Tu navegador no soporta el video
                    </video>
                    @if($cedulas >'0')
                        <!-- botón borrar -->
                        <div class="PaClick" wire:click="BorraFoto('lateralvideo1')"  wire:confirm="Estás por elminar PERMANENTEMENTE una foto para todo el Jardín. ¿Deseas continuar?" style="display:inline-block;vertical-align:bottom;">
                            <i class="bi bi-trash"><small>lateralvideo1</i>
                        </div>
                    @endif
                @else
                    <div class="form-group" style="border:1px dotted gray;color:gray; padding:10px;margin:5px;">
                        lateralvideo1 (sólo video)
                    </div>
                @endif

                <!-- Imágenes laterales -->
                @foreach (['lateral1','lateral2','lateral3','lateral4','lateral5','lateral6','lateral7','lateral8','lateral9','lateral10'] as $lat)
                    @if($fotos->where('imgsp_cimgname',$lat)->value('imgsp_file') != '')
                        <div class="ContenedorImg">
                        <img class="PaClick" src="/cedulas/{{ $fotos->where('imgsp_cimgname',$lat)->value('imgsp_file') }}" onclick="VerNoVer('foto','{{ $fotos->where('imgsp_cimgname',$lat)->value('imgsp_id') }}')" style="width:100%;">
                        <div style="display:none; font-size:90%;" id="sale_foto{{ $fotos->where('imgsp_cimgname',$lat)->value('imgsp_id') }}">
                            <b style="padding:3px;">{{ $fotos->where('imgsp_cimgname',$lat)->value('imgsp_titulo') }}</b><br>
                            <p>{{ $fotos->where('imgsp_cimgname',$lat)->value('imgsp_pie') }}</p>
                            <b>Autor:</b> {{ $fotos->where('imgsp_cimgname',$lat)->value('imgsp_autor') }}<br>
                            <b>Fecha:</b> {{ $fotos->where('imgsp_cimgname',$lat)->value('imgsp_date') }} &nbsp;
                            <a href="/cedulas/{{ $fotos->where('imgsp_cimgname',$lat)->value('imgsp_file') }}" target="new">Abrir imagen</a>
                        </div>
                    </div>
                        @if($cedulas >'0')
                            <!-- botón borrar -->
                            <div class="PaClick" wire:click="BorraFoto('{{ $lat }}')"  wire:confirm="Estás por elminar PERMANENTEMENTE una foto para todo el Jardín. ¿Deseas continuar?"  style="display:block;vertical-align:bottom;color:gray;">
                                <i class="bi bi-trash"><small>{{ $lat }}</small></i>
                            </div>
                        @endif
                    @else
                        <div class="form-group" style="border:1px dotted gray;color:gray; padding:10px;">
                            Imagen {{ $lat }}
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- -------------------------------------- BLOQUE INFERIOR AUTORÍAS ----------------------------------------------->
        <!-- -------------------------------------- BLOQUE INFERIOR AUTORÍAS ----------------------------------------------->
        <!-- -------------------------------------- BLOQUE INFERIOR AUTORÍAS ----------------------------------------------->
        <div class="row my-4 p-3" style="margin:5px; border-radius:8px; background-color:#87796d;">
            <div class="col-12 " style="">
                <!-- -------------------------------- Versión ------------------------------->
                <h4>Versión</h4>
                id {{ $version['ced_id'] }} {{ $version['cedula'] }}<br>
                Versión: {{  $version['ced_version'] }}  ({{ $version['ced_versiondate'] }})
                &nbsp; &nbsp;
                @if($cedulas >'0')
                    <span onclick="VerNoVer('ver','Versionar')" class="PaClick"><i class="bi bi-git"></i> Versionar/DOI</span>  &nbsp; &nbsp; &nbsp;
                    <a href="{{ '/sppdf/'.$urlced->ced_id.'/pdf' }}" target="new" class="nolink"><i class="bi bi-filetype-pdf"></i> pdf</a>
                    <div id="sale_verVersionar" style="display:none;">
                        <button wire:click="NuevaVersion()" wire:loadding.attr="disabled" wire:confirm="Vas a generar una nueva versión pública de la Cédula. Esto afecta la referencia bibliográfica (cambiará el año al de la nueva versión). Como parte del proceso, los contadores de versión de cada párrafo se van a reiniciar. ¿Quieres continuar? " class="btn btn-primary">
                            Avanzar a versión {{ $version['ced_version'] + 0.1 }}
                        </button>
                        <button class="btn btn-secondary" onclick="VerNoVer('ver','Versionar')">
                            Cancelar
                        </button>
                        @if($cedulas =='2')
                            <div style="">
                                <label class="form-label">DOI:</label>
                                <input wire:model="NvoDoi" type="text" class="form-control" style="width:50%;">
                                @error('NvoDoi')<error>{{ $message }}</error>@enderror
                                <button wire:click="NuevoDoi()" class="btn btn-primary">Registra DOI</button>
                                <button class="btn btn-secondary" onclick="VerNoVer('ver','Versionar')">
                                    Cancelar
                                </button>
                            </div>
                        @else
                            <div>
                                Solo el admin. global de cédulas puede ingresar un DOI<br>
                                doi: {{ $NvoDoi }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>
            <!-- -------------------------------- Versiones previas ------------------------------->
            <div class="col-12 " style="">
                <div>
                    <b>Versiones previas:</b>
                        @if(count($version['versiones']) > 0)
                            @foreach ($version['versiones'] as $i)
                                {{ $i->cedv_cedversion }},
                            @endforeach
                        @else
                            Aún no hay versiones.
                        @endif
                    </div>
                    <br>
                </div>

            <div class="col-12">
                <br>
                <h4>Forma de citar:</h4>
                @if($cedulas >'0')
                    <div id="sale_NuevoAutor" style="display:none;">
                        <label>Autor(es):</label><br>
                        <input type="text" wire:model="NvaCita" class="form-control" style="width:400px;display:inline-block;">
                        <button wire:click="NuevaCita()" class="btn btn-primary btn-sm">
                            Guardar autor
                        </button>
                        <button class="btn btn-secondary btn-sm" onclick="VerNoVer('Nuevo','Autor')">
                            Cancelar
                        </button>
                    </div>
                @else
                    <b>{{ $NvaCita }}</b>
                @endif

                @if($cedulas >'0') <i class="bi bi-pencil-square PaClick" onclick="VerNoVer('Nuevo','Autor')"></i> @endif
                <!-- autores -->    <b>{{ $version['ced_cita'] }}</b>.
                <!-- año -->        {{ date('Y', strtotime($version['ced_versiondate'])) }}.
                <!-- nombre/lengua --> <u>{{ $version['ced_nombre'] }} / {{ $urlced->ced_clencode }}</u>
                <!-- version -->    (V. {{ $version['ced_version'] }}).
                <!-- jardin --> Cédulas de {{ $version['jardin'] }}
                <!-- lengua --> en {{ $version['idioma2'] }}<br>
                <!-- registro doi--> @if($version['ced_doi'] != '') https://doi.org/{{ $version['ced_doi'] }} @endif
                <br>
                Formato de cita:<br>
                <b>Apellido1, N1.</b>, <b>Apellido2, N2. </b> y <b> Apellido3, N3.</b> &nbsp; &nbsp; Año  &nbsp; &nbsp; <u> Tema &nbsp; / &nbsp; Lengua </u>  &nbsp; &nbsp; (Versión)  &nbsp; &nbsp; Cédulas del -Nombre del jardín-  &nbsp; &nbsp; en lengua.
                <br><br>
            </div>

            <div class="col-12 " style="">
                <h4>Personas involucradas con la cédula:</h4>
                Rol <b>cedula general</b>:
                @foreach($roles->where('rol_crolrol','cedulas')->where('rol_tipo1','todas') as $r)
                    {{ $r->usrname }}: {{ $r->email }} &nbsp; |
                @endforeach
                <br>
                Rol <b>cedula</b> en {{ $jardinData->cjar_siglas  }}:
                @foreach($roles->where('rol_crolrol','cedulas')->where('rol_tipo1',$jardinData->cjar_siglas) as $r)
                    {{ $r->usrname }}: {{ $r->email }} &nbsp; |
                @endforeach
                <br>
                Rol <b>traduce</b> en {{$jardinData->cjar_siglas }} y lengua {{ $urlced->ced_clencode }}:</b>
                @foreach($roles->where('rol_crolrol','traduce')->where('rol_tipo1',$jardinData->cjar_siglas)->where('rol_tipo2',$urlced->ced_clencode) as $r)
                    {{ $r->usrname }}: {{ $r->email }} &nbsp; |
                @endforeach
            </div>
        </div>
    </div>

    <!-- ------------------------- Modal de imágenes ---------------------------------- -->
    <livewire:cedulas.edita-ceds-agregaimagen-modal-component imgId='{{$NvaImagenTipo}}' />

</div>


