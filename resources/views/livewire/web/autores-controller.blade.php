@section('MenuPublico') x @endsection
@section('title') {{ $url->caut_nombre}} {{ $url->caut_apelldo1}} @endsection
@section('meta-description') {{ $url->caut_nombre}} {{ $url->caut_apellido1}}, autor de cédulas del jardín @endsection

@section('logo') {{ $url->jardin->cjar_logo }} @endsection
@section('siglas') {{ $url->caut_cjarsiglas }} @endsection
@section('siglasMin'){{ strtolower($url->caut_cjarsiglas) }}@endsection
@section('jardin') {{ $url->jardin->cjar_nombre }} @endsection

@section('red_facebook') {{ $url->jardin->cjar_face }} @endsection
@section('red_instagram') {{ $url->jardin->cjar_insta }} @endsection
@section('red_youtube') {{ $url->jardin->cjar_youtube }}  @endsection
@section('ubicacion') {{ $url->jardin->cjar_ubica }}  @endsection
@section('mail') {{ $url->jardin->cjar_mail }} @endsection
@section('web') {{ $url->jardin->cjar_www }} @endsection



<div>
    @if($edit=='0' and $url->caut_edit=='1')
        <h3 style="text-align: center;">
            ¡ Lo sentimos !<br>
            La página de nuestr@ autor@<br>{{ $url->caut_nombre }} {{ $url->caut_apellido1 }}<br> se encuentra en mantenimiento.<br>
            <br>
            Seguramente en breve, habrán terminado y podrás consultarla nuevamente.
        </h3>
    @else
        <div class="my-4">
            <h2>{{ $url->caut_nombre}} {{ $url->caut_apellido1}} {{ $url->caut_apellido2}}</h2>
            @if($url->caut_institu != '') {{ $url->caut_institu }}<br> @endif
            @if($url->caut_comunidad!='') {{ $url->caut_comunidad }}<br> @endif
            @if($url->caut_mailpublic =='1') <a href="mailto:{{ $url->caut_correo }}" class="nolink">{{ $url->caut_correo }}</a> <br> @endif
            Persona autora de cédulas del {{ $url->jardin->cjar_nombre }}<br>
            </p>
        </div>


        <div class="row">
            @if($url->caut_img != '')
                <div class="@if($url->caut_img == '') col-12 @else col-5 col-md-3 @endif">
                    <img src='{{ $url->caut_img }}' style="max-width:100%;max-height:300px;">
                </div>
            @endif
            <div class="@if($url->caut_img == '') col-12 @else col-7 col-md-9 @endif">
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Illo natus rerum accusamus eius ea molestias facere velit beatae tenetur quis dicta, repudiandae quasi quos totam recusandae porro minus harum vero.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorum nemo quia, consequatur in veritatis totam et ipsum sapiente voluptatibus? Ab autem suscipit quod hic earum minus recusandae excepturi aliquid explicabo!</p>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptates obcaecati placeat iste explicabo laboriosam suscipit nesciunt! Officia, excepturi itaque provident, ab dolorem voluptatum cumque praesentium modi architecto expedita fugit laborum.</p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam ut facere laudantium temporibus tempore earum id eius blanditiis, possimus esse vero at provident. Tempore optio nemo et, ducimus quia omnis?</p>
            </div>
        </div>
        <div class="row">
            <h3>Cédulas</h3>
            <ul>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
    @endif
</div>
