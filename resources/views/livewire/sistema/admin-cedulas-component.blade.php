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
            <select wire:model.live="" id="" class="form-select">
                <option value="">En todas</option>
                {{-- @foreach($JardsDelUsr as $jar)
                    <option value="{{ $jar->cjar_siglas }}">{{ $jar->cjar_siglas }} ({{ $jar->cjar_name }})</option>
                @endforeach --}}
            </select>
        </div>

        <!-- buscar por estado -->
        <div class="col-6 col-md-3 form-group">
            <label for="" class="form-label">Estado</label>
            <select wire:model.live="" id="" class="form-select">
                <option value="">En todos</option>
                <option value="0">0 En creación</option>
                <option value="1">1 En edición</option>
                <option value="2">2 En revisión</option>
                <option value="3">3 En autorización</option>
                <option value="4">4 Publicada</option>
                <option value="5">5 Publicada Solicita Edición</option>
            </select>
            @if($abiertos > '0')<error> @endif Hay {{ $abiertos }} @if($abiertos =='1' ) página @else páginas  @endif en edición</error>
        </div>

        <!-- buscar por texto -->
        <div class="col-6 col-md-3 form-group">
            <label for="" class="form-label">Buscar por texto</label>
            <input wire:model.live="" id="" class="form-control" type="text">
        </div>
    </div>

    <!-- ----------------- El ciclo de la cédula -------------------- -->
    <div class="row">
        <div class="col-12" style="background-color:#CDC6B9;text-align:center;"><b>El ciclo de publicación de una cédula</b></div>
        <div class="col-0 col-md-3"> &nbsp; </div>
        <div class="col-3 col-md-1" style="color:#9917aa; text-align:center;">
            <div style="font-size:80%; font-weight:600;">0 Crea</div>
            <i class="bi bi-brush-fill"></i>
            <div style="font-size:60%;">Autor/traductor</div>
        </div>
        <div class="col-3 col-md-1" style="color:#CD7B34; text-align:center;">
            <div style="font-size:80%; font-weight:600;">1 Edita</div>
            <i class='bi bi-pencil-square'></i>
            <div style="font-size:60%;">Editor</div>
        </div>
        <div class="col-3 col-md-1" style="color:#9917aa; text-align:center;">
            <div style="font-size:80%; font-weight:600;">2 Revisa</div>
            <i class='bi bi-search'></i>
            <div style="font-size:60%;">Autor/traductor</div>
        </div>
        <div class="col-3 col-md-1" style="color:#CD7B34; text-align:center;">
            <div style="font-size:80%; font-weight:600;">3 Edita2</div>
            <i class='bi bi-pencil-square'><sub>2</sub></i>
            <div style="font-size:60%;">Editor</div>
        </div>
        <div class="col-3 col-md-1" style="color:#9c1919; text-align:center;">
            <div style="font-size:70%; font-weight:600;">4 Autoriza</div>
            <i class='bi bi-star-fill'></i>
            <div style="font-size:60%;">Administrador</div>
        </div>
        <div class="col-3 col-md-1" style="color:#108516; text-align:center;">
            <div style="font-size:80%; font-weight:600;">5 Publica</div>
            <i class="bi bi-file-earmark-check-fill"></i>
            <div style="font-size:60%;">Administrador</div>
        </div>
        <div class="col-3 col-md-1" style="color:#108516; text-align:center;">
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

                        <!-- titulo -->
                        <td>
                            {{ $u->url_titulo }}
                        </td>

                        <!-- tipo -->
                        <td>
                            {{ $u->url_ccedtipo }}
                        </td>
                        <!-- estado -->
                        <td>

                            @if($u->url_edo =='0')
                                <i class="bi bi-0-circle-fill" style="color:#CD7B34;"></i>
                                Creación
                                <div style="color:gray;font-size:80%;"> Con autor/traductor</div>
                            @elseif($u->url_edo =='1')
                                <i class="bi bi-1-circle-fill" style="color:#cdb634;"></i>
                                Edición
                                <div style="color:gray;font-size:80%;"> Con editor</div>
                            @elseif($u->url_edo =='2')
                                <i class="bi bi-2-circle-fill" style="color:#34b6cd;"></i>
                                Revisión
                                <div style="color:gray;font-size:80%;"> Con autor/traductor</div>
                            @elseif($u->url_edo =='3')
                                <i class="bi bi-3-circle-fill" style="color:#cdb634;"></i>
                                Edición 2
                                <div style="color:gray;font-size:80%;"> Con admin</div>
                            @elseif($u->url_edo =='4')
                                <i class="bi bi-4-circle-fill" style="color:#cd34c0;"></i>
                                Autorización
                            @elseif($u->url_edo =='5')
                                <i class="bi bi-5-circle-fill" style="color:#919C1B;"></i>
                                Publicado
                            @elseif($u->url_edo =='6')
                                <i class="bi bi-6-circle-fill" style="color:#cd3434;"></i>
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
                <!-- cuerpo del modal -->
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

                        <!-- MODAL: url web jardin -->
                        <div class="col-4 form-group">
                            <label for="url" class="form-label">URL <red>*</red> </label>
                            <input wire:model="url" id="url" class="@error('url') is-invalid @enderror form-control" @if($url=='inicio' or $origtrad=='traducción') disabled @endif type="text" >
                            <div class="form-text">Sin espacios, ñ, acentos ni caracteres</div>
                            @error('url')<error>{{ $message }}</error>@enderror
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


                        <!-- MODAL: titulo web jardin -->
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

                    <!-- Autor, editor y traductor -->
                    <div class="row my-2">
                        <hr>
                        <h5>Autores:</h5>
                        <!-- Autor -->
                        <div class="col-4 form-group">
                            <label for="" class="form-label">Autor(es)<red>*</red></label><br>
                            <button wire:click="AbreModalDeBuscarAutor()" class="btn btn-secondary btn-sm"><i class="bi bi-plus-circle"></i> Autor</button>
                            <div class="form-text"></div>
                            @error('')<error>{{ $message }}</error>@enderror
                        </div>


                        <!-- Editor -->
                        <div class="col-4 form-group">
                            <label for="" class="form-label">Editor<red>*</red></label><br>
                            <select wire:model="" id="" class="@error('') is-invalid @enderror form-select agregar" style="width:40%;">
                                <option value="">Selecciona ....</option>
                            </select>
                            <i wire:click="" class="bi bi-plus-circle agregar"></i>
                            <div class="form-text"></div>
                            @error('')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Traductor -->
                        <div class="col-4 form-group">
                            <label for="" class="form-label">Traductor<red></red></label><br>
                            <select wire:model="" id="" class="@error('') is-invalid @enderror form-select agregar" style="width:40%;">
                                <option value="">Selecciona ....</option>
                            </select>
                            <i wire:click="" class="bi bi-plus-circle agregar"></i>
                            <div class="form-text"></div>
                            @error('')<error>{{ $message }}</error>@enderror
                        </div>
                    </div>

                    <!-- Palabras clave -->
                    <div class="row my-2">
                        <h5>Metadatos</h5>
                        <hr>
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
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        @if($cedulaId=='0')
                            Buscando autor para cédula nueva
                        @else
                            Buscando autor para cédula Id {{ $cedulaId }}
                        @endif
                        de {{ $jardinSel }}
                    </h3>
                    <button wire:click="CierraModalDeBuscarAutor()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- cuerpo del modal -->
                <div class="modal-body">
                    </div>
                <div class="modal-footer">
                    <button wire:click="GuardaCedula()" class="btn btn-primary">
                        <span wire:loading.remove> Guardar </span>
                        <span wire:loading style="display:none;"> <red> ..guardando...</red> </span>
                    </button>

                    <button wire:click="CierraModalDeBuscarAutor()" class="btn btn-secondary">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>







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
