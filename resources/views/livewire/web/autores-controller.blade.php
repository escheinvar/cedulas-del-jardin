@section('MenuPublico') x @endsection
@section('title') {{ $url->autor->caut_nombre}} {{ $url->autor->caut_apelldo1}} @endsection
@section('meta-description') {{ $url->autor->caut_nombre}} {{ $url->autor->caut_apellido1}}, autor de cédulas del jardín @endsection

@section('logo') {{ $url->jardin->cjar_logo }} @endsection
@section('siglas') {{ $url->aurl_cjarsiglas }} @endsection
@section('siglasMin'){{ strtolower($url->aurl_cjarsiglas) }}@endsection
@section('jardin') {{ $url->jardin->cjar_nombre }} @endsection

@section('red_facebook') {{ $url->jardin->cjar_face }} @endsection
@section('red_instagram') {{ $url->jardin->cjar_insta }} @endsection
@section('red_youtube') {{ $url->jardin->cjar_youtube }}  @endsection
@section('ubicacion') {{ $url->jardin->cjar_ubica }}  @endsection
@section('mail') {{ $url->jardin->cjar_mail }} @endsection
@section('web') {{ $url->jardin->cjar_www }} @endsection



<div>
    <!-- --------------------- Menú de traducciones ------------------------------ -->
    @if($traducciones->count() > 0)
        <div class="row">
            <div class="col-4 col-md-6 "> &nbsp; </div>

            <div class="col-4 col-md-3 form-group" style="text-align:right;">
                <div>
                    <h3>{{ $url->lengua->len_autonimias }}</h3>
                    <span style="font-size: 70%;">{{ $url->lengua->len_lengua }}</span>
                </div>
            </div>

            <div class="col-4 col-md-3 form-group">
                <label class="form-label">Hay {{ $traducciones->count() }} @if($traducciones->count()=='1') traducción @else traducciones @endif</label>
                <select wire:change="CambiaAunaTraduccion()" wire:model.live="traduccion" class="form-select">
                    <option value="">Selecciona ...</option>
                    @foreach ($traducciones as $t)
                        <option value="{{ $t->aurl_id }}">{{ $t->lengua->len_autonimias }} ({{ $t->lengua->len_lengua }}) {{ $t->lengua->len_code }}</optio>
                    @endforeach
                </select>
            </div>
        </div>
    @endif

    <!-- ---------------------------- inicia página de autor ------------------------ -->
     <div class="row my-4">
            <div class="col-12">
                <h2> {{ $url->autor->caut_nombre}} {{ $url->autor->caut_apellido1}} {{ $url->autor->caut_apellido2}}</h2>
            </div>
     </div>
    @if(!Auth::user() AND ($enEdit=='1' ))
        <div class="col-6 col-md-10">
            <b>{{ $url->autor->caut_nombreautor }}</b><br>
        </div>
        @include('plantillas.PaginaEnMtto')

    @else
        <div class="row my-4">
            {{-- <div class="col-12">
                <h2>{{ $url->autor->caut_nombre}} {{ $url->autor->caut_apellido1}} {{ $url->autor->caut_apellido2}}</h2>
            </div> --}}
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
                <b>{{ $url->autor->caut_nombreautor }}</b><br>
                @if($url->autor->caut_institu != '')Institución: {{ $url->autor->caut_institu }}<br> @endif
                @if($url->autor->caut_comunidad!='')Comunidad: {{ $url->autor->caut_comunidad }}<br> @endif
                @if($url->autor->caut_mailpublic =='1')Correo: <a href="mailto:{{ $url->autor->caut_correo }}" class="nolink">{{ $url->autor->caut_correo }}</a> <br> @endif
                @if($url->autor->caut_orcid != '')  <a href="https://orcid.org/{{ $url->autor->caut_orcid }}" target="orcid" class="nolink">ORCID: {{ $url->autor->caut_orcid }}</a><br>@endif
                @if($url->autor->caut_scopus != '')  <a href="https://scopus.com/authid/detail.uri?authorId={{ $url->autor->caut_scopus }}" target="orcid" class="nolink">Scopus: {{ $url->autor->caut_scopus }}</a><br>@endif
                @if($url->autor->caut_isni != '')  <a href="https://isni.org/isni/{{ $url->autor->caut_isni }}" target="orcid" class="nolink">ISNI: {{ $url->autor->caut_isni }}</a><br>@endif
                Cédulas del Jardín: {{ STR_PAD($url->autor->caut_id, 4,"0",STR_PAD_LEFT) }}<br>
                <br>
                Persona autora de cédulas del {{ $url->jardin->cjar_nombre }}<br>

                <b>{{ $url->lengua->len_autonimias }}</b>  &nbsp; ({{ $url->lengua->len_lengua }})


                @if($edit=='1' and $editMaster=='1')
                    <i wire:click="AbreModalAutores('{{ $url->autor->caut_id }}')" class="bi bi-pencil-square cedEdo{{ $url->aurl_edo }} PaClick"> Datos de autor </i>
                @endif
                <!-- Indicador de edición y rol -->
                @if(Auth::user())
                    <div class="cedEdoIcon{{ $url->aurl_edo }}">
                        @if($enEdit=='0') <b>No en edición</b> @endif
                       {{ implode(', ',session('rol')) }}
                    </div>
                @endif
            </div>
        </div>





        <!-- Texto de semblanza-->
        <div class="row">
            <div class="col-12">
                <?php $TablaDeTexto=$txt; $modulo='autor';?>
                @include('plantillas.texto')
            </div>
            <!-- muestra último párrafo -->
            @if($edit=='1')
                <div class="row my-4" style="background-color: #CDC6B9;">
                    <div class="col-2">
                        <i wire:click="AbreModalEditaParrafo('0','0', '', '', '', '1')" class="bi bi-plus-square PaClick" style="display:inline;"> Nuevo párrafo</i>
                    </div>
                </div>

            @endif
        </div>

        <!-- Cédulas en las que participa -->
        <div class="row">
            <h3>Cédulas en las que participa:</h3>
            <ol >
                @foreach ($ceds as $c)
                    <li class="my-2"><a href="{{ url('/cedula') }}/{{ $c->cedula->url_cjarsiglas }}/{{ $c->cedula->url_url }}" class="nolink">{{ $c->cedula->url_titulo }}<sup>{{ substr($c->aut_tipo,0,1) }}</sup> ({{ $c->cedula->url_lencode }}), {{ $c->cedula->url_cjarsiglas }} </a></li>
                @endforeach
            </ol>
        </div>
    @endif


    <livewire:sistema.modal-inserta-objeto-component />
    <livewire:sistema.modal-cedula-autores-component >

    <livewire:sistema.modal-edita-parrafo-component />
</div>
