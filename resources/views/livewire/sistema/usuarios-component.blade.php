<div>
    <h1>Usuarios</h1>
    <!-- ------------------------------------------------------------------------------------ -->
    <!-- -------------------------------- BUSCAR USUARIO ------------------------------------- -->
    <!-- ------------------------------------------------------------------------------------ -->
    <div class="row">
    </div>

    <!-- ------------------------------------------------------------------------------------ -->
    <!-- -------------------------------- EDITA USUARIO ------------------------------------- -->
    <!-- ------------------------------------------------------------------------------------ -->

    @if($VerEditUsr=='1')
        <div class="my-4">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-4 form-group">
                    <label class="form-label">Correo <red>*</red> (único)</label>
                    <input wire:model="correo" type="text" class="form-control">
                    @error('correo')<error>{{ $message }}</error>@enderror
                </div>
                <div class="col-12 col-sm-6 col-md-4 form-group">
                    <label class="form-label">Nombre de usuario <red>*</red> (único) </label>
                    <input wire:model="usrname" type="text" class="form-control">
                    @error('usrname')<error>{{ $message }}</error>@enderror
                </div>
                <div class="col-12 col-sm-6 col-md-4 form-group">
                    <label class="form-label">Nombre<red>*</red> </label>
                    <input wire:model="nombre" type="text" class="form-control">
                    @error('nombre')<error>{{ $message }}</error>@enderror
                </div>
                <div class="col-12 col-sm-6 col-md-4 form-group">
                    <label class="form-label">Apellido <red>*</red> </label>
                    <input wire:model="apellido" type="text" class="form-control">
                    @error('apellido')<error>{{ $message }}</error>@enderror
                </div>
                <div class="col-12 col-sm-6 col-md-4 form-group">
                    <label class="form-label">Organización</label>
                    <select wire:model="org" class="form-select">
                        @foreach ($orgs as $o)
                            <option value="{{ $o->cins_id }}">{{ $o->cins_institucion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-4 form-group">
                    <br>
                    <div class="form-check">
                        <input class="form-check-input" wire:model="act" type="radio" value="1">
                        <label class="form-check-label">
                        Usuario Activo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" wire:model="act" type="radio" value="0">
                        <label class="form-check-label" for="flexRadioDefault2">
                        Usuario Inactivo
                        </label>
                    </div>
                </div>
            </div>

            <!-- ------------------------ Roles ------------------------ -->
            <!-- ------------------------ Roles ------------------------ -->
            <div class="row">
                <h3>Roles:</h3>

                <div class="col-12 form-group">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Rol</th>
                                <th>Característica</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles->where('rol_usrid',$this->usrID) as $r)
                                <tr>
                                    <td>
                                        {{ $r->rol_crolrol }}
                                    </td>
                                    <td>
                                        {{ $r->rol_tipo1 }}
                                        @if($r->rol_tipo2 != "") : <b>{{ $r->rol_tipo2 }}</b>   {{ $catLenguas->where('clen_code',$r->rol_tipo2)->value('clen_lengua') }}@endif
                                    </td>
                                    <td>
                                        <button  wire:click="BorraRol({{ $r->rol_id }})" wire:confirm="Estás por quitarle definitivamente el rol de {{ $r->rol_crolrol }} a este usuario ¿Deseas continuar?" class="btn btn-secondary btn-sm">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- ---------- Nuevo Rol ------------->
                <div class="col-4">
                    <select wire:model.live="NewRol" class="form-select">
                        <option value="">Asigna un nuevo rol</option>
                        @foreach ($catRoles as $cat)
                            <option value="{{ $cat->crol_rol }}"> {{ $cat->crol_rol }}</option>
                        @endforeach
                    </select>
                    @error('NewRol')<error>{{ $mesagge }}</error>@enderror
                    {{ $catRoles->where('crol_rol',$NewRol)->value('crol_describe') }}
                </div>
                <!-- ---------- Nuevo Rol: jardin ------------->
                @if(in_array($NewRol,['cedulas','traduce']))
                    <div class="col-4">
                        <select wire:model.live="NewRolJardin" class="form-select">
                            <option value="">Indica un jardin</option>
                            @foreach ($catJards as $cat)
                                <option value="{{ $cat->cjar_siglas }}"> {{ $cat->cjar_nombre }}</option>
                            @endforeach
                            @if($NewRol=='cedulas')
                                <option value="todas"> Todos los jardines</option>
                            @endif
                        </select>
                        @error('NewRolJardin')<error>{{ $mesagge }}</error>@enderror
                    </div>
                @endif

                <!-- ---------- Nuevo Rol: lengua ------------->
                @if(in_array($NewRol, ['traduce']))
                    <div class="col-4">
                        <select wire:model="NewRolLengua" class="form-select">
                            <option value="">Indica una lengua</option>
                            @foreach ($catLenguas as $cat)
                                <option value="{{ $cat->clen_code }}"> {{ strtolower($cat->clen_lengua) }}</option>
                            @endforeach
                        </select>
                        @error('NewRolLengua')<error>{{ $mesagge }}</error>@enderror
                    </div>
                @endif
            </div>

            <div class="row my-4">
                <div class="col-12 col-sm-3">
                    <a href="/usuarios" class="nolink"> <i class="bi bi-arrow-return-left"></i> Regresar a Usuarios</a>
                </div>

                <div class="col-12 col-sm-3">
                    <button wire:click="GuardaEdit()" class="btn btn-primary">
                        <span wire:loading.remove> Guardar </span>
                        <span wire:loading style="display:none;"> <red> ..guardando...</red> </span>
                    </button>
                </div>

                <div class="col-12 col-sm-3">
                    <button wire:click="CancelaEdit()" class="btn btn-secondary">
                        Cancelar
                    </button>
                </div>

            </div>
        </div>
    @endif


    <!-- ------------------------------------------------------------------------------------ -->
    <!-- ----------------------------- TABLA DE USUARIOS ------------------------------------ -->
    <!-- ------------------------------------------------------------------------------------ -->
    @if($VerEditUsr=='0')
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>email</th>
                    <th>usr</th>
                    <th>Nombre</th>
                    <th>Rol(es)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usr)
                    <tr>
                        <td class="PaClick" wire:click="IniciaEdit('{{ $usr->id }}')">
                            @if($usr->act == '1')<i class="bi bi-eye"></i> @else <i class="bi bi-eye-slash-fill"></i> @endif
                            {{ $usr->id }}
                        </td>
                        <td class="PaClick" wire:click="IniciaEdit('{{ $usr->id }}')">
                            <span >
                                {{ $usr->email }}
                            </span>
                        </td>
                        <td class="PaClick" wire:click="IniciaEdit('{{ $usr->id }}')">
                            {{ $usr->usrname }}
                        </td>
                        <td class="PaClick" wire:click="IniciaEdit('{{ $usr->id }}')">
                            {{ $usr->nombre }} {{ $usr->apellido }}
                        </td>
                        <td class="PaClick" wire:click="IniciaEdit('{{ $usr->id }}')">
                            @foreach ($roles->where('rol_usrid',$usr->id)  as $rol)
                                <b>{{ $rol->rol_crolrol }}</b>
                                @if($rol->rol_tipo1 != '' OR $rol->rol_tipo2 != '')
                                    [ {{ $rol->rol_tipo1 }}
                                    @if($rol->rol_tipo2 != '')
                                    : {{ $rol->rol_tipo2 }}
                                    @endif
                                    ]
                                @endif
                                &nbsp; | &nbsp;
                            @endforeach
                            <i class="bi bi-pencil-square"></i>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
