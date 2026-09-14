@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection
<div>
    <h1>Reporte de Visitas</h1>
    <b>14 de septiembre de 2026</b>
    <embed src="/estadisticas_pdf/Rep20260914_14Septiembre26.pdf" width="100%" height="700"
    type="application/pdf"></embed>

    <h3>Previos</h3>
    <ul>
        <li><a href="/estadisticas_pdf/Rep20260914_14Septiembre26.pdf" target="_new" class="nolink">14 de septiembre de 2026</a></li>
    </ul>


    {{-- <div class="row">
        <div class="col-3">
            <label class="form-label">Desde</label>
            <input wire:model.live="desde" type="date" class="form-control">
        </div>
        <div class="col-3">
            <label class="form-label">Hasta</label>
            <input wire:model.live="hasta" type="date" class="form-control">
        </div>
    </div> --}}



    {{-- <table class="table table-striped">
        <thead>
            <tr>
                <th>
                    <div style="display:inline-block; width:300px;"> Página</div>
                    <div style="display:inline-block; width:80px;">  Visitas</div>
                    <div style="display:inline-block; width:80px;">  Ips    </div>
                    <div style="display:inline-block; width:80px;">  1 - vis/IP    </div>
                    <div style="display:inline-block;width:80px; ">  Países </div>
                    <div style="display:inline-block;width:80px; ">  Regiones </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div style="display:inline-block; width:300px;"> Total de visitas </div>
                    <div style="display:inline-block; width:80px;"> {{ $visitas->sum('cant') }} </div>
                    <div style="display:inline-block; width:80px;" class="PaClick" onclick="VerNoVer('ips','Todos')"> {{ $NumIPs= $Ips->count('vis_ip') }}</div>
                    <div style="display:inline-block; width:80px;"> {{ 1 - round($visitas->sum('cant') / $NumIPs,2) }} </div>
                    <div style="display:inline-block; width:80px;" class="PaClick"  onclick="VerNoVer('pais','Todos')"> {{ $Ips->unique('vis_pais')->pluck('vis_pais')->count()}} </div>
                    <div style="display:inline-block; width:80px;" class="PaClick"  onclick="VerNoVer('region','Todos')"> {{  $Ips->unique('vis_regionname')->pluck('vis_regionname')->count()}} </div>
                    <!-- Lista de paises y de Ips-->
                    <div style="display:none;font-size:90%;" id='sale_ipsTodos'> <hr>   <b>Ips:</b>      {{ implode('  ',$Ips->unique('vis_ip')->pluck('vis_ip')->toArray() ) }} </div>
                    <div style="display:none;font-size:90%;" id='sale_paisTodos'> <hr>  <b>Paises:</b>   {{ implode(', ',$Ips->unique('vis_pais')->pluck('vis_pais')->toArray() ) }} </div>
                    <div style="display:none;font-size:90%;" id='sale_regionTodos'> <hr><b>Regiones:</b> {{ implode(',  ',$Ips->unique('region')->pluck('region')->toArray() ) }} </div>
                </td>
            </tr>
            @foreach ($visitas as $v)
                <tr>
                    <td>
                        <!-- Página -->
                        <div style="display:inline-block; width:300px;">
                            {{ $v->vis_flag }}
                        </div>
                        <!-- visitas -->
                        <div style="display:inline-block; width:80px;">
                            {{ $v->cant }}
                        </div>
                        <!--Num. Ips -->
                        <div style="display:inline-block; width:80px;" class="PaClick" onclick="VerNoVer('ips','{{ $v->vis_url2 }}')">
                            {{ $NumIPs= $Ips->where('vis_url2',$v->vis_url2)->count('vis_ip') }}
                        </div>
                        <!-- indice vis/Ips -->
                        <div style="display:inline-block; width:80px;">
                            {{ 1 - round($v->cant / $NumIPs,2) }}
                        </div>
                        <!-- Num. Países -->
                        <div style="display:inline-block; width:80px;" class="PaClick" onclick="VerNoVer('pais','{{ $v->vis_url2 }}')">
                            {{ $NumPaises = $Ips->where('vis_url2',$v->vis_url2)->unique('vis_pais')->pluck('vis_pais')->count()}}
                        </div>
                        <!-- Num. Regiones -->
                        <div style="display:inline-block; width:80px;" class="PaClick" onclick="VerNoVer('region','{{ $v->vis_url2 }}')">
                            {{ $NumPaises = $Ips->where('vis_url2',$v->vis_url2)->unique('vis_regionname')->pluck('vis_regionname')->count()}}
                        </div>

                        <!-- Lista de Ips -->
                        <div style="display:none;font-size:90%;" id='sale_ips{{ $v->vis_url2 }}'>
                            <hr>
                            <b>Ips:</b> {{ implode(' | ', $Ips->where('vis_url2',$v->vis_url2)->unique('vis_ip')->pluck('vis_ip')->toArray() ) }}
                            </div>
                        </div>

                        <!-- Lista de paises -->
                        <div style="display:none;font-size:90%;" id='sale_pais{{ $v->vis_url2 }}'>
                            <hr>
                            <b>Paises:</b> {{ implode(', ', $Ips->where('vis_url2',$v->vis_url2)->unique('vis_pais')->pluck('vis_pais')->toArray() ) }}
                        </div>
                        <!-- Lista de regiones -->
                        <div style="display:none;font-size:90%;" id='sale_region{{ $v->vis_url2 }}'>
                            <hr>
                            <b>Regiones:</b> {{ implode(', ', $Ips->where('vis_url2',$v->vis_url2)->unique('region')->pluck('region')->toArray() ) }}
                        </div>

                    </td>
                </tr>
            @endforeach

        </tbody>
    </table> --}}



</div>
