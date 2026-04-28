<div>
    <!-- ------------------------------------------------------------------------------------------ -->
    <!-- --------------------------------------- MODAL DE CAMBIO DE TÍTULO ------------------------ -->
    <!-- ------------------------------------------------------------------------------------------ -->
    <!-- ------------------------------------------------------------------------------------------ -->
    <div wire:ignore.self class="modal fade" id="ModalDeMensaje" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- ----------------------------  cabeza del modal ------------------------- -->
                <div class="modal-header">
                    <h3 class="modal-title">
                        @if($msjNuevo=='0')Enviar nuevo mensaje @else Responder mensaje a {{ $msjToName }} @endif
                    </h3>
                    <button wire:click="CierraModalMensaje()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- ----------------------------  cuerpo del modal ------------------------- -->
                <div class="modal-body" wire:loading.attr="disabled">
                    @if($msjNuevo=='0')
                        <div class="row">
                            <!-- Selector de jardín destino -->
                            <div class="col-12 col-md-4 my-1 form-group">
                                <label for="jardinTo" class="form-label">Jardín de destinatario<red>*</red></label>
                                <select wire:model.live="jardinTo" id="jardinTo" class="@error('jardinTo') is-invalid @enderror form-select">
                                    <option value="">Indicar...</option>
                                    @foreach($jardines as $j)
                                        <option value="{{ $j->cjar_siglas }}">{{ $j->cjar_siglas }}</option>
                                    @endforeach
                                </select>
                                <div class="form-text"></div>
                                @error('jardinTo')<error>{{ $message }}</error>@enderror
                            </div>

                            <!-- Selector de rol destino -->
                            <div class="col-12 col-md-4 my-1 form-group">
                                <label for="rolTo" class="form-label">Rol de destinatario<red>*</red></label>
                                <select wire:model.live="rolTo" id="rolTo" class="@error('rolTo') is-invalid @enderror form-select">
                                    <option value="">Indicar...</option>
                                    @foreach($rolesEnJar as $r)
                                        <option value="{{ $r }}">{{ $r}}</option>
                                    @endforeach
                                </select>
                                <div class="form-text"></div>
                                @error('rolTo')<error>{{ $message }}</error>@enderror
                            </div>

                            <!-- destinatario -->
                            <div class="col-12 col-md-4 my-1 form-group">
                                <label for="msjTo" class="form-label">Usuario destinatario<red>*</red></label>
                                <select wire:model="msjTo" id="msjTo" class="@error('msjTo') is-invalid @enderror form-select">
                                    <option value="">Indicar...</option>
                                    @foreach($dest as $d)
                                        <option value="{{ $d->rol_usrid }}">{{ $d->usr->nombre }} {{ $d->usr->apellido }} ({{ $d->usr->usrname }})</option>
                                    @endforeach
                                </select>
                                <div class="form-text"></div>
                                @error('msjTo')<error>{{ $message }}</error>@enderror
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <!-- Reply to -->
                            <input type="hidden" wire:model="msjTo">
                            <div class="col-12 col-md-6 my-1 form-group">
                                <label for="msjToName" class="form-label">Respondiendo a<red>*</red></label>
                                <input wire:model="msjToName" id="msjToName" disabled class="@error('msjToName') is-invalid @enderror form-control" type="text">
                                <div class="form-text"></div>
                                @error('msjToName')<error>{{ $message }}</error>@enderror
                            </div>

                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12 form-group">
                            <label class="form-label">Asunto:</label>
                            <input wire:model="asunto" type="text" class="form-control">
                            @error('asunto')<error>{{ $message }}</error>@enderror
                        </div>
                        <div class="col-sm-12  form-group">
                            <label class="form-label">Mensaje:</label>
                            <textarea wire:model="mensaje" class="form-control"></textarea>
                            @error('mensaje')<error>{{ $message }}</error>@enderror
                        </div>
                    </div>
                </div>

                <!-- ---------------------------- pie del modal ----------------------------- -->
                <div class="modal-footer">
                    <button wire:click="CierraModalMensaje()" class="btn btn-secondary">Cerrar</button>
                    <button wire:click="EnviarMensaje()" wire:loading.attr="disabled" class="btn btn-primary">Guardar</button>
                    <span wire:loading style="display:none;" class="parpadeo"><red>enviando mensaje. Espera...</red> </span>
                </div>
            </div>
        </div>
    </div>
    <!-- ----------------------------- TERMINA MODAL ROLES DE USUARIO ------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <script>
        /* ### Script para abrir y cerrar Modal */
        Livewire.on('AbreModalDeMensaje', () => {
            $('#ModalDeMensaje').modal('show');
        });
        Livewire.on('CierraModalDeMensaje', () => {
            $('#ModalDeMensaje').modal('hide');
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
