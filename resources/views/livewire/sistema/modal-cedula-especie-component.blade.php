<div>
    <!-- ------------------------------------------------------------------------------------------ -->
    <!-- ----------------------------- MODAL DE NOMBRE CIENTÍFICO EN CÉDULA ----------------------- -->
    <!-- ------------------------------------------------------------------------------------------ -->
    <div wire:ignore.self class="modal fade" id="ModalAlias_Especies" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Especies para {{ $aliasp_urltxt }} en {{ $aliasp_jardin }}
                    </h3>
                    <button wire:click="CerrarModalDeBuscarEspecie('0')" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- ----------------------------  cuerpo del modal --------------------------->
                <div class="modal-body" >
                    <div class="row"  wire:loading.attr="disabled">
                        <!-- Reino -->
                        <div class="col-12 col-md-6 form-group">
                            <label for="aliasp_reino" class="form-label">Reino<red>*</red></label>
                            <select wire:model.live="aliasp_reino" wire:change="DeterminaReino()" id="aliasp_reino" class="@error('aliasp_reino') is-invalid @enderror form-select">
                                <option value="">Indicar...</option>
                                <option value="planta">Planta</option>
                                <option value="animal">Animal</option>
                                <option value="hongo">Hongo</option>
                                <option value="bacteria">Bacteria</option>
                                <option value="arquea">Arquea</option>
                                <option value="protista">Protista</option>
                            </select>
                            <div class="form-text"></div>
                            @error('aliasp_reino')<error>{{ $message }}</error>@enderror
                        </div>

                        @if($aliasp_reino!='')
                            <!-- Familia -->
                            <div class="col-12 col-md-6 form-group">
                                <label for="aliasp_familia" class="form-label">Familia<red></red></label>
                                <input wire:model.live="aliasp_familia" id="aliasp_familia" class="@error('aliasp_familia') is-invalid @enderror form-control" type="text">
                                <div class="form-text">Si lo sabes, escribe el nombre correctamente</div>
                                @error('aliasp_familia')<error>{{ $message }}</error>@enderror
                            </div>


                            @if($aliasp_ConCatalogo=='1')
                                <!-- --------------------- Sección con catálogo ------------------------- -->
                                <!-- Busca género -->
                                <div class="col-10 col-md-6 form-group">
                                    <label for="aliasp_buscaGen" class="form-label">Buscar género o especie:<red></red></label>
                                    <input wire:model="aliasp_buscaGen" id="aliasp_buscaGen" class="@error('aliasp_buscaGen') is-invalid @enderror form-control" type="text" style="">
                                    <div class="form-text">Escribe el género o la especie</div>
                                    @error('aliasp_buscaGen')<error>{{ $message }}</error>@enderror
                                </div>
                                <!-- botón de buscar género -->
                                <div class="col-2 col-md-6 form-group">
                                    <br><br>
                                    <button wire:click="BuscaCatalogoDeSp()" class="btn btn-secondary btn-sm" style="display:inline;">Buscar</button>
                                </div>

                                <!-- Selecciona especie -->
                                <div class="col-12 col-md-6 form-group">
                                    <label for="aliasp_sp" class="form-label">Nombre científico:<red>*</red></label>
                                    <select wire:model.live="aliasp_sp" id="aliasp_sp" class="@error('aliasp_sp') is-invalid @enderror form-select">
                                        @if($aliasp_especies->count() == '0')
                                            <option value="">Buscar primero ...</option>
                                        @else
                                            <option value="">Indicar sp...</option>
                                            @foreach($aliasp_especies as $sp)
                                                <option value="{{ $sp->ckew_taxonid }}">{{ $sp->ckew_scientfiicname }} [{{ $sp->ckew_family }}]</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <div class="form-text"></div>
                                    @error('aliasp_sp')<error>{{ $message }}</error>@enderror
                                </div>
                            @else
                                <!-- ------------------------- Sección sin catálogo --------------------------- -->
                                <!-- Genero -->
                                <div class="col-12 col-md-6 form-group">
                                    <label for="aliasp_gen" class="form-label">Género<red>*</red></label>
                                    <input wire:model.live="aliasp_gen" id="aliasp_gen" class="@error('aliasp_gen') is-invalid @enderror form-control" @if($aliasp_familia=='') disabled @endif type="text">
                                    <div class="form-text"></div>
                                    @error('aliasp_gen')<error>{{ $message }}</error>@enderror
                                </div>
                                <!-- Especie -->
                                <div class="col-12 col-md-6 form-group">
                                    <label for="aliasp_sp" class="form-label">Especie<red>*</red></label>
                                    <input wire:model.live="aliasp_sp" id="aliasp_sp" class="@error('aliasp_sp') is-invalid @enderror form-control" @if($aliasp_gen=='') disabled @endif type="text">
                                    <div class="form-text"></div>
                                    @error('aliasp_sp')<error>{{ $message }}</error>@enderror
                                </div>
                                <!-- Cat. Infrasp -->
                                <div class="col-12 col-md-6 form-group">
                                    <label for="aliasp_ssp" class="form-label">Categoría infraespecífica<red></red></label>
                                    <input wire:model.live="aliasp_ssp" id="aliasp_ssp" class="@error('aliasp_ssp') is-invalid @enderror form-control" @if($aliasp_sp=='') disabled @endif type="text">
                                    <div class="form-text"></div>
                                    @error('aliasp_ssp')<error>{{ $message }}</error>@enderror
                                </div>
                            @endif
                            <!-- Cultivar/variante/raza -->
                            <div class="col-12 col-md-6 form-group">
                                <label for="aliasp_var" class="form-label">Cultivar o raza:<red></red></label>
                                <input wire:model="aliasp_var" id="aliasp_var" class="@error('aliasp_var') is-invalid @enderror form-control" @if($aliasp_sp =='') disabled @endif type="text">
                                <div class="form-text"></div>
                                @error('aliasp_var')<error>{{ $message }}</error>@enderror
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="CerrarModalDeBuscarEspecie('0')" class="btn btn-secondary">
                        Cerrar
                    </button>

                    <button wire:click="GuardaSp()" wire:loading.attr="disabled" class="btn btn-primary">
                        Guardar
                    </button>
                    <span wire:loading style="display:none;"> <red>..pensando.</red> </span>
                </div>
            </div>
        </div>
    </div>
    <!-- ----------------------------- TERMINA MODAL ROLES DE USUARIO ------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->




    <script>
        /* ### Script para abrir y cerrar ModalAlias_Especies */
        Livewire.on('AbreModalDeBuscarEspecie', () => {
            $('#ModalAlias_Especies').modal('show');
        });
        Livewire.on('CierraModalDeBuscarEspecie', () => {
            $('#ModalAlias_Especies').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });


        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoAliasCedula',()=>{
            alert(event.detail.msj);
        })

        /* ### Script para mostrar botón personalizado de input=file */
        document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
            document.getElementById('MiInputFile').click();
        });
    </script>
</div>
