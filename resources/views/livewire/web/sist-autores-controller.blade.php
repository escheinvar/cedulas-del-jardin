<div>
    @section('title')Los autores del SiCedJar @endsection
    @section('meta-description')Informaión de los autores y traductores partícipes del sistema @endsection
    @section('banner') banner-2lineas @endsection
    @section('banner-title') Los autores<br>y traductores @endsection
    @section('banner-img') imagen5 @endsection <!-- imagen1 a imagen10 -->
    @section('MenuPublico') x @endsection
    @section('MenuPrivado')  @endsection

    <h2>Los autores y traductores</h2>

    <!-- ------------ Formulario de búsqueda -------------------------- -->
    <div class="row my-5">
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





    <div class="row my-5">
        @foreach ($autores as $a)
            <div class="col-12 col-md-2" style="text-align: center;">
                <div style="">
                    <div>
                        @if($a->objetos->count() > '0')
                            <img src="{{ $a->objetos->value('img_file') }}" style="height:200px;">
                        @else
                            <img src="/avatar/usr1.png" style="height:200px;">
                        @endif
                    </div>

                    <b>{{ $a->caut_nombre }} {{ $a->caut_apellido1 }} {{ $a->caut_apellido2 }}</b>

                    <div>
                        {{ $a->cedulas->count() }} @if($a->cedulas->count() > '1') cédulas @else cedula @endif
                    </div>

                    <div>
                        @foreach ($a->urlautor as $u)
                            <div style="font-size:70%;">
                                <span id="sale_autor{{ $u->aurl_id }}" style="display:none">{{ url('/autor') }}/{{ $u->aurl_cjarsiglas }}/{{ $a->caut_url }}</span>
                                <a href="{{ url('/autor') }}/{{ $u->aurl_cjarsiglas }}/{{ $a->caut_url }}" class="nolink">
                                    {{ $u->aurl_cjarsiglas }}
                                </a>
                                <i onclick="CopiarContenido('autor',{{ $u->aurl_id }})" class="bi bi-clipboard PaClick mx-1"> </i>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
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
