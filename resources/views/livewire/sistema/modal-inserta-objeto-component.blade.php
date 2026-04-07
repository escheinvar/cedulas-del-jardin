<div>
    <!-- ---------------------- MODAL PARA IMÁGENES ---------------------- -->
    <!-- recibe variables idImg (id de img ó 0) e modImg (módulo a cargar) -->
    <div wire:ignore.self class="modal fade" id="ModalIncertaObjeto" tabindex="-1" role="dialog" style="z-index:3000">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Título -->
                    @if($Imgmod_id=='0')
                        <h5 class="modal-title">Cargando nuevo objeto</h5>
                    @else
                        <h5 class="modal-title">Editando objeto {{ $Imgmod_id }} </h5>
                    @endif
                    <button wire:click="CerrarModalIncertaObjeto()" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @if($Imgmod_id == '0')
                    <!-- Si es imagen nueva, pregunta el tipo de archivo -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-check" style="display:inline-block">
                                    <label class="form-check-label" for="flexRadioDefault1">Archivo</label>
                                    <input wire:model.live="Imgmod_tipoobjeto" value="archivo" @if($Imgmod_tipoobjeto=='arch') checked @endif wire:change="LimpiarModalIncertaObjeto()"  class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                </div>
                                <div class="form-check" style="display:inline-block">
                                    <label class="form-check-label" for="flexRadioDefault2">Youtube</label>
                                    <input wire:model.live="Imgmod_tipoobjeto" value="youtube" @if($Imgmod_tipoobjeto=='yout') checked @endif wire:change="LimpiarModalIncertaObjeto()"  class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                </div>
                                <div class="form-check" style="display:inline-block">
                                    <label class="form-check-label"vo for="flexRadioDefault2">Embeber código</label>
                                    <input wire:model.live="Imgmod_tipoobjeto" value="codigo"  @if($Imgmod_tipoobjeto=='html') checked @endif wire:change="LimpiarModalIncertaObjeto()" class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                </div>
                            </div>
                        </div>

                        <!-- ---------- Solicita la carga del archivo o código ----------- -->
                        <div class="row">
                            @if($Imgmod_tipoobjeto!='')
                                <div class="col-9  my-1 form-group">
                                    @if($Imgmod_tipoobjeto=='archivo')
                                    <!-- Carga nuevo archivo -->
                                        <label for="Imgmod_nvoobj" class="form-label">Carga el archivo<red></red></label>
                                        <input wire:model.defer="Imgmod_nvoobj" wire:click="LimpiarModalIncertaObjeto()" id="Imgmod_nvoobj" class="@error('Imgmod_nvoobj') is-invalid @enderror form-control" type="file">
                                        <div class="form-text">Selecciona el archivo a subir (imagen, audio o video)</div>
                                        @error('Imgmod_nvoobj')<error>{{ $message }}</error>@enderror


                                    @elseif($Imgmod_tipoobjeto=='youtube')
                                        <!-- Carga nuevo youtube -->

                                        <label for="Imgmod_nvoobj" class="form-label">Indica la clave del video:<red></red></label>
                                        <input wire:model="Imgmod_nvoobj" id="Imgmod_nvoobj" class="@error('Imgmod_nvoobj') is-invalid @enderror form-control" type="text">
                                        <div class="form-text">Texto url entre los símbolos '=' y '&' (.../watch?v<b>=</b><span style="color:#CD7B34;">RpbjMcAqKzY</span><b>&</b>t=5s...)</div>
                                        @error('Imgmod_nvoobj')<error>{{ $message }}</error>@enderror

                                    @elseif($Imgmod_tipoobjeto=='codigo')
                                        <!-- Carga nuevo código -->

                                        <label for="Imgmod_nvoobj" class="form-label">Código para embeber:<red></red></label>
                                        <textarea wire:model="Imgmod_nvoobj" id="Imgmod_nvoobj" class="@error('Imgmod_nvoobj') is-invalid @enderror form-control"></textarea>
                                        <div class="form-text">Copia el código para embeber</div>
                                        @error('Imgmod_nvoobj')<error>{{ $message }}</error>@enderror
                                    @endif
                                </div>

                                @if($Imgmod_tipoobjeto!='')
                                    <div class="col-3">
                                        <br><br>
                                        <button wire:click="LeerObjeto()" class="btn btn-primary"> Revisar</button>
                                    </div>
                                @endif
                            @endif
                        </div>
                    @endif

                    <!-- ------------ Sección de mostrar objeto y datos ------------------------- -->
                    @if($Imgmod_verobjeto == '1')
                        <div class="row my-3">
                            <div class="col-7">
                                <!-- muestra el objeto -->
                                <center>
                                    <!-- ----------- Ver Imagen -------------- -->
                                    @if($Imgmod_tipo =='img')
                                        <img src="{{ $Imgmod_file }}" style="max-height:150px; max-width:70%; border:1px solid black;">

                                    <!-- ----------- Ver Video -------------- -->
                                    @elseif($Imgmod_tipo=='vid')
                                        <video style=" max-height:200px;" controls>
                                            <source src="{{ $Imgmod_file }}" type="video/mp4" style="border:1px solid black;">
                                            <source src="{{ $Imgmod_file }}" type="video/ogg" style="border:1px solid black;">
                                            Tu navegador no soporta el video.
                                        </video>

                                    <!-- ----------- Escuchar Audio -------------- -->
                                    @elseif($Imgmod_tipo=='aud')
                                        <i class="bi bi-volume-up-fill" style="font-size: 150%;"></i>
                                        <audio controls>
                                            <source src="{{ $Imgmod_file }}" type="audio/ogg" style="border:1px solid black;">
                                            <source src="{{ $Imgmod_file }}" type="audio/mpeg" style="border:1px solid black;">
                                            Tu navegador no soporta archivos de audio
                                        </audio>

                                    @elseif($Imgmod_tipo == 'you')
                                        <div class="ratio ratio-16x9">
                                            <iframe
                                                width="100%"
                                                src="https://www.youtube.com/embed/{{ $Imgmod_nvoobj }}"
                                                title="{{ $Imgmod_nvoobj }}"
                                                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                            </iframe>
                                        </div>

                                    @elseif($Imgmod_tipo == 'htm')
                                        {!! $Imgmod_nvoobj !!}

                                    @elseif($Imgmod_tipo == 'otro')
                                        <i class="bi bi-file-earmark-medical" style="font-size: 150%;"></i>
                                        -- otro tipo --
                                    @endif
                                </center>
                            </div>

                            <!-- muestra metadatos del objeto -->
                            <div class="col-5" style="font-size: 80%; vertical-align:bottom; color:rgb(88, 88, 88)">
                                <div><b>Id</b>: @if($Imgmod_id=='0') Por asignar @else {{ $Imgmod_id }} @endif</div>
                                <div><b>Jardín@url</b>: {{ $Imgmod_key }}</div>
                                <div><b>Objeto</b>: {{ $Imgmod_tipo }}</div>
                                <div>@if($Imgmod_size > 20) <error>@endif <b>Tamaño</b>: {{ $Imgmod_size }} MB </error></div>
                                <div><b>Módulo</b>: {{ $Imgmod_cimgmodulo }} - {{ $Imgmod_cimgtipo }} </div>
                                <div><b>Url</b>: @if($Imgmod_key != '') {{ $Imgmod_key }} @else --- @endif</div>
                                <div><b>Resol x,y</b>: {{ $Imgmod_resolu }} px</div>
                            </div>
                        </div>

                        <!-- ------------ Muestra cuestionario ------------------------- -->
                        <div class="row my-3">
                            <!-- titulo -->
                            <div class="col-6 form-group">
                                <label for="Imgmod_titulo" class="form-label">Título del objeto<red>*</red></label>
                                <input wire:model="Imgmod_titulo" id="Imgmod_titulo" class="@error('Imgmod_titulo') is-invalid @enderror form-control" type="text" >
                                <div class="form-text"></div>
                                @error('Imgmo   d_titulo')<error>{{ $message }}@enderror
                            </div>

                            <div class="col-6 form-check">
                                <!-- forzar título -->
                                <input wire:model="Imgmod_tituloact" class="form-check-input" type="checkbox" value="" id="forzar">
                                <label class="form-check-label" for="forzar">Forzar título   </label>
                                <div class="form-text"></div>

                                <!-- inactivar imagen -->
                                <input wire:model.live="Imgmod_act" class="form-check-input" type="checkbox" value="" id="forzar">
                                <label class="form-check-label" for="forzar">Inactivar imagen   </label>
                                {{-- <div class="form-text"> @if($Imgmod_act==TRUE)<error>La imagen no es visible</error> @endif </div> --}}
                            </div>

                            <!-- autor -->
                            <div class="col-6 form-group">
                                <label for="Imgmod_autor" class="form-label">Autor del objeto<red>*</red></label>
                                <input wire:model="Imgmod_autor" id="Imgmod_autor" class="@error('Imgmod_autor') is-invalid @enderror form-control" type="text">
                                <div class="form-text"></div>
                                @error('Imgmod_autor')<error>{{ $message }}@enderror
                            </div>

                            <!-- fecha -->
                            <div class="col-6 form-group">
                                <label for="Imgmod_fecha" class="form-label">Fecha</label>
                                <input wire:model="Imgmod_fecha" id="Imgmod_fecha" class="@error('Imgmod_fecha') is-invalid @enderror form-control" type="date">
                                <div class="form-text"></div>
                                @error('Imgmod_fecha')<error>{{ $message }}@enderror
                            </div>

                            <!-- explicación de pie de figura -->
                            <div class="col-12 form-group">
                                <label for="Imgmod_pie" class="form-label">Pie de figura</label>
                                <textarea wire:model="Imgmod_pie" id="Imgmod_pie" class="@error('Imgmod_pie') is-invalid @enderror form-control" ></textarea>
                                <div class="form-text"></div>
                                @error('Imgmod_pie')<error>{{ $message }}@enderror
                            </div>

                            <!-- ubicación -->
                            <div class="col-12 col-md-4 form-group">
                                <label for="Imgmod_ubica" class="form-label">Ubicación del objeto</label>
                                <input wire:model="Imgmod_ubica" id="Imgmod_ubica" class="@error('Imgmod_ubica') is-invalid @enderror form-control" type="text">
                                <div class="form-text"></div>
                                @error('Imgmod_ubica')<error>{{ $message }}@enderror
                            </div>

                            <!-- longitud y -->
                            <div class="col-12 col-md-4 form-group">
                                <label for="Imgmod_laty" class="form-label">Latitud (Y)</label>
                                <input wire:model="Imgmod_laty" id="Imgmod_laty" class="@error('Imgmod_laty') is-invalid @enderror form-control" type="number">
                                <div class="form-text"></div>
                                @error('Imgmod_laty')<error>{{ $message }}@enderror
                            </div>

                            <!-- latitud x -->
                            <div class="col-12 col-md-4 form-group">
                                <label for="Imgmod_lonx" class="form-label">Longitud (X)</label>
                                <input wire:model="Imgmod_lonx" id="Imgmod_lonx" class="@error('Imgmod_lonx') is-invalid @enderror form-control" type="number">
                                <div class="form-text"></div>
                                @error('Imgmod_lonx')<error>{{ $message }}@enderror
                            </div>

                            <!-- alias o paslabras clave -->
                            <div class="col-12 form-group">
                                <label for="" class="form-label">Palabras clave</label><br>
                                <input wire:model.live="Imgmod_NvoAlias" type="text" class="form-control sm agregar" style="width:30%;">

                                <!-- alias para registrados (id > 0) -->
                                @if($Imgmod_id != '0')
                                    <i wire:click="AgregarAlias()" class="bi bi-plus-square-fill agregar"></i>
                                    @foreach ($Imgmod_alias as $a)
                                        <div class="elemento">
                                            {{ $a->aimg_txt }} <i wire:click="BorrarAlias('{{ $a->aimg_id }}','')" wire:confirm="Vas a eliminar este alias de la imagen. ¿Deseas continuar?" class="bi bi-trash agregar"></i>
                                        </div>
                                    @endforeach

                                <!-- alias para nuevos  (id=0)-->
                                @else
                                    <i wire:click="AgregarAlias()" class="bi bi-plus-square-fill agregar"></i>
                                    @foreach ($Imgmod_alias as $a)
                                        <div class="elemento">
                                            {{ $a }} <i wire:click="BorrarAlias('{{ $a }}')" wire:confirm="Vas a eliminar este alias de la imagen. ¿Deseas continuar?" class="bi bi-trash agregar"></i>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- inactivar imagen -->
                            {{-- <div class="col-6 form-check">
                                <br>
                                <input wire:model.live="Imgmod_act" class="form-check-input" type="checkbox" value="" id="forzar">
                                <label class="form-check-label" for="forzar">Inactivar imagen   </label>
                                <div class="form-text"> @if($Imgmod_act==TRUE)<error>La imagen no es visible</error> @endif </div>
                            </div> --}}

                            {{-- <!-- Borrar imagen -->
                            <div class="col-6 form-check">
                                @if($ImgId != '0')
                                    <br>
                                    <i wire:click="BorrarObjeto()" wire:confirm="Estás por eliminar esta imagen y NO SE VA A PODER RECUPERAR. ¿Quieres continuar?" class="bi bi-trash agregar"> Eliminar imagen permanentemente</i>
                                @endif
                            </div> --}}
                        </div>


                        <div class="col-12 my-2" style="color: gray;">
                            <!-- muestra en cuantas imagenes aparece -->
                            {{-- @if($ImgId != '0' and $apariciones->count() > 0)
                                Se usa {{ $apariciones->count() }} veces:
                                @foreach ($apariciones as $a)  {{ $a->url->urlj_cjarsiglas }}:{{ $a->url->urlj_url }}, @endforeach

                            @elseif($ImgId != '0' and $apariciones->count()=='0')
                                <div class="my-2" style="">
                                    <i wire:click="BorrarObjeto()" wire:confirm="Estás por eliminar esta imagen y NO SE VA A PODER RECUPERAR. ¿Quieres continuar?" class="bi bi-trash agregar"> Eliminar imagen</i>
                                </div>
                            @endif --}}
                        </div>




                    @endif
                </div>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-12">
                            <button wire:click="CerrarModalIncertaObjeto()" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button class="btn btn-primary" wire:click="GuardarDatos()" @if($Imgmod_verobjeto=='0') disabled style="color:gray;" @endif> Guardar </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- ----------------------------- TERMINA MODAL ROLES DE USUARIO ------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <script>
        /* ### Script para abrir y cerrar Modal */
        Livewire.on('AbreModalIncertaObjeto', () => {
            $('#ModalIncertaObjeto').modal('show');
        });
        Livewire.on('CierraModalIncertaObjeto', () => {
            $('#ModalIncertaObjeto').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });

        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoIncertaObjeto',()=>{
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
        Livewire.on('RecargarPagina',() => {
            location.reload();
            // window.location.href;
        });
    </script>

</div>
