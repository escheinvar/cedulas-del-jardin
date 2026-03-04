<div>

    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- ---------------------------- INICIA MODAL AUTORES --------------------------- -->
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

                        <!-- ver o no ver código original -->
                        <div class="col-6 col-md-3 form-group">
                            @if($modJar_id >'0')
                                <b onclick="VerNoVer('tex','Orig')" class="PaClick"> Ver Texto original</b>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <!-- muestra código originarl -->
                        <div class="col-12 form-group">
                            @if($modJar_id >'0')
                                <div id="sale_texOrig" class="row my-2" style="display: none; padding: 3px; margin:0px;">
                                    <div style=" border:1px solid #CDC6B9;">
                                        {!! $modJar_txt !!}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Textarea de código nuevo -->
                        <div class="col-12 form-group">
                            <label for="modJar_txt" class="form-label">Nuevo código</label>
                            {{--<!-- Summernote -->
                                 <div class="my-4" wire:ignore >
                                     <div id="summernote"> Texto en summernote</div>
                                 </div>
                             --}}
                            <textarea wire:model="modJar_txt" class="@error('modJar_txt') is-invalid @enderror form-control">
                            </textarea>
                            <div class="form-text"></div>
                            @error('modJar_txt')<error>{{ $message }}</error>@enderror
                        </div>
                    </div>

                    {{-- <!-- muestra imágenes -->
                    <div class="row">
                        <div class="col-12 form-group">
                            <label class="form-label">Archivos multimedia</label><br>
                            @foreach(['ar1','ar2','ar3','ar4','ar5'] as $a)
                                @if($archs[$a] == null)
                                    <button wire:click="AbreModalObjeto('0')" class="btn btn-secondary btn-sm" wire:key="Imagen{{ $a }}">
                                        <i class="bi bi-image"></i> {{ $a }}
                                    </button>
                                @else
                                    <div style="display:inline-block;" wire:key="Imagen{{ $a }}">
                                        < ?php $imags=$archs[$a]; ?>
                                        @include('plantillas.imagenes')
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button  wire:click="CierraModalEditaTextoWebJardin()" class="btn btn-secondary" data-bs-dismiss="modal">
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

    <livewire:Web.ModalImagenController  />

    <script>
    // /*------------------------------ Script summernote ----------------------- */
    // document.addEventListener('livewire:init', function () {
    //         $('#summernote').summernote({
    //             toolbar: [
    //                 ['style', ['bold', 'italic', 'underline', 'clear']],
    //                 ['font', ['strikethrough', 'superscript', 'subscript']],
    //                 ['fontsize', ['fontsize']],
    //                 ['color', ['color']],
    //                 ['para', ['ul', 'ol', 'paragraph']],
    //                 ['para', ['ul', 'ol']],
    //                 ['height', ['height']],
    //                 ['view', ['fullscreen', 'codeview', 'help']],
    //                 ['table', ['table']],
    //                 ['insert', ['link', 'picture', 'video']],
    //                 ['group', [ 'specialChar' ]],
    //                 // ['mybutton', ['LineaArriba','LineaAbajo','LineaDiagonal','CirculoArriba']]
    //             ],
    //         });
    //     });


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
    </script>
</div>
