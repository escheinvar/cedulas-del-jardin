<div>
    <!--  Buzón viejo de cédulas -->

    <h3><i class="bi bi-inbox"></i> Buzón</h3>

    <!-- ------------- indicador del número de mensajes ---------------------- -->
    <span wire:click="VerNoVerLeidos()" style="margin:5px; font-weight:bold;" class="PaClick">
        @if($verLeidos=='0')
            <i class="bi bi-eye"></i> Mostrar leídos
        @else
            <i class="bi bi-eye-slash"></i> Ocultar leídos
        @endif
    </span>
    <span style="margin:5px; padding:1px; @if($buzon->where('buz_leido','0')->count() > 0)color:#CD7B34; font-weight:bold; @endif">
        <i class="bi bi-envelope-fill"></i>
        {{ $buzon->where('buz_leido','0')->count() }}
        @if($buzon->where('buz_leido','0')->count() =='1')mensaje nuevo @else mensajes nuevos @endif
    </span>

    <span style="margin:5px; padding:1px; color:gray; @if($buzon->where('buz_leido','1')->count() > 0) font-weight:bold; @endif">
        <i class="bi bi-envelope-open"></i>
        {{ $buzon->where('buz_leido','1')->count() }}
        @if($buzon->where('buz_leido','1')->count() =='1')mensaje leído @else mensajes leídos @endif
    </span>
    <span style="margin:5px; padding:1px;" >
        <button wire:click="LeerMensajes()" type="button" class="btn btn-sm btn-primary" style="display:inline-block" @if(count($ganonesLee)==0) disabled @endif)>
            <i class="bi bi-envelope-open"></i> Leer {{ count($ganonesLee) }} @if(count($ganonesLee)==1)mensaje @else mensajes @endif
        </button>
        <span style="float: right;">

        <button wire:click="BorrarMensajes()" type="button" class="btn btn-sm btn-primary" style="display:inline-block" @if(count($ganonesBorra)==0) disabled @endif wire:confirm="Estás por eliminar definitivamente este mensaje. Esta acción no puede ser revertida. ¿Deseas continuar?">
            <i class="bi bi-trash"></i> Borrar {{ count($ganonesBorra) }} @if(count($ganonesBorra)==1)mensaje @else mensajes @endif
        </button>
        </span>
    </span>

    <!-- -------------------------------------------- inicia buzón -------------------------- -->
    @if($buzon->count() > 0)
        <table class="table table-striped" style="width:100%; ">
            <tbody>
                @foreach ($buzon->where('buz_leido','<=',$verLeidos) as $b)
                <tr>
                    <td class="p-3 m-2">
                        <div>

                            {{-- <span class="PaClick m-1 p-1" wire:click="LeerMensaje('{{ $b->buz_id }}')"> --}}
                            <span class="m-1 p-1" >
                                @if($b->buz_leido == '0')
                                    <input type="checkbox" wire:model.live="ganonesLee" id="ch{{ $b->buz_id }}" value="{{ $b->buz_id }}">
                                    <i class="bi bi-envelope-fill"></i>
                                @else
                                    <i class="bi bi-envelope-open"></i>
                                    <input type="checkbox" wire:model.live="ganonesLee" id="ch{{ $b->buz_id }}" value="{{ $b->buz_id }}">
                                @endif
                            </span>
                            <span style="@if($b->buz_leido =='1') color:gray; @endif">
                                <b>{{ $b->buz_asunto }}</b>
                            </span>
                        </div>
                        <div style="@if($b->buz_leido =='1') color:gray; @endif">
                            {{ $b->buz_mensaje }}<br>
                            <span style="font-size:80%;">
                                @if($b->buz_notas != '') {{ $b->buz_notas }} <br> @endif
                            </span>
                        </div>
                        <!-- responder a mensaje -->
                        <div wire:click="ReplyMsj('{{ $b->buz_id }}');" class="PaClick" style="color:gray; margin-top:10px;font-size:80%;">
                            <a href="#enviar" class="nolink">
                                <i class="bi bi-reply"></i> a {{ $b->usrname }}
                            </a>
                        </div>
                        <!-- muestra fecha -->
                        <div style="text-align: right;">
                            {{ preg_replace('/ .*/', '',$b->buz_date_origen) }}
                            <span style="font-size: 70%;">
                                {{ preg_replace('/:..$/','',     preg_replace('/.* /', '',$b->buz_date_origen) )}}
                            </span>
                            <!-- botón de borrar -->
                            {{-- <span class="PaClick m-1 p-1" wire:click="BorrarMensaje('{{ $b->buz_id }}')" wire:confirm="Estás por eliminar definitivamente este mensaje. Esta acción no puede ser revertida. ¿Deseas continuar?"> --}}
                            <span class="m-1 p-1">
                                <i class="bi bi-trash"> </i>
                                <input type="checkbox" wire:model.live="ganonesBorra" id="ch{{ $b->buz_id }}" value="{{ $b->buz_id }}">
                            </span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        -- No tienes mensajes en tu buzón --
    @endif


    <br><br>
    <!-- ------------------------------------ Enviar un mensaje ------------------------------------->
    <!-- ------------------------------------ Enviar un mensaje ------------------------------------->
    <!-- ------------------------------------ Enviar un mensaje ------------------------------------->
    <a name="enviar"> &nbsp; </a>
    <div wire:click="VerEnviar('1')"  class="PaClick">
        <h3> <i class="bi bi-envelope-at"></i> @if($RepplyTo=='')Enviar nuevo mensaje @else Responder mensaje @endif</h3>
    </div>
    @if($VerEnviarMsj=='1')
        <div id="sale_mnsEnvio">
            <div class="row">
                @if($RepplyTo == '')
                    <div class="col-md-3">
                        <label class="form-label">Destino:</label>
                        <select wire:model="MsjA" class="form-select" >
                            <option value="">Selecciona un destinatario.</option>
                            @foreach ($dest as $d)
                                <option value="{{ $d->rol_usrid }}">{{ $d->rol_crolrol }}: {{ $d->rol_tipo1 }} {{ $d->rol_tipo2 }} ({{ $d->usrname }})</option>
                            @endforeach
                        </select>
                        @error('Msj"')<error>{{ $message }}</error>@enderror
                    </div>
                    <div class="col-md-9">
                        <label  class="form-label">Asunto:</label>
                        <input wire:model="MsjAsunto" type="text" class="form-control">
                        @error('MsjAsunto')<error>{{ $message }}</error>@enderror
                    </div>
                @else
                    <div class="col-12">
                        Respondiendo a:<br><b>{{ $RepplyTo['buz_asunto'] }}</b><br>
                        {{ $RepplyTo['buz_mensaje'] }}<br>
                        {{ $RepplyTo['buz_notas'] }}<br>
                        @error('Msj"')<error>{{ $message }}</error>@enderror
                        @error('MsjAsunto')<error>{{ $message }}</error>@enderror
                    </div>
                @endif
                <div class="col-md-12" style="margin:10px;">
                    <label class="form-label">Mensaje:</label>
                    <textarea wire:model="Msj" class="form-control"></textarea>
                    @error('Msj')<error>{{ $message }}</error>@enderror
                </div>
                <div class="col-md-12">
                    @if($RepplyTo !='')
                        Nota:
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <button type="button" wire:click="cancelarMsj()" class="btn btn-secondary" style="margin:10px;">Cancelar</button>
                </div>
                <div class="col-md-2">
                    <button type="button" wire:click="enviarMsj()" class="btn btn-primary" style="margin:10px;">Enviar mensaje</button>
                </div>
            </div>


            <br><br>
            <h3>Mensajes enviados</h3>
            <!-- ------------------------------------ Ver mis mensajes ------------------------------------->
            @if($propios->count()>0)
                <table class="table table-striped">
                    @foreach ($propios as $p)
                        <tr>
                            <td>
                                A: {{ $p->usrname }}. &nbsp;
                                <span style="font-size: 90%">
                                    <b>{{ $p->buz_asunto }}</b>:
                                    {{ $p->buz_mensaje }}
                                </span>
                                <span style="float: right;">
                                    {{ preg_replace('/ .*/', '',$p->buz_date_origen) }}
                                    <span style="font-size: 70%;">
                                        {{ preg_replace('/:..$/','',     preg_replace('/.* /', '',$p->buz_date_origen) )}}
                                    </span>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                -- No has enviado ningún mensaje aún --
            @endif
        </div>
    @endif
</div>
