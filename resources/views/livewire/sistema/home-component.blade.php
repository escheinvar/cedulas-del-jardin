@section('title') Home SiCeJar @endsection
@section('meta-description') Home de usuario del sistema de cédulas del jardín @endsection
@section('cintillo-ubica') &nbsp; @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection


<div>

    <!-- --------------------------------------------------------------------------------------------- -->
    <!-- -------------------- CAJA DE USUARIOS Y ROLSES ---------------------------------------------- -->
    <!-- --------------------------------------------------------------------------------------------- -->
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
                        <div style="display:inline-block;"> {{ Auth::user()->usrname }} (Id: {{ Auth::user()->id }})</span></div>
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
                        @if(count($roles)< '1')
                            Usuario General
                        @endif
                    </div>
                </div>
                <div style="width:13%; display:inline-block; vertical-align:top; text-align:right;padding:5px;" class="d-none d-sm-inline-block">
                    @if(Auth::user()->avatar == '')
                        <a href="/homeConfig" class="nolink" style="">
                            <img src="/avatar/usr_default.png" class="avatar"  style="display: inline;">
                            <i class="@if(Auth::user()->mensajes =='1') bi bi-envelope @else bi bi-envelope-x @endif" style="color:black;"></i>
                        </a>
                    @else
                        <a href="/homeConfig" class="nolink" style="">
                            <img src="{{ Auth::user()->avatar }}" class="avatar ">
                            <i class="@if(Auth::user()->mensajes =='1') bi bi-envelope @else bi bi-envelope-x @endif" style="@if(Auth::user()->mensajes =='0')color:#CD7B34; @else color:black; @endif"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- --------------------------------------------------------------------------------------------- -->
    <!-- -------------------- SECCIÓN DE ASUNTOS PENDIENTES ------------------------------------------ -->
    <!-- --------------------------------------------------------------------------------------------- -->
    <div class="row my-3">
        <!-- mensajes de buzón -->
        @if($buzon->where('buz_act','1')->count() > '0')
            <div class="col-12 col-md-4" style="border-radius:5px;">
                <div class="align-middle align-content-center avisoHome">
                    <div style="transform:rotate(-90deg); text-align:center;">
                        <a href="/buzon" class="nolink">
                            <button  class="btn btn-primary">
                                Buzón
                            </button>
                        </a>
                    </div>
                    <div style="width:150px;">
                        <b style="color:#CD7B34">Sin leer: {{ $buzon->where('buz_act','1')->count() }}</b><br>
                        Leídos: {{ $buzon->where('buz_act','0')->count() }}<br>
                        Total: {{ $buzon->count() }}
                    </div>
                    <div class="align-middle align-content-center">
                        <b class="bi bi-envelope" style="color:#87796d; font-size:300%;"></b>
                    </div>
                </div>
            </div>
        @endif

        <!-- Aportes del público -->
        @if( $aporta->where('msg_edo','0')->count() > '0')
            <div class="col-12 col-md-4" style="border-radius:5px;">
                <div class="align-middle align-content-center avisoHome">

                    <div style="transform:rotate(-90deg); text-align:center;">
                        <a href="/admin_aportes" class="nolink">
                            <button  class="btn btn-primary">
                                Aportes
                            </button>
                        </a>
                    </div>
                    <div style="width:150px;">
                        {{-- ##0:enviado x usr 1:pausado x admin, 2:canceladox admin, 3:publico --}}
                        <b style="color:#CD7B34">Nuevos: {{ $aporta->where('msg_edo','0')->count() }}</b><br>
                        Pausados: {{ $aporta->where('msg_edo','1')->count() }}<br>
                        Cancelados: {{ $aporta->where('msg_edo','2')->count() }}<br>
                    </div>
                    <div style="width:200px;">
                        <b class="bi bi-people" style="color:#87796d; font-size:300%;"></b>
                    </div>
                </div>
            </div>
        @endif

        <!-- cédulas del usuario -->
        @if($cedulas->count() > '0')
            <div class="col-12 col-md-4" style="border-radius:5px;">
                <div class="align-middle align-content-center avisoHome">

                    <div style="transform:rotate(-90deg); text-align:center;">
                        <a href="/admin_cedulas" class="nolink">
                            <button  class="btn btn-primary">
                                Cédulas
                            </button>
                        </a>
                    </div>
                    <div style="width:150px;">
                        <b style="color:#CD7B34">Creando: {{ $cedulas->where('url_ciclo', '<','1')->where('url_edo','0')->count() }}</b><br>
                        <b style="color:#CD7B34">Revisando: {{ $cedulas->where('url_edo','>','0')->where('url_edo','<','5')->count() }}</b><br>
                        <b style="color:#CD7B34">Editando: {{ $cedulas->where('url_edit','1')->count() }}</b>
                    </div>
                    <div style="width:150px;">
                        Total: {{ $cedulas->count() }}<br>
                        Originales: {{ $cedulas->where('url_tradid','0')->count() }}<br>
                        Públicadas {{ $cedulas->where('url_edo','>=','5')->where('url_edit','0')->count() }}
                    </div>
                </div>
            </div>
        @endif
    </div>



    <!-- --------------------------------------------------------------------------------------------- -->
    <!-- ------------------------------SECCIÓN DE PROYECTOS ------------------------------------------ -->
    <!-- --------------------------------------------------------------------------------------------- -->
    <h3>Proyectos de publicación</h3>
    <div style="display:flex;align-items:center">
        <div style="font-size:80%;">
            <a href="/normaeditorial" target="_new" class="nolink">Ver norma editorial.</a><br>
            <a href="/comopublicar" target="new" class="nolink">Ver manual de publicación</a><br>
            <a href="/FormatoDeEnvíoV1.docx" class="nolink">Descargar formato de envío</a><br>
            <a href="FormatoSolicitudDePublicacionV1.docx" class="nolink">Descargar carta de solicitud de publicación</a><br>
            <span onclick="VerNoVer('manual','Pasos')" class="PaClick">Ver pasos del proceso de revisión</span>
        </div>
        <div style="display:inline-block;vertical-align:middle;text-align:center;padding:35px;">
            <button wire:click="AbrirModalProyecto('0')" class="btn btn-primary bi bi-plus">
                Iniciar publicación
            </button>
        </div>
    </div>
    <!-- Pasos de proceso de revisión -->
    <div id="sale_manualPasos" class="row" style="display: none; vertical-align:top;">
        <div class="col-12"><b>Proceso de revisión del proyecto</b></div>
        <div class="col-5 col-md-2" style="border-radius:5px; font-size:80%;display:inline-block; padding:7px; margin:5px; background-color:#CDC6B9;">0.0) Crea el proyecto</div>
        <div class="col-5 col-md-2" style="border-radius:5px; font-size:80%;display:inline-block; padding:7px; margin:5px; background-color:#CDC6B9;">0.1) Carga los archivos</div>
        <div class="col-5 col-md-2" style="border-radius:5px; font-size:80%;display:inline-block; padding:7px; margin:5px; background-color:#CDC6B9;">0.2) El administrador revisa</div>
        <div class="col-5 col-md-2" style="border-radius:5px; font-size:80%;display:inline-block; padding:7px; margin:5px; background-color:#CDC6B9;">0.4) El autor revisa</div>
        <div class="col-5 col-md-2" style="border-radius:5px; font-size:80%;display:inline-block; padding:7px; margin:5px; background-color:#CDC6B9;">0.5) El administrador revisa y asigna editor</div>
        <div class="col-5 col-md-2" style="border-radius:5px; font-size:80%;display:inline-block; padding:7px; margin:5px; background-color:#CDC6B9;">1.0) El editor designa revisores externos</div>
        <div class="col-5 col-md-2" style="border-radius:5px; font-size:80%;display:inline-block; padding:7px; margin:5px; background-color:#CDC6B9;">1.1) El autor revisa</div>
        <div class="col-5 col-md-2" style="border-radius:5px; font-size:80%;display:inline-block; padding:7px; margin:5px; background-color:#CDC6B9;">1.2) El editor revisa</div>
        <div class="col-5 col-md-2" style="border-radius:5px; font-size:80%;display:inline-block; padding:7px; margin:5px; background-color:#CDC6B9;">2.0) Inicia proceso de publicación</div>
    </div>
    <!-- --------------------------------------------------------------------------------------------- -->
    <!-- --------------------------INICIA SECCIÓN DE CADA PROYECTO ----------------------------------- -->
    <!-- ver archivados -->
    <div class="col-12 my-1 form-group">
        <div class="form-check">
            <input wire:model.live="VerProysArchiv" id="VerProysArchiv" value="VerProysArchiv" @if($VerProysArchiv==TRUE)checked @endif class="@error('VerProysArchiv') is-invalid @enderror form-check-input" type="checkbox">
            <label class="form-check-label" for="checkDefault">Mostrar proyectos archivados</label>
        </div>
    </div>

    @if($proyectos->count() > '0')
        <!-- ---------------------- Aviso de ausencia de Rol ---------------------------------- -->
        @if( !session('rol'))
            <div class="alert alert-danger" role="alert">
                <b>¡ Atención !</b><br>
                <p>Aún no cuentas con el Rol de <b>autor</b>. El administrador del sistema ya fue avisado de tu
                solicitud. Carga tus documentos (pica el botón "Acción"), pero espera a que se apruebe tu solicitud de rol para que puedas enviar
                los documentos de tu proyecto.</p>
            </div>
        @endif
        @foreach($proyectos as $p)
            <div class="card my-3">
                <div class="card-body">
                    <!--------------- Cabecera con Título y Estado del proyecto ------------------- -->
                    <a name="{{ $p->proy_jardin }}_{{ str_pad($p->proy_id, 4,"0", STR_PAD_LEFT) }}"></a>
                    <!-- ------------ Calcula el tiempo ------ -->
                    @php
                        $tiempo= new DateTime($p->estados->where('predo_act','1')->value('predo_fecha'))->diff(new DateTime(date('Y-m-d')));
                    @endphp
                    <div onclick="VerNoVerIcon('proyecto','{{ $p->proy_id }}','bi bi-arrow-up-circle','bi bi-arrow-down-circle-fill','block')" style="clear:both; @if($p->proy_act=='0') background-color:#CDC6B9;border:1px solid black;  @endif;" class="card-title PaClick">
                        <h5 style="display:inline-block; margin-top: 5px; margin-bottom: 10px;">
                            <!-- Título -->
                            {{ $p->proy_jardin }}_{{ str_pad($p->proy_id, 4,"0", STR_PAD_LEFT) }}:
                            {{ $p->proy_titulo }}
                            <!-- Detecta si no hay rol de autor -->
                            @if( ($p->autor1 AND $autores->where('rol_usrid',$p->autor1->id)->count() < '1') OR ($p->autor2 AND $autores->where('rol_usrid',$p->autor2->id)->count() < '1') OR ($p->autor3 AND $autores->where('rol_usrid',$p->autor3->id)->count() < '1'))
                                <error><b>No rol autor</b></error>
                            @endif
                            <!-- Indica si ya pasaron más de 15 días -->
                            @if($tiempo->days >= '20')
                                &nbsp; <error><b>¡ {{ $tiempo->format('%m mes y %d días') }} !</b></error>
                            @endif

                        </h5>

                        <div style="float:right;">
                            <b>Estado:</b> {{ $p->estados->where('predo_act','1')->value('predo_edo') }} {{ $p->estados->where('predo_act','1')->value('predo_estado') }}
                            &nbsp; <i id="saleicon_proyecto{{ $p->proy_id }}" class="bi bi-arrow-down-circle-fill"></i>
                            @if($p->proy_act=='0')<error><b>ARCHIVADO</b></error>@endif
                        </div>
                    </div>
                    <!--------------- Cuerpo de proyecto ------------------- -->
                    <div id="sale_proyecto{{ $p->proy_id }}" class="card-text" style="width:100%;display: none;">
                        <!-- Autor, admin y  editor -->
                        <div class="row">
                            <!-- Autores de correspondencia -->
                            <div class="col-12 col-md-4">
                                <b>Autor correspondencia:</b> {{ $p->autor1->usrname ?? '--' }} @if($autores->where('rol_usrid',$p->autor1->id)->count() < '1')<error>**</error>@endif
                                @if($p->autor2)
                                    | {{ $p->autor2->usrname ?? '' }}
                                    @if($autores->where('rol_usrid',$p->autor2->id)->count() < '1')<error>**</error>@endif
                                @endif
                                @if($p->autor3)
                                    | {{ $p->autor3->usrname ?? '' }}
                                    @if($autores->where('rol_usrid',$p->autor3->id)->count() < '1')<error>**</error>@endif
                                @endif
                            </div>
                            <div class="col-12  col-md-4">
                                <b>Administrador:</b> {{ $p->admin->usrname ?? '--' }}
                            </div>
                            <div class="col-12 col-md-4">
                                <b>Editor:</b> {{ $p->editor->usrname ?? '--' }}
                            </div>
                        </div>
                        <!-- muestra archivos pasados -->
                        @foreach($p->estados->where('predo_act','1') as $e)
                            <!-- fecha -->
                            <b>{{ $e->predo_fecha }}</b>
                            <!-- tiempo -->
                            @if($tiempo->format('%m') > '0')
                                (<error><b></b>{{ $tiempo->format('%m mes y %d días') }}</b></error>)
                            @else
                                ({{ $tiempo->format('%d días') }})
                            @endif
                            @if($p->estados->where('predo_act','1')->value('predo_edo') >= 0.2)
                                <div>
                                    <b>Comentarios:</b> <span style="font-size: 100%;">{{ $e->predo_comentario }}</span>
                                </div>
                                <!-- Muestra archivo previos -->
                                <br><b>Archivos recibidos:</b>
                                @if($p->archivos->where('prmat_predoid',$e->predo_id)->where('prmat_del','0')->count() < '1') <i>Ninguno</i> @else <br> @endif
                                @foreach($p->archivos->where('prmat_predoid',$e->predo_id)->where('prmat_del','0') as $a)
                                    <div style="font-size:80%;display:inline-block;margin-right:25px;">
                                        <a href="{{ $a->prmat_archivo }}" target="_blank" class="nolink">{{ $a->prmat_nombrearch }}</a> ({{ $a->prmat_tipo }})
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                            <hr>
                        @foreach($p->estados->where('predo_act','2') as $e)
                            <b>Archivos en preparación para envío:</b>
                            @if($p->archivos->where('prmat_predoid',$e->predo_id)->where('prmat_del','0')->count()<'1') <i>Aún ninguno</i> @else <br> @endif
                            @foreach($p->archivos->where('prmat_predoid',$e->predo_id)->where('prmat_del','0') as $a)
                                <div style="font-size:80%;display:inline-block;margin-right:25px;">
                                    <a href="{{ $a->prmat_archivo }}" target="_blank" class="nolink">{{ $a->prmat_nombrearch }}</a> ({{ $a->prmat_tipo }})
                                </div>
                            @endforeach
                        @endforeach
                        <!-- ------------ Botón de Acción ---------------------- -->
                        <div class="my-4">
                            <button wire:click="AbrirModalProyecto('{{ $p->proy_id }}')" class="btn btn-sm btn-primary bi bi-arrow-up-right-circle-fill"> Acción</button>
                        </div>
                        <!-- ------------- Todos los Estados previos ---------------------- -->
                        @if($p->estados->where('predo_act','0')->count()> '0')
                            <div class="row">
                                <div class="col-12">
                                    <div class="" style="border:1px solid black;border-radius:5px;text-align:right;margin:10px;padding:5px;width:90%;">
                                        <span class="PaClick">
                                            <i onclick="VerNoVerIcon('previos',{{ $p->proy_id }},'bi bi-arrow-bar-up','bi bi-arrow-bar-down','block')" id="saleicon_previos{{ $p->proy_id }}" class="bi bi-arrow-bar-down PaClick"> Ver anteriores</i>
                                        </span>
                                        <table id="sale_previos{{ $p->proy_id }}" class="table table-responsive" style="--bs-table-bg: transparent;display:none;width:100%;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th style="text-align: left;">Estado</th>
                                                    <th>Fecha</th>
                                                    <th></th>
                                                    <th>Archivos</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($p->estados->where('predo_act','0') as $e)
                                                    <tr>
                                                        <td>{{ $e->predo_edo }}</td> <!-- Estado -->
                                                        <td style="text-align: left;">{{ $e->predo_estado }}</td> <!-- Nombre de estado -->
                                                        <td>{{ $e->predo_fecha }}</td>
                                                        <td>{{ $e->predo_comentario }}</td>
                                                        <td>
                                                            @foreach($p->archivos->where('prmat_predoid',$e->predo_id) as $a)
                                                                <div style="font-size:80%">
                                                                    <li><a href="{{ $a->prmat_archivo }}" class="nolink" target="new">{{ $a->prmat_nombrearch }}</a> ({{ $a->prmat_tipo }})</li>
                                                                </div>
                                                            @endforeach
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @endif


    <!-- --------------------------------------------------------------------------------------------- -->
    <!-- ------------------------------SECCIÓN DE BOTONES EXTRA ------------------------------------------ -->
    <!-- --------------------------------------------------------------------------------------------- -->
    <br>
    <div class="row my-1">
        <div class="col-12 my-1">
            <button wire:click="enconstruccion()" class="btn btn-primary bi bi-translate" >
                Quiero traducir
            </button>
        </div>
        <div class="col-12  my-1">
            <button wire:click="AbrirModalParaPedirNvoRol()" class="btn btn-primary bi bi-person-gear">
                Solicitar rol
            </button>
        </div>
        <div class="col-12  my-1">
            <button wire:click="enconstruccion()" class="btn btn-primary bi bi-person-gear">
                Crear nuevo jardin
            </button>
        </div>
    </div>




    <!-- ----------------------- Faltantes ----------------------- -->
    @if(in_array('admin',session('rol')))
        <h3>Pendientes de Enrique</h3>
        <ol>
            <li>Cédulas: Módulo para vaciar imágenes que no estan en sp_cedulas (txt_audio, txt_img1-3, txt_video) o en sp_fotos
            <br>
        </ol>
    @endif

    <livewire:sistema.modal-home-solicita-rol-component />
    <livewire:sistema.modal-proyecto-componenet />

    <script>
        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoHome',()=>{
            alert(event.detail.msj);
        })

        /* #### Recibe variable desde un componente externo y lo manda a livewire */
        Livewire.on('RecibeVariablesEnHome',() => {
           @this.set('proyectos',event.detail.dato, live=true);
        });

        /* ###### Verifica ventanas emergentes */
        Livewire.on('VerificaVentanaEmergente',()=>{
            // Intenta abrir una ventana diminuta y oculta
            var ventanaPrueba = window.open('about:blank', '_blank', 'width=1,height=1,left=0,top=0');
            // Verifica si la ventana fue bloqueada
            if (!ventanaPrueba || ventanaPrueba.closed || typeof ventanaPrueba.closed === 'undefined') {
                alert('¡El bloqueador de ventanas emergentes está activado! Por favor, deshabilítalo para continuar.');
                return true; // Bloqueado
            } else {
                // Cierra la ventana inmediatamente si no está bloqueada
                ventanaPrueba.close();
                return false; // Permitido
            }
        })

    </script>
</div>
