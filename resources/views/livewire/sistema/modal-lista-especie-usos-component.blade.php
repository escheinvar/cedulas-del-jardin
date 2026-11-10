<div>
<!-- ------------------------------------------------------------------------------------------ -->
<!-- --------------------------------------- MODAL DE ASIGNACIÓN DE USO EN LISTA ------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<div wire:ignore.self class="modal fade" id="Modal_UsoEnLista" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <!-- ----------------------------  cabeza del modal ------------------------- -->
            <div class="modal-header">
                <h3 class="modal-title">
                    Agregar Uso
                </h3>
                <button wire:click="CerrarModalDeAsignaUsoEnLista()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
            </div>
            <!-- ----------------------------  cuerpo del modal ------------------------- -->
            <div class="modal-body" wire:loading.attr="disabled">
                <div class="row">
                    <!-- Categoria de uso -->
                    <div class="col-12 my-1 form-group">
                        <label for="modUso_catego" class="form-label">Categoría de uso<red></red></label>
                        <select wire:model.live="modUso_catego" id="modUso_catego" class="@error('modUso_catego') is-invalid @enderror form-select">
                            <option value="">Indicar...</option>
                            @foreach($CatUso as $c)
                                <option value="{{ $c }}">{{ $c }}</option>
                            @endforeach
                        </select>
                        <div class="form-text"></div>
                        @error('modUso_catego')<error>{{ $message }}</error>@enderror
                    </div>

                    <!-- Uso -->
                    <div class="col-12 my-1 form-group">
                        <label for="modUso_uso" class="form-label">Uso<red></red></label>
                        <select wire:model.live="modUso_uso" id="modUso_uso" class="@error('modUso_uso') is-invalid @enderror form-select">
                            <option value="">Indicar...</option>
                            @foreach($usos as $u)
                                <option value="{{ $u->cuso_uso }}">{{ $u->cuso_uso }}</option>
                            @endforeach

                        </select>
                        <div class="form-text">{{ $usos->where('cuso_uso',$modUso_uso)->value('cuso_describe') }}</div>
                        @error('modUso_uso')<error>{{ $message }}</error>@enderror
                    </div>

                    <!-- Uso en caso de otro uso-->
                    @if($modUso_uso=='Otro/NA')
                        <div class="col-12  my-1 form-group">
                            <label for="modUso_uso2" class="form-label">Indica el otro uso<red></red></label>
                            <input wire:model="modUso_uso2" id="modUso_uso2" class="@error('modUso_uso2') is-invalid @enderror form-control" type="text">
                            <div class="form-text"></div>
                            @error('modUso_uso2')<error>{{ $message }}</error>@enderror
                        </div>
                    @endif
                </div>

                <div class="row">
                    <!-- Parte utiliada -->
                    <div class="col-12 my-1 form-group">
                        <label for="modUso_parte" class="form-label">Parte utilizada<red></red></label>
                        <select wire:model.live="modUso_parte" id="modUso_parte" class="agregar @error('modUso_parte') is-invalid @enderror form-select">
                            <option value="">Indicar...</option>
                            @foreach($partes as $p)
                                <option value="{{ $p->cat_valor }}">{{ $p->cat_valor }}</option>
                            @endforeach
                            <option value="Otra">Otra</option>
                        </select>
                        @if($modUso_parte != '' AND $modUso_parte != 'Otra')
                            <i wire:click='AgregarParte()'class="bi bi-plus-circle-fill agregar" style="color:#64383E"></i>
                        @endif
                        <div class="form-text"></div>
                        @error('modUso_parte')<error>{{ $message }}</error>@enderror
                    </div>

                    <!-- Uso en caso de otra parte -->
                    @if($modUso_parte=='Otra')
                        <div class="col-12  my-1 form-group">
                            <label for="modUso_parte2" class="form-label">Indica que parte<red></red></label>
                            <input wire:model="modUso_parte2" id="modUso_parte2" class="agregar @error('modUso_parte2') is-invalid @enderror form-control" type="text">
                            <i wire:click='AgregarParte()'class="bi bi-plus-circle-fill agregar" style="color:#64383E"></i>
                            <div class="form-text"></div>
                            @error('modUso_parte2')<error>{{ $message }}</error>@enderror
                        </div>
                    @endif
                </div>

                <div class="row">
                    <!-- enlista partes -->
                    <div class="col-12">
                        @foreach($modPartes as $p)
                            <div class="elemento">
                                {{ $p }}  <i wire:click='BorrarParte("{{ $p }}")' class="bi bi-trash agregar"></i>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="row">
                    <!-- Explicación -->
                    <div class="col-12 my-1 form-group">
                        <label for="modUso_explica" class="form-label">Explica el uso<red></red></label>
                        <textarea wire:model="modUso_explica" id="modUso_explica" class="@error('modUso_explica') is-invalid @enderror form-control"></textarea>
                        <div class="form-text"></div>
                        @error('modUso_explica')<error>{{ $message }}</error>@enderror
                    </div>
                </div>

                <div class="row">
                    @if($this->lstusoId>'0')
                        <div class="col-12 my-2">
                            <i wire:click='EliminarUso()'wire:confirm="¿Estás seguro de que quieres eliminar este uso?" class="bi bi-trash agregar PaClick"> Eliminar uso</i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- ---------------------------- pie del modal ----------------------------- -->
            <div class="modal-footer">
                <button wire:click="CerrarModalDeAsignaUsoEnLista()" class="btn btn-secondary">Cerrar</button>
                <button wire:click="GuardarUso()" wire:loading.attr="disabled" class="btn btn-primary">Guardar</button>
                <span wire:loading style="display:none;"><red>pensando...</red> </span>
            </div>
        </div>
    </div>
</div>
<!-- ----------------------------- TERMINA MODAL ASIGNACIÓN DE USO EN LISTA ------------------------- -->
<!-- -------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------- -->
    <script>
        /* ### Script para abrir y cerrar Modal */
        Livewire.on('AbreModalDeUsoEnLista', () => {
            $('#Modal_UsoEnLista').modal('show');
        });
        Livewire.on('CierraModalDeUsoEnLista', () => {
            $('#Modal_UsoEnLista').modal('hide');
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
