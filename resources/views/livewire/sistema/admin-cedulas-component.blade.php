@section('title') Admin Cedulas @endsection
@section('meta-description') Administrador de cédulas del SiCedJar @endsection
@section('cintillo-ubica') -> {{ request()->path() }} @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection
<div>
    <h2>Administración de cédulas del jardín</h2>
    <div style="font-size: 80%;color:grey;">
        Este catálogo es administrado por los roles
        <b style="@if(in_array('admin',session('rol'))) color:green; @endif">admin</b>
        <b style="@if(in_array('editor',session('rol'))) color:green; @endif">editor</b>,
        <b style="@if(in_array('autor',session('rol'))) color:green; @endif">autor</b> o
        <b style="@if(in_array('traductor',session('rol'))) color:green; @endif">traductor</b>
        en jardin: {{ implode(',',$editjar) }}
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
            {{-- @if($abiertos->where('url_edit','1')->count() > '0')
                <error style="font-size: 90%;">
            @endif
            Hay {{ $abiertos->where('url_edit','1')->count() }} @if($abiertos =='1' ) página @else páginas  @endif en edición
            y {{ $abiertos->where('url_edo','<','5')->count() }} en proceso --}}
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
        @if($editMaster=='1' and $jardinSel != '%' and $jardinSel != '')
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
                    <th wire:click="ordenaTabla('url_titulo')" class="PaClick">Titulo</th>
                    <th wire:click="ordenaTabla('')" class="PaClick">Lengua</th>
                    <th wire:click="ordenaTabla('url_tipo')" class="PaClick">Tipo</th>
                    <th wire:click="ordenaTabla('url_titulo')" class="PaClick">Autores/Edit</th>
                    <th wire:click="ordenaTabla('url_descrip')" class="PaClick">Estado</th>
                    <th wire:click="ordenaTabla('urlO_descrip')" class="PaClick"> Dirección </th>
                    <th> Edición </th>
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
                            @if($this->editMaster=='1')
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
                            @endif
                        </td>

                        <!-- jardin -->
                        <td class="@if($u->url_act=='0') inact @endif">
                            {{ $u->url_cjarsiglas }}
                        </td>

                        <!-- titulo -->
                        <td>
                            <div>
                                {{ $u->url_titulo }}
                                <div style="color:gray;font-size:80%;">
                                @if($u->url_tradid=='0')
                                    Original
                                @else
                                    Traducción
                                @endif
                            </div>
                            </div>
                        </td>

                        <!-- lengua -->
                        <td>
                            {{ $u->lenguas->len_lengua }}
                            <div style="color:gray;font-size:80%;">
                                {{ $u->lenguas->len_code }}
                            </div>
                        </td>

                        <!-- tipo -->
                        <td>
                            <div>
                                {{ $u->url_ccedtipo }}
                            </div>
                        </td>

                        <td>
                            <div style="font-size:80%;">
                                <!-- Editores -->
                                @foreach ($u->editores as $a)
                                    <span style="@if($a->caut_usrid == Auth::user()->id)color:#CD7B34; font-weight:600; @endif">
                                        <sup>
                                            <b>E</b>
                                        </sup>
                                        @if($a->caut_usrid > '0')<i class="bi bi-person-check"></i> @endif
                                        {{ $a->aut_name }},
                                    </span>
                                @endforeach
                            </div>
                            <div style="color:gray; font-size:80%;">
                                <!-- Autores -->
                                @foreach ($u->autores as $a)
                                    <span style="@if($a->caut_usrid == Auth::user()->id)color:#CD7B34; font-weight:600; @endif">
                                        <sup>
                                            <b>A</b>
                                        </sup>
                                        @if($a->caut_usrid > '0')<i class="bi bi-person-check"></i> @endif
                                        {{ $a->aut_name }},
                                    </span>
                                @endforeach

                                <!-- Traductores -->
                                @foreach ($u->traductores as $a)
                                    <span style="@if($a->caut_usrid == Auth::user()->id)color:#CD7B34; font-weight:600; @endif">
                                        <sup>
                                            <b>T</b>
                                        </sup>
                                        @if($a->caut_usrid > '0')<i class="bi bi-person-check"></i> @endif
                                        {{ $a->aut_name }},
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <!-- estado -->
                        <td  class="@if($u->url_act=='0') inact @endif">
                            <!-- ------------------------- Muestra estado actual --------------------- -->
                            <span wire:click="AbreModalDeCambioDeEstado('{{ $u->url_id }}')" class="PaClick">
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
                            </span>
                        </td>

                        <!-- Dirección -->
                        <td class="@if($u->url_act=='0') inact @endif">
                            <a href="{{ url('/') }}/cedula/{{ strtolower($u->url_cjarsiglas) }}/{{ $u->url_url }}" target="new" class="nolink" id="sale_url{{ $u->url_id }}">
                                {{ url('/') }}/cedula/{{ strtolower($u->url_cjarsiglas) }}/{{ $u->url_url }}
                            </a>
                            <i class="bi bi-clipboard PaClick" onclick="CopiarContenido('url','{{ $u->url_id }}')"></i>
                            <!-- doi -->
                            @if($u->url_doi != '')
                                <div>
                                    <a href="https://doi.org/{{ $u->url_doi }}" target="new" class="nolink" id="sale_doi{{ $u->url_id }}">
                                        <b>https://doi.org/{{ $u->url_doi }}</b>
                                    </a>
                                    <i class="bi bi-clipboard PaClick" onclick="CopiarContenido('doi','{{ $u->url_id }}')"></i>
                                </div>
                            @endif
                        </td>


                        <!-- switch Modo edición -->
                        <td>
                            @if($u->url_edo <='4')
                                <div class="form-check form-switch my-1">
                                    <input  wire:change="CambiaAmodoEdicion('{{ $u->url_id }}')"
                                        @if($u->url_edit=='0' and $u->url_doi != '') wire:confirm="Esta cédula cuenta con DOI. Se recomienda NO EDITAR las cédulas con doi. ¿Seguro que quieres comenzar la edición ?" @else  @endif
                                        class="form-check-input" value="1" type="checkbox" role="switch"
                                        id="flexSwitchCheckDefault" @if($u->url_edit=='1') checked @endif
                                        style="@if($u->url_edit=='1')background-color:red; @endif">
                                    <label class="form-check-label" style="font-size:90%;" for="flexSwitchCheckDefault">@if($u->url_edit=='0') off @else on @endif</label>
                                    @if($u->url_doi != '')<b>DOI</b> @endif
                                </div>
                            @endif
                        </td>

                        <td>
                            {{ $u->url_ciclo }} ({{ $u->url_version }})
                            {{-- {{ $u->url_anio }} --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($urls->count()=='0')
            --- Aún no hay cédulas ---
        @endif
    </div>


    <livewire:sistema.modal-admin-cedula-component />
    <livewire:sistema.modal-cedula-cambia-estado-component />

    <script>
        Livewire.on('RecargarPagina',() => {
            location.reload();
            // window.location.href;
        });
    </script>
</div>
