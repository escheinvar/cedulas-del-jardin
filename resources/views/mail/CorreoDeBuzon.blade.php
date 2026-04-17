<div style="font-family: 'Roboto Condensed', sans-serif; margin:10px; padding:10px;">
    <h2> Hola {{ $Data['para']['usrname'] }}</h2>

    Te llegó un mensaje a tu buzón dentro del <a href="{{ url('/home') }}" style="text-decoration:none; color:inherit"><b>Sistema de Cédulas del Jardín</b></a>:
    <br>

    <div style="margin-top:20px;">
        <b>De:</b> {{ $Data['de']['usrname'] }} <br>
        <b>Asunto:</b> {{ $Data['datos']['buz_asunto'] }}<br>
        <b>Fecha:</b> {{ $Data['datos']['buz_date'] }}<br>
        <br>
        <div>
            {!! $Data['datos']['buz_mensaje']  !!}
        </div>
        <div style="font-size:80%;">
            {!! $Data['datos']['buz_notas'] !!}
        </div>
    </div>

    <div style="margin-top:20px; background-color:#CDC6B9; font-size:80%; padding:7px; ">
        Este es un mensaje generado automáticamente por la computadora. <b>No es necesario que lo respondas</b><br>
        Para cualquier asunto, dirígete al Sistema de Cédulas del Jardín en Lenguas Originarias: <a href="{{ url('/') }}">
        {{ url('/') }}</a><br>
        Para dejar de recibir estos mensajes en tu correo electrónico, ingresa a la <a href="{{ url('/homeConfig') }}">configuración del usuario</a> (menú: "Usuario" -> "Mis datos")<br>
        en el sistema y desmarca la casilla que dice "Reenviar mensajes del buzón a mi correo electrónico".
    </div>
</div>
