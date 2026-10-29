<div>
<!-- ------------------------------------------------------------------------------------------ -->
<!-- ----------------------------- MODAL DE NOMBRE CIENTÍFICO EN LISTA ------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<div wire:ignore.self class="modal fade" id="Modal_NombreCientEnLista" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    	<!-- ----------------------------  cabeza del modal ------------------------- -->
        <div class="modal-header">
            <h3 class="modal-title">
                Indicar el nombre científico
            </h3>
            <button wire:click="CerrarModal()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
        </div>
        <!-- ----------------------------  cuerpo del modal ------------------------- -->
        <div class="modal-body" wire:loading.attr="disabled">
            <div class="row"  wire:loading.attr="disabled">
                <div class="row"  wire:loading.attr="disabled">

                    <!-- Reino -->
                    <div class="col-12 col-md-6 form-group">
                        <label for="listasp_reino" class="form-label">Reino<red>*</red></label>
                        <select wire:model.live="listasp_reino" wire:change="DeterminaReino()" id="listasp_reino" class="@error('listasp_reino') is-invalid @enderror form-select">
                            <option value="">Indicar...</option>
                            <option value="planta">Planta</option>
                            <option value="animal">Animal</option>
                            <option value="hongo">Hongo</option>
                            <option value="bacteria">Bacteria</option>
                            <option value="arquea">Arquea</option>
                            <option value="protista">Protista</option>
                        </select>
                        <div class="form-text"></div>
                        @error('listasp_reino')<error>{{ $message }}</error>@enderror
                    </div>
                        @if($listasp_reino!='')
                            <!-- Familia -->
                            <div class="col-12 col-md-6 form-group">
                                <label for="listasp_familia" class="form-label">Familia<red></red></label>
                                <input wire:model.live="listasp_familia" id="listasp_familia" class="@error('listasp_familia') is-invalid @enderror form-control" type="text" >
                                <div class="form-text"></div>
                                @error('listasp_familia')<error>{{ $message }}</error>@enderror
                            </div>

                            @if($listasp_ConCatalogo=='1')
                                <!-- --------------------- Sección con catálogo ------------------------- -->
                                <!-- Busca género -->
                                <div class="col-10 col-md-6 form-group">
                                    <label for="listasp_buscaGen" class="form-label">Buscar género o especie:<red></red></label>
                                    <input wire:model="listasp_buscaGen" id="listasp_buscaGen" class="@error('listasp_buscaGen') is-invalid @enderror form-control" type="text" style="">
                                    <div class="form-text">Escribe el género o la especie</div>
                                    @error('listasp_buscaGen')<error>{{ $message }}</error>@enderror
                                </div>
                                <!-- botón de buscar género -->
                                <div class="col-2 col-md-6 form-group">
                                    <br><br>
                                    <button wire:click="BuscaCatalogoDeSp()" class="btn btn-secondary btn-sm" style="display:inline;">Buscar</button>
                                </div>

                                <!-- Selecciona especie de catálogo-->
                                <div class="col-12 col-md-6 form-group">
                                    <label for="listasp_scnamePre" class="form-label">Nombre científico:<red>*</red></label>
                                    <select wire:model.live="listasp_scnamePre" id="listasp_scnamePre" class="@error('listasp_scnamePre') is-invalid @enderror form-select">
                                        @if($listasp_especies->count() == '0')
                                            <option value="">Buscar primero ...</option>
                                        @else
                                            <option value="">Indicar sp...</option>
                                            @foreach($listasp_especies as $sp)
                                                <option value="{{ $sp->ckew_taxonid }}">{{ $sp->ckew_scientfiicname }} [{{ $sp->ckew_family }}]</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="form-text"></div>
                                    @error('listasp_scnamePre')<error>{{ $message }}</error>@enderror
                                </div>
                            @else
                                <!-- ------------------------- Sección sin catálogo --------------------------- -->
                                <!-- Genero -->
                                <div class="col-12 col-md-6 form-group">
                                    <label for="listasp_gen" class="form-label">Género<red>*</red></label>
                                    <input wire:model.live="listasp_gen" id="listasp_gen" class="@error('listasp_gen') is-invalid @enderror form-control" @if($listasp_familia=='') disabled @endif type="text">
                                    <div class="form-text"></div>
                                    @error('listasp_gen')<error>{{ $message }}</error>@enderror
                                </div>
                                <!-- Especie -->
                                <div class="col-12 col-md-6 form-group">
                                    <label for="listasp_sp" class="form-label">Especie<red>*</red></label>
                                    <input wire:model.live="listasp_sp" id="listasp_sp" class="@error('listasp_sp') is-invalid @enderror form-control" @if($listasp_gen=='') disabled @endif type="text">
                                    <div class="form-text"></div>
                                    @error('listasp_sp')<error>{{ $message }}</error>@enderror
                                </div>
                                <!-- Cat. Infrasp -->
                                <div class="col-12 col-md-6 form-group">
                                    <label for="listasp_ssp" class="form-label">Categoría infraespecífica<red></red></label>
                                    <input wire:model.live="listasp_ssp" id="listasp_ssp" class="@error('listasp_ssp') is-invalid @enderror form-control" @if($listasp_sp=='') disabled @endif type="text">
                                    <div class="form-text"></div>
                                    @error('listasp_ssp')<error>{{ $message }}</error>@enderror
                                </div>
                            @endif

                            <!-- Cultivar/variante/raza -->
                            <div class="col-12 col-md-6 form-group">
                                <label for="listasp_var" class="form-label">Cultivar o raza:<red></red></label>
                                <input wire:model="listasp_var" id="listasp_var" class="@error('listasp_var') is-invalid @enderror form-control"  type="text">
                                <div class="form-text"></div>
                                @error('listasp_var')<error>{{ $message }}</error>@enderror
                            </div>

                            <!-- boton guardar especie -->
                            <div class="col-12 col-md-6 form-group">
                                <button wire:click="GuardaSp()" wire:loading.attr="disabled" class="btn btn-primary">
                                    Guardar especie
                                </button>
                                <span wire:loading style="display:none;"> <red>..pensando.</red> </span>
                            </div>
                        @endif
                </div>
            </div>
        </div>

        <!-- ---------------------------- pie del modal ----------------------------- -->
        <div class="modal-footer">
            <button wire:click="CerrarModal" class="btn btn-secondary">Cerrar</button>
            <button wire:click="GuardaModal()" wire:loading.attr="disabled" class="btn btn-primary">Guardar</button>
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
