@section('title') No autorizado @endsection
@section('cintillo-ubica') &nbsp; @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado')  @endsection

<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->
{{-- @section('main-Nolivewire')@endsection --}}
<div class="row">
    <div class="col-sm-1 col-md-2">
    </div>
    <div class="col-sm-11 col-md-8">
        <div class="alert alert-danger" role="alert">
            <center>
                No cuentas con las credenciales necesarias para este recurso
                <br>
                {{ $msj }}
                <br>
                <button class="my-3 btn btn-primary" onclick="history.back()">Regresar</button>
            </center>
        </div>
    </div>


</div>
<!-- ------------ TERMINA CONTENIDO PRINCIPAL ------------------- -->
<!-- ----------------------------------------------------------- -->
@section('scripts') @endsection
