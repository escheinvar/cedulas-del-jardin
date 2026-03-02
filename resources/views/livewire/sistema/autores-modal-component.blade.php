<div>
 <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- ---------------------------- INICIA MODAL AUTORES --------------------------- -->
    <div wire:ignore.self class="modal fade" id="ModalAutores" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        @if($ModAut_IdAutor=='0')
                            Ingresando un nuevo autor
                        @else
                            Editando datos de autor {{ $ModAut_IdAutor }}
                        @endif
                    </h3>
                    <button wire:click="CierraModalAutores()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- ----------------------------  cuerpo del modal --------------------------->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="row">
                                <div class="col-12 form-group">
                                    @if($ModAut_img != '')
                                        <center>
                                            <img src="{{ $ModAut_img }}" style="max-width:90%;">
                                            <i wire:click="BorrarImagen('{{ $ModAut_IdAutor }}')" wire:confirm="Estás por ELIMINAR PERMANENTEMENTE la imagen del autor. ¿Seguro que quieres continuar?" class="bi bi-trash agregar"></i>
                                        </center>
                                    @else
                                        @if($ModAut_NvaImg != '')
                                            <center>
                                                <img src="{{ $ModAut_NvaImg->temporaryUrl() }}" style="max-width:90%;">
                                            </center>
                                        @endif
                                        <label for="Mod_Aut_NvaImg">Nueva imagen</label>
                                        <input wire:model="ModAut_NvaImg" type="file" class="form-control">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-md-9">
                            <div class="row">
                                <!-- Nombre -->
                                <div class="col-12 col-md-6  form-group">
                                    <label for="ModAut_nombre" class="form-label">Nombre(s)<red>*</red></label>
                                    <input wire:model="ModAut_nombre" id="ModAut_" class="@error('ModAut_nombre') is-invalid @enderror form-control" type="text">
                                    <div class="form-text"></div>
                                    @error('ModAut_nombre')<error>{{ $message }}</error>@enderror
                                </div>

                                <!-- Apellido -->
                                <div class="col-12 col-md-6  form-group">
                                    <label for="ModAut_apellido" class="form-label">Apellido(s)<red>*</red></label>
                                    <input wire:model="ModAut_apellido" id="ModAut_"apellido class="@error('ModAut_apellido') is-invalid @enderror form-control" type="text">
                                    <div class="form-text"></div>
                                    @error('ModAut_apellido')<error>{{ $message }}</error>@enderror
                                </div>

                                <!-- Nombre de autor  -->
                                <div class="col-12 col-md-6  form-group">
                                    <label for="ModAut_autorname" class="form-label">Nombre de autor<red>*</red></label>
                                    <input wire:model="ModAut_autorname" id="ModAut_autorname" class="@error('ModAut_autorname') is-invalid @enderror form-control" type="text">
                                    <div class="form-text">Nombre único del autor (generalmente apellido-apellido N.)</div>
                                    @error('ModAut_autorname')<error>{{ $message }}</error>@enderror
                                </div>

                                <!-- Correo electrónico -->
                                <div class="col-12 col-md-6  form-group">
                                    <label for="ModAut_correo" class="form-label">Correo</label>
                                    <input wire:model="ModAut_correo" id="ModAut_correo" class="@error('ModAut_correo') is-invalid @enderror form-control" type="text">
                                    <div class="form-text">Correo electrónico de contacto</div>
                                    @error('ModAut_correo')<error>{{ $message }}</error>@enderror
                                </div>

                                <!--  Institución -->
                                <div class="col-12 col-md-6  form-group">
                                    <label for="ModAut_institu" class="form-label">Institución</label>
                                    <input wire:model="ModAut_institu" id="ModAut_institu" class="@error('ModAut_institu') is-invalid @enderror form-control" type="text">
                                    <div class="form-text">Institución a la que pertenece</div>
                                    @error('ModAut_institu')<error>{{ $message }}</error>@enderror
                                </div>

                                <!--  Orcid -->
                                <div class="col-12 col-md-6  form-group">
                                    <label for="ModAut_orcid" class="form-label">Orcid</label>
                                    <input wire:model="ModAut_orcid" id="ModAut_orcid" class="@error('ModAut_orcid') is-invalid @enderror form-control" type="text">
                                    <div class="form-text">Número de autor para investigadores (en caso de haberlo)</div>
                                    @error('ModAut_orcid')<error>{{ $message }}</error>@enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- checkboxes de web y de publicar -->
                        <div class="col-6 col-md-3 form-group">
                            <div class="form-check">
                                <input wire:model="ModAut_web" class="form-check-input" type="checkbox" value="1" id="ModAut_web">
                                <label class="form-check-label" for="ModAut_web">Publicar web</label>
                            </div>
                            <div class="form-check">
                                <input wire:model="ModAut_mailpublic" class="form-check-input" type="checkbox" value="1" id="ModAut_mailpublic">
                                <label class="form-check-label" for="ModAut_mailpublic">Publicar correo en web</label>
                            </div>
                        </div>
                        <!-- tipo de dato -->
                        <div class="col-6 col-md-3 form-group">
                            <label for="ModAut_tipo" class="form-label">Tipo</label>
                            <select wire:model="ModAut_tipo" id="ModAut_tipo" class="@error('ModAut_tipo') is-invalid @enderror form-select">
                                <option value="">Indicar</option>
                                <option value="Autor">Autor</option>
                                <option value="Traductor">Traductor</option>
                                <option value="AutorTraductor">Autor y Traductor</option>
                                {{-- <option value="Comunidad">Comunidad</option> --}}
                            </select>
                            @error('ModAut_tipo')<error>{{ $message }}</error>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button  wire:click="CierraModalAutores()" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>

                    <button wire:click="GuardarDatos()" class="btn btn-primary">
                        <span wire:loading.attr="disabled"> Guardar </span>
                        <span wire:loading style="display:none;"> <red> ..guardando...</red> </span>
                    </button>

                </div>
            </div>
        </div>
    </div>
    <!-- ----------------------------- TERMINA MODAL ROLES DE USUARIO ------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
</div>

<script>
    /* ### Script para abrir y cerrar modal */

    Livewire.on('AbreModalDeAutores', () => {
        $('#ModalAutores').modal('show');
    });

    Livewire.on('CierraModalDeAutores', () => {
        $('#ModalAutores').modal('hide');
        if(event.detail.reload == '1'){
            window.location.reload();
        }
    });



</script>
