@section('title') Admin Imágenes @endsection
@section('meta-description') Módulo administrador de imágenes @endsection
@section('cintillo-ubica') &nbsp; @endsection
@section('cintillo') &nbsp; @endsection
@section('MenuPublico')  @endsection
@section('MenuPrivado') x @endsection

<div>
    <h2>Resumen de Cedulas</h2>
    <div class="row">
        <div class="col-12 col-md-3">
            Total de cédulas: {{ $orig->count()+$trad->count() }}
        </div>
        <div class="col-12 col-md-3">
            Cédulas originales: {{ $orig->count() }}
        </div>
        <div class="col-12 col-md-3">
            Cédulas traducidas: {{ $trad->count() }}
        </div>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th></th>
                <th>Cédula</th>
                @foreach($len as $l)
                    <th style="text-align: center;">
                        {{ $l->len_code }}<br>
                        {{ $orig->where('url_lencode',$l->len_code)->count()+$trad->where('url_lencode',$l->len_code)->count() }}
                    </th>
                @endforeach
                <th>Total<br> &nbsp;</th>
            </tr>
        </thead>
        <tbody>
            @php $num=1; $jar=null; @endphp
            @foreach( $orig as $o)
                <tr>
                    <td style="font-size: 80%;font-weight: bold;">
                        @if($num=='1' OR $jar == $o->url_cjarsiglas)
                            {{ $num++ }}
                        @else
                            @php $num=1; @endphp
                            {{ $num++ }}
                        @endif
                    </td>
                    <td>
                        <span style="color:gray; font-size: 80%;">
                            {{ $o->url_cjarsiglas }}
                        </span>

                        {{ $o->url_url }}
                        <span style="color:gray; font-size: 80%;">
                            {{ $o->url_lencode }}
                            <span class="cedEdoIcon{{ $o->url_edo }}"><sub>{{ $o->url_edo }}</sub></span>
                        </span>
                    </td>

                    @foreach($len as $l2)
                        <td>
                            {{-- {{ $l2->len_code }} --}}
                            @if($trad->where('url_key',$o->url_key)
                                ->where('url_lencode',$l2->len_code)
                                ->count() == '1')
                                <?php
                                    $Estado= $trad->where('url_key',$o->url_key)
                                    ->where('url_lencode',$l2->len_code)
                                    ->value('url_edo');
                                ?>
                                <span class="cedEdo{{ $Estado }}">
                                    <i class="bi bi-{{ $Estado }}-circle-fill"></i>

                                    <br>
                                    <span style="font-size: 60%;">
                                    {{ $trad->where('url_key',$o->url_key)
                                        ->where('url_lencode',$l2->len_code)
                                        ->value('url_lencode') }}
                                </span>
                            @endif
                        </td>
                    @endforeach
                    <td style="text-align: center;">
                        <b>
                            {{ $orig->where('url_key',$o->url_key)->count() + $trad->where('url_key',$o->url_key)->count() }}
                        </b>
                    </td>
                    @php $jar=$o->url_cjarsiglas; @endphp
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
