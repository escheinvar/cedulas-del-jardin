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
        <ul>
            <li>{{ $j->cjar_nombre }} ({{ $j->cjar_siglas }})
        </ul>
    @endforeach

</div>
