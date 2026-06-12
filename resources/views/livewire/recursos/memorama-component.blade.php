<div>


    @if($NombreJuego=='0')
        <h1>Juego de Memoria</h1>

        <div class="row">
            <!-- Agrega jugadores -->
            <div class="col-12 col-md-6 my-1 form-group">
                <label for="NvoJugador" class="form-label">Nombre del jugador {{ count(session('MemNombres'))+1 }}:<red></red></label>
                <input wire:model="NvoJugador" id="NvoJugador" class="@error('NvoJugador') is-invalid @enderror form-control agregar" type="text">
                <button type="button" wire:click="AgregaJugador" class="btn btn-primary agregar">+</button>
                <div class="form-text"></div>
                @error('NvoJugador')<error>{{ $message }}</error>@enderror


            </div>

            <!-- Gran Ayuda -->
            @if($edit=='1')
                <div class="col-12 col-md-3 my-1 form-group">
                    <div class="form-check"><br>
                        <input wire:model="granAyuda" id="granAyuda" value="" class="@error('granAyuda') is-invalid @enderror form-check-input" type="checkbox" >
                        <label class="form-check-label" for="checkDefault">Gran Ayuda</label>
                    </div>
                </div>
            @endif

            <!-- Tamaño de carta -->
            <div style="float: right;">
                <span wire:click='CambiaTamanio2(50,100)' class="PaClick mx-2">Mini</span>
                <span wire:click='CambiaTamanio2(70,120)' class="PaClick mx-2">Chico</span>
                <span wire:click='CambiaTamanio2(110,160)' class="PaClick mx-2">Mediano</span>
                <span wire:click='CambiaTamanio2(150,200)' class="PaClick mx-2">Normal</span>
                <span wire:click='CambiaTamanio2(180,230)' class="PaClick mx-2">Grande</span>
                <span wire:click='CambiaTamanio2(210,260)' class="PaClick mx-2">Grandísimo</span>
                <span wire:click='CambiaTamanio2(250,300)' class="PaClick mx-2">Enorme</span>
                <i wire:click="CambiaTamanio(+10)"class="bi bi-plus-circle-fill PaClick mx-2" style="color:#64383E;"> </i>
                <i wire:click="CambiaTamanio(-10)" class="bi bi-dash-circle-fill PaClick mx-2" style="color:#64383E;"> </i>
            </div>
            <!-- muestra jugadores-->
            <div class="col-12">
                {{-- <button wire:click='temp()'>a</button> --}}
                @foreach($nombres as $n)
                    <div class="elemento p-1">
                        {{ $n['name'] }}
                        <i wire:click="EliminaJugador('{{ $n['name'] }}')" class="bi bi-trash agregar"></i>
                    </div>
                @endforeach
            </div>
        </div>


        <br><br>
        <h3>Selecciona el juego</h3>
        <div class="row my-4">
            @foreach ($NombreJuegos as $j)
            <div style="display:inline-block; width:{{ session('MemAncho') }}px; height:{{ session('MemAlto') }}px; margin:10px;">
                <div wire:click="SeleccionaJuego('{{ $j->jue_name }}')"
                    class="cartaAbierta"
                    style="width:{{ session('MemAncho') }}px; height:{{ session('MemAlto') }}px; @if($j->jue_portada != '')background-image:url('{{ $j->jue_portada }}'); @endif background-size:auto {{ session('MemAlto') }}px; margin-bottom:0px;">
                    @if($j->jue_portada==''){{ $j->jue_name }}@endif
                </div>
                <div style="margin-top:0px;font-size:80%;margin-left:10px;">
                    {{ $j->jue_name }}<br>({{ $j->cartas->count()/2 }} pares)
                </div>
            </div>
            @endforeach
        </div>
    @else
        <!-- ------------------------------------------------------------------ -->
        <!-- --------------  INICIA JUEGO ------------------------------------- -->
        <!-- ------------------------------------------------------------------ -->
        <div class="row">
            <div class="col-6 col-md-2">
                <a href="/memorama">
                    <button class="btn btn-secondary">Regresar</button>
                </a>

            </div>
        </div>
        <h1>Jugando {{ $NombreJuego }}</h1>
        <!-- marcador -->
        <div class="row">
            @foreach ($nombres as $n)
                <div class="col-4 col-md-2" style="@if($nombres[$turno]['name'] == $n['name']) color:#CD7B34; font-size:200%; @else color:gray;  @endif vertical-align:middle;">
                    {{ $n['name'] }}
                    <b>
                        {{ $n['pt'] }}
                    </b>

                </div>
            @endforeach
        </div>

        <!-- ------------- Inicia tablero -------------------- -->
        <div class="row">
            <div class="col-12" wire:ignore>
                <!-- cada carta -->
                @foreach ($baraja as $c)
                    <!-- carta cerrada -->
                    <div id="CartaCe{{ $c->mem_id }}" wire:click="TurnoDeJuego({{ $c->mem_id }})" class="cartaCerrada" style="display:block-inline; width:{{ session('MemAncho') }}px; height:{{ session('MemAlto') }}px">
                        @if($granAyuda==TRUE)<div style="color:red; float: right;">{{ $c->mem_par }}@if($c->mem_img !='')<b>*</b>@endif @if($c->mem_aud !='')<b>^</b>@endif</div>@endif
                    </div>

                    <!-- carta abierta-->
                    <div id="CartaAb{{ $c->mem_id }}" wire:click="TurnoDeJuego({{ $c->mem_id }})" class="cartaAbierta" style="display:none; background-image: url('{{ $c->mem_img }}');  width:{{ session('MemAncho') }}px; height:{{ session('MemAlto') }}px; background-size:auto {{ session('MemAlto') }}px">
                        @if($granAyuda==TRUE)<div style="color:red; float: right;">{{ $c->mem_par }}@if($c->mem_img !='')<b>*</b>@endif @if($c->mem_aud !='')<b>^</b>@endif</div>@endif
                        @if($c->mem_txt != '')
                            <div id="Txt{{ $c->mem_id }}" style="background-color:#efebe8; width:100%; margin:0px; padding:4px; border-radius:7px;">
                                {!!  $c->mem_txt !!}
                            </div>
                        @endif
                        @if($c->mem_aud != '')
                            <i class="bi bi-volume-up"></i>
                            <audio id="SpAudio{{ $c->mem_id }}">
                                <source src="{{ $c->mem_aud }}" type="audio/ogg" /> El navegador no soporta el audio
                            </audio>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

    @endif







<script>
    Livewire.on('AbreCarta',()=>{
        id=event.detail.id;
        document.getElementById('CartaCe'+id).style.display ='none';
        document.getElementById('CartaAb'+id).style.display ='inline-block';
    })

    Livewire.on('CierraCartas',()=>{
        id1=event.detail.id1;
        id2=event.detail.id2;
        document.getElementById('CartaCe'+id1).style.display ='inline-block';
        document.getElementById('CartaAb'+id1).style.display ='none';
        document.getElementById('CartaCe'+id2).style.display ='inline-block';
        document.getElementById('CartaAb'+id2).style.display ='none';

    })

    Livewire.on('GanaCartas',()=>{
        id1=event.detail.id1;
        id2=event.detail.id2;
        document.getElementById('CartaCe'+id1).style.display ='inline-block';
        document.getElementById('CartaAb'+id1).style.display ='none';
        document.getElementById('CartaCe'+id2).style.display ='inline-block';
        document.getElementById('CartaAb'+id2).style.display ='none';
        document.getElementById('CartaCe'+id1).className= 'cartaGanada';
        document.getElementById('CartaCe'+id2).className= 'cartaGanada';

    })
    Livewire.on('AvisaGana',()=>{
        id1=event.detail.id1;
        id2=event.detail.id2;
        document.getElementById('CartaAb'+id1).className= 'avisoGanada';
        document.getElementById('CartaAb'+id2).className= 'avisoGanada';
    })

    Livewire.on('EjecutaAudio',()=>{
        //busca si hay audios encendidos
        var AlgunoConPlay = document.querySelectorAll('[id*="SpAudio"]');
        // Si hay, los pausa todos
        if(AlgunoConPlay.length > 0){
            AlgunoConPlay.forEach(el => {
                if (typeof el.pause === 'function') {
                    el.pause();
                }
            });
        }
        //Ejecuta el audio
        id=event.detail.id;
        const MyAudio = document.getElementById('SpAudio'+id);
        MyAudio.currentTime = 0;
        MyAudio.play();
    })

        // /* ### Script para abrir y cerrar Modal */
        // Livewire.on('AbreModal', () => {
        //     $('#ModalAlias_Especies').modal('show');
        // });
        // Livewire.on('CierraModal', () => {
        //     $('#ModalAlias_Especies').modal('hide');
        //     if(event.detail.reload == '1'){
        //         window.location.reload();
        //     }
        // });

        /* ### Script para abrir mensaje */
        Livewire.on('AvisoExitoMemoria',()=>{
            alert(event.detail.msj);
        })

        /* ### Script para mostrar botón personalizado de input=file */
        //document.getElementById('MiBotonPersonalizado').addEventListener('click', function() {
        //    document.getElementById('MiInputFile').click();
        //});

        /* #### Recibe variable desde un componente externo y lo manda a livewire */
        //Livewire.on('RecibeVariables',() => {
        //    @this.set('ModeloWire',event.detail.dato, live=true);
        //});

        /* #### Reiniciar la página */
        Livewire.on('RecargarPagina',() => {
            location.reload();
            // window.location.href;
        });
    </script>

</div>
