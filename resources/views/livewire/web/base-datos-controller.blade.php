@section('title')
Base de datos
@endsection

@section('meta-description')
Base de datos del Jardín
@endsection

@section('banner')
banner-directorio
@endsection

@section('banner-title')
Base de datos
@endsection

<div>
    <section class="directorio pt-4">
        <div class="container px-4 py-5" id="bienvenido">
            <h1>Base de datos</h1>{{ $sale }}

            <!-- ----------------------- Buscadores --------------------------- -->
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Clavo</label>
                    <input type="text" class="form-control" wire:model="clavo">
                    <div  class="form-text">(>>,<<, >=, <=, !=, ilike tx%)</div>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Género</label>
                    <input type="text" class="form-control"  wire:model="genero">
                    <div  class="form-text">(Txt, ilike Tx%)</div>
                </div>


                <div class="col-md-3 mb-3">
                    <label class="form-label">Especie</label>
                    <input type="text" class="form-control" wire:model="especie">
                    <div  class="form-text">(Txt, ilike Tx%)</div>
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label">Nombre común</label>
                    <input type="text" class="form-control"  wire:model="nombre">
                    <div  class="form-text">(Txt, ilike Tx%)</div>
                </div>



                <div class="col-md-3 mb-3">
                    @if(auth()->user())
                        <button wire:click="buscar()" wire:loadding.attr="disabled" type="button" class="btn btn-primary">
                            <span wire:loading.remove>Buscar</span>
                            <span wire:loading style="display:none;"> <red> ..buscando...</red> </span>
                        </button>

                        @if($base)
                            &nbsp; {{ count($base) }} resultados
                        @endif
                    @else
                        <button class="btn btn-primary" disabled> Buscar</button> (Debes <a href="/home">ingresar primero</a>)
                    @endif

                </div>
            </div>


            <!-- ----------------------- Tabla --------------------------- -->
            @if($base)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Clavo</th>
                            <th>Letra</th>
                            <th>Nombre Científico</th>
                            <th>Nombre común</th>
                            <th>Familia</th>
                            <th>Datos</th>
                            <th> &nbsp; </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($base as $i)
                            <tr>
                                <td>
                                    {{ $i->cl_numero_clavo }}
                                </td>

                                <td>
                                    {{ $i->cl_letra }}
                                </td>

                                <td>
                                    {{ $i->cl_genero }}
                                    {{ $i->cl_especie }}
                                </td>

                                <td>
                                    {{ $i->cl_nombre_comun }}
                                </td>

                                <td>
                                    {{ $i->cl_familia }}
                                </td>

                                <td>
                                    {{ $i->cl_procedencia }}
                                    <small>{{ $i->cl_fecha }}</small>
                                </td>

                                <td>
                                    <i class="bi bi-pencil-square"></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if(count($base)<1) No hay registros @endif
            @endif
        </div>
    </section>
</div>

