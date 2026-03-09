{{-- @section('banner') banner-3lineas @endsection <!-- banner-1linea banner-2lineas banner-3lineas --> --}}
@section('MenuPublico') x @endsection
@section('title') {{ $url->url_titulo }} @endsection
@section('meta-description') {{ $url->url_descrip }} @endsection
{{-- @section('banner-img'){{ $url->url_bannerimg }}@endsection
@section('banner-title'){{ $url->url_bannertitle }}  @endsection --}}

@section('logo') {{ $url->jardin->cjar_logo }} @endsection
@section('siglas') {{ $url->urlj_cjarsiglas }} @endsection
@section('siglasMin'){{ strtolower($url->url_cjarsiglas) }}@endsection
@section('jardin') {{ $url->jardin->cjar_nombre }} @endsection

@section('red_facebook') {{ $url->jardin->cjar_face }} @endsection
@section('red_instagram') {{ $url->jardin->cjar_insta }} @endsection
@section('red_youtube') {{ $url->jardin->cjar_youtube }}  @endsection
@section('ubicacion') {{ $url->jardin->cjar_ubica }}  @endsection
@section('mail') {{ $url->jardin->cjar_mail }} @endsection
@section('web') {{ $url->jardin->cjar_www }} @endsection



<div>

    <h1>Cédula de {{ $url->url_url }}</h1>
    <div>Edit: {{ $edit }}, enEdit:{{ $enEdit }}:
           @if ($enEdit=='1' and $edit=='1')  Página no pública, modo edición
        @elseif($enEdit=='1' and $edit=='0')  Página no pública
        @elseif($enEdit=='0' and $edit=='1')  Página pública, acepta edición
        @elseif($enEdit=='0' and $edit=='0')  Página pública.
        @endif
    </div>
    <div>Estado: {{ $url->url_edo }}</div>

    <div>Jardín: {{ $jardin }}</div>
    <div>Url: {{ $url->url_url }}</div>
    <div>Lengua: {{ $url->lenguas->len_lengua }} [{{ $url->lenguas->len_code }}]</div>
    <div>Traducciones: {{ $traducciones->count() }}</div>
</div>
