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
        <p>Las Cédulas del Jardín es una plataforma de código abierto, gratuita, colaborativa, multilingüe,
            diseñada, generada y mantenida por los
            Investigadores por México del Jardín Etnobiológico de Oaxaca y que se pone a disposición
            de comunidades, pueblos, Jardines Etnobiológicos o personas interesadas en  documentar
            los saberes relacionados al patrimonio biocultural de los pueblos de México.</p>

        <p>Si quieres participar, revisa nuestra sección de contribuciones.</p>

        <p>Su objetivo principal es generar un punto de encuentro en el que se pueda valorar, conocer y reconocer estos saberes
            en lenguas originarias o en español, presentados en forma de breves artículos, cédulas, monografías, audios, imágenes o videos
            organizadas bajo el esquema de jardines virtuales que son generados y mantenidos por quienes lo conforman.</p>


        <div class="col-sm-auto col-md-4 text-end px-4 mb-4">
            <center>
                <img  src="{{ asset('/imagenes/logo-nav.png') }}">
            </center>
        </div>

        <div class="col-sm-auto col-md-8 px-4 mb-4" style="text-align: justify;">
            <p>El patrimonio biocultural se define como la trama viva que entrelaza la diversidad biológica con la diversidad cultural.
                Ambas coevolucionan en territorios específicos a lo largo del tiempo. No se
                limita a especies, ecosistemas, usos o artefactos materiales; abarca saberes, lenguas, rituales, sistemas productivos,
                toponimias y cosmovisiones que los pueblos han desarrollado mediante la interacción continua con sus entornos.</p>

            <p>Documentar este patrimonio implica registrar y organizar sistemáticamente una memoria colectiva, dinámica,
                que respeta la transmisión oral, la adaptación contextual y el uso de la lengua propia.</p>

            <p>A diferencia de los inventarios tradicionales, la documentación biocultural se debe construir bajo protocolos éticos que
                salvaguarden la propiedad intelectual colectiva, respetan los conocimientos sagrados o restringidos, y garanticen el derecho
                de las comunidades a decidir qué, cómo y para qué se documenta o que no se documenta. </p>
        </div>

        <div class="row justify-content-around py-5">
            <p>La <a href="https://www.diputados.gob.mx/LeyesBiblio/pdf/LGMHCTI.pdf" class="nolink" target="_blank">Ley General
                en Materia de Humanidades, Ciencias, Tecnologías e Innovación</a> de México, en su artículo 53 establece: &quot;la constitución y consolidación de una
                Red Nacional de Jardines Etnobiológicos que tendrá por objeto conservar la riqueza biocultural y promover el cuidado de
                los territorios y bienes comunes. Asimismo, procurará que en cada entidad federativa se cuente al menos con uno de
                estos espacios.&quot;</p>

            <p>Los Jardines Etnobiológicos tenemos que visibilizar, resguardar, difundir y sobre todo, reconocer y dar lugar
                a los autores y poseedores del conocimiento etnobiológico que conforman la riqueza biocultural del país,
                incluyendo las lenguas en las que son generados.  Nuestra
                participación en la sistematización de información y en el impulso y acompañamiento de los procesos de
                documentación por parte de las propias comunidades es importante.</p>

            <p>Así mismo, la colocación de cédulas informativas en jardines comunitarios, escolares o etnobiológicos, es compleja,
                debido a que se realiza en espacios al aire libre y al recambio constante de ejemplares que eleva los costos de impresión,
                de ahí, que este sistema ofrece la posibilidad de ofrecer la información al público, mediante el acceso de un código QR.</p>

            <p>"Las cédulas del jardín" es una herramienta de código abierto diseñada para facilitar elaboración, traducción y
            publicación en línea de cédulas informativas en lenguas originarias.</p>
        </div>
        <div class="col-sm-auto col-md-12 px-4 mb-4" style="text-align: justify;">
            <p>El objetivo principal del sistema es apoyar la documentación, difusión y preservación de saberes locales, particularmente
                en lenguas originarias, mediante una plataforma electrónica gratuita, accesible y colaborativa
                que permita la creación, edición y publicación en línea de cédulas o artículos de información y documentación elaboradas o traducidas a diversas lenguas
                por las propias comunidades poseedoras del conocimiento o con el apoyo del personal de los Jardines Etnobiológicos.</p>


            <p>Su desarrollo inicia en 2025 como parte de una línea de investigación de los Investigadores por México de la
                <a href="https://secihti.mx/" target="new">Secihti</a> en el
                <a href="https://jardinoaxaca.mx">Jardín Etnobiológico de Oaxaca</a> bajo
                los principios de software libre, respeto a la diversidad cultural y lingüística y reconocimiento
                de los saberes ancestrales de los pueblos originarios y desconolinzación del saber y ha sido apoyada por los proyectos
                Renajeb-2023-21 y Divulgación 2024-1114 financiados por el Consejo Nacional de Humanidades, Ciencias y Tecnologías (Conahcyt) y la
                la Secretaría de Ciencia, Humanidades, Tecnología e Innovación (Secihti).</p>
        </div>
    </div>

    <div class="row justify-content-around py-5">
        <div class="col-sm-auto col-md-12 px-4 mb-4" style="text-align:justify;">
            <h3>Características del sistema</h3>
            <ul>
            <li>Es colaborativa. Cuenta con diversos roles que facilitan la interacción para la creación, edición y publicación
                 de cédulas de información.</li>

            <li>Multilingüe. Cuenta con la capacidad de interactuar con traductores a distancia para generar traducciones
                de cada una de las cédulas a diversas lenguas.</li>

            <li>Respeta la oralidad. Permite asociar archivos de audio en las cédulas para preservar
                    la tradición oral o facilitar la traducción a lenguas sin escritura o de compleja escritura .</li>

            <li>Interactiva. Incluye funcionalidades para agregar documentación mediante audio, imágenes o videos.</li>

            <li>Catalogable. Genera una dirección URL única y fija para cada una de las cédulas de documentacion a las cuales se puede
                acceder desde una dirección URL o un código QR (generado por el sistema) o mediante la dirección asignada por DOI.</li>

            <li>Aportaciones moderadas. Incluye un módulo mediante el cual los visitantes pueden enviar sus aportaciones al conocimiento
                sobre alguna cédula, la cual se publica junto con la cédula de información luego de pasar por un proceso de aprobación.</li>

            <li>Incorpora redes. Permite incorporar referencias a canales, publicaciones y videos de documentación
                generadas por el público en diversas redes sociales.</li>

            <li>Gestión multi-jardín. Permite registrar uno o más jardines en un mismo sistema, manteniendo la independencia en la asignación de roles y
                administración de contenidos, pero ahorrando recursos de infraestructura</li>

            <li>Colaboración. Al incluir información de diferentes jardines, permite ampliar la información referente a un mismo tema, avisando al visitante, la existencia
                de otras cédulas relacionadas en otros jardines, lo que promueve la colaboración entre jardines y comunidades.</li>

             <li>Accesible. Al ser un sistema basado en la web, permite el acceso a las cédulas desde cualquier dispositivo con conexión a internet, facilitando su consulta tanto en los jardines como en las comunidades o desde cualquier parte del mundo.
            </li>

            <li>Seguro. Cuenta con un robusto sistema de seguridad que permite generar cuentas asociadas a un correo electrónico
                y asignarles roles específicos, promoviendo la colaboración comunitaria, al permitir que hablantes nativos, lingüistas y educadores
                contribuyan a la creación, edición o traducción de contenido desde sus comunidades mediante el
                acceso a la plataforma por internet.</li>

            <li>Catálogos homologados. Con el objeto de homologar la información, incorpora catálogos especializados, como algunos de
                ubicación del <a href="https://www.inegi.org.mx/" target="new">INEGI</a>, de
                <a href="https://www.ethnologue.com/" target="new">lenguas del ethnologue</a> o de especies botánicas
                <a href="https://powo.science.kew.org/" target="new"> Plants of the World</a> de Kew</li>
        </div>    </div>


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
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/45/Heckert_GNU.png" style="width:150px;">

        </div>
    </div>

    <div class="row justify-content-around py-5">
        <div class="col-sm-auto col-md-12 px-4 mb-4" style="text-align:justify;">
        <h3>Desarrollo y contribución:</h3>
        <p>El sistema fua desarrollado como un producto derivado del proyecto de investigación del  Investigador por México de la Secihti en el Jardín Etnobiológico de Oaxaca,
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
            {{ url('/') }}.</p>
        </div>
    </div>

</div>
