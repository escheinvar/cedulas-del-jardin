<h1>Registro de usuario en sistema</h1>

Hola.<br>
Alguien solicitó el registro de esta cuenta de correo en el <a href="{{url('/')}}" target="new">sistema del Jardín Etnobiológico de Oaxaca</a>.<br>
<br>

Para continuar, haz click en la siguiente liga:<br>

<a href="{{url('/')}}/nuevousr01/{{$Datos['token']}}"> {{url('/')}}/recuperar/{{$Datos['token']}}</a> <br>
<br>
Esta liga vence a los 20 minutos de haber sido solicitada, por lo que tienes hasta el día {{date('d',strtotime($Datos['fin']))}}
de {{date('F',strtotime($Datos['fin']))}} a las {{date('H:i:s',strtotime($Datos['fin']))}} para realizar el cambio de contraseña<br>
<br>
