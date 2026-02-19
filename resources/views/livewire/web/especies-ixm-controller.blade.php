<div>
    @section('title')
    Las especies
    @endsection

    @section('meta-description')
    Las especies de los IxM del jardín: Información sobre las especies de los Investigadores por México en el Jardín Etnobiológico de Oaxaca
    @endsection

    @section('banner')
    banner-colaboradores
    @endsection

    @section('banner-title')
    Las cédulas<br> de los IxMx del Jardín
    @endsection


    <div>
        <!--S1 Las plantas del Jardín-->
        <section class="colaboradores pt-4">
            <div class="container px-4 py-5 " id="bienvenido">
                <div>
                    @include('plantillas/plant_locale')
                </div>

                <div class="row subtitulo justify-content-end px-4">
                    <div class="col-sm-12 col-md-9 col-lg-8 col-xl-6">
                        <h2 class="subtitulo">Las cédulas de los Investigadores por México del Jardín</h2>
                    </div>
                </div>

                <div class="row subtitulo justify-content-end px-4 pb-5">
                    <div class="col-sm-12 col-md-9 col-lg-8 col-xl-6">
                        <ul>
                            @foreach ($cedulas as $i)
                                <li>
                                    <a href="/sp/{{ $i->url_url }}/IxMxJebOax">
                                        {{ $i->url_nombre }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>

</div>
