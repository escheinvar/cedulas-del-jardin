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

    <!--------------------------------------------------------------------------------------------->
    <!--------------------------------- TABLA DE AUTORES ----------------------------------------->
    <!--------------------------------------------------------------------------------------------->
    <div class="row">
        <div class="col-12 my-3">
            <div>
                @if($edit=='1')
                    <button wire:click="AbreModalAutores('0')" type="button" class="btn btn-secondary" style="float: right;">
                        <i class="bi bi-plus-square"></i> Nuevo Autor
                    </button>
                @endif
            </div>
        </div>
        <div class="col-12">
            <table class="table table-striped" style="width:100%;">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tipo</th>
                        <th>Nombre/Apellidos</th>
                        <th>Institucion</th>
                        <th>Correo</th>
                        <th>web</th>
                        <th>Jardines</th>
                        <th>Obra</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($autores as $a)
                        <tr wire:click="AbreModalAutores({{ $a->caut_id }})" class="@if($edit=='1')PaClick @endif">
                            <td> {{ $a->caut_id }} </td>
                            <td> {{ $a->caut_tipo }} </td>
                            <td> {{ $a->caut_nombre }} {{ $a->caut_apellidos }} </td>
                            <td> {{ $a->caut_institu }} </td>
                            <td> {{ $a->caut_correo }} </td>
                            <td> {{ $a->caut_web }}</td>
                            <td> <div class="elemento">JebOax</div> </td>
                            <td> <div class="elemento">obra</div> </td>
                            <td> <i class="bi bi-pencil-square PaClick" wire:click="AbreModalAutores({{ $a->caut_id }})"></i> </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($autores->count() =='0')
                -- aún no hay autores registrados --
            @endif
        </div>
    </div>

    <livewire:sistema.autores-modal-component>

</div>
