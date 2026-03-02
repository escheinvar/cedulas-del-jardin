
@extends('plantillas.basePublico')

@section('title')Las cédulas del SiCedJar @endsection
@section('meta-description')Acceso al Sistema de Cédulas del Jardín en Lenguas Originarias @endsection
@section('banner') banner-1linea @endsection
@section('banner-title') Acceso @endsection
@section('banner-img') imagen5 @endsection <!-- imagen1 a imagen10 -->
@section('MenuPublico') x @endsection
@section('MenuPrivado')  @endsection


@section('main-Nolivewire')
    <div>

        <form action="{{route('login')}}" method="POST">
            @csrf
            <div class="row">
                <div class="col-12 col-md-4"></div>
                <div class="col-12 col-md-4">
                    <h2 class="subtitulo">Ingreso al sistema</h2>
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
                </div>
                <div class="col-12 col-md-4"></div>
            </div>
        </form>
    </div>
@endsection



