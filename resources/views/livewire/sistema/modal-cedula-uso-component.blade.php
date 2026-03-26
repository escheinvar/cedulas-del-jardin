<div>
    <!-- ------------------------------------------------------------------------------------------ -->
    <!-- ------------------------------ MODAL DE REGISTRO DE USO EN CÉDULA ------------------------ -->
    <!-- ------------------------------------------------------------------------------------------ -->
    <!-- ------------------------------------------------------------------------------------------ -->
    <div wire:ignore.self class="modal fade" id="Modal_UsoEnCedula" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <!-- ----------------------------  cabeza del modal ------------------------- -->
            <div class="modal-header">
                <h3 class="modal-title">
                    @if($uso_usoid=='0') Nuevo uso
                    @else Edita uso
                    @endif

                    de {{ $uso_urltxt }} en {{ $uso_jardin }}
                    @if($uso_sp)
                        de {{ $uso_sp->sp_scname}}
                    @endif
                </h3>
                <button wire:click="CerrarModalUsoEnCedula('0')" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
            </div>
            <!-- ----------------------------  cuerpo del modal ------------------------- -->
            <div class="modal-body" wire:loading.attr="disabled">
                <div class="row">
                    <!--Cagegoría  -->
                    <div class="col-6 my-1 form-group">
                        <label for="uso_catego" class="form-label">Categoría de uso:<red>*</red></label>
                        <select wire:model="uso_catego" wire:change="SeleccionaUso()" id="uso_catego" class="@error('uso_catego') is-invalid @enderror form-select">
                            <option value="">Indicar categoría...</option>
                            @foreach($categorias as $c)
                                <option value="{{ $c->cuso_catego }}">{{ $c->cuso_catego }}</option>
                            @endforeach
                        </select>
                        <div class="form-text"></div>
                        @error('uso_catego')<error>{{ $message }}</error>@enderror
                    </div>

                    <!-- Uso -->
                    <div class="col-6 my-1 form-group">
                        <label for="uso_uso" class="form-label">Uso<red>*</red></label>
                        <select wire:model.live="uso_uso" id="uso_uso" class="@error('uso_uso') is-invalid @enderror form-select @if($uso_catego=='') disabled @endif">
                            @if($uso_catego=='')
                                <option value="">Indicar categoria primero</option>
                            @else
                                <option value="">Selecciona uso</option>
                                @foreach($usos as $u)
                                    <option value="{{ $u->cuso_id }}">{{ $u->cuso_id }}) {{ $u->cuso_uso }}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class="form-text"></div>
                        @error('uso_uso')<error>{{ $message }}</error>@enderror
                    </div>
                </div>
                <div class="row">
                    <!-- explica categoría seleccionada -->
                    <div class="col-12">
                        <div class="form-text">
                            @if($uso_catego != '' AND $uso_uso == '')
                                <b>Usos</b>: @foreach($usos as $u) {{ $u->cuso_uso }} &nbsp; | &nbsp; @endforeach

                            @else
                                {{ $uso_uso }}:  {{ $usos->where('cuso_id',$uso_uso)->value('cuso_describe')}}
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Partes usadas -->
                <div class="row">
                    <div class="col-12 my-1 form-group">

                        <!-- Select Partes de planta-->
                        @if($uso_sp AND $uso_sp->sp_reino=='planta')
                            <label for="uso_parte" class="form-label">Parte(s) de la planta usadas<red></red></label>
                            <select wire:model="uso_parte" id="uso_parte" class="@error('uso_parte') is-invalid @enderror form-select agregar">
                                @if($uso_uso=='')
                                    <option value="">Indicar uso primero</option>
                                @else
                                    <option v   alue="">Indicar...</option>
                                    @foreach($partes as $p)
                                        <option value="{{ $p->cat_valor }}">{{ $p->cat_valor }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @if($uso_uso != '')<i wire:click="AgregarParte()" class="bi bi-plus-square-fill agregar"></i>@endif
                                <div class="form-text"></div>
                            @error('uso_parte')<error>{{ $message }}</error>@enderror

                        <!-- Select Partes no planta -->
                        @elseif($uso_sp AND $uso_sp->sp_reino !='planta')
                            <!-- Select Partes de no planta-->
                            <label for="uso_parte" class="form-label">Parte(s) usadas<red></red></label>
                            <input wire:model="uso_parte" id="uso_parte" class="@error('uso_parte') is-invalid @enderror form-control agregar" @if($uso_uso=='') disabled @endif type="text">
                            @if($uso_uso != '')<i wire:click="AgregarParte()" class="bi bi-plus-square-fill agregar"></i>@endif
                            <div class="form-text"></div>
                            @error('uso_parte')<error>{{ $message }}</error>@enderror
                        @endif
                    </div>

                    <!-- Muestra cada parte -->
                    <div class="col-12 my-1 form-group">
                        {{-- con:{{ count($uso_usosPartes) }} --}}
                        @foreach($uso_usosPartes as $u)
                            <div class="elemento">
                                <i class="bi bi-trash agregar" wire:click="BorrarParte('{{ $u }}')"></i>
                                {{ $u }}
                            </div>
                        @endforeach

                    </div>
                </div>

                <!-- Explica el uso -->
                <div class="row">
                    <div class="col-12 my-1 form-group">
                        <label for="uso_explica" class="form-label">Explica el uso<red></red></label>
                        <textarea wire:model="uso_explica" class="form-control" @if($uso_uso=='') disabled @endif></textarea>
                    </div>
                </div>

                <div class="col-12 form-group">
                    <i class="bi bi-trash agregar" wire:click="EliminarUso()" wire:confirm="Estas a punto de eliminar todo el registro del uso. ¿Estás seguro de querer continuar?" style="float: right;"> Eliminar uso</i>
                </div>
            </div>

            <!-- ---------------------------- pie del modal ----------------------------- -->
            <div class="modal-footer">
                <button wire:click="CerrarModalUsoEnCedula('0')" class="btn btn-secondary">Cerrar</button>
                <button wire:click="GuardarUso()" wire:loading.attr="disabled" class="btn btn-primary">Guardar</button>
                <span wire:loading style="display:none;"><red>pensando...</red> </span>
            </div>
        </div>
    </div>
    </div>
    <!-- ----------------------------- TERMINA MODAL DE USO EN CEDULA ------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->




    <script>
        /* ### Script para abrir y cerrar Modal */
        Livewire.on('AbreModalUsoEnCedula', () => {
            $('#Modal_UsoEnCedula').modal('show');
        });
        Livewire.on('CierraModalUsoEnCedula', () => {
            $('#Modal_UsoEnCedula').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });


        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoUsoCedula',()=>{
            alert(event.detail.msj);
        })

        /* ### Script para mostrar botón personalizado de input=file */
        // document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
        //     document.getElementById('MiInputFile').click();
        // });
    </script>
</div>
