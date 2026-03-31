@section('title') Admin. Autores @endsection
@section('meta-description') Administrador de Autores del SiCedJar @endsection
@section('cintillo-ubica') -> Catálogo de Autores @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection

<div>
    <h2>Administración de Autores</h2>

    <div style="font-size: 80%;color:grey;">
        Este catálogo es administrado por el rol <b>Admin@todos</b> en jardin: {{ implode(',',$editjar) }}
        (@if($edit=='0') <error style="font-size: 90%;"> No autorizado</error> @else <span style="font-size:90%;color:green;"> Autorizado </span>@endif)
    </div>

    <!-------------------------- BUSCADOR DE JARDINES ----------------------------------------------------------->
    <!-- buscar por jardín -->
    <div class="row my-3">
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
    </div>

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
        <div class="col-12">
            <table class="table table-striped" style="width:100%;">
                <thead>
                    <tr style="vertical-align: middle;">
                        <th>Id</th>
                        <th>Url / Nombre</th>
                        <th>Nombre de autor<br>Orcid</th>
                        <th>Institucion/Comunidad<br>Correo</th>

                        <th>Web</th>
                        <th>Edit</th>
                        <th>Autorias</th>
                        <th>Traducciones</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($autores as $a)
                        <tr>
                            <!-- ID -->
                            <td> {{ $a->caut_id }} </td>

                            <!-- Nombre, Apellidos -->
                            <td>
                                <i class="bi bi-clipboard PaClick" onclick="CopiarContenido('Autor','{{ $a->caut_id }}')"></i> &nbsp;
                                <a href="/autor/{{ $a->caut_cjarsiglas }}/{{ $a->caut_url }}" target="autor" class="nolink">
                                    {{ $a->caut_nombre }} {{ $a->caut_apellido1 }} {{ $a->caut_apellido2 }}
                                </a>
                                <span id="sale_Autor{{ $a->caut_id }}" style="display:none">{{ url('/') }}/autor/{{ $a->caut_cjarsiglas }}/{{ $a->caut_url }}</span>
                            </td>

                            <!-- url -->
                            <td>
                                {{ $a->caut_nombreautor }}
                                @if($a->caut_orcid != '') <br> <a href="https://orcid.org/{{ $a->caut_orcid }}" target="new" style="font-size: 80%;" class="nolink">{{ $a->caut_orcid }}</a> @endif
                            </td>

                            <!-- Institución /comunidad Correo-->
                            <td>
                                {{ $a->caut_institu }} {{ $a->caut_comunidad }}<br>
                                {{ $a->caut_correo }}
                            </td>



                            <!-- Si o no hacer Web -->
                            <td>
                                @if($edit=='1')
                                    <div class="form-check form-switch">
                                        <input  wire:change="CambiaConOsinWeb('{{ $a->caut_id }}')"
                                            class="form-check-input"
                                            value="1" type="checkbox" role="switch"
                                            id="flexSwitchCheckDefault"
                                            @if($a->caut_web=='1') checked @endif
                                            style="@if($a->caut_web=='1')background-color:darkgreen; @endif">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">@if($a->caut_web=='0')Sin web @else Con Web @endif</label>
                                    </div>
                                @endif
                            </td>

                            <!--  Editar o no web -->
                            <td>
                                @if($edit=='1' AND $a->caut_web=='1')
                                    <div class="form-check form-switch">
                                        <input  wire:change="CambiaEditNoEdit('{{ $a->caut_id }}')"
                                            class="form-check-input"
                                            value="1" type="checkbox" role="switch"
                                            id="flexSwitchCheckDefault"
                                            @if($a->caut_edit=='1') checked @endif
                                            style="@if($a->caut_edit=='1')background-color:red; @endif">
                                        <label class="form-check-label" for="flexSwitchCheckDefault">@if($a->caut_edit=='0')Público @else En edición @endif</label>
                                    </div>
                                @endif
                            </td>

                            <!-- Cédulas de las que es autor -->
                            <td> <div class="elemento">Cedula</div> </td>

                            <!--  Cédulas de las que es traductor -->
                            <td> <div class="elemento">Cedula</div> </td>

                            <!-- Ícono de edición -->
                            <td>
                                <i wire:click="AbreModalAutores({{ $a->caut_id }})"  class="bi bi-pencil-square PaClick" wire:click="AbreModalAutores({{ $a->caut_id }})"></i>
                                @if($a->caut_usrid > '0') <i class="bi bi-person-check"><sub>{{ $a->caut_usrid }}</sub></i>@endif
                            </td>
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
