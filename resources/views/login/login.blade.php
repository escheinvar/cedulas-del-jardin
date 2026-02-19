{{-- @extends('plantillas.PlantillaPublicaGeneral') --}}

@extends('plantillas.PlantillaWeb')

@section('title')
Ingreso al sistema
@endsection

@section('meta-description')

@endsection

@section('banner')
banner-historia
@endsection

@section('banner-title')
Acceso al sistema
@endsection


@section('main-superior')
<section class="visitas pt-4">
    <div class="container px-4 py-5" >
        <div class="row justify-content-around text-center pb-4">
            <div class="col-sm-12 col-md-10 col-lg-7 col-xl-7 pt-5 px-4">
                <div class="center" style="width:50%;">

                    <h2 class="subtitulo">Ingreso al sistema</h2>
                    <form action="{{route('login')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="correo">Correo eletrónico</label>
                            <input name="correo" type="email" class="form-control" id="correo" placeholder="Ingresa tu correo">
                            @error('correo')<error>{{$message}}</error>@enderror

                        </div>

                        <div class="form-group form-con-icono">
                            <label for="contrasenia">Contraseña</label>
                            <input name="contrasenia" type="password" class="form-control" id="passfield" placeholder="Ingresa tu contraseña">
                            <i class="bi bi-eye-slash form-icon" id='passicon' onclick="VerNoVerPass('passfield','passicon','bi bi-eye form-icon', 'bi bi-eye-slash form-icon')" style="padding:10px; cursor:pointer;"></i>
                            @error('contrasenia')<error>{{$message}}</error>@enderror
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="sesionActiva" name="dejarActiva" value=TRUE>
                            <label class="form-check-label" for="sesionActiva" style="float: left;"> &nbsp; Dejar sesión activa</label>
                        </div>

                        <br>
                        <div>
                            <error>{{$mensaje}}</error>
                        </div>
                        <div class="col-sm-12 col-md-auto pb-5">
                            <button type="submit" class="btn btn-primary">Ingresar</button>
                        </div>


                        <div class="my-3">
                            <small>
                            <a class="nolink" href="/recuperaAcceso">Recuperar/Cambiar contraseña</button></a>
                            &nbsp; &nbsp;</small>
                        </div>
                        <div>
                            <small>
                            <a class="nolink" href="/nuevousr">Crear una cuenta</button></a>
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>



    </div>
<br><br>
@endsection



@section('main-inferior')

@endsection








@section('title')Acceso @endsection

@section('cintillo')
    <h3>Acceso al sistema</h3>
    <hr class="titulo">
    <br>
@endsection


@section('main')

@endsection
