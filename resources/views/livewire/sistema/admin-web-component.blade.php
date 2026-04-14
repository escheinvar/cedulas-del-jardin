<div>
@section('title') Admin Usuarios @endsection
@section('meta-description') Meta @endsection
@section('cintillo-ubica') -> {{ request()->path() }} @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection


<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->

    <h2>Administración de sitios web del jardín</h2>
    <div style="font-size: 80%;color:grey;">
        Este catálogo es administrado por el rol
        <b style="@if(in_array('webmaster',session('rol'))) color:green; @endif">webmaster</b> en jardin: {{ implode(',',$editjar) }}
        (@if($edit=='0') <error style="font-size: 90%;"> No autorizado</error> @else <span style="font-size:90%;color:green;"> Autorizado </span>@endif)
    </div>

    <!-- buscar por jardín -->
    <div class="row my-3">
        <div class="col-6 col-md-3 form-group">
            <label class="form-label">Jardin<red>*</red></label>
            <select wire:model.live="jardinSel"  wire:change="DefineJardin()"  class="form-select">
                <option value="">Indica un jardín</option>
                @foreach($JardsDelUsr as $jar)
                    <option value="{{ $jar->cjar_siglas }}">{{ $jar->cjar_siglas }} ({{ $jar->cjar_name }})</option>
                @endforeach
                @if(in_array('todos',$editjar))
                    <option value="%">Todos</option>
                @endif
            </select>
        </div>
        <div class="col-6 col-md-3">
            <br>
            @if($abiertos > '0')<error> @endif
                Hay {{ $abiertos }} @if($abiertos =='1' ) página @else páginas  @endif del jardin<br>
                y
                {{ $abiertosAutor }} @if($abiertosAutor =='1' ) página @else páginas  @endif de autor
                en edición
            @if($abiertos > '0')</error> @endif
        </div>
    </div>

    <!-- ------------------------------------------------------------------------------------ -->
    <!-- ----------------------- SITIOS WEB DE LOS JARDÍNES --------------------------------- -->
    <!-- ------------------------------------------------------------------------------------ -->

    <div class="" style="">
        <h3>Del jardin</h3>
        @if($edit=='1' and $jardinSel != '%' and $jardinSel != '')
            <div style="float: right;" class="my-3">
                <button wire:click="AbreModalWeb('jardin','0')" class="btn btn-secondary">
                    Nueva página
                </button>
            </div>
        @endif
    </div>

    <div class="table-responsive-sm"  style="clear:both;">
        <table class="table table-striped table-sm my-4">
            <thead>
                <tr>
                    <th wire:click="ordenaTabla('urlj_id')" class="PaClick">Id</th>
                    <th></th>
                    <th wire:click="ordenaTabla('urlj_id')" class="PaClick">Jardin</th>
                    <th wire:click="ordenaTabla('urlj_url')" class="PaClick">url</th>
                    <th wire:click="ordenaTabla('urlj_lengua')" class="PaClick">Lengua</th>
                    <th wire:click="ordenaTabla('urlj_titulo')" class="PaClick">Titulo</th>
                    <th wire:click="ordenaTabla('urlj_descrip')" class="PaClick">Descripción</th>
                    <th> Edición </th>
                    <th wire:click="ordenaTabla('urlj_descrip')" class="PaClick"> Dirección </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($urls as $u)
                    <tr wire:key="url{{ $u->urlj_id }}">
                        <!-- id -->
                        <td class="@if($u->urlj_act=='0') inact @endif">
                             {{ $u->urlj_id }}
                        </td>

                         <!-- icono editar -->
                        <td>
                            @if($jardinSel !='%')
                                <i class="bi bi-pencil-square @if($edit=='1')PaClick @endif"   wire:click="AbreModalWeb('jardin','{{ $u->urlj_id }}')"></i>
                            @else
                                <i class="bi bi-pencil-square" style="color:rgb(172, 172, 172);"></i>
                            @endif
                        </td>

                        <!-- jardin -->
                        <td class="@if($u->urlj_act=='0') inact @endif">
                            {{ $u->urlj_cjarsiglas }}
                        </td>

                        <!-- url -->
                        <td class="@if($u->urlj_act=='0') inact @endif">
                            <b>{{ $u->urlj_url }}</b>
                            <div style="color:gray;font-size:80%;">
                                @if($u->urlj_tradid =='0')
                                    original
                                @else
                                    traducción
                                @endif
                            </div>
                        </td>

                        <!-- lengua -->
                        <td class="@if($u->urlj_act=='0') inact @endif">
                            <center>{{ $u->urlj_lencode }} <br>
                            {{ $u->lenguas->len_lengua }}</center>
                        </td>

                        <!-- titulo-->
                        <td class="@if($u->urlj_act=='0')  inact @endif">
                             {{ $u->urlj_titulo }}
                        </td>

                        <!-- descripcion -->
                        <td  class="@if($u->urlj_act=='0') inact @endif">
                            {{ $u->urlj_descrip }}
                        </td>

                        <!-- apagador edit -->
                        <td>
                            @if($edit=='1')
                                <div class="form-check form-switch">
                                    <input  wire:change="CambiaEstadoEdicion('{{ $u->urlj_id }}')" class="form-check-input" value="1" type="checkbox" role="switch" id="flexSwitchCheckDefault{{ $u->urlj_id }}" @if($u->urlj_edit=='1') checked @endif style="@if($u->urlj_edit=='1')background-color:red; @endif">
                                    <label class="form-check-label" for="flexSwitchCheckDefault{{ $u->urlj_id }}">@if($u->urlj_edit=='0')Off @else Editando @endif</label>
                                </div>
                            @endif
                        </td>

                        <!-- http dir-->
                        <td class="@if($u->urlj_act=='0') inact @endif">
                            @if($u->urlj_url == 'inicio')
                                <a href="{{ url('/') }}/jardin/{{ strtolower($u->urlj_cjarsiglas) }}" target="new" class="nolink" id="sale_url{{ $u->urlj_id }}">
                                    {{ url('/') }}/jardin/{{ strtolower($u->urlj_cjarsiglas) }}
                                </a>
                            @else
                                <a href="{{ url('/') }}/jardin/{{ strtolower($u->urlj_cjarsiglas) }}/{{ $u->urlj_url }}" target="new" class="nolink" id="sale_url{{ $u->urlj_id }}">
                                    {{ url('/') }}/jardin/{{ strtolower($u->urlj_cjarsiglas) }}/{{ $u->urlj_url }}
                                </a>
                            @endif
                            <i class="bi bi-clipboard PaClick" onclick="CopiarContenido('url','{{ $u->urlj_id }}')"></i>

                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($urls->count()=='0') -- aún no se registra ninguna URL -- @endif
    </div>






















    <!-- ------------------------------------------------------------------------------------ -->
    <!-- ------------------------ CAMPOS DE BÚSQUEDA DE AUTORES ----------------------------- -->
    <!-- ------------------------------------------------------------------------------------ -->
    <div class="row my-4">
        <h3>Autores</h3>

        {{-- <!-- buscar por rol -->
        <div class="col-12 col-md-3 form-group">
            <label class="form-label">Con el rol</label>
            <select wire:model.live="rolSel" class="form-select">
                <option value="">Todos</option>
                <option value="Autor">Autor</option>
                <option value="Traductor">Traductor</option>
                <option value="AutorTraductor">Autor/Traductor</option>
            </select>
        </div> --}}

        <!-- buscar por nombre o correo -->
        {{-- <div class="col-12 col-md-3 form-group">
            <label class="form-label">Con nombre o correo</label>
            <input wire:model.live="nombreSel" class="form-control">
        </div> --}}
    </div>

    <!-- ---------------------------------------------  --------------------------------------- -->
    <!-- ----------------------------- TABLA DE AUTORES ------------------------------------ -->
    <!-- ------------------------------------------------------------------------------------ -->
    <div class="table-responsive-sm">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th wire:click="ordenaTabla('id')" class="PaClick">Id</th>
                    <th wire:click="ordenaTabla('id')" class="PaClick">Jardin</th>
                    <th wire:click="ordenaTabla('email')" class="PaClick">Nombre</th>
                    <th wire:click="ordenaTabla('usrname')" class="PaClick">Apellidos</th>
                    <th wire:click="ordenaTabla('usrname')" class="PaClick">Lengua</th>
                    <th wire:click="ordenaTabla('nombre')" class="PaClick">Institución</th>
                    <th wire:click="ordenaTabla('nombre')" class="PaClick">Comunidad</th>
                    <th >Edición</th>
                    <th wire:click="ordenaTabla('usrname')" class="PaClick">Dirección</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($autores as $a)
                    <tr class="@if($a->caut_act=='0') inact @endif">
                        <!-- id autores -->
                        <td>
                            {{ $a->aurl_id }}
                        </td>

                        <!-- jardin -->
                        <td>
                            {{ $a->aurl_cjarsiglas }}
                        </td>
                        <!-- nombre autores  -->
                        <td>
                            {{ $a->autor->caut_nombre }}
                        </td>

                        <!-- Apellidos autores  -->
                        <td>
                            {{ $a->autor->caut_apellido1 }}
                            {{ $a->autor->caut_apellido2 }}
                        </td>

                        <!-- Lengua autores  -->
                        <td>
                            {{ $a->aurl_lencode }}
                            @if($a->aurl_tradid=='0')
                                <div class="form-text">original</div>
                            @else
                                <div class="form-text">traducción</div>
                            @endif


                        <!-- institución autores  -->
                        <td>
                            {{ $a->autor->caut_institu }}
                        </td>

                        <!-- comunidad autores  -->
                        <td>
                            {{ $a->autor->caut_comunidad }}
                        </td>

                        <!-- switch de edición autores -->
                        <td>
                            <div class="form-check form-switch">
                                <input  wire:change="CambiaEdoEdicionAutor('{{ $a->aurl_id }}')" class="form-check-input" value="1" type="checkbox" role="switch" id="flexSwitchCheckDefault{{ $a->aurl_id }}" @if($a->aurl_edit=='1') checked @endif style="@if($a->aurl_edit=='1')background-color:red; @endif">
                                <label class="form-check-label" for="flexSwitchCheckDefault{{ $a->aurl_id }}">@if($a->aurl_edit=='0')Off @else Editando @endif</label>
                            </div>
                        </td>
                        <!-- url autores  -->
                        <td>
                            <a href="{{ url('/autor') }}/{{ $a->aurl_cjarsiglas }}/{{ $a->aurl_url }}" id="sale_autor{{ $a->aurl_id }}" target="new" class="nolink">
                                {{ url('/autor') }}/{{ $a->aurl_cjarsiglas }}/{{ $a->aurl_url }}
                            </a>
                            <i class="bi bi-clipboard PaClick" onclick="CopiarContenido('autor','{{ $a->aurl_id }}')"></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <button wire:click="VerNoVerNuevoAutor()" class="btn btn-secondary">@if($verNvoAutor=='1')Ocultar nueva @else Nueva @endif página autor</button>
        </div>


        <!--- ------------------------------ Nuevo autor -------------------------- -->
        @if($verNvoAutor=='1')
            <div class="row my-5">
                <div class="col-12 col-md-2 my-1 form-group">
                    <div class="form-check">
                        <input wire:model="NvoAutorTipo" wire:change="SeleccionaNuevoAutor()" value="autor" class="form-check-input" type="radio" name="radioDefault" id="radioDefault1">
                        <label class="form-check-label" for="radioDefault1">
                            Nuevo autor
                        </label>
                    </div>
                    <div class="form-check">
                        <input wire:model="NvoAutorTipo" wire:change="SeleccionaNuevoAutor()" value="traduccion" class="form-check-input" type="radio" name="radioDefault" id="radioDefault2" checked>
                        <label class="form-check-label" for="radioDefault2">
                            Nueva traducción
                        </label>
                    </div>
                    @error('NvoAutorTipo')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Autor -->
                <div class="col-12 col-md-3 my-1 form-group">
                    <label for="NvoAutor" class="form-label">Indica al autor<red>*</red></label>
                    <select wire:model="NvoAutor" id="NvoAutor" class="@error('NvoAutor') is-invalid @enderror form-select">
                        <option value="">Indicar autor...</option>
                        @foreach($NvosAutores as $a)
                            <option value="{{ $a->caut_id }}">{{ $a->caut_nombre }} {{ $a->caut_apellido1 }} {{ $a->caut_apellido2 }}</option>
                        @endforeach
                    </select>
                    <div class="form-text"></div>
                    @error('NvoAutor')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Lengua -->
                <div class="col-12 col-md-3 my-1 form-group">
                    <label for="NvaLengua" class="form-label">Indica la lengua<red>*</red></label>
                    <select wire:model="NvaLengua" id="NvaLengua" class="@error('NvaLengua') is-invalid @enderror form-select">
                        <option value="">Indicar lengua...</option>
                        @foreach($NvasLenguas as $l)
                            <option value="{{ $l->len_code }}">{{ $l->len_autonimias }} ({{ $l->len_lengua }}) {{ $l->len_code }}</option>
                        @endforeach
                    </select>
                    <div class="form-text"></div>
                    @error('NvaLengua')<error>{{ $message }}</error>@enderror
                </div>

                <!-- botones cancelar y crear -->
                <div class="col-12 col-md-3 my-1 form-group">
                    <br><br>

                    <button wire:click="VerNoVerNuevoAutor()" class="btn btn-secondary">Cancelar</button>
                    <button wire:click="CrearNuevaPaginaDeAutor()"class="btn btn-primary">Crear</button>
                </div>

            </div>
        @endif

        <!-- menú de paginación autores  -->
        {{-- @if($usuarios->hasPages())
         <div class="">
            <div class="paginador">
                <a href="{{ $usuarios->previousPageUrl() }}"><div class="boton" @if($usuarios->currentPage() == '1') disabled @endif> &laquo; </div></a>
                @foreach (range(1,$usuarios->lastPage()) as $i)
                    @if($i == $usuarios->currentPage())
                        <div class="boton" disabled> {{ $i }} </div>
                    @else
                        <a href="{{ $usuarios->url($i) }}"><div class="boton"> {{ $i }} </div></a>
                    @endif
                @endforeach
                <a href="{{ $usuarios->nextPageUrl() }}"><div class="boton" @if($usuarios->currentPage() == $usuarios->lastPage()) disabled @endif> &raquo; </div></a>
                Estás en {{ $usuarios->currentPage() }}
            </div>
         </div>
        @endif --}}
    </div>



    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- ---------------------------- INICIA MODAL PÁGINA WEB DE JARDIN --------------------------- -->
    <div wire:ignore.self class="modal fade" id="ModalUrlsJardin" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        @if($jardinId=='0')
                            Creando nueva página
                        @else
                            Editando página {{ $jardinId }}
                        @endif
                        de {{ $jardinSel }}
                    </h3>
                    <button wire:click="CierraModal()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- cuerpo del modal -->
                <div class="modal-body">
                    <!-- Datos de usuario -->
                    <div class="row">
                        <div class="col-12 form-group">
                            <center>
                                <label class="form-label">Banner de la página</label><br>
                                <!-- MODAL: si no hay imagen -->
                                @if($this->bannerimg =='')
                                    @if($this->NvoBanner != '')
                                        <div>
                                            <img src="{{ $this->NvoBanner->temporaryUrl() }}" style="width:100%; max-height:250px; border:1px solid #64383E;">
                                        </div>
                                    @endif
                                        <input wire:model.live="NvoBanner" class="form-control my-2" type="file" id="MiInputFile" style="width:40%;" @if($jardinId=='0' AND $origtrad !='original') disabled @endif>
                                <!-- MODAL: si hay imagen -->
                                @else
                                    <div>
                                        <img src="{{ $this->bannerimg }}" style="width:100%; max-height:250px; border:1px solid #64383E;">
                                    </div>
                                    <i wire:click="BorrarImagenModal('{{ $this->jardinId }}')" wire:confirm="Estás por elminar PERMANENTEMENTE la imagen principal del jardín y no se podrá recuperar. ¿Deseas continuar?" class="bi bi-trash agregar"> Borra imagen</i>
                                @endif
                            </center>
                        </div>
                    </div>
                    <div class="row">
                        <!-- Original o traducción -->
                        <div class="col-6 form-group">
                            <label for="origtrad" class="form-label">Original/Traducción<red>*</red></label>
                            <select wire:model.live="origtrad"  wire:change="DeterminaVariablesDeCopia()" id="origtrad" class="@error('origtrad') is-invalid @enderror form-select" @if($jardinId > '0') disabled @endif>
                                <option value="">Indica ...</option>
                                <option value="original">Página original</option>
                                <option value="traducción">Traducción de página</option>
                            </select>
                            <div class="form-text"></div>
                            @error('origtrad') <error> {{ $message }}</error>@enderror
                        </div>
                        <!-- Copia de -->
                        <div class="col-6 form-group">
                            <label for="copiade" class="form-label">Copia de<red></red></label>
                            <select wire:model.live="copiade" wire:change="DeterminaVariablesDeCopia()" id="copiade" class="@error('copiade') is-invalid @enderror form-select" @if($origtrad=='original' or $jardinId != '0') disabled @endif>
                                <option value="">Indica ...</option>
                                @foreach ($originales as $o)
                                    <option value="{{ $o->urlj_id }}"> {{ $o->urlj_cjarsiglas }}: {{ $o->urlj_url }} [{{ $o->urlj_lencode }}]</option>
                                @endforeach
                            </select>
                            <div class="form-text"></div>
                            @error('copiade') <error> {{ $message }}</error>@enderror
                        </div>
                    </div>
                    <div class="row">
                        <!-- Lengua -->
                        <div class="col-6 form-group">
                            <label for="lengua" class="form-label">Lengua<red>*</red></label>
                            <select wire:model.live="lengua" wire:change="DeterminaVariablesDeCopia()" id="lengua" class="@error('lengua') is-invalid @enderror form-select">
                                <option value="">Indica....</option>
                                {{-- <option value="spa">Español</option> --}}
                                @foreach($lenguas as $l)
                                    <option value="{{ $l->len_code }}">{{ $l->len_code }}: {{ $l->len_lengua }} {{ $l->len_variante }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Indica la lengua en la que estará la página.</div>
                            @error('lengua') <error> {{ $message }}</error>@enderror
                        </div>

                        <!-- MODAL: url web jardin -->
                        <div class="col-6 form-group">
                            <label for="url" class="form-label">URL <red>*</red> </label>
                            <input wire:model="url" id="url" class="@error('url') is-invalid @enderror form-control" @if($url=='inicio' or $origtrad=='traducción') disabled @endif type="text" >
                            <div class="form-text">Texto sin espacios ni caracteres para usar como url</div>
                            @error('url')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- MODAL: banner titulo --->
                        <div class="col-6 form-group">
                            <label for="bannertitle" class="form-label">Titulo<red>*</red> </label>
                            <input wire:model="bannertitle" id="bannertitle" class="@error('bannertitle') is-invalid @enderror form-control" type="text" >
                            <div class="form-text"> Texto que aparecerá como título de la página</div>
                            @error('bannertitle')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- MODAL: titulo web jardin -->
                        <div class="col-6 form-group">
                            <label for="titulo" class="form-label">Metadato: Título</label>
                            <input wire:model="titulo" id="titulo" class="@error('titulo') is-invalid @enderror form-control"  type="text" >
                            <div class="form-text"> Texto que aparecerá en la parte superior del navegador</div>
                            @error('titulo')<error>{{ $message }}</error>@enderror
                        </div>



                        <!-- MODAL: descrip web jardin -->
                        <div class="col-12  form-group">
                            <label for="descrip" class="form-label">Metadato: descripción</label>
                            <textarea wire:model="descrip" id="descrip" class="@error('descrip') is-invalid @enderror form-control" type="text" ></textarea>
                            <div class="form-text">Texto que mostrarán los buscadores (como google) como descripción de la página</div>
                            @error('descrip')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- MODAL: checkbox activo -->
                        <div class="col-6 form-group my-2">
                            <div class="form-check">
                                <input class="form-check-input" wire:model.live="act" type="checkbox" id="act">
                                <label class="form-check-label" for="checkDefault"> Publicar página </label><br>
                                @if($act==FALSE)<b><error>La página no está disponible al público</error></b> @else El público puede acceder a este sitio @endif
                            </div>
                        </div>

                        <!-- MODAL: Borrar-->
                        @if( !in_array($url,['inicio','autores','cedulas']) and $jardinId > '0')
                            <div class="col-6 form-group my-2">
                                <i  wire:click="EliminarSitioWeb()" class="bi bi-trash agregar"> Eliminar página completa</i>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="GuardaModal()" class="btn btn-primary">
                        <span wire:loading.remove> Guardar </span>
                        <span wire:loading style="display:none;"> <red> ..guardando...</red> </span>
                    </button>

                    <button wire:click="CierraModal()" class="btn btn-secondary">
                        Cerrar
                    </button>


                </div>
            </div>
        </div>
    </div>
    <!-- ----------------------------- TERMINA MODAL ROLES DE USUARIO ------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->




    <script>
        /* ### Script para abrir y cerrar modal */
        Livewire.on('AbreModalUrlJardin', () => {
            $('#ModalUrlsJardin').modal('show');
        });

        Livewire.on('CierraModalUrlJardin', () => {
            $('#ModalUrlsJardin').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });

        Livewire.on('AvisoExitoAdminWeb',()=>{
            alert(event.detail.msj);
        })

        /* ### Script para mostrar botón personalizado de input=file */
        document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
            document.getElementById('MiInputFile').click();
        });
    </script>

</div>
<!-- ------------ TERMINA CONTENIDO PRINCIPAL ------------------- -->
<!-- ----------------------------------------------------------- -->
@section('scripts')

@endsection
