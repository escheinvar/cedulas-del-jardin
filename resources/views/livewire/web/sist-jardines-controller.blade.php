    @section('title')Los jardines del SiCedJar @endsection
    @section('meta-description')Informaión de los jardínes, instituciones y organizaciones partícipes del sistema @endsection
    @section('banner') banner-2lineas @endsection
    @section('banner-title') Los jardines @endsection
    @section('banner-img') imagen5 @endsection <!-- imagen1 a imagen10 -->
    @section('MenuPublico') x @endsection
    @section('MenuPrivado')  @endsection
    <div>

        <h2>Los jardines</h2>
        @foreach ($jardines as $j)
            <div class="row my-3" style="list-style-type:none;">
                <div class="col-3">
                    <a href="/jardin/{{ $j->cjar_siglas }}" target="jardin" class="nolink">
                        <img src="{{ $j->cjar_logo }}" style="width:80px;">
                    </a>
                </div>
                <div class="col-8">
                    <a href="/jardin/{{ $j->cjar_siglas }}" target="jardin" class="nolink"></a>
                        {{ $j->cjar_nombre }} ({{ $j->cjar_siglas }})
                    </a>
                    <div class="m-2">
                        <!-- cedulas -->
                        <div style="display:inline;" class="mx-2">
                            @if($j->cedulas->count() > '0')
                                <a href="/jardin/{{ $j->cjar_siglas }}/cedulas/" class="nolink">
                                    <i class="">Cedulas</i>
                                </a>
                            @endif
                        </div>

                        <!-- Lista -->
                        <div style="display:inline;" class="mx-2" >
                            @if($j->lista->count() > '0')
                                <a href="/jardin/{{ $j->cjar_siglas }}/listado/" class="nolink">
                                    <i class="">Listado</i>
                                </a>
                            @endif
                        </div>


                        <!-- autores -->
                        <div style="display:inline;" class="mx-2" >
                            @if($j->autores->count() > '0')
                                <a href="/jardin/{{ $j->cjar_siglas }}/autores/" class="nolink">
                                    <i class="">Autores</i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
