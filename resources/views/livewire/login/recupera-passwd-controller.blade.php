<div>
    @section('title')Recuperar contraseña @endsection
    @section('cintillo')Recuperar contraseña @endsection
    @section('main') @endsection
    

    <div class="center" style="width:50%;">
        <div class="form-group">
            <label for="correo">Indica tu correo eletrónico:</label>
            <input name="correo" wire:model="correo" type="email" class="form-control" id="correo" placeholder="Ingresa tu correo">
            @error('correo')<error>{{$message}}</error>@enderror
        </div>
        
        <div class="form-group">
            
            @if($mensaje=='0')
                <br>
                <div class="alert alert-danger" role="alert">
                    Este correo no está registrado en esta plataforma
                </div>
            @elseif($mensaje=='1')
                <br>
                <div class="alert alert-success" role="alert">
                    Las instrucciones para continuar se enviaron al correo electrónico que indicaste.<br>
                    El correo tiene una vigencia máxima de 20 minutos.
                </div>
            @elseif($mensaje=='2')
                <br>
                <div class="alert alert-danger" role="alert">
                    Este correo se encuentra temporalmente suspendido, por favor comunícate con el administrador.
                </div>
            @endif
            <br>
            @if($ver=='1')
                <button wire:click="validador" wire:loading.attr="disabled" type="submit" class="btn btn-primary">Enviar</button>
            @endif
            <a href="/ingreso"><button type="submit" class="btn btn-secondary">Regresar</button></a>
        </div>

        
    </div>
    <br>
   
    
    
<script>

</script>


   
</div>
