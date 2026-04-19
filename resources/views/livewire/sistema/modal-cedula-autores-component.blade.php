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
                        <div class="row">
                            <!-- Nombre -->
                            <div class="col-12 col-md-4  form-group">
                                <label for="ModAut_nombre" class="form-label">Nombre(s)<red>*</red></label>
                                <input wire:model.live="ModAut_nombre" id="ModAut_nombre" class="@error('ModAut_nombre') is-invalid @enderror form-control" type="text">
                                <div class="form-text"></div>
                                @error('ModAut_nombre')<error>{{ $message }}</error>@enderror
                            </div>

                            <!-- Apellido -->
                            <div class="col-12 col-md-4  form-group">
                                <label for="ModAut_apellido1" class="form-label">Primer apellido<red>*</red></label>
                                <input wire:model.live="ModAut_apellido1" id="ModAut_apellido1"apellido class="@error('ModAut_apellido1') is-invalid @enderror form-control" type="text">
                                <div class="form-text"></div>
                                @error('ModAut_apellido1')<error>{{ $message }}</error>@enderror
                            </div>

                            <!-- Apellido 2-->
                            <div class="col-12 col-md-4  form-group">
                                <label for="ModAut_apellido2" class="form-label">Segundo apellido<red></red></label>
                                <input wire:model.live="ModAut_apellido2" id="ModAut_apellido2" class="@error('ModAut_apellido2') is-invalid @enderror form-control" type="text">
                                <div class="form-text"></div>
                                @error('ModAut_apellido2')<error>{{ $message }}</error>@enderror
                            </div>

                             <!-- Nombre de autor  -->
                            <div class="col-12 col-md-4  form-group">
                                <label for="ModAut_autorname" class="form-label">Nombre de autor<red>*</red></label><br> &nbsp; &nbsp;
                                <button class="btn btn-sm btn-primary bi bi-info-square" wire:click="CalculaNombre()" style="display:inline-block;"  @if($ModAut_nombre=='' OR $ModAut_apellido1=='' OR $ModAut_IdAutor > '0') disabled @endif> Sugerir</button>
                                <input wire:model.live="ModAut_autorname" wire:change="CalculaUrl()" id="ModAut_autorname" style="display:inline-block;width:75%;" class="@error('ModAut_autorname') is-invalid @enderror form-control"  @if($ModAut_IdAutor > '0') readonly @endif type="text">

                                <div class="form-text">Nombre único del autor (generalmente apellido-apellido N.)</div>
                                @error('ModAut_autorname')<error>{{ $message }}</error>@enderror
                            </div>

                            {{-- <!-- Url-->
                            <div class="col-12 col-md-4  form-group">
                                <label for="ModAut_url" class="form-label">Url<red></red></label> &nbsp; &nbsp;
                                <button class="btn btn-sm" @if($ModAut_nombre=='') disabled @endif readonly><i wire:click="CalculaNombre()" class="bi bi-info-square PaClick"> Sugerir</i></button>
                                <input wire:model="ModAut_url" id="ModAut_url" class="@error('ModAut_url') is-invalid @enderror form-control" readonly type="text">
                                <div class="form-text"></div>
                                @error('ModAut_url')<error>{{ $message }}</error>@enderror
                            </div> --}}

                            <!-- Correo electrónico -->
                            <div class="col-12 col-md-4  form-group">
                                <label for="ModAut_correo" class="form-label">Correo</label>
                                <input wire:model="ModAut_correo" id="ModAut_correo" class="@error('ModAut_correo') is-invalid @enderror form-control" type="text">
                                <div class="form-text">Correo electrónico de contacto</div>
                                @error('ModAut_correo')<error>{{ $message }}</error>@enderror
                            </div>

                            <!-- checkboxes de web y de publicar -->
                                {{-- <div class="col-6 col-md-4 form-group">
                                    <div class="form-check">
                                        <input wire:model="ModAut_web" class="form-check-input" type="checkbox" value="1" id="ModAut_web">
                                        <label class="form-check-label" for="ModAut_web">Generar página web</label>
                                    </div>
                                </div> --}}
                                <div class="col-12 col-md-4 form-group">
                                    <div class="form-check">
                                        <br>
                                        <input wire:model.live="ModAut_mailpublic" class="form-check-input" type="checkbox" value="1" id="ModAut_mailpublic">
                                        <label class="form-check-label" for="ModAut_mailpublic">@if($ModAut_mailpublic=='1')El autor aceptó que su correo sea publicado en internet @else Publicar correo en web @endif</label>
                                    </div>
                                </div>

                            <!-- Teléfono -->
                            {{-- <div class="col-12 col-md-4  form-group">
                                <label for="ModAut_tel" class="form-label">Teléfono</label>
                                <input wire:model="ModAut_tel" id="ModAut_tel" class="@error('ModAut_tel') is-invalid @enderror form-control" type="text">
                                <div class="form-text">Correo electrónico de contacto</div>
                                @error('ModAut_tel')<error>{{ $message }}</error>@enderror
                            </div> --}}
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <!--  Comunidad -->
                                <div class="col-12 col-md-4  form-group">
                                    <label for="ModAut_comunidad" class="form-label">Comunidad</label>
                                    <input wire:model="ModAut_comunidad" id="ModAut_comunidad" class="@error('ModAut_comunidad') is-invalid @enderror form-control" type="text">
                                    <div class="form-text">En su caso, comunidad a la que pertenece</div>
                                    @error('ModAut_comunidad')<error>{{ $message }}</error>@enderror
                                </div>

                                <!--  Institución -->
                                <div class="col-12 col-md-4  form-group">
                                    <label for="ModAut_institu" class="form-label">Institución</label>
                                    <input wire:model="ModAut_institu" id="ModAut_institu" class="@error('ModAut_institu') is-invalid @enderror form-control" type="text">
                                    <div class="form-text">En su caso, institución a la que pertenece</div>
                                    @error('ModAut_institu')<error>{{ $message }}</error>@enderror
                                </div>

                                <!--  Orcid -->
                                <div class="col-12 col-md-4  form-group">
                                    <label for="ModAut_orcid" class="form-label">Orcid ID</label>
                                    <input wire:model="ModAut_orcid" id="ModAut_orcid" class="@error('ModAut_orcid') is-invalid @enderror form-control" type="text">
                                    <div class="form-text">En su caso, número de autor para investigadores (sacar en <a href="https://orcid.org/" target="new">orcid.org</a>)</div>
                                    @error('ModAut_orcid')<error>{{ $message }}</error>@enderror
                                </div>

                                <!--  Scopus -->
                                <div class="col-12 col-md-4  form-group">
                                    <label for="ModAut_scopus" class="form-label">Scopus ID</label>
                                    <input wire:model="ModAut_scopus" id="ModAut_scopus" class="@error('ModAut_scopus') is-invalid @enderror form-control" type="text">
                                    <div class="form-text">En su caso, número de autor para autores (sacar en <a href="https://scopus.com/" target="new">scopus.com</a>)</div>
                                    @error('ModAut_scopus')<error>{{ $message }}</error>@enderror
                                </div>

                                <!--  ISNI -->
                                <div class="col-12 col-md-4  form-group">
                                    <label for="ModAut_isni" class="form-label">ISNI</label>
                                    <input wire:model="ModAut_isni" id="ModAut_isni" class="@error('ModAut_isni') is-invalid @enderror form-control" type="text">
                                    <div class="form-text">En su caso, número de autor ISNI (sacar en <a href="https://https://isni.org/" target="new">isni.org/</a>)</div>
                                    @error('ModAut_isni')<error>{{ $message }}</error>@enderror
                                </div>



                                <!-- Vincular a usuario -->
                                <div class="col-12 col-md-4 form-group">
                                    <label for="ModAut_usrsist" class="form-label">@if($ModAut_usrsist=='')Vincular @else <i class="bi bi-person-check"></i>Vinculado @endif a usuario del sistema: <red></red></label>
                                    <select wire:model.live="ModAut_usrsist" id="ModAut_usrsist" class="@error('ModAut_usrsist') is-invalid @enderror form-select">
                                        <option value="">Indicar usuario del sistema...</option>
                                        @foreach($usr as $u)
                                            <option value='{{ $u->id }}'>{{ $u->nombre }} {{ $u->apellido }} ({{ $u->usrname }})</option>
                                        @endforeach
                                    </select>
                                    <div class="form-text"></div>
                                    @error('ModAut_usrsist')<error>{{ $message }}</error>@enderror
                                </div>
                            </div>
                        </div>

                        <!-- tipo de dato -->
                        {{-- <div class="col-6 col-md-3 form-group">
                            <label for="ModAut_tipo" class="form-label">Tipo</label>
                            <select wire:model="ModAut_tipo" id="ModAut_tipo" class="@error('ModAut_tipo') is-invalid @enderror form-select">
                                <option value="">Indicar</option>
                                <option value="Autor">Autor</option>
                                <option value="Traductor">Traductor</option>
                                <option value="AutorTraductor">Autor y Traductor</option>
                            </select>
                            @error('ModAut_tipo')<error>{{ $message }}</error>@enderror
                        </div> --}}
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
    <!-- ----------------------------- TERMINA MODAL AUTORES ---------------------------------- -->
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
