@section('title')Las cédulas del SiCedJar @endsection
@section('meta-description')Cédulas de información de los jardínes, instituciones y organizaciones partícipes del sistema @endsection
@section('banner') banner-2lineas @endsection
@section('banner-title') Las cédulas @endsection
@section('banner-img') imagen5 @endsection <!-- imagen1 a imagen10 -->
@section('MenuPublico') xaa @endsection
@section('MenuPrivado')  @endsection


<div>
    <h2 class="subtitulo">Las cédulas</h2>

    <!-- ------------ Formulario de búsqueda -------------------------- -->
    <div class="row">
        <div class="col-sm-12 col-md-3 form-group">
            <label class="form-label">Buscar: </label>
            <input wire:model.live="buscaText" type="text" class="form-control">
            @error('buscaText')<error>{{ $message }}</error>@enderror
        </div>

        <div class="col-sm-12 col-md-3 form-group">
            <label class="form-label">Jardín:</label>
            <select wire:model.live="buscaJardin" class="form-select">
                <option value="%"> Todos</option>
                @foreach ($jardines as $i)
                    <option value="{{ $i->url_cjarsiglas }}"> {{ $i->cjar_nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-12 col-md-3 form-group">
            <label class="form-label">Lengua:</label>
            <select wire:model.live="buscaLengua" class="form-select">
                <option value="%"> Todas</option>
                @foreach ($lenguas as $i)
                    <option value="{{ $i->len_code }}"> {{ $i->len_autonimias }} ({{ $i->len_lengua }})</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row py-4">
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Lengua</th>
                    <th>Jardín</th>
                    <th>Palabras</th>
                    {{-- <th>Autores</th> --}}
                    <th>Url</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cedulas as $i)
                    <tr>
                        <!-- nombre cédula -->
                        <td>
                            <b>{!! $i->url_titulo !!}</b>
                            <div class="form-text">{!! $i->url_tituloorig !!}
                        </td>

                        <!-- lengua -->
                        <td>
                            {{ $i->lenguas->len_autonimias }}
                            ({{ $i->lenguas->len_lengua }})
                            <span class="form-text">{{ $i->url_lencode }}</span>
                        </td>

                        <!-- Jardin -->
                        <td>
                            {{ $i->jardin->cjar_name }}
                            <span class="form-text">{{ $i->jardin->cjar_siglas }}</span>
                        </td>

                        <!-- Palabras -->
                        <td style="font-size:80%;">
                            @foreach($i->especies as $e)
                                <i>{{ $e->sp_scname }}</i>,
                            @endforeach

                            @foreach ($i->alias as $a)
                                {{ $a->ali_txt_tr }},
                            @endforeach

                            @foreach ($i->ubicaciones as $u)
                                {{ $u->ubi_ubicacion_tr }},
                            @endforeach

                            @foreach ($i->usos as $s)
                                {{ $s->usos->cuso_uso }},
                            @endforeach
                        </td>

                        <!-- autores -->
                        {{-- <td style="font-size: 80%;" >
                            @foreach ($i->autores as $a)
                                {{ $a->aut_name }},
                            @endforeach

                            @if($i->traductores->count() > '0')
                                (
                                @foreach ($i->traductores as $a)
                                    {{ $a->aut_name }},
                                @endforeach
                                )
                            @endif
                        </td> --}}

                        <td>
                            <i class="bi bi-clipboard PaClick" onclick="CopiarContenido('url','{{ $i->url_id }}')"></i> &nbsp;
                            @if($i->url_doi == '')
                                <a href="{{ url('/cedula') }}/{{ $i->url_cjarsiglas }}/{{ $i->url_url }}" id="sale_url{{ $i->url_id }}" target="new" class="nolink">
                                    {{ url('/cedula') }}/{{ $i->url_cjarsiglas }}/{{ $i->url_url }}
                                </a>
                            @else
                                <a href="https://doi.org/{{ $i->url_doi }}" target="new" class="nolink">
                                    https://doi.org/{{ $i->url_doi }}
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    @section('scripts')
        <script>
            function copiar($base,$url,$jar,$len){
                var copyText = $base+"/len/"+$url+"/"+$jar+"/"+$len

                console.log(copyText)
                navigator.clipboard.writeText(copyText);
                // Alert the copied text
                alert(copyText + " copiada al escritorio");
            }
        </script>
    @endsection

</div>


