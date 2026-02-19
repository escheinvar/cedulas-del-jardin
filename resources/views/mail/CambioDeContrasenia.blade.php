<h1>Solicitud de cambio de contraseña</h1>

Hola.<br>
Alguien solicitó el cambio de contraseña en el <a href="{{url('/ingreso')}}" target="new">sistema del Jardín Etnobiológico de Oaxaca</a>.<br>
<br>
Para continuar, haz click en la siguiente liga:<br>

<a href="{{url('/')}}/recuperaContrasenia/{{$Datos['token']}}"> {{url('/')}}/recuperar/{{$Datos['token']}}</a> <br>
<br>
Esta liga vence a los 20 minutos de haber sido solicitada, por lo que tienes hasta el día {{date('d',strtotime($Datos['fin']))}} 
de {{date('F',strtotime($Datos['fin']))}} a las {{date('H:i:s',strtotime($Datos['fin']))}} para realizar el cambio de contraseña<br>
<br>
