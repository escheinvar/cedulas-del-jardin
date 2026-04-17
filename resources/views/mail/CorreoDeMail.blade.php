<div style="font-family: 'Roboto Condensed', sans-serif; margin:10px; padding:10px;">

      {!! $Data['mensaje'] !!}


    <div style="font-size:80%;">
        {!! $Data['notas'] !!}
    </div>

    <div style="margin-top:20px; background-color:#CDC6B9; font-size:80%; padding:7px; ">
        Este es un mensaje automático generado por el <a href="{{ url('/') }}">Sistema de Cédulas del Jardín en Lenguas Originarias</a>. <b>No es necesario que lo respondas</b><br>
        Lo recibes ya que estás registrado como autor o como traductor de cédulas de información que
        están siendo publicadas en el Sistema Gestor de Cédulas del Jardín en Lenguas Originarias: <a href="{{ url('/') }}">{{ url('/') }}</a>
        <br>
        Te invitamos a <b>crear tu cuenta</b> en el sistema para poder dar seguimiento
         a la cédula ingresando en "<a href="{{ url('/nuevousr') }}">Crear una cuenta</a>"" en la siguiente liga: <a href="{{ url('/ingreso') }}">{{ url('/ingreso') }}</a>
    </div>
</div>
