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
    <div class="row my-4">
        <div class="col-sm-12 col-md-3 form-group">
            <label class="form-label">Jardín:</label>
            <select wire:model.live="buscaJardin" class="form-select">
                <option value=""> Todos</option>
                @foreach ($jardines as $i)
                    <option value="{{ $i->cjar_siglas }}"> {{ $i->cjar_nombre }} ({{ $i->cjar_siglas }})</option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-12 col-md-3 form-group">
            <label class="form-label">Lengua:</label>
            <select wire:model.live="buscaLengua" class="form-select">
                <option value=""> Todas</option>
                @foreach ($lenguas as $i)
                    <option value="{{ $i->url_lencode }}"> {{ $i->len_autonimias }} ({{ $i->len_lengua }})</option>
                @endforeach
            </select>
        </div>

        <div class="col-sm-12 col-md-3 form-group">
            <label class="form-label">Nombre/Autor/Titulo: </label><br>
            <input wire:model="buscaText" type="text" class="form-control" style="width:70%;display:inline-block">
            <button wire:click='BuscaPorTexto()'class="btn btn-sm btn-secondary" style="display:inline-block;">buscar</button>
            <i wire:click='BorrarTexto()'class="bi bi-x-square agregar"></i>
            @error('buscaText')<br><error>{{ $message }}</error>@enderror
        </div>
    </div>

    @include('plantillas.cedula')

    @if($cedulas->count() < '1')
        -- Lo sentimos, no hay cédulas en esta búsqueda --
    @endif





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


