@section('title')
Catálogo de Campus
@endsection
@section('cintillo')
    Catálogo: Campus y Jardines
@endsection

<div>
    <h2>Catálogo de Jardines</h2>
    <!--------------------------------------------------------------------------------------------->
    <!--------------------------------- TABLA DE JARDÍNES ----------------------------------------->
    <!--------------------------------------------------------------------------------------------->
    <div class="row">
        <div class="col-12 my-3">
            <h3>Jardines</h3>
            <div>
                <button wire:click="ProcedeJardin('0')" type="button" class="btn btn-secondary" style="float: right;">
                    Nuevo Jardín
                </button>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <table class="table table-striped" style="width:100%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Siglas</th>
                        <th>Nombre corto</th>
                        <th>Nombre largo</th>
                        <th>Campus</th>
                        <th> &nbsp; </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jardines as $jar)
                        <tr>
                            <td style="@if($HayJardin == $jar->cjar_id) background-color:#87796d;@endif"> {{ $jar->cjar_id }}</td>
                            <td style="@if($HayJardin == $jar->cjar_id) background-color:#87796d;@endif"> {{ $jar->cjar_siglas }}</td>
                            <td style="@if($HayJardin == $jar->cjar_id) background-color:#87796d;@endif"> {{ $jar->cjar_name }}</td>
                            <td style="@if($HayJardin == $jar->cjar_id) background-color:#87796d;@endif"> {{ $jar->cjar_nombre }}</td>
                            <td style="@if($HayJardin == $jar->cjar_id) background-color:#87796d;@endif"> {{$Num=$NumDeCampus->where('ccam_cjarid', $jar->cjar_id)->value('total')}} @if($Num < '1')<error>Falta campus</error>@endif </td>
                            <td style="@if($HayJardin == $jar->cjar_id) background-color:#87796d;@endif"> <i class="bi bi-pencil-square PaClick" wire:click="ProcedeJardin({{ $jar->cjar_id }})"></i> </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!--------------------------------------------------------------------------------------------->
    <!--------------------------------- FORMULARIO PARA EDITAR JARDÍN ----------------------------->
    <!--------------------------------------------------------------------------------------------->
    @if($HayJardin != '')
        <div class="row">
            <!-- Nombre corto -->
            <div class="col-xs-12 col-sm-6 col-md-4" >
                <label>Nombre corto</label>
                <input wire:model.live="jar_name" type="text" class="form-control" @if($HayJardin > 0) readonly @endif>
                @error('jar_name')<error>{{ $message }}</error>@enderror
            </div>

            <!-- Nombre largo -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <label>Nombre completo</label>
                <input wire:model.live="jar_nombre" type="text" class="form-control">
                @error('jar_nombre')<error>{{ $message }}</error>@enderror
            </div>

            <!-- Siglas -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <label>Siglas</label>
                <input wire:model.live="jar_siglas" type="text" class="form-control">
                @error('jar_siglas')<error>{{ $message }}</error>@enderror
            </div>

            <!--  Tipo de jardín -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <label>Tipo de jardín</label>
                <select wire:model.live="jar_tipo" class="form-select">
                    <option value="Etnobotánico">Etnobotánico</option>
                    <option value="Etnobiológico">Etnobiológico</option>
                    <option value="Botánico">Botánico</option>
                    <option value="Comunitario">Comunitario</option>
                    <option value="Escolar">Escolar</option>
                    <option value="Parque">Parque</option>
                    <option value="Jardinera">Jardinera</option>
                </select>
            </div>

            <!-- Dirección -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <label>Dirección</label>
                <input wire:model.live="jar_direccion" type="text" class="form-control">
            </div>

            <!--  Estado -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <label>Estado</label>
                <select class="form-select" wire:model="jar_edo">
                    @foreach ($Entidades as $edo)
                        <option value="{{ $edo->cedo_nombre }}"> {{ $edo->cedo_nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Teléfono -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <label>Teléfono</label>
                <input wire:model.live="jar_tel" type="text" class="form-control">
            </div>

            <!-- Correo -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <label>Correo</label>
                <input wire:model.live="jar_mail" type="text" class="form-control">
            </div>

            <!-- Logo -->
            <div class="col-xs-12 col-sm-6 col-md-4">
                <!-- ver logo-->
                <label>Logo</label><br>
                @if($jar_logo != '' )
                    <img src="/avatar/jardines/{{ $jar_logo }}" style="width:150px;">
                    <i class="bi bi-trash PaClick mx-2" wire:click="BorraLogo('{{  $HayJardin }}','{{ $jar_logo }}')" wire:confirm="Vas a eliminar el logo Y YA NO SE VA A PODER RECUPERAR. ¿Quieres continuar?"></i>
                @else
                    <input wire:model.live="jar_logoNuevo" type="file" class="form-control">
                    @if($jar_logoNuevo != '')
                        <img src="{{ $jar_logoNuevo->temporaryUrl() }}" style="width:150px;">
                    @endif

                @endif
            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">
                <br>
                @if($HayJardin=='0')
                    <button wire:click="EditaJardin('0')" type="button" class="btn btn-primary">
                        Agregar Nuevo Jardín
                    </button>
                @elseif($HayJardin > '0')
                    <button wire:click="EditaJardin('{{ $HayJardin }}')" type="button" class="btn btn-primary">
                        Guardar cambios del jardín {{ $HayJardin }}
                    </button>
                @endif
            </div>
        </div>
    @endif


    <!--------------------------------------------------------------------------------------------->
    <!--------------------------------- TABLA DE CAMPUS ------------------------------------------->
    <!--------------------------------------------------------------------------------------------->
    <br><br>
    @if($this->HayJardin > 0)
        <div class="row">

            <h3>Campus de: {{$jar_name}}</h3>
            <div>
                <button wire:click="ProcedeCampus('0')" type="button" class="btn btn-secondary" style="float: right;">
                    Nuevo Campus
                </button>
            </div>
        </div>
        <div class="row">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre largo </th>
                            <th>Nombre corto</th>
                            <th>Dirección</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($campuses as $camp)
                            <tr>
                                <td style="@if($HayCampus == $camp->ccam_id) background-color:#87796d;@endif">
                                        {{ $camp->ccam_id }}
                                </td>
                                <td style="@if($HayCampus == $camp->ccam_id) background-color:#87796d;@endif">
                                    {{ $camp->ccam_nombre }}
                                </td>
                                <td style="@if($HayCampus == $camp->ccam_id) background-color:#87796d;@endif">
                                    {{ $camp->ccam_name }})
                                </td>
                                <td style="@if($HayCampus == $camp->ccam_id) background-color:#87796d;@endif">
                                    {{ $camp->ccam_direccion }}
                                </td>
                                <td style="@if($HayCampus == $camp->ccam_id) background-color:#87796d;@endif">
                                    <i class="bi bi-pencil-square PaClick" wire:click="ProcedeCampus({{ $camp->ccam_id }})"></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

        </div>



        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4">
                <label>Nombre corto</label>
                <input wire:model="cam_name" type="text" class="form-control">
            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">
                <label>Nombre largo</label>
                <input wire:model="cam_nombre" type="text" class="form-control">
            </div>

            <div class="col-xs-12 col-sm-6 col-md-4">
                <label>Dirección</label>
                <input wire:model="cam_direccion" type="text" class="form-control">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4">
                <br>
                @if($HayJardin=='0')
                    <button wire:click="EditaCampus('0')" type="button" class="btn btn-primary">
                        Agregar Nuevo Campus</button>
                @elseif($HayJardin > '0')
                    <button wire:click="EditaCampus('{{ $HayCampus }}')" type="button" class="btn btn-primary">
                        @if($HayCampus=='0') Guardar nuevo campus
                        @else Guardar cambios al campus {{ $HayCampus }}@endif
                    </button>
                @endif
            </div>
        </div>

    @endif
</div>
