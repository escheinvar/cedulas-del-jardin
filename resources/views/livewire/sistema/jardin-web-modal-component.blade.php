<div>

    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- ---------------------------- INICIA MODAL EDICIÓN DE PÁGINA --------------------------- -->
    <div wire:ignore.self class="modal fade" id="ModalParrafoWebJardin" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        @if($modJar_id=='0')
                            Ingresando un nuevo párrafo {{ $modJar_cjarsiglas}}
                        @else
                            Editando párrafo {{ $modJar_id }} de {{ $modJar_cjarsiglas }}
                        @endif
                    </h3>
                    <button wire:click="CierraModalEditaTextoWebJardin()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- ----------------------------  cuerpo del modal --------------------------->
                <div class="modal-body">
                    <div class="row">
                        <!-- orden -->
                        <div class="col-6 col-md-3 form-group">
                            <label for="modJar_orden" class="form-label">Orden</label>
                            <input wire:model="modJar_orden" id="modJar_orden" class="@error('modJar_orden') is-invalid @enderror form-control" type="number">
                            <div class="form-text"></div>
                            @error('modJar_orden')<error>{{ $message }}</error> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <!-- muestra código originarl -->
                        <div class="col-12 form-group my-1">
                            @if($modJar_id >'0')
                                <div onclick="VerYocultar('tex','Orig')" id="entra_texOrig" class="PaClick">
                                    <i class="bi bi-eye"></i>
                                    <b>Ver Texto original</b>
                                </div>

                                <div onclick="VerYocultar('tex','Orig')"  id="sale_texOrig" class="PaClick" style="display: none;">
                                    <div>
                                        <i class="bi bi-eye-slash"></i>
                                        <b>Ocultar Texto original</b>
                                    </div>
                                    <div style=" border:1px solid #CDC6B9;">
                                        {!! $modJar_original !!}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Textarea de código nuevo -->
                        <div class="col-12 form-group" wire:ignore.self>
                            <!-- iconos para escritura-->
                            <div style="margin:7px;">
                                <button onclick="insertarTexto('<p>','</p>')" class="lenguas" title="Párrafo"> <i class="bi bi-text-paragraph"></i>  </button>
                                <button onclick="insertarTexto('<br>','')" class="lenguas" title="Salto de línea"> <i class="bi bi-arrow-return-left"></i>  </button>
                                <button onclick="insertarTexto('<ar>','</ar>')" class="lenguas" title="Línea alta"> <ar>a</ar>  </button>
                                <button onclick="insertarTexto('<b>','</b>')" class="lenguas" title="Negritas"> <b>B</b>    </button>
                                <button onclick="insertarTexto('<u>','</u>')" class="lenguas" title="Subrayado">    <u>u</u>    </button>
                                <button onclick="insertarTexto('<i>','</i>')" class="lenguas" title="Cursivas"> <i>i</i>    </button>
                                <button onclick="insertarTexto('<sub>','</sub>')" class="lenguas" title="Subíndice">    a<sub>s</sub>   </button>
                                <button onclick="insertarTexto('<sup>','</sup>')" class="lenguas" title="Superíndice">  a<sup>s</sup>   </button>
                                <button onclick="insertarTexto('<s>','</s>')" class="lenguas" title="Tachado">  <s>S</s>    </button>
                                &nbsp; | &nbsp;
                                <button onclick="insertarTexto('<span style=&quot;text-align:left;&quot;>','</span>')" class="lenguas" title="Alinear a izquierda">  <i class="bi bi-text-left"></i>    </button>
                                <button onclick="insertarTexto('<span style=&quot;text-align:center;&quot;>','</span>')" class="lenguas" title="Centrar">  <i class="bi bi-text-center"></i>    </button>
                                <button onclick="insertarTexto('<span style=&quot;text-align:right;&quot;>','</span>')" class="lenguas" title="Alinear a derecha">  <i class="bi bi-text-right"></i>    </button>
                                <button onclick="insertarTexto('<ul><li></li>','<li></li></ul>')" class="lenguas" title="Lista">  <i class="bi bi-list-task"></i>    </button>
                                <button onclick="insertarTexto('<ol><li></li>','<li></li></ol>')" class="lenguas" title="Lista">  <i class="bi bi-list-ol"></i>    </button>
                                <button onclick="insertarTexto('<h2>','</h2>')" class="lenguas" title="Titulo">  H2  </button>
                                <button onclick="insertarTexto('<h3>','</h3>')" class="lenguas" title="Título">  H3  </button>
                                <button onclick="insertarTexto('<h4>','</h4>')" class="lenguas" title="Título">  H4  </button>
                                &nbsp; | &nbsp;
                                <button wire:click="AbreModalVerImagenParrafo()" class="lenguas" title="Imágen"> <i class="bi bi-image"></i>   </button>
                                <button onclick="insertarTexto('','')" class="lenguas" title="Video" disabled >  <i class="bi bi-film"></i>    </button>
                                <button onclick="insertarTexto('','')" class="lenguas" title="Audio" disabled >  <i class="bi bi-file-earmark-music"></i> </button>
                                <button onclick="insertarTexto('','')" class="lenguas" title="YouTube" disabled ><i class="bi bi-youtube"></i> </button>

                                <button  wire:click="VerOnoVerCodigoHtml()" class="lenguas" title="ver código" style="@if($VerHtml=='1') background-color:gray; @endif">
                                    <small>html</small>
                                </button>
                            </div>

                            <!-- textarea -->
                            @if($VerHtml=='0')
                                <textarea  rows="5" id="Codigo" wire:model="modJar_txt" class="@error('modJar_txt') is-invalid @enderror form-control"></textarea>
                                <div class="form-text"></div>
                                @error('modJar_txt')<error>{{ $message }}</error>@enderror
                            @else
                                <div class="m-1" style="min-height: 95px; border:1px solid gray;  border-radius:4px;">
                                    {!! $modJar_txt !!}
                                </div>
                            @endif
                        </div>

                        <!-- Archivo de audio -->
                        <div class="row">
                            <div class="col-6 form-group">
                                @if($modJar_Audio == '')
                                    <label for="modJar_NvoAudio" class="form-label">Audio</label>
                                    <input wire:model="modJar_NvoAudio" id="modJar_NvoAudio" class="@error('modJar_NvoAudio') is-invalid @enderror form-control" type="file">
                                    <div class="form-text"></div>
                                    @error('modJar_NvoAudio')<error>{{ $message }}</error>@enderror
                                @else
                                    <audio style="width:90%; display:inline-block;" class="my-2" controls>
                                        <source src="{{ $modJar_Audio }}" type="audio/ogg">
                                        <source src="{{ $modJar_Audio }}" type="audio/mpeg">
                                        Tu navegador no soporta archivos de audio
                                    </audio>
                                    <i wire:click="BorrarAudio()" class="bi bi-trash agregar"></i>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button  wire:click="CierraModalEditaTextoWebJardin()" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                    <button wire:click="GuardarDatos()" class="btn btn-primary"  wire:loading.attr="disabled">Guardar</button>
                    <span wire:loading style="display:none;"> <red> ..guardando...</red> </span>

                </div>
            </div>
        </div>
    </div>
    <!-- ---------------------------- TERMINA MODAL EDICIÓN DE PÁGINA ------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->





    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------- INICIA MODAL VER IMÁGEN PÁRRAFO --------------------------- -->
    <div wire:ignore.self class="modal fade" id="ModalVerImagenParrafo" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Imágenes
                    </h3>
                    <button wire:click="CierraModalVerImagenParrafo()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- ----------------------------  cuerpo del modal --------------------------->
                <div class="modal-body" >
                    <!-- Nueva imágen -->
                    <button wire:click="AbreModalObjeto('0')" class="btn btn-secondary"> <bi class="bi bi-plus-square"></bi> Agregar </button>
                    <!-- muestra imágenes -->
                    <div class="row">
                        <div class="col-12 form-group">
                            @foreach ($img as $o)
                                <div onclick="insertarTexto('<img src=&quot;{{ $o->img_file }}&quot; style=&quot;max-width:200px; max-height:200px;&quot;>','')"
                                    wire:click="CierraModalVerImagenParrafo()"
                                    wire:key="img_{{ $o->img_id }}"
                                    style="max-height:100px; max-width: 100px;  display:inline-block; margin:7px; border:0px solid gray;"
                                    class="PaClick" >
                                    <!-- titulo-->
                                    <div style="font-size:80%;">
                                        <center>{{ $o->img_titulo }}</center>
                                    </div>
                                    <!-- OBJETO IMAGEN -->
                                    @if($o->img_tipo=='img')
                                        <img style="max-width:100%; max-height:100%;" src="{{ $o->img_file }}">

                                    <!-- OBJETO AUDIO -->
                                    @elseif($o->img_tipo=='aud')
                                        <audio style="width:100%;" controls>
                                            <source src="{{ $o->img_file }}" type="audio/ogg">
                                            <source src="{{ $o->img_file }}" type="audio/mpeg">
                                            Tu navegador no soporta archivos de audio
                                        </audio>

                                    <!-- OBJETO VIDEO -->
                                    @elseif($o->img_tipo=='vid')
                                        <video style="width:100%; max-height:200px;" controls>
                                            <source src="{{ $o->img_file }}" type="video/mp4">
                                            <source src="{{ $o->img_file }}" type="video/ogg">
                                            Tu navegador no soporta el video.
                                        </video>
                                    @endif
                                    <!-- pie -->
                                    <div style="font-size:60%">
                                        {{ $o->img_pie }}
                                    </div>
                                    <!-- palabras clave-->
                                    @foreach ($o->alias as $a)
                                        <div style="font-size:60%" class="elemento">
                                            {{ $a->aimg_txt }}
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach

                            @if($img->count() =='0') <br>-- aún no hay objetos --<br> @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button  wire:click="CierraModalVerImagenParrafo()" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>

                    <button wire:click="" class="btn btn-primary">
                        <span wire:loading.attr="disabled"> Guardar </span>
                        <span wire:loading style="display:none;"> <red> ..guardando...</red> </span>
                    </button>

                </div>
            </div>
        </div>
    </div>
    <!-- -------------------------- TERMINA MODAL VER IMÁGEN PÁRRAFO --------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->



    <livewire:Web.ModalImagenController  />

    <script>
        /* ### Script para botones de editor de texto */
        function insertarTexto(antes,despues) {
            // 1. Obtener el elemento textarea
            const textarea = document.getElementById('Codigo');

            // 2. Obtener la posición actual del cursor (inicio y fin de la selección)
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;

            // 3. Obtener el texto que hay antes y después del cursor
            const textoAntes = textarea.value.substring(0, start);
            const textoDespues = textarea.value.substring(end);
            const textoDentro = textarea.value.substring(start,end);
            // console.log(textoAntes, textoDespues, textoDentro)

            // 4. Construir el nuevo valor completo
            // Texto Antes + Texto Numevo + Texto Después
            textarea.value = textoAntes + antes +  textoDentro + despues + textoDespues;

            // 5. (Importante) Restaurar el foco y mover el cursor
            // Movemos el cursor al final del texto que acabamos de insertar
            const nuevaPosicion = start  + antes.length;
            textarea.focus();
            textarea.setSelectionRange(nuevaPosicion, nuevaPosicion);

            // ### Envía variable a wire
            // textarea.dispatchEvent(new Event('modJar_txt'));
            Livewire.dispatch('event-from-js', { codigo: textarea.value });

        }

        /* ### Script para abrir y cerrar modal */
        Livewire.on('AbreModalDeParrafoWebJardin', () => {
            $('#ModalParrafoWebJardin').modal('show');
        });

        Livewire.on('CierraModalDeParrafoWebJardin', () => {
            $('#ModalParrafoWebJardin').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });

        /* ### Script para abrir y cerrar modal */
        Livewire.on('AbreModalDeVerImagenParrafo', () => {
            $('#ModalVerImagenParrafo').modal('show');
        });

        Livewire.on('CierraModalDeVerImagenParrrafo', () => {
            $('#ModalVerImagenParrafo').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });

    </script>
</div>
