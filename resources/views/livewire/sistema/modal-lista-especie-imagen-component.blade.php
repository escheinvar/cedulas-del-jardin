<div>
    <!-- ------------------------------------------------------------------------------------------ -->
<!-- --------------------------------------- MODAL DE CAMBIO DE TÍTULO ------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<div wire:ignore.self class="modal fade" id="Modal_ListaImagen" tabindex="-1" role="dialog">
<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
    	<!-- ----------------------------  cabeza del modal ------------------------- -->
        <div class="modal-header">
            <h3 class="modal-title">
                @if($lstimg_imgid=='0') Nueva @else Editar @endif  imagen
            </h3>
            <button wire:click="CerrarModalDeListaImagen()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
        </div>
        <!-- ----------------------------  cuerpo del modal ------------------------- -->
        <div class="modal-body" wire:loading.attr="disabled">
            <div class="row">
                @if($lstimg_imgid=='0')
                    @if($lstimg_nvaImg == '')
                        <!-- Carga Nueva Imagen -->
                        <div class="col-12 my-1 form-group">
                            <label for="lstimg_nvaImg" class="form-label">Nueva imagen<red>*</red></label>
                            <input wire:model="lstimg_nvaImg" id="lstimg_nvaImg" class="@error('lstimg_nvaImg') is-invalid @enderror form-control" type="file">
                            <div class="form-text"></div>
                            @error('lstimg_nvaImg')<error>{{ $message }}</error>@enderror
                        </div>
                    @else
                        <div class="col-12 my-1 form-group center" >
                            <center>
                                <img src="{{ $lstimg_nvaImg->temporaryUrl() }}" style="max-width:300px; max-height: 300px;">
                            </center>
                        </div>
                    @endif
                @else
                    <img src="{{ $lstimg_img }}" style="max-width:300px; max-height: 300px;">
                @endif
            </div>

            @if($lstimg_nvaImg!='' OR $lstimg_img != '')
                <div class="row">
                    <!-- Orden -->
                    <div class="col-12 col-md-6 my-1 form-group">
                        <label for="lstimg_orden" class="form-label">Orden<red></red></label>
                        <input wire:model="lstimg_orden" id="lstimg_orden" class="@error('lstimg_orden') is-invalid @enderror form-control" type="number">
                        <div class="form-text"></div>
                        @error('lstimg_orden')<error>{{ $message }}</error>@enderror
                    </div>

                    <!-- Título -->
                    <div class="col-12 col-md-6 my-1 form-group">
                        <label for="lstimg_titulo" class="form-label">Título<red></red></label>
                        <input wire:model="lstimg_titulo" id="lstimg_titulo" class="@error('lstimg_titulo') is-invalid @enderror form-control" type="text">
                        <div class="form-text"></div>
                        @error('lstimg_titulo')<error>{{ $message }}</error>@enderror
                    </div>

                    <!-- Autor -->
                    <div class="col-12 col-md-6 my-1 form-group">
                        <label for="lstimg_autor" class="form-label">Autor<red></red></label>
                        <input wire:model="lstimg_autor" id="lstimg_autor" class="@error('lstimg_autor') is-invalid @enderror form-control" type="text">
                        <div class="form-text"></div>
                        @error('lstimg_autor')<error>{{ $message }}</error>@enderror
                    </div>

                    <!-- Explica -->
                    <div class="col-12 col-md-6 my-1 form-group">
                        <label for="lstimg_explica" class="form-label">Explicación<red></red></label>
                        <textarea wire:model="lstimg_explica" id="lstimg_explica" class="@error('lstimg_explica') is-invalid @enderror form-control"></textarea>
                        <div class="form-text"></div>
                        @error('lstimg_explica')<error>{{ $message }}</error>@enderror
                    </div>
                </div>
            @endif
        </div>

        <!-- ---------------------------- pie del modal ----------------------------- -->
        <div class="modal-footer">
            <button wire:click="CerrarModalDeListaImagen" class="btn btn-secondary">Cerrar</button>
            <button wire:click="GuardaModalImagen()" wire:loading.attr="disabled" class="btn btn-primary">Guardar</button>
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
        Livewire.on('AbreModalDeListaImagen', () => {
            $('#Modal_ListaImagen').modal('show');
        });
        Livewire.on('CierraModalDeListaImagen', () => {
            $('#Modal_ListaImagen').modal('hide');
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

        /* #### Recibe variable desde un componente externo y lo manda a livewire
           #### Usar: $this->dispatch('RecibeVariables',dato:'valor');*/
        Livewire.on('RecibeVariables',() => {
           @this.set('ModeloWire',event.detail.dato, live=true);
        });

        /* #### Reiniciar la página */
        Livewire.on('RecargarPagina',() => {
            location.reload();
            // window.location.href;
        });
    </script>

</div>
