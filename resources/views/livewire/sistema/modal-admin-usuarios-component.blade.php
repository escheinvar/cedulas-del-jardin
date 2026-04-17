<div>
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- ---------------------------- INICIA MODAL ROLES DE USUARIO --------------------------- -->
    <div wire:ignore.self class="modal fade" id="ModalRolesDeUsuario" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Editor de datos de usuario {{ $usrId }}
                    </h3>
                    <button wire:click="CierraModal()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- cuerpo del modal -->
                <div class="modal-body">
                    <!-- Datos de usuario -->
                    <div class="row">
                        <div class="col-sm-12 col-md-3">
                            <div class="row">
                                <div class="col-12 form-group">
                                    <center>
                                        <label class="form-label">Avatar</label><br>
                                        @if($this->avatar =='')
                                            <img src="@if($NvoAvatar=='') /avatar/usr_default.png @else {{ $NvoAvatar->temporaryUrl() }} @endif" style="max-width:100px; max-height:150px; border:1px solid #64383E;">
                                        @else
                                            <img src="{{ $this->avatar }}" style="max-width:100px; max-height:150px; border:1px solid #64383E;">
                                        @endif
                                        <button type="button" class="btn btn-secondary btn-sm m-2" id="MiBotonPersonalizado">
                                            <i class="bi bi-card-image"></i> Buscar archivo
                                        </button>
                                        <input wire:model.live="NvoAvatar" type="file" id="MiInputFile" style="display: none;">
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-9">
                            <div class="row">
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label class="form-label">Correo</label>
                                    <input wire:model="correo" type="text" class="form-control" disabled>
                                    @error('correo')<error>{{ $message }}</error>@enderror
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label class="form-label">Fecha Nacimiento</label>
                                    <input wire:model="nace" type="date" class="form-control" >
                                    @error('correo')<error>{{ $message }}</error>@enderror
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label class="form-label">Nombre de usuario <red>*</red> (único) </label>
                                    <input wire:model="usrname" type="text" class="form-control">
                                    @error('usrname')<error>{{ $message }}</error>@enderror
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label class="form-label">Nombre<red>*</red> </label>
                                    <input wire:model="nombre" type="text" class="form-control">
                                    @error('nombre')<error>{{ $message }}</error>@enderror
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label class="form-label">Apellido <red>*</red> </label>
                                    <input wire:model="apellido" type="text" class="form-control">
                                    @error('apellido')<error>{{ $message }}</error>@enderror
                                </div>
                                <div class="col-sm-12 col-md-6 form-group my-2">
                                    <div class="form-check">
                                        <input class="form-check-input" value='1' wire:model.live="Inactiva" type="checkbox" id="checkDefault">
                                        <label class="form-check-label" for="checkDefault"> Usuario Inactivo </label>
                                        @if($Inactiva=='1')
                                            <small style="color:#CD7B34;"> ATENCIÓN: si esta casilla está seleccionada, el usuario ya no podrá acceder al sistema.
                                            </small>
                                        @endif
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" value='0' wire:model.live="mensajes" type="checkbox" id="mensajes">
                                        <label class="form-check-label" for="mensajes"> Reenviar buzón a correo</label>
                                        @if($mensajes=='0')
                                            <small style="color:#CD7B34;;"> Los mensajes del buzón de este usuario ya no se reenviarán a su correo electrónico. </small>
                                        @else
                                            <small style="color:#919C1B;;"> Los mensajes del buzón se reenviarán al correo del usuario. </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--  Roles  -->
                    <div class="row">
                        <h3>Roles:</h3>
                        <div class="col-12 form-group">
                            <table class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>Rol</th>
                                        <th>Jardín</th>
                                        {{-- <th>Lengua</th>
                                        <th>Url</th> --}}
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($rolesUsr)
                                        @foreach ($rolesUsr as $r)
                                            <tr>
                                                <td> {{ $r->rol_crolrol }} </td>
                                                <td> {{ $r->rol_cjarsiglas }} @error('ErrorAdmin')<br><error>{{ $message }}</error>@enderror</td>
                                                {{-- <td> len </td>
                                                <td> url </td> --}}
                                                <td>
                                                    <!-- botón para borrar rol -->
                                                    @if(in_array($r->rol_cjarsiglas, $editjar) or in_array('todos',$editjar))
                                                        <button  wire:click="InactivarRol_Modal({{ $r->rol_id }})" wire:confirm="Estás por quitarle definitivamente el rol de {{ $r->rol_crolrol }} a este usuario ¿Deseas continuar?" class="btn btn-secondary btn-sm" >
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    <tr>

                                        <!-- selecciona rol -->
                                        <td>
                                            <select wire:model.live="NvoRol" class="@error('NvoRol') is-invalid @enderror form-select" aria-label="Default select example">
                                                <option value="">Indica un rol</option>
                                                @foreach($catRoles as $rol)
                                                    <option value="{{ $rol->crol_rol }}">{{ $rol->crol_rol }}</option>
                                                @endforeach
                                            </select>
                                            @error('NvoRol')<error>{{ $message }}</error>@enderror
                                        </td>

                                        <!-- selecciona jardín -->
                                        <td>
                                            <select wire:model.live="NvoJardin" class="@error('NvoJardin') is-invalid @enderror form-select" aria-label="Default select example">
                                                <option value="">Indica un jardín</option>
                                                @foreach ($JardsDelUsr as $jar)
                                                    <option value="{{ $jar->cjar_siglas }}"> {{ $jar->cjar_name }} / {{ $jar->ccam_siglas }} ({{ $jar->cjar_name }})</option>
                                                @endforeach
                                                @if(in_array('todos', $editjar) )
                                                    <option value="todos">Todos</option>
                                                @endif
                                            </select>
                                            @error('NvoJardin')<error>{{ $message }}</error>@enderror
                                        </td>

                                        <!-- selecciona lengua -->
                                        {{-- <td>
                                            len
                                        </td>

                                        <!-- selecciona url -->
                                        <td>
                                            url
                                        </td> --}}
                                        <td>
                                            <!-- botón para agregar rol -->
                                            <button  wire:click="AgregarRol_Modal()" class="btn btn-secondary btn-sm" @if($NvoJardin =='' && $NvoRol == '') disabled @endif>
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan='3' style="background-color: transparent;">
                                            @if($NvoRol != '')
                                                <span style="font-size: 80%;">
                                                    <b>{{ $catRoles->where('crol_rol',$NvoRol)->value('crol_rol') }}</b>:
                                                    {{ $catRoles->where('crol_rol',$NvoRol)->value('crol_describe') }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <red wire:loading style="display:none" class="parpadeo">Trabajando... espera ...</red>
                    <button wire:click="GuardaModal()" class="btn btn-primary">
                        <span wire:loading.remove> Guardar </span>
                        <span wire:loading style="display:none;"> <red class="parpadeo"> ..guardando...</red> </span>
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
        Livewire.on('AbreModalRolesDeUsuario', () => {
            $('#ModalRolesDeUsuario').modal('show');
        });
        Livewire.on('CierraModalRolesDeUsuario', () => {
            $('#ModalRolesDeUsuario').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });

        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoModalUsuarios',()=>{
            alert(event.detail.msj);
        })


        /* ### Script para mostrar botón personalizado de input=file */
        document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
            document.getElementById('MiInputFile').click();
        });

    </script>
</div>
