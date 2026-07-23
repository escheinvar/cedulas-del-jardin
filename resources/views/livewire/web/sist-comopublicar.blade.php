@section('title')Cómo publicar @endsection
@section('meta-description') Proceso para la publicación de materiales en Las Cédulas del Jardín @endsection
@section('banner') banner-1linea @endsection
@section('banner-title')Cómo publicar @endsection
@section('banner-img') imagen5 @endsection <!-- imagen1 a imagen10 -->
@section('MenuPublico') x @endsection
@section('MenuPrivado')  @endsection
<div class="formato-grande">

    <h1>Pasos para publicar</h1>

    <div class="Manual">
        <div class="cabezaManual" onclick="VerNoVerIcon('ver','Normas','bi bi-arrow-bar-up','bi bi-arrow-bar-down','block')">
            1.- Revisar norma editorial
            <i id="saleicon_verNormas" class="bi bi-arrow-bar-down" ></i>
        </div>
        <div class="cuerpoManual" id="sale_verNormas">
            Revisa la <a href="/normaeditorial" target="_blank">norma editorial</a> para confirmar que lo que deseas publicar cumpla con los criterios de publicación.<br>
            Revisa que los textos, imágenes y demás elementos cumplan con los criterios de publicación ahí establecidos.
        </div>
    </div>

    <div class="Manual">
        <div class="cabezaManual"  onclick="VerNoVerIcon('ver','Crear','bi bi-arrow-bar-up','bi bi-arrow-bar-down','block')">
            2.- Genera una cuenta en Las Cédulas del Jardín.
            <i id="saleicon_verCrear" class="bi bi-arrow-bar-down"></i>
        </div>
        <div class="cuerpoManual" id="sale_verCrear">
            <ol type="1" >
                <li>Ingresa a <a href="https://cedulasdeljardin.mx" target="_blank">https://cedulasdeljardin.mx</a> y en el
                    menú superior ve a la opción <b>Ingresar</b> </li>
                <li>Da clic en donde dice <b>Crear una cuenta</b></li>
                <li>Escribe la dirección de tu correo electrónico y pica en <b>Registrar</b></li>
                <li>Tienes un máximo de 15 minutos para ingresar a tu correo electrónico y buscar el correo que te envió el sistema (no olvides revisar la carpeta de Spam).
                    En el cuerpo del mensaje, pica donde dice <b>"Para continuar, haz click en la siguiente liga: https://cedulasdeljardin.mx/recuperar/Mxjfj..."</b>
                    (o copia y pega toda la dirección en un navegador). Serás redireccionado a la  página de registro del sistema. <br>
                    Si tardas más de 15 minutos, la página de registro caducará y deberás reiniciar el proceso de generación de cuenta.

                <li>Ingresa los datos solicitados: nombre, apellidos, nombre de usuario, fecha de nacimiento, y contraseña.</li>
                <li>Pica en <b>crear cuenta</b></li>
                <li>Espera y deberás ver el texto "La cuenta fue creada correctamente"</li>
            </ol>
        </div>
    </div>

    <div class="Manual">
        <div class="cabezaManual" onclick="VerNoVerIcon('ver','Ingresar','bi bi-arrow-bar-up','bi bi-arrow-bar-down','block')">
            3.- Ingresa al portal.
            <i id="saleicon_verIngresar" class="bi bi-arrow-bar-down" ></i>
        </div>
        <div  class="cuerpoManual" id="sale_verIngresar">
            <ol type="1">
                <li>Ve a la dirección <a href="https://cedulasdeljardin.mx" target="_blank">https://cedulasdeljardin.mx</a> </li>
                <li>En el menú superior a la derecha, pica en <b>"Ingresar"</b></li>
                <li>Ingresa tu correo electónico y tu constraseña (los que indicaste al crear tu cuenta)</li>
                <li>Si ingresaste tus datos correctamente, serás redireccionado a la página inicial del sistema (o home)</li>
            </ol>
        </div>
    </div>

    <div class="Manual">
        <div class="cabezaManual"  onclick="VerNoVerIcon('ver','Rol','bi bi-arrow-bar-up','bi bi-arrow-bar-down','block')">
            4.- Solicita el rol de autor
            <i id="saleicon_verRol" class="bi bi-arrow-bar-down" ></i>
        </div>
        <div  class="cuerpoManual" id="sale_verRol">
            <ol type="1">
                <li>Luego de ingresar al portal, desde la página inicial (o home), busca y pica el botón <b>Solicitar rol</b>.</li>
                <li>En el campo <b>Jardín virtual</b>, selecciona el jardín en el que deseas publicar.</li>
                <li>En el campo <b>Rol solicitado</b>, selecciona <b>autor</b>.</li>
                <li>En el campo <b>Explica la razón de la solicitud</b>, escribe un breve texto para con las
                    razones por las que solicitas el jardín y el rol.</li>
                <li>Pica Guardar y espera a que el administrador del jardín solicitado responda a tu petición.</li>
                <li>En lo que esperas la respuesta, puedes continuar con el paso siguiente.</li>
            </ol>
        </div>
    </div>

    <div class="Manual">
        <div class="cabezaManual"  onclick="VerNoVerIcon('ver','Formatos','bi bi-arrow-bar-up','bi bi-arrow-bar-down','block')">
            5.- Descarga y llena el formato de envío y la solicitud de publicación
            <i id="saleicon_verFormatos" class="bi bi-arrow-bar-down" ></i>
        </div>
        <div  class="cuerpoManual" id="sale_verFormatos">
            <b><u>Formato de envío</u></b>
            <ol type="1">
                <li>Luego de ingresar al portal, desde la págnia inicial (o home), el autor de correspondencia deberá
                    busca y descarga el formato de envío (o descargarlo desde <a href="" target="_new">aquí</a>)</li>
                <li>
                    El formato solicita los siguientes datos:
                    <ol type="a">
                        <li><b>Nombre del Jardín virutal</b></li>
                        <li><b>Título del trabajo</b></li>
                        <li><b>Datos de autores</b>. Nombres, apellidos, comunidad de origen o institución y correo electrónico de cada uno de los autores.
                            También deberás indicar si el autor autoriza o no la publicación de su correo, así como
                            a quién fungirá como autor de correspondencia (persona responsable que aparece junto con su correo
                            electrónico en la publicación y que será el punto de contacto ante los lectores y los editores).
                            En caso de así considerarlo, también se podrá indicar los números identificadores de autor
                            como orcid, scopus, isni y google académico</li>
                        <li><b>Datos de la lengua</b>.  Nombre oficial de la o las lenguas en la que están los materiales
                            a publicar (este nombre oficial deberá estar registrado en <a href="https://www.ethnologue.com/" target="_new">https://www.ethnologue.com/</a>),
                            autonimia de la lengua (nombre con el que denominan a su lengua los propios hablantes) y estado, municipio y nombre
                            de la comunidad desde la que se generan los material en lengua.</li>
                        <li><b>Autorización de traducción</b>. Declaración de autorización o no, de traducción de materiales a otras lenguas.</li>
                        <li><b>Comunidades</b>. Datos de las comunidades que se deben reconocer en la publicación. Estado, municipio, localidad,
                            paraje o explicación de ubicación.</li>
                        <li>Palabras clave. Deberá asignar cuando menos tres palabras clave relacionadas a los materiales y que servirán para
                            que los visitantes encuentren los materiales y para vincular con materiales similares de otros jardines y otros autores.</li>
                        <li><b>Especies</b>. Deberá nombrar todas las especies que se describen en el trabajo, indicando el nombre común y el nombre
                            científico (para el caso de nombres científicos de plantas, éstos deberán ser nombres válidos registrados en el
                            portal <a href="https://powo.science.kew.org/" target="_new">Plants of the world online </a>) </li>
                        <li><b>Archivos enviados</b>. Deberá incluir el listado de todos los archivos que forman parte de la publicación,
                            indicando para cada uno: nombre del archivo, título del material, nombres y apellidos de los autores del material,
                            pie de fugura (breve explicación del contenido del material), ubicación geográfica a la que refiere el material,
                            fecha en la que se generó el material y palabras clave del material.</li>
                    </ol>
                </li>
            </ol>

            <b><u>Carta de solicitud</u></b>
            <ol type="1">
                <li>Luego de ingresar al portal, desde la página inicial (o home), el autor de correspondencia deberá
                    buscar y descargar la carta de solicitud (o descargarla desde <a href="" tartet="_new">aquí</a>).</li>
                <li>El autor de correspondencia será el encargado de que todos los autores lean y firmen la carta de solicitud</li>
                <li>Ya firmada, la carga deberá ser escaneada (en formato de imagen o de pdf) para luego ser incorporada en el sistema.</li>
                <li>Es importante mencionar que la carta deberá traer la firma autógrafa de todos los autores de los materiales
                    para poder proceder a la publicación.</li>
            </ol>
        </div>
    </div>


    <div class="Manual">
        <div class="cabezaManual"  onclick="VerNoVerIcon('ver','Someter','bi bi-arrow-bar-up','bi bi-arrow-bar-down','block')">
            6.- Iniciar con las revisiones
            <i id="saleicon_verSometer" class="bi bi-arrow-bar-down" ></i>
        </div>
        <div  class="cuerpoManual" id="sale_verSometer">
            <ol type="1">
                <li>Luego de ingresar al portal, desde la págnia inicial (o home), el autor de correspondencia deberá
                    picar el botón <b>Iniciar Publicación</b></li>
                <li>Deberá ingresar un título con el que identificará el proyecto y el Jardín Virtual en el que desea que
                    se publique. El título del proyecto puede ser distinto al título de la publicación y no debe existir
                    otro título igual en el sistema. Luego, debe picar el botón <b>Crear proyecto</b></li>
                <li>El autor de correspondencia deberá cargar el <b>formato de envío</b>, la <b>carta de solicitud de publicación</b>,
                    el <b>archivo principal</b> (el que constituye la publicación en sí) y todos los <b>Archivos adicionales</b> (fotos
                    imágenes, audios, archivos y videos). También deberá escribir un breve texto explicativo en la sección <b>Comentarios</b>
                    que será leído por el administrador. Para enviar toda la documentación, deberá picar el botón <b>Enviar a administrador</b></li>
                <li>El administrador realizará una revisión técnica del cumplimiento de las normas editoriales.
                    Cuando el administrador haya concluido su revisión, podrá solicitar alguna modificación, rechazar o asignar editor responsable.<br>
                    En caso de tener algún requirimiento, serás avisado mediante un mensaje en el buzón del sistema, el cual -salvo que lo hayas desactivado-,
                    se reenvía de manera predeterminada al correo electrónico que registraste en la plataforma.</li>
                <li>Luego del administrador, el editor realizará la revisión del contenido y podrá solicitar el apoyo en la revisión del documento
                    de personas externas.</li>
                <li>Durante cada fase del proceso, el autor de correspondencia será avisado mediante mensaje en su buzón dentro del sistema
                    (en menú superiro, ver opción usuario -> <a href="{{ url('/buzon') }}">Mi buzón</a>).</li>

            </ol>
        </div>
    </div>


    <div class="Manual">
        <div class="cabezaManual"  onclick="VerNoVerIcon('ver','Publicacion','bi bi-arrow-bar-up','bi bi-arrow-bar-down','block')">
            7.- Inicia el proceso de publicación
        <i id="saleicon_verPublicacion" class="bi bi-arrow-bar-down" ></i>
        </div>
        <div  class="cuerpoManual" id="sale_verPublicacion">
            <li>Todo el proceso de pubicación se realizará en la sección
                <b>administración de cédulas</b> (menú superior, opción Cédulas-> <a href="{{ url('/admin_cedulas') }}">Administrar</a>)</li>
            <li>Cuando el editor y el autor de correspondencia hayan concluido con la revisión de los materiales, el editor encargado
                iniciará el proceso de publicación, para lo cual cargará los datos de los autores, los metadatos y los materiales adicionales.</li>
            <li>Cuando el editor concluya la carga de los materiales, todos los autores que posean cuenta de usuario, podrán acceder a revisar y
                en su caso editar los materiales.</li>
            <li>Cuando los materiales a publicar hayan sido revisados y aprobados por el editor y por los autores, el administrador procederá a
                la liberación al público de los materiales</li>

        </div>

    </div>

</div>
