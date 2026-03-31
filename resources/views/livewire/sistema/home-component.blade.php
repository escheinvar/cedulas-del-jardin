@section('title') Home SiCeJar @endsection
@section('meta-description') Home de usuario del sistema de cédulas del jardín @endsection
@section('cintillo-ubica') &nbsp; @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection


<div>

    <!-- ------------------------------------------- -->
    <!--  ----- Inicia Caja de usuario y roles ----- -->
    <div class="row">
        <div class="col-sm-12 col-md-3 col-lg-5">
            <h2>Home</h2>
        </div>
        <div class="col-sm-12 col-md-8 col-lg-6">
            <div style="background-color:#CDC6B9;padding:10px; color:#64383E">
                <div style="width:80%;display:inline-block;">
                    <!-- muestra usuario -->
                    <div>
                        <div style="display:inline-block; width:70px; font-weight:bold">Usuario:</div>
                        <div style="display:inline-block;"> {{ Auth::user()->usrname }} ({{ Auth::user()->id }})</span></div>
                        <a href="/homeConfig" class="nolink" style="padding:5px;">
                            <i class="bi bi-gear-fill" style="font-size:120%;"></i>
                        </a>
                    </div>
                    <!-- muestra correo -->
                    <div>
                        <div style="display:inline-block; width:70px; font-weight:bold">Correo:</div>
                        <div style="display:inline-block;">  {{ Auth::user()->email  }}</div>
                    </div>
                    <!-- muestra roles -->
                    <div>
                        <div style="display:inline-block; width:70px; font-weight:bold">Rol(es):</div>
                        @foreach ($roles as $i)
                            {{ $i->rol_crolrol.'@'.$i->rol_cjarsiglas }}, &nbsp; &nbsp; &nbsp;
                        @endforeach
                    </div>
                </div>
                <div style="width:13%; display:inline-block; vertical-align:top; text-align:right;padding:5px;" class="d-none d-sm-inline-block">
                    @if(Auth::user()->avatar == '')
                        <a href="/homeConfig" class="nolink" style="">
                            <img src="/avatar/usr_default.png" class="avatar" style="display: inline;">
                        </a>
                    @else
                        <a href="/config" class="nolink" style="">
                            <img src="{{ Auth::user()->avatar }}" class="avatar">
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--  ----- Termina Caja de usuario y roles ----- -->
    <!-- ------------------------------------------- -->








    <!-- -- TABLA DE APORTES DEL USUARIO -->
    <div class="my-4">
        @if($MisAportes=='0')<br>
        <button wire:click="VerNoverAportes()" class="btn btn-primary">
            Ver mis aportes
        </button>
        @endif
    </div>
    <!-- ---------- Módulo de  aportes --------------->
    <div class="m-4">
        @if($MisAportes=='1')
            <h3 wire:click="VerNoverAportes()" class="PaClick"><img src="/cedulas/BotonAportar.png" style="width:90px;border:2px solid rgb(61, 41, 33);border-radius:15px;">
                &nbsp; Mis aportes
            </h3>
            @if($aporta->count()> 0)
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th> Jardín / Tema / lengua</th>
                            <th>Fecha | Estado</th>
                            <th>Mensaje [Origen, Edad]</th>
                            <th></th><th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aporta as $a)
                            <tr>
                                <td>
                                    {{ $a->ced_cjarsiglas }} / {{ $a->ced_urlurl }} / {{ $a->ced_clencode }}
                                </td>
                                <td>
                                    {{ $a->msg_date }}  |
                                    @if($a->msg_edo=='0')
                                        <i class="bi bi-0-circle-fill" style="color:#CD7B34"></i> En revisión
                                    @elseif($a->msg_edo=='1')
                                        <i class="bi bi-1-circle-fill" style="color:rgb(0, 162, 255)"></i> Pausado por usuario

                                    @elseif($a->msg_edo=='2')
                                        <i class="bi bi-2-circle-fill" style="color:red"></i> Cancelado por admin.
                                    @elseif($a->msg_edo=='3')
                                        <i class="bi bi-3-circle-fill"  style="color:darkgreen"></i> Publicado

                                    @endif
                                </td>
                                <td>
                                    {{ $a->msg_mensaje }} [Origen: {{ $a->msg_origen }}; Edad: {{ $a->msg_edad }}]
                                </td>
                                <td>
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                -- Aún no tengo aportes -->
            @endif
        @endif
    </div>



    <!-- ---------------------------------------------------------------------------- -->
    @if($cedulas->count() > '0')
        <h3>Mis cédulas</h3>
        <div class="table table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titulo</th>
                        <th>Url</th>
                        <th>Lengua</th>
                        <th>Jardin</th>
                        <th>Rol</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cedulas as $c)
                        <tr>
                            <td>{{ $c->url_titulo }}</td>
                            <td>{{ $c->url_url }}</td>
                            <td>{{ $c->lenguas->len_autonimias }} ({{ $c->lenguas->len_lengua }})</td>
                            <td>{{ $c->jardin->cjar_nombre }} ({{ $c->jardin->cjar_siglas }})</td>
                            <td>{{ $c->aut_tipo }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif


    <!-- ----------------------- Faltantes ----------------------- -->
    @if(in_array('admin',session('rol')))
        <h3>Pendientes</h3>
        <ol>
            <li>Modal-cedula-cambia-edo: Enviar buzón y correo en c/cambio de estado a los involucrados</li>
            <li>Modal-cedula-cambia-edo: Crear PDF con nueva versión</li>
            <li>Cédulas: Buscador de cédulas. Vincular cédulas por tema(s)</li>
            <br>

            <li>Cédulas: Módulo para vaciar imágenes que no estan en sp_cedulas (txt_audio, txt_img1-3, txt_video) o en sp_fotos
            <br>
        </ol>
    @endif
</div>
