<div>
    <!-- ------------------------------------------------------------------------------------------ -->
<!-- --------------------------------------- MODAL DE CAMBIO DE TÍTULO ------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<div wire:ignore.self class="modal fade" id="Modal_VerFuenteExterna" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    	<!-- ----------------------------  cabeza del modal ------------------------- -->
        <div class="modal-header">
            <h3 class="modal-title">
                @if($this->modext_id=='0') Nueva @endif
                Fuente externa
                para {{ $this->modext_urltxt }} de {{ $this->modext_jardin }}
            </h3>
            <button wire:click="CerrarModalDeFuenteExterna()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
        </div>
        <!-- ----------------------------  cuerpo del modal ------------------------- -->
        <div class="modal-body" wire:loading.attr="disabled">
            <div class="row">
                <!-- Nombre de la red Red-->
                <div class="col-12 col-md-4 my-1 form-group">
                    <label for="modext_red" class="form-label">Nombre de la red<red>*</red></label>
                    <select wire:model="modext_red" id="modext_red" class="@error('modext_red') is-invalid @enderror form-select">
                        <option value="">Indicar...</option>
                        @foreach($redes as $r)
                            <option value="{{ $r->red_id }}">{{ $r->red_name }}</option>
                        @endforeach
                    </select>
                    <div class="form-text"></div>
                    @error('modext_red')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Tìtulo -->
                <div class="col-12 col-md-4 my-1 form-group">
                    <label for="modext_titulo" class="form-label">Título del video o recurso<red>*</red></label>
                    <input wire:model="modext_titulo" id="modext_titulo" class="@error('modext_titulo') is-invalid @enderror form-control" type="text">
                    <div class="form-text">Texto que se mostrará como título</div>
                    @error('modext_titulo')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Nombre del autor -->
                <div class="col-12 col-md-4 my-1 form-group">
                    <label for="modext_autor" class="form-label">Nombre del autor del video<red>*</red></label>
                    <input wire:model="modext_autor" id="modext_autor" class="@error('modext_autor') is-invalid @enderror form-control" type="text">
                    <div class="form-text">Nombre de usuario en la red social</div>
                    @error('modext_autor')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Url del autor -->
                <div class="col-12 col-md-4 my-1 form-group">
                    <label for="modext_urlautor" class="form-label">Página del autor<red>*</red></label>
                    <input wire:model="modext_urlautor" id="modext_urlautor" class="@error('modext_urlautor') is-invalid @enderror form-control" type="text">
                    <div class="form-text">Dirección del canal del autor</div>
                    @error('modext_urlautor')<error>{{ $message }}</error>@enderror
                </div>



                <!-- Explica -->
                <div class="col-12 col-md-4 my-1 form-group">
                    <label for="modext_explica" class="form-label">Breve explicación<red>*</red></label>
                    <input wire:model="modext_explica" id="modext_explica" class="@error('modext_explica') is-invalid @enderror form-control" type="text">
                    <div class="form-text">Breve razón por la que su muestra el recurso en la cédula</div>
                    @error('modext_explica')<error>{{ $message }}</error>@enderror
                </div>

                <!-- url -->
                <div class="col-12 col-md-4 my-1 form-group">
                    <label for="modext_url" class="form-label">Url del video<red>*</red></label>
                    <input wire:model="modext_url" id="modext_url" class="@error('modext_url') is-invalid @enderror form-control" type="text">
                    <div class="form-text">Dirección a la que será redirigido el usuario al picar</div>
                    @error('modext_url')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Fecha -->
                <div class="col-12 col-md-4 my-1 form-group">
                    <label for="modext_fecha" class="form-label">Fecha del video<red></red></label>
                    <input wire:model="modext_fecha" id="modext_fecha" class="@error('modext_fecha') is-invalid @enderror form-control" type="date">
                    <div class="form-text">Fecha en la que se realizó</div>
                    @error('modext_fecha')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Carátula -->
                <div class="col-12 col-md-4 my-1 form-group">
                    <label for="modext_caratNva" class="form-label">@if($modext_carat!='')Cambiar @else Imágen @endif de carátula<red></red></label>
                    <input wire:model="modext_caratNva" id="modext_caratNva" class="@error('modext_caratNva') is-invalid @enderror form-control" type="file">
                    <div class="form-text">Imágen de 200px de ancho por 100px de alto</div>
                    @error('modext_caratNva')<error>{{ $message }}</error>@enderror
                </div>

                <!-- imagen de ejemplo -->
                <div class="col-12 col-md-4 my-1 form-group">
                    <span wire:loading wire:target="modext_caratNva" style="display:none;"><red>cargando...</red> </span>
                    @if($modext_caratNva=='' and $modext_carat != '')
                        <img src="{{ $modext_carat }}" style="width:230px; height:130px; border-radius:7px;">
                    @elseif($modext_caratNva!= '')
                        <img src="{{ $modext_caratNva->temporaryUrl() }}" style="width:230px; height:130px; border-radius:7px;">
                    @endif
                </div>
            </div>
        </div>

        <!-- ---------------------------- pie del modal ----------------------------- -->
        <div class="modal-footer">
            <button wire:click="CerrarModalDeFuenteExterna" class="btn btn-secondary">Cerrar</button>
            <button wire:click="GuardaFuenteExterna()" wire:loading.attr="disabled" class="btn btn-primary">Guardar</button>
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
        Livewire.on('AbreModalFuenteExterna', () => {
            $('#Modal_VerFuenteExterna').modal('show');
        });
        Livewire.on('CierraModalFuenteExterna', () => {
            $('#Modal_VerFuenteExterna').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });


        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoFuenteExterna',()=>{
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
        Livewire.on('RecargarPaginaFuenteExterna',() => {
            location.reload();
            // window.location.href;
        });
    </script>
</div>
