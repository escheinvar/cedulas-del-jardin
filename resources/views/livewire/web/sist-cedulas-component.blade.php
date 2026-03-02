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
                    <option value="{{ $i->ced_cjarsiglas }}"> {{ $i->cjar_nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-12 col-md-3 form-group">
            <label class="form-label">Lengua:</label>
            <select wire:model.live="buscaLengua" class="form-select">
                <option value="%"> Todas</option>
                @foreach ($lenguas as $i)
                    <option value="{{ $i->ced_clencode }}"> {{ $i->clen_lengua }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row py-4">
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>Cédula</th>
                    <th>Jardín &nbsp; &nbsp; Lengua</th>
                    <th>Palabras</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $ja=$cedulas->first()->url_nombre ?>
                @foreach ($cedulas as $i)
                    <tr>
                        <td class="PaClick" wire:click="CambiaLengua({{ $i->ced_id }})">
                            <b>{{ $i->url_nombre }}</b>
                            @if($i->url_nombre == $ja)  @else  @endif
                        </td>
                        <td class="PaClick" wire:click="CambiaLengua({{ $i->ced_id }})">
                            {{ $i->ced_cjarsiglas }}
                            &nbsp; &nbsp;
                            {{ $i->clen_lengua }}
                        </td>
                        <td style="font-size: 80%;"  class="PaClick" wire:click="CambiaLengua({{ $i->ced_id }})">
                            @if($i->url_nombrecomun !='')
                                {{ $i->url_nombrecomun }},
                            @endif

                            @if($i->url_sciname != '')
                                {{ $i->url_sciname }},
                            @endif

                            @if($i->url_palabras != '')
                                {{ $i->url_palabras }}
                            @endif
                        </td>
                        <td>
                            <i class="bi bi-clipboard PaClick" onclick="copiar('{{ url('/') }}','{{ $i->ced_urlurl }}','{{ $i->ced_cjarsiglas }}','{{ $i->ced_clencode }}')">url</i>
                        </td>
                    </tr>
                    <?php $ja=$i->url_nombre ?>
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


