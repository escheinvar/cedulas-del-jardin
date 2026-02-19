<div>
    @section('title')
    Actividades
    @endsection

    @section('meta-description')
    ¿Tienes interés en la botánica, la ecología o la historia de Oaxaca? Conoce las diversas conferencias, talleres y actividades que tenemos para ti.
    @endsection

    @section('banner')
    banner-actividades
    @endsection

    @section('banner-title')
    Eventos
    @endsection




    <!--S1 PROXIMAMENTE-->
    <section class="proximamente pt-4 pb-3">
        <!-- ############################################################################################# -->
        <!-- ################################ FICHAS DE EVENTOS FUTUROS ################################## -->
        @if(count($eventosProx) > 0)
            <div class="container px-4 py-5" id="bienvenido">
                <h2 class="subtitulo">Próximamente </h2>
                @foreach ($eventosProx as $i)
                    <article class="evento">
                        <div class="row justify-content-around p-5">
                            <!-- cartel portada -->
                            <div class="col-sm-5 col-md-5 col-lg-3 cartel">
                                <a href="{{$i->wwevs_img}}" target="new" class="nolink">
                                    <img src="{{$i->wwevs_img}}" alt="Cartel {{$i->wwevs_titulo}}"
                                        class="img-fluid">
                                </a>
                            </div>
                            <div class="col-sm-7 col-md-7 col-lg-5 descripcion">
                                <h3 class="evento-nombre">
                                    {{$i->wwevs_titulo}}
                                </h3>
                                <div class="etiquetas">
                                    <ul class="tags" >
                                        <?php
                                            $etiqs=explode(',',$i->wwevs_label)
                                        ?>
                                        @foreach ($etiqs as $e)
                                            <li class="tag-{{$e}}">{{$e}}</li>
                                        @endforeach
                                    </ul>
                                </div>

                                <div class="evento-descripcion">
                                    <p>{{$i->wwevs_descrip}}</p>
                                    @if($i->wwevs_descrip2 != '') <p>{{$i->wwevs_descrip2}}</p> @endif
                                </div>
                            </div>
                            <div class=" col-sm-11 col-md-12 col-lg-3 px-4 pt-3 datos-evento ">
                                <div class="row horario">
                                    <div class="col-sm-6 col-md-3 col-lg-12 p-0 pb-3">
                                        <div class="row">
                                            <div class="col-auto p-0">
                                                <img src="imagenes/icono-reloj.png" alt="icono reloj">
                                            </div>
                                            <div class="col">
                                                <p>{{substr($i->wwevs_timeini,-8,5)}}
                                                    @if($i->wwevs_timefin !='') - {{substr($i->wwevs_timefin,-8,5)}}  @endif horas</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3 col-lg-12 p-0 pb-3">
                                        <div class="row">
                                            <div class="col-auto p-0">
                                                <img src="imagenes/icono-calendario.png" alt="icono calendario">
                                            </div>
                                            <div class="col">
                                                <p>{{substr($i->wwevs_dateini,-2)}} de {{$mes[intval(substr($i->wwevs_dateini,-5,2))]}}
                                                    @if($i->wwevs_datefin != $i->wwevs_dateini) a<br>{{substr($i->wwevs_datefin,-2)}} de {{$mes[intval(substr($i->wwevs_datefin,-5,2))]}} @endif</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-5 col-lg-12 p-0 pb-3">
                                        <div class="row">
                                            <div class="col-auto p-0">
                                                <img src="imagenes/icono-mapa.png" alt="icono lugar">
                                            </div>
                                            <div class="col">
                                                <p>{{$i->wwevs_lugar}}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-12 col-lg-12 p-0">
                                        <div class="row">
                                            <h5>{{$i->wwevs_costo}}</h5>
                                        </div>
                                        @if(auth()->user() AND in_array('webmaster', session('rol')))
                                            <i class="bi bi-trash" wire:click="Borrar({{$i->wwevs_id}})" wire:confirm="Estás por eliminar el evento '{{$i->wwevs_titulo}}' ¿Quieres seguir?" style="cursor: pointer;"></i> &nbsp; &nbsp;
                                            <a href="#editor" class="nolink">
                                                <i class="bi bi-pencil-square" wire:click="EditaEvento('{{ $i->wwevs_id }}')"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

        <!-- ############################################################################################# -->
        <!-- ################################ FORMULARIO DE NUEVO EVENTO ################################# -->
        @if(null !== session('rol') )
            @if(auth()->user() AND in_array('webmaster', session('rol')))
                <div class="container px-4 py-5">
                    <div style="float: right;">
                        <button wire:click="MostrarNuevoEvento()" class="boton">
                            <i class="bi bi-plus-circle"></i> Nuevo evento
                        </button>
                    </div>
                    <a name="editor"> &nbsp; </a>
                    @if($VerNuevoEvento=='1')
                        <div class="row">
                            <div class="col-md-4 form-group">
                                <label>Título <red>*</red></label>
                                <input wire:model="titulo" type="text" class="form-control">
                                @error('titulo')<error>{{$message}}</error>@enderror
                            </div>

                            <div class="col-md-8 form-group">
                                <label>Lugar <red>*</red></label>
                                <input wire:model="lugar" type="text" class="form-control">
                                @error('lugar')<error>{{$message}}</error>@enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 form-group">
                                <label for="correo">Descripción <red>*</red></label>
                                <input wire:model="descripcion" type="text" class="form-control">
                                @error('descripcion')<error>{{$message}}<br></error>@enderror

                                <label for="correo">Descripción línea 2 (opcional)</label>
                                <input wire:model="descripcion2" type="text" class="form-control">
                                @error('descripcion2')<error>{{$message}}</error>@enderror
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Tipo de evento <red>*</red></label>
                                <select wire:model="tipo" multiple type="text" class="form-control">
                                    <option value="Comunicado">Comunicado</option>
                                    <option value="Recorrido">Recorrido</option>
                                    <option value="Taller">Taller</option>
                                    <option value="Conferencia">Conferencia</option>
                                    <option value="Cultural">Cultural</option>
                                    <option value="Presentacion">Presentacion</option>
                                </select>
                                @error('tipo')<error>{{$message}}</error>@enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-lg-2 form-group">
                                <label>Fecha de inicio <red>*</red></label>
                                <input wire:model="fechaIni" min="{{date('Y-m-d')}}" type="date" class="form-control">
                                @error('fechaIni')<error>{{$message}}</error>@enderror
                            </div>
                            <div class="col-md-3 col-lg-2 form-group">
                                <label>Hora de inicio <red>*</red></label>
                                <input wire:model="horaIni" type="time"  class="form-control">
                                @error('horaIni')<error>{{$message}}</error>@enderror
                            </div>

                            <div class="col-md-3 col-lg-2 form-group">
                                <label>Fecha de finalización </label>
                                <input wire:model="fechaFin" min="{{date('Y-m-d')}}" type="date" class="form-control">
                                @error('fechaFin')<error>{{$message}}</error>@enderror
                            </div>
                            <div class="col-md-3 col-lg-2 form-group">
                                <label>Hora de finalización </label>
                                <input wire:model="horaFin" type="time" class="form-control">
                                @error('horaFin')<error>{{$message}}</error>@enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-lg-2 form-group">
                                <label>Costo (texto) </label>
                                <input wire:model="costo" type="text" class="form-control">
                                @error('costo')<error>{{$message}}</error>@enderror
                            </div>

                            <div class="col-md-4 col-lg-5 form-group">
                                <label>Imagen </label>
                                <input wire:model="imagen" type="file" class="form-control">
                                @error('imagen')<error>{{$message}}</error>@enderror
                            </div>

                            <!-- Muestra Imágen de portada -->
                            <div class="col-md-5 col-lg-5">
                                <!-- Muestra Imágen de portada si proviene de edición (ya hay imagen)-->
                                @if($TipoFormulario > '0' and $imagen =='')
                                    <img src="{{$imagen2}}" style="width:70%;">
                                    <i wire:click="BorrarImagen()" class="bi bi-trash PaClick"></i>
                                @endif
                                <!-- Muestra Imágen nueva -->
                                @if($imagen)
                                    <span wire:loading wire:target="imagen"> Cargando archivo...</span>
                                    <img src="{{$imagen->temporaryUrl()}}" style="width:90%;">
                                @endif

                            </div>
                        </div>
                        <br>

                        <botton wire:click="Guardar()" class="boton3" style="display:inline-block;">
                            Guardar @if($TipoFormulario=='0') nuevo @else cambios @endif
                        </botton>
                        <botton  wire:click="CancelarNuevoEvento();" class="boton2" style="display:inline-block;">
                            Cancelar
                        </botton>
                    @endif
                </div>
            @endif
        @endif
    </section>

    <!-- ############################################################################################# -->
    <!-- ################################ FICHAS DE EVENTOS PASADOS ################################## -->
    <a name="SeccionAnteriores"></a>
    <section class="eventos-anteriores pt-4 pb-3">
        <div class="container px-4 py-5" id="bienvenido">
            <h2 class="subtitulo">Eventos pasados</h2>
            @if($eventosPast->hasPages())
                <span style="color:#87796d">Página: {{$eventosPast->currentPage()}}</span>
            @endif

            @foreach ($eventosPast as $i)
                <article class="evento">
                    <div class="row justify-content-around p-5">
                        <div class="col-sm-5 col-md-5 col-lg-3 cartel">
                            <a href="{{$i->wwevs_img}}" target="new" class="nolink">
                                <img src="{{$i->wwevs_img}}" alt="Cartel {{$i->wwevs_titulo}}"
                                    class="img-fluid">
                            </a>
                        </div>
                        <div class="col-sm-7 col-md-7 col-lg-5 descripcion">
                            <h3 class="evento-nombre">
                                {{$i->wwevs_titulo}}
                            </h3>
                            <div class="etiquetas">
                                <ul class="tags">
                                    <?php
                                        $etiqs=explode(',',$i->wwevs_label)
                                    ?>
                                    @foreach ($etiqs as $e)
                                        <li class="tag-{{$e}}">{{$e}}</li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="evento-descripcion">
                                <p>{{$i->wwevs_descrip}}</p>
                                @if($i->wwevs_descrip2 != '') <p>{{$i->wwevs_descrip2}}</p> @endif
                            </div>
                        </div>
                        <div class=" col-sm-11 col-md-12 col-lg-3 px-4 pt-3 datos-evento ">
                            <div class="row horario">
                                <div class="col-sm-6 col-md-3 col-lg-12 p-0 pb-3">
                                    <div class="row">
                                        <div class="col-auto p-0">
                                            <img src="imagenes/icono-reloj.png" alt="icono reloj">
                                        </div>
                                        <div class="col">
                                            <p>{{substr($i->wwevs_timeini,-8,5)}}
                                                @if($i->wwevs_timefin !='') - {{substr($i->wwevs_timefin,-8,5)}}  @endif horas</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3 col-lg-12 p-0 pb-3">
                                    <div class="row">
                                        <div class="col-auto p-0">
                                            <img src="imagenes/icono-calendario.png" alt="icono calendario">
                                        </div>
                                        <div class="col">
                                            <p>{{substr($i->wwevs_dateini,-2)}} de {{$mes[intval(substr($i->wwevs_dateini,-5,2))]}}
                                                @if($i->wwevs_datefin != $i->wwevs_dateini) a<br>{{substr($i->wwevs_datefin,-2)}} de {{$mes[intval(substr($i->wwevs_datefin,-5,2))]}} @endif de {{substr($i->wwevs_dateini,-10,4)}} </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-5 col-lg-12 p-0 pb-3">
                                    <div class="row">
                                        <div class="col-auto p-0">
                                            <img src="imagenes/icono-mapa.png" alt="icono lugar">
                                        </div>
                                        <div class="col">
                                            <p>{{$i->wwevs_lugar}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-12 col-lg-12 p-0">
                                    <div class="row">
                                        <h5>{{$i->wwevs_costo}}</h5>
                                        @if(auth()->user() AND in_array('webmaster', session('rol')))
                                            <div>
                                                <i class="bi bi-trash" wire:click="Borrar({{$i->wwevs_id}})" wire:confirm="Estás por eliminar el evento '{{$i->wwevs_titulo}}' ¿Quieres seguir?" style="cursor: pointer;"></i>
                                                &nbsp; &nbsp;
                                                <a href="#editor" class="nolink">
                                                    <i class="bi bi-pencil-square" wire:click="EditaEvento('{{ $i->wwevs_id }}')"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach

            @if($eventosPast->hasPages())
                <div class="paginador">
                    @if($eventosPast->onFirstPage()) @else
                        <a href="{{$eventosPast->previousPageurl()}}#SeccionAnteriores">
                            <div class="boton abajo" style="display: inline-block;" ></div>
                        </a>
                    @endif

                    @foreach (range(1,$eventosPast->lastPage()) as $page)
                        <a href="{{$eventosPast->url($page)}}#SeccionAnteriores">
                            <div class="pagina" style="display: inline-block;"> {{$page}} </div>
                        </a>
                    @endforeach

                    @if($eventosPast->onLastPage()) @else
                        <a href="{{$eventosPast->nextPageurl()}}#SeccionAnteriores">
                            <div class="boton arriba" style="display: inline-block;"> </div>
                        </a>
                    @endif

                    {{-- <select wire:model.live="Cantidad" class="forma-select">
                        <option value='2'>2 eventos</option>
                        <option value='5'>5 eventos</option>
                        <option value='20'>20 eventos</option>
                        <option value='50'>50 eventos</option>
                    </select> --}}
                </div>
            @endif
        </div>
    </section>

</div>
