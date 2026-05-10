<div>
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- ------------------------------ INICIA MODAL VER OBJETO  ------------------------------ -->
    <div wire:ignore.self class="modal fade" id="ModalVerObjetosPalParrafo" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        Objetos
                    </h3>
                    <button wire:click="CierraModalVerObjetos()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- ----------------------------  cuerpo del modal --------------------------->
                <div class="modal-body">
                    <div class="row">
                        <!-- Buscar nombre -->
                        <div class="col-12 col-md-3  form-group">
                            <label for="modver_buscatxt" class="form-label">Buscar:<red></red></label>
                            <input wire:model.live="modver_buscatxt" id="modver_buscatxt" class="@error('modver_buscatxt') is-invalid @enderror form-control" type="text">
                            <div class="form-text"></div>
                            @error('modver_buscatxt')<error>{{ $message }}</error>@enderror
                        </div>

                        <div class="col-3 form-group">
                            <label for="modver_VerModulo" class="form-label">Tipo de objeto<red></red></label>
                            <select wire:model.live="modver_tipoSelected" class="form-select" @if($modver_tipoRecibido=='1') disabled @endif>>
                                <option value="%"> Todos</option>
                                <option value="img">Imagenes</option>
                                <option value="aud">Audio</option>
                                <option value="vid">Videos</option>
                                <option value="you">Youtube</option>
                                <option value="htm">Código</option>
                            </select>
                        </div>

                        <div class="col-3">
                            <!-- Nueva imágen -->
                            <label for="" class="form-label"> &nbsp; </label><br>
                            <button wire:click="AbrirModalPaIncertarObjeto('0', '{{ $this->modver_modulo }}', 'web', '' ,'0')" class="btn btn-secondary"> <i class="bi bi-plus-square"></i> Nuevo objeto </button>
                        </div>

                    </div>
                    <!-- muestra imágenes -->
                    <div class="row">
                        <div class="col-12 form-group" style="vertical-align: middle;">
                            @foreach ($modver_objetos as $o)
                                <div style="margin:10px; display:inline-block;">
                                    <!-- ---------------- Muestra Imágenes para insertar ------------------------- -->
                                    @if($o->img_tipo =='img')
                                        <div wire:key="img_{{ $o->img_id }}"
                                            style="max-height:100px; max-width: 100px; display:inline-block; margin:7px;"
                                            class="PaClick">
                                            <span onclick="insertarTexto('<a href=&quot;{{ $o->img_file }}&quot; target=&quot;_new&quot;><img src=&quot;{{ $o->img_file }}&quot; style=&quot;max-width:200px; max-height:200px;&quot;>','</a>')" wire:click="CierraModalVerObjetos()">
                                                <!-- titulo-->
                                                <div style="font-size:80%; padding:10px;">
                                                   {{ $o->img_titulo }}
                                                </div>
                                                <i class="bi bi-plus-circle"> Insertar</i>
                                            </span>

                                            <!-- OBJETO IMAGEN -->
                                            <img style="max-width:100%; max-height:100%;" src="{{ $o->img_file }}">

                                            <!-- pie -->
                                            <div style="font-size:60%; width:200px;" onclick="VerNoVerClase('pie','{{ $o->img_id }}','cortaTexto')" id="sale_pie{{ $o->img_id }}" class="cortaTexto">
                                                {{ $o->img_pie }}
                                            </div>
                                    <!-- ---------------- Muestra Audios para insertar ------------------------- -->
                                    @elseif($o->img_tipo =='aud')
                                        <div wire:key="img_{{ $o->img_id }}"
                                            style="max-height:100px; max-width: 100px; display:inline-block; margin:7px;"
                                            class="PaClick">
                                            <span onclick="insertarTexto('<audio class=&quot;web&quot; controls>  <source src=&quot;{{ $o->img_file }}&quot; type=&quot;audio/ogg&quot;>  <source src=&quot;{{ $o->img_file }}&quot; type=&quot;audio/mpeg&quot;> Tu navegador no soporta archivos de audio','</audio>')" wire:click="CierraModalVerObjetos()">
                                                <!-- titulo-->
                                                <div style="font-size:80%;">
                                                    {{ $o->img_titulo }}
                                                </div>
                                                <i class="bi bi-plus-circle"> Insertar</i>
                                            </span>

                                            <!-- OBJETO AUDIO -->
                                            <audio style="width:100%;" controls>
                                                <source src="{{ $o->img_file }}" type="audio/ogg">
                                                <source src="{{ $o->img_file }}" type="audio/mpeg">
                                                Tu navegador no soporta archivos de audio
                                            </audio>

                                            <!-- pie -->
                                            <div style="font-size:60%; width:100px;" onclick="VerNoVerClase('pie','{{ $o->img_id }}','cortaTexto')" id="sale_pie{{ $o->img_id }}" class="cortaTexto">
                                                {{ $o->img_pie }}
                                            </div>

                                        </div>
                                    <!-- ---------------- Muestra Videos para insertar ------------------------- -->
                                    @elseif($o->img_tipo =='vid')
                                        <div wire:key="img_{{ $o->img_id }}"
                                            style="max-height:100px; max-width: 100px; display:inline-block; margin:7px;"
                                            class="PaClick">
                                            <span onclick="insertarTexto('<video style=&quot; max-width:100%; max-height:200px;&quot; controls>  <source src=&quot;{{ $o->img_file }}&quot; type=&quot;video/mp4&quot;>  <source src=&quot;{{ $o->img_file }}&quot; type=&quot;video/ogg&quot;>  Tu navegador no soporta el video.','</video>')" wire:click="CierraModalVerObjetos()">
                                                <!-- titulo-->
                                                <div style="font-size:80%;">
                                                    {{ $o->img_titulo }}
                                                </div>
                                                <i class="bi bi-plus-circle"> Insertar</i>
                                            </span>

                                            <!-- OBJETO VIDEO -->
                                            <video style="width:100%; max-height:200px;" controls>
                                                <source src="{{ $o->img_file }}" type="video/mp4">
                                                <source src="{{ $o->img_file }}" type="video/ogg">
                                                Tu navegador no soporta el video.
                                            </video>

                                            <!-- pie -->
                                            <div style="font-size:60%; width:200px;" onclick="VerNoVerClase('pie','{{ $o->img_id }}','cortaTexto')" id="sale_pie{{ $o->img_id }}" class="cortaTexto">
                                                {{ $o->img_pie }}
                                            </div>
                                        </div>

                                    <!-- ---------------- Muestra liga Youtube para insertar ------------------------- -->
                                    @elseif($o->img_tipo =='you')
                                        <div
                                            wire:key="img_{{ $o->img_id }}"
                                            style="display:inline-block;"
                                            class="PaClick">
                                            <span wire:click="CierraModalVerObjetos()" onclick="insertarTexto('<div class=&quot;ratio ratio-16x9&quot; style=&quot;width:95%;&quot;> <iframe width=&quot;100%;&quot; src=&quot;https://www.youtube.com/embed/{{ $o->img_youtube }}&quot; title=&quot;{{ $o->img_titulo }}&quot; frameborder=&quot;0&quot; allow=&quot;accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share&quot; referrerpolicy=&quot;strict-origin-when-cross-origin&quot; allowfullscreen>','</iframe> </div>')">
                                                <!-- titulo-->
                                                <div style="font-size:80%; width:200px;">
                                                    {{ $o->img_titulo }}
                                                </div>
                                                <i class="bi bi-plus-circle"> Insertar</i>
                                            </span>

                                            <!-- OBJETO VIDEO -->
                                            <div class="ratio ratio-16x9" style="width:200px;">
                                                <iframe
                                                    width="100%;"
                                                    src="https://www.youtube.com/embed/{{ $o->img_youtube }}"
                                                    title="{{ $o->img_titulo }}"
                                                    frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                                                </iframe>
                                            </div>

                                            <!-- pie -->
                                            <div style="font-size:60%; width:200px;" onclick="VerNoVerClase('pie','{{ $o->img_id }}','cortaTexto')" id="sale_pie{{ $o->img_id }}" class="cortaTexto">
                                                {{ $o->img_pie }}
                                            </div>
                                        </div>
                                    <!-- ---------------- Muestra liga insertar código ------------------------- -->
                                    @elseif($o->img_tipo =='htm')
                                        <div wire:key="img_{{ $o->img_id }}"
                                            style="display:inline-block;"
                                            class="PaClick">
                                            <span onclick="insertarTexto('{{ $o->img_html }}','')" wire:click="CierraModalVerObjetos()">
                                                <!-- titulo-->
                                                <div style="font-size:80%;">
                                                    {{ $o->img_titulo }}
                                                </div>
                                                <i class="bi bi-plus-circle"> Insertar</i>
                                            </span>

                                            <!-- OBJETO VIDEO -->
                                            <div class="" style="width:200px;border:1px solid gray;padding:5px;border-radius:3px;">
                                                {!! $o->img_html !!}"
                                            </div>

                                            <!-- pie -->
                                            <div style="font-size:60%; width:200px;" onclick="VerNoVerClase('pie','{{ $o->img_id }}','cortaTexto')" id="sale_pie{{ $o->img_id }}" class="cortaTexto">
                                                {{ $o->img_pie }}
                                            </div>
                                    @endif
                                </div>
                            @endforeach
                            @if($modver_objetos->count() =='0') <br>-- aún no hay objetos --<br> @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button  wire:click="CierraModalVerObjetos()" class="btn btn-secondary" data-bs-dismiss="modal">
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
    <!-- ------------------------------ TERMINA MODAL VER OBJETOS ------------------------------ -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->

{{-- <livewire:sistema.modal-inserta-objeto-component /> --}}



    <script>
        /* ### Script para abrir y cerrar modal */
        Livewire.on('AbreModalDeVerObjetos', () => {
            $('#ModalVerObjetosPalParrafo').modal('show');
        });

        Livewire.on('CierraModalDeVerObjetos', () => {
            $('#ModalVerObjetosPalParrafo').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });
        /*#### Recibe variable desde un componente externo y lo manda a livewire */
        Livewire.on('RecibeVariables',() => {
           @this.set('modver_objetos',event.detail.dato, live=true);
        });

    </script>
</div>
