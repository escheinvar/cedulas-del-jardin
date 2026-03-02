@section('title')Las especies @endsection
@section('meta-description')Las especies del jardín: Información sobre las especies del Jardín Etnobiológico de Oaxaca @endsection
@section('banner') banner-colaboradores @endsection
@section('banner-title')Las especies<br>del Jardín @endsection
@section('banner-img') imagen5 @endsection <!-- imagen1 a imagen10 -->
@section('MenuPublico') x @endsection
@section('MenuPrivado')  @endsection
<div>
    <section class="colaboradores pt-4">
        <div class="container px-4 py-5 " id="bienvenido">
            <div class="row subtitulo justify-content-end px-4">
                <div class="col-sm-12 col-md-9 col-lg-8 col-xl-6">
                    <h2 class="subtitulo">Las especies del Jardín</h2>
                </div>
            </div>

            <div class="row subtitulo justify-content-end px-4 pb-5">
                <div class="col-sm-12 col-md-9 col-lg-8 col-xl-6">
                    <ul>
                        @foreach ($cedulas as $i)
                            <li>
                                <a href="/sp/{{ $i->url_url }}/JebOax">
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
