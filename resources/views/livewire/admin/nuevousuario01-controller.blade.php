<div>
    @section('title')Nuevo Usuario @endsection
    @section('cintillo')Crear una cuenta @endsection
    @section('main') @endsection
    <div class="container text-center">
        @if($correo->count()=='0')
            <div class="alert alert-warning" role="alert">
                La liga no es correcta o ya caducó.
            </div>

        @endif

        <div class="row">
            <div class="col-md-4 col-sm-12">
                <label class="form-label">Correo electrónico <red>*</red></label>
                <input type="email" wire:model="correo" class="form-control @error('correo') error @enderror" disabled>
                @error('correo') <error> {{$message}}</error> @enderror
            </div>

            <div class="col-md-4 col-sm-12">
                <label class="form-label">Nombre(s) <red>*</red></label>
                <input type="text" wire:model="nombre" class="form-control @error('nombre') error @enderror">
                @error('nombre') <error> {{$message}}</error> @enderror
            </div>

            <div class="col-md-4 col-sm-12">
                <label class="form-label">Apellido(s) <red>*</red></label>
                <input type="text" wire:model="apellido" class="form-control @error('apellido') error @enderror">
                @error('apellido') <error> {{$message}}</error> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-sm-12">
                <label class="form-label">Nombre de usuario <red>*</red></label>
                <input type="text" wire:model="usrname" class="form-control @error('usrname') error @enderror">
                @error('usrname') <error> {{$message}}</error> @enderror
            </div>

            <div class="col-md-4 col-sm-12">
                <label class="form-label">Fecha de nacimiento</label>
                <input type="date" wire:model.live="nace" max="{{date('Y-m-d')}}" class="form-control @error('nace') error @enderror">
                @error('nace') <error> {{$message}}</error> @enderror
            </div>

            <div class="col-md-4 col-sm-12" wire:ignore>
                <label class="form-label">¿Perteneces a una organización?</label>
                <select class="form-select Select2" wire:model.live="org" id="organizacion">
                    @foreach ($instituciones as $i)
                        <option value="{{$i->cins_id}}">{{$i->cins_institucion}}</option>
                    @endforeach
                    <option value="otro">Si, pero no está en la lista</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 col-sm-12">
                <label class="form-label">Contraseña <red>*</red></label>
                <input type="password" wire:model="contrasenia" class="form-control @error('contrasenia') error @enderror">
                @error('contrasenia') <error> {{$message}}</error> @enderror
            </div>

            <div class="col-md-4 col-sm-12">
                <label class="form-label">Repite contraseña <red>*</red></label>
                <input type="password" wire:model="contrasenia2" class="form-control @error('contrasenia2') error @enderror">
                @error('contrasenia2') <error> {{$message}}</error> @enderror
            </div>
        </div>

        <div class="row">
            @if($finalizado =='0')
                <div class="col-12 my-3">
                    <br>
                    <button wire:click="enviar" wire:loadding.attr="disabled" type="submit" class="btn btn-primary" @if($correo->count()=='0') disabled @endif>Crear cuenta</button>
                    <div wire:loading  style="display:none;">
                        <error>Espera. Estoy realizando el registro</error>
                    </div>
                </div>
            @elseif($finalizado=='1')
                <div class="alert alert-success my-4" role="alert">
                    La cuenta fue creada correctamente<br>
                    Puedes ingresar <a href="/ingreso"> aquí</a>
                </div>
            @endif
        </div>

        @script
            <script>
                $('.Select2').select2({
                    placeholder:'selecciona',">
                    tags: true,
                    width: '100%',
                });
                $('#organizacion').on('change',function(){
                    @this.set('org',$(this).val())
                })
            </script>
            @endscript
    </div>
</div>
