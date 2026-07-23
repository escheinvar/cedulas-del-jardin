<div>
<!-- ------------------------------------------------------------------------------------------ -->
<!-- --------------------------------------- MODAL DE PROYECTO ------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<div wire:ignore.self class="modal fade" id="Modal_proyecto" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- ----------------------------  cabeza del modal ------------------------- -->
            <div class="modal-header">
                <h3 class="modal-title">
                    @if($proyId=='0')
                        Enviando nuevo proyecto
                    @elseif($proyId > '0')
                        Proyecto {{ $tituloId }}: {{ $proy->proy_titulo }}
                    @endif
                </h3>
                <button wire:click="CerrarModalProyecto()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
            </div>
            <!-- ----------------------------  cuerpo del modal ------------------------- -->
            <div class="modal-body" wire:loading.attr="disabled">
                @if($proyId > '0')
                    {{-- <b>Estado actual</b>: {{ $proyEdo->predo_edo }} {{ $proyEdo->predo_estado }} --}}
                    <b>Estado</b>: {{ $proy->estados->where('predo_act','1')->value('predo_edo') }} {{ $proy->estados->where('predo_act','1')->value('predo_estado')}}

                @endif

                <!---------------------------------------------------------------------------------- -->
                <!------------------------------ FORMULARIO ---------------------------------------- -->
                @if($proyId=='0')
                    <div class="row">
                        <!-- Título del proyecto -->
                        <div class="col-12 col-md-6 my-1 form-group">
                            <label for="titulo" class="form-label">Título del proyecto<red>*</red></label>
                            <input wire:model="titulo" id="titulo" class="@error('titulo') is-invalid @enderror form-control" type="text">
                            <div class="form-text">Nombre con el que identificarás este proyecto dentro del sistema</div>
                            @error('titulo')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- jardín -->
                        <div class="col-12 col-md-6 my-1 form-group">
                            <label for="jardin" class="form-label">Jardín Virtual<red>*</red></label>
                            <select wire:model="jardin" id="jardin" class="@error('jardin') is-invalid @enderror form-select">
                                <option value="">Indicar...</option>
                                @foreach($jardines as $j)
                                    <option value="{{ $j->cjar_siglas }}">{{ $j->cjar_siglas }} ({{ $j->cjar_nombre }})</option>
                                @endforeach
                            </select>
                            <div class="form-text">Jardín virtual al que pertenecerá la publicación</div>
                            @error('jardin')<error>{{ $message }}</error>@enderror
                        </div>
                    </div>
                @endif
                @if( $proyId > '0')
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <!-- Autor 1 -->
                            <b>Autor correspondencia:</b>
                            @if($proy->autor1)
                                {{ $proy->autor1->usrname ?? '--' }}
                                @if($proy->proy_autor2 !='' OR $proy->proy_autor3 != '') <i wire:click="BorrarAutorProyecto('{{ $proy->proy_id }}','1')" wire:confirm="Vas a eliminar al autor de correspondencia {{ $proy->autor1->usrname }} de este proyecto y ya no tendrá acceso. ¿Quieres continuar?" class="bi bi-trash agregar"></i> @endif |
                            @endif
                            <!-- Autor 2 -->
                            @if($proy->autor2)
                                {{ $proy->autor2->usrname ?? '' }}
                                @if(($proy->autor1 OR $proy->autor3) AND $cancha=="autor") <i wire:click="BorrarAutorProyecto('{{ $proy->proy_id }}','2')" wire:confirm="Vas a eliminar al autor de correspondencia {{ $proy->autor2->usrname }} de este proyecto y ya no tendrá acceso. ¿Quieres continuar?" class="bi bi-trash agregar"></i> @endif |
                            @endif
                            <!-- Autor 3 -->
                            @if($proy->autor3)
                                {{ $proy->autor3->usrname ?? '' }}
                                @if(($proy->autor1 OR $proy->autor2) AND $cancha=="autor") <i wire:click="BorrarAutorProyecto('{{ $proy->proy_id }}','3')" wire:confirm="Vas a eliminar al autor de correspondencia {{ $proy->autor3->usrname }} de este proyecto y ya no tendrá acceso. ¿Quieres continuar?" class="bi bi-trash agregar"></i> @endif |
                            @endif
                            <!-- nvo autor -->
                            @if((!$proy->autor1 or !$proy->autor2 or !$proy->autor3) AND $cancha=="autor")
                                <i wire:click="AgregarAutorProyecto('{{ $proy->proy_id }}')" class="bi bi-plus-circle-fill agregar" ></i></button>
                            @endif
                        </div>
                        <div class="col-12  col-md-4">
                            <b>Administrador:</b> {{ $p->admin->usrname ?? '--' }}
                        </div>
                        <div class="col-12 col-md-4">
                            <b>Editor:</b> {{ $p->editor->usrname ?? '--' }}
                        </div>
                        <hr>
                    </div>
                    <div class="row" >
                        @if($proy->estados->where('predo_act','1')->value('predo_edo') <= '0.1')
                            <!-- Formato de envío -->
                            <div class="col-12 col-md-6 my-1 form-group">
                                <label for="ArchFormato" class="form-label">Formato de envío<red>*</red></label>
                                <input wire:model="ArchFormato" id="ArchFormato" class="agregar @error('ArchFormato') is-invalid @enderror form-control" type="file" @if($edit=='0') disabled @endif>
                                <button wire:click="SubirArchivo('Formato')" class="btn btn-sm btn-primary bi bi-plus" @if($ArchFormato=='') disabled @endif></button>
                                <div class="form-text"></div>
                                @error('ArchFormato')<error>{{ $message }}</error>@enderror
                            </div>
                            <!-- Carta solicitud -->
                            <div class="col-12 col-md-6 my-1 form-group">
                                <label for="ArchSol" class="form-label">Carta Solicitud de publicación<red>*</red></label>
                                <input wire:model="ArchSol" id="ArchSol" class="agregar @error('ArchSol') is-invalid @enderror form-control" type="file" @if($edit=='0') disabled @endif>
                                <button wire:click="SubirArchivo('Solicitud')" class="btn btn-sm btn-primary bi bi-plus" @if($ArchSol=='') disabled @endif></button>
                                <div class="form-text"></div>
                                @error('ArchSol')<error>{{ $message }}</error>@enderror
                            </div>
                            <!-- Archivo principal -->
                            <div class="col-12 col-md-6 my-1 form-group">
                                <label for="ArchPpal" class="form-label">Archivo principal<red>*</red></label>
                                <input wire:model="ArchPpal" id="ArchPpal" class="agregar @error('ArchPpal') is-invalid @enderror form-control" type="file" @if($edit=='0') disabled @endif>
                                <button wire:click="SubirArchivo('Principal')" class="btn btn-sm btn-primary bi bi-plus" @if($ArchPpal=='') disabled @endif></button>
                                <div class="form-text"></div>
                                @error('ArchPpal')<error>{{ $message }}</error>@enderror
                            </div>
                            <!-- Archivos adicionales -->
                            <div class="col-12 col-md-6 my-1 form-group">
                                <label for="ArchMaterial" class="form-label">Archivos adicionales <red></red></label>
                                <input wire:model="ArchMaterial" id="ArchMaterial" class="agregar @error('ArchMaterial') is-invalid @enderror form-control" type="file" @if($edit=='0') disabled @endif>
                                <button wire:click="SubirArchivo('Material')" class="btn btn-sm btn-primary bi bi-plus"  @if($ArchMaterial=='') disabled @endif></button>
                                <div class="form-text">Cargar archivos y luego picar +</div>
                                @error('ArchMaterial')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        @if( $proy->estados->where('predo_act','1')->value('predo_edo') > '0.1')
                            <!-- Archivos de revisión -->
                            <div class="col-12 col-md-6 my-1 form-group">
                                <label for="ArchRevision" class="form-label">Archivos del proceso: <red></red></label>
                                <input wire:model="ArchRevision" id="ArchRevision" class="agregar @error('ArchRevision') is-invalid @enderror form-control" type="file" @if($edit=='0') disabled @endif>
                                <button wire:click="SubirArchivo('Revision')" class="btn btn-sm btn-primary bi bi-plus"  @if($ArchRevision=='') disabled @endif></button>
                                <div class="form-text">Cargar archivos y luego picar +</div>
                                @error('ArchRevision')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif
                    </div>
                @endif

                <!---------------------------------------------------------------------------------- -->
                <!--------------------------- ARCHIVOS CARGADOS ------------------------------------ -->
                @if($proyArchs AND $proyArchs->count() > ' 0')
                    <div class="row">
                        <div class="col-12 my-1  form-group">
                            <b>Archivos cargados:</b>
                            <ul>
                                @foreach($proyArchs as $a)
                                    <li>
                                        {{ $a->prmat_nombrearch }} ({{ $a->prmat_tipo }})
                                        @if($edit=='1')
                                            <i wire:click="EliminarArchivo('{{ $a->prmat_id }}')" wire:confirm='Estás por eliminar definitivamente el archivo {{ $a->prmat_tipo }}: "{{ $a->prmat_nombrearch }}". Esta acción no se podrá recuperar. ¿Quieres seguir?' class="bi bi-trash agregar PaClick" ></i>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!---------------------------------------------------------------------------------- -->
                <!--------------------------- FORMULARIO NOTAS ------------------------------------- -->
                @if($proyId > '0')
                    <div class="row" >
                        <div class="col-12 my-1 form-group">
                            <label for="NvoComents" class="form-label">Comentarios<red></red></label>
                            <textarea wire:model="NvoComents" id="NvoComents" class="@error('NvoComents') is-invalid @enderror form-control" rows="5" @if($edit=='0') disabled @endif></textarea>
                            <div class="form-text"></div>
                            @error('NvoComents')<error>{{ $message }}</error>@enderror
                        </div>
                    </div>
                @endif

                <!---------------------------------------------------------------------------------- -->
                <!--------------------------- ASIGNACIÓN DE EDITOR --------------------------------- -->
                @if( $proyId > '0' and $editores->count() > '0')
                    @if($proy->estados->where('predo_act','1')->value('predo_edo') == '0.2' OR
                        $proy->estados->where('predo_act','1')->value('predo_edo') == '0.5' )
                        <!-- Selecciona Editor -->
                        <div class="col-12 col-md-6 my-1 form-group">
                            <label for="NuevoEditor" class="form-label">Indica al editor<red></red></label>
                            <select wire:model="NuevoEditor" id="NuevoEditor" class="@error('NuevoEditor') is-invalid @enderror form-select" @if($edit=='0') disabled @endif>
                                <option value="">Indicar...</option>
                                @foreach($editores as $e)
                                    <option value="{{ $e->rol_usrid }}">{{ $e->nombre }} {{ $e->apellido }} ({{ $e->rol_cjarsiglas }})</option>
                                @endforeach
                            </select>
                            <div class="form-text"></div>
                            @error('NuevoEditor')<error>{{ $message }}</error>@enderror
                        </div>
                    @endif
                @endif

                {{-- <button wire:click='juego()'>JUEGO</button> --}}
                <!---------------------------------------------------------------------------------- -->
                <!--------------------------- BOTONES DE ACCIÓN ------------------------------------ -->
                @if($edit=='0')
                    <error class="parpadeo">Esperando al {{ $cancha }}</error>
                @else
                    Acción del {{ $cancha }}:
                @endif

                @if(in_array('admin',session('rol')))
                    <div style="margin:15px;">
                        <!-- Botones de Acciones del Administrador -->
                        <button wire:click="CambiaEstado('0.3')" class="btn btn-sm btn-primary bi bi-slash-circle"
                            style="margin:7px;display:{{ $Arechaza }};">
                            Rechazar Proyecto
                        </button>
                        <button wire:click="CambiaEstado('0.4')" class="btn btn-sm btn-primary bi bi-pencil-square"
                            style="margin:7px;display:{{ $Amodif }};">
                            Revisión por autor
                        </button>
                        <button wire:click="CambiaEstado('1.0')" class="btn btn-sm btn-primary bi bi-person-fill-check"
                            style="margin:7px;display:{{ $Aeditor }};">
                            Asignar editor
                        </button>
                    </div>
                @endif
                @if(in_array('editor',session('rol')))
                    <div style="margin:15px;">
                    <!-- Botones de Acciones del editor -->
                        <button wire:click="CambiaEstado('1.0')" class="btn btn-sm btn-primary bi bi-eye"
                            style="margin:7px;display:{{ $Arevisor }};">
                            Asigna revisores
                        </button>
                        <button wire:click="CambiaEstado('1.1')" class="btn btn-sm btn-primary bi bi-check2-all"
                            style="margin:7px;display:{{ $Aautor }};">
                            Enviar a autor
                        </button>
                        <button wire:click="CambiaEstado('2.0')" class="btn btn-sm btn-primary bi bi-check2-all"
                            style="margin:7px;display:{{ $Aautoriza }};">
                            Iniciar publicación
                        </button>
                    </div>
                @endif
                @if(in_array('autor',session('rol')))
                    <!-- Botones de Acciones del Autor -->
                    <div style="margin:15px;">
                        <button wire:click="CambiaEstado('0.2')" class="btn btn-sm btn-primary bi bi-person-add"
                            style="margin:7px;display:{{ $Badmin }};">
                            Enviar a administrador
                        </button>
                        <button wire:click="CambiaEstado('0.5')" class="btn btn-sm btn-primary bi bi-person-add"
                            style="margin:7px;display:{{ $Badmin2 }};">
                            Enviar a administrador <!-- 2 -->
                        </button>
                        <button wire:click="CambiaEstado('1.2')" class="btn btn-sm btn-primary bi bi-person-fill-check"
                            style="margin:7px;display:{{ $Beditor }};">
                            Enviar a editor
                        </button>
                    </div>
                @endif
                <div style="margin:15px;">
                    <a href="/admin_cedulas" style="display:{{ $BirApub }}">
                        {{-- <button  class="btn btn-sm btn-primary bi bi-person-fill-check"
                            style="margin:7px;"> --}}
                            Ir a sección de publicaciones
                        {{-- </button> --}}
                    </a>
                    @if(in_array('admin',session('rol')))
                        <button  class="btn btn-sm btn-primary bi bi-person-fill-check"
                            style="margin:7px; display:{{ $BirApub }}">
                            Regresar a proyecto
                        </button>
                    @endif
                    <button wire:click="CrearProyecto()" class="btn btn-sm btn-primary bi bi-person-add"
                        style="margin:7px;display:{{ $Bcrear }};">
                        Crear proyecto
                    </button>
                </div>
                @if($proyId > '0')
                    <div style="float:left;">
                        <i wire:click='EliminarProyecto()' wire:confirm='Vas a eliminar todo el proyecto, sus avances y todos sus archivos y tendrás que volver a iniciar el proyecto. ¿Estás seguro de que quieres continuar?' class="bi bi-trash agregar"> Eliminar proyecto</i>
                    </div>
                    <div style="float:right;">
                        <i wire:click='ArchivarProyecto()' class="bi bi-archive-fill agregar"> @if($proy->proy_act=='1')Archivar proyecto @else Desarchivar proyecto @endif</i>
                    </div>
                @endif
            </div>

            <!-- ---------------------------- pie del modal ----------------------------- -->
            <div class="modal-footer">
                <button wire:click="CerrarModalProyecto()" class="btn btn-secondary">Cerrar</button>
                {{-- <button wire:click="GuardaModal()" wire:loading.attr="disabled" class="btn btn-primary">Guardar</button> --}}
                {{-- <span wire:loading style="display:none;"><red>pensando...</red> </span> --}}
            </div>
        </div>
    </div>
</div>

@if($edit=='1')
    <livewire:sistema.modal-admin-cedula-component />
@endif
<!-- ----------------------------- TERMINA MODAL ROLES DE USUARIO ------------------------- -->
<!-- -------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------- -->
    <script>
        /* ### Script para abrir y cerrar Modal */
        Livewire.on('AbreModalProyecto', () => {
            $('#Modal_proyecto').modal('show');
        });
        Livewire.on('CierraModalProyecto', () => {
            $('#Modal_proyecto').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });


        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoProyecto',()=>{
            alert(event.detail.msj);
        })

        /* ### Script para mostrar botón personalizado de input=file */
        //document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
        //    document.getElementById('MiInputFile').click();
        //});

        /* #### Recibe variable desde un componente externo y lo manda a livewire */
        //Livewire.on('RecibeVariables',() => {
        //    @this.set('ModeloWire',event.detail.dato, live=true);
        //});

        /* #### Reiniciar la página */
        Livewire.on('RecargarPagina',() => {
            location.reload();
            // window.location.href;
        });
    </script>
</div>
