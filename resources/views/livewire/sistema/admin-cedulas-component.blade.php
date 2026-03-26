@section('title') Admin Cedulas @endsection
@section('meta-description') Administrador de cédulas del SiCedJar @endsection
@section('cintillo-ubica') -> {{ request()->path() }} @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection
<div>
    <h2>Administración de cédulas del jardín</h2>
    <div style="font-size: 80%;color:grey;">
        Este catálogo es administrado por los roles <b>editor</b>, <b>admin</b> en jardin: {{ implode(',',$editjar) }}
        (@if($edit=='0') <error style="font-size: 90%;"> No autorizado</error> @else <span style="font-size:90%;color:green;"> Autorizado </span>@endif)
    </div>


    <div class="row my-3">
        <!-- buscar por jardín -->
        <div class="col-6 col-md-3 form-group">
            <label for="jardinSel" class="form-label">Jardin<red>*</red></label>
            <select wire:model.live="jardinSel" id="jardinSel" class="form-select">
                <option value="">Indica un jardín</option>
                @foreach($JardsDelUsr as $jar)
                    <option value="{{ $jar->cjar_siglas }}">{{ $jar->cjar_siglas }} ({{ $jar->cjar_name }})</option>
                @endforeach
                @if(in_array('todos',$editjar))
                    <option value="%">Todos</option>
                @endif
            </select>
        </div>

        <!-- buscar por lengua -->
        <div class="col-6 col-md-3 form-group">
            <label for="" class="form-label">Lengua</label>
            <select wire:model.live="BuscaLengua" id="BuscaLengua" class="form-select">
                <option value="">En todas</option>
                @foreach($lenguas as $len)
                    <option value="{{ $len->len_code }}">{{ $len->len_lengua }} ({{ $len->len_code }})</option>
                @endforeach
            </select>
        </div>

        <!-- buscar por estado -->
        <div class="col-6 col-md-3 form-group">
            <label for="" class="form-label">Estado</label>
            <select wire:model.live="BuscaEstado" id="" class="form-select">
                <option value="">En todos</option>
                <option value="0">0 En creación (autor/traductor)</option>
                <option value="1">1 En edición (editor)</option>
                <option value="2">2 En revisión (autor/traductor)</option>
                <option value="3">3 En edición2 (editor)</option>
                <option value="4">4 En Autorización (Administrador)</option>
                <option value="5">5 Publicada</option>
                <option value="6">6 Publicada Solicita Edición</option>
            </select>
            @if($abiertos->where('url_edit','1')->count() > '0')
                <error style="font-size: 90%;">
            @endif
            Hay {{ $abiertos->where('url_edit','1')->count() }} @if($abiertos =='1' ) página @else páginas  @endif en edición
            y {{ $abiertos->where('url_edo','<','5')->count() }} en proceso
            </error>

        </div>

        <!-- buscar por texto -->
        <div class="col-6 col-md-3 form-group">
            <label for="" class="form-label">Buscar por texto</label>
            <input wire:model.live="BuscaTexto" id="" class="form-control" type="text">
        </div>
    </div>

    <!-- ----------------- El ciclo de la cédula -------------------- -->
    <div class="row">
        <div class="col-12" style="background-color:#CDC6B9;text-align:center;"><b>El ciclo de publicación de una cédula</b></div>
        <div class="col-0 col-md-3"> &nbsp; </div>

        <div class="col-3 col-md-1 cedEdoIcon0" style="text-align:center;font-size:80%;">
            <div class="cedEdo0" style="font-size: 80%;">Autor/Traductor</div>
        </div>
        <div class="col-3 col-md-1 cedEdoIcon1" style="text-align:center;font-size:80%;">
            <div class="cedEdo1" style="font-size: 80%;">Editor</div>
        </div>
        <div class="col-3 col-md-1 cedEdoIcon2" style="text-align:center;font-size:80%;">
            <div class="cedEdo2" style="font-size: 80%;">Autor/Traductor</div>
        </div>
        <div class="col-3 col-md-1 cedEdoIcon3" style="text-align:center;font-size:80%;">
            <div class="cedEdo3" style="font-size: 80%;">Editor</div>
        </div>
        <div class="col-3 col-md-1 cedEdoIcon4" style="text-align:center;font-size:80%;">
            <div class="cedEdo4" style="font-size: 80%;">Administrador</div>
        </div>
        <div class="col-3 col-md-1 cedEdoIcon5" style="text-align:center;font-size:80%;">
            <div class="cedEdo5" style="font-size: 80%;">Administrador</div>
        </div>
        <div class="col-3 col-md-1 cedEdoIcon6" style="text-align:center;font-size:80%;">
            <div class="cedEdo6" style="font-size: 80%;"></div>
        </div>
    </div>

    <!-- -------------------- botón de nueva cédula ------------------------ -->
    <div class="clearfix" style="">
        @if($edit=='1' and $jardinSel != '%' and $jardinSel != '')
            <div style="float: right;" class="my-3">
                <button wire:click="AbreModalCedula('0','{{ $jardinSel }}')" class="btn btn-secondary">
                    <i class="bi bi-plus-circle"></i> cédula
                </button>
            </div>
        @endif
    </div>

    <!-- ------------------------------------------------------------------------------------ -->
    <!-- ----------------------- TABLA DE CÉDULAS LOS JARDÍNES ------------------------------ -->
    <!-- ------------------------------------------------------------------------------------ -->
    <div class="table-responsive-sm"  style="clear:both;">
        <table class="table table-striped table-sm my-4">
            <thead>
                <tr>
                    <th wire:click="ordenaTabla('url_id')" class="PaClick">Id</th>
                    <th></th>
                    <th wire:click="ordenaTabla('url_id')" class="PaClick">Jardin</th>
                    <th wire:click="ordenaTabla('url_url')" class="PaClick">url</th>


                    <th wire:click="ordenaTabla('')" class="PaClick">Lengua</th>
                    <th wire:click="ordenaTabla('url_titulo')" class="PaClick">Titulo</th>
                    <th wire:click="ordenaTabla('url_tipo')" class="PaClick">Tipo</th>
                    <th wire:click="ordenaTabla('url_descrip')" class="PaClick">Estado</th>
                    <th> Acción </th>
                    <th wire:click="ordenaTabla('urlO_descrip')" class="PaClick"> Dirección </th>
                    <th>Ciclo (V.0)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($urls as $u)
                    <tr wire:key="url{{ $u->url_id }}">
                        <!-- id -->
                        <td class="@if($u->url_act=='0') inact @endif">
                            {{ $u->url_id }}
                        </td>

                        <!-- editar -->
                        <td class="@if($u->url_act=='0') inact @endif">

                            <!-- Verifica autores, editores y traductores -->
                            <div wire:click="AbreModalCedula('{{ $u->url_id }}','{{ $u->url_cjarsiglas }}')" class="PaClick">
                                @if($u->autores->count() =='0' OR
                                    $u->editores->count() =='0' OR
                                    ($u->url_tradid=='1' AND $u->traductores->count() =='0') OR
                                    ($u->ubicaciones->count() == '0') OR
                                    ($u->alias->count()=='0')
                                )
                                    <i class="bi bi-exclamation-octagon-fill" style="color:#CD7B34"></i>
                                @else
                                    <i wire:click="AbreModalCedula('{{ $u->url_id }}','{{ $u->url_cjarsiglas }}')" class="bi bi-pencil-square PaClick"></i>
                                @endif
                            </div>
                        </td>

                        <!-- jardin -->
                        <td class="@if($u->url_act=='0') inact @endif">
                            {{ $u->url_cjarsiglas }}
                        </td>

                        <!-- url -->
                        <td>
                            {{ $u->url_url }}
                            <div style="color:gray;font-size:80%;">
                                @if($u->url_tradid=='0')
                                    Original
                                @else
                                    Traducción
                                @endif
                            </div>
                        </td>

                        <!-- lengua -->
                        <td>
                            {{ $u->lenguas->len_lengua }}
                            <div style="color:gray;font-size:80%;">
                                {{ $u->lenguas->len_code }}
                            </div>
                        </td>
                        <!-- titulo -->
                        <td>
                            <div wire:click="AbreModalCedula('{{ $u->url_id }}','{{ $u->url_cjarsiglas }}')" class="PaClick">
                                {{ $u->url_titulo }}
                            </div>
                        </td>

                        <!-- tipo -->
                        <td>
                            <div wire:click="AbreModalCedula('{{ $u->url_id }}','{{ $u->url_cjarsiglas }}')" class="PaClick">
                                {{ $u->url_ccedtipo }}
                            </div>
                        </td>
                        <!-- estado -->
                        <td  class="@if($u->url_act=='0') inact @endif">
                            <!-- ------------------------- Muestra estado actual --------------------- -->
                            {{-- <span class="cedEdo{{ $u->url_edo }}">{{ $u->url_edo }}</span> --}}
                            @if($u->url_edo =='0')
                                <div class="cedEdoIcon0" style="text-align:center;font-size:80%;">
                                    {{ $u->url_edo }}<div class="cedEdo0" style="font-size: 80%;">Autor/Traductor</div>
                                </div>
                            @elseif($u->url_edo =='1')
                                <div class="cedEdoIcon1" style="text-align:center;font-size:80%;">
                                    <div class="cedEdo1" style="font-size: 80%;">Editor</div>
                                </div>
                            @elseif($u->url_edo =='2')
                                <div class="cedEdoIcon2" style="text-align:center;font-size:80%;">
                                    <div class="cedEdo2" style="font-size: 80%;">Autor/Traductor</div>
                                </div>
                            @elseif($u->url_edo =='3')
                                <div class="cedEdoIcon3" style="text-align:center;font-size:80%;">
                                    <div class="cedEdo3" style="font-size: 80%;">Editor</div>
                                </div>
                            @elseif($u->url_edo =='4')
                                <div class="cedEdoIcon4" style="text-align:center;font-size:80%;">
                                    <div class="cedEdo4" style="font-size: 80%;">Administrador</div>
                                </div>
                            @elseif($u->url_edo =='5')
                                <div class="cedEdoIcon5" style="text-align:center;font-size:80%;">
                                    <div class="cedEdo5" style="font-size: 80%;">Administrador</div>
                                </div>
                            @elseif($u->url_edo =='6')
                                <div class="cedEdoIcon6" style="text-align:center;font-size:80%;">
                                    <div class="cedEdo6" style="font-size: 80%;"></div>
                                </div>
                            @endif
                        </td>

                        <!-- ACCIONES -->
                        <td>
                            <center>
                            @if(array_intersect(['admin'],session('rol')) )
                                <!-- --------------------- acciones del admin ------------------ -->
                                @if(in_array($u->url_edo, ['0','2','4','6'])) <!-- a 1edita -->
                                    <button wire:click="CambiaEstadoCedula('{{ $u->url_id }}','1')" class="cedEdo1 btn btn-sm btn-light" wire:confirm="Estás por enviar la cédula al editor para su edición. ¿Deseas continuar?">
                                        <i class="cedEdoIcon1"></i>
                                    </button>
                                @endif
                                @if(in_array($u->url_edo, ['1','3','4','6'])) <!-- a 2revisa -->
                                    <button wire:click="CambiaEstadoCedula('{{ $u->url_id }}','2')" class="cedEdo2 btn btn-sm btn-light" wire:confirm="Estás por enviar la cédula al autor/traductor para su revisión. ¿Deseas continuar?">
                                        <i class="cedEdoIcon2"></i>
                                    </button>
                                @endif
                                @if(in_array($u->url_edo, ['0','1','2','3','4','6'])) <!-- a 5publica -->
                                    <button wire:click="CambiaEstadoCedula('{{ $u->url_id }}','5')" class="cedEdo5 btn btn-sm btn-light" wire:confirm="Estás por publicar la cédula y podrá ser vista por los visitantes. ¿Deseas continuar?">
                                        <i class="cedEdoIcon5"></i>
                                    </button>
                                @endif
                            @elseif(array_intersect(['editor'],session('rol')) )
                                <!-- -------------------- acciones del editor -------------- -->
                                @if(in_array($u->url_edo, ['1','3','6'])) <!-- a 2revisa -->
                                    <button wire:click="CambiaEstadoCedula('{{ $u->url_id }}','2')" class="cedEdo2 btn btn-sm btn-light" wire:confirm="Estás por enviar la cédula al autor/traductor para su revisión. ¿Deseas continuar?">
                                        <i class="cedEdoIcon2"></i>
                                    </button>
                                @endif
                                @if(in_array($u->url_edo, ['0','1','2','3'])) <!-- a 4revisa -->
                                    <button wire:click="CambiaEstadoCedula('{{ $u->url_id }}','4')" class="cedEdo4 btn btn-sm btn-light" wire:confirm="Estás por enviar la cédula al administrador para autorizar su publicación. ¿Deseas continuar?">
                                        <i class="cedEdoIcon4"></i>
                                    </button>
                                @endif
                            {{-- @elseif(array_intersect(['autor','traductor'],session('rol')) )
                                <!-- -------------------- acciones del Autor/Traductor -------------- -->
                                @if(in_array($u->url_edo, ['0'])) <!-- a 1edita -->
                                    <button wire:click="CambiaEstadoCedula('{{ $u->url_id }}','1')" class="cedEdo1 btn btn-sm btn-light" wire:confirm="Estás por enviar la cédula al editor para su edición. ¿Deseas continuar?">
                                        <i class="cedEdoIcon1"></i>
                                    </button>
                                @endif
                                @if(in_array($u->url_edo, ['3'])) <!-- a 3edita -->
                                    <button wire:click="CambiaEstadoCedula('{{ $u->url_id }}','3')" class="cedEdo3 btn btn-sm btn-light" wire:confirm="Estás por enviar la cédula  al editor para su edición. ¿Deseas continuar?">
                                        <i class="cedEdoIcon3"></i>
                                    </button>
                                @endif --}}
                            @endif
                            @if(in_array($u->url_edo, ['5'])) <!-- a 6solEdit -->
                                <button wire:click="CambiaEstadoCedula('{{ $u->url_id }}','6')" class="cedEdo6 btn btn-sm btn-light" wire:confirm="Estás por solicitar la suspensión de la publicación de la cédula para comenzar la edición.. ¿Deseas continuar?">
                                    <i class="cedEdoIcon6"></i>
                                </button>
                            @endif
                            </center>
                        </td>

                        <!-- URL -->
                        <td class="@if($u->url_act=='0') inact @endif">
                            <a href="{{ url('/') }}/cedula/{{ strtolower($u->url_cjarsiglas) }}/{{ $u->url_url }}" target="new" class="nolink" id="sale_url{{ $u->url_id }}">
                                {{ url('/') }}/cedula/{{ strtolower($u->url_cjarsiglas) }}/{{ $u->url_url }}
                            </a>
                            <i class="bi bi-clipboard PaClick" onclick="CopiarContenido('url','{{ $u->url_id }}')"></i>
                            @if($u->url_doi != '')<b>DOI: {{ $u->url_doi }} @endif
                            <!-- -------------------- switch Modo edición --------------------- -->
                            @if($u->url_edo <='4')
                                <div class="form-check form-switch my-1">
                                    <input  wire:change="CambiaAmodoEdicion('{{ $u->url_id }}')" class="form-check-input" value="1" type="checkbox" role="switch" id="flexSwitchCheckDefault" @if($u->url_edit=='1') checked @endif style="@if($u->url_edit=='1')background-color:red; @endif">
                                    <label class="form-check-label" style="font-size:90%;" for="flexSwitchCheckDefault">@if($u->url_edit=='0') Público @else Editando @endif</label>
                                </div>
                            @endif
                        </td>
                        <td>
                            {{ $u->url_ciclo }} ({{ $u->url_version }}) {{ $u->url_anio }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($urls->count()=='0')
            --- Aún no hay cédulas ---
        @endif
    </div>


    <livewire:sistema.modal-admin-cedula-component>











    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    <!-- ---------------------------- INICIA MODAL DE BUSCAR AUTOR ----------------------- -->
    <!-- -------------------------------------------------------------------------------------- -->
    {{-- <div wire:ignore.self class="modal fade" id="ModalDeBusquedaDeElAutor" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">
                        @if($cedulaId=='0')
                            Buscando {{ $BuscaAutor_tipo }} para cédula nueva
                        @else
                            Buscando autor para cédula Id {{ $cedulaId }}
                        @endif
                        de {{ $jardinSel }}
                    </h3>
                    <button wire:click="CierraModalDeBuscarAutor()" type="button" class="btn-close" data-bs-dismiss="modal"> </button>
                </div>
                <!-- cuerpo del modal -->
                <div class="modal-body">

                        <div class="row">
                            <div class="col-12 col-md-5 form-group">
                                <label for="BuscaAutor_BuscaNombre" class="form-label">Nombre:</label>
                                <input wire:model="BuscaAutor_BuscaNombre" id="BuscaAutor_BuscaNombre" class="@error('BuscaAutor_BuscaNombre') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('BuscaAutor_BuscaNombre')<error>{{ $message }}</error>@enderror
                            </div>

                            <div class="col-12 col-md-5 form-group">
                                <label for="BuscaAutor_BuscaApellido" class="form-label">Apellido:</label>
                                <input wire:model="BuscaAutor_BuscaApellido" id="BuscaAutor_BuscaApellido" class="@error('BuscaAutor_BuscaApellido') is-invalid @enderror form-control">
                                <div class="form-text"></div>
                                @error('BuscaAutor_BuscaApellido')<error>{{ $message }}</error>@enderror
                            </div>

                            <div class="col-12 col-md-2 form-group">
                                <br>
                                <button wire:click="BuscarAutores()" class="btn btn-primary">Buscar</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                @if($BuscaAutor_BuscaNombre != '' OR $BuscaAutor_BuscaApellido != '')
                                    @if($BuscaAutor_Posibles->count() > '0')
                                        <b>Selecciona al autor:</b>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr><th>Nombre Apellido</th></tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($BuscaAutor_Posibles as $a)
                                                    <tr>
                                                        <td>
                                                            <div class="py-2 PaClick" onclick="VerNoVer('Autor','{{ $a->caut_id }}')">
                                                                {{ $a->caut_nombre }} {{ $a->caut_apellido1 }} {{ $a->caut_apellido2 }}
                                                            </div>
                                                            <div id="sale_Autor{{ $a->caut_id }}" style="display:none;">
                                                                Nombre de autor: {{ $a->caut_nombreautor }}<br>
                                                                Correo: {{ $a->caut_correo }}<br>
                                                                Comunidad: {{ $a->caut_comunidad }} <br>
                                                                Instituto: {{ $a->caut_institu }} <br>
                                                                @if($a->caut_lenguas != '') Lenguas: {{ $a->caut_lenguas }} <br> @endif
                                                                <button wire:click="ConfirmarDatosDeAutor({{ $a->caut_id }})" class="btn btn-secondary btn-sm" style="float: right;">
                                                                    Ver Datos de {{ $BuscaAutor_tipo }}
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        No se encontraron autores en el catálogo.
                                        <button wire:click="AbrirModalDeNuevoAutor()" class="btn btn-secondary">Agregar uno al catálogo</button>
                                    @endif
                                @endif

                                <!-- ------------------------------------------------------------------------------------- -->
                                <!-- ------------------------------------------------------------------------------------- -->
                                <!-- ----------------------- Ver y confirmar datos de autor seleccionado ----------------- -->
                                <!-- ------------------------------------------------------------------------------------- -->
                                @if($BuscaAutor_Ganon->count() != '0')
                                    <h5 class="my-3">Confirma los datos del autor id {{ $BuscaAutor_id }}:</h5>
                                    <div class="row">
                                        <div class="col-4 col-md-3 px-1"><b>Nombre</b></div>
                                        <div class="col-8 col-md-9 px-1"><input class="form-control" value="{{ $BuscaAutor_Ganon->caut_nombre }} {{ $BuscaAutor_Ganon->caut_apellido1 }} {{ $BuscaAutor_Ganon->caut_apellido2 }}" readonly></div>
                                    </div>
                                     <div class="row">
                                        <div class="col-4 col-md-3 px-1"><b>Nombre de autor:</b></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4 col-md-3 px-1"><b>Comunidad:</b></div>
                                        <div class="col-8 col-md-9 px-1"><input wire:model="BuscaAutor_comunidad" class="@error('BuscaAutor_comunidad') is-invalid @enderror form-control" type="text"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4 col-md-3 px-1"><b>Institución:</b></div>
                                        <div class="col-8 col-md-9 px-1"><input wire:model="BuscaAutor_institu" class="@error('BuscaAutor_institu') is-invalid @enderror form-control" type="text"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-4 col-md-3 px-1"><b>Correo:</b></div>
                                        <div class="col-8 col-md-9 px-1"><input wire:model="BuscaAutor_correo" class="@error('BuscaAutor_correo') is-invalid @enderror form-control" type="text"></div>
                                    </div>

                                    <div class="form-check">
                                        <input wire:model="BuscaAutor_corresponding" class="form-check-input" type="checkbox" value="" id="checkDefault">
                                        <label class="form-check-label" for="checkDefault">Poner como autor de correspondencia</label>
                                    </div>

                                    <div class="row my-3">
                                        <div class="col-12">
                                            <button wire:click="AgregarAutorACedula()" class="btn btn-primary" style="float: right;">
                                                <i class="bi bi-plus-circle"></i> Agregar
                                            </button>
                                        </div>
                                    </div>

                                @endif
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button wire:click="CierraModalDeBuscarAutor()" class="btn btn-secondary">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div> --}}


    {{-- <livewire:sistema.modal-cedula-autores-component > --}}




    {{-- <script>
        /* ### Script para abrir y cerrar modal de Cédula */
        Livewire.on('AbreModalDeCedula', () => {
            $('#ModalDeEdicionDeCedulas').modal('show');
        });

        Livewire.on('CierraModalDeCedula', () => {
            $('#ModalDeEdicionDeCedulas').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });

        /* ### Script para abrir y cerrar modal de Buscar Autor */
        Livewire.on('AbreModalDeBuscarAutor', () => {
            $('#ModalDeBusquedaDeElAutor').modal('show');
        });

        Livewire.on('CierraModalDeBuscarAutor', () => {
            $('#ModalDeBusquedaDeElAutor').modal('hide');
            if(event.detail.reload == '1'){
                window.location.reload();
            }
        });

        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoCedula',()=>{
            alert(event.detail.msj);
        })

        /* ### Script para mostrar botón personalizado de input=file */
        document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
            document.getElementById('MiInputFile').click();
        });
    </script> --}}

</div>
