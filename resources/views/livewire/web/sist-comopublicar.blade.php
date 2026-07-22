@section('title')Cómo publicar @endsection
@section('meta-description') Proceso para la publicación de materiales en Las Cédulas del Jardín @endsection
@section('banner') banner-1linea @endsection
@section('banner-title')Cómo publicar @endsection
@section('banner-img') imagen5 @endsection <!-- imagen1 a imagen10 -->
@section('MenuPublico') x @endsection
@section('MenuPrivado')  @endsection
<div class="formato-grande">

    <h1>Cómo publicar</h1>



    <ol>
        <li>Lee las <a href="/normaeditorial" target="_blank">Normas editoriales</a> para ver si lo que deseas publicar cumple con los criterios de publicación.
            Revisa que los textos, imágenes y demás elementos cumplan con los criterios de publicación ahí establecidos.
        </li>

        <li>
            Genera una cuenta en Las Cédulas del Jardín.
            <i id="saleicon_verCrear" class="bi bi-eye-slash PaClick" onclick="VerNoVerIcon('ver','Crear','','','block')"></i>
            <ol type="a" style="display:none;" id="sale_verCrear">
                <li>Ingresa a <a href="https://cedulasdeljardin.mx/ingreso" target="_blank">https://cedulasdeljardin.mx/ingreso</a> </li>
                <li>Da clic en donde dice <b>"Crear una cuenta"</b></li>
                <li>Escribe la dirección de tu correo electrónico y pica en <button class="btn btn-primary">Registrar</button></li>
                <li>Ingresa a tu cuenta de correo electrónico y busca el correo que te envió el sistema. Pica
                    donde dice <b>"Para continuar, haz click en la siguiente liga: https://cedulasdeljardin.mx/recuperar/Mxjfj..."</b> y serás
                    redireccionado a la  página de registro</li>
                <li>Ingresa los datos solicitados: nombre, apellidos, nombre de usuario, fecha de nacimiento, y contraseña.</li>
                <li>Pica en <button class="btn btn-primary">crear cuenta</button></li>
                <li>Espera y deberás ver el texto "La cuenta fue creada correctamente"</li>
            </ol>
        </li>
        <li>Ingresa al sistema.
            <i id="saleicon_verIngresar" class="bi bi-eye-slash PaClick" onclick="VerNoVerIcon('ver','Ingresar','','','block')"></i>
            <ol type="a" style="display:none;" id="sale_verIngresar">
                <li>Ve a la dirección <a href="https://cedulasdeljardin.mx" target="_blank">https://cedulasdeljardin.mx</a> </li>
                <li>En el menú superior a la derecha, pica en <b>"Ingresar"</b></li>
                <li>Ingresa tu correo electónico y tu coonstraseña (los que indicaste al crear tu cuenta)</li>
                <li>Si ingresaste tus datos correctamente, serás redireccionado a la página inicial del sistema (home)</li>
            </ol>
        </li>
        <li>Solicita el rol de autor</li>



</div>
