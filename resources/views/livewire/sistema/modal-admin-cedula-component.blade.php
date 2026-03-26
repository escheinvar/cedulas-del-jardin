<div>
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- ---------------------------- INICIA MODAL DE EDICIÓN DE CÉDULA ----------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <div wire:ignore.self class="modal fade" id="ModalDeEdicionDeCedulas" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        @if($cedulaId=='0')
                            Creando nueva cédula
                        @else
                            Editando cédula Id {{ $cedulaId }}
                        @endif
                        de {{ $jardinSel }}
                    </h3>
                    <button wire:click="CierraModalCedula()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- cuerpo del MODAL:EDICIÓN CÉDULA -->
                <div class="modal-body">
                    <!-- Original/Copia y copia de -->
                    <div class="row">
                        <!-- Original o traducción -->
                        <div class="col-4 form-group">
                            <label for="origtrad" class="form-label">Original/Traducción<red>*</red></label>
                            <select wire:model.live="origtrad"  wire:change="DeterminaVariablesDeCopia()" id="origtrad" class="@error('origtrad') is-invalid @enderror form-select" @if($cedulaId > '0') disabled @endif>
                                <option value="">Indica ...</option>
                                <option value="original">Cédula original</option>
                                <option value="traducción">Traducción de cédula</option>
                            </select>
                            <div class="form-text"></div>
                            @error('origtrad') <error> {{ $message }}</error>@enderror
                        </div>

                        <!-- Copia de -->
                        <div class="col-4 form-group">
                            <label for="copiade" class="form-label">Copia de<red>@if($origtrad=='traducción')*@endif</red></label>
                            <select wire:model.live="copiade" wire:change="DeterminaVariablesDeCopia()" id="copiade" class="@error('copiade') is-invalid @enderror form-select" @if($origtrad=='original' or $cedulaId != '0') disabled @endif>
                                <option value="">Indica ...</option>
                                @foreach($CedsOriginales as $o)
                                    <option value="{{ $o->url_id }}">
                                        {{ $o->url_cjarsiglas }}:
                                        {{ $o->url_url }}
                                        [{{ $o->url_lencode }}]
                                        @if($o->url_edo < '4') -- EN EDICIÓN -- @endif
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text"></div>
                            @error('copiade') <error> {{ $message }}</error>@enderror
                        </div>

                        <!-- Tipo de cédula -->
                        <div class="col-4 form-group">
                            <label for="tipoCedula" class="form-label">Tipo de ćedula<red>*</red></label>
                            <select wire:model.live="tipoCedula" wire:change="DeterminaVariablesDeCopia()" id="tipoCedula" class="@error('tipoCedula') is-invalid @enderror form-select" @if($origtrad=='traducción' ) disabled @endif>
                                <option value="">Indica ...</option>
                                @foreach($TiposDeCedula as $t)
                                    <option value="{{ $t->cced_tipo }}"> {{ $t->cced_tipo }}</option>
                                @endforeach
                            </select>
                            <div class="form-text"></div>
                            @error('tipoCedula') <error> {{ $message }}</error>@enderror
                        </div>
                    </div>

                    <!-- Datos generales de la cédula -->
                    <div class="row">
                        <!-- Lengua -->
                        <div class="col-4 form-group">
                            <label for="lengua" class="form-label">Lengua<red>*</red></label>
                            <select wire:model.live="lengua" wire:change="DeterminaVariablesDeCopia()" id="lengua" class="@error('lengua') is-invalid @enderror form-select">
                                <option value="">Indica....</option>
                                @foreach($lenguas as $l)
                                    <option value="{{ $l->len_code }}">{{ $l->len_code }}: {{ $l->len_lengua }} {{ $l->len_variante }}</option>
                                @endforeach
                            </select>
                            <div class="form-text"></div>
                            @error('lengua') <error> {{ $message }}</error>@enderror
                        </div>

                        <!-- MODAL: titulo --->
                        <div class="col-4 form-group">
                            <label for="titulo" class="form-label">
                                Titulo<red>*</red>
                            </label>
                            @if($origtrad=='traducción') <span onclick="VerNoVer('titulo','Original')" class="PaClick">Ver original</span> @endif
                            <input wire:model="titulo" id="titulo" class="@error('titulo') is-invalid @enderror form-control" type="text" >
                            <div class="form-text"></div>
                            @error('titulo')<error>{{ $message }}</error>@enderror

                            <div id="sale_tituloOriginal" style="display:none;font-size:90%;">
                                {{ $tituloOrig }}
                            </div>
                        </div>

                        <!-- MODAL: url web jardin -->
                        <div class="col-4 form-group">
                            <label for="url" class="form-label">URL <red>*</red></label>
                            @if($origtrad == 'original' and $cedulaId == '0')
                                &nbsp; <i class="bi bi-info-square-fill agregar" wire:click="ProponUrl()"> Proponer </i>
                            @endif
                            <input wire:model="url"  id="url" class="@error('url') is-invalid @enderror form-control" @if($url=='inicio' or $origtrad=='traducción' or $cedulaId >'0') disabled @endif type="text" >
                            <div class="form-text">Sin espacios, ñ, acentos ni caracteres</div>
                            @error('url')<error>{{ $message }}</error>@enderror
                        </div>

                        <!-- MODAL: Resumen -->
                        <div class="col-9 form-group">
                            <label for="resumen" class="form-label">Resumen</label>
                            @if($origtrad=='traducción') <span onclick="VerNoVer('resumen','Original')" class="PaClick">Ver original</span> @endif
                            <textarea wire:model="resumen" id="resumen" class="@error('resumen') is-invalid @enderror form-control"></textarea>
                            <div class="form-text"> </div>
                            @error('resumen')<error>{{ $message }}</error>@enderror
                            <div id="sale_resumenOriginal" style="display:none;">
                                {{ $resumenOrig }}
                            </div>
                        </div>

                        <!-- MODAL: checkbox activo -->
                        <div class="col-3 form-group my-2">
                            <div class="form-check">
                                <input class="form-check-input" wire:model.live="act" type="checkbox" id="act">
                                <label class="form-check-label" for="checkDefault"> Publicar página </label><br>
                                @if($act==FALSE)<error>La cédula no está disponible al público</b></error> @else El público puede acceder a este sitio @endif
                            </div>
                        </div>

                        <!-- MODAL: Borrar-->
                        @if( $cedulaId > '0')
                            <div class="col-6 form-group my-2">
                                <i  wire:click="EliminarSitioWeb()" class="bi bi-trash agregar"> Eliminar página completa</i>
                            </div>
                        @endif
                    </div>

                    @if($cedulaId > '0')
                        <!-- Autor, editor y traductor -->
                        <div class="row my-2">
                            <hr>
                            <!-- Autor -->
                            <div class="col-4 form-group">
                                <div>
                                    @if($CedAutores->count() =='0')
                                        <i class="bi bi-exclamation-octagon-fill" style="color:#CD7B34"></i>
                                    @endif
                                    <label for="" class="form-label">Autor(es)<red></red></label>
                                    <i wire:click="AbreModalDeBuscarAutor('Autor')" class="bi bi-plus-square-fill agregar"></i>
                                </div>
                                @if($CedAutores AND $cedulaId > '0')
                                    <?php $cont='1';?>
                                    @foreach ($CedAutores as $a)
                                        <div class="elemento" style="font-size: 80%;">
                                            {{ $cont++ }} {{ $a->aut_name }}@if($a->aut_corresponding=='1')*@endif
                                            <i wire:click="BorrarAutor('{{ $a->aut_id }}')" wire:confirm="Estas por eliminar a este autor de esta cédula y todas sus traducciones. ¿Seguro quieres continuar?" class="bi bi-trash agregar"></i>
                                        </div>
                                    @endforeach
                                @endif
                                <div class="form-text">(Aplica a todas las traducciones)</div>
                            </div>

                            <!-- Editor -->
                            <div class="col-4 form-group">
                                <div>
                                    @if($CedEditores->where('aut_tipo','Editor')->count() =='0')
                                        <i class="bi bi-exclamation-octagon-fill" style="color:#CD7B34"></i>
                                    @endif
                                    <label for="" class="form-label">Editor<red></red></label>
                                    <i wire:click="AbreModalDeBuscarAutor('Editor')" class="bi bi-plus-square-fill agregar"></i>
                                </div>
                                @if($CedEditores AND $cedulaId > '0')
                                    <?php $cont='1';?>
                                    @foreach ($CedEditores as $a)
                                        <div class="elemento" style="font-size: 80%;">
                                            {{ $cont++ }} {{ $a->aut_name }}@if($a->aut_corresponding=='1')*@endif
                                            <i wire:click="BorrarAutor('{{ $a->aut_id }}')" wire:confirm="Estás por eliminar al editor de esta cédula. ¿Seguro quires continuar?"  class="bi bi-trash agregar"></i>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Traductor -->
                            <div class="col-4 form-group">
                                @if($this->origtrad=='traducción')
                                    <div>
                                        @if($CedTraductores->count() =='0')
                                            <i class="bi bi-exclamation-octagon-fill" style="color:#CD7B34"></i>
                                        @endif
                                        <label for="" class="form-label">Traductor<red></red></label>
                                        <i wire:click="AbreModalDeBuscarAutor('Traductor')" class="bi bi-plus-square-fill agregar"></i>
                                    </div>
                                    @if($CedTraductores AND $cedulaId > '0')
                                        <?php $cont='1';?>
                                        @foreach ($CedTraductores->where('aut_tipo','Traductor') as $a)
                                            <div class="elemento" style="font-size: 80%;">
                                                {{ $cont++ }} {{ $a->aut_name }}@if($a->aut_corresponding=='1')*@endif
                                                <i wire:click="BorrarAutor('{{ $a->aut_id }}')" wire:confirm="Estás por eliminar a este autor de esta cédula. ¿Quieres continuar?" class="bi bi-trash agregar"></i>
                                            </div>
                                        @endforeach
                                    @endif
                                @endif
                            </div>
                        </div>

                        <!-- Palabras clave -->
                        <div class="row my-2">
                            <hr>
                            <!-- Especie(s) -->
                            <div class="col-4 form-group">
                                <div>
                                    {{-- @if($CedUbica->count() =='0')
                                        <i class="bi bi-exclamation-octagon-fill" style="color:#CD7B34"></i>
                                    @endif --}}
                                    <label for="" class="form-label">Especie(s)<red></red></label>
                                    <i wire:click="AbrirModalDeEspecie('0')" class="bi bi-plus-square-fill agregar"></i>
                                    <div class="form-text">(Aplica a todas las traducciones y se traduce)</div>
                                </div>
                                @if($CedSp AND $cedulaId > '0')
                                    @foreach ($CedSp as $a)
                                        <div class="elemento" style="font-size: 80%;width:100%;">
                                            <div class="cortaTexto PaClick" id="Especie{{ $a->sp_id }}" onclick="QuitarCortaTexto('Especie','{{ $a->sp_id }}')" style="width:90%; display:inline-block;">
                                                <i>{{ $a->sp_genero }} {{ $a->sp_especie }}</i> {{ $a->sp_ssp }} ({{ $a->sp_var }})
                                            </div>
                                            <i wire:click="AbrirModalDeUbicacion('{{ $a->ubi_id }}')" class="bi bi-pencil-square agregar" style="float: right;"></i>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Ubicación(es) -->
                            <div class="col-4 form-group">
                                <div>
                                    @if($CedUbica->count() =='0')
                                        <i class="bi bi-exclamation-octagon-fill" style="color:#CD7B34"></i>
                                    @endif
                                    <label for="" class="form-label">Ubicación(es)<red></red></label>
                                    <i wire:click="AbrirModalDeUbicacion('0')" class="bi bi-plus-square-fill agregar"></i>
                                    <div class="form-text">(Aplica a todas las traducciones y se traduce)</div>
                                </div>
                                @if($CedUbica AND $cedulaId > '0')
                                    @foreach ($CedUbica as $a)
                                        <div class="elemento" style="font-size: 80%;width:100%;">
                                            <div class="cortaTexto PaClick" id="Ubica{{ $a->ubi_id }}" onclick="QuitarCortaTexto('Ubica','{{ $a->ubi_id }}')" style="width:90%; display:inline-block;">
                                                {{ $a->ubi_ubicacion_tr }}
                                            </div>
                                            <i wire:click="AbrirModalDeUbicacion('{{ $a->ubi_id }}')" class="bi bi-pencil-square agregar" style="float: right;"></i>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Palabras clave -->
                            <div class="col-4 form-group">
                                <div>
                                    @if($CedAlias->count() =='0')
                                        <i class="bi bi-exclamation-octagon-fill" style="color:#CD7B34"></i>
                                    @endif
                                    <label for="" class="form-label">Palabras clave<red></red></label>
                                    <i wire:click="AbrirModalDeAlias('0')" class="bi bi-plus-square-fill agregar"></i>
                                    <div class="form-text">(Aplica a todas las traducciones y se traduce)</div>
                                </div>
                               @if($CedAlias AND $cedulaId > '0')
                                    @foreach ($CedAlias as $a)
                                        <div class="elemento" style="font-size: 80%;width:100%;">
                                            <div class="cortaTexto PaClick" id="Alias{{ $a->ali_id }}" onclick="QuitarCortaTexto('Alias','{{ $a->ali_id }}')" style="width:90%; display:inline-block;">
                                                {{ $a->ali_txt_tr }}
                                            </div>
                                            <i wire:click="AbrirModalDeAlias('{{ $a->ubi_id }}')" class="bi bi-pencil-square agregar" style="float: right;"></i>
                                        </div>
                                    @endforeach
                                @endif

                            </div>

                        </div>
                    @else
                        <div class="alert alert-warning my-3" role="alert">
                            Luego de generar la cédula, deberás regresar para agrega <b>autores</b>/<b>traductores</b>, <b>editores</b>, <b>ubicación geográfica</b> y <b>palabras clave</b>.
                        </div>
                    @endif


                </div>
                <div class="modal-footer">
                    <button wire:click="GuardaCedula()" class="btn btn-primary">
                        <span wire:loading.remove> Guardar </span>
                        <span wire:loading style="display:none;"> <red> ..guardando...</red> </span>
                    </button>

                    <button wire:click="CierraModalCedula()" class="btn btn-secondary">
                        Cerrar
                    </button>
                </div>
            </div>

        </div>
    </div>
    <!-- ----------------------------- TERMINA MODAL DE EDICIÓN DE CÉDULA --------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->




    <livewire:sistema.modal-cedula-buscautor-component >
    <livewire:sistema.modal-cedula-autores-component >
    <livewire:sistema.modal-cedula-ubicaciones-component >




    <script>
        /* ### Script para abrir y cerrar modal de Cédula */
        Livewire.on('AbreModalDeCedula', () => {
            $('#ModalDeEdicionDeCedulas').modal('show');
        });

        Livewire.on('CierraModalDeCedula', () => {
            $('#ModalDeEdicionDeCedulas').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });

        Livewire.on('RecibeVariablesDeBuscaAutor',() => {
            @this.set('CedAutores',event.detail.dato, live=true);
        });

        Livewire.on('RecibeVariablesDeUbicacion',() => {
            @this.set('CedUbica',event.detail.dato, live=true);
        });

        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoCedula',()=>{
            alert(event.detail.msj);
        })

        function QuitarCortaTexto(prefijo,id){
            document.getElementById(prefijo+id).classList.toggle('cortaTexto');

        }

        /* ### Script para mostrar botón personalizado de input=file */
        // document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
        //     document.getElementById('MiInputFile').click();
        // });
    </script>
</div>
