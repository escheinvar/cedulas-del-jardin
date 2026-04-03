<!--#############################################################################
    Vista que recibe un Imagenes::get() y muestra cada una de las imagenes, videos
    o audios y que al picarlos, muestra sus metadatos. Diseñado para mostrar
    objetos en las áreas principales de las cédulas.
    Cuando no se recibe ruta de archivo (img_file=='') muestra un botón para colocar
    un nuevo objeto en la posición indicada en $TipoObjeto.

    Requiere métodos: AbreModalObjeto() y EliminaImagen()
    {ver su definición en livewire/web/cedulas-controller}

    Requiere variables:
        $objetos=Imagenes::get(), TipoObjeto="img_cimgtipo" y $edit='0'

    Se invoca como:
        @ include('plantillas.cedulaImagenPlantilla',['objetos'=>$objsPpal,'TipoDeObjeto'=>'ppal1'])
    ############################################################################# -->
<!-- ------------------INICIA IMÁGEN ------------------------ -->
@if(!isset($objetos))
    <div class="alert alert-danger" role="alert">
        @if(!isset($objetos))¡No se definió el objeto! @endif
    </div>
@else
    @foreach ($objetos as $objeto)
        <div wire:key="objetoCed_{{ $objeto->img_id }}">
            <!-- Muestra título -->
            @if($objeto->img_tituloact=='1')
                <div style="font-weight: 900;">{{ $objeto->img_titulo }}</div>
            @endif
            <!-- muestra objeto -->
            @if($objeto->img_tipo=='img')
                <!-- imprime imagen -->
                <img style="display:flex;width:100%;" class="img-fluid PaClick" src="{{ $objeto->img_file }}" onclick="VerNoVer('foto','{{ $objeto->img_id }}')">

            @elseif($objeto->img_tipo=='vid')
                <!-- imprime video -->
                <video style="width:100%; max-height:200px;" controls>
                    <source src="{{ $objeto->img_file }}" type="video/mp4">
                    <source src="{{ $objeto->img_file }}" type="video/ogg">
                    Tu navegador no soporta el video.
                </video>
                <i onclick="VerYocultar('foto','{{ $objeto->img_id }}')" id="entra_foto{{ $objeto->img_id }}" class="bi bi-box-arrow-in-down-right agregar" style="color:#87796d;float: right;"></i>
                {{-- <i onclick="VerNoVer('foto','{{ $objeto->img_id }}')" class="bi bi-box-arrow-in-down-right" style="color:#87796d;"></i> --}}
            @elseif($objeto->img_tipo=='aud')
                <!-- imprime audio -->
                <div class="" style="margin-top:40px;">
                    {{-- @if($objeto->img_titulo != '') <b>{{ $objeto->img_titulo }}</b><br>@endif --}}
                    <audio style="width:100%;" controls>
                        <source src="{{ $objeto->img_file }}" type="audio/ogg">
                        <source src="{{ $objeto->img_file }}" type="audio/mpeg">
                        Tu navegador no soporta archivos de audio
                    </audio>
                    <i onclick="VerYocultar('foto','{{ $objeto->img_id }}')" id="entra_foto{{ $objeto->img_id }}" class="bi bi-box-arrow-in-down-right agregar" style="color:#87796d;float: right;"></i>
                </div>
            @elseif($objeto->img_tipo=='you')
                <!-- imprime youtube -->
                <div class="ratio ratio-16x9">
                    <iframe
                        width="100%"
                        src="https://www.youtube.com/embed/{{ $objeto->img_youtube }}"
                        title="{{ $objeto->img_titulo }}"
                        frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                    </iframe>
                </div>
                <i onclick="VerYocultar('foto','{{ $objeto->img_id }}')" id="entra_foto{{ $objeto->img_id }}" class="bi bi-box-arrow-in-down-right agregar" style="color:#87796d;float: right;"></i>
            @elseif($objeto->img_tipo=='htm')
                <!-- imprime el Html -->
                <div>
                    {!! $objeto->img_html !!}
                    <i onclick="VerYocultar('foto','{{ $objeto->img_id }}')" id="entra_foto{{ $objeto->img_id }}" class="bi bi-box-arrow-in-down-right agregar" style="color:#87796d;float: right;"></i>
                </div>
            @endif

            <div class="ced-imgMetadata" style="display:none;" id="sale_foto{{ $objeto->img_id }}">
                <!-- imprime metadatos del objeto -->
                <i onclick="VerYocultar('foto','{{ $objeto->img_id }}')" class="bi bi-box-arrow-up-left agregar" style="color:#87796d;float: right;"></i>
                <br>

                @if($objeto->img_titulo != '') <b>{{ $objeto->img_titulo }}</b><br>@endif
                @if($objeto->img_pie != '')    <p>{{ $objeto->img_pie }}</p> @endif
                @if($objeto->img_autor != '')  Autor: {{ $objeto->img_autor }}<br>@endif
                @if($objeto->img_fecha != '')  Fecha: {{ $objeto->img_fecha }}<br>@endif
                @if($objeto->img_ubica != '')  Ubicación: {{ $objeto->img_ubica }}<br>@endif
                @if($editMaster=='1' or $edit=='1')Id:{{ $objeto->img_id }}<br>@endif
                <a href="{{ $objeto->img_file }}" target="new">{{ url('/') }}{{ $objeto->img_file }}</a><br>
                @if($edit=='1'AND $editMaster=='1')
                    <!-- eliminar -->
                    @if(method_exists($this,'EliminaImagen'))
                        <div style="color:#87796d;padding-top:15px;">
                            <i class="bi bi-trash PaClick"  wire:click="EliminaImagen('{{ $objeto->img_id }}')" wire:confirm="Estas por eliminar esta imagen. ¿Seguro quieres continuar?">
                                {{ $TipoDeObjeto }}
                            </i>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    @endforeach
@endif


<!-- ------------------TERMINA IMÁGEN ------------------------ -->
