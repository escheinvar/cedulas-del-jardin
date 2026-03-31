<div>
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- ---------------------------- INICIA MODAL DE BUSCAR AUTOR ----------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <div wire:ignore.self class="modal fade" id="ModalDeBusquedaDeElAutor" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        @if($cedulaId=='0')
                            Buscando {{ $BuscaAutor_tipo }} para cédula nueva
                        @else
                            Buscando {{ $BuscaAutor_tipo }} para cédula Id {{ $cedulaId }}
                        @endif
                        de {{ $jardinSel }}
                    </h3>
                    <button wire:click="CierraModalDeBuscarAutor()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- cuerpo del modal -->
                <div class="modal-body">
                        <div class="row">
                            @if($BuscaAutor_tipo=='Editor') <div class="col-12 my-2"><div class="alert alert-warning"><b>Recuerda que el editor DEBE estar registrado en el sistema</b></div></div>@endif
                            <div class="col-12 col-md-4 form-group">
                                <label for="BuscaAutor_BuscaNombre" class="form-label">Nombre:</label>
                                <input wire:model="BuscaAutor_BuscaNombre" id="BuscaAutor_BuscaNombre" class="@error('BuscaAutor_BuscaNombre') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('BuscaAutor_BuscaNombre')<error>{{ $message }}</error>@enderror
                            </div>

                            <div class="col-12 col-md-4 form-group">
                                <label for="BuscaAutor_BuscaApellido" class="form-label">Apellido:</label>
                                <input wire:model="BuscaAutor_BuscaApellido" id="BuscaAutor_BuscaApellido" class="@error('BuscaAutor_BuscaApellido') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('BuscaAutor_BuscaApellido')<error>{{ $message }}</error>@enderror
                            </div>

                            <div class="col-12 col-md-2 form-group">
                                <br>
                                <button wire:click="BuscarAutores()" class="btn btn-primary">Buscar</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                @if($BuscaAutor_BuscaNombre != '' OR $BuscaAutor_BuscaApellido != '')
                                    @if($BuscaAutor_Posibles->count() > '0')
                                        <b>Selecciona al autor:</b>
                                        <table class="table table-striped">
                                            <thead>
                                                {{-- <tr><th>Nombre Apellido</th></tr> --}}
                                            </thead>
                                            <tbody>
                                                @foreach ($BuscaAutor_Posibles as $a)
                                                    <tr>
                                                        <td>
                                                            <div class="py-2 PaClick" onclick="VerNoVer('Autor','{{ $a->caut_id }}')">
                                                                {{ $a->caut_nombre }} {{ $a->caut_apellido1 }} {{ $a->caut_apellido2 }}
                                                                @if($a->caut_usrid != '')<i class="bi bi-person-check"></i>@endif
                                                            </div>
                                                            <div id="sale_Autor{{ $a->caut_id }}" style="display:none;">
                                                                Nombre de autor: {{ $a->caut_nombreautor }}<br>
                                                                Correo: {{ $a->caut_correo }}<br>
                                                                Comunidad: {{ $a->caut_comunidad }} <br>
                                                                Instituto: {{ $a->caut_institu }} <br>
                                                                @if($a->caut_lenguas != '') Lenguas: {{ $a->caut_lenguas }} <br> @endif

                                                                <button wire:click="ConfirmarDatosDeAutor({{ $a->caut_id }})"
                                                                    class="btn btn-secondary btn-sm"
                                                                    style="float: right;"
                                                                    @if($BuscaAutor_tipo=='Editor' AND $a->caut_usrid =='') disabled @endif>
                                                                    Seleccionar a {{ $BuscaAutor_tipo }}
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        No se encontraron autores en el catálogo.
                                        <button wire:click="AbrirModalDeNuevoAutor()" class="btn btn-secondary" @if($BuscaAutor_tipo=='Editor') disabled @endif>
                                            Agregar uno al catálogo
                                        </button>
                                    @endif
                                @endif

                                <!-- ------------------------------------------------------------------------------------- -->
                                <!-- ------------------------------------------------------------------------------------- -->
                                <!-- ----------------------- Ver y confirmar datos de autor seleccionado ----------------- -->
                                <!-- ------------------------------------------------------------------------------------- -->
                                @if($BuscaAutor_Ganon->count() != '0')
                                    <h5 class="my-3">Confirma los datos del autor id {{ $BuscaAutor_id }}:</h5>

                                    <div class="row">
                                        <div class="col-4 col-md-3 px-1"><b>Nombre</b></div>
                                        <div class="col-8 col-md-9 px-1"><input class="form-control" value="{{ $BuscaAutor_Ganon->caut_nombre }} {{ $BuscaAutor_Ganon->caut_apellido1 }} {{ $BuscaAutor_Ganon->caut_apellido2 }}" readonly></div>
                                    </div>
                                     <div class="row">
                                        <div class="col-4 col-md-3 px-1"><b>Nombre de autor:</b></div>
                                        <div class="col-8 col-md-9 px-1">{{ $BuscaAutor_Ganon->caut_nombreautor }}
                                            @if($BuscaAutor_Ganon->caut_usrid > '0') <i class="bi bi-person-check"></i>@endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4 col-md-3 px-1"><b>Comunidad:</b></div>
                                        <div class="col-8 col-md-9 px-1"><input wire:model="BuscaAutor_comunidad" class="@error('BuscaAutor_comunidad') is-invalid @enderror form-control" type="text"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4 col-md-3 px-1"><b>Institución:</b></div>
                                        <div class="col-8 col-md-9 px-1"><input wire:model="BuscaAutor_institu" class="@error('BuscaAutor_institu') is-invalid @enderror form-control" type="text"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4 col-md-3 px-1"><b>Correo:</b></div>
                                        <div class="col-8 col-md-9 px-1"><input wire:model="BuscaAutor_correo" class="@error('BuscaAutor_correo') is-invalid @enderror form-control" type="text"></div>
                                    </div>

                                    <div class="form-check">
                                        <input wire:model="BuscaAutor_corresponding" class="form-check-input" type="checkbox" value="" id="checkDefault">
                                        <label class="form-check-label" for="checkDefault">Poner como autor de correspondencia</label>
                                    </div>

                                    <div class="row my-3">
                                        <div class="col-12">
                                            <button wire:click="AgregarAutorACedula()" class="btn btn-primary" style="float: right;">
                                                <i class="bi bi-plus-circle"></i> Agregar
                                            </button>
                                        </div>
                                    </div>

                                @endif
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button wire:click="CierraModalDeBuscarAutor()" class="btn btn-secondary">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>

        /* ### Script para abrir y cerrar modal de Buscar Autor */
        Livewire.on('AbreModalDeBuscarAutor', () => {
            $('#ModalDeBusquedaDeElAutor').modal('show');
        });

        Livewire.on('CierraModalDeBuscarAutor', () => {
            $('#ModalDeBusquedaDeElAutor').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });

        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoBuscaAutorCedula',()=>{
            alert(event.detail.msj);
        })


        /* ### Script para mostrar botón personalizado de input=file */
        // document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
        //     document.getElementById('MiInputFile').click();
        // });
    </script>

</div>
