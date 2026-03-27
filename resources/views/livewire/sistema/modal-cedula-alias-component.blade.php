<div>
<!-- ------------------------------------------------------------------------------------------ -->
<!-- --------------------------------------- MODAL DE CAMBIO DE TÍTULO ------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<div wire:ignore.self class="modal fade" id="Modal_alias" tabindex="-1" role="dialog">
<div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    	<!-- ----------------------------  cabeza del modal ------------------------- -->
        <div class="modal-header">
            <h3 class="modal-title">
                @if($alias_id=='0')Nueva @else Editando @endif
                Palabras clave
                de cédula {{ $alias_url }}
                de {{ $alias_jardin }}
                {{-- (@if($alias_trad >'0') traducción @else original @endif) --}}
            </h3>
            <button wire:click="CerrarModalDeAlias()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
        </div>
        <!-- ----------------------------  cuerpo del modal ------------------------- -->
        <div class="modal-body" wire:loading.attr="disabled">
            <div class="row">
                <!-- Tipo de alias -->
                <div class="col-12 my-1 form-group">
                    <label for="alias_tipo" class="form-label">Tipo de palabra<red>*</red></label>
                    <select wire:model="alias_tipo" id="alias_tipo" class="@error('alias_tipo') is-invalid @enderror form-select" @if($alias_id > '0') disabled @endif>
                        <option value="">Indicar...</option>
                        @foreach($tipoAlias as $t)
                            <option value="{{ $t->cat_valor }}">{{ $t->cat_valor }}</option>
                        @endforeach
                    </select>
                    <div class="form-text"></div>
                    @error('alias_tipo')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Palabra -->
                <div class="col-12 my-1 form-group">
                    <label for="alias_txt" class="form-label">Palabra clave<red>*</red></label>
                    <input wire:model="alias_txt" id="alias_txt" class="@error('alias_txt') is-invalid @enderror form-control" type="text" @if($alias_id > '0') disabled @endif>
                    <div class="form-text"></div>
                    @error('alias_txt')<error>{{ $message }}</error>@enderror
                </div>

                <!-- Traducción -->
                @if($alias_id > '0')
                    <div class="col-12 my-1 form-group">
                        <label for="alias_txt_tr" class="form-label">Traducción de Palabra Clave<red></red></label>
                        <input wire:model="alias_txt_tr" id="alias_txt_tr" class="@error('alias_txt_tr') is-invalid @enderror form-control" type="text">
                        <div class="form-text"></div>
                        @error('alias_txt_tr')<error>{{ $message }}</error>@enderror
                    </div>
                @endif

                @if($alias_id > '0')
                    <div class="col-12 my-1 form-group">
                        <i wire:click="EliminarAlias()" wire:confirm="Estas por eliminar este alias y todas sus traducciones. ¿Seguro quieres continuar?" class="bi bi-trash agregar" style="float: right;"> Eliminar alias</i>
                    </div>
                @endif
            </div>
        </div>

        <!-- ---------------------------- pie del modal ----------------------------- -->
        <div class="modal-footer">
            <button wire:click="CerrarModalDeAlias" class="btn btn-secondary">Cerrar</button>
            <button wire:click="GuardarAlias()" wire:loading.attr="disabled" class="btn btn-primary">Guardar</button>
            <span wire:loading style="display:none;"><red>pensando...</red> </span>
        </div>
    </div>
</div>
</div>
<!-- ----------------------------- TERMINA MODAL ROLES DE USUARIO ------------------------- -->
<!-- -------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------- -->
    <script>
        /* ### Script para abrir y cerrar Modal */
        Livewire.on('AbreModalAlias', () => {
            $('#Modal_alias').modal('show');
        });
        Livewire.on('CierraModalAlias', () => {
            $('#Modal_alias').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });
        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoAlias',()=>{
            alert(event.detail.msj);
        })

        /* ### Script para mostrar botón personalizado de input=file */
        // document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
        //     document.getElementById('MiInputFile').click();
        // });
    </script>

</div>
