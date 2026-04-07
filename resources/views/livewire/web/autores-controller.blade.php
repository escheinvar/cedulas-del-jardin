@section('MenuPublico') x @endsection
@section('title') {{ $url->caut_nombre}} {{ $url->caut_apelldo1}} @endsection
@section('meta-description') {{ $url->caut_nombre}} {{ $url->caut_apellido1}}, autor de cédulas del jardín @endsection

@section('logo') {{ $url->jardin->cjar_logo }} @endsection
@section('siglas') {{ $url->caut_cjarsiglas }} @endsection
@section('siglasMin'){{ strtolower($url->caut_cjarsiglas) }}@endsection
@section('jardin') {{ $url->jardin->cjar_nombre }} @endsection

@section('red_facebook') {{ $url->jardin->cjar_face }} @endsection
@section('red_instagram') {{ $url->jardin->cjar_insta }} @endsection
@section('red_youtube') {{ $url->jardin->cjar_youtube }}  @endsection
@section('ubicacion') {{ $url->jardin->cjar_ubica }}  @endsection
@section('mail') {{ $url->jardin->cjar_mail }} @endsection
@section('web') {{ $url->jardin->cjar_www }} @endsection



<div>
    @if($edit=='0' and $url->caut_edit=='1')
        <h3 style="text-align: center;">
            ¡ Lo sentimos !<br>
            La página de nuestr@ autor@<br>{{ $url->caut_nombre }} {{ $url->caut_apellido1 }}<br> se encuentra en mantenimiento.<br>
            <br>
            Seguramente en breve, habrán terminado y podrás consultarla nuevamente.
        </h3>
    @else
        <div class="row my-4">
            <div class="col-12">
                <h2>{{ $url->caut_nombre}} {{ $url->caut_apellido1}} {{ $url->caut_apellido2}}</h2>
            </div>
            <!-- imagen del autor-->
            <div class="col-6 col-md-2">
                @if($objs->where('img_cimgtipo','portada')->count() > '0')
                    @include('plantillas.cedulaImagenPlantilla',['objetos'=>$objs->where('img_cimgtipo','portada'),'TipoDeObjeto'=>'portada'])
                @else
                    @if($editMaster=='1')
                        <div wire:click="AbrirModalPaIncertarObjeto('0','autor','portada','','1')" class="bi bi-image PaClick my-3 p-2" style="color:#87796d">
                            Foto del autor
                        </div>
                    @endif
                @endif
            </div>

            <!-- Datos del autor -->
            <div class="col-6 col-md-10">
                <b>{{ $url->caut_nombreautor }}</b><br>
                @if($url->caut_institu != '') {{ $url->caut_institu }}<br> @endif
                @if($url->caut_comunidad!='') {{ $url->caut_comunidad }}<br> @endif
                @if($url->caut_mailpublic =='1') <a href="mailto:{{ $url->caut_correo }}" class="nolink">{{ $url->caut_correo }}</a> <br> @endif
                @if($url->caut_orcid != '')  <a href="https://orcid.org/{{ $url->caut_orcid }}" target="orcid" class="nolink">ORCID {{ $url->caut_orcid }}</a>@endif<br>
                Persona autora de cédulas del {{ $url->jardin->cjar_nombre }}<br>
                @if($edit=='1' and $editMaster=='1')
                    <i wire:click="AbreModalAutores('{{ $url->caut_id }}')" class="bi bi-pencil-square agregar"> Editar </i>
                @endif
            </div>
        </div>






        <div class="row">

            <div class="col-12">
                 <?php $TablaDeTexto=$txt; ?>
                @include('plantillas.texto')
            </div>
        </div>
        <div class="row">
            <h3>Cédulas</h3>
            <ul>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
    @endif


    <livewire:sistema.modal-inserta-objeto-component />
    <livewire:sistema.modal-cedula-autores-component >

    <livewire:sistema.modal-edita-parrafo-component />
</div>
