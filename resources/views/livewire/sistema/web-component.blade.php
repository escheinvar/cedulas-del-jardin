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
        Este catálogo es administrado por el rol <b>webmaster</b> en jardin: {{ implode(',',$editjar) }}
        (@if($edit=='0') <error style="font-size: 90%;"> No autorizado</error> @else <span style="font-size:90%;color:green;"> Autorizado </span>@endif)
    </div>

    <!-- buscar por jardín -->
    <div class="row my-3">
        <div class="col-12 col-md-3 form-group">
            <label class="form-label">Jardin</label>
            <select wire:model.live="jardinSel" class="form-select">
                <option value="">Indica un jardín</option>
                @foreach($JardsDelUsr as $jar)
                    <option value="{{ $jar->cjar_siglas }}">{{ $jar->cjar_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- ------------------------------------------------------------------------------------ -->
    <!-- ----------------------- SITIOS WEB DE LOS JARDÍNES --------------------------------- -->
    <!-- ------------------------------------------------------------------------------------ -->
    <h3>Del jardin</h3>
    <div class="" style="clear: both;">
        @if($edit=='1' and $jardinSel != '')
            <button wire:click="AbreModalWeb('jardin','0')" class="btn btn-secondary" style="float: right;">
                Nueva página
            </button><br>
        @endif
    </div>
    <div class="table-responsive-sm"  style="clear:both;">
        <table class="table table-striped table-sm my-4">
            <thead>
                <tr>
                    <th wire:click="ordenaTabla('urlj_id')" class="PaClick">Id</th>
                    <th></th>
                    <th wire:click="ordenaTabla('urlj_url')" class="PaClick">url</th>
                    <th wire:click="ordenaTabla('urlj_titulo')" class="PaClick">Titulo</th>
                    <th wire:click="ordenaTabla('urlj_descrip')" class="PaClick">Descripción</th>
                    <th> Edición </th>
                    <th wire:click="ordenaTabla('urlj_descrip')" class="PaClick"> Dirección </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($urls as $u)
                    <tr>
                        <!-- id -->
                        <td class="@if($u->urlj_act=='0') inact @endif @if($edit=='1')PaClick @endif" wire:click="AbreModalWeb('jardin','{{ $u->urlj_id }}')">
                             {{ $u->urlj_id }}
                        </td>

                        <!-- icono editar -->
                        <td>
                            <i class="bi bi-pencil-square @if($edit=='1')PaClick @endif" wire:click="AbreModalWeb('jardin','{{ $u->urlj_id }}')"></i>
                        </td>

                        <!-- url -->
                        <td class="@if($u->urlj_act=='0') inact @endif @if($edit=='1')PaClick @endif" wire:click="AbreModalWeb('jardin','{{ $u->urlj_id }}')">
                             {{ $u->urlj_url }}
                        </td>

                        <!-- titulo-->
                        <td class="@if($u->urlj_act=='0')  inact @endif @if($edit=='1')PaClick @endif" wire:click="AbreModalWeb('jardin','{{ $u->urlj_id }}')">
                             {{ $u->urlj_titulo }}
                        </td>

                        <!-- descripcion -->
                        <td  class="@if($u->urlj_act=='0') inact @endif  @if($edit=='1')PaClick @endif" wire:click="AbreModalWeb('jardin','{{ $u->urlj_id }}')">
                            {{ $u->urlj_descrip }}
                        </td>

                        <!-- apagador edit -->
                        <td>
                            @if($edit=='1')
                                <div class="form-check form-switch">
                                    <input  wire:change="CambiaEstadoEdicion('{{ $u->urlj_id }}')" class="form-check-input" value="1" type="checkbox" role="switch" id="flexSwitchCheckDefault" @if($u->urlj_edit=='1') checked @endif style="@if($u->urlj_edit=='1')background-color:red; @endif">
                                    <label class="form-check-label" for="flexSwitchCheckDefault">@if($u->urlj_edit=='0')Off @else Editando @endif</label>
                                </div>
                            @endif
                        </td>

                        <!-- http dir-->
                        <td class="@if($u->urlj_act=='0') inact @endif">
                            <a href="{{ url('/') }}/jardin/{{ $u->urlj_url }}" target="new" class="nolink">
                                {{ url('/') }}/jardin/{{ strtolower($u->urlj_cjarsiglas) }}@if($u->urlj_url != 'inicio')/{{ $u->urlj_url }} @endif
                            </a>
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

        <!-- buscar por rol -->
        <div class="col-12 col-md-3 form-group">
            <label class="form-label">Con el rol</label>
            <select wire:model.live="rolSel" class="form-select">
                <option value="">Todos</option>
                <option value="Autor">Autor</option>
                <option value="Traductor">Traductor</option>
                <option value="AutorTraductor">Autor/Traductor</option>
            </select>
        </div>

        <!-- buscar por nombre o correo -->
        <div class="col-12 col-md-3 form-group">
            <label class="form-label">Con nombre o correo</label>
            <input wire:model.live="nombreSel" class="form-control">
        </div>
    </div>

    <!-- ---------------------------------------------  --------------------------------------- -->
    <!-- ----------------------------- TABLA DE USUARIOS ------------------------------------ -->
    <!-- ------------------------------------------------------------------------------------ -->
    <div class="table-responsive-sm">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th wire:click="ordenaTabla('id')" class="PaClick">Id</th>
                    <th wire:click="ordenaTabla('email')" class="PaClick">email</th>
                    <th wire:click="ordenaTabla('usrname')" class="PaClick">usr</th>
                    <th wire:click="ordenaTabla('nombre')" class="PaClick">Nombre</th>
                    <th >Rol (jardin)</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($usuarios as $usr)
                    <tr class="PaClick @if($usr->act=='0') inact @endif" wire:click="AbreModal('{{ $usr->id }}')">
                        <td> {{ $usr->id }} </td>
                        <td> {{ $usr->email }}  </td>
                        <td> {{ $usr->usrname }}  </td>
                        <td> {{ $usr->nombre }} {{ $usr->apellido }}  </td>
                        <td>
                            @foreach ($usr->roles as $rol)
                                <b>{{ $rol->rol_crolrol }}</b> ({{ $rol->rol_cjarsiglas }}), &nbsp;
                            @endforeach
                        </td>
                        <td>
                            <i class="bi bi-pencil-square PaClick"  ></i>
                            @if($usr->act=='0') X @endif
                        </td>
                    </tr>
                @endforeach --}}
            </tbody>
        </table>

        <!-- menú de paginación -->
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
    <!-- ---------------------------- INICIA MODAL ROLES DE USUARIO --------------------------- -->
    <div wire:ignore.self class="modal fade" id="ModalUrlsJardin" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
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
                                <label class="form-label">Banner del jardín</label><br>
                                <!-- MODAL: si no hay imagen -->
                                @if($this->bannerimg =='')
                                    @if($this->NvoBanner != '')
                                        <div>
                                            <img src="{{ $this->NvoBanner->temporaryUrl() }}" style="width:100%; max-height:250px; border:1px solid #64383E;">
                                        </div>
                                    @endif
                                        <input wire:model.live="NvoBanner" class="form-control my-2" type="file" id="MiInputFile" style="width:40%;">
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
                        <!-- MODAL: url web jardin -->
                        <div class="col-12 col-md-6 form-group">
                            <label for="url" class="form-label">URL <red>*</red> </label>
                            <input wire:model="url" id="url" class="@error('url') is-invalid @enderror form-control" @if($url=='inicio') disabled @endif type="text" >
                            <div class="form-text">Texto sin espacios ni caracteres para usar como url en: {{ url('/')."/".$jardinSel."/url" }}</div>
                            @error('url')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- MODAL: banner titulo --->
                        <div class="col-12 col-md-6 form-group">
                            <label for="bannertitle" class="form-label">Titulo<red>*</red> </label>
                            <input wire:model="bannertitle" id="bannertitle" class="@error('bannertitle') is-invalid @enderror form-control" type="text" >
                            <div class="form-text"> Texto que aparecerá como título de la página</div>
                            @error('bannertitle')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- MODAL: titulo web jardin -->
                        <div class="col-12 col-md-6 form-group">
                            <label for="titulo" class="form-label">Metadato: Título</label>
                            <input wire:model="titulo" id="titulo" class="@error('titulo') is-invalid @enderror form-control"  type="text" >
                            <div class="form-text"> Texto que aparecerá como nombre de la página en la parte superior del navegador</div>
                            @error('titulo')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- MODAL: checkbox activo -->
                        <div class="col-12 col-md-3 form-group my-2">
                            <div class="form-check">
                                <input class="form-check-input" wire:model.live="act" type="checkbox" id="act">
                                <label class="form-check-label" for="checkDefault"> Publicar página </label><br>
                                @if($act==FALSE)<b>La página no está disponible al público</b> @else El público puede acceder a este sitio @endif
                            </div>
                        </div>

                        <!-- MODAL: Borrar-->
                        <div class="col-12 col-md-3 form-group my-2">
                            @if($url !='inicio' and $jardinId > '0')
                                <i  wire:click="" class="bi bi-trash agregar"> Eliminar página completa</i>
                            @endif
                        </div>

                        <!-- MODAL: descrip web jardin -->
                        <div class="col-12  form-group">
                            <label for="descrip" class="form-label">Metadato: descripción</label>
                            <textarea wire:model="descrip" id="descrip" class="@error('descrip') is-invalid @enderror form-control" type="text" ></textarea>
                            <div class="form-text">Texto que mostrarán los buscadores (como google) como descripción de la página</div>
                            @error('descrip')<error>{{ $message }}</error>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button> --}}

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
