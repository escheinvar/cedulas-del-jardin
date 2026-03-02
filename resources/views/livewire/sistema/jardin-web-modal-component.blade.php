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
                            Ingresando un nuevo párrafo
                        @else
                            Editando párrafo
                        @endif
                    </h3>
                    <button wire:click="CierraModalEditaTextoWebJardin()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- ----------------------------  cuerpo del modal --------------------------->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 col-md-3 form-group">
                            <label for="modJar_orden" class="form-label">Orden</label>
                            <input wire:model="modJar_orden" id="modJar_orden" class="@error('modJar_orden') is-invalid @enderror form-control" type="number">
                            <div class="form-text"></div>
                            @error('modJar_orden')<error>{{ $message }}</error> @enderror
                        </div>
                        <div class="col-6 col-md-3 form-group">
                            @if($modJar_id >'0')
                                <b onclick="VerNoVer('tex','Orig')" class="PaClick"> Ver Texto original</b>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 form-group">
                            @if($modJar_id >'0')
                                <div id="sale_texOrig" class="row my-2" style="display: none; padding: 3px; margin:0px;">
                                    <div style=" border:1px solid #CDC6B9;">
                                        {!! $modJar_txt !!}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Summernote -->
                       {{-- <div class="col-12 form-group">
                            <div class="my-4" wire:ignore >
                                <div id="summernote"> Texto en summernote</div>
                            </div>
                        </div> --}}

                        <!-- Textarea de código -->
                        <div class="col-12 form-group">
                            <label for="modJar_txt" class="form-label">Nuevo código</label>
                            <textarea wire:model="modJar_txt" class="@error('modJar_txt') is-invalid @enderror form-control">
                            </textarea>
                        </div>
                    </div>
                    <div class="row">
                        @if(count($archs) > '0')
                            @foreach ($archs as $i)
                                <!-- ----------------------- muestra ------------------- -->
                                @if(preg_match('/.jpg$|.jpeg$|.png$|.jpeg\/jfif$|.exif$|.tif$|.gif$|.bmp$/i',$i))
                                    <div class="col-6 col-md-4">
                                        <div style=>{{ $i }}</div>
                                        <img src="{{ $i }}"
                                    </div>

                                @elseif(preg_match('/.ogg$|.mp3$|.acc$|.wma$|.flac$|.alac$|.wav$|.aiff$/i',$i))
                                    {{ $i }} es audio<br>

                                @elseif(preg_match('/.mp4$|.mov$|.avi$|.wmv$|.mkv$/i',$i))
                                    {{ $i }} es video<br>

                                @else
                                    {{ $i }} es otro<br>
                                @endif


                            @endforeach
                        @endif
                    </div>
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

{{-- @push('scripts')
    <script>
        $('#description').summernote({
            placeholder: 'hola',
            tabsize: 2,
            height: 100
        });
    </script>
@endpush --}}
<script>
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
