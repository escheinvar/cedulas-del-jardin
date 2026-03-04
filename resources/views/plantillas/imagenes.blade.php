<!-- ------------------------------------------------------------------------------
    Esta plantilla es invocada desde imagen-controller, módulo de imágenes
    que requiere única y exclusivamente una variable denominada $imags
    que contenga el listado de imágenes que se quiere mostrar y que
    fue obtenido desde el controlador con <b>imagenes::get()</b>.<br>

    En el view, donde vas a mostrar imágenes pon:

    < ?php $imags=$objeto; ? >
    @ include('plantillas.imagenes')

    --------------------
    Esta plantilla, además de recibir el listado y mostrar los objetos de $imgags,
    tiene la posiblidad de editar cada una de los objetos, para lo cual, requiere que el
    controlador, incluya la función "AbrirModalObjeto", para lo cual cópiala ypégala
    tal cual en el controlador:

    public function AbreModalObjeto(){
        $data=[
            'ImgId'=>       'Obligatorio: img_id de tabla imagenes ó 0 para nuevo',
            'SiglasJardin'=>'Obligatorio: siglas del jardín al que pertenece',
            'ModuloCatImg'=>'Obligatorio: cimg_modulo de tabla cat_imgs',
            'TipoCatImg'=>  'Obligatorio: cimg_tipo de tabla cat_imgs'
            'Url'=>         'url a la que pertenece o vacío',
            'Lengua'=>      'len_code de tabla lenguas o vacío',
            'Reload'=>'0 o 1. Al cerrar, se recarga (1) o no (0) la pag'
        ];
        $this->dispatch('abreModalDeImagen', $data);
    }
------------------------------------------------------------------------------ -->
{{-- @if(!method_exists($this,'AbreModalObjeto')) <error> No se detecta el método AbreModalObjeto </error> @endif --}}

@if(isset($imags))
    @foreach ($imags as $o)
        <imagen style="max-width:250px; display:inline-block;" wire:key="imagenId{{ $o->img_id }}">
            <!-- TITULO -->
            <titulo class="truncarTexto" onclick="Destruncar('titulo','{{ $o->img_id }}')" id="titulo_{{ $o->img_id }}">
                @if($o->img_act=='0') <error><i class="bi bi-eye-slash"></i></error>@endif
                {{ $o->img_titulo }}
            </titulo>
            <div class="imagen">
                <fecha style="">{{ $o->img_fecha }}</fecha>
                <!-- OBJETO IMAGEN -->
                @if($o->img_tipo=='img')
                    <a href="{{ $o->img_file }}" target="nvaImg" class="nolink">
                        <img style="width:100%" src="{{ $o->img_file }}">
                    </a>

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
                <!-- AUTOR -->
                <autor>
                    {{ $o->img_autor }}
                </autor>
            </div>
            <!-- PIE -->
            <explica class="truncarTexto" id="explica_{{ $o->img_id }}">
                <div>
                    <span onclick="Destruncar('explica','{{ $o->img_id }}')">
                        {{ $o->img_pie }}
                    </span>
                </div>
                <div>
                    <!-- icono para desplegar metadatos -->
                    <i onclick="VerNoVer('metadatos','{{ $o->img_id }}')" style="color:#CDC6B9;font-weight:600;" class="bi bi-arrow-down-right-square"></i>
                    <!-- ícono para editar -->
                    @if(isset($edit) AND method_exists($this,'AbreModalObjeto'))
                        @if($edit=='1')
                            <i wire:click="AbreModalObjeto('{{ $o->img_id }}')" class="bi bi-pencil-square agregar" style="float: right;"> Editar {{ $o->img_id }}</i>
                        @endif
                    @endif
                </div>
                <!-- METADATOS -->
                <div style="display:none" id="sale_metadatos{{ $o->img_id }}" class="my-2">

                    <b>Id</b>: {{ $o->img_id }} </br>
                    <b>Jardin</b>: {{ $o->img_cjarsiglas }}<br>
                    <b>Tipo</b>: {{ $o->img_tipo }}<br>
                    <b>Modulo</b>: {{ $o->img_cimgmodulo }}-{{ $o->img_cimgtipo }}<br>

                    @if($o->img_urlurl !='')<b>Cédula</b>: {{ $o->img_urlurl }}<br> @endif
                    @if($o->img_lencode !='')<b>Lengua</b>: {{ $o->img_lencode }}<br> @endif
                    @if($o->img_ubica != '')<b>Ubicación</b>: {{ $o->img_ubica }}<br> @endif
                    @if($o->img_lonx != '' or $o->img_laty != '')<b>XY</b>: {{ round($o->img_lonx,4) }}, {{ round($o->img_laty,4) }}<br>@endif
                    @if($o->img_size != '')<b>Tamaño</b>: {{ $o->img_size }} MB<br>@endif
                    @if($o->img_resolu > '0')<b>Resolución</b>: {{ $o->img_resolu }} px<br>@endif
                    @if($o->img_file != '')<b>Url</b>:
                        <a href="{{ $o->img_file }}" target="new" class=" mx-2" id="sale_Nombre{{ $o->img_id }}">
                            {{ $o->img_file }}
                        </a>
                        <i class="bi bi-clipboard PaClick" onclick="CopiarContenido('Nombre','{{ $o->img_id }}');"><sub>copy</sub></i><br>
                    @endif
                </div>
            </explica>
        </imagen>
    @endforeach
    <?php $imags='';?>
@else
    <div class="alert alert-danger" role="alert">
        El módulo de imágenes requiere una variable denominada $imags
        que contenga el listado de imágenes <b>imagenes::get()</b><br>
        Puedes enviarla al módulo escribiendo <b>&lt;?php $imags= $MiObjeto; ?&gt;</b>
        antes de invocar este módulo.
    </div>
@endif



<livewire:Web.ModalImagenController  />



<script>
    function Destruncar($tipo,$id){
        var obj = document.getElementById($tipo + '_' + $id);
        if (obj.classList.contains('truncarTexto')) {
            // console.log('está truncado');
            obj.classList.remove("truncarTexto");
        }else{
            // console.log('no lo está');
            obj.classList.add("truncarTexto");
        }
    }
</script>

