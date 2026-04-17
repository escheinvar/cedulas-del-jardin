<div>
@section('title') Admin Usuarios @endsection
@section('meta-description') Meta @endsection
@section('cintillo-ubica') -> {{ request()->path() }} @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection


<!-- ----------------------------------------------------------- -->
<!-- ------------ INICIA CONTENIDO PRINCIPAL ------------------- -->

    <h2>Administración de usuarios</h2>
    <div style="font-size: 80%;color:grey;">
        Este catálogo es administrado por el rol
        <b style="@if(in_array('admin',session('rol'))) color:green; @endif">Admin</b> en jardin: {{ implode(',',$editjar) }}
        (@if($edit=='0') <error style="font-size: 90%;"> No autorizado</error> @else <span style="font-size:90%;color:green;"> Autorizado </span>@endif)
    </div>
    <!-- ------------------------------------------------------------------------------------ -->
    <!-- -------------------------------- BUSCAR USUARIO ------------------------------------- -->
    <!-- ------------------------------------------------------------------------------------ -->
    <div class="row my-4">
        <!-- buscar por jardín -->
        <div class="col-12 col-md-3 form-group">
            <label class="form-label">Jardin</label>
            <select wire:model.live="jardinSel" wire:change="DefineJardin()" class="form-select">
                <option value="">Cualquiera</option>
                @foreach($JardsDelUsr as $jar)
                    <option value="{{ $jar->cjar_siglas }}">{{ $jar->cjar_name }}</option>
                @endforeach
                <option value="todos">A todos</option>
            </select>
        </div>

        <!-- buscar por rol -->
        <div class="col-12 col-md-3 form-group">
            <label class="form-label">Con el rol</label>
            <select wire:model.live="rolSel" class="form-select">
                <option value="">Todos los roles</option>
                @foreach($catRoles as $rol)
                    <option value="{{ $rol->crol_rol }}">{{ $rol->crol_rol }}</option>
                @endforeach
            </select>
        </div>

        <!-- buscar por nombre o correo -->
        <div class="col-12 col-md-3 form-group">
            <label class="form-label">Con nombre o correo</label>
            <input wire:model.live="nombreSel" class="form-control">
        </div>
    </div>

    <!-- ------------------------------------------------------------------------------------ -->
    <!-- ----------------------------- TABLA DE USUARIOS ------------------------------------ -->
    <!-- ------------------------------------------------------------------------------------ -->
    <div class="table-responsive-sm">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th wire:click="ordenaTabla('id')" class="PaClick">Id</th>
                    <th wire:click="ordenaTabla('email')" class="PaClick">email</th>
                    <th wire:click="ordenaTabla('usrname')" class="PaClick">usr</th>
                    <th wire:click="ordenaTabla('nombre')" class="PaClick">Nombre</th>
                    <th >Rol (jardin)</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usr)
                    <tr class="PaClick @if($usr->act=='0') inact @endif" wire:click="AbrirModalDeRolesDeUsuario('{{ $usr->id }}')">
                        <td> {{ $usr->id }} </td>
                        <td> {{ $usr->email }}  </td>
                        <td> {{ $usr->usrname }}  </td>
                        <td> {{ $usr->nombre }} {{ $usr->apellido }}  </td>
                        <td>
                            @foreach ($usr->roles as $rol)
                                <b>{{ $rol->rol_crolrol }}</b> ({{ $rol->rol_cjarsiglas }}), &nbsp;
                            @endforeach
                        </td>
                        <td>
                            <i class="bi bi-pencil-square PaClick"  ></i>
                            @if($usr->act=='0') X @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- menú de paginación -->
        @if($usuarios->hasPages())
         <div class="">
            <div class="paginador">
                <a href="{{ $usuarios->previousPageUrl() }}"><div class="boton" @if($usuarios->currentPage() == '1') disabled @endif> &laquo; </div></a>
                @foreach (range(1,$usuarios->lastPage()) as $i)
                    @if($i == $usuarios->currentPage())
                        <div class="boton" disabled> {{ $i }} </div>
                    @else
                        <a href="{{ $usuarios->url($i) }}"><div class="boton"> {{ $i }} </div></a>
                    @endif
                @endforeach
                <a href="{{ $usuarios->nextPageUrl() }}"><div class="boton" @if($usuarios->currentPage() == $usuarios->lastPage()) disabled @endif> &raquo; </div></a>
                Estás en {{ $usuarios->currentPage() }}
            </div>
         </div>
        @endif
    </div>


    <livewire:sistema.modal-admin-usuarios-component />

</div>
<!-- ------------ TERMINA CONTENIDO PRINCIPAL ------------------- -->
<!-- ----------------------------------------------------------- -->
@section('scripts')

@endsection
