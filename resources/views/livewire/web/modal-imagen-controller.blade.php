<div>
    <!-- ---------------------- MODAL PARA IMÁGENES ---------------------- -->
    <!-- recibe variables idImg (id de img ó 0) e modImg (módulo a cargar) -->
    <div wire:ignore.self class="modal fade" id="ModalDeImagen" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Título -->
                    @if($ImgId=='0')
                        <h5 class="modal-title">Cargando nuevo objeto</h5>
                    @else
                        <h5 class="modal-title">Editando objeto {{ $ImgId }} </h5>
                    @endif
                    <button wire:click="CerrarModalImg()" type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    @if($ImgMod_file != '')
                        <!-- Muestra imagen -->
                        <div class="row">
                            <div class="col-8">
                                <center>

                                    <!-- ----------- Ver Imagen -------------- -->
                                    @if($ImgMod_tipo =='img')
                                        <img src="{{ $ImgMod_file }}" style="max-height:200px; max-width:100%; border:1px solid black;">

                                    <!-- ----------- Ver Video -------------- -->
                                    @elseif($ImgMod_tipo=='vid')
                                        <video style=" max-height:200px;" controls>
                                            <source src="{{ $ImgMod_file }}" type="video/mp4" style="border:1px solid black;">
                                            <source src="{{ $ImgMod_file }}" type="video/ogg" style="border:1px solid black;">
                                            Tu navegador no soporta el video.
                                        </video>

                                    <!-- ----------- Escuchar Audio -------------- -->
                                    @elseif($ImgMod_tipo=='aud')
                                        <i class="bi bi-volume-up-fill" style="font-size: 150%;"></i>
                                        <audio controls>
                                            <source src="{{ $ImgMod_file }}" type="audio/ogg" style="border:1px solid black;">
                                            <source src="{{ $ImgMod_file }}" type="audio/mpeg" style="border:1px solid black;">
                                            Tu navegador no soporta archivos de audio
                                        </audio>

                                    @elseif($ImgMod_tipo == 'tau')
                                        -- audio embebido --

                                    @elseif($ImgMod_tipo == 'yut')

                                        -- embeber youtube --
                                    @elseif($ImgMod_tipo == 'otro')
                                        <i class="bi bi-file-earmark-medical" style="font-size: 150%;"></i>
                                        -- otro tipo --
                                    @endif
                                    {{-- <i class="bi bi-trash agregar"></i> --}}

                                </center>
                            </div>
                        {{-- </div>


                        <!-- Muestra metadatos del objeto -->
                        <div class="row"> --}}
                            <div class="col-4" style="font-size: 80%; vertical-align:bottom; color:rgb(88, 88, 88)">
                                <div><b>Id</b>: @if($ImgId=='0') Por asignar @else {{ $ImgId }} @endif</div>
                                <div><b>Objeto</b>: {{ $ImgMod_tipo }}</div>
                                <div>@if($ImgMod_fileSize > 20) <error>@endif <b>Tamaño</b>: {{ $ImgMod_fileSize }} MB </error></div>
                                <div><b>Jardín</b>: {{ $ImgMod_jardin }}</div>
                                <div><b>Módulo</b>: {{ $ImgMod_modulo }} - {{ $ImgMod_tipomod }} </div>
                                <div><b>Url</b>: @if($ImgMod_url != '') {{ $ImgMod_url }} @else --- @endif</div>
                                <div><b>Lengua</b>: @if($ImgMod_lengua != '') {{ $ImgMod_lengua }} @else --- @endif</div>
                                {{-- <div><b>Resol x,y</b>: @if($ImgId=='0){{ round($ImgMod_resol['x'],3) }},{{ $ImgMod_resol['y'] }} px @else {{ $ImgMod_resol }} px @endif</div> --}}
                                <div><b>Resol x,y</b>: {{ $ImgMod_resol }} px</div>
                            </div>
                        </div>
                    @endif

                    @if($ImgMod_file=='' OR $ImgId=='0')
                        <div class="row">
                            <!-- Carga nuevo Objeto -->
                            <div class="col-12 form-group">
                                @if($ImgMod_file == '')
                                    <label for="ImgMod_Nvofile" class="form-label">Cargar objeto {{ $ImgId }}<red>*</red> </label>
                                @endif
                                <input wire:model="ImgMod_Nvofile" id="ImgMod_Nvofile" class="@error('ImgMod_Nvofile') is-invalid @enderror form-control" type="file">
                                <div class="form-text">Selecciona el archivo a subir (imagen, audio o video)</div>
                                @error('Im  gMod_Nvofile')<error>{{ $message }}@enderror
                            </div>
                        </div>
                    @endif


                    @if($ImgMod_file != '')
                        <div class="row">
                            <!-- titulo -->
                            <div class="col-6 form-group">
                                <label for="ImgMod_titulo" class="form-label">Título del objeto<red>*</red></label>
                                <input wire:model="ImgMod_titulo" id="ImgMod_titulo" class="@error('ImgMod_titulo') is-invalid @enderror form-control" type="text" >
                                <div class="form-text"></div>
                                @error('ImgMod_titulo')<error>{{ $message }}@enderror
                            </div>

                            <!-- forzar título -->
                            <div class="col-6 form-check">

                                <input wire:model="ImgMod_tituloact" class="form-check-input" type="checkbox" value="" id="forzar">
                                <label class="form-check-label" for="forzar">Forzar título   </label>
                                <div class="form-text"></div>
                                <!-- inactivar imagen -->

                                <input wire:model.live="ImgMod_act" class="form-check-input" type="checkbox" value="" id="forzar">
                                <label class="form-check-label" for="forzar">Inactivar imagen   </label>
                                <div class="form-text"> @if($ImgMod_act==TRUE)<error>La imagen no es visible</error> @endif </div>

                            </div>

                            <!-- autor -->
                            <div class="col-6 form-group">
                                <label for="ImgMod_autor" class="form-label">Autor del objeto<red>*</red></label>
                                <input wire:model="ImgMod_autor" id="ImgMod_autor" class="@error('ImgMod_autor') is-invalid @enderror form-control" type="text">
                                <div class="form-text"></div>
                                @error('ImgMod_autor')<error>{{ $message }}@enderror
                            </div>

                            <!-- fecha -->
                            <div class="col-6 form-group">
                                <label for="ImgMod_fecha" class="form-label">Fecha</label>
                                <input wire:model="ImgMod_fecha" id="ImgMod_fecha" class="@error('ImgMod_fecha') is-invalid @enderror form-control" type="date">
                                <div class="form-text"></div>
                                @error('ImgMod_fecha')<error>{{ $message }}@enderror
                            </div>

                            <!-- explicación de pie de figura -->
                            <div class="col-12 form-group">
                                <label for="ImgMod_pie" class="form-label">Pie de figura</label>
                                <textarea wire:model="ImgMod_pie" id="ImgMod_pie" class="@error('ImgMod_pie') is-invalid @enderror form-control" ></textarea>
                                <div class="form-text"></div>
                                @error('ImgMod_pie')<error>{{ $message }}@enderror
                            </div>

                            <!-- ubicación -->
                            <div class="col-12 col-md-4 form-group">
                                <label for="ImgMod_ubica" class="form-label">Ubicación del objeto</label>
                                <input wire:model="ImgMod_ubica" id="ImgMod_ubica" class="@error('ImgMod_ubica') is-invalid @enderror form-control" type="text">
                                <div class="form-text"></div>
                                @error('ImgMod_ubica')<error>{{ $message }}@enderror
                            </div>

                            <!-- longitud y -->
                            <div class="col-12 col-md-4 form-group">
                                <label for="ImgMod_laty" class="form-label">Latitud (Y)</label>
                                <input wire:model="ImgMod_laty" id="ImgMod_laty" class="@error('ImgMod_laty') is-invalid @enderror form-control" type="number">
                                <div class="form-text"></div>
                                @error('ImgMod_laty')<error>{{ $message }}@enderror
                            </div>

                            <!-- latitud x -->
                            <div class="col-12 col-md-4 form-group">
                                <label for="ImgMod_lonx" class="form-label">Longitud (X)</label>
                                <input wire:model="ImgMod_lonx" id="ImgMod_lonx" class="@error('ImgMod_lonx') is-invalid @enderror form-control" type="number">
                                <div class="form-text"></div>
                                @error('ImgMod_lonx')<error>{{ $message }}@enderror
                            </div>

                            <!-- alias o paslabras clave -->
                            <div class="col-12 form-group">
                                <label for="" class="form-label">Palabras clave</label><br>
                                <input wire:model.live="ImgMod_NvoAlias" type="text" class="form-control sm agregar" style="width:30%;">
                                <!-- alias para registrados -->
                                @if($ImgId != '0')
                                    <i wire:click="AgregarAlias()" class="bi bi-plus-square-fill agregar"></i>
                                    @foreach ($ImgModalias as $a)
                                        <div class="elemento">
                                            {{ $a->aimg_txt }} <i wire:click="BorrarAlias('{{ $a->aimg_id }}')" wire:confirm="Vas a eliminar este alias de la imagen. ¿Deseas continuar?" class="bi bi-trash agregar"></i>
                                        </div>
                                    @endforeach

                                <!-- alias para nuevos -->
                                @else
                                    <i wire:click="AgregarAliasConIdNuevo()" class="bi bi-plus-square-fill agregar"></i>
                                    @foreach ($ImgModaliasNvo as $a)
                                        <div class="elemento">
                                            {{ $a }} <i wire:click="BorrarAliasConIdNuevo('{{ $a }}')" wire:confirm="Vas a eliminar este alias de la imagen. ¿Deseas continuar?" class="bi bi-trash agregar"></i>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- inactivar imagen -->
                            {{-- <div class="col-6 form-check">
                                <br>
                                <input wire:model.live="ImgMod_act" class="form-check-input" type="checkbox" value="" id="forzar">
                                <label class="form-check-label" for="forzar">Inactivar imagen   </label>
                                <div class="form-text"> @if($ImgMod_act==TRUE)<error>La imagen no es visible</error> @endif </div>
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
                            @if($ImgId != '0' and $apariciones->count() > 0)
                                Se usa {{ $apariciones->count() }} veces:
                                @foreach ($apariciones as $a)  {{ $a->url->urlj_cjarsiglas }}:{{ $a->url->urlj_url }}, @endforeach

                            @elseif($ImgId != '0' and $apariciones->count()=='0')
                                <div class="my-2" style="">
                                    <i wire:click="BorrarObjeto()" wire:confirm="Estás por eliminar esta imagen y NO SE VA A PODER RECUPERAR. ¿Quieres continuar?" class="bi bi-trash agregar"> Eliminar imagen</i>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-12">
                            <button wire:click="CerrarModalImg()" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            @if($ImgMod_file != '')
                                <button class="btn btn-primary" wire:click="GuardarObjeto()"> Guardar </button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        Livewire.on('abreModalDeImagen',()=>{
            $('#ModalDeImagen').modal('show'); // Abre modal
            // const ImgId = event.detail.ImgId; // Envía variable ImgId
            // @this.set('ImgId',ImgId, live=true);
            // @this.set('tipo1',ImgTipo, live=true);
        })

        Livewire.on('cierraModalDeImagen',()=>{
            $('#ModalDeImagen').modal('hide');

            console.log('fin', event.detail.IDreturn)

            if(event.detail.reload == '1'){
                window.location.reload();
            }

            if(event.detail.IDreturn != '0'){
                console.log('f', event.detail.IDreturn);
            }
        })

        Livewire.on('AlertaDeImagen',()=>{
            alert(event.detail.msj);
        })

    </script>

</div>
