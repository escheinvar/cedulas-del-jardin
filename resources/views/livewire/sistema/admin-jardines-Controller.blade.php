
@section('title') Admin. Jardines @endsection
@section('meta-description') Administrador de Jardines del SiCedJar @endsection
@section('cintillo-ubica') -> Catálogo de Jardines @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection

<div>
    <h2>Administración de Jardines</h2>
    <div style="font-size: 80%;color:grey;">
        Este catálogo es administrado por el rol <b>Admin@todos</b> en jardin: {{ implode(',',$editjar) }}
        (@if($edit=='0') <error style="font-size: 90%;"> No autorizado</error> @else <span style="font-size:90%;color:green;"> Autorizado </span>@endif)
    </div>
    <!--------------------------------------------------------------------------------------------->
    <!--------------------------------- TABLA DE JARDÍNES ----------------------------------------->
    <!--------------------------------------------------------------------------------------------->
    <div class="row">
        <div class="col-12 my-3">
            <div>
                <button wire:click="AbreModalJardin('0')" type="button" class="btn btn-secondary" style="float: right;">
                    Nuevo Jardín
                </button>
            </div>
        </div>
        <div class="col-12">
            <table class="table table-striped" style="width:100%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th></th>
                        <th><center>Siglas</center></th>
                        <th>Nombre corto</th>
                        <th>Nombre largo</th>
                        <th>Tipo</th>
                        <th>Contacto</th>

                        <th> &nbsp; </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jardines as $jar)
                        <tr wire:click="AbreModalJardin({{ $jar->cjar_id }})" class="PaClick">
                            <td> {{ $jar->cjar_id }} </td>
                            <td><img src="{{ $jar->cjar_logo }}" style="max-width:60px; max-width:60px;"></center></td>
                            <td> <center>{{ $jar->cjar_siglas }}</td>
                            <td> {{ $jar->cjar_name }} </td>
                            <td> {{ $jar->cjar_nombre }} </td>
                            <td> {{ $jar->cjar_tipo }}</td>
                            <td>
                                @if($jar->cjar_direccion != '') {{ $jar->cjar_direccion }}@endif
                                @if($jar->cjar_tel != '') | {{ $jar->cjar_tel }}@endif
                                @if($jar->cjar_mail != '') | {{ $jar->cjar_mail }}@endif
                                @if($jar->cjar_edo != '') | {{ $jar->cjar_edo }}@endif
                            </td>
                            <td> <i class="bi bi-pencil-square PaClick" wire:click="AbreModalJardin({{ $jar->cjar_id }})"></i> </td>
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
                        @if($IdJardin=='0')
                            Ingresando un nuevo jardín
                        @else
                            Editando datos del jardín
                        @endif
                    </h3>
                    <button wire:click="CierraModalJardin()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- ----------------------------  cuerpo del modal --------------------------->
                <div class="modal-body">
                    <div class="row">
                        <!-- Siglas -->
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label class="form-label">Siglas<red>*</red></label>
                            <input wire:model.live="jar_siglas" type="text" class="@error('jar_siglas') is-invalid @enderror form-control" @if($IdJardin > '0') disabled @endif>
                            <div class="form-text">Texto corto, sin espacios y único. No se podrá cambiar.</div>
                            @error('jar_siglas')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Nombre corto -->
                        <div class="col-12 col-sm-6 col-md-4 form-group" >
                            <label class="form-label">Nombre corto<red>*</red></label>
                            <input wire:model.live="jar_name" type="text" class="@error('jar_name') is-invalid @enderror form-control">
                            <div class="form-text">Texto que utilizará el nombre de manera interna.</div>
                            @error('jar_name')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Nombre largo -->
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label class="form-label">Nombre completo<red>*</red></label>
                            <input wire:model.live="jar_nombre" type="text" class="@error('jar_nombre') is-invalid @enderror form-control">
                            <div class="form-text">Nombre real y completo del Jardín</div>
                            @error('jar_nombre')<error>{{ $message }}</error>@enderror
                        </div>

                        <!--  Tipo de jardín -->
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label class="form-label">Tipo de jardín</label>
                            <select wire:model.live="jar_tipo" class="@error('jar_tipo') is-invalid @enderror form-select">
                                <div class="form-text"></div>
                                <option value="Etnobotánico">Etnobotánico</option>
                                <option value="Etnobiológico">Etnobiológico</option>
                                <option value="Botánico">Botánico</option>
                                <option value="Comunitario">Comunitario</option>
                                <option value="Escolar">Escolar</option>
                                <option value="Parque">Parque</option>
                                <option value="Jardinera">Jardinera</option>
                            </select>
                            <div class="form-text"></div>
                            @error('')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Dirección -->
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label class="form-label">Dirección</label>
                            <input wire:model.live="jar_direccion" type="text" class="@error('jar_direccion') is-invalid @enderror form-control">
                            <div class="form-text">Dirección principal de contacto.</div>
                            @error('')<error>{{ $message }}</error>@enderror
                        </div>

                        <!--  Estado -->
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label class="form-label">Estado<red>*</red></label>
                            <select wire:model="jar_edo" class="@error('jar_edo') is-invalid @enderror form-select">
                                @foreach ($Entidades as $edo)
                                    <option value="{{ $edo->cedo_nombre }}"> {{ $edo->cedo_nombre }}</option>
                                @endforeach
                            </select>
                            <div class="form-text"></div>
                            @error('')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Teléfono -->
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label class="form-label">Teléfono</label>
                            <input wire:model.live="jar_tel" type="text" class="@error('jar_tel') is-invalid @enderror form-control">
                            <div class="form-text">Teléfono de contacto</div>
                            @error('')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Correo -->
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <label class="form-label">Correo</label>
                            <input wire:model.live="jar_mail" type="text" class="@error('jar_mail') is-invalid @enderror form-control">
                            <div class="form-text">Correo electrónico de contacto.</div>
                            @error('')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Logo -->
                        <div class="col-xs-12 col-sm-6 col-md-4 form-group">
                            <!-- ver logo-->
                            <label class="form-label">Logo</label><br>
                            @if($jar_logo != '' )
                                <img src="{{ $jar_logo }}" style="width:130px;">
                                <i class="bi bi-trash mx-2 agregar" wire:click="BorraLogo('{{ $jar_logo }}')" wire:confirm="Vas a eliminar el logo Y YA NO SE VA A PODER RECUPERAR. ¿Quieres continuar?"></i>
                            @else
                                <input wire:model.live="jar_logoNuevo" type="file" class="@error('jar_logoNuevo') is-invalid @enderror form-control">
                                @if($jar_logoNuevo != '')
                                    <img src="{{ $jar_logoNuevo->temporaryUrl() }}" style="width:150px;">
                                @endif
                                <div wire:loading wire:target="jar_logoNuevo" style="display:none;"> <error>Espera... cargando imágen</error></div>
                            @endif
                            <div class="form-text"></div>
                            @error('')<error>{{ $message }}</error>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="CierraModalJardin()" class="btn btn-secondary">
                        Cerrar
                    </button>

                    <button wire:click="GuardaModal()" class="btn btn-primary">
                        <span wire:loading.attr="disabled"> Guardar </span>
                        <span wire:loading style="display:none;"> <red> ..guardando...</red> </span>
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
                $('#ModalJardin').modal('show');
           });
           Livewire.on('CierraModalJardin', () => {
                $('#ModalJardin').modal('hide');
           });
        });

        /* ### Script para mostrar botón personalizado de input=file */
        document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
            document.getElementById('MiInputFile').click();
        });

    </script>

</div>
