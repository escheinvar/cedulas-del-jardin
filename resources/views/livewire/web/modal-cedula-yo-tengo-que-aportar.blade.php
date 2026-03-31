<div>

<!-- ------------------------------------------------------------------------------------------ -->
<!-- --------------------------------------- MODAL DE CAMBIO DE TÍTULO ------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<div wire:ignore.self class="modal fade" id="Modal_YoTengoQueAportar" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    	<!-- ----------------------------  cabeza del modal ------------------------- -->
        <div class="modal-header">
            <h3 class="modal-title">
                YoTengoQueAportar
            </h3>
            <button wire:click="CancelaMensajeUsr()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
        </div>
        <!-- ----------------------------  cuerpo del modal ------------------------- -->
        <div class="modal-body" wire:loading.attr="disabled">
            <div>
                <a name="AporteUsrs"> </a>
                <div class="row">
                    <div class="col-12 col-md-4 form-group">
                        <label class="form-label">Usuario <red>*</red>:</label>
                        <input type="text" value="{{ Auth::user()->usrname }}" class="form-control" readonly>
                    </div>
                    <div class="col-12 col-md-4 form-group">
                        <label class="form-label">Soy originario de (opcional): </label>
                        <input wire:model="MsgOrigen" type="text" class="form-control">
                    </div>
                    <div class="col-12 col-md-4 form-group">
                        <label class="form-label">Edad (opcional):</label>
                        <input wire:model="MsgEdad"  type="text" class="form-control">
                    </div>
                    <div class="col-12 form-group">
                        <label class="form-label">Sobre este tema, quiero aportar lo siguiente<red>*</red>:</label>
                        <textarea wire:model="MsgMensaje" class="form-control" placeholder="En mi comunidad, esta planta se utiliza para ..."></textarea>
                        @error('MsgMensaje')<error>{{ $message }}</error>@enderror
                        <span>Tu aporte debe ser revisado por los editores antes de ser publicado.</span>
                    </div>
                    {{-- <div class="col-12 form-group my-4">
                        <buton type="button" wire:click="GuardarNuevoMensaje()" class="btn btn-primary">Enviar mi aporte</buton>
                        <buton type="button" wire:click="CancelaMensajeUsr()" onclick="VerNoVer('ver','Aportes')" class="btn btn-secondary">Cancelar</buton>
                    </div> --}}
                </div>
            </div>

        </div>

        <!-- ---------------------------- pie del modal ----------------------------- -->
        <div class="modal-footer">
            <button wire:click="CancelaMensajeUsr" class="btn btn-secondary">Cerrar</button>
            <button wire:click="GuardarNuevoMensaje()" wire:loading.attr="disabled" class="btn btn-primary">Guardar</button>
            <span wire:loading style="display:none;"><red>pensando...</red> </span>
        </div>
    </div>
</div>
</div>
<!-- ----------------------------- TERMINA MODAL ROLES DE USUARIO ------------------------- -->
<!-- -------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------- -->
    <script>
        /* ### Script para abrir y cerrar Modal */
        Livewire.on('AbreModalYoTengoQueAportar', () => {
            $('#Modal_YoTengoQueAportar').modal('show');
        });
        Livewire.on('CierraModalYoTengoQueAportar', () => {
            $('#Modal_YoTengoQueAportar').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });


        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExito',()=>{
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
