<div>
    <!-- -------------------------------------------------------------------------------------- -->
<!-- -------------------------------- MODAL DE ASIGNACIÓN DE UBICACIÓN ------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<div wire:ignore.self class="modal fade" id="Modal_AsignaUbica" tabindex="-1" role="dialog">
<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
    	<!-- ----------------------------  cabeza del modal ------------------------- -->
        <div class="modal-header">
            <h3 class="modal-title">
                @if($ubica_url)
                    Ubicación de cédula {{ $ubica_url->url_url }} de {{ $ubica_url->url_cjarsiglas }}
                    (@if($ubica_copia=='1') copia @else original @endif) Id: {{ $ubica_ubicaId }}
                @endif
            </h3>
            <button wire:click="CerrarModalDeUbicacion()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
        </div>
        <!-- ----------------------------  cuerpo del modal ------------------------- -->
        <div class="modal-body" wire:loading.attr="disabled">
            <div class="row">
                <!-- Estado -->
                <div class="col-12 col-md-6 my-1 form-group">
                    <label for="ubica_edo" class="form-label">Entidad federativa<red></red></label>
                    <select wire:model.live="ubica_edo" wire:change="CalculaTextoUbicacion()" id="ubica_edo" class="@error('ubica_edo') is-invalid @enderror form-select" @if($ubica_copia=='1') disabled @endif>
                        <option value="">Indicar...</option>
                        @foreach($edos as $e)
                            <option value="{{ $e->cedo_nombre }}">{{ $e->cedo_nombre }}</option>
                        @endforeach
                    </select>
                    <div class="form-text"></div>
                    @error('ubica_edo')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Municipio -->
                <div class="col-12 col-md-6 my-1 form-group">
                    <label for="ubica_mpio" class="form-label">Municipio<red></red></label>
                    <select wire:model.live="ubica_mpio" wire:change="CalculaTextoUbicacion()" id="ubica_mpio" class="@error('ubica_mpio') is-invalid @enderror form-select"  @if($ubica_copia=='1') disabled @endif>
                        @if($ubica_edo == '')
                            <option value="">Selecciona entidad</option>
                        @else
                            <option value="">Indicar...</option>
                            @foreach($mpios as $m)
                                <option value="{{ $m->cmun_mpioname }}"> {{ $m->cmun_mpioname }} </option>
                            @endforeach
                        @endif
                    </select>
                    <div class="form-text"></div>
                    @error('ubica_mpio')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Localidad -->
                <div class="col-12 col-md-6 my-1 form-group">
                    <label for="ubica_localidad" class="form-label">Localidad<red></red></label>
                    <input wire:model="ubica_localidad" wire:change="CalculaTextoUbicacion()" id="ubica_localidad" class="@error('ubica_localidad') is-invalid @enderror form-control" type="text"  @if($ubica_copia=='1' or $ubica_mpio=='') disabled @endif>
                    <div class="form-text"></div>
                    @error('ubica_localidad')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Paraje -->
                <div class="col-12 col-md-6 my-1 form-group">
                    <label for="ubica_paraje" class="form-label">Paraje<red></red></label>
                    <input wire:model="ubica_paraje" wire:change="CalculaTextoUbicacion()" id="ubica_paraje" class="@error('ubica_paraje') is-invalid @enderror form-control" type="text"  @if($ubica_copia=='1' or $ubica_mpio=='') disabled @endif>
                    <div class="form-text"></div>
                    @error('ubica_paraje')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Coords. X longitud -->
                <div class="col-12 col-md-6 my-1 form-group">
                    <label for="ubica_x" class="form-label">Coords X (longitud)<red></red></label>
                    <input wire:model="ubica_x" id="ubica_x" class="@error('ubica_x') is-invalid @enderror form-control" type="number"  @if($ubica_copia=='1') disabled @endif>
                    <div class="form-text"></div>
                    @error('ubica_x')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Coords. Y latitud -->
                <div class="col-12 col-md-6 my-1 form-group">
                    <label for="ubica_y" class="form-label">Coords. Y (latitud)<red></red></label>
                    <input wire:model="ubica_y" id="ubica_y" class="@error('ubica_y') is-invalid @enderror form-control" type="number"  @if($ubica_copia=='1') disabled @endif>
                    <div class="form-text"></div>
                    @error('ubica_y')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Ubicación -->
                <div class="col-12 my-1 form-group">
                    <label for="ubica_ubicacion" class="form-label">Ubicación:<red>*</red></label>
                    <textarea wire:model="ubica_ubicacion" id="ubica_ubicacion" class="@error('ubica_ubicacion') is-invalid @enderror form-control"  @if($ubica_copia=='1') disabled @endif></textarea>
                    <div class="form-text"></div>
                    @error('ubica_ubicacion')<error>{{ $message }}</error>@enderror
                </div>

                @if($ubica_copia=='1')
                    <!-- Ubicación transl -->
                    <div class="col-12 my-1 form-group">
                        <label for="ubica_ubicacion_tr" class="form-label">Ubicación:<red>*</red></label>
                        <textarea wire:model="ubica_ubicacion_tr" id="ubica_ubicacion_tr" class="@error('ubica_ubicacion_tr') is-invalid @enderror form-control"></textarea>
                        <div class="form-text"></div>
                        @error('ubica_ubicacion_tr')<error>{{ $message }}</error>@enderror
                    </div>
                @endif
                @if($ubica_ubicaId > '0')
                    <div>
                        <i class="bi bi-trash agregar" wire:click="EliminarUbicacion()" wire:confirm="Estas por eliminar todos los datos de esta ubicación en esta cédula y en todas sus traducciones. ¿Seguro quieres continuar?" style="float: right;"> Eliminar ubicación</i>
                    </div>
                @endif
            </div>

        </div>


        <!-- ---------------------------- pie del modal ----------------------------- -->
        <div class="modal-footer">
            <button wire:click="CerrarModalDeUbicacion" class="btn btn-secondary">Cerrar</button>
            <button wire:click="GuardarUbicacion()" wire:loading.attr="disabled" class="btn btn-primary">Guardar</button>
            <span wire:loading style="display:none;"><red>pensando...</red> </span>
        </div>
    </div>
</div>this->
</div>
<!-- ----------------------------- TERMINA MODAL ROLES DE USUARIO ------------------------- -->
<!-- -------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------- -->
    <script>
        /* ### Script para abrir y cerrar Modal */
        Livewire.on('AbreModalAsignaUbicacion', () => {
            $('#Modal_AsignaUbica').modal('show');
        });

        Livewire.on('CierraModalAsignaUbicacion', () => {
            $('#Modal_AsignaUbica').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });


        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoAsignaUbica',()=>{
            alert(event.detail.msj);
        })

        /* ### Script para mostrar botón personalizado de input=file */
        // document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
        //     document.getElementById('MiInputFile').click();
        // });
    </script>
</div>
