@section('title') Admin Imágenes @endsection
@section('meta-description') Módulo administrador de imágenes @endsection
@section('cintillo-ubica') &nbsp; @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection

<div>
    <h2>Administración de Imágenes</h2>
    <div  style="font-size: 80%;color:grey;">
        Este catálogo es administrado por los roles
        <b style="@if(in_array('webmaster',session('rol'))) color:green; @endif">Webmaster</b> y
        <b style="@if(in_array('editor',session('rol'))) color:green; @endif">editor</b>
         en jardin: {{ implode(',',$editjar) }}
        (@if($edit=='0') <error style="font-size: 90%;"> No autorizado</error> @else <span style="font-size:90%;color:green;"> Autorizado </span>@endif)
    </div>

    <div class="row">
        <!-- Buscar por Jardín-->
        <div class="col-6 col-md-2 form-group">
            <label id="BuscaJardin" class="form-label">Jardín<red>*</red></label>
            <select wire:model.live="BuscaJardin" id="BuscaJardin" class="@error('BuscaJardin') is-invalid @enderror form-select">
                <option value="">Todos</option>
                @foreach ($jardines as $j)
                    <option value="{{ $j->cjar_siglas }}">{{ $j->cjar_siglas }}</option>
                @endforeach
            </select>
            <div class="form-text"></div>
            @error('BuscaJardin')<error>{{ $message }}</error>@enderror
        </div>

        <!-- Buscar por módulo -->
        <div class="col-6 col-md-2 form-group">
            <label id="BuscaMod" class="form-label">Módulo<red>*</red></label>
            <select wire:model.live="BuscaMod" id="BuscaMod" class="@error('BuscaMod') is-invalid @enderror form-select">
                <option value="">Indicar alguno</option>
                @foreach ($modulos as $m)
                    <option value="{{ $m->cimg_modulo }}">{{ $m->cimg_modulo }} </option>
                @endforeach
            </select>
            <div class="form-text"></div>
            @error('BuscaMod')<error>{{ $message }}</error>@enderror
        </div>

        <!-- Buscar por Url -->
        <div class="col-6 col-md-2 form-group">
            <label id="BuscaUrl" class="form-label">Url<red>*</red></label>
            <select wire:model.live="BuscaUrl" id="BuscaUrl" class="@error('BuscaUrl') is-invalid @enderror form-select" @if($BuscaMod=='') disabled @endif>
                    @if($BuscaMod == '') <option value=""> @endif Indica un módulo</option>
                    <option value="">Todos</option>
                    @foreach ($UrlsDelModulo as $m)
                        <option value="{{ $m->url }}"> {{ $m->url }}</option>
                    @endforeach
            </select>
            <div class="form-text"></div>
            @error('BuscaUrl')<error>{{ $message }}</error>@enderror
        </div>

        <!-- Buscar por Submódulo -->
        <div class="col-6 col-md-2 form-group">
            <label id="BuscaSubMod" class="form-label">Submódulo<red>*</red></label>
            <select wire:model.live="BuscaSubMod" id="BuscaSubMod" class="@error('BuscaSubMod') is-invalid @enderror form-select" @if($BuscaMod=='') disabled @endif>
                @if($BuscaMod == '') <option value=""> @endif Indica un módulo</option>
                @if($BuscaMod != '')
                    <option value="">Todos</option>
                    @foreach ($submodulos as $m)
                        <option value="{{ $m->cimg_tipo }}"> {{ $m->cimg_tipo }}</option>
                    @endforeach
                @endif
            </select>
            <div class="form-text"></div>
            @error('BuscaSubMod')<error>{{ $message }}</error>@enderror
        </div>
    </div>

    <div class="row">
        <!-- Busar por titulo/aturo/pie o palabra clave -->
        <div class="col-6 col-md-4 form-group">
            <label id="BuscaTxt" class="form-label">Titulo/Autor/Pie o palabra clave<red></red></label>
            <input wire:model.live="BuscaTxt" id="BuscaTxt" class="@error('BuscaTxt') is-invalid @enderror form-control" type="text">
            <div class="form-text"></div>
            @error('BuscaTxt')<error>{{ $message }}</error>@enderror
        </div>

        <!-- Buscar por tipo de objeto -->
        <div class="col-6 col-md-2 form-group">
            <label id="BuscaTipo" class="form-label">Tipo de objeto<red></red></label>
            <select wire:model.live="BuscaTipo" id="BuscaTipo" class="@error('BuscaTipo') is-invalid @enderror form-select">
                <option value="">Cualquiera</option>
                <option value="img">Imágenes</option>
                <option value="vid">Videos</option>
                <option value="aud">Audio</option>
            </select>
            <div class="form-text"></div>
            @error('BuscaTipo')<error>{{ $message }}</error>@enderror
        </div>

        <!-- Botón para agregar nuevo objeto -->
        <div class="col-6 col-md-6" style="">
            {{-- @if($BuscaJardin != '' AND $BuscaMod != '' AND $BuscaSubMod != '' AND $edit=='1') --}}
                <br>
                <button wire:click="AbrirModalPaIncertarObjeto('0')" type="button" class="btn btn-primary" @if($BuscaJardin == '' OR $BuscaMod == '' OR $BuscaSubMod == '' or $edit=='0') disabled style="color:#64383E;" @endif >Nuevo Objeto</button>
                {{-- <button wire:click="AbreModalObjeto('0','img')" type="button" class="btn btn-primary" @if($BuscaJardin == '' OR $BuscaMod == '' OR $BuscaSubMod == '' or $edit=='0') disabled style="color:#64383E;" @endif >Nuevo Objeto</button> --}}
            {{-- @else
                <span style="font-size:80%; color:gray;"><br>Para agregar una nueva imagen,<br>indica jardin, Modelo y Submodelo</span>
            @endif --}}
        </div>
    </div>



    <!-- ------------------------------------------------------------------------------- -->
    <!-- ------------------------------ Vista de tabla --------------------------------- -->
    @if($ModoTabla=='' OR $ModoTabla=='1')
        <div class="table-responsive">
            <div wire:click="CambiaModo" class="PaClick" style="float: right;">
                @if($ModoTabla=='0')
                    Ver como tabla <i class="bi bi-table"></i> ({{ $imagenes->total() }} objetos)
                @else
                    Ver imágenes <i class="bi bi-grid-3x3-gap-fill"></i> ({{ $imagenes->total() }} objetos)
                @endif
            </div>
            <table class="table table-striped table-sm">
                <thead style="vertical-align:middle;align:center;">
                    <th wire:click="Orden('img_id')" class="PaClick">Id</th>
                    <th wire:click="Orden('img_cjarsiglas')" class="PaClick">Jardin</th>
                    <th>
                        <span wire:click="Orden('img_cimgmodulo')" class="PaClick">Modulo</span>/
                        <span wire:click="Orden('img_cimgtipo')" class="PaClick">Submódulo</span> -<br>
                        <span wire:click="Orden('img_urlurl')" class="PaClick">url</span>,
                        <span wire:click="Orden('img_lencode')" class="PaClick">lengua</span>
                    </th>
                    <th wire:click="Orden('img_tipo')" class="PaClick">Tipo</th>
                    <th wire:click="Orden('img_titulo')" class="PaClick">Titulo</th>
                    <th wire:click="Orden('img_autor')" class="PaClick">Autor</th>
                    <th wire:click="Orden('img_pie')" class="PaClick">Pie</th>
                    <th>Palabras clave</th>
                    <th wire:click="Orden('img_id')" class="PaClick">Ruta</th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($imagenes as $i)
                        <tr>
                            <!-- id -->
                            <td>{{ $i->img_id }}</td>

                            <!-- jardin -->
                            <td>{{ $i->img_cjarsiglas }}</td>

                            <!-- Modulo/submódulo - url/lengua -->
                            <td>
                                {{ $i->img_cimgmodulo }}/{{ $i->img_cimgtipo }}
                                @if($i->img_urlrul != '' OR $i->img_lencode != '')
                                    - {{ $i->img_urlurl }},{{ $i->img_lencode }}
                                @endif
                            </td>

                            <!-- tipo -->
                            <td>{{ $i->img_tipo }}</td>

                            <!-- titulo -->
                            <td>{{ $i->img_titulo }}</td>

                            <!-- autor -->
                            <td>{{ $i->img_autor }}</td>

                            <!-- pie -->
                            <td><small>{{ $i->img_pie }}</small></td>

                            <!-- Palabras clave -->
                            <td>
                                @foreach($i->alias as $a)
                                    <div class="elemento" style="font-size:80%;">{{ $a->aimg_txt }}</div>
                                @endforeach
                            </td>

                            <!-- Ruta -->
                            <td>
                                <i class="bi bi-clipboard PaClick" onclick="CopiarContenido('Img','{{ $i->img_id }}')"></i> &nbsp;
                                <small><a href="{{ $i->img_file }}" class="nolink" target="img" id="sale_Img{{ $i->img_id }}">{{ $i->img_file }}</a></small>
                            </td>

                            <!-- Imagen en chiquito -->
                            <td>
                                <center style="border:1px solid gray;border-radius:5px;">
                                @if($i->img_tipo=='img')
                                    <a href="{{ $i->img_file }}" class="nolink" target="img">
                                        <img src="{{ $i->img_file }}" style="max-width:80px; max-height:70px;">
                                    </a>
                                @elseif($i->img_tipo=='aud' or$i->img_tipo=='tau' )
                                    <a href="{{ $i->img_file }}" class="nolink" target="img">
                                        <i class="bi bi-volume-up-fill" style="font-size: 300%;"></i>
                                    </a>
                                @elseif($i->img_tipo=='vid')
                                    <a href="{{ $i->img_file }}" class="nolink" target="img">
                                        <i class="bi bi-camera-reels-fill" style="font-size:300%;"></i>
                                    </a>
                                @elseif($i->img_tipo=='you')
                                    <a href="https://www.youtube.com/watch?v={{ $i->img_youtube }}" class="nolink" target="new">
                                        <i class="bi bi-youtube" style="font-size:200%;"></i><br>
                                        <span style="font-size:90%;">Youtube</span>
                                    </a>
                                @endif
                                </center>
                            </td>

                            <!-- icono de editar -->
                            <td>

                                {{-- <i wire:click="AbreModalObjeto('{{ $i->img_id }}')" class="bi bi-pencil-square mx-2 PaClick"></i> --}}
                                <i wire:click="AbrirModalPaIncertarObjeto('{{ $i->img_id }}')" class="bi bi-pencil-square mx-2 PaClick"></i>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    <!-- -------------------------------------------------------------------------------- -->
    <!-- ------------------------------ Vista de objeto --------------------------------- -->
    @else
        <div wire:click="CambiaModo" class="PaClick" style="float: right;">
            @if($ModoTabla=='0')
                Ver como tabla <i class="bi bi-table"></i> ({{ $imagenes->total() }} objetos)
            @else
                Ver imágenes <i class="bi bi-grid-3x3-gap-fill"></i> ({{ $imagenes->total() }} objetos)
            @endif
        </div>

        <div class="row">
            <div class="col-12">

                <?php $imags=$imagenes; ?>
                @include('plantillas.imagenes')
            </div>
        </div>
    @endif

    @if($imagenes->count() == '0')
        -- Aún no hay objetos --
    @endif

    <!-- ------------------------------------------------------------------------------- -->
    <!-- ------------------------------- Paginador ------------------------------------- -->
    <!-- menú de paginación -->
        @if($imagenes->hasPages())
         <div class="">
            <div class="paginador">
                <a href="{{ $imagenes->previousPageUrl() }}"><div class="boton" @if($imagenes->currentPage() == '1') disabled @endif> &laquo; </div></a>
                @foreach (range(1,$imagenes->lastPage()) as $i)
                    @if($i == $imagenes->currentPage())
                        <div class="boton" disabled> {{ $i }} </div>
                    @else
                        <a href="{{ $imagenes->url($i) }}"><div class="boton"> {{ $i }} </div></a>
                    @endif
                @endforeach
                <a href="{{ $imagenes->nextPageUrl() }}"><div class="boton" @if($imagenes->currentPage() == $imagenes->lastPage()) disabled @endif> &raquo; </div></a>
                Estás en {{ $imagenes->currentPage() }}
            </div>
         </div>
        @endif

    <livewire:sistema.modal-inserta-objeto-component />
    {{-- <livewire:web.modal-imagen-controller/> --}}
</div>
