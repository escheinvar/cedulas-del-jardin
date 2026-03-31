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
                    <th>Nombre</th>
                    <th>Comunidad/Institución</th>
                    <th>Cédulas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($autores as $a)
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
