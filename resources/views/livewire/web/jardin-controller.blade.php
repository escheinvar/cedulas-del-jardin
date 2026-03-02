@section('banner') banner-3lineas @endsection <!-- banner-1linea banner-2lineas banner-3lineas -->
@section('MenuPublico') x @endsection
@section('title') {{ $url->urlj_titulo }} @endsection
@section('meta-description') {{ $url->urlj_descrip }} @endsection
@section('banner-img'){{ $url->urlj_bannerimg }}@endsection
@section('banner-title'){{ $url->urlj_bannertitle }}  @endsection

@section('logo') {{ $url->jardin->cjar_logo }} @endsection
@section('siglas') {{ $url->urlj_cjarsiglas }} @endsection
@section('siglasMin'){{ strtolower($url->urlj_cjarsiglas) }}@endsection
@section('jardin') {{ $url->jardin->cjar_nombre }} @endsection


<div>
    <!-- pone título -->
    @if($url->urlj_url=='inicio')
        <h1>
            {{ $url->jardin->cjar_nombre }}
            @if($edit=='1') <error><i class="bi bi-record-circle" style="font-size:150%;"></i></error> @endif
        </h1>
    @endif
    <!-- --------------------- TEXTO PRINCIPAL ----------------------------------- -->
    @foreach ($txt as $l)
        <div class="my-2">
            <!-- muestra opción de edición -->
            @if($edit=='1')
                <i wire:click="AbreModalEditaTextoWebJardin('{{ $l->jar_id }}','{{ $l->jar_orden }}')" class="bi bi-pencil-square agregar" style="display:inline;"><sup>{{ $l->jar_orden }}</sup><sub>Id {{ $l->jar_id }}</sub></i>
            @endif
            <!-- muestra código html -->
            {!! $l->jar_txt !!}
        </div>

    @endforeach

    <livewire:sistema.jardin-web-modal-component>

    <script>
        document.addEventListener('livewire:init', function () {
            $('#summernote').summernote({
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['para', ['ul', 'ol']],
                    ['height', ['height']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['group', [ 'specialChar' ]],
                    ['mybutton', ['LineaArriba','LineaAbajo','LineaDiagonal','CirculoArriba']]
                ],
            });
        });
    </script>
</div>
