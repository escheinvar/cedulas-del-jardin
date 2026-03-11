@section('title') Admin Cedulas @endsection
@section('meta-description') Administrador de cédulas del SiCedJar @endsection
@section('cintillo-ubica') -> {{ request()->path() }} @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection
<div>
    <h2>Administración de cédulas del jardín</h2>
    <div style="font-size: 80%;color:grey;">
        Este catálogo es administrado por los roles <b>editor</b>, <b>admin</b> en jardin: {{ implode(',',$editjar) }}
        (@if($edit=='0') <error style="font-size: 90%;"> No autorizado</error> @else <span style="font-size:90%;color:green;"> Autorizado </span>@endif)
    </div>


    <div class="row my-3">
        <!-- buscar por jardín -->
        <div class="col-6 col-md-3 form-group">
            <label for="jardinSel" class="form-label">Jardin<red>*</red></label>
            <select wire:model.live="jardinSel" id="jardinSel" class="form-select">
                <option value="">Indica un jardín</option>
                @foreach($JardsDelUsr as $jar)
                    <option value="{{ $jar->cjar_siglas }}">{{ $jar->cjar_siglas }} ({{ $jar->cjar_name }})</option>
                @endforeach
                @if(in_array('todos',$editjar))
                    <option value="%">Todos</option>
                @endif
            </select>
        </div>

        <!-- buscar por lengua -->
        <div class="col-6 col-md-3 form-group">
            <label for="" class="form-label">Lengua</label>
            <select wire:model.live="BuscaLengua" id="BuscaLengua" class="form-select">
                <option value="">En todas</option>
                @foreach($lenguas as $len)
                    <option value="{{ $len->len_code }}">{{ $len->len_lengua }} ({{ $len->len_code }})</option>
                @endforeach
            </select>
        </div>

        <!-- buscar por estado -->
        <div class="col-6 col-md-3 form-group">
            <label for="" class="form-label">Estado</label>
            <select wire:model.live="BuscaEstado" id="" class="form-select">
                <option value="">En todos</option>
                <option value="0">0 En creación (autor/traductor)</option>
                <option value="1">1 En edición (editor)</option>
                <option value="2">2 En revisión (autor/traductor)</option>
                <option value="3">3 En edición2 (editor)</option>
                <option value="4">4 En Autorización (Administrador)</option>
                <option value="5">5 Publicada</option>
                <option value="6">6 Publicada Solicita Edición</option>
            </select>
            @if($abiertos > '0')<error> @endif Hay {{ $abiertos }} @if($abiertos =='1' ) página @else páginas  @endif en edición</error>
        </div>

        <!-- buscar por texto -->
        <div class="col-6 col-md-3 form-group">
            <label for="" class="form-label">Buscar por texto</label>
            <input wire:model.live="BuscaTexto" id="" class="form-control" type="text">
        </div>
    </div>

    <!-- ----------------- El ciclo de la cédula -------------------- -->
    <div class="row">
        <div class="col-12" style="background-color:#CDC6B9;text-align:center;"><b>El ciclo de publicación de una cédula</b></div>
        <div class="col-0 col-md-3"> &nbsp; </div>

        <div class="col-3 col-md-1 cedEdo0" style="text-align:center;">
            <div style="font-size:80%; font-weight:600;">0 Crea</div>
            <i class="bi bi-brush-fill"></i>
            <div style="font-size:60%;">Autor/traductor</div>
        </div>
        <div class="col-3 col-md-1 cedEdo1" style="text-align:center;">
            <div style="font-size:80%; font-weight:600;">1 Edita</div>
            <i class='bi bi-pencil-square'></i>
            <div style="font-size:60%;">Editor</div>
        </div>
        <div class="col-3 col-md-1 cedEdo2" style="text-align:center;">
            <div style="font-size:80%; font-weight:600;">2 Revisa</div>
            <i class='bi bi-search'></i>
            <div style="font-size:60%;">Autor/traductor</div>
        </div>
        <div class="col-3 col-md-1 cedEdo3" style="text-align:center;">
            <div style="font-size:80%; font-weight:600;">3 Edita2</div>
            <i class='bi bi-pencil-square'><sub>2</sub></i>
            <div style="font-size:60%;">Editor</div>
        </div>
        <div class="col-3 col-md-1 cedEdo4" style="text-align:center;">
            <div style="font-size:70%; font-weight:600;">4 Autoriza</div>
            <i class='bi bi-star-fill'></i>
            <div style="font-size:60%;">Administrador</div>
        </div>
        <div class="col-3 col-md-1 cedEdo5" style="text-align:center;">
            <div style="font-size:80%; font-weight:600;">5 Publica</div>
            <i class="bi bi-file-earmark-check-fill"></i>
            <div style="font-size:60%;">Administrador</div>
        </div>
        <div class="col-3 col-md-1 cedEdo6" style="text-align:center;">
            <div style="font-size:70%; font-weight:600;">6 Solicita edición</div>
            <i class="bi bi-hand-index-thumb-fill"></i>
            <div style="font-size:60%;"></div>
        </div>
    </div>

    <!-- -------------------- botón de nueva cédula ------------------------ -->
    <div class="clearfix" style="">
        @if($edit=='1' and $jardinSel != '%' and $jardinSel != '')
            <div style="float: right;" class="my-3">
                <button wire:click="AbreModalCedula('0','{{ $jardinSel }}')" class="btn btn-secondary">
                    <i class="bi bi-plus-circle"></i> cédula
                </button>
            </div>
        @endif
    </div>

    <!-- ------------------------------------------------------------------------------------ -->
    <!-- ----------------------- TABLA DE CÉDULAS LOS JARDÍNES ------------------------------ -->
    <!-- ------------------------------------------------------------------------------------ -->
    <div class="table-responsive-sm"  style="clear:both;">
        <table class="table table-striped table-sm my-4">
            <thead>
                <tr>
                    <th wire:click="ordenaTabla('url_id')" class="PaClick">Id</th>
                    <th></th>
                    <th wire:click="ordenaTabla('url_id')" class="PaClick">Jardin</th>
                    <th wire:click="ordenaTabla('url_url')" class="PaClick">url</th>
                    <th wire:click="ordenaTabla('url_lengua')" class="PaClick">Lengua</th>
                    <th wire:click="ordenaTabla('')" class="PaClick">Autor</th>
                    <th wire:click="ordenaTabla('')" class="PaClick">P.clave</th>
                    <th wire:click="ordenaTabla('url_titulo')" class="PaClick">Titulo</th>
                    <th wire:click="ordenaTabla('url_tipo')" class="PaClick">Tipo</th>
                    <th wire:click="ordenaTabla('url_descrip')" class="PaClick">Estado</th>
                    <th> Edición </th>
                    <th wire:click="ordenaTabla('url_descrip')" class="PaClick"> Dirección </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($urls as $u)
                    <tr>
                        <!-- id -->
                        <td class="@if($u->url_act=='0') inact @endif">
                            {{ $u->url_id }}
                        </td>

                        <!-- editar -->
                        <td class="@if($u->url_act=='0') inact @endif">
                            <i wire:click="AbreModalCedula('{{ $u->url_id }}','{{ $u->url_cjarsiglas }}')" class="bi bi-pencil-square PaClick"></i>
                        </td>

                        <!-- jardin -->
                        <td class="@if($u->url_act=='0') inact @endif">
                            {{ $u->url_cjarsiglas }}
                        </td>

                        <!-- url -->
                        <td>
                            {{ $u->url_url }}
                            <div style="color:gray;font-size:80%;">
                                @if($u->url_tradid=='0')
                                    Original
                                @else
                                    Traducción
                                @endif
                            </div>
                        </td>

                        <!-- lengua -->
                        <td>
                            {{ $u->lenguas->len_lengua }}
                            <div style="color:gray;font-size:80%;">
                                {{ $u->lenguas->len_code }}
                            </div>
                        </td>

                         <!-- autor -->
                        <td class="@if($u->url_act=='0') inact @endif">
                            <div>
                                <!-- conteo de autores -->
                                <div style="color:gray;font-size:80%;">
                                    {{-- {{ $u->autores->where('aut_tipo','Autor')->count() }} --}}
                                    @if($u->autores->where('aut_tipo','Autor')->count() =='0')
                                        <error style="font-size:110%;">Falta Autor</error>
                                    @elseif($u->autores->where('aut_tipo','Autor')->count() =='1')
                                        {{ $u->autores->where('aut_tipo','Autor')->first()->aut_name }}
                                    @else
                                        {{ $u->autores[0]->where('aut_tipo','Autor')->aut_name }},
                                        {{ $u->autores[1]->where('aut_tipo','Autor')->aut_name }} et al.
                                    @endif
                                </div>

                                <!-- conteo de traductores -->
                                @if($u->url_tradid=='1')
                                    <div style="color:gray;font-size:80%;">
                                        {{-- {{ $u->autores->where('aut_tipo','Traductor')->count() }} --}}
                                        @if($u->autores->where('aut_tipo','Traductor')->count() =='0')
                                            <error style="font-size:110%;">Falta Traductor</error>
                                        @else
                                            Tr:{{ $u->autores->where('aut_tipo','Traductor')[0]->aut_name }}
                                        @endif
                                    </div>
                                @endif

                                <!-- conteo de Editor -->
                                <div style="color:gray;font-size:80%;">
                                    {{-- {{ $u->autores->where('aut_tipo','Editor')->count() }} --}}
                                    @if($u->autores->where('aut_tipo','Editor')->count() =='0')
                                        <error style="font-size:110%;">Falta Editor</error>
                                    @else
                                        {{-- Ed:{{ $u->autores[0]->where('aut_tipo','Editor')->aut_name }} --}}
                                    @endif
                                </div>

                            </div>
                        </td>

                        <!-- Palabras clave -->
                        <td class="@if($u->url_act=='0') inact @endif">
                            <div>
                                <error style="font-size: 80%;">Falta sp</error>
                            </div>
                            <div>
                                <error style="font-size: 80%;">Falta comunidad</error>
                            </div>
                            <div>
                                <error style="font-size: 80%;">Falta usos</error>
                            </div>
                            <div>
                                <error style="font-size: 80%;">Falta p. clave</error>
                            </div>
                        </td>
                        <!-- titulo -->
                        <td>
                            {{ $u->url_titulo }}
                        </td>

                        <!-- tipo -->
                        <td>
                            {{ $u->url_ccedtipo }}
                        </td>
                        <!-- estado -->
                        <td  class="@if($u->url_act=='0') inact @endif">

                            @if($u->url_edo =='0')
                                <i class="bi bi-0-circle-fill cedEdo0"></i>
                                Creación
                                {{-- <div style="color:gray;font-size:80%;"> Con autor/traductor</div> --}}
                            @elseif($u->url_edo =='1')
                                <i class="bi bi-1-circle-fill cedEdo1"></i>
                                Edición
                                {{-- <div style="color:gray;font-size:80%;"> Con editor</div> --}}
                            @elseif($u->url_edo =='2')
                                <i class="bi bi-2-circle-fill cedEdo2"></i>
                                Revisión
                                {{-- <div style="color:gray;font-size:80%;"> Con autor/traductor</div> --}}
                            @elseif($u->url_edo =='3')
                                <i class="bi bi-3-circle-fill cedEdo3"></i>
                                Edición 2
                                {{-- <div style="color:gray;font-size:80%;"> Con admin</div> --}}
                            @elseif($u->url_edo =='4')
                                <i class="bi bi-4-circle-fill cedEdo4"></i>
                                Autorización
                            @elseif($u->url_edo =='5')
                                <i class="bi bi-5-circle-fill cedEdo5"></i>
                                Publicado
                            @elseif($u->url_edo =='6')
                                <i class="bi bi-6-circle-fill cedEdo6"></i>
                                Publicado (Solicita edición)
                            @endif
                        </td>

                        <!-- Edición -->
                        <td>
                            @if($edit=='1')
                                <div class="form-check form-switch">
                                    {{-- <input  wire:change="CambiaEstadoEdicion('{{ $u->url_id }}')" class="form-check-input" value="1" type="checkbox" role="switch" id="flexSwitchCheckDefault" @if($u->url_edo <= 3 ) checked @endif style="@if($u->url_edo <= 3) background-color:red; @endif">
                                    <label class="form-check-label" for="flexSwitchCheckDefault"> @if($u->url_edo < '4')Publicado @else Editando @endif  </label> --}}
                                </div>
                            @endif
                        </td>

                        <!-- URL -->
                        <td class="@if($u->url_act=='0') inact @endif">
                            <a href="{{ url('/') }}/cedula/{{ strtolower($u->url_cjarsiglas) }}/{{ $u->url_url }}" target="new" class="nolink" id="sale_url{{ $u->url_id }}">
                                {{ url('/') }}/cedula/{{ strtolower($u->url_cjarsiglas) }}/{{ $u->url_url }}
                            </a>
                            <i class="bi bi-clipboard PaClick" onclick="CopiarContenido('url','{{ $u->url_id }}')"></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($urls->count()=='0')
            --- Aún no hay cédulas ---
        @endif
    </div>














    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- ---------------------------- INICIA MODAL DE EDICIÓN DE CÉDULA ----------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <div wire:ignore.self class="modal fade" id="ModalDeEdicionDeCedulas" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        @if($cedulaId=='0')
                            Creando nueva cédula
                        @else
                            Editando cédula Id {{ $cedulaId }}
                        @endif
                        de {{ $jardinSel }}
                    </h3>
                    <button wire:click="CierraModalCedula()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- cuerpo del MODAL:EDICIÓN CÉDULA -->
                <div class="modal-body">
                    <!-- Original/Copia y copia de -->
                    <div class="row">
                        <!-- Original o traducción -->
                        <div class="col-4 form-group">
                            <label for="origtrad" class="form-label">Original/Traducción<red>*</red></label>
                            <select wire:model.live="origtrad"  wire:change="DeterminaVariablesDeCopia()" id="origtrad" class="@error('origtrad') is-invalid @enderror form-select" @if($cedulaId > '0') disabled @endif>
                                <option value="">Indica ...</option>
                                <option value="original">Cédula original</option>
                                <option value="traducción">Traducción de cédula</option>
                            </select>
                            <div class="form-text"></div>
                            @error('origtrad') <error> {{ $message }}</error>@enderror
                        </div>

                        <!-- Copia de -->
                        <div class="col-4 form-group">
                            <label for="copiade" class="form-label">Copia de<red>@if($origtrad=='traducción')*@endif</red></label>
                            <select wire:model.live="copiade" wire:change="DeterminaVariablesDeCopia()" id="copiade" class="@error('copiade') is-invalid @enderror form-select" @if($origtrad=='original' or $cedulaId != '0') disabled @endif>
                                <option value="">Indica ...</option>
                                @foreach($CedsOriginales as $o)
                                    <option value="{{ $o->url_id }}">
                                        {{ $o->url_cjarsiglas }}:
                                        {{ $o->url_url }}
                                        [{{ $o->url_lencode }}]
                                        @if($o->url_edo < '4') -- EN EDICIÓN -- @endif
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text"></div>
                            @error('copiade') <error> {{ $message }}</error>@enderror
                        </div>

                        <!-- Tipo de cédula -->
                        <div class="col-4 form-group">
                            <label for="tipoCedula" class="form-label">Tipo de ćedula<red>*</red></label>
                            <select wire:model.live="tipoCedula" wire:change="DeterminaVariablesDeCopia()" id="tipoCedula" class="@error('tipoCedula') is-invalid @enderror form-select" @if($origtrad=='traducción' ) disabled @endif>
                                <option value="">Indica ...</option>
                                @foreach($TiposDeCedula as $t)
                                    <option value="{{ $t->cced_tipo }}"> {{ $t->cced_tipo }}</option>
                                @endforeach
                            </select>
                            <div class="form-text"></div>
                            @error('tipoCedula') <error> {{ $message }}</error>@enderror
                        </div>
                    </div>

                    <!-- Datos generales de la cédula -->
                    <div class="row">
                        <!-- Lengua -->
                        <div class="col-4 form-group">
                            <label for="lengua" class="form-label">Lengua<red>*</red></label>
                            <select wire:model.live="lengua" wire:change="DeterminaVariablesDeCopia()" id="lengua" class="@error('lengua') is-invalid @enderror form-select">
                                <option value="">Indica....</option>
                                @foreach($lenguas as $l)
                                    <option value="{{ $l->len_code }}">{{ $l->len_code }}: {{ $l->len_lengua }} {{ $l->len_variante }}</option>
                                @endforeach
                            </select>
                            <div class="form-text"></div>
                            @error('lengua') <error> {{ $message }}</error>@enderror
                        </div>

                        <!-- MODAL: titulo --->
                        <div class="col-4 form-group">
                            <label for="titulo" class="form-label">
                                Titulo<red>*</red>
                            </label>
                            @if($origtrad=='traducción') <span onclick="VerNoVer('titulo','Original')" class="PaClick">Ver original</span> @endif
                            <input wire:model="titulo" id="titulo" class="@error('titulo') is-invalid @enderror form-control" type="text" >
                            <div class="form-text"></div>
                            @error('titulo')<error>{{ $message }}</error>@enderror

                            <div id="sale_tituloOriginal" style="display:none;font-size:90%;">
                                {{ $tituloOrig }}
                            </div>
                        </div>

                        <!-- MODAL: url web jardin -->
                        <div class="col-4 form-group">
                            <label for="url" class="form-label">URL <red>*</red></label>
                            &nbsp; <i class="bi bi-info-square-fill agregar" wire:click="ProponUrl()"> Proponer </i>
                            <input wire:model="url"  id="url" class="@error('url') is-invalid @enderror form-control" @if($url=='inicio' or $origtrad=='traducción') disabled @endif type="text" >
                            <div class="form-text">Sin espacios, ñ, acentos ni caracteres</div>
                            @error('url')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- MODAL: Resumen -->
                        <div class="col-9 form-group">
                            <label for="resumen" class="form-label">Resumen</label>
                            @if($origtrad=='traducción') <span onclick="VerNoVer('resumen','Original')" class="PaClick">Ver original</span> @endif
                            <textarea wire:model="resumen" id="resumen" class="@error('resumen') is-invalid @enderror form-control"></textarea>
                            <div class="form-text"> </div>
                            @error('resumen')<error>{{ $message }}</error>@enderror
                            <div id="sale_resumenOriginal" style="display:none;">
                                {{ $resumenOrig }}
                            </div>
                        </div>

                        <!-- MODAL: checkbox activo -->
                        <div class="col-3 form-group my-2">
                            <div class="form-check">
                                <input class="form-check-input" wire:model.live="act" type="checkbox" id="act">
                                <label class="form-check-label" for="checkDefault"> Publicar página </label><br>
                                @if($act==FALSE)<b>La cédula no está disponible al público</b> @else El público puede acceder a este sitio @endif
                            </div>
                        </div>

                        <!-- MODAL: Borrar-->
                        @if( $cedulaId > '0')
                            <div class="col-6 form-group my-2">
                                <i  wire:click="EliminarSitioWeb()" class="bi bi-trash agregar"> Eliminar página completa</i>
                            </div>
                        @endif
                    </div>

                    @if($cedulaId > '0')
                        <!-- Autor, editor y traductor -->
                        <div class="row my-2">
                            <hr>
                            <!-- Autor -->
                            <div class="col-4 form-group">
                                <label for="" class="form-label">Autor(es)<red></red></label>
                                <i wire:click="AbreModalDeBuscarAutor('Autor')" class="bi bi-plus-square-fill agregar"></i>
                                @if($CedAutores AND $cedulaId > '0')
                                    <?php $cont='1';?>
                                    @foreach ($CedAutores->where('aut_tipo','Autor') as $a)
                                        <div class="elemento" style="font-size: 80%;">
                                            {{ $cont++ }} {{ $a->aut_name }}@if($a->aut_corresponding=='1')*@endif
                                            <i wire:click="BorrarAutor('{{ $a->aut_id }}')" class="bi bi-trash agregar"></i>
                                        </div>
                                    @endforeach
                                @endif
                            </div>


                            <!-- Editor -->
                            <div class="col-4 form-group">
                                <label for="" class="form-label">Editor<red></red></label>
                                <i wire:click="AbreModalDeBuscarAutor('Editor')" class="bi bi-plus-square-fill agregar"></i>
                                @if($CedAutores AND $cedulaId > '0')
                                    <?php $cont='1';?>
                                    @foreach ($CedAutores->where('aut_tipo','Editor') as $a)
                                        <div class="elemento" style="font-size: 80%;">
                                            {{ $cont++ }} {{ $a->aut_name }}@if($a->aut_corresponding=='1')*@endif
                                            <i wire:click="BorrarAutor('{{ $a->aut_id }}')" class="bi bi-trash agregar"></i>
                                        </div>
                                    @endforeach

                                @endif
                            </div>

                            <!-- Traductor -->
                            <div class="col-4 form-group">
                                @if($this->origtrad=='traducción')
                                    <label for="" class="form-label">Traductor<red></red></label>
                                    <i wire:click="AbreModalDeBuscarAutor('Traductor')" class="bi bi-plus-square-fill agregar"></i>
                                    @if($CedAutores AND $cedulaId > '0')
                                        <?php $cont='1';?>
                                        @foreach ($CedAutores->where('aut_tipo','Traductor') as $a)
                                            <div class="elemento" style="font-size: 80%;">
                                                {{ $cont++ }} {{ $a->aut_name }}@if($a->aut_corresponding=='1')*@endif
                                                <i wire:click="BorrarAutor('{{ $a->aut_id }}')" class="bi bi-trash agregar"></i>
                                            </div>
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- Palabras clave -->
                        <div class="row my-2">
                            <hr>
                            <h5>Metadatos</h5>
                            <!-- especies -->
                            <div class="col-6 form-group">
                                <label for="" class="form-label">Especie(s)<red></red></label><br>
                                <select wire:model="" id="" class="@error('') is-invalid @enderror form-select agregar" style="width:33%;">
                                    <option value="">Selecciona ....</option>
                                </select>
                                <i wire:click="" class="bi bi-plus-circle agregar"></i>
                                <div class="form-text"></div>
                                @error('')<error>{{ $message }}</error>@enderror
                            </div>

                            <!-- localidades -->
                            <div class="col-6 form-group">
                                <label for="" class="form-label">Localidad(es)<red></red></label><br>
                                <select wire:model="" id="" class="@error('') is-invalid @enderror form-select agregar" style="width:33%;">
                                    <option value="">Selecciona ....</option>
                                </select>
                                <i wire:click="" class="bi bi-plus-circle agregar"></i>
                                <div class="form-text"></div>
                                @error('')<error>{{ $message }}</error>@enderror
                            </div>

                            <!-- Usos -->
                            <div class="col-6 form-group">
                                <label for="" class="form-label">Uso(s)<red></red></label><br>
                                <select wire:model="" id="" class="@error('') is-invalid @enderror form-select agregar" style="width:33%;">
                                    <option value="">Selecciona ....</option>
                                </select>
                                <i wire:click="" class="bi bi-plus-circle agregar"></i>
                                <div class="form-text"></div>
                                @error('')<error>{{ $message }}</error>@enderror
                            </div>

                            <!-- Pals. clave -->
                            <div class="col-6 form-group">
                                <label for="" class="form-label">Palabra(s) clave<red></red></label><br>
                                <select wire:model="" id="" class="@error('') is-invalid @enderror form-select agregar" style="width:33%;">
                                    <option value="">Selecciona ....</option>
                                </select>
                                <i wire:click="" class="bi bi-plus-circle agregar"></i>
                                <div class="form-text"></div>
                                @error('')<error>{{ $message }}</error>@enderror
                            </div>
                        </div>
                    @else
                        <div class="alert alert-warning my-3" role="alert">
                            Luego de generar la cédula, deberás regresar para agrega <b>autores</b>, <b>editores</b> y <b>metadatos</b>.
                        </div>
                    @endif


                </div>
                <div class="modal-footer">
                    <button wire:click="GuardaCedula()" class="btn btn-primary">
                        <span wire:loading.remove> Guardar </span>
                        <span wire:loading style="display:none;"> <red> ..guardando...</red> </span>
                    </button>

                    <button wire:click="CierraModalCedula()" class="btn btn-secondary">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ----------------------------- TERMINA MODAL DE EDICIÓN DE CÉDULA --------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->







    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- ---------------------------- INICIA MODAL DE BUSCAR AUTOR ----------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <div wire:ignore.self class="modal fade" id="ModalDeBusquedaDeElAutor" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        @if($cedulaId=='0')
                            Buscando {{ $BuscaAutor_tipo }} para cédula nueva
                        @else
                            Buscando autor para cédula Id {{ $cedulaId }}
                        @endif
                        de {{ $jardinSel }}
                    </h3>
                    <button wire:click="CierraModalDeBuscarAutor()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- cuerpo del modal -->
                <div class="modal-body">

                        <div class="row">
                            <div class="col-12 col-md-5 form-group">
                                <label for="BuscaAutor_BuscaNombre" class="form-label">Nombre:</label>
                                <input wire:model="BuscaAutor_BuscaNombre" id="BuscaAutor_BuscaNombre" class="@error('BuscaAutor_BuscaNombre') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('BuscaAutor_BuscaNombre')<error>{{ $message }}</error>@enderror
                            </div>

                            <div class="col-12 col-md-5 form-group">
                                <label for="BuscaAutor_BuscaApellido" class="form-label">Apellido:</label>
                                <input wire:model="BuscaAutor_BuscaApellido" id="BuscaAutor_BuscaApellido" class="@error('BuscaAutor_BuscaApellido') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('BuscaAutor_BuscaApellido')<error>{{ $message }}</error>@enderror
                            </div>

                            <div class="col-12 col-md-2 form-group">
                                <br>
                                <button wire:click="BuscarAutores()" class="btn btn-primary">Buscar</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                @if($BuscaAutor_BuscaNombre != '' OR $BuscaAutor_BuscaApellido != '')
                                    @if($BuscaAutor_Posibles->count() > '0')
                                        <b>Selecciona al autor:</b>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr><th>Nombre Apellido</th></tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($BuscaAutor_Posibles as $a)
                                                    <tr>
                                                        <td>
                                                            <div class="py-2 PaClick" onclick="VerNoVer('Autor','{{ $a->caut_id }}')">
                                                                {{ $a->caut_nombre }} {{ $a->caut_apellido1 }} {{ $a->caut_apellido2 }}
                                                            </div>
                                                            <div id="sale_Autor{{ $a->caut_id }}" style="display:none;">
                                                                Nombre de autor: {{ $a->caut_nombreautor }}<br>
                                                                Correo: {{ $a->caut_correo }}<br>
                                                                Comunidad: {{ $a->caut_comunidad }} <br>
                                                                Instituto: {{ $a->caut_institu }} <br>
                                                                @if($a->caut_lenguas != '') Lenguas: {{ $a->caut_lenguas }} <br> @endif
                                                                <button wire:click="ConfirmarDatosDeAutor({{ $a->caut_id }})" class="btn btn-secondary btn-sm" style="float: right;">
                                                                    Ver Datos de {{ $BuscaAutor_tipo }}
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        No se encontraron autores en el catálogo.
                                        <button wire:click="AbrirModalDeNuevoAutor()" class="btn btn-secondary">Agregar uno al catálogo</button>
                                    @endif
                                @endif

                                <!-- ------------------------------------------------------------------------------------- -->
                                <!-- ------------------------------------------------------------------------------------- -->
                                <!-- ----------------------- Ver y confirmar datos de autor seleccionado ----------------- -->
                                <!-- ------------------------------------------------------------------------------------- -->
                                @if($BuscaAutor_Ganon->count() != '0')
                                    <h5 class="my-3">Confirma los datos del autor id {{ $BuscaAutor_id }}:</h5>
                                    {{-- <div class="row">
                                        <div class="col-4 col-md-3 px-1"><b>Orden</b></div>
                                        <div class="col-8 col-md-3 px-1"><input wire:model="BuscaAutor_orden" class="@error('BuscaAutor_orden') is-invalid @enderror form-control" type="mail" style="width:90%;"> </div>
                                    </div> --}}
                                    <div class="row">
                                        <div class="col-4 col-md-3 px-1"><b>Nombre</b></div>
                                        <div class="col-8 col-md-9 px-1"><input class="form-control" value="{{ $BuscaAutor_Ganon->caut_nombre }} {{ $BuscaAutor_Ganon->caut_apellido1 }} {{ $BuscaAutor_Ganon->caut_apellido2 }}" readonly></div>
                                    </div>
                                     <div class="row">
                                        <div class="col-4 col-md-3 px-1"><b>Nombre de autor:</b></div>
                                        {{-- <div class="col-8 col-md-9 px-1"><input class="form-control" value="{{ $BuscaAutor_Ganon->caut_nombre }} {{ $BuscaAutor_Ganon->caut_apellido1 }} {{ $BuscaAutor_Ganon->caut_apellido2 }}" readonly></div> --}}
                                    </div>

                                    <div class="row">
                                        <div class="col-4 col-md-3 px-1"><b>Comunidad:</b></div>
                                        <div class="col-8 col-md-9 px-1"><input wire:model="BuscaAutor_comunidad" class="@error('BuscaAutor_comunidad') is-invalid @enderror form-control" type="text"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4 col-md-3 px-1"><b>Institución:</b></div>
                                        <div class="col-8 col-md-9 px-1"><input wire:model="BuscaAutor_institu" class="@error('BuscaAutor_institu') is-invalid @enderror form-control" type="text"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4 col-md-3 px-1"><b>Correo:</b></div>
                                        <div class="col-8 col-md-9 px-1"><input wire:model="BuscaAutor_correo" class="@error('BuscaAutor_correo') is-invalid @enderror form-control" type="text"></div>
                                    </div>

                                    <div class="form-check">
                                        <input wire:model="BuscaAutor_corresponding" class="form-check-input" type="checkbox" value="" id="checkDefault">
                                        <label class="form-check-label" for="checkDefault">Poner como autor de correspondencia</label>
                                    </div>

                                    <div class="row my-3">
                                        <div class="col-12">
                                            <button wire:click="AgregarAutorACedula()" class="btn btn-primary" style="float: right;">
                                                <i class="bi bi-plus-circle"></i> Agregar
                                            </button>
                                        </div>
                                    </div>

                                @endif
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    {{-- <button wire:click="GuardaCedula()" class="btn btn-primary">
                        <span wire:loading.remove> Guardar </span>
                        <span wire:loading style="display:none;"> <red> ..guardando...</red> </span>
                    </button> --}}

                    <button wire:click="CierraModalDeBuscarAutor()" class="btn btn-secondary">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>


    <livewire:sistema.autores-modal-component>




    <script>
        /* ### Script para abrir y cerrar modal de Cédula */
        Livewire.on('AbreModalDeCedula', () => {
            $('#ModalDeEdicionDeCedulas').modal('show');
        });

        Livewire.on('CierraModalDeCedula', () => {
            $('#ModalDeEdicionDeCedulas').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });

        /* ### Script para abrir y cerrar modal de Buscar Autor */
        Livewire.on('AbreModalDeBuscarAutor', () => {
            $('#ModalDeBusquedaDeElAutor').modal('show');
        });

        Livewire.on('CierraModalDeBuscarAutor', () => {
            $('#ModalDeBusquedaDeElAutor').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });

        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoCedula',()=>{
            alert(event.detail.msj);
        })

        /* ### Script para mostrar botón personalizado de input=file */
        document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
            document.getElementById('MiInputFile').click();
        });
    </script>

</div>
