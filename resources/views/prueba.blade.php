<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" http-equiv="Content-Type" content="text/html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- TITULO -->
    <title>@yield('title')</title>

    <!--META DESCRIPCIÓN-->
    <meta name="description" content="@yield('meta-description')">

    <!--FAVICON-->
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!--  LEAFLET -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!--- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- summernote 1-->

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!-- summernote 2-->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

    <!-- HOJA DE ESTILOS  y JS -->
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="/style2.css">
    <script src="{{asset('MyJs.js')}}"></script>

</head>

<body>

    <h1>Prueba</h1>
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10 form-group">
                <div id="summernote" style="height: 500px;">Texto en summernote</div>
            </div>
        </div>
        {{-- <button id="botoncito" class="btn btn-secondary btn-sm"wire:click="cachador()">ver</button> --}}
        {{-- va: {{ $textin }} --}}



</body>

<script>

    $('#summernote').summernote({
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            // ['fontsize', ['fontsize']],
            // ['color', ['color']],
            // ['para', ['ul', 'ol', 'paragraph']],
            ['para', ['ul', 'ol']],
            // ['height', ['height']],
            ['view', ['fullscreen', 'codeview', 'help']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['group', [ 'specialChar' ]],
            ['mybutton', ['LineaArriba','LineaAbajo','LineaDiagonal','CirculoArriba']]
        ],

        // buttons: {
        //     LineaArriba: BotonLineaArriba,
        //     LineaAbajo: BotonLineaAbajo,
        //     LineaDiagonal: BotonLineaDiagonal,
        //     CirculoArriba: BotonCirculoArriba
        // }
    });
</script>
</html>

