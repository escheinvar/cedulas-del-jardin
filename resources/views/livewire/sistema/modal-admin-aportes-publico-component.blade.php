<div>
    <!-- ------------------------------------------------------------------------------------------ -->
    <!-- --------------------------------------- MODAL DE CAMBIO DE TÍTULO ------------------------ -->
    <!-- ------------------------------------------------------------------------------------------ -->
    <!-- ------------------------------------------------------------------------------------------ -->
    <div wire:ignore.self class="modal fade" id="Modal_EditaAporteVisitante" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- ----------------------------  cabeza del modal ------------------------- -->
            <div class="modal-header">
                <h3 class="modal-title">
                    Editando aporte
                </h3>
                <button wire:click="CerrarModalParaEditarAporteDeVisitante()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
            </div>
            <!-- ----------------------------  cuerpo del modal ------------------------- -->
            <div class="modal-body" wire:loading.attr="disabled">
                <div class="row">
                    @if($ModalMsg_id > '0')
                        <div class="col-6">
                            <b>Nombre</b>:{{ $msg->msg_nombre }}<br>
                            <b>Usuario</b>: {{ $msg->msg_usuario }}<br>
                            <b>Ubicación</b>: {{ $msg->msg_estado }}, {{ $msg->msg_mpio }}, {{ $msg->comunidad }}<br>
                            <b>Lengua</b>: {{ $msg->msg_lengua }}
                        </div>
                        <div class="col-6">
                            <b>Ocupación</b>: <br>
                            <b>Edad</b>: {{ $msg->msg_edad }}<br>
                            <b>Correo</b>: {{ $msg->msg_correo }}<br>
                            <b>Tel</b>: {{ $msg->msg_tel }}<br>
                        </div>

                        <!--  Texto-->
                        <div class="col-12 my-1 form-group">
                            @if($msg->msg_edo=='0')
                                <label for="ModalMsg_mensaje" class="form-label">En caso de ser necesario, edita el texto<red></red></label>
                                <textarea wire:model="ModalMsg_mensaje" rows="5" id="ModalMsg_mensaje"
                                    class="@error('ModalMsg_mensaje') is-invalid @enderror form-control"
                                    @if($msg->msg_edo != '0') readonly @endif>
                                </textarea>
                                <div class="form-text"></div>
                                @error('ModalMsg_mensaje')<error>{{ $message }}</error>@enderror
                            @else
                                <label for="ModalMsg_mensaje" class="form-label">Mensaje:<red></red></label>
                                <div class="p5 m4">
                                    {{ $ModalMsg_mensaje }}
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <div class="row m-1">
                <div class="col-12 form-group">
                    <label class="form-label">Indica el paso siguiente:</label>
                </div>
                <div class="col-12 center">
                    <div class="row">
                        <!-- botón previo -->
                        <div class="col-4 col-md-2">
                            <div class="m-2" style="">
                                Visitante<br>Escribe
                                {{-- <i class="bi bi-arrow-right"></i> --}}
                            </div>
                        </div>

                        <!-- botón 0 revisión -->
                        <div class="col-4 col-md-2" style="color:#CD7B34">
                            <div class="bi @if($ModalMsg_id >'0' AND $msg->msg_edo=='0') bi-0-circle-fill @endif">
                                Editor<br>Revisa
                            </div>
                        </div>

                        <!-- botón 3 autoriza -->
                        <div class="col-4 col-md-2" style="color:darkgreen;">
                            <div class="bi @if($ModalMsg_id >'0' AND $msg->msg_edo=='3') bi-3-circle-fill @else btn PaClick @endif" @if($ModalMsg_id >'0' AND $msg->msg_edo != '3') wire:click="CambiaEstado('3')" @endif>
                                Editor<br>Autoriza
                            </div>
                        </div>

                        <!-- botón 1 pausa -->
                        <div class="col-4 col-md-3" style="color:rgb(0, 162, 255);">
                            <div class="bi @if($ModalMsg_id >'0' AND $msg->msg_edo=='1') bi-1-circle-fill @else btn PaClick @endif" @if($ModalMsg_id >'0' AND $msg->msg_edo != '1') wire:click="CambiaEstado('1')" @endif>
                                Autor o editor<br>Suspende
                            </div>
                        </div>

                        <!-- botón 2 cancela -->
                        <div class="col-4 col-md-2" style="color:red;">
                            <div class="bi @if($ModalMsg_id >'0' AND $msg->msg_edo=='2') bi-2-circle-fill @else btn PaClick @endif" @if($ModalMsg_id >'0' AND $msg->msg_edo != '2') wire:click="CambiaEstado('2')" @endif>
                                Editor<br>Cancela
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ---------------------------- pie del modal ----------------------------- -->
            <div class="modal-footer">
                <button wire:click="CerrarModalParaEditarAporteDeVisitante" class="btn btn-secondary">Cancelar</button>
                {{-- <button wire:click="GuardaModal()" wire:loading.attr="disabled" class="btn btn-primary">Guardar</button> --}}
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
        Livewire.on('AbreModalParaEditarAporteDeVisitante', () => {
            $('#Modal_EditaAporteVisitante').modal('show');
        });
        Livewire.on('CierraModalParaEditarAporteDeVisitante', () => {
            $('#Modal_EditaAporteVisitante').modal('hide');
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
        Livewire.on('RecargarPaginaModalAportes',() => {
            location.reload();
            // window.location.href;
        });
    </script>
</div>
