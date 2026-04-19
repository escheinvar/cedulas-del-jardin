@section('title') Gestor de Jardines @endsection
@section('meta-description') Home del Sistema Gestor de Jardines @endsection
@section('cintillo-ubica') -> Configuración Usuario @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection
<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
<div>
    <a href="/home" class="nolink" style="color:">
        <i class="bi bi-arrow-left"></i> a Home
    </a>
    <h2>Configuración</h2>
    <div class="row">
        <div class="col-sm-12 col-md-10">
            <div class="row">
                <div class="col-sm-12 col-md-5 form-group">
                    <label class="form-label">Correo</label>
                    <input wire:model="correo" type="text" class="form-control" disabled>
                    @error('correo')<error>{{ $message }}</error>@enderror
                </div>

                <div class="col-sm-12 col-md-5 form-group">
                    <label class="form-label">Nombre de usuario <red>*</red> (único) </label>
                    <input wire:model="usrname" type="text" class="form-control">
                    @error('usrname')<error>{{ $message }}</error>@enderror
                </div>
                <div class="col-sm-12 col-md-5 form-group">
                    <label class="form-label">Fecha Nacimiento</label>
                    <input wire:model="nace" type="date" class="form-control" >
                    @error('correo')<error>{{ $message }}</error>@enderror
                </div>

                <div class="col-sm-12 col-md-5 form-group">
                    <label class="form-label">Nombre<red>*</red> </label>
                    <input wire:model="nombre" type="text" class="form-control">
                    @error('nombre')<error>{{ $message }}</error>@enderror
                </div>
                <div class="col-sm-12 col-md-5 form-group">
                    <label class="form-label">Apellido <red>*</red> </label>
                    <input wire:model="apellido" type="text" class="form-control">
                    @error('apellido')<error>{{ $message }}</error>@enderror
                </div>
                <div class="col-sm-12 col-md-5">
                    <div class="col-sm-12 form-check my-2">
                        <input class="form-check-input" value='0' wire:model.live="mensajes" type="checkbox" id="mensajes">
                        <label class="form-check-label" for="mensajes"> Reenviar mensajes del buzón a mi correo electrónico </label>
                        @if($mensajes=='0')
                            <small style="color:#919C1B;;"> Si esta casilla está desmarcada, los mensajes sólo llegarán a tu buzón del sistema y ya no se reenviarán a tu correo electrónico. </small>
                        @endif
                        <br>
                    </div>
                    <div wire:click="PedirTokenPasswd()" wire:loading.attr="hide" class="my-3 PaClick"  style="color:#64383E;">
                        <u>Cambiar mi contraseña</u>
                    </div>
                    <span wire:loading wire:target="PedirTokenPasswd()" style="display:none; color:#CD7B34"> Procesando solicitud ...</span>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-2 form-group">
            <center>
                <label class="form-label">Avatar</label><br>
                @if($this->avatar =='')
                    {{-- <img src="@if($NvoAvatar=='') /avatar/usr.png @else {{ $NvoAvatar->temporaryUrl() }} @endif" class="avatar"> --}}
                @else
                    <img src="@if($NvoAvatar=='') {{ $this->avatar }} @else {{ $NvoAvatar->temporaryUrl() }} @endif" class="avatar" alt="Avatar de usr">

                @endif
                <button type="button" class="btn btn-secondary btn-sm m-2" id="MiBotonPersonalizado">
                    <i class="bi bi-card-image"></i> Buscar archivo
                </button>
                <input wire:model.live="NvoAvatar" type="file" id="MiInputFile" style="display: none;">
            </center>
        </div>
    </div>
    <div class="row">
        <div class="col-12 my-4" style="text-align: center;">
            <button wire:click="GuardarCambios()" wire:loading.attr="disabled" class="btn btn-primary">
                Guardar cambios
            </button>
            <span wire:loading wire:target="GuardarCambios()" style="display:none; color:#CD7B34"> Procesando solicitud ...</span>
        </div>
    </div>



    <!--  Roles  -->
    <div class="row">
        <h3>Roles:</h3>
        <div class="col-12 form-group">
            @if($rolesUsr->count()>'0')
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th>Rol</th>
                            <th>Campus</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($rolesUsr as $r)
                            <tr>
                                <td> {{ $r->rol_crolrol }} </td>
                                <td> {{ $r->rol_cjarsiglas }} </td>
                                <td> <small>{{ $r->rol->crol_describe }}</small></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                -- aún no se te ha asignado ningún rol en el sistema --
            @endif
        </div>
    </div>
    <div class="row">
        <p>Para cualquier asunto relacionado con los perfiles, dirígete a tu buzón y envía un mensaje al administrador (admin) del sistema</p>
    </div>

    <!-- botones de acción -->
    <div class="row">
        <div class="col-12 my-2">
            <button wire:click="AbrirModalParaPedirNvoRol()" class="btn btn-secondary bi bi-person-gear"> Solicitar rol</button>
        </div>
    </div>

    <livewire:sistema.modal-home-solicita-rol-component />

    <script>
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

