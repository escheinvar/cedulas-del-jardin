@section('title') Admin. Lenguas @endsection
@section('meta-description') Meta @endsection
@section('cintillo-ubica') -> {{ request()->path() }} @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection
<div>
    <!-- ----------------------------------------------------------- -->
    <!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->

    <h2>Administración de lenguas</h2>
    <div style="font-size: 80%;color:grey;">
        Este catálogo es administrado por el rol <b>Admin@todos</b> en jardin: {{ implode(',',$editjar) }}
        (@if($edit=='0') <error style="font-size: 90%;"> No autorizado</error> @else <span style="font-size:90%;color:green;"> Autorizado </span>@endif)
    </div>

    <!-- ------------------------------------------------------------------------------------ -->
    <!-- ----------------------------- TABLA DE LENGUAS EN EL SISTEMA ----------------------- -->
    <!-- ------------------------------------------------------------------------------------ -->
    <div class="table-responsive-sm">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th wire:click="ordenaTabla('len_id')" class="PaClick">ID</th>
                    <th wire:click="ordenaTabla('len_code')" class="PaClick">Código</th>
                    <th wire:click="ordenaTabla('len_lengua')" class="PaClick">Lengua</th>
                    {{-- <th wire:click="ordenaTabla('len_variante')" class="PaClick">Variante</th> --}}
                    <th wire:click="ordenaTabla('len_autonimias')" class="PaClick">Autonimia</th>
                    <th wire:click="ordenaTabla('len_altnames')" class="PaClick">Otros Nombres</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lenguasActivas as $len)
                    <tr>
                        <td> {{ $len->len_id }} </td>
                        <td> {{ $len->len_code }} </td>
                        <td> {{ $len->len_lengua }}  </td>
                        {{-- <td> {{ $len->len_variante }}  </td> --}}
                        <td> {{ $len->len_autonimias }} </td>
                        <td> {{ $len->len_altnames }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- menú de paginación -->
        @if($lenguasActivas->hasPages())
         <div class="">
            <div class="paginador">
                <a href="{{ $lenguasActivas->previousPageUrl() }}"><div class="boton" @if($lenguasActivas->currentPage() == '1') disabled @endif> &laquo; </div></a>
                @foreach (range(1,$lenguasActivas->lastPage()) as $i)
                    @if($i == $lenguasActivas->currentPage())
                        <div class="boton" disabled> {{ $i }} </div>
                    @else
                        <a href="{{ $lenguasActivas->url($i) }}"><div class="boton"> {{ $i }} </div></a>
                    @endif
                @endforeach
                <a href="{{ $lenguasActivas->nextPageUrl() }}"><div class="boton" @if($lenguasActivas->currentPage() == $lenguasActivas->lastPage()) disabled @endif> &raquo; </div></a>
                Estás en {{ $lenguasActivas->currentPage() }}
            </div>
         </div>
        @endif
    </div>
    <div>
        @if($edit=='1')
            <button wire:click="VerNuevaLengua()" class="btn btn-primary"> <i class="bi bi-plus-square"></i> Agregar lengua</button>
        @endif
    </div>









    <!-- ------------------------------------------------------------------------------------ -->
    <!-- -------------------------------- AGREGAR NUEVA LENGUA ------------------------------------- -->
    <!-- ------------------------------------------------------------------------------------ -->
    @if($VerNuevo=='1')
        <div class="row my-4">
            <!-- buscar por nombre o correo -->
            <div class="col-12 col-md-3 form-group">
                <label class="form-label">Lengua/Autonimia</label>
                <input wire:model.live="lenguaSel" class="form-control agregar">
                <i class="bi bi-x-square-fill agregar" wire:click="BorrarBusqueda('lenguaSel')"></i>

            </div>

            <!-- buscar por ubicación geográfica -->
            <div class="col-12 col-md-3 form-group">
                <label class="form-label">Municipio/Localidad</label>
                <input wire:model.live="localSel" class="form-control agregar">
                <i class="bi bi-x-square-fill agregar" wire:click="BorrarBusqueda('localSel')"></i>
            </div>

            <!-- buscar por código -->
            <div class="col-12 col-md-3 form-group">
                <label class="form-label">Código</label>
                <input wire:model.live="codeSel" class="form-control agregar">
                <i class="bi bi-x-square-fill agregar" wire:click="BorrarBusqueda('codeSel')"></i>
            </div>

        </div>
        <div class="row table-responsive">
            <div >
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th wire:click="ordenaTabla2('clen_id')" class="PaClick">ID</th>
                            <th wire:click="ordenaTabla2('clen_code')" class="PaClick">Clave</th>
                            <th wire:click="ordenaTabla2('clen_lengua')" class="PaClick">Lengua</th>
                            <th wire:click="ordenaTabla2('clen_autonimia')" class="PaClick">Autonimia</th>
                            <th wire:click="ordenaTabla2('clen_nombres')" class="PaClick">Otros nombres</th>
                            <th wire:click="ordenaTabla2('clen_localidad')" class="PaClick">Localidades</th>
                            <th wire:click="ordenaTabla2('clen_base')" class="PaClick">Origen</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lenguas as $l)
                            <tr style="background-color:red;">
                                <td>{{ $l->clen_id }}</td>
                                <td>{{ $l->clen_code }}</td>
                                <td>{{ $l->clen_lengua }}</td>
                                <td>{{ $l->clen_autonimia }}</td>
                                <td>{{ $l->clen_nombres }}</td>
                                <td>{{ $l->clen_localidad }}</td>
                                <td>{{ $l->clen_base }}</td>
                                <td>
                                    @if($lenguasActivas->where('len_code',$l->clen_code)->count() =='0')
                                        <button wire:click="AgregarNuevaLengua('{{ $l->clen_code }}')" wire:confirm="Estás por agregar una nueva lengua al sistema. ¿Seguro deseas continuar?" class="btn btn-sm btn-secondary">
                                            Agregar
                                        </button>
                                    @else
                                        <center>-- en sistema --</center>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    @endif


    <script>
    Livewire.on('AvisoExitoLengua',()=>{
        alert(event.detail.msj);
    })
    </script>

</div>
