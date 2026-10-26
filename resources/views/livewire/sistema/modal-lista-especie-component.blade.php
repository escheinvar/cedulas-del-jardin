<div>
    <!-- ------------------------------------------------------------------------------------------ -->
    <!-- ----------------------------- MODAL DE LISTA DE ESPECIES ----------------------- -->
    <!-- ------------------------------------------------------------------------------------------ -->
    <div wire:ignore.self class="modal fade" id="Modal_ListaEspecies" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Listad de {{ $listasp_jardin }}
                    </h3>
                    <button wire:click="CerrarModalDeBuscarEspecie('0')" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- ----------------------------  cuerpo del modal --------------------------->
                <div class="modal-body" >
                    <div class="row"  wire:loading.attr="disabled">
                        <!-- Orden en lista -->
                        <div class="col-4 my-1 form-group">
                            <label for="listasp_orden" class="form-label">Orden:<red>*</red></label>
                            <input wire:model="listasp_orden" id="listasp_orden" class="@error('listasp_orden') is-invalid @enderror form-control" type="number">
                            <div class="form-text"></div>
                            @error('listasp_orden')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Nombre científico  -->
                        <div class="col-8  my-1 form-group">
                            @if($listasp_scname !='')
                                <label for="listasp_scname" class="form-label">Nombre cientìfico<red></red></label>
                                <input wire:model="listasp_scname" id="listasp_nombr" class="@error('listasp_scname') is-invalid @enderror form-control agregar" type="text">
                                <i class="bi bi-trash agregar" wire:click='BorrarSp()' wire:confirm='Estas por eliminar el nombre científico de este ejemplar y quedará si nombre. ¿Seguro que quieres continuar?'></i>
                                <div class="form-text"></div>
                                @error('listasp_scname')<error>{{ $message }}</error>@enderror
                            @endif
                        </div>
                    </div>

                    <!-- Imagen -->
                    <div class="row" wire:loading.attr="disabled">
                        <div class="col-12 form-group center">
                            <label for="" class="form-label">Imagen<red></red></label>
                            <center>
                            @if($listasp_img != '')
                                <img src="{{ $listasp_img }}" style="max-width:200px; max-height:400px;">
                                <i class="bi bi-trash agregar"  title="Eliminar imagen" wire:click="BorrarImagen('bd')" wire:confirm='Estás por eliminar una imágen de la base de datos. ¿Seguro quieres continuar?'></i>
                            @else
                                @if($listasp_nuevaImagen == '')
                                    <input wire:model="listasp_nuevaImagen" id="listasp_nuevaImagen" accept="image/*"  class="@error('listasp_nuevaImagen') is-invalid @enderror form-control" type="file">
                                    <div class="form-text"></div>
                                    @error('listasp_nuevaImagen')<error>{{ $message }}</error>@enderror
                                @endif
                            @endif

                            @if($listasp_nuevaImagen != '' )
                                <img src="{{ $listasp_nuevaImagen->temporaryUrl() }}" style="max-width:200px; max-height:400px;">
                                <i class="bi bi-trash agregar"  title="Eliminar imagen" wire:click="BorrarImagen('tmp')"></i>
                            @endif
                            </center>
                        </div>

                    </div>

                    <!-- Nombres Comunes -->
                    <div class="row"  wire:loading.attr="disabled">
                        <!-- Nombres comunes -->
                        <div class="col-12 my-1 form-group">
                            <table class="table table-striped" style="width:100%;">
                                <thead>
                                    <tr>
                                        <th style="width:60%;">Nombre(s)</th>
                                        <th style="width:10%;">Audio</th>
                                        <th style="width:25%;">Lengua</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nombres as $n)
                                        <tr>
                                            <!-- nombre -->
                                            <td style="width:60%;">{{ $n->lstn_name }}</td>
                                            <!-- audio -->
                                            <td style="width:10%;">
                                                @if($n->lstn_audio != '' )
                                                    <audio id="SpAudio{{ $n->lstn_id }}Titu" style="display:inline-block;">
                                                        <source src="{{ $n->lstn_audio }}" type="audio/ogg" /> El navegador no soporta el audio
                                                    </audio>
                                                    <i class="audioTxtPlay" id="IconPlay{{ $n->lstn_id }}Titu" onclick="playAudio('{{ $n->lstn_id }}Titu')"></i>
                                                    <i class="audioTxtStop" id="IconStop{{ $n->lstn_id }}Titu" onclick="pauseAudio('{{ $n->lstn_id }}Titu')"></i>
                                                @endif
                                            </td>
                                            <!-- lengua -->
                                            <td style="width:25%;">
                                                <span style="color: #CD7B34a;" title="{{ $n->lstn_lengua }}">
                                                    {{ $n->lstn_lencode }}
                                                </span>
                                            </td>

                                            <td>
                                                <i class="bi bi-trash agregar"  title="Eliminar nombre" wire:click="BorrarNombre({{ $n->lstn_id }})" wire:confirm='Vas a eliminar este nombre de la lista. ¿Quieres continuar?'></i>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <!-- Agregar nuevo nombre -->
                                        <td class="my-1 form-group">
                                            <input wire:model="listasp_nuevoNombre" id="listasp_nuevoNombre" class="@error('listasp_nuevoNombre') is-invalid @enderror form-control" type="text">
                                            @error('listasp_nuevoNombre')<error>{{ $message }}</error>@enderror
                                        </td>
                                        <!-- Agregar nuevo audio -->
                                        <td>
                                            @if($listasp_nuevoAudio)
                                                <audio id="SpAudioNuevo" style="display:inline-block;">
                                                    <source src="{{ $listasp_nuevoAudio->temporaryUrl() }}" type="audio/ogg" /> El navegador no soporta el audio
                                                </audio>
                                                <i class="audioTxtPlay" id="IconPlayNuevo" onclick="playAudio('Nuevo')"></i>
                                                <i class="audioTxtStop" id="IconStopNuevo" onclick="pauseAudio('Nuevo')"></i>
                                                <i class="bi bi-trash agregar"  title="Eliminar audio" wire:click="BorrarAudioNuevo()"></i>
                                            @else
                                                <input type="file" wire:model="listasp_nuevoAudio" id="subirAudioNuevo" accept="audio/*" style="display:none">
                                                <button class="btn btn-sm btn-secondary" style="cursor: pointer;" title="Subir audio" onclick="document.getElementById('subirAudioNuevo').click();">
                                                    <i class="bi bi-cloud-upload-fill"></i>
                                                </button>

                                            @endif
                                        </td>
                                        <!-- Agregar nueva lengua -->
                                        <td class="my-1 form-group">
                                            <select wire:model="listasp_nuevaLengua" id="listasp_nuevaLengua" class="@error('listasp_nuevaLengua') is-invalid @enderror form-select">
                                                <option value="">Indicar...</option>
                                                @foreach($lenguas as $lengua)
                                                    <option value="{{ $lengua->len_code }}">{{ $lengua->len_code }} {{ $lengua->len_lengua }} ({{ $lengua->len_autonimias }}) </option>
                                                @endforeach
                                            </select>
                                            @error('listasp_nuevaLengua')<error>{{ $message }}</error>@enderror
                                        </td>
                                        <!-- Botón Agregar -->
                                        <td class="my-1 form-group">
                                            <button class="btn btn-sm btn-primary"  title="Agregar nombre" wire:click="AgregrarNuevoNombre()"> + </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Explicación y URL -->
                    <div class="row"  wire:loading.attr="disabled">
                        <!-- Explicación o razón  -->
                        <div class="col-12  my-1 form-group">
                            <label for="listasp_razon" class="form-label">Explicación o descripción:<red></red></label>
                            <textarea wire:model="listasp_razon" id="listasp_razon" class="@error('listasp_razon') is-invalid @enderror form-control" type="text"></textarea>
                            <div class="form-text"></div>
                            @error('listasp_razon')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Explicación o razón  -->
                        <div class="col-12  my-1 form-group">
                            <label for="listasp_url" class="form-label">URL:<red></red></label>
                            <input wire:model="listasp_url" id="listasp_url" class="@error('listasp_url') is-invalid @enderror form-control agregar" type="text">
                            <i class="bi bi-trash agregar" wire:click='BorrarURL()'></i>
                            <div class="form-text"></div>
                            @error('listasp_url')<error>{{ $message }}</error>@enderror
                        </div>
                    </div>

                    <!-- ------------------------------------------------------------ -->
                    <!-- -----------Inicia secciòn  nombre cientìfico ------------------------ -->
                    <!-- Nombre científico -->
                    <div class="row"  wire:loading.attr="disabled">
                        @if($listasp_scname == '')
                            <div class="row"  wire:loading.attr="disabled">
                                <div class="col-12 form-group">
                                    <hr>
                                    <label for="" class="form-label">Nombre cientìfico:<red></red></label>
                                </div>
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
                                            <button wire:click="PreSeleccionaSp()" wire:loading.attr="disabled" class="btn btn-primary">
                                                Guardar especie
                                            </button>
                                            <span wire:loading style="display:none;"> <red>..pensando.</red> </span>
                                        </div>
                                    @endif
                            </div>
                        @endif
                    </div>
                    <!-- -----------Termina secciòn nombre cientìfico ------------------------ -->
                    <!-- ------------------------------------------------------------ -->
                </div>
                <div class="modal-footer">
                    <button wire:click="CerrarModalDeBuscarEspecie('0')" class="btn btn-secondary">
                        Cerrar
                    </button>

                    <button wire:click="GuardaRegistro('1')" wire:loading.attr="disabled" class="btn btn-primary">
                        Guardar
                    </button>
                    <span wire:loading style="display:none;"> <red>..pensando.</red> </span>
                </div>
            </div>
        </div>
    </div>
    <!-- ----------------------------- TERMINA MODAL DE LISTA DE ESPECIES ------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->



    <script>
        /* ### Script para abrir y cerrar Modal de ejemplar */
        Livewire.on('AbrirModalDeListaDeEspecies', () => {
            $('#Modal_ListaEspecies').modal('show');
        });
        Livewire.on('CierraModalDeListaDeEspecies', () => {
            $('#Modal_ListaEspecies').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });
        /* ### Script para abrir y cerrar Modal de nombres cientìficos */
        Livewire.on('AbrirModalDeNombreCientifico', () => {
            $('#Modal_ListaNombreCient').modal('show');
        });
        Livewire.on('CierraModalDeNombreCientifico', () => {
            $('#Modal_ListaNombreCient').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });


        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoAliasCedula',()=>{
            alert(event.detail.msj);
        })

        /* ### Script para mostrar botón personalizado de input=file */
        // document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
        //     document.getElementById('MiInputFile').click();
        // });
    </script>
</div>
