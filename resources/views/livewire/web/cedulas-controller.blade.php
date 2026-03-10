@section('MenuPublico') x @endsection
@section('title') {{ $url->url_titulo }} @endsection
@section('meta-description') {{ $url->url_descrip }} @endsection

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
    <div><b>Id url</b>: {{ $url->url_id }}</div>
    <div>Edit: {{ $edit }}, enEdit:{{ $enEdit }}:
           @if ($enEdit=='1' and $edit=='1')  Página no pública, modo edición
        @elseif($enEdit=='1' and $edit=='0')  Página no pública
        @elseif($enEdit=='0' and $edit=='1')  Página pública, acepta edición
        @elseif($enEdit=='0' and $edit=='0')  Página pública.
        @endif
    </div>
    <div><b>Estado</b>: {{ $url->url_edo }}</div>

    <div><b>Jardín</b> {{ $jardin }}</div>
    <div><b>Url</b> {{ $url->url_url }}</div>
    <div><b>Lengua</b>: {{ $url->lenguas->len_lengua }} [{{ $url->lenguas->len_code }}]</div>
    <div><b>Traducciones</b>: {{ $traducciones->count() }}</div>
    <div><b>Autores</b>:   @foreach($url->autores->where('aut_tipo','Autor') as $a) {{ $a->aut_name }} @endforeach</div>
    <div><b>Traductor</b>: @foreach($url->autores->where('aut_tipo','Traductor') as $a) {{ $a->aut_name }} @endforeach</div>
    <div><b>Editor</b>:   @foreach($url->autores->where('aut_tipo','Editor') as $a) {{ $a->aut_name }} @endforeach</div>
</div>
