<div>
    <!-- ------------------------------------------------------------------------------------------ -->
<!-- --------------------------------------- MODAL DE CAMBIO DE TÍTULO ------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<div wire:ignore.self class="modal fade" id="Modal_AgregarNombreLengua" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    	<!-- ----------------------------  cabeza del modal ------------------------- -->
        <div class="modal-header">
            <h3 class="modal-title">
            </h3>
            <button wire:click="CerrarModal()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
        </div>
        <!-- ----------------------------  cuerpo del modal ------------------------- -->
        <div class="modal-body" wire:loading.attr="disabled">
        </div>

        <!-- ---------------------------- pie del modal ----------------------------- -->
        <div class="modal-footer">
            <button wire:click="CerrarModal" class="btn btn-secondary">Cerrar</button>
            <button wire:click="GuardaModal()" wire:loading.attr="disabled" class="btn btn-primary">Guardar</button>
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
        Livewire.on('AbreModal', () => {
            $('#Modal_AgregarNombreLengua').modal('show');
        });
        Livewire.on('CierraModal', () => {
            $('#Modal_AgregarNombreLengua').modal('hide');
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
