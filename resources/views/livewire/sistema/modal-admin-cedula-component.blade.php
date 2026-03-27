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
                                        {{-- {{ $o->url_cjarsiglas }}: --}}
                                        {{ $o->url_url }}
                                        [{{ $o->url_lencode }}]
                                        @if($o->url_edo < '4') -- EN EDICIÓN -- @endif
                                        {{ $o->url_ciclo }}V.{{ $o->url_version }}
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
                            <label for="titulo" class="form-label"> Titulo<red>*</red></label>
                            <input wire:model="titulo" id="titulo" class="@error('titulo') is-invalid @enderror form-control" type="text" >
                            <div class="form-text"></div>
                            @error('titulo')<error>{{ $message }}</error>@enderror

                            <!-- botón para ver titulo original -->
                            @if($origtrad=='traducción')
                                <span wire:click="VerNoVer('verTituloOrig')" class="agrega PaClick">
                                    @if($verTituloOrig=='0')<i class="bi bi-eye"></i> @else <i class="bi bi-eye-slash"></i>  @endif original
                                </span>
                            @endif
                            <!-- titulo original -->
                            @if($verTituloOrig=='1')
                               : {{ $tituloOrig }}
                            @endif
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
                            {{-- @if($origtrad=='traducción') <span onclick="VerNoVer('resumen','Original')" class="PaClick">Ver original</span> @endif --}}
                            <textarea wire:model="resumen" id="resumen" class="@error('resumen') is-invalid @enderror form-control"></textarea>
                            <div class="form-text"> </div>
                            @error('resumen')<error>{{ $message }}</error>@enderror

                            <!-- botón para ver resumen original -->
                            @if($origtrad=='traducción')
                                <span wire:click="VerNoVer('verResumenOrig')" class="agrega PaClick">
                                    @if($verResumenOrig=='0')<i class="bi bi-eye"></i> @else <i class="bi bi-eye-slash"></i>  @endif original
                                </span>
                            @endif
                            <!-- resumen original -->
                            @if($verResumenOrig=='1')
                               : {{ $resumenOrig }}
                            @endif
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
                            <div class="col-12 form-group my-2">
                                <i  wire:click="EliminarSitioWeb()" wire:confirm="ATENCIÓN: Estás a punto de eliminar la cédula completa, todos sus textos, todas sus imágenes y todos los metadatos asociados. ¿seguro que quieres continuar?" class="bi bi-trash agregar" style="float: right;">
                                    Eliminar cédula
                                </i>
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
                                    <i wire:click="VerNoVer('verAutor')" class="@if($verAutor=='1')bi bi-dash-square-fill @else bi bi-plus-square-fill @endif agregar"></i>
                                    <label for="" class="form-label">Autor(es)<red>*</red></label>
                                    @if($CedAutores->count() =='0')
                                        <i wire:click="AbreModalDeBuscarAutor('Autor')" class="bi bi-exclamation-octagon-fill PaClick" style="color:#CD7B34"></i>
                                    @else
                                    <i wire:click="AbreModalDeBuscarAutor('Autor')" class="bi bi-plus-circle-fill agregar"></i>
                                    @endif
                                </div>
                                @if($CedAutores AND $cedulaId > '0' AND $verAutor=='1')
                                    <div class="form-text">(Aplica a todas las traducciones)</div>
                                    <?php $cont='1';?>
                                    @foreach ($CedAutores as $a)
                                        <div class="elemento" style="font-size: 80%;">
                                            {{ $cont++ }} {{ $a->aut_name }}@if($a->aut_corresponding=='1')*@endif
                                            <i wire:click="BorrarAutor('{{ $a->aut_id }}')" wire:confirm="Estas por eliminar a este autor de esta cédula y todas sus traducciones. ¿Seguro quieres continuar?" class="bi bi-trash agregar"></i>
                                        </div>
                                    @endforeach
                                @endif

                            </div>

                            <!-- Editor -->
                            <div class="col-4 form-group">
                                <div>
                                    <i wire:click="VerNoVer('verEditor')" class="@if($verEditor=='1')bi bi-dash-square-fill @else bi bi-plus-square-fill @endif agregar"></i>
                                    <label for="" class="form-label">Editor<red>*</red></label>
                                    @if($CedEditores->where('aut_tipo','Editor')->count() =='0')
                                        <i wire:click="AbreModalDeBuscarAutor('Editor')" class="bi bi-exclamation-octagon-fill PaClick" style="color:#CD7B34"></i>
                                    @else
                                        <i wire:click="AbreModalDeBuscarAutor('Editor')" class="bi bi-plus-circle-fill agregar"></i>
                                        @endif
                                    </div>
                                @if($CedEditores AND $cedulaId > '0' and $verEditor=='1')
                                    <div class="form-text">(Aplica a esta cédula)</div>
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
                                        <i wire:click="VerNoVer('verTraductor')" class="@if($verTraductor=='1')bi bi-dash-square-fill @else bi bi-plus-square-fill @endif agregar"></i>
                                        <label for="" class="form-label">Traductor<red>*</red></label>
                                        @if($CedTraductores->count() =='0')
                                            <i wire:click="AbreModalDeBuscarAutor('Traductor')" class="bi bi-exclamation-octagon-fill PaClick" style="color:#CD7B34"></i>
                                        @else
                                            <i wire:click="AbreModalDeBuscarAutor('Traductor')" class="bi bi-plus-circle-fill agregar"></i>
                                        @endif
                                    </div>

                                    @if($CedTraductores AND $cedulaId > '0' and $verTraductor=='1')
                                        <div class="form-text">(Aplica a esta cédula)</div>
                                        <?php $cont='1';?>
                                        @foreach ($CedTraductores->where('aut_tipo','Traductor') as $a)
                                            <div class="elemento" style="font-size: 80%;">
                                                {{ $cont++ }} {{ $a->aut_name }}@if($a->aut_corresponding=='1')*@endif
                                                <i wire:click="BorrarAutor('{{ $a->aut_id }}')" wire:confirm="Estás por eliminar a este autor de esta cédula. ¿Quieres continuar?" class="bi bi-trash agregar"></i>
                                            </div>
                                        @endforeach
                                    @endif
                                @else
                                    {{-- <label for="" class="form-label">Traductor<red></red></label>
                                    <div class="form-text">(No aplica)</div> --}}
                                @endif
                            </div>
                        </div>




                        <div class="row my-2">
                            <hr>
                            <!-- Ubicación(es) -->
                            <div class="col-6 form-group">
                                <div>
                                    <i wire:click="VerNoVer('verUbicacion')" class="@if($verUbicacion=='1')bi bi-dash-square-fill @else bi bi-plus-square-fill @endif agregar"></i>
                                    <label for="" class="form-label">Ubicación(es)<red>*</red></label>
                                    @if($CedUbica->count() =='0')
                                        <i wire:click="AbrirModalDeUbicacion('0')" class="bi bi-exclamation-octagon-fill PaClick" style="color:#CD7B34"></i>
                                    @else
                                        <i wire:click="AbrirModalDeUbicacion('0')" class="bi bi-plus-circle-fill agregar"></i>
                                    @endif
                                </div>
                                @if($CedUbica AND $cedulaId > '0' and $verUbicacion=='1')
                                    <div class="form-text">(Aplica a todas las traducciones y se traduce)</div>
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
                            <div class="col-6 form-group">
                                <div>
                                    <i wire:click="VerNoVer('verAlias')" class="@if($verAlias=='1')bi bi-dash-square-fill @else bi bi-plus-square-fill @endif agregar"></i>
                                    <label for="" class="form-label">Palabras clave<red>*</red></label>
                                    @if($CedAlias->count() =='0')
                                        <i wire:click="AbrirModalDeAlias('0')" class="bi bi-exclamation-octagon-fill PaClick" style="color:#CD7B34"></i>
                                    @else
                                        <i wire:click="AbrirModalDeAlias('0')" class="bi bi-plus-circle-fill agregar"></i>
                                    @endif
                                </div>
                                @if($CedAlias AND $cedulaId > '0' AND $verAlias=='1')
                                    <div class="form-text">(Aplica a todas las traducciones y se traduce)</div>
                                    @foreach ($CedAlias as $a)
                                        <div class="elemento" style="font-size: 80%;width:100%;">
                                            <div class="cortaTexto PaClick" id="Alias{{ $a->ali_id }}" onclick="QuitarCortaTexto('Alias','{{ $a->ali_id }}')" style="width:90%; display:inline-block;">
                                                {{ $a->ali_txt_tr }} &nbsp; &nbsp; [{{ $a->ali_calitipo }}]
                                            </div>
                                            <i wire:click="AbrirModalDeAlias('{{ $a->ali_id }}')" class="bi bi-pencil-square agregar" style="float: right;"></i>
                                        </div>
                                    @endforeach
                                @endif

                            </div>

                        </div>

                        <div class="row my-2">
                            <hr>
                            <!-- Especie(s) -->
                            <div class="col-6 form-group">
                                <div>
                                    <i wire:click="VerNoVer('verSp')" class="@if($verSp=='1')bi bi-dash-square-fill @else bi bi-plus-square-fill @endif agregar"></i>
                                    <label for="" class="form-label">Especie(s)<red></red></label>
                                    {{-- @if($CedSp->count() =='0')
                                        <i wire:click="AbrirModalDeBuscarEspecie('0')" class="bi bi-exclamation-octagon-fill PaClick" style="color:#CD7B34"></i>
                                        @endif --}}
                                        <i wire:click="AbrirModalDeBuscarEspecie('0')" class="bi bi-plus-circle-fill agregar"></i>
                                    </div>
                                @if($CedSp AND $cedulaId > '0' and $verSp=='1')
                                    <div class="form-text">(Aplica a todas las traducciones)</div>
                                    @foreach ($CedSp as $sp)
                                        <div class="elemento" style="font-size: 80%;width:100%;">
                                            <div class="cortaTexto PaClick" id="Especie{{ $sp->sp_id }}" onclick="QuitarCortaTexto('Especie','{{ $sp->sp_id }}')" style="width:90%; display:inline-block;">
                                                <i>{{ $sp->sp_genero }} {{ $sp->sp_especie }}
                                                {{ $sp->sp_ssp }} </i>
                                                @if($sp->sp_var !='')(variante: {{ $sp->sp_var }}) @endif
                                                [{{ $sp->sp_familia }}]
                                                <!-- nuevo uso -->
                                                <i wire:click="AbrirModalDeUso('0','{{ $sp->sp_id }}')" class="bi bi-plus-circle-fill agregar">Uso</i>
                                                <!-- borrar sp -->
                                                &nbsp; &nbsp; &nbsp; <i wire:click="BorrarEspecieDeCedula('{{ $sp->sp_id }}')" class="bi bi-trash agregar" wire:confirm="Estás por eliminar una especie de esta cédula y de todas sus traducciones, así como sus usos asociados. ¿Quieres continuar?" >
                                                    sp @if($sp->usos->count() > '0')y{{ $sp->usos->count() }} usos @endif
                                                </i>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- usos -->
                            <div class="col-6 form-group">
                                <div>
                                    <i wire:click="VerNoVer('verUso')" class="@if($verUso=='1')bi bi-dash-square-fill @else bi bi-plus-square-fill @endif agregar"></i>
                                    <label for="" class="form-label">Usos(s)<red></red></label>
                                    {{-- @if($CedUsos->count() =='0')
                                        <i wire:click="AbrirModalDeBuscarEspecie('0')" class="bi bi-exclamation-octagon-fill PaClick" style="color:#CD7B34"></i>
                                    @endif --}}
                                    {{-- <i wire:click="AbrirModalDeUso('0')" class="bi bi-plus-circle-fill agregar"></i> --}}
                                </div>
                                @if($CedUsos AND $cedulaId > '0' and $verUso=='1')
                                    <div class="form-text">(Aplica a todas las traducciones)</div>
                                    @foreach ($CedUsos as $u)
                                        <div class="elemento" style="font-size: 80%;width:100%;">
                                            <div class="cortaTexto PaClick" id="Uso{{ $u->uso_id }}" onclick="QuitarCortaTexto('Uso','{{ $u->uso_id }}')" style="width:90%; display:inline-block;">
                                                {{ $u->uso_categoria }}
                                                {{ $u->uso_uso }}
                                                @if($u->uso_partes != '') ({{ $u->uso_partes }}) @endif
                                                &nbsp; | <i>{{ $u->uso_spname }}</i> &nbsp; |
                                                {{ $u->uso_describe }}
                                                <i wire:click="AbrirModalDeUso('{{ $u->uso_id }}', '{{ $u->uso_spid }}')" class="bi bi-pencil-square agregar" style="floats: right;"></i>
                                            </div>
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
    <livewire:sistema.modal-cedula-especie-component >
    <livewire:sistema.modal-cedula-uso-component >
    <livewire:sistema.modal-cedula-ubicaciones-component >
    <livewire:sistema.modal-cedula-alias-component >




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

        Livewire.on('RecibeVariablesDeAlias',() => {
            @this.set('CedAlias',event.detail.dato, live=true);
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
