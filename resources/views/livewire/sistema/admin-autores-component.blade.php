@section('title') Admin. Autores @endsection
@section('meta-description') Administrador de Autores del SiCedJar @endsection
@section('cintillo-ubica') -> Catálogo de Autores @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection

<div>
    <h2>Catálogo de Autores</h2>

    <div style="font-size: 80%;color:grey;">
        Este catálogo es administrado por el rol
        <b style="@if(in_array('admin',session('rol'))) color:green; @endif">Admin</b><b>@todos</b> en jardin: {{ implode(',',$editjar) }}
        (@if($edit=='0') <error style="font-size: 90%;"> No autorizado</error> @else <span style="font-size:90%;color:green;"> Autorizado </span>@endif)
    </div>

    <!-------------------------- BUSCADOR DE JARDINES ----------------------------------------------------------->
    <!-- buscar por jardín -->
    {{-- <div class="row my-3">
        <div class="col-6 col-md-3 form-group">
            <label class="form-label">Jardin<red>*</red></label>
            <select wire:model.live="jardinSel" class="form-select">
                <option value="">Indica un jardín</option>
                @foreach($JardsDelUsr as $jar)
                    <option value="{{ $jar->cjar_siglas }}">{{ $jar->cjar_siglas }} ({{ $jar->cjar_name }})</option>
                @endforeach
                @if(in_array('todos',$editjar))
                    <option value="%">Todos</option>
                @endif
            </select>
        </div>
        <div class="col-6 col-md-2">
            <br>
            @if($abiertos > '0')<error> @endif Hay {{ $abiertos }} @if($abiertos =='1' ) página @else páginas  @endif <br>en edición</error>
        </div>
    </div> --}}

    <!--------------------------------------------------------------------------------------------->
    <!--------------------------------- Botón de nuevo autor ----------------------------------------->
    <!--------------------------------------------------------------------------------------------->
    <div class="row">
        <div class="col-12 my-3">
            <div>
                @if($edit=='1' and $jardinSel != '' and $jardinSel != '%')
                    <button wire:click="AbreModalAutores('0')" type="button" class="btn btn-secondary" style="float: right;">
                        <i class="bi bi-plus-square"></i> Nuevo Autor
                    </button>
                @endif
            </div>
        </div>
    <!--------------------------------------------------------------------------------------------->
    <!--------------------------------- TABLA DE AUTORES ----------------------------------------->
    <!--------------------------------------------------------------------------------------------->
        <div class="col-12 table-responsive">
            <table class="table table-striped" style="width:100%;">
                <thead>
                    <tr style="vertical-align: middle;">
                        <th>Id</th>

                        <th>Nombre</th>
                        <th>Nombre de autor</th>
                        <th>Institucion / Comunidad </th>
                        <th>Correo</th>
                        <th>Autoria(s)</th>
                        <th>Editor</th>
                        <th>Semblanza(s)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($autores as $a)
                        <tr>
                            <!-- ID, ícono de edición y usuario asignado -->
                            <td style="width:65px;">
                                <sub>{{ $a->caut_id }}</sub>
                                <i wire:click="AbreModalAutores({{ $a->caut_id }})"  class="bi bi-pencil-square PaClick" wire:click="AbreModalAutores({{ $a->caut_id }})">
                                    @if($a->caut_usrid > '0') <i class="bi bi-person-check"></i>@endif
                                </i>
                            </td>

                            <!-- Nombre, Apellidos -->
                            <td>
                                {{ $a->caut_nombre }} {{ $a->caut_apellido1 }} {{ $a->caut_apellido2 }}
                            </td>

                            <!-- url -->
                            <td>
                                {{ $a->caut_nombreautor }}
                            </td>

                            <!-- Institución / Comunidad-->
                            <td>
                                {{ $a->caut_institu }}

                                {{ $a->caut_comunidad }}
                            </td>

                            <!-- Correo -->
                            <td>
                                {{ $a->caut_correo }}
                            </td>


                            <!-- Cédulas de las que es autor -->
                            <td>
                                <div class="cortaUnaLinea PaClick" id="sale_Aut{{ $a->caut_id }}" onClick="VerNoVerUnaLinea('Aut','{{ $a->caut_id }}')">

                                    @foreach ($a->cedulas as $c)
                                        @if($c->aut_tipo != 'Editor')
                                            <div class="elemento" style="font-size: 70%;">
                                                <a href="{{ url('/cedula') }}/{{ $c->aut_cjarsiglas }}/{{ $c->aut_urltxt }}" class="nolink" target="new_">
                                                    @if($c->aut_tipo=='Traductor')<b><sup>T</sup></b>@endif
                                                    {{ $c->aut_key }}
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                    <i id="icono_Aut{{ $a->caut_id }}" style="display:none;" class="bi bi-box-arrow-up-right agregar">
                                </div>
                            </td>

                            <!-- Cédulas de las que es editor -->
                            <td>
                                <div class="cortaUnaLinea PaClick" id="sale_Edit{{ $a->caut_id }}" onClick="VerNoVerUnaLinea('Edit','{{ $a->caut_id }}')">
                                    @foreach ($a->cedulas as $c)
                                        @if($c->aut_tipo == 'Editor')
                                            <div class="elemento" style="font-size: 70%;">
                                                <a href="{{ url('/cedula') }}/{{ $c->aut_cjarsiglas }}/{{ $c->aut_urltxt }}" class="nolink" target="new_">
                                                    @if($c->aut_tipo=='Traductor')<b><sup>T</sup></b>@endif
                                                    {{ $c->aut_key }}
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                    <i id="icono_Edit{{ $a->caut_id }}" style="display:none;" class="bi bi-box-arrow-up-right agregar">
                                </div>
                            </td>



                            <!-- Semblanzas -->
                            <td>
                                <div class="cortaUnaLinea PaClick" id="sale_Semb{{ $a->caut_id }}" onClick="VerNoVerUnaLinea('Semb','{{ $a->caut_id }}')">
                                    @foreach ($a->urlautor as $u)
                                        <div class="elemento" style="font-size: 70%;">
                                            <a href="{{ url('/autor') }}/{{ $u->aurl_cjarsiglas }}/{{ $u->aurl_url }}" class="nolink" target="new_">
                                                {{ $u->aurl_cjarsiglas }}
                                            </a>
                                        </div>
                                    @endforeach
                                    <i id="icono_Semb{{ $a->caut_id }}" style="display:none;" class="bi bi-box-arrow-up-right agregar">
                                </div>
                            </td>

                            {{-- <!--  Identificadores -->
                            <td>
                                @if($a->caut_orcid != '')
                                    <div class="elemento" style="font-size:70%;">
                                        <a href="https://orcid.org/{{ $a->caut_orcid }}" target="new" class="nolink">Orcid</a>
                                    </div>
                                @endif

                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($autores->count() =='0')
                -- aún no hay autores registrados --
            @endif
        </div>
    </div>

    <livewire:sistema.modal-cedula-autores-component >

</div>
