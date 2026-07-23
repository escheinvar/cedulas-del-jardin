<div>
    <!-- ------------------------------------------------------------------------------------------ -->
    <!-- --------------------------------------- MODAL DE CAMBIO DE TÍTULO ------------------------ -->
    <!-- ------------------------------------------------------------------------------------------ -->
    <!-- ------------------------------------------------------------------------------------------ -->
    <div wire:ignore.self class="modal fade" id="Modal_PideNvoRol" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <!-- ----------------------------  cabeza del modal ------------------------- -->
                <div class="modal-header">
                    <h3 class="modal-title">
                        Solicita rol en el sistema
                    </h3>
                    <button wire:click="CerrarModalParaPedirNvoRol()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- ----------------------------  cuerpo del modal ------------------------- -->
                <div class="modal-body" wire:loading.attr="disabled">
                    <div class="row p-4">
                        <!-- Jardín -->
                        <div class="col-12 my-1 form-group">
                            <label for="jardinRol" class="form-label">Jardín virtual<red>*</red></label>
                            <select wire:model="jardinRol" id="jardinRol" class="@error('jardinRol') is-invalid @enderror form-select">
                                <option value="">Indica el Jardín.</option>
                                @foreach($jardinesRol as $j)
                                    <option value="{{ $j->cjar_siglas }}">{{ $j->cjar_nombre }} ({{ $j->cjar_siglas }})</option>
                                @endforeach
                                <option value="Nuevo">Crear nuevo jardín virtual</option>
                            </select>
                            <div class="form-text"></div>
                            @error('jardinRol')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Rol -->
                        <div class="col-12 my-1 form-group">
                            <label for="rolRol" class="form-label">Rol solicitado<red>*</red></label>
                            <select wire:model.live="rolRol" id="rolRol" class="@error('rolRol') is-invalid @enderror form-select">
                                <option value="">Indica el rol que solicitas.</option>
                                @foreach($rolesRol as $r)
                                    <option value="{{ $r->crol_rol }}">{{ $r->crol_rol }}</option>
                                @endforeach
                                <option value="NoClaro">No lo tengo muy claro</option>
                            </select>
                            <div class="form-text">@if($rolRol!='' and $rolRol!='NoClaro') {{ $rolesRol->where('crol_rol',$rolRol)->value('crol_describe') }} @endif</div>
                            @error('rolRol')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- explica -->
                        <div class="col-12  my-1 form-group">
                            <label for="msjRol" class="form-label">Explica la razón de la solicitud<red>*</red></label>
                            <textarea wire:model="msjRol" id="msjRol" class="@error('msjRol') is-invalid @enderror form-control"></textarea>
                            <div class="form-text">Escribe un breve texto que será leído por el administrador al revisar tu cuenta.</div>
                            @error('msjRol')<error>{{ $message }}</error>@enderror
                        </div>
                        <div class="col-12  my-1 form-group">
                            Luego de enviar tu solicitud, serás notificado en tu buzón del sistema cuando el administrador
                            autorice el nuevo rol.
                        </div>
                    </div>
                </div>

                <!-- ---------------------------- pie del modal ----------------------------- -->
                <div class="modal-footer">
                    <button wire:click="CerrarModalParaPedirNvoRol" class="btn btn-secondary">Cerrar</button>
                    <button wire:click="SolicitarRol()" wire:loading.attr="disabled" class="btn btn-primary">Solicitar</button>
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
        Livewire.on('AbreModalPedirNvoRol', () => {
            $('#Modal_PideNvoRol').modal('show');
        });
        Livewire.on('CierraModalPedirNvoRol', () => {
            $('#Modal_PideNvoRol').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });


        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoPideNvoRol',()=>{
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
