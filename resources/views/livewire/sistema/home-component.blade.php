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
                        <a href="/config" class="nolink" style="">
                            <img src="{{ Auth::user()->avatar }}" class="avatar ">
                            <i class="@if(Auth::user()->mensajes =='1') bi bi-envelope @else bi bi-envelope-x @endif" style="color:black;"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--  ----- Termina Caja de usuario y roles ----- -->
    <!-- ------------------------------------------- -->


    <!-- ------------- Informe de asuntos pendientes ----------- -->
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


    <!-- botones de acción -->
    <div class="row">
        <div class="col-12 my-2">
            <button wire:click="AbrirModalParaPedirNvoRol()" class="btn btn-primary bi bi-person-gear"> Solicitar rol</button>
        </div>
    </div>









    <!-- ----------------------- Faltantes ----------------------- -->
    @if(in_array('admin',session('rol')))
        <h3>Pendientes</h3>
        <ol>
            <li>Botón en home: "solicitar lengua"</li>
            <li>Botón: Solicitar nueva cédula, solicitar traducción </li>
            <li>Cédulas: Buscador de cédulas. Vincular cédulas por tema(s)</li>
            <li>Cédulas: Módulo para vaciar imágenes que no estan en sp_cedulas (txt_audio, txt_img1-3, txt_video) o en sp_fotos
            <br>
        </ol>
    @endif

    <livewire:sistema.modal-home-solicita-rol-component />

    <script>
        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoHome',()=>{
            alert(event.detail.msj);
        })

    </script>
</div>
