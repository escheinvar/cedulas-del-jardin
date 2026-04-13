
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
                    <div class="row">
                        <!-- Nombre -->
                        <div class="col-12 col-md-4 my-1 form-group">
                            <label for="msg_nombre" class="form-label">Nombre y apellidos<red></red></label>
                            <input wire:model="msg_nombre" id="msg_nombre" class="@error('msg_nombre') is-invalid @enderror form-control" type="text">
                            <div class="form-text">Este dato no será público</div>
                            @error('msg_nombre')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- usuario -->
                        <div class="col-12 col-md-4 my-1 form-group">
                            <label for="msg_alias" class="form-label">Nombre de usuario o pseudónimo<red>*</red></label>
                            <input wire:model="msg_alias" id="msg_alias" class="@error('msg_alias') is-invalid @enderror form-control" type="text">
                            <div class="form-text">Nombre que aparecerá en la página</div>
                            @error('msg_alias')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Estado -->
                        <div class="col-12 col-md-4 my-1 form-group">
                            <label for="msg_estado" class="form-label">Estado de la república<red>*</red></label>
                            <select wire:model.live="msg_estado" id="msg_estado" class="@error('msg_estado') is-invalid @enderror form-select">
                                <option value="">Indicar...</option>
                                @foreach($estados as $e)
                                    <option value="{{ $e->cedo_nombre }}">{{ $e->cedo_nombre }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Estado en el que vives</div>
                            @error('msg_estado')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Municipio -->
                        <div class="col-12 col-md-4 my-1 form-group">
                            <label for="msg_mpio" class="form-label">Municipio<red>*</red></label>
                            <select wire:model="msg_mpio" id="msg_mpio" class="@error('msg_mpio') is-invalid @enderror form-select">
                                <option value="">Indicar...</option>
                                @foreach($mpios as $m)
                                    <option value="{{ $m->cmun_mpioname }}">{{ $m->cmun_mpioname }}</option>
                                @endforeach
                            </select>
                            <div class="form-text">Municipio en el que vives</div>
                            @error('msg_mpio')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Comunidad -->
                        <div class="col-12 col-md-4 my-1 form-group">
                            <label for="msg_comunidad" class="form-label">Comunidad<red>*</red></label>
                            <input wire:model="msg_comunidad" id="msg_comunidad" class="@error('msg_comunidad') is-invalid @enderror form-control" type="text">
                            <div class="form-text">Comunidad, colonia o pueblo en el que vives</div>
                            @error('msg_comunidad')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Lengua -->
                        <div class="col-12 col-md-4 my-1 form-group">
                            <label for="msg_lengua" class="form-label">Lengua(s)<red>*</red></label>
                            <input wire:model="msg_lengua" id="msg_lengua" class="@error('msg_lengua') is-invalid @enderror form-control" type="text">
                            <div class="form-text">Lengua(s) que se hablan en tu comunidad</div>
                            @error('msg_lengua')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Edad -->
                        <div class="col-12 col-md-4 my-1 form-group">
                            <label for="msg_edad" class="form-label">Edad<red></red></label>
                            <input wire:model="msg_edad" id="msg_edad" class="@error('msg_edad') is-invalid @enderror form-control" type="text">
                            <div class="form-text">Este dato no será público</div>
                            @error('msg_edad')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- correo -->
                        <div class="col-12 col-md-4 my-1 form-group">
                            <label for="msg_correo" class="form-label">Correo electŕonico:<red></red></label>
                            <input wire:model="msg_correo" id="msg_correo" class="@error('msg_correo') is-invalid @enderror form-control" type="text">
                            <div class="form-text">Este dato no será público</div>
                            @error('msg_correo')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- tel -->
                        <div class="col-12 col-md-4 my-1 form-group">
                            <label for="msg_tel" class="form-label">Teléfono<red></red></label>
                            <input wire:model="msg_tel" id="msg_tel" class="@error('msg_tel') is-invalid @enderror form-control" type="text">
                            <div class="form-text">Este dato no será público</div>
                            @error('msg_tel')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Mensaje -->
                        <div class="col-12 my-1 form-group">
                            <label for="msg_txt" class="form-label">Sobre este tema, quiero aportar lo siguiente:<red>*</red></label>
                            <textarea wire:model="msg_txt" id="msg_txt" class="@error('msg_txt') is-invalid @enderror form-control" rows='4'  placeholder="En mi comunidad, esta planta se conoce como... y se utiliza para ..."></textarea>
                            <div class="form-text">Tu aporte debe ser revisado por los editores antes de ser publicado.</div>
                            @error('msg_txt')<error>{{ $message }}</error>@enderror
                        </div>


                    </div>
                </div>

                <!-- ---------------------------- pie del modal ----------------------------- -->
                <div class="modal-footer">
                    <button wire:click="CancelaMensajeUsr()" class="btn btn-secondary">Cerrar</button>
                    <button wire:click="GuardarNuevoMensaje()" wire:loading.attr="disabled" class="btn btn-primary">Guardar</button>
                    <span wire:loading style="display:none;"><red>pensando...</red> </span>
                </div>
            </div>
        </div>
    </div>
    <!-- ----------------------------- TERMINA MODAL ROLES DE USUARIO ------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->




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
        Livewire.on('AvisoExitoMensajeNvo',()=>{
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

<div>
