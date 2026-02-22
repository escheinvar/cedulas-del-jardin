
@section('title') Admin. Jardines @endsection
@section('meta-description') Administrador de Jardines del SiCedJar @endsection
@section('cintillo-ubica') -> Catálogo de Jardines @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection

<div>
    <h2>Administración de Jardines</h2>
    <div style="font-size: 80%;color:grey;">
        Este catálogo es administrado por el rol <b>Admin</b> en jardin: {{ implode(',',$editjar) }}
        (@if($edit=='0') <error style="font-size: 90%;"> No autorizado</error> @else <span style="font-size:90%;color:green;"> Autorizado </span>@endif)
    </div>
    <!--------------------------------------------------------------------------------------------->
    <!--------------------------------- TABLA DE JARDÍNES ----------------------------------------->
    <!--------------------------------------------------------------------------------------------->
    <div class="row">
        <div class="col-12 my-3">
            <div>
                <button wire:click="ProcedeJardin('0')" type="button" class="btn btn-secondary" style="float: right;">
                    Nuevo Jardín
                </button>
            </div>
        </div>
        <div class="col-12">
            <table class="table table-striped" style="width:100%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Siglas</th>
                        <th>Nombre corto</th>
                        <th>Nombre largo</th>
                        {{-- <th>Campus</th> --}}
                        <th> &nbsp; </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jardines as $jar)
                        <tr>
                            <td> {{ $jar->cjar_id }} </td>
                            <td> {{ $jar->cjar_siglas }} </td>
                            <td> {{ $jar->cjar_name }} </td>
                            <td> {{ $jar->cjar_nombre }} </td>
                            <td> <i class="bi bi-pencil-square PaClick" wire:click="ProcedeJardin({{ $jar->cjar_id }})"></i> </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>









    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- ---------------------------- INICIA MODAL ROLES DE USUARIO --------------------------- -->
    <div wire:ignore.self class="modal fade" id="ModalJardin" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Editor de datos del jardín
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- ----------------------------  cuerpo del modal --------------------------->
                <div class="modal-body">
                    <div class="row">
                        <!-- Nombre corto -->
                        <div class="col-12 col-sm-6 col-md-4" form-group>
                            <label class="form-label">Nombre corto</label>
                            <input wire:model.live="jar_name" type="text" class="@error('jar_name') is-invalid @enderror form-control" @if($HayJardin > 0) readonly @endif>
                            @error('jar_name')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Nombre largo -->
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label class="form-label">Nombre completo</label>
                            <input wire:model.live="jar_nombre" type="text" class="@error('jar_nombre') is-invalid @enderror form-control">
                            @error('jar_nombre')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Siglas -->
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label class="form-label">Siglas</label>
                            <input wire:model.live="jar_siglas" type="text" class="@error('jar_siglas') is-invalid @enderror form-control">
                            @error('jar_siglas')<error>{{ $message }}</error>@enderror
                        </div>

                        <!--  Tipo de jardín -->
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label class="form-label">Tipo de jardín</label>
                            <select wire:model.live="jar_tipo" class="@error('jar_tipo') is-invalid @enderror form-select">
                                <option value="Etnobotánico">Etnobotánico</option>
                                <option value="Etnobiológico">Etnobiológico</option>
                                <option value="Botánico">Botánico</option>
                                <option value="Comunitario">Comunitario</option>
                                <option value="Escolar">Escolar</option>
                                <option value="Parque">Parque</option>
                                <option value="Jardinera">Jardinera</option>
                            </select>
                        </div>

                        <!-- Dirección -->
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label class="form-label">Dirección</label>
                            <input wire:model.live="jar_direccion" type="text" class="@error('jar_direccion') is-invalid @enderror form-control">
                        </div>

                        <!--  Estado -->
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label class="form-label">Estado</label>
                            <select wire:model="jar_edo" class="@error('jar_edo') is-invalid @enderror form-select">
                                @foreach ($Entidades as $edo)
                                    <option value="{{ $edo->cedo_nombre }}"> {{ $edo->cedo_nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Teléfono -->
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label class="form-label">Teléfono</label>
                            <input wire:model.live="jar_tel" type="text" class="@error('jar_tel') is-invalid @enderror form-control">
                        </div>

                        <!-- Correo -->
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <label class="form-label">Correo</label>
                            <input wire:model.live="jar_mail" type="text" class="@error('jar_mail') is-invalid @enderror form-control">
                        </div>

                        <!-- Logo -->
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <!-- ver logo-->
                            <label class="form-label">Logo</label><br>
                            @if($jar_logo != '' )
                                <img src="/avatar/jardines/{{ $jar_logo }}" style="width:150px;">
                                <i class="bi bi-trash PaClick mx-2" wire:click="BorraLogo('{{  $HayJardin }}','{{ $jar_logo }}')" wire:confirm="Vas a eliminar el logo Y YA NO SE VA A PODER RECUPERAR. ¿Quieres continuar?"></i>
                            @else
                                <input wire:model.live="jar_logoNuevo" type="file" class="@error('jar_logoNuevo') is-invalid @enderror form-control">
                                @if($jar_logoNuevo != '')
                                    <img src="{{ $jar_logoNuevo->temporaryUrl() }}" style="width:150px;">
                                @endif

                            @endif
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <br>
                            @if($HayJardin=='0')
                                <button wire:click="EditaJardin('0')" type="button" class="btn btn-primary">
                                    Agregar Nuevo Jardín
                                </button>
                            @elseif($HayJardin > '0')
                                <button wire:click="EditaJardin('{{ $HayJardin }}')" type="button" class="btn btn-primary">
                                    Guardar cambios del jardín {{ $HayJardin }}
                                </button>
                            @endif
                        </div>
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
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('AbreModalJardin', () => {
                $('#ModalRolesDeUsuario').modal('show');
           });
           Livewire.on('CierraModalJardin', () => {
                $('#ModalRolesDeUsuario').modal('hide');
           });
        });

        /* ### Script para mostrar botón personalizado de input=file */
        document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
            document.getElementById('MiInputFile').click();
        });

    </script>

</div>


    <!--------------------------------------------------------------------------------------------->
    <!--------------------------------- FORMULARIO PARA EDITAR JARDÍN ----------------------------->
    <!--------------------------------------------------------------------------------------------->
    @if($HayJardin != '')

    @endif
</div>
