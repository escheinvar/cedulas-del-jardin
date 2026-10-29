<div>
<!-- ------------------------------------------------------------------------------------------ -->
<!-- ----------------------------- MODAL DE NOMBRE CIENTÍFICO EN LISTA ------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<div wire:ignore.self class="modal fade" id="Modal_NombreCientEnLista" tabindex="-1" role="dialog">
<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
    	<!-- ----------------------------  cabeza del modal ------------------------- -->
        <div class="modal-header">
            <h3 class="modal-title">
                Indicar el nombre científico
            </h3>
            <button wire:click="CerrarModalNombreCient()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
        </div>
        <!-- ----------------------------  cuerpo del modal ------------------------- -->
        <div class="modal-body" wire:loading.attr="disabled">
            <div class="row"  wire:loading.attr="disabled">
                <div class="row"  wire:loading.attr="disabled">

                    <!-- Reino -->
                    <div class="col-12 col-md-6 form-group">
                        <label for="listasc_reino" class="form-label">Reino<red>*</red></label>
                        <select wire:model.live="listasc_reino" wire:change="DeterminaReino()" id="listasc_reino" class="@error('listasc_reino') is-invalid @enderror form-select">
                            <option value="">Indicar...</option>
                            <option value="planta">Planta</option>
                            <option value="animal">Animal</option>
                            <option value="hongo">Hongo</option>
                            <option value="bacteria">Bacteria</option>
                            <option value="arquea">Arquea</option>
                            <option value="protista">Protista</option>
                        </select>
                        <div class="form-text"></div>
                        @error('listasc_reino')<error>{{ $message }}</error>@enderror
                    </div>
                        @if($listasc_reino!='')
                            <!-- Familia -->
                            <div class="col-12 col-md-6 form-group">
                                <label for="listasc_familia" class="form-label">Familia<red></red></label>
                                <input wire:model.live="listasc_familia" id="listasc_familia" class="@error('listasc_familia') is-invalid @enderror form-control" type="text" >
                                <div class="form-text"></div>
                                @error('listasc_familia')<error>{{ $message }}</error>@enderror
                            </div>

                            @if($listasc_ConCatalogo=='1')
                                <!-- --------------------- Sección con catálogo ------------------------- -->
                                <!-- Busca género -->
                                <div class="col-10 col-md-6 form-group">
                                    <label for="listasc_buscaGen" class="form-label">Buscar género o especie:<red></red></label>
                                    <input wire:model="listasc_buscaGen" id="listasc_buscaGen" class="@error('listasc_buscaGen') is-invalid @enderror form-control" type="text" style="">
                                    <div class="form-text">Escribe el género o la especie</div>
                                    @error('listasc_buscaGen')<error>{{ $message }}</error>@enderror
                                </div>
                                <!-- botón de buscar género -->
                                <div class="col-2 col-md-6 form-group">
                                    <br><br>
                                    <button wire:click="BuscaCatalogoDeSp()" class="btn btn-secondary btn-sm" style="display:inline;">Buscar</button>
                                </div>

                                <!-- Selecciona especie de catálogo-->
                                <div class="col-12 col-md-6 form-group">
                                    <label for="listasc_scnamePre" class="form-label">Nombre científico:<red>*</red></label>
                                    <select wire:model.live="listasc_scnamePre" id="listasc_scnamePre" class="@error('listasc_scnamePre') is-invalid @enderror form-select">
                                        @if($listasc_especies->count() == '0')
                                            <option value="">Buscar primero ...</option>
                                        @else
                                            <option value="">Indicar sp...</option>
                                            @foreach($listasc_especies as $sp)
                                                <option value="{{ $sp->ckew_taxonid }}">{{ $sp->ckew_scientfiicname }} [{{ $sp->ckew_family }}]</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="form-text"></div>
                                    @error('listasc_scnamePre')<error>{{ $message }}</error>@enderror
                                </div>
                            @else
                                <!-- ------------------------- Sección sin catálogo --------------------------- -->
                                <!-- Genero -->
                                <div class="col-12 col-md-6 form-group">
                                    <label for="listasc_gen" class="form-label">Género<red>*</red></label>
                                    <input wire:model.live="listasc_gen" id="listasc_gen" class="@error('listasc_gen') is-invalid @enderror form-control" @if($listasc_familia=='') disabled @endif type="text">
                                    <div class="form-text"></div>
                                    @error('listasc_gen')<error>{{ $message }}</error>@enderror
                                </div>
                                <!-- Especie -->
                                <div class="col-12 col-md-6 form-group">
                                    <label for="listasc_sp" class="form-label">Especie<red>*</red></label>
                                    <input wire:model.live="listasc_sp" id="listasc_sp" class="@error('listasc_sp') is-invalid @enderror form-control" @if($listasc_gen=='') disabled @endif type="text">
                                    <div class="form-text"></div>
                                    @error('listasc_sp')<error>{{ $message }}</error>@enderror
                                </div>
                                <!-- Cat. Infrasp -->
                                <div class="col-12 col-md-6 form-group">
                                    <label for="listasc_ssp" class="form-label">Categoría infraespecífica<red></red></label>
                                    <input wire:model.live="listasc_ssp" id="listasc_ssp" class="@error('listasc_ssp') is-invalid @enderror form-control" @if($listasc_sp=='') disabled @endif type="text">
                                    <div class="form-text"></div>
                                    @error('listasc_ssp')<error>{{ $message }}</error>@enderror
                                </div>
                            @endif

                            <!-- Cultivar/variante/raza -->
                            <div class="col-12 col-md-6 form-group">
                                <label for="listasc_var" class="form-label">Cultivar o raza:<red></red></label>
                                <input wire:model="listasc_var" id="listasc_var" class="@error('listasc_var') is-invalid @enderror form-control"  type="text">
                                <div class="form-text"></div>
                                @error('listasc_var')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif
                </div>
            </div>
        </div>

        <!-- ---------------------------- pie del modal ----------------------------- -->
        <div class="modal-footer">
            <button wire:click="CerrarModalNombreCient()" class="btn btn-secondary">Cerrar</button>
            <button wire:click="GuardaSp()" wire:loading.attr="disabled" class="btn btn-primary">Guardar</button>
            <span wire:loading style="display:none;"><red>pensando...</red> </span>
        </div>
    </div>
</div>
</div>
<!-- ----------------------- TERMINA MODAL DE NOMBRE CIENTÍFICO EN LISTA ------------------ -->
<!-- -------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------- -->
    <script>
        /* ### Script para abrir y cerrar Modal */
        Livewire.on('AbreModalDeNombreCientEnlista', () => {
            $('#Modal_NombreCientEnLista').modal('show');
        });
        Livewire.on('CierraModalDeNombreCientEnLista', () => {
            $('#Modal_NombreCientEnLista').modal('hide');
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
