<div>
    @section('title') Admin. Autores @endsection
    @section('meta-description') Administrador de Autores del SiCedJar @endsection
    @section('cintillo-ubica') -> Catálogo de Autores @endsection
    @section('cintillo') &nbsp; @endsection
    @section('MenuPublico')  @endsection
    @section('MenuPrivado') x @endsection


        <!-- ---------- Módulo de  aportes --------------->
    <div class="m-4">
        <h2>
            Aportes de visitantes
        </h2>
        @if($aporta->count()> 0)
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Jardín</th>
                            <th>Tema</th>
                            <th>Lengua</th>
                            <th>Fecha</th>
                            <th>Mensaje / Autor / Ubiación / Contacto</th>
                            <th>Estado</th>
                            {{-- <th></th>
                            <th></th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aporta as $a)
                            <tr>
                                <!-- Jardín -->
                                <td>
                                    {{ $a->cedula->url_cjarsiglas }}
                                </td>

                                <!-- url -->
                                <td>
                                    <a href="{{ url('/cedula') }}/{{ $a->cedula->url_cjarsiglas }}/{{ $a->cedula->url_url }}" class="nolink">
                                        {{ $a->cedula->url_url }}
                                    </a>
                                </td>

                                <!-- lengua -->
                                <td>
                                    {{ $a->cedula->url_lencode }}
                                </td>

                                <!-- fecha -->
                                <td>
                                    {{ $a->msg_date }}
                                </td>

                                <!-- mensaje y datos de autor-->
                                <td>
                                    {{ $a->msg_mensaje }}
                                    <div class="form-text">
                                        {{ $a->msg_nombre }} ({{ $a->msg_usuario }}) @if($a->msg_edad != '') {{ $a->msg_edad }} años. @endif <br>
                                        {{ $a->msg_estado }}, {{ $a->msg_mpio }}, {{ $a->msg_comunidad }} ({{ $a->msg_lengua }})
                                        <div>{{ $a->msg_correo }} {{ $a->msg_tel }}</div>
                                    </div>
                                </td>


                                <!-- estado -->
                                <td style="text-align: center;">
                                    @if($editMaster=='1') <span class="PaClick" wire:click="AbrirModalParaEditarAporteDeVisitante({{ $a->msg_id }})"> @endif
                                        @if($a->msg_edo=='0')
                                            <i class="bi bi-0-circle-fill"  style="color:#CD7B34"> En revisión</i>
                                        @elseif($a->msg_edo=='1')
                                            <i class="bi bi-1-circle-fill" style="color:rgb(0, 162, 255)"> Pausado</i>

                                        @elseif($a->msg_edo=='2')
                                            <i class="bi bi-2-circle-fill" style="color:red"> Cancelado</i>
                                        @elseif($a->msg_edo=='3')
                                            <i class="bi bi-3-circle-fill" style="color:darkgreen"> Publicado</i>
                                        @endif
                                    @if($editMaster=='1') </span> @endif
                                </td>

                                {{-- <td>
                                    <!-- Pausar / Publicar (por el pripietario de mensajes) -->
                                    @if($a->msg_edo=='3' )
                                        <span class="PaClick">
                                            <i wire:click="CambiaEdoMsg('{{ $a->msg_id }}','1')" class="bi bi-pause-circle mx-3"> Pausar</i>
                                        </span>
                                    @elseif($a->msg_edo=='1' )
                                        <span class="PaClick">
                                            <i wire:click="CambiaEdoMsg('{{ $a->msg_id }}','3')" class="bi bi-play-btn mx-3"> Publicar</i>
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if( $a->msg_usr == Auth::user()->id  )
                                        <span class="PaClick">
                                            <i wire:click="BorrarMsg('{{ $a->msg_id }}')" wire:confirm="Estás por eliminar tu aportación del sistema y no se podrá recuperar ¿Seguro que quieres continuar?" class="bi bi-trash m-2"> Borrar</i>
                                        </span>
                                    @endif
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            -- Aún no tengo aportes -->
        @endif
    </div>

    <livewire:sistema.modal-admin-aportes-publico-component />
</div>
