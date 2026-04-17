<div>
<!-- ------------------------------------------------------------------------------------------ -->
<!-- --------------------------------------- MODAL DE CAMBIO DE TÍTULO ------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------------ -->
<div wire:ignore.self class="modal fade" id="Modal_CambioEdoCedula" tabindex="-1" role="dialog">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    	<!-- ----------------------------  cabeza del modal ------------------------- -->
        <div class="modal-header">
            <h3 class="modal-title">
                Cambio de estado de cédula
                @if($CambiaEdo_ced)
                    {{ $CambiaEdo_ced->url_url }}
                @endif
            </h3>
            <button wire:click="CerrarModalDeCambioDeEstado()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
        </div>
        <!-- ----------------------------  cuerpo del modal ------------------------- -->
        <div class="modal-body" wire:loading.attr="disabled">
            {{-- <button class="btn btn-secondary" wire:click="GeneraPDF('2.1')">
                Crear pdf
            </button> --}}

            <div>
                <b>Indica el paso que sigue</b>
            </div>


            @if($CambiaEdo_urlid > '0')
                @if($CambiaEdo_ced->url_doi != '')
                    <div class="alert alert-warning">
                        Esta cédula ya cuenta con registro <b>DOI</b>, por lo que se recomienda no editarla.
                    </div>
                @endif

                <div class="my-2" style="font-size: 80%; width:100%; text-align:center;">
                    <div style="display:inline-block;">
                        @if($CambiaEdo_urledo=='0')<i class="bi bi-0-circle-fill" style="color:#CD7B34"></i><br> @endif
                        <button wire:click="CambiaEstado('0')" class="btn cedEdoIcon0 @if($CambiaEdo_urledo=='0') EdoActual @endif" {{ $e0 }}>
                            <br>
                            <span style="font-size:90%;">0 Aut/Trad</span>
                        </button>
                    </div>

                    <i class="bi bi-arrow-right"></i>
                    <div style="display:inline-block;">
                        @if($CambiaEdo_urledo=='1')<i class="bi bi-1-circle-fill" style="color:#CD7B34"></i><br> @endif
                        <button wire:click="CambiaEstado('1')" class="btn cedEdoIcon1 @if($CambiaEdo_urledo=='1') EdoActual @endif" {{ $e1 }}>
                            <br>
                            <span style="font-size:90%;">1 Editor</span>
                        </button>
                        @if($CambiaEdo_ced->url_doi != '' and $CambiaEdo_ced->url_edo=='6')<br><b>(con DOI)</b> @endif
                    </div>

                    <i class="bi bi-arrow-right"></i>
                    <div style="display:inline-block;">
                        @if($CambiaEdo_urledo=='2')<i class="bi bi-2-circle-fill" style="color:#CD7B34"></i><br> @endif
                        <button wire:click="CambiaEstado('2')" class="btn cedEdoIcon2 @if($CambiaEdo_urledo=='2') EdoActual @endif" {{ $e2 }}>
                            <br>
                            <span style="font-size:90%;">2 Aut/Trad</span>
                        </button>
                        @if($CambiaEdo_ced->url_doi != ''  and $CambiaEdo_ced->url_edo=='6')<br><b>(con DOI)</b> @endif
                    </div>

                    <i class="bi bi-arrow-right"></i>
                    <div style="display:inline-block;">
                        @if($CambiaEdo_urledo=='3')<i class="bi bi-3-circle-fill" style="color:#CD7B34"></i><br> @endif
                        <button wire:click="CambiaEstado('3')" class="btn cedEdoIcon3 @if($CambiaEdo_urledo=='3') EdoActual @endif" {{ $e3 }}>
                            <br>
                            <span style="font-size:90%;">3 Editor</span>
                        </button>
                    </div>

                    <i class="bi bi-arrow-right"></i>
                    <div style="display:inline-block;">
                        @if($CambiaEdo_urledo=='4')<i class="bi bi-4-circle-fill" style="color:#CD7B34"></i><br> @endif
                        <button wire:click="CambiaEstado('4')" class="btn cedEdoIcon4 @if($CambiaEdo_urledo=='4') EdoActual @endif" {{ $e4 }}>
                            <br>
                            <span style="font-size:90%;">4 Admin.</span>
                        </button>
                    </div>

                    <i class="bi bi-arrow-right"></i>
                    <div style="display:inline-block;">
                        @if($CambiaEdo_urledo=='5')
                            <i class="bi bi-5-circle-fill" style="color:#CD7B34"></i>
                            {{-- @if($CambiaEdo_ced->url_doi != '')<br><b>DOI</b> @endif --}}
                            <br>
                        @endif
                        <button wire:click="ConfirmarPublicacion()" class="btn cedEdoIcon5 @if($CambiaEdo_urledo=='5') EdoActual @endif" {{ $e5 }}>
                            <br>
                            <span style="font-size:90%;">5 Admin.</span>
                        </button>

                    </div>

                    <i class="bi bi-arrow-right"></i>
                    <div style="display:inline-block;">
                        @if($CambiaEdo_urledo=='6')<i class="bi bi-6-circle-fill" style="color:#CD7B34"></i><br> @endif
                        <button wire:click="CambiaEstado('6')" class="btn cedEdoIcon6 @if($CambiaEdo_urledo=='6') EdoActual @endif" {{ $e6 }}>
                            <br>
                            <span style="font-size:90%;">6</span>
                        </button>
                        @if($CambiaEdo_ced->url_doi != '')<br><b>(con DOI)</b> @endif
                    </div>
                </div>


                <!-- ---------------------------------------------------------------------------------- -->
                <!-- ---------------- SECCIÓN DE VALORES PARA PUBLICACIÓN ----------------------------- -->
                <!-- ---------------------------------------------------------------------------------- -->
                @if($ErrorAlert=='1')
                    <div class="alert alert-danger">
                        <h4>! Error !</h4>
                        Faltan datos. No se puede publicar .<br>
                        @if($CambiaEdo_ced->autores->count() < '1')           <i class="bi bi-exclamation-octagon-fill" style="color:#CD7B34"></i> No hay autor<br> @endif
                        @if($this->CambiaEdo_ced->editores->count() < '1')    <i class="bi bi-exclamation-octagon-fill" style="color:#CD7B34"></i> No hay editor<br> @endif
                        @if(($this->CambiaEdo_ced->url_tradid > '0') AND
                           ($this->CambiaEdo_ced->traductores->count() < '1'))<i class="bi bi-exclamation-octagon-fill" style="color:#CD7B34"></i> No hay Traductor<br> @endif
                        @if($this->CambiaEdo_ced->ubicaciones->count() < '1') <i class="bi bi-exclamation-octagon-fill" style="color:#CD7B34"></i> No hay ubicación<br> @endif
                        @if($this->CambiaEdo_ced->alias->count() < '1')       <i class="bi bi-exclamation-octagon-fill" style="color:#CD7B34"></i> No hay palabra clave<br> @endif
                    </div>
                @endif

                <!-- Sección de cuestionario de datos para publicación -->
                @if($verPublicar=='1')
                    @if($CambiaEdo_ced->url_edo != '6')
                        <!-- cabecera avisando tipo de acción -->
                        <div class="row my-2">
                            <div class="col-12 my-2">
                                @if($CambiaEdo_ced->url_ciclo =='0')
                                    <b>Estás por publicar por primera vez esta cédula</b><br>
                                @else
                                    <b>Estás por concluir el {{ $CambiaEdo_ced->url_ciclo }}@if(in_array($CambiaEdo_ced->url_ciclo,[1,3]))<sup>er</sup> @else<sup>o</sup>@endif ciclo de esta cédula</b><br>
                                @endif
                            </div>
                        </div>

                        <!-- muestra ciclo, versión año, cambio de versión y botón doi -->
                        <div class="row">
                            <div class="col-3">
                                <b>Ciclo</b>: {{ $CambiaEdo_ced->url_ciclo }}<br>
                                <b>Versión</b>: {{ $CambiaEdo_ced->url_version }}<br>
                                <b>Año</b>: @if($CambiaEdo_ced->url_ciclo =='0'){{ Date('Y') }} @else {{ $CambiaEdo_ced->url_anio }} @endif<br>
                            </div>

                            <div class="col-2">
                                @if($CambiaEdo_ced->url_ciclo > '0')
                                    <a href="google.com" target="_new" class="nolink">
                                        <i class="bi bi-file-earmark-pdf-fill"> V. previa</i>
                                    </a>
                                    <br>
                                    <a href="google.com" target="_new2" class="nolink">
                                        <i class="bi bi-file-earmark-pdf-fill"> V. actual</i>
                                    </a>
                                @endif
                            </div>
                            <div class="col-4">
                                @if($CambiaEdo_ced->url_ciclo > '0')
                                    <b>¿Amerita cambio de versión?</b><br>
                                    <div class="form-check" style="display: inline-block;">
                                        <input wire:model.live="CambiaEdo_version" value='1' @if($CambiaEdo_version=='1') checked @endif class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">Sí</label>
                                    </div>
                                    <div class="form-check"  style="display: inline-block;">
                                        <input wire:model.live="CambiaEdo_version" value='0'  @if($CambiaEdo_version=='0') checked @endif class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">No</label>
                                    </div>
                                @endif
                            </div>
                            <div class="col-2">
                                @if($CambiaEdo_ced->url_doi == '')
                                    <button wire:click="VerNoVerDoi()" class="btn btn-sm btn-secondary">Vincular DOI</button>
                                @else
                                    <button wire:click="BorrarDoi()" wire:confirm="Estás por borrar definitivamente el número DOI de esta cédula y no se va a poder recuperar. ¿Seguro quieres continuar?" class="btn btn-sm btn-secondary">
                                        <i class="bi bi-trash"></i> Eliminar DOI
                                    </button>

                                @endif
                            </div>
                        </div>

                        <!-- Muestra cita -->
                        <div class="row my-3">
                            <div class="col-12">
                                <b>Cita</b>:
                                    <!-- Autores -->
                                    <?php $num='0'; ?>
                                    @foreach ($CambiaEdo_ced->autores as $a)
                                        <?php $num++; ?>
                                        {{ $a->autor->caut_nombreautor }}@if($CambiaEdo_ced->autores->count() > '1' and $num==($CambiaEdo_ced->autores->count() - 1) ) y
                                        @elseif($CambiaEdo_ced->autores->count() > '1' and $num < ($CambiaEdo_ced->autores->count()-1)),
                                        @endif
                                    @endforeach

                                    <!-- Año -->
                                    @if($CambiaEdo_ced->url_ciclo =='0')
                                        <b>{{ date('Y') }}</b>.
                                    @else
                                        <b>{{ $CambiaEdo_ced->url_anio }}</b>.
                                    @endif

                                    <!-- Título -->
                                    <u>{{ $CambiaEdo_ced->url_titulo }}</u>

                                    <!-- Traducción -->
                                    @if($CambiaEdo_ced->url_tradid > '0')
                                        ({{ $CambiaEdo_ced->lenguas->len_lengua }},
                                        @foreach ($CambiaEdo_ced->traductores as $a)
                                            <?php $num++; ?>
                                            {{ $a->autor->caut_nombreautor }}@if($CambiaEdo_ced->traductores->count() > '1' and $num==($CambiaEdo_ced->traductores->count() - 1) ) y
                                            @elseif($CambiaEdo_ced->traductores->count() > '1' and $num < ($CambiaEdo_ced->traductores->count()-1)),
                                            @endif
                                        @endforeach
                                        )
                                    @endif

                                    <!-- Versión -->
                                    @if($CambiaEdo_version=='1')
                                        <b>V.{{ $CambiaEdo_ced->url_version + 0.10}}</b>.
                                    @else
                                        V.{{ $CambiaEdo_ced->url_version }}.
                                    @endif

                                    <!-- url /DOI -->
                                    Cédulas del Jardín en lenguas originarias.
                                    @if($CambiaEdo_ced->url_doi != '')
                                        <a href="{{ $CambiaEdo_ced->url_doi }}" class="nolink">
                                            https://doi.org/{{ $CambiaEdo_ced->url_doi }}
                                        </a>
                                    @else
                                        <a href="{{ url('/') }}/{{ $CambiaEdo_ced->url_cjarsiglas }}/{{ $CambiaEdo_ced->url_url }}" class="nolink">
                                            {{ url('/') }}/{{ $CambiaEdo_ced->url_cjarsiglas }}/{{ $CambiaEdo_ced->url_url }}
                                        </a>
                                    @endif


                            </div>
                        </div>

                        <!-- INGRESAR NUEVO DOI -->
                        @if($verDoi=='1')
                            <div class="row my-3">
                                <div class="col-12">
                                    <div class="alert alert-warning">
                                        <h4>Atención</h4>
                                        Una vez que hayas vinculado un número DOI a la cédula, <b>ya no podrás volver a editarla</b>.<br>
                                        Revisa cuidadosamente toda la cédula antes de publicarla.
                                        <div class="row">
                                            <!-- Nuevo DOI -->
                                            <div class="col-6  my-1 form-group">
                                                <label for="" class="form-label">Ingresa el número DOI:<red>*</red></label>
                                                <input wire:model.live="NvoDoi" id="NvoDoi" class="@error('NvoDoi') is-invalid @enderror form-control" type="text" placeholder="10.1111/jbi.12851">
                                                <div class="form-text">No es necesario incluir los textos: https://doi.org ni doi. Solo escribe a partir del número</div>
                                                @error('NvoDoi')<error>{{ $message }}</error>@enderror
                                            </div>
                                            <div class="col-6" my-1 form-group">
                                                <BR><BR>
                                                @if(strlen($NvoDoi) > '5')
                                                    <button wire:click="RegistrarDoi()" class="btn btn-sm btn-primary">Registrar DOI</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        @endif

                        <!-- muestra metadatos y palabras clave -->
                        <div class="row">
                            <div class="col-12">
                                <b>Palabras clave</b>:
                                @foreach($CambiaEdo_ced->alias as $a)
                                    <div class="elemento">{{ $a->ali_txt_tr }}</div>
                                @endforeach
                            </div>
                            <div class="col-12">
                                <b>Ubicaciones</b>:
                                @foreach($CambiaEdo_ced->ubicaciones as $a)
                                    <div class="elemento">{{ $a->ubi_ubicacion_tr }}</div>
                                @endforeach
                            </div>
                            <div class="col-12">
                                <b>Especies</b>:
                                @if($CambiaEdo_ced->especies->count() == '0')
                                    <i class="bi bi-exclamation-octagon-fill" style="color:#CD7B34"></i> No hay especie registrada
                                @else
                                    @foreach($CambiaEdo_ced->especies as $e)
                                        <div class="elemento">{{ $e->sp_scname }}</div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-12">
                                <b>Usos</b>:
                                @if($CambiaEdo_ced->usos->count() == '0')
                                    <i class="bi bi-exclamation-octagon-fill" style="color:#CD7B34"></i> No hay ningún uso registrado
                                @else
                                    @foreach($CambiaEdo_ced->usos as $u)
                                        <div class="elemento">{{ $u->uso_categoria }}:{{ $u->uso_uso }}</div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Botón final para publicar -->
                    @if($verDoi=='0')
                        <div class="row">where
                            <div class="col-12" style="text-align: center;">
                                <button wire:click="PublicaCedula()" class="btn btn-primary"> Publicar cédula </button>
                            </div>
                        </div>
                    @endif
                @endif
            @endif

        </div>

        <!-- ---------------------------- pie del modal ----------------------------- -->
        <div class="modal-footer">
            <span wire:loading style="display:none;" class="parpadeo"><red>trabajando... espera...</red> </span>
            <button wire:click="CerrarModalDeCambioDeEstado()" class="btn btn-secondary">
                Cancelar
            </button>
            {{-- <button wire:click="GuardaModal()" wire:loading.attr="disabled" class="btn btn-primary">Guardar</button> --}}
        </div>
    </div>
</div>
</div>
<!-- ----------------------------- TERMINA MODAL ROLES DE USUARIO ------------------------- -->
<!-- -------------------------------------------------------------------------------------- -->
<!-- -------------------------------------------------------------------------------------- -->
    <script>
        /* ### Script para abrir y cerrar Modal */
        Livewire.on('AbreModalCambiaEdoCedula', () => {
            $('#Modal_CambioEdoCedula').modal('show');
        });

        Livewire.on('CierraModalCambiaEdoCedula', () => {
            $('#Modal_CambioEdoCedula').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });

        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoCambiaEdoCedula',()=>{
            alert(event.detail.msj);
        });

        /* ### Script para mostrar botón personalizado de input=file */
        // document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
        //     document.getElementById('MiInputFile').click();
        // });

        /* #### Recibe variable desde un componente externo y lo manda a livewire */
        // Livewire.on('RecibeVariables',() => {
        //     @this.set('ModeloWire',event.detail.dato, live=true);
        // });
    </script>

</div>
