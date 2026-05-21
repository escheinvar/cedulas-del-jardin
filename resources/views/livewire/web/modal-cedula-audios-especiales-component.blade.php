<div>
    <div wire:ignore.self class="modal fade" id="ModalTraduceTitulo" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Traduce {{ $modal_tipo }}</h3>
                    <button wire:click="CerrarModalTraduceTitulo()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- ----------------------------  cuerpo del modal --------------------------->
                <div class="modal-body" style="">
                    @if($url)
                        @if($modal_tipo=='Titulo')
                            <div class="form-group">
                                <b>{{ $modal_tipo }} original:</b>
                                <input type="text" class="form-control" value="{{ $url->url_tituloorig }}" readonly>
                            </div>

                            <div class="form-group">
                                <b>{{ $modal_tipo }} en {{ $url->lenguas->len_autonimias }}</b>:<br>
                                <input  wire:model="NuevoTituloTraducido" type="text" class="@error('NuevoTituloTraducido') is-invalid @enderror form-control" >
                                @error('NuevoTituloTraducido')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif

                        @if($modal_archivo != '')
                            <div class="form-group">
                                <audio style="width:100%;padding:10px;" controls>
                                    <source src="{{ $modal_archivo }}" type="audio/ogg">
                                    <source src="{{ $modal_archivo }}" type="audio/mpeg">
                                    Tu navegador no soporta archivos de audio
                                </audio>
                                <i wire:click="EliminarAudioTitulo()" wire:confirm="Vas a eliminar el archivo de audio. ¿Seguro quieres continuar?" class="bi bi-trash agregar"></i>
                            </div>
                        @else
                            <!-- Subir Audio -->
                            <div class="col-12 my-1 form-group">
                                <label for="NuevoAudio" class="form-label">Audio<red></red></label>
                                <input wire:model="NuevoAudio" id="NuevoAudio" class="@error('NuevoAudio') is-invalid @enderror form-control" type="file">
                                <div class="form-text"></div>
                                @error('NuevoAudio')<error>{{ $message }}</error>@enderror
                            </div>
                            @if($NuevoAudio != '')
                                <div class="col-12">
                                    <button wire:click="SubirAudioTitulo()" wire:loading.attr="disabled" class="btn btn-primary">
                                        Subir audio
                                    </button>
                                    <span wire:loading style="display:none;"> <red>..subiendo...</red> </span>
                                </div>
                            @endif
                        @endif
                    @endif

                </div>
                <div class="modal-footer">
                    <button wire:click="CerrarModalTraduceTitulo()" class="btn btn-secondary">
                        Cerrar
                    </button>
                    @if($modal_tipo == 'Titulo')
                        <button wire:click="GuardaTituloTraducido()" wire:loading.attr="disabled" class="btn btn-primary">
                            Guardar
                        </button>
                        <span wire:loading style="display:none;"> <red>..guardando...</red> </span>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <script>
        /* ### Script para abrir y cerrar Modal */

        Livewire.on('AbreModalTraduceTitulo', () => {
            $('#ModalTraduceTitulo').modal('show');
        });
        Livewire.on('CierraModalTraduceTitulo', () => {
            $('#ModalTraduceTitulo').modal('hide');
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
