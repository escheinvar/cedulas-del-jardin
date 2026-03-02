@section('title')Cédulas del Jardín en lenguas originarias @endsection
@section('meta-description') Sistema para la gestión de cédulas informativas en lenguas originarias generadas por jardines o instituciones asociadas @endsection
@section('banner') banner-2lineas @endsection
@section('banner-title') Las Cédulas del Jardín<br>en lenguas originarias @endsection
@section('banner-img') imagen5 @endsection <!-- imagen1 a imagen10 -->
@section('MenuPublico') x @endsection
@section('MenuPrivado')  @endsection
<div>

    <h1>Las cédulas del Jardín (<i>V. beta 1.0</i>)</h1>

    <div class="row justify-content-around py-5">
        <div class="col-sm-auto col-md-4 text-end px-4 mb-4">
            <center>

                <img  src="http://localhost:8000/imagenes/logo-nav.png">
            </center>
        </div>

        <div class="col-sm-auto col-md-8 px-4 mb-4" style="text-align: justify;">
            <p>Los Jardines Etnobiológicos tienen como objetivo la visibilización, resguardo, recuperación, intercambio y difusión del
                conocimiento etnobiológico y de la riqueza biocultural del país, incluyendo sus lenguas originarias.  De ahí que se
                requiere de la difusión de información en español y en lenguas sobre sus ejemplares. </p>

            <p> La colocación de cédulas informativas en los jardines es compleja, debido a que se realiza en espacios al aire libre
                y al recambio constante de ejemplares que eleva los costos de impresión.</p>

            <p>"Las cédulas del jardín" es una herramienta de código abierto diseñada para facilitar elaboración, traducción y
            publicación en línea de cédulas informativas en lenguas originarias.</p>
        </div>
        <div class="col-sm-auto col-md-12 px-4 mb-4" style="text-align: justify;">
            <p>Su objetivo principal es apoyar a los Jardines Etnobiológicos, públicos o comunitarios en la
                documentación, difusión  y preservación de los saberes locales en lenguas originarias mediante una
                plataforma accesible, colaborativa y fácil de usar.</p>

            <p>Fue desarrollada por los Investigadores por México del
                <a href="https://secihti.mx/" target="new">Secihti</a> en el
                <a href="https://jardinoaxaca.mx">Jardín Etnobiológico de Oaxaca</a> bajo
                los principios de software libre, respeto a la diversidad cultural y lingüística y reconocimiento
                de los saberes ancestrales de los pueblos originarios.</p>
        </div>
    </div>

    <div class="row justify-content-around py-5">
        <div class="col-sm-auto col-md-12 px-4 mb-4" style="text-align:justify;">
            <h3>Características principales</h3>
            <ul>
            <li>Permite la creación, edición, publicación y compartición en línea de cédulas informativas elaboradas por
                los Jardines Etnobiológicos o por los jardines comunitarios o públicos asociados a ellos.</li>

            <li>Genera una dirección URL única para cada una de las cédulas de cada jardín a las cuales el público puede
                acceder desde un código QR (generado por el sistema), desde el buscador de temas del sistema o
                ingresando directamente la url a un navegador web.</li>

            <li> Permite generar múltiples traducciones de cada una de las cédulas que se ofrecen al usuario
                desde un menú simple para que seleccione la lengua en la que desea leer</li>


            <li>Incluye funcionalidades para agregar audio, imágenes y ejemplos de uso en contexto,
                incluyendo la opción de incorporar audios con la lectura en lengua originaria
                de cada uno de los párrafos, lo cual resulta útil en el caso de lenguas sin
                escritura.</li>

            <li>Incluye un módulo mediante el cual cualquier visitante registrado en la plataforma,
                puede enviar sus aportaciones al conocimiento sobre alguna cédula (el material debe pasar
                un proceso de aprobación por los administradores del Jardín previo a su publicación)</li>

            <li>Cuenta con un robusto sistema de seguridad que permite generar cuentas asociadas a un correo electrónico
                y asignarles roles específicos, por ejemplo, creador de contenido de un jardín ó traductor de una lengua en específico
                para un jardín, promoviendo la colaboración comunitaria, al permitir que hablantes nativos, lingüistas y educadores
                contribuyan a la creación, edición o traducción de contenido desde sus comunidades mediante el
                acceso a la plataforma por internet.</li>

            <li>Permite registrar uno o más jardines en un mismo sistema, manteniendo la independencia en la asignación de roles y
                administración de contenidos, pero ahorrando recursos de infraestructura</li>

            <li> Con el objeto de homologar la información, incorpora catálogos especializados, como algunos de
                ubicación del <a href="https://www.inegi.org.mx/" target="new">INEGI</a>, de
                <a href="https://www.ethnologue.com/" target="new">lenguas del ethnologue</a> o de especies botánicas
                <a href="https://powo.science.kew.org/" target="new"> Plants of the World</a> de Kew</li>
        </div>
    </div>


    <div class="row justify-content-around py-5">
        <div class="col-sm-auto col-md-9 px-4 mb-4" style="text-align:justify;">
            <h3>Licencia de uso:</h3>
            <p>Este software se distribuye bajo la <a href="https://www.gnu.org/licenses/gpl.html" target="new">Licencia Pública General de GNU (GPL)</a> versión 3, lo que significa que es software libre:
                puedes usarlo, copiarlo, modificarlo y redistribuirlo bajo los términos de la licencia. El código fuente está disponible públicamente para
                fomentar la transparencia, la auditoría técnica y el desarrollo colaborativo.</p>
            <p>El contenido de las cédulas se distribuye bajo la <a href="https://www.gnu.org/licenses/fdl-1.3.html" target="new">Licencia de Documentación Libre de GNU</a> Versión 1.3, por lo que se concede permiso
                para copiar, distribuir y/o modificar los documentos</p>

        </div>
        <div class="col-sm-auto col-md-3 px-4 mb-4" style="text-align:justify;">
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/45/Heckert_GNU.png" style="width:80%;">

        </div>
    </div>

    <div class="row justify-content-around py-5">
        <div class="col-sm-auto col-md-12 px-4 mb-4" style="text-align:justify;">
        <h3>Desarrollo y contribución:</h3>
        <p>El sistema fua desarrollado como un producto derivado del proyecto de investigación del Investigador por México de la Secihti en el Jardín Etnobiológico de Oaxaca,
            Dr. Enrique Scheinvar, sin embargo, una vez liberado, se considera un proyecto que pueda ser ampliado, adoptado y mejorado de manera colaborativa
            por la comunidad de programadores, lingüistas, activistas culturales y hablantes de lenguas originarias. Invitamos a personas interesadas a
            contribuir al proyecto mediante mejoras técnicas, traducciones, documentación o aportes lingüísticos.
            El repositorio del código y las instrucciones para colaborar están disponibles en el siguiente
            enlace: <a href="https://github.com/escheinvar/cedulasdeljardin" target="new">https://github.com/escheinvar/cedulasdeljardin</a></p>
        <p>Lenguaje Laravel 11.0, Livewire 3.5, php 8.4. Servidor Ubuntu Linux 16.9, Nginx, base de datos PostgreSQL v. 16.9.</p>

        </div>
    </div>

    <div class="row justify-content-around py-5">
        <div class="col-sm-auto col-md-12 px-4 mb-4" style="text-align:justify;">
            <h3>Reconocimiento a comunidades</h3>
            <p>Este sistema reconoce y respeta los derechos de las comunidades indígenas sobre sus conocimientos tradicionales y su patrimonio lingüístico.
                Su uso debe realizarse siempre en coordinación con las comunidades hablantes, garantizando su participación, consentimiento previo e información
                adecuada en la recopilación y difusión de sus lenguas.</p>
        </div>
    </div>

    <div class="row justify-content-around py-5">
        <div class="col-sm-auto col-md-12 px-4 mb-4" style="text-align:justify;">
            <h3>Créditos</h3>
            Desarrollado por <b>Dr. Enrique Scheinvar Gottdiener</b> y la Dra. Niza Gámez Tamariz, Investigadores por México de la Secihti en el Jardín Etnobiológico de Oaxaca,
            con el apoyo de <b>Amigos del Jardín Etnobiológico de Oaxaca, A.C.</b> y los proyectos
            Secihti <b>RENAJEB-2023-21 "Consolidación del JEBOax como acervo biocultural de acceso libre vinculado con iniciativas comunitarias"</b>.
        </div>
    </div>


    <div class="row justify-content-around py-5">
        <div class="col-sm-auto col-md-12 px-4 mb-4" style="text-align:justify;">
            <h3>Contacto:</h3>
            <p>Para reportar errores, sugerir mejoras o participar en el proyecto, escríbe a Enrique Scheinvar: <b>enrique.scheinvar@secihti.mx</b> o visita nuestra página oficial:
            https://jardinoaxaca.mx.</p>
        </div>
    </div>

</div>
