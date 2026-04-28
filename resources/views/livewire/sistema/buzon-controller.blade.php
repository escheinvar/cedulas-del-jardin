@section('title') Buzón del SiCeJar @endsection
@section('meta-description') Buzón de usuario del sistema de cédulas del Jardín @endsection
@section('cintillo-ubica') -> {{ request()->path() }} @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection

<div>
    <div class="container">

        <h2><i class="bi bi-inbox"></i> Buzón de {{ Auth::user()->usrname }}</h2>
        <div>
            <!-- indicador de número de  nuevos -->
            <span style="margin:5px; padding:1px; @if($buzon->where('buz_leido','0')->count() > 0)color:#CD7B34; font-weight:bold; @endif">
                {{ $buzon->where('buz_act','1')->where('buz_from','!=',Auth::user()->id)->count() }} <i class="bi bi-envelope-fill"></i>
                @if($buzon->where('buz_act','0')->where('buz_from','!=',Auth::user()->id)->count() =='1') nuevo @else nuevos @endif
            </span>
            <!-- indicador de número de leídos -->
            @if($verLeidos==TRUE)
                <span style="margin:5px; padding:1px; color:gray; @if($buzon->where('buz_leido','1')->count() > 0) font-weight:bold; @endif">
                    {{ $buzon->where('buz_act','0')->where('buz_from','!=',Auth::user()->id)->count() }} <i class="bi bi-envelope-open"></i>
                    @if($buzon->where('buz_act','0')->where('buz_from','!=',Auth::user()->id)->count() =='1') leído @else leídos @endif
                </span>
            @endif
        </div>
        <!-- ---------------------------------------------------------------------------------- -->
        <!-- ------------- INICIA BARRA SUPERIOR DE ACCIONES PARA BUZÓN  ---------------------- -->
        <div class="my-2" style="background-color:#CDC6B9; padding:5px; clear:both;">
            <!-- Marcar todos -->
            <div class="form-check mx-1" style="display:inline-block;">
                <input wire:model.live="SelectTodo" wire:click="MarcaDesmarcaTodo()"  class="form-check-input" type="checkbox" id="checkDefault">
                <label class="form-check-label" for="checkDefault">
                    Marcar todos
                </label>
            </div>
            <!-- mostrar leídos -->
            <div class="form-check mx-1" style="display:inline-block;">
                <input wire:model.live="verLeidos" class="form-check-input" type="checkbox" id="checkDefault">
                <label class="form-check-label" for="checkDefault">
                    Mostrar leídos
                </label>
            </div>
            <!-- mostrar enviados -->
            <div class="form-check mx-1" style="display:inline-block;">
                <input wire:model.live="verEnviados" class="form-check-input" type="checkbox" id="checkDefault">
                <label class="form-check-label" for="checkDefault">
                    Mostrar enviados
                </label>
            </div>


            <div style="margin:5px; padding:1px; display:inline-block;" >
                <button wire:click="LeerMensajes()" type="button" class="btn btn-sm btn-primary mx-2" style="color:#CDC6B9; display:inline-block" @if(count($ganonesLee)==0) disabled @endif)>
                    <i class="bi bi-envelope-open" style="color:#CDC6B9;"></i> Leer <sub> {{ count($ganonesLee) }}</sub>
                </button>

                <button wire:click="BorrarMensajes()" type="button" class="btn btn-sm btn-primary mx-2" style="color:#CDC6B9; display:inline-block" @if(count($ganonesLee)==0) disabled @endif wire:confirm="Estás por eliminar definitivamente este mensaje. Esta acción no puede ser revertida. ¿Deseas continuar?">
                    <i class="bi bi-trash" style="color:#CDC6B9;"></i> Borrar <sub>{{ count($ganonesLee) }}</sub>
                </button>
            </div>
        </div>
        <!-- ------------------------------------------------------------------- -->
        <!-- ------- TERMINA BARRA SUPERIOR DE ACCIONES PARA BUZÓN  ------------ -->

        <!-- ------------------------------------------------------------------- -->
        <!-- ----------------- INICIA BUZÓN DE MENSAJES ------------------------ -->
        @if($buzon->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-responsive-sm" style="width:100%; ">
                    <tbody>
                        @foreach ($buzon as $b)
                            <tr style="border:1px solid #CDC6B9;">
                                <td class="p-3 m-2" style="@if($b->buz_act=='0')color:gray; @endif">
                                    <!-- cabecera del mensaje -->
                                    <div style="">
                                        @if($b->buz_to==Auth::user()->id)<!-- solo muestra si son recibidos (no enviados) -->
                                            <div style="display: inline-block;" class="m-1 p-1">
                                                <input type="checkbox" wire:model.live="ganonesLee"  id="ch{{ $b->buz_id }}" value="{{ $b->buz_id }}" >
                                                <span class="PaClick" wire:click="MarcarComoLeido('{{ $b->buz_id }}')">
                                                    @if( $b->buz_act == '1')
                                                        <i class="bi bi-envelope-fill"></i>
                                                    @else
                                                        <i class="bi bi-envelope-open"></i>
                                                    @endif
                                                    {{ $b->usrname }}: <b>{{ $b->buz_asunto }}</b>
                                                </span>
                                            </div>
                                        @else
                                            <i class="bi bi-arrow-up-circle"><sub>{{ $b->buz_id }}</sub></i> {{ $b->buz_asunto }}
                                        @endif

                                        <!-- muestra fecha -->
                                        <div class="m-1 p-1" style="float:right;">
                                            <span class="" style="color:gray; font-size:80%">
                                                {{ $b->buz_date }}
                                                {{ preg_replace('/:..$/','',$b->buz_hora) }}
                                            </span>
                                        </div>
                                    </div>
                                    <!-- cuerpo del mensaje -->
                                    <div style="@if($b->buz_act =='0') color:gray; @endif display:block;" class="m-1 p-1">
                                        {!! $b->buz_mensaje !!}

                                        @if($b->buz_notas != '')
                                            <div style="font-size:80%; color:gray; margin-left:10px;" onclick="VerYocultar('nota','{{ $b->buz_id }}')" id="entra_nota{{ $b->buz_id }}" class="PaClick">
                                                <i class="bi bi-arrow-down-right-square"></i> Ver mensajes previos

                                            </div>
                                            <div style="font-size:80%; color:gray;display:none;" onclick="VerYocultar('nota','{{ $b->buz_id }}')" id="sale_nota{{ $b->buz_id }}" class="PaClick">
                                                <i class="bi bi-arrow-up-right-square"></i> Ocultar mensajes previos
                                                {!! $b->buz_notas !!}
                                            </div>
                                        @endif
                                        </div>
                                    </div>

                                    <!-- responder a mensaje -->
                                    <div style="color:gray; margin-top:10px;font-size:80%;">
                                        @if($b->buz_to == Auth::user()->id AND $b->buz_from != Auth::user()->id)
                                            @if($b->buz_from > '0')
                                                <span wire:click="AbreModalDeMensaje('{{ $b->buz_id }}')" class="PaClick">
                                                    <i class="bi bi-reply"></i> responder a {{ $b->usrname }}
                                                </span>
                                            @else
                                                Mensaje de sistema
                                            @endif
                                        @else
                                            Enviado a {{ $b->usrname }}
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            -- No tienes mensajes en tu buzón --
        @endif
        <!-- ----------------- TERMINA BUZÓN DE MENSAJES ------------------------ -->
        <!-- ------------------------------------------------------------------- -->
        <div>
            <button type="button" wire:click="AbreModalDeMensaje('0')">
                <i class="bi bi-envelope-at"></i> Nuevo mensaje
            </button>
        </div>
    </div>

    <livewire:sistema.modal-buzon-mensaje-controller />



    <script>
        /* #### Script para marcar/desmarcar todos los mensajes */
        function MarcaDesmarcaTodo(source) {
            // Get all checkboxes with the class 'my-checkbox-class'
            var checkboxes = document.querySelectorAll('.EsteMensaje');

            // The 'source' is the "Select All" checkbox itself (passed via 'this' in HTML onclick)
            var isChecked = source.checked;

            // Iterate over the checkboxes and set their 'checked' property
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = isChecked;
            }
        }

    </script>
</div>

@section('scripts') @endsection
