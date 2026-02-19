@section('title')
    Aportes
@endsection
@section('cintillo')
    Administrador de Aportes &nbsp; &nbsp;
@endsection


<div class="m-4">

    <h3 class="">
        <img src="/cedulas/BotonAportar.png" style="width:90px;border:2px solid rgb(61, 41, 33);border-radius:15px;">
        &nbsp; Administrador de aporte de usuarios
    </h3>

    <div class="row my-3">
        <div class="col-12">
            <i class="bi bi-0-circle-fill" style="color:#CD7B34"></i>
            En revisión &nbsp; &nbsp;

            <i class="bi bi-1-circle-fill" style="color:rgb(0, 162, 255)"></i>
            Pausado por usuario &nbsp; &nbsp;

            <i class="bi bi-2-circle-fill" style="color:red"></i>
            Cancelado por admin. &nbsp; &nbsp;

            <i class="bi bi-3-circle-fill"  style="color:darkgreen"></i>
            Publicado
        </div>
        <div class="col-4">
            <select wire:model.live="edo" class="form-select">
                <option value='0'>0 En revisión</option>
                <option value='1'>1 Pausado por usuario</option>
                <option value='2'>2 Cancelado por administrador</option>
                <option value='3'>3 Publicado</option>
            </select>
        </div>
        <div class="col-2">
            {{-- <button wire:click="selecciona()" class="btn btn-primary btn-sm"> Ver </button> --}}
            En estado {{ $edo }} hay {{ $aporta->count() }} registros
        </div>
    </div>

    @if($aporta->count() > 0)
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th><span wire:click="ordena('msg_edo')" class="PaClick">Edo.</span> </th>
                    <th><span wire:click="ordena('ced_cjarsiglas')" class="PaClick">Jardín</span></th>
                    <th><span wire:click="ordena('ced_urlurl')" class="PaClick">Tema </span></th>
                    <th><span wire:click="ordena('ced_clencode')" class="PaClick">Lengua</span></th>
                    <th><span wire:click="ordena('msg_date')" class="PaClick">Fecha</span></th>
                    <th><span wire:click="ordena('msg_usuario')" class="PaClick">Usr</span><br>
                        <span wire:click="ordena('msg_origen')" class="PaClick">Origen</span>
                        <span wire:click="ordena('msg_edad')" class="PaClick">Edad</span>
                    </th>
                    <th><span wire:click="ordena('msg_mensaje')" class="PaClick">Mensaje</span></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($aporta as $a)
                    <tr>
                        <!-- Estado -->
                        <td>
                            @if($a->msg_edo=='0')
                                <i class="bi bi-0-circle-fill" style="color:#CD7B34"></i>
                            @elseif($a->msg_edo=='1')
                                <i class="bi bi-1-circle-fill" style="color:rgb(0, 162, 255)"></i>
                            @elseif($a->msg_edo=='2')
                                <i class="bi bi-2-circle-fill" style="color:red"></i>
                            @elseif($a->msg_edo=='3')
                                <i class="bi bi-3-circle-fill"  style="color:darkgreen"></i>
                            @endif
                        </td>
                        <!-- Jardin  -->
                        <td>
                            {{ $a->ced_cjarsiglas }}
                        </td>
                        <!-- Tema -->
                        <td>
                            {{ $a->ced_urlurl }}
                        </td>
                        <!-- Lengua -->
                        <td>
                            {{ $a->ced_clencode }}
                        </td>
                        <!-- Fecha -->
                        <td>
                            {{ $a->msg_date }}
                        </td>
                        <!-- Usuario / Origen / Edad -->
                        <td>
                            {{ $a->msg_usuario }}<br>
                            @if($a->msg_origen !='') ({{ $a->msg_origen }}) @endif
                            @if($a->msg_edad != '')  {{ $a->msg_edad }} años @endif
                        </td>
                        <!-- Mensaje -->
                        <td style="width:50%;">
                            @if($ModoEdit==$a->msg_id AND ($a->msg_edo=='0' OR $a->msg_edo=='2') )
                                <textarea wire:model="TextoEdita" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                <button wire:click="GuardarEdita('{{ $a->msg_id }}')" class="btn btn-primary">Guardar</button>
                                <button wire:click="CancelaEditar()" class="btn btn-secondary">Cancelar</button>

                            @else
                                {{ $a->msg_mensaje }}
                            @endif
                        </td>

                        <td>
                            <!-- ACCIONES -->
                            @if($a->msg_edo=='0' )
                               <div class="PaClick my-1">
                                    <i wire:click="IniciaEdita('{{ $a->msg_id }}')" class="bi bi-pencil-square mx-3"> Editar</i>
                                <div class="PaClick py-1">

                                <div class="PaClick my-1">
                                    <i wire:click="CambiaEdoMsg('{{ $a->msg_id }}','2')" class="bi bi-pause-circle mx-3"> Cancelar</i>
                                <div class="PaClick py-1">

                                </div>
                                    <i wire:click="CambiaEdoMsg('{{ $a->msg_id }}','3')" class="bi bi-play-btn mx-3"> Publicar</i>
                                </div>
                            @elseif($a->msg_edo=='2' )
                                <div class="PaClick my-1">
                                    <i wire:click="CambiaEdoMsg('{{ $a->msg_id }}','3')" class="bi bi-play-btn mx-3"> Publicar</i>
                                </div>
                            @elseif($a->msg_edo=='3' )
                                <div class="PaClick my-1">
                                    <i wire:click="CambiaEdoMsg('{{ $a->msg_id }}','2')" class="bi bi-pause-circle mx-3"> Cancelar</i>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        -- No hay aportes -->
    @endif

</div>

