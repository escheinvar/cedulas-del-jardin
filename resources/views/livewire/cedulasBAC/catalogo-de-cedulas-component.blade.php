<div>
    <h1>Catálogo de cédulas</h1>
    <b>Usuario</b>:{{ Auth::user()->email }}<br>
    {{-- <b>Jardines</b>: {{ implode(', ',$autorizados) }}<br> --}}

    @if(in_array('cedulas', session('rol')))
        <b>Rol Cédulas</b>: {{ implode(" | ",$roles_ced->pluck('rol_tipo1')->toArray()) }} | <br>
    @endif
    @if(in_array('traduce', session('rol')))
        <b>Rol Traductor </b>:
        @foreach ($roles_tra as $rol)
             {{ $rol->rol_tipo1 }}:{{ $rol->rol_tipo2 }} &nbsp; | &nbsp;
        @endforeach  <br>
    @endif

    <div class="container">
        <!-- ------------------------------------------------------------------------------------------------ -->
        <!-- ------------------------------------------------------------------------------------------------ -->
        <!-- --------------------------------- FORMULARIO DE NUEVA CÉDULA ----------------------------------- -->
        <!-- ------------------------------------------------------------------------------------------------ -->
        <!-- ------------------------------------------------------------------------------------------------ -->
        @if( in_array('cedulas', session('rol')) )
            <div class="row py-2">
                <div class="col-7 col-sm-8 col-md-9 col-lg-10">
                </div>
                <!-- NUEVA CÉDULA -->
                @if($VerCrearCedula=='0')
                    <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                        <button wire:click="VerCrearNuevaCedula()" onclick="VerNoVerBAC('nva','cedula')" class="btn btn-primary" class="float:rigth;">
                            Nueva cédula
                        </button>
                    </div>
                @endif
            </div>

            <!-- --------------------- FORMULARIO DE NUEVA CÉDULA -------------------------- -->
            <!-- --------------------- FORMULARIO DE NUEVA CÉDULA -------------------------- -->
            <!-- --------------------- FORMULARIO DE NUEVA CÉDULA -------------------------- -->
            @if($VerCrearCedula=='1')
                <div id="sale_nvacedula" style="">
                    <div class="row py-4"  >
                        <!-- Selector de Tema -->
                        <div class="col-12 col-sm-4 form-group">
                            <label class="form-label"> Tema</label><br>
                            <select wire:model.live="NvoTema" class="form-select" style="width:80%; display:inline;">
                                <option value="">Indicar un tema</option>
                                @foreach ($temas as $t)
                                    @if($t->url_act == '1')
                                        <option value="{{ $t->url_url }}">{{ $t->url_nombre }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <!-- botón agregar nuevo tema-->
                            <i wire:click="ActivarNuevoTema()" class="bi bi-plus-circle PaClick" style="padding:5px;"></i>
                            @error('NvoTema')<br><error>{{ $message }}</error>@enderror
                        </div>

                        <!-- Selector de Jardín -->
                        <div class="col-12 col-sm-4 form-group">
                            <label class="form-label"> Jardín</label><br>
                            <select wire:model="NvoJardin" class="form-select" style="width:80%; display:inline;">
                                <option value="">Indicar un Jardín</option>
                                @foreach ($jardines as $j)
                                    <option value="{{ $j->cjar_siglas }}">{{ $j->cjar_nombre }} ({{ $j->cjar_siglas }})</option>
                                @endforeach
                            </select>

                            <!-- botón agregar nuevo Jardin-->
                            @if(in_array('admin',session('rol')) )
                                <a href="/catalogo/campus" class="nolink">
                                    <i class="bi bi-plus-circle PaClick" style="padding:5px;"></i>
                                </a>
                                @error('NvoJardin')<br><error>{{ $message }}</error>@enderror
                            @endif
                        </div>

                        <!-- Selector de Lengua -->
                        <div class="col-12 col-sm-4 form-group">
                            <label class="form-label"> Lengua</label><br>
                            <select wire:model="NvoLengua" class="form-select" style="width:80%; display:inline;">
                                <option value="">Indicar una lengua</option>
                                @foreach ($CatLenguas as $l)
                                    <option value="{{ $l->clen_code }}">{{ strtolower($l->clen_lengua) }} ({{ strtolower($l->clen_code) }})</option>
                                @endforeach
                            </select>
                            @error('NvoLengua')<br><error>{{ $message }}</error>@enderror
                        </div>

                        <!-- cedula nueva o copiar cédula -->
                        <div class="col-12 col-sm-3 form-group">
                            <label class="form-label"> Indica origen</label>
                            <div class="form-check">
                                <input wire:model.live="NvoCopia" class="form-check-input" value="0" type="radio"  checked>
                                <label class="form-check-label" for="exampleRadios1">
                                Cédula nueva
                                </label>
                            </div>
                            <div class="form-check">
                                <input wire:model.live="NvoCopia" class="form-check-input" value="1" type="radio">
                                <label class="form-check-label" for="exampleRadios2">
                                Copiar existente
                                </label>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4 form-group">
                            <!-- listado de cédulas a copiar -->
                            @if($NvoCopia=='1')
                                <label class="form-label">
                                    Copiar la siguiente cédula:
                                </label>
                                <select wire:model="NvoCopia2" class="form-select">
                                    <option value="">Indicar cédula de origen</option>
                                    @foreach ($cedulas->where('ced_urlurl',$NvoTema) as $c)
                                        <option value="{{ $c->ced_id }}">{{ $c->ced_urlurl }} {{ $c->ced_cjarsiglas }}: {{ $c->ced_clencode }}  {{ $CatLenguas->where('clen_code',$c->ced_clencode)->value('clen_lengua') }}</option>
                                    @endforeach
                                </select>
                                @error('NvoCopia2')<br><error>{{ $message }}</error>@enderror
                            @endif
                        </div>

                        <div class="col-0 col-sm-5 form-group">
                        </div>

                        <div class="col-4 form-group my-3">
                            <button wire:click="GeneraCedula()" wire:model="Valida" class="btn btn-primary">
                                Generar nueva cédula</button>
                            @error('Valida')<br><error>{{ $message }}</error>@enderror
                        </div>

                        <div class="col-4 form-group my-3">
                            <button wire:click="CancelarNuevaCedula()" wire:model="Valida" class="btn btn-secondary">Cancelar nueva cédula</button>
                        </div>
                    </div>
                </div>
            @endif
            <!-- --------------------- Nuevo tema -------------------------- -->
            <!-- --------------------- Nuevo tema -------------------------- -->
            <!-- --------------------- Nuevo tema -------------------------- -->
            <a name="nuevotema"> </a>
            @if($VerNuevoTema=='1')
                <div class="row">
                    <h3>Crear nuevo tema</h3>
                    <div class="col-12 col-sm-6 col-md-4 form-group">
                        <label class="form-label">Nombre del tema <red>*</red> </label>
                        <input wire:model="urlNombre" type="text" class="form-control">
                        <div style="font-size:80%; color:rgb(78, 78, 78)">Nombre corto del tema. No más de 5 palabras. Ej: Abejas sin aguijón</div>
                        @error('urlNombre')<error>{{ $message }}</error>@enderror
                    </div>

                    <div class="col-12 col-sm-6 col-md-4 form-group">
                        <label class="form-label">Dirección URL <red>*</red> </label>
                        <input wire:model.live="urlUrl" type="text" class="form-control">
                        <div style="font-size:80%; color:rgb(78, 78, 78)">Nombre del tema en minúsculas, sin espacios, acentos, eñes o caracteres. El nombre no debe estar registrado previamente. Ej: abejasinaguijon</div>
                        @error('urlUrl')<error>{{ $message }}</error>@enderror
                    </div>

                    <div class="col-12 col-sm-6 col-md-4 form-group">
                        <label class="form-label">Tipo <red>*</red></label>
                        <select wire:model.live="urlReino" class="form-select">
                            <option value=""> Indicar tipo</option>
                            <option value="pl">Plantas (Reino Plantae)</option>
                            <option value="an">Animales (Reino Animalia)</option>
                            <option value="fu">Hongos (Reino Fungi)</option>
                            <option value="pr">Reino Protista</option>
                            <option value="mo">Bacterias eucariotas (Reino Monera)</option>
                            <option value="ar">Arqueas (Bacterias)</option>
                            <option value="lu">Lugar</option>
                            <option value="pr">Proceso</option>
                            <option value="us">Uso</option>
                            <option value="le">Lengua</option>
                            <option value="none">Otro</option>
                        </select>
                        <div style="font-size:80%; color:rgb(78, 78, 78)">Seleccionar una de las opciones de tipo de cédula. </div>
                        @error('urlReino')<error>{{ $message }}</error>@enderror
                    </div>

                    @if( in_array($urlReino, ['pl']))
                        <div class="col-12 col-sm-6 col-md-4 form-group">
                            <label class="form-label">Genero</label><br>
                            <input wire:model="urlGenero" type="text" class="form-control" style="width:70%; display:inline;">
                            <button wire:click="BuscaSpPlanta()" wire:loading.attr="disabled" class="btn btn-sm btn-primary">Buscar</button>
                            <div style="display:none;" wire:loading> <error>Cargando género...Espera.</error> </div>
                            <div style="font-size:80%; color:rgb(78, 78, 78)"> Escribe el género (o parte de él) y pica en Buscar.</div>
                            @error('urlGenero')<error>{{ $message }}</error>@enderror
                        </div>

                        <div class="col-12 col-sm-6 col-md-4 form-group">
                            <label class="form-label">Genero y especie</label>
                            <select wire:model="urlSp" type="text" class="form-select">
                                @if($urlGeneros->count() < 1) <option value="">Debes buscar un género primero</option> @else <option value="">Indicar la especie</option> @endif
                                @foreach ($urlGeneros as $g)
                                    <option value="{{ $g->ckew_taxonid }}">{{ $g->ckew_scientfiicname }}</option>
                                @endforeach
                            </select>
                            <div style="font-size:80%; color:rgb(78, 78, 78)"></div>
                            @error('urlSp')<error>{{ $message }}</error>@enderror
                        </div>
                    @elseif(in_array($urlReino, ['','an','fu','pr','mo','ar']))
                        <div class="col-12 col-sm-12 col-md-8 form-group">
                            <label class="form-label">Género y especie</label>
                            <input wire:model="urlSciname" type="text" class="form-control">
                            <div style="font-size:80%; color:rgb(78, 78, 78)">Escribe el nombre científico (género iniciando en mayúscula, especie y en su caso variedad o subespecie) Ej. Agave lechuguilla </div>
                            @error('urlSciname')<error>{{ $message }}</error>@enderror
                        </div>
                    @else
                        <div class="col-12 col-sm-12 col-md-8 form-group">
                            <label class="form-label">Texto descriptor único</label>
                            <input wire:model="urlSciname" type="text" class="form-control">
                            <div style="font-size:80%; color:rgb(78, 78, 78)">Escribe el nombre específico (y único) al que refiere la cédula</div>
                            @error('urlSciname')<error>{{ $message }}</error>@enderror
                        </div>
                    @endif

                    <div class="col-12 col-sm-6 col-md-4 form-group">
                        <label class="form-label">Nombre común</label>
                        <input wire:model="urlNombrecomun" type="text" class="form-control">
                        <div style="font-size:80%; color:rgb(78, 78, 78)">Escribe el nombre común de la cédula (en caso de haberlo)</div>
                        @error('urlNombrecomun')<error>{{ $message }}</error>@enderror
                    </div>

                    <div class="col-12 form-group">
                        <label class="form-label">Palabras clave</label>
                        <input wire:model="urlpalabras" type="text" class="form-control">
                        <div style="font-size:80%; color:rgb(78, 78, 78)">Listado de palabras clave separadas por punto y coma que serán utilizadas por los usuarios para encontrar la cédula. Ej: Agave; Maguey; Agave lechuguilla; Ixtle; Desierto Chihuahuense; </div>
                        @error('urlpalabras')<error>{{ $message }}</error>@enderror
                    </div>

                    <div class="col-12 form-group my-3">
                        @if($roles_ced->where('rol_tipo1','todas')->count() == 0)
                            <div>
                                <error>
                                    El tema quedará como borrador hasta que el administrador lo autorice.
                                </error>
                            </div>
                        @endif

                        <button wire:click="GuardarNuevoTema()" class="btn btn-primary"   style="margin:5px;">@if($urlId=='0')Crear @else Autorizar @endif nuevo tema</button>
                        @if($urlId == '0')
                            <button wire:click="CancelarNuevoTema()" class="btn btn-secondary" style="margin:5px;">Cancelar nuevo tema</button>
                        @else
                            <button wire:click="EliminarNuevoTema('{{ $urlId }}')" wire:confirm="Esta acción borrará definitivamente el tema, sus cédulas e información definitivamente de la base de datos y NO SE PODRÁ RECUPERAR. ¿Deseas continuar?" class="btn btn-secondary" style="margin:5px;"> <i class="bi bi-trash"></i>Eliminar el tema</button>
                        @endif
                    </div>


                </div>
            @endif
        @endif

        <!-- ------------------------------------------------------------------------------------------------ -->
        <!-- ------------------------------------------------------------------------------------------------ -->
        <!-- -------------------------------- TABLA DE CÉDULAS EXISTENTES ----------------------------------- -->
        <!-- ------------------------------------------------------------------------------------------------ -->
        <!-- ------------------------------------------------------------------------------------------------ -->
        <div class="row my-4">
            <table class="table table-striped">
                <tbody>
                    @foreach ($temas as $tema)
                        <tr>
                            <td>
                                <div  style="">
                                    {{-- {{ $tema->url_id }} --}}
                                    <span style="font-size:125%; @if($tema->url_act =='1') font-weight:bold; @else color:gray; @endif">
                                        {{ $tema->url_nombre }}
                                    </span>
                                    <span style="@if($tema->url_act =='0') color:gray; @endif">
                                        &nbsp; [/{{ $tema->url_url }}]
                                    </span>
                                    @if($tema->url_act =='0')
                                        <br><error> -- Esperando autorización --</error>
                                        @if($roles_ced->where('rol_tipo1','todas')->count()>0)
                                        <a href="#nuevotema" class="nolink">
                                            <div wire:click="EditarNuevoTema('{{ $tema->url_id }}')" class="PaClick">
                                                <i class="bi bi-pencil-square"></i> Revisar Tema
                                            </div>
                                        </a>
                                        @endif
                                    @endif

                                </div>
                                <div style="vertical-align: top;">
                                    @foreach ($cedulas->where('ced_urlurl',$tema->url_url)->unique('ced_cjarsiglas') as $jardin)
                                        <!--  --------------------------- LISTA DE JARDINES  --------------------------- -->
                                        <!--  --------------------------- LISTA DE JARDINES  --------------------------- -->
                                        <div class="m-2 mx-4" style="display: inline-block;">
                                            <span id="entra_Cedula{{ $tema->url_url }}{{ $jardin->ced_cjarsiglas }}" onclick="VerYocultar('Cedula','{{ $tema->url_url }}{{ $jardin->ced_cjarsiglas }}')" class="PaClick">
                                                <img src="@if($jardin->cjar_logo=='')/avatar/jardines/default.png @else /avatar/jardines/{{ $jardin->cjar_logo }}@endif" style="width:30px;">
                                                {{ $jardin->ced_cjarsiglas }}
                                            </span>
                                        </div>
                                        <!-- --------------------------- SECCIÓN OCULTA DE CÉDULAS DEL JARDÍN --------------------------- -->
                                        <!-- --------------------------- SECCIÓN OCULTA DE CÉDULAS DEL JARDÍN --------------------------- -->
                                        <div id="sale_Cedula{{ $tema->url_url }}{{ $jardin->ced_cjarsiglas }}" style="display:none" class="m-d mx-4">
                                            <div onclick="VerYocultar('Cedula','{{ $tema->url_url }}{{ $jardin->ced_cjarsiglas }}')" class="PaClick">
                                                <img src="@if($jardin->cjar_logo=='')/avatar/jardines/default.png @else /avatar/jardines/{{ $jardin->cjar_logo }}@endif" style="width:30px;">
                                                {{ $jardin->ced_cjarsiglas }}
                                            </div>
                                            <!-- --------------------------- MUESTRA CADA CÉDULA DE CADA JARDÍN --------------------------- -->
                                            <!-- --------------------------- MUESTRA CADA CÉDULA DE CADA JARDÍN --------------------------- -->
                                            @foreach ($cedulas->where('ced_urlurl',$tema->url_url)->where('ced_cjarsiglas',$jardin->ced_cjarsiglas) as $c)
                                                <div class="py-2" style="display: inline-block;width:300px;background-color:#CDC6B9;padding:5px;margin:3px;">
                                                    <!-- estado de la cédula -->
                                                    <div style="">
                                                        @if($c->ced_edo=='0')     <i class="bi bi-0-circle-fill" style="color:red;"> En elaboración</i>    <!-- 0 -->
                                                        @elseif($c->ced_edo=='1') <i class="bi bi-1-circle-fill" style="color:#CD7B34;">En corrección</i>   <!-- 1 -->
                                                        @elseif($c->ced_edo=='2') <i class="bi bi-2-circle-fill" style="color:purple;;">En revisión</i> <!-- 2 -->
                                                        @elseif($c->ced_edo=='3') <i class="bi bi-3-circle-fill" style="color:#CD7B34;">En edición</i>        <!-- 3 -->
                                                        @elseif($c->ced_edo=='4') <i class="bi bi-4-circle-fill" style="color:purple;">En revisión</i> <!-- 4 -->
                                                        @elseif($c->ced_edo=='5') <i class="bi bi-5-circle-fill" style="color:darkgreen;"> Públicada</i>   <!-- 5 -->
                                                        @endif

                                                        @if($c->ced_doi !='') &nbsp; &nbsp;  <b> doi {{ $c->ced_doi }} </b>@endif
                                                    </div>
                                                    <!-- url, lengua y siglas de jardin -->
                                                    <div>
                                                        ID {{ $c->ced_id }}: &nbsp; {{ $c->ced_urlurl }} /  {{ $c->ced_cjarsiglas }}  /  {{ $c->ced_clencode }}
                                                    </div>
                                                    <!-- nombre de la lengua -->
                                                    <div>
                                                        {{ $CatLenguas->where('clen_code',$c->ced_clencode)->value('clen_lengua') }}
                                                    </div>
                                                    <div>
                                                        <!-- botón de editar para rol cedula -->
                                                        @if(in_array($c->ced_cjarsiglas, $roles_ced->pluck('rol_tipo1')->toArray())
                                                            OR    in_array('todas',  $roles_ced->pluck('rol_tipo1')->toArray())
                                                            OR   ($roles_tra->where('rol_tipo1', $c->ced_cjarsiglas)->where('rol_tipo2',$c->ced_clencode)->count() > 0 AND ($c->ced_edo < 2 OR $c->ced_edo == 3) )   )
                                                            <div style="display:inline-block;margin:10px;">
                                                                @if($c->ced_doi != '' AND !in_array('todas',  $roles_ced->pluck('rol_tipo1')->toArray()))
                                                                    DOI
                                                                @else

                                                                    <i wire:click="IniciarEdicion('{{ $c->ced_id }}')" @if($c->ced_edo == '5') wire:confirm="La cédula no estará disponible al público durante la edición. ¿Deseas comenzar a editar?" @endif class="bi bi-pencil-square PaClick" style="margin:7px;">
                                                                        editar
                                                                    </i>

                                                                @endif
                                                            </div>
                                                        @endif

                                                        <!-- botón iniciar edición para rol traduce -->
                                                        @if($c->ced_edo =='5' AND ($roles_tra->where('rol_tipo1', $c->ced_cjarsiglas)->where('rol_tipo2',$c->ced_clencode)->count() > 0) )
                                                            <div style="display:inline-block;margin:10px;">
                                                                <i  wire:click="IniciarEdicion('{{ $c->ced_id }}')" @if($c->ced_edo == '5')  wire:confirm="La cédula no estará disponible al público durante la edición. ¿Deseas comenzar a editar?" @endif class="bi bi-pencil-square PaClick" style="margin:7px;" class="PaClick">
                                                                    Iniciar edición
                                                                </i>
                                                            </div>
                                                        @endif
                                                        <!-- botón de ver-->
                                                        <div style="display:inline-block;margin:10px;">
                                                            <i class="bi bi-box-arrow-up-right" wire:click="IrConLengua('{{ $c->ced_clencode }}','{{ $c->ced_urlurl }}', '{{ $c->ced_cjarsiglas }}')" style="padding:7px; cursor: pointer;" class="PaClick">ver</i>
                                                        </div>
                                                        <!-- botón de borrar-->
                                                        @if(in_array($c->ced_cjarsiglas, $roles_ced->pluck('rol_tipo1')->toArray())   OR   in_array('todas',  $roles_ced->pluck('rol_tipo1')->toArray()) )
                                                            <div style="display:inline-block;margin:10px;" onclick="VerNoVer('Borrar','{{ $c->ced_id }}')" wire:click="" wire:confirm="Estás por eliminar PERMANENTEMENTE la cédula, sus textos, imágenes y videos. Como esto es irreversible, vas a tener que confirmar esta acción haciendo clic en el botón que dice Si, borrar.¿Seguro que quieres continuar?.">
                                                                <i class="bi bi-trash" style="padding:7px; cursor: pointer;" class="PaClick">eliminar</i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div id="sale_Borrar{{ $c->ced_id }}" style="display: none;">
                                                        @if(in_array($c->ced_cjarsiglas, $roles_ced->pluck('rol_tipo1')->toArray())   OR   in_array('todas',  $roles_ced->pluck('rol_tipo1')->toArray()) )
                                                            <button wire:click="BorrarCedula('{{ $c->ced_id }}')" wire:confirm="Nuevamente, ¿estas seguro? Si picas continuar, esta cédula será eliminada." class="btn btn-danger btn-sm">Si, Borrar</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
