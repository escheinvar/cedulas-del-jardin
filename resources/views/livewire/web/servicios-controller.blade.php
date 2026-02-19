@section('title')
Servicios
@endsection

@section('meta-description')
El Jardín apoya la formación de profesionistas en diversos temas relacionados con la etnobotánica y el manejo sostenible de los recursos naturales ¡entérate!
@endsection

@section('banner')
banner-educacion
@endsection

@section('banner-title')
Servicios
@endsection

<div>

    <!--S1 PRESENTACION-->
    <section class="presentacion pb-5">
        <div class="container py-5 px-3" id="bienvenido">
            <div>
                @include('plantillas/plant_locale')
            </div>
            <div class="row justify-content-around py-5">
                <div class="col-sm-auto col-md-6 col-lg-5 text-end px-4 pb-5 mb-4">
                    <h3 class="cita">“Visitar el jardín <br>de niña me motivó a estudiar Ingeniería en Restauración
                        forestal”</h3>
                    <h4 class="autor-cita">Visitante del Jardín</h4>
                    <p class="autor-cita">Día Nacional de los Jardines Botánicos</p>
                </div>
                <div class="col-sm-auto col-md-6 col-lg-6 col-xl-5 text-start px-4">
                    <div class="row">
                        {{-- <div class="col">
                            <h2 class="subtitulo">Servicios comunitarios</h2>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="texto-secundario">El Jardín se fundó bajo el esquema tradicional del Tequio, y desde entonces,
                                continuamos con esta labor de trabajo comunitario incesante, en el que la difusión y la educación
                                tienen un papel primordial.
                            </p>
                            <p class="texto-secundario"> Apoyamos la formación de profesionistas en diversos temas
                                relacionados con la etnobiología y el manejo sostenible de los recursos naturales.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-around py-5">
                <div class="col-sm-auto col-md-6 col-lg-5 text-start px-4 pb-5 mb-4">
                    <div class="row">
                        <div class="col">
                            <p class="texto-secundario">
                                Contamos con una vasta biblioteca especializada abierta al público.
                            </p>
                            <p class="texto-secundario">
                                Orgullosamente y de manera diaria, brindamos recorridos escolares gratuitos.
                            </p>
                            <p class="texto-secundario">
                                Participamos de diversos programa gubernamuntales como el de "Noches de Museo", donde ofrecemos recorridos nocturnos las noches del último viernes de cada mes.
                            </p>
                            <p class="texto-secundario">
                                Fomentamos, apoyamos y mantenemos varios Jardines Comunitarios en el estado de Oaxaca además de
                                brindar asesoría y germoplasma en diversas jardineras y jardines de México.
                            </p>
                            <p class="texto-secundario">
                                Ofrecemos actividades, pláticas y talleres gratuitos de manera periódica.
                            </p>

                        </div>
                    </div>
                </div>
                <div class="col-sm-auto col-md-6 col-lg-6 col-xl-5 text-start px-4">
                    <div class="row">
                        <div class="col">
                            <h3 class="cita">“Nos enfocamos en la experiencia humana con las plantas y los animales, tanto en el pasado y el presente como a futuro.</h3>
                            <h4 class="autor-cita">Dr. Alejandro de Ávila Blomberg</h4>
                            <p class="autor-cita">Director Fundador del Jardín</p>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>








    <!--S2 GALERIA SERVICIOS-EDUCATIVOS  -->
    <section class="servicios-educativos py-5">
        <div class="container espacios pt-4">
            <!-- Biblioteca -->
            <div class="slide-container active">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">Biblioteca</h2>
                        <p> Especializada en temas de ciencias naturales, etnobiología, ecología humana y conservación
                            ambiental, la biblioteca del Jardín Etnobotánico de Oaxaca tiene bajo su resguardo cerca de
                            10,000 publicaciones en español, inglés y otras lenguas.
                        </p>
                        <p>Resguardamos el acervo de la Sociedad Botánica de México.</p>

                        <p>Cuenta con servicio de internet disponible para todos los usuarios. Si desea visitarla puede ingresar
                            en los siguientes horarios.</p>

                        <h3>Horarios</h3>
                        <p>Lunes - viernes <br> 9:00 - 19: 00 horas</p>
                        <p>Sábados <br>9:00 - 13:00 horas</p>
                    </div>

                    <div class="image">
                        <a href="imagenes/slider-6_servicios/img-01_biblio.jpg" data-fancybox="gallery7">
                            <img src="imagenes/slider-6_servicios/img-pre-01_biblio.jpg"
                                alt="Visitantes en la Biblioteca  del Jardín Etnobiológico">
                            <h4 class="w-100">Visitantes en la Biblioteca del Jardín Etnobiológico</h4>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recorridos escolares-->
            <div class="slide-container">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">Recorridos<br>escolares</h2>
                        <p>Uno de los objetivos del jardín, es el resguardo y transmisión del conocimiento acerca de las
                            plantas, hongos y animales depositado por las comunidades en el Jardín.</p>
                        <p>De ahí que una de nuestras mayores prioridades es la de ofrecer recorridos gratuitos diarios
                            a todas las escuelas que nos lo soliciten y en las cuales podemos mostrar la inmensa diversidad
                            natural y cultural de las comunidades oaxaqueñas.
                        </p>
                        <br>
                        <div class="col-sm-12 col-md-auto">
                            <a href="/recorridos#escolares" class="escolares">
                                @if(session('locale')=='en')
                                    School visits
                                @elseif(session('locale')=='pt')
                                    Visitas escolares
                                @elseif(session('locale')=='es_mix_bj')
                                    Ñà kì’vi na kuǎlí ká’vi
                                @else
                                    Visitas escolares
                                @endif
                            </a>
                            @if(session('locale')=='es_mix_bj')
                                <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','4')" style="color:#64383E"></i>
                                <audio controls  id="sale_audio4" style="display:none;">
                                    <source src="audio/es_mix_bj/02_recorrido_04.ogg" type="audio/ogg">
                                </audio>
                            @endif
                        </div>

                    </div>
                    <div class="image">
                        <a href="imagenes/slider-6_servicios/img-02_recorridos.jpg" data-fancybox="gallery7">
                            <img src="imagenes/slider-6_servicios/img-02_recorridos.jpg" alt="Recorrido de escuela de San Pabo Yaganiza, noviembre 2024">
                            <h4 class="w-100">Recorrido de escuela de San Pabo Yaganiza, noviembre 2024</h4>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recorridos nocturnos-->
            <div class="slide-container">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">Recorridos<br>nocturnos</h2>
                        <p>Como parte del programa "Noches de museo" y "Fines culturales", el Jardín Etnobiológico
                            de Oaxaca, ofrece de manera periódica, recorridos nocturnos gratuitos a todos los visitantes que
                            deseen conocer el Jardín de noche</p>
                        <p>En estos recorridos, los visitantes podrán oler, sentir y percibir la vida nocturna del jardín,
                            y podrán escuchar, de parte de nuestros guías especializados, varios aspectos interesantes
                            sobre la vida de las plantas y animales nocturnos que habitan en el estado de Oaxaca.
                        </p>

                        <h3>Horarios</h3>
                        <h4 class="duracion">Duración 20 minutos</h4>
                        <p>Último viernes, de cada tres meses<br>a partir de las 18:00 horas
                        </p>

                    </div>
                    <div class="image">
                        <a href="imagenes/slider-6_servicios/img-03.jpg" data-fancybox="gallery7">
                            <img src="imagenes/slider-6_servicios/img-pre-03.jpg" alt="Recorridos nocturnos en el Jardín Etnobotánico de Oaxaca">
                            <h4 class="w-100">Noche de Museos en el Jardín Etnobiológico de Oaxaca, noviembre 2024.</h4>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Jardín comunitario 1-->
            <div class="slide-container">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">Jardines comunitarios</h2>
                        <p>
                            Bajo solicitud expresa, apoyamos a las comunidades en el establecimiento, consolidación y mantenimiento
                            de sus jardines comunitarios.
                        </p>
                        <p>En 2024 iniciamos labores para la creación de jardines comunitarios:</p>


                        <h4 class="duracion">Guelatao</h4>
                        <h4 class="duracion">Santiago Matatlán</h4>

                        <p>En 2022, apoyamos a la comunidad de Cuilapam de Guerrero y la comunidad de San Pedro Totolapam
                            con la elaboración de su propuesta técnica, selección de especies locales, diseño y trazo del jardín y jardineras,
                            capacitación al personal, entrega de germoplasma y
                            apoyo en elaboración y mantenimiento de sus Jardines Comunitarios.
                        </p>

                        <h4 class="duracion">Cuilapam de Guerrero</h4>
                        <h4 class="duracion">San Pedro Totolapan</h4>


                    </div>
                    <div class="image">
                        <a href="imagenes/slider-6_servicios/img-04_jardinescoms.png" data-fancybox="gallery7">
                            <img src="imagenes/slider-6_servicios/img-04_jardinescoms.png" alt="Guía y alumnos en el Jardín Etnobotánico">
                            <h4 class="w-100">Vista del Jardín Comunitario de San Pedro Totolapam</h4>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Jardines y jardineras-->
            <div class="slide-container">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">Apoyo a Jardines</h2>
                        <p>Como parte de nuestra labor comunitaria, hemos apoyado a varios gobiernos municipales
                            en aspectos de jardinería y paisajismo.
                            Desde la selección de especies adecuadas para cada ambiente, proporción de germoplasma
                            y asesoría.
                        </p>

                        <h4 class="duracion">Parque Primavera Oaxaqueña</h4>
                        <h4 class="duracion">Archivo General del Estado de Oaxaca</h4>
                        <h4 class="duracion">Parque de Canteras</h4>
                        <h4 class="duracion">Plazuela del Carmen Alto</h4>
                        <h4 class="duracion">Atrio de iglesia de Santo Domingo</h4>
                        <h4 class="duracion">Jardín de polinizadores del Cerro del Fortín</h4>
                        <h4 class="duracion">Reforestación de Cerro del Fortín</h4>
                    </div>
                    <div class="image">
                        <a href="imagenes/slider-6_servicios/img-03.jpg" data-fancybox="gallery7">
                            <img src="imagenes/slider-6_servicios/img-pre-03.jpg" alt="Guía y alumnos en el Jardín Etnobotánico">
                            <h4 class="w-100">Recorridos escolares en el Jardín Etnobotánico de Oaxaca</h4>
                        </a>
                    </div>
                </div>
            </div>


             <!-- Cursos y Talleres-->
             <div class="slide-container">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">Cursos y Talleres</h2>
                        <p>Como parte de nuestros servicios, contamos con personal capacitado en diversos temas para
                            la impartición de cursos y talleres al público, relacionados con temas de
                            lenguas originarias, botánica, evolución, biogeografía, jardinería, sustentabilidad, zoologia, hongos, entre otros.
                        </p>
                        <div class="col-sm-12 col-md-auto">
                            <a href="/actividades" class="escolares">
                                Eventos
                            </a>
                        </div>
                    </div>
                    <div class="image">
                        <a href="imagenes/slider-6_servicios/img-06_cursos.jpg" data-fancybox="gallery7">
                            <img src="imagenes/slider-6_servicios/img-06_cursos.jpg" alt="Guía y alumnos en el Jardín Etnobotánico">
                            <h4 class="w-100">Taller: Manualidades con hojas, flores y Semillas del Jardín. Sra
                                    Mariana Muñoz Herrera | Foto: Alma Pérez Bautista</h4>
                        </a>
                    </div>
                </div>
            </div>

            <div id="prev" onclick="prev()" class="button-prev"> </div>
            <div id="next" onclick="next()" class="button-next"> </div>

        </div>

    </section>








    <!--S2 GALERIA-COLECCIONES VIEJO-->
    {{-- <section class="galeria-servicios pt-5">
        <div class="container py-5 px-4">
            <div class="row pb-5">
                <div class="col">
                    <h2>Actividades del Jardín Etnobotánico</h2>
                    <div class="owl-carousel owl-theme">
                        <div>
                            <a href="imagenes/slider-6_servicios/zimg-01.jpg" data-fancybox="gallery6">
                                <img src="imagenes/slider-6_servicios/zimg-pre-01.jpg" alt="Día de los Jardínes Botánicos">
                                <h3 class="w-100"> Día Nacional de los Jardínes Botánicos| Foto: Alma Pérez Bautista
                                </h3>
                            </a>
                        </div>
                        <div>
                            <a href="imagenes/slider-6_servicios/zimg-02.jpg" data-fancybox="gallery6">
                                <img src="imagenes/slider-6_servicios/zimg-pre-02.jpg" alt="Día de los Jardínes Botánicos">
                                <h3 class="w-100"> Día Nacional de los Jardínes Botánicos| Foto: Alma Pérez Bautista
                                </h3>
                            </a>
                        </div>
                        <div>
                            <a href="imagenes/slider-6_servicios/zimg-03.jpg" data-fancybox="gallery6">
                                <img src="imagenes/slider-6_servicios/zimg-pre-03.jpg"
                                    alt="Taller del Día de los Jardínes Botánicos">
                                <h3 class="w-100">Taller: Gilá Naquitz y el origen de la agricultura, Dra. Xitlali
                                    Aguirre Dugua | Foto: Alma Pérez Bautista</h3>
                            </a>
                        </div>
                        <div>
                            <a href="imagenes/slider-6_servicios/zimg-04.jpg" data-fancybox="gallery6">
                                <img src="imagenes/slider-6_servicios/zimg-pre-04.jpg"
                                    alt="Taller infantil del Día de los Jardínes Botánicos">
                                <h3 class="w-100">Taller: Manualidades con hojas, flores y Semillas del Jardín. Sra
                                    Mariana Muñoz Herrera | Foto: Alma Pérez Bautista</h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
</div>


@section('scripts')
    <!--slider educacion-->
    <script>

        let slides = document.querySelectorAll('.slide-container');
        let index = 0;

        //next function
        function next() {
            slides[index].classList.remove('active');
            index = (index + 1) % slides.length;
            slides[index].classList.add('active');
        }
        //next prev
        function prev() {
            slides[index].classList.remove('active');
            index = (index - 1 + slides.length) % slides.length;
            slides[index].classList.add('active');
        }

    </script>

@endsection
