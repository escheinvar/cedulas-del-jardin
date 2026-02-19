<div>
    @section('title')Recuperar contraseña @endsection
    @section('cintillo')Recuperar contraseña @endsection
    @section('main') @endsection
    <br>

    @if($caso=='0')
        <div class="alert alert-warning" role="alert">
            Este vínculo no existe o ya venció.<br>
            <a href="/recuperaAcceso"><button type="button" class="btn btn-secondary">Solicitar otro</button></a>
        </div>
    @else
        <div class="center" style="width:50%;">
            <div class="form-group">
                <label>Ingresa tu nueva contraseña:</label>
                <input wire:model="contrasenia" type="password" class="@error('contrasenia') error @enderror form-control" placeholder="Ingresa la nueva contraseña">
                @error('contrasenia')<error>{{$message}}</error> @enderror
            </div>

            <div class="form-group">
                <label>Repite tu nueva contraseña:</label>
                <input wire:model="contraseniaConfirmacion"type="password" class="@error('contraseniaConfirmacion') error @enderror form-control" placeholder="Repetir contraseña">
                @error('contraseniaConfirmacion')<error>{{$message}}</error> @enderror
            </div>
            
            <div class="form-group">
                @if($mensaje=='')
                    <br>
                    <button wire:click="Cambiar()" wire:loading.attr="disabled" type="submit" class="btn btn-primary">Cambiar</button>
                    <br>
                @elseif($mensaje=='1')

                    <div class="alert alert-success" role="alert">
                        La contraseña fue cambiada exitosamente
                    </div>
                @elseif($mensaje=='2')
                    <div class="alert alert-danger" role="alert">
                        El vínculo venció antes de poder cambiar la contraseña. <br>
                        Intenta nuevamente. <a href="/recuperaAcceso"><button type="button" class="btn btn-secondary">Solicitar uno nuevo</button></a>
                    </div>
                @else
                @endif
            </div>
            
        </div>
    @endif
    
</div>
