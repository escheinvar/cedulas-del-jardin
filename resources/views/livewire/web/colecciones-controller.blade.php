
@section('title')
Colecciones
@endsection

@section('meta-description')
Brindamos apoyo a iniciativas comunitarias y a la formación de profesionistas relacionados a la etnobotánica. Contamos con una biblioteca especializada y un Herbario.
@endsection

@section('banner')
banner-servicios
@endsection

@section('banner-title')
Colecciones
@endsection



<div>
    <!--S1 SERVICIOS-->
    <section class="servicios pb-5">
        <div class="container px-4 py-5" id="bienvenido">
            <div>
                @include('plantillas/plant_locale')
            </div>

            <!-- Texto superior -->
            <div class="row justify-content-around text-center pb-4">
                <div class="col-sm-12 col-md-9 col-lg-8 col-xl-7 pt-5 px-4">
                    <h2 class="subtitulo">Colecciones</h2>
                    <p class="texto-principal">El Jardín Etnobiológico resguarda en vivo una colección de cientos de especies de plantas,
                        originarias y donadas por las comunidades de Oaxaca, que presentan algún uso o son de importancia para las mismas.
                        Además, contamos con un herbario, una colección de semillas vivas y una colección de hongos.
                    </p>
                </div>
            </div>

            <!-- Contador -->
            <div class="row count-area text-center pt-3" data-diff="100">
                <div class="col-sm-6 col-md-2">
                    <div class="count-area-content">
                        <div class="count-icon"> </div>
                        <div class="count-digit">2</div>
                        <div class="count-title">Hectáreas</div>
                        <div class="count-description">Área plantadas <br> </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="count-area-content">
                        <div class="count-icon"> </div>
                        <div class="count-digit">100</div>
                        <div class="count-title">Comunidades y ejidos</div>
                        <div class="count-description">Aportaron plantas, <br> piedra y tierra al Jardín</div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="count-area-content">
                        <div class="count-icon"> </div>
                        <div class="count-digit">1500</div>
                        <div class="count-title">Especies plantadas</div>
                        <div class="count-description">10% de la flora<br>del estado</div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="count-area-content">
                        <div class="count-icon"> </div>
                        <div class="count-digit">1300</div>
                        <div class="count-title">Ejemplares de herbario</div>
                        <div class="count-description">Para terminar<br>el Jardín</div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <div class="count-area-content">
                        <div class="count-icon"> </div>
                        <div class="count-digit">300</div>
                        <div class="count-title">Semillas de especies distintas</div>
                        <div class="count-description">20% de las especies<br>del Jardín</div>
                    </div>
                </div>
            </div>

            {{--
            <div class="row justify-content-end">
                <div class="col-sm-12 col-md-9 col-lg-8 col-xl-6 pt-5 px-4">
                    <h2 class="subtitulo">Apoyo comunitario</h2>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-sm-12 col-md-9 col-lg-8 col-xl-6 py-2 px-4">
                    <p class="texto-secundario">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis
                        reprehenderit esse neque odit, vitae optio porro illo tempore, expedita nesciunt aspernatur!
                        Minus cumque illum quaerat a impedit, sit excepturi vel. Lorem ipsum dolor sit amet
                        consectetur
                        adipisicing elit. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aspernatur
                        reprehenderit deserunt minus tenetur debitis officiis sequi hic, ipsa molestiae tempore
                        impedit
                        unde amet aperiam illum voluptate vel in, perferendis quas!Nihil iusto explicabo, quam
                        sapiente
                        laudantium voluptates fuga repellendus
                        repellat, ab perspiciatis illo mollitia ipsam itaque fugit voluptatem. Cum error est
                        ducimus.
                    </p>
                </div>
            </div>
            --}}
        </div>
    </section>


    <!--S2 GALERIA SERVICIOS-EDUCATIVOS  -->
    <section class="servicios-educativos py-5">
        <div class="container espacios pt-4">

            <!-- Colección viva -->
            <div class="slide-container active">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">Colección viva</h2>
                        <p> Contamos con una importante colección de ejemplares de plantas vivas nativas de Oaxaca que fueron
                            donadas por las comunidades del estado por tener algún tipo de valor cultural o de uso.
                        </p>
                        <p>Todas las especies que observamos se relacionan de alguna forma con la vida humana en Oaxaca, desde los cazadores
                            recolectores de hace 12,000 años, hasta las comunidades rurales y urbanas actuales.
                        </p>
                        <p>El estado de Oaxaca, no solamente presenta la flora más diversa de México, cuenta también con la mayor diversidad
                            cultural en el país: aquí se hablan más lenguas indígenas, conviven más pueblos originarios y más
                            comunidades políticamente autónomas que en ninguna otra área de México.
                        </p>
                        <p>El Jardín busca resguardar una pequeña parte del patrimonio representado en las relaciones
                            que hay entre la diversidad natural y la complejidad cultural de Oaxaca.
                        </p>
                        {{-- <h3>Horarios</h3>
                        <p>Lunes - viernes <br> 9:00 - 19: 00 horas</p>
                        <p>Sábados <br>9:00 - 13:00 horas</p> --}}
                    </div>
                    <div class="image">
                        <a href="imagenes/slider-7_colecciones/img-01.jpg" data-fancybox="gallery7">
                            <img src="imagenes/slider-7_colecciones/img-pre-01.jpg"
                                alt="Colección del Jardín Etnobiológico de Oaxaca">
                            <h4 class="w-100">Hornos de cal en la zona norte de la colección</h4>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Herbario -->
            <div class="slide-container">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo"> Herbario</h2>
                        <p>Contamos actualmente con cerca de 3100 especímenes herborizados, que representan cerca de
                            1100 especies de plantas. La mayor parte de estos especímenes sirven de respaldo para
                            documentar el conocimiento tradicional y los usos de las plantas vivas del Jardín
                            Etnobotánico de Oaxaca.</p>

                        <p>El herbario está abierto tanto a estudiantes como a promotores comunitarios e investigadores
                            académicos, previa cita por teléfono o correo electrónico.</p>
                    </div>
                    <div class="image">
                        <a href="imagenes/slider-7_colecciones/img-02.jpg" data-fancybox="gallery7">
                            <img src="imagenes/slider-7_colecciones/img-pre-02.jpg" alt="Ficha del herbario">
                            <h4 class="w-100">Ejemplar de <i>Sambucus nigra</i> del herbario del Jardín Etnobiológico de Oaxaca</h4>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Colección de semillas -->
            <div class="slide-container">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">Colección <br>de semillas</h2>
                        <p> Contamos con una
                            colección de semillas obtenidas de nuestros propios ejemplares y que renovamos
                            de manera periódica
                            con el objeto de dar continuidad a nuestra propia colección viva, así como poder surtir de
                            germoplasma a los proyectos asociados al Jardín, cuando existen excedentes.
                        </p>
                        <p> Para 2024, resguardamos en nuestra colección, más de 1000 accesiones correspondientes a
                            más de 300 especies de flora nativa oaxaqueña.
                        </p>
                        <p>La colección está disponible para instituiciones, investigadores o comunidades que lo requieran,
                            mediante solicitud oficial por correo electrónico</p>
                    </div>
                    <div class="image">
                        <a href="imagenes/slider-7_colecciones/img-03.jpg" data-fancybox="gallery7">
                            <img src="imagenes/slider-7_colecciones/img-pre-03.jpg" alt="Guía y alumnos en el Jardín Etnobotánico">
                            <h4 class="w-100">Ejemplares de semillas</h4>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Colección de hongos -->
            <div class="slide-container">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">Colección <br>de hongos</h2>
                        <p>Muy recientemente y con apoyo de nuestros colaboradores de la Universidad de Tlaxcala, es que
                            estamos iniciando con nuestra nueva colección de ejemplares de herbario de hongos
                            del estado de Oaxaca.
                        </p>

                        <p>El herbario está abierto tanto a estudiantes como a promotores comunitarios e investigadores
                            académicos, previa cita por teléfono o correo electrónico.</p>

                    </div>
                    <div class="image">
                        <a href="imagenes/slider-7_colecciones/img-03.jpg" data-fancybox="gallery7">
                            <img src="imagenes/slider-7_colecciones/img-pre-03.jpg" alt="Guía y alumnos en el Jardín Etnobotánico">
                            <h4 class="w-100">Colección de hongos del Jardín Etnobiológico de Oaxaca</h4>
                        </a>
                    </div>
                </div>
            </div>

            <div id="prev" onclick="prev()" class="button-prev"> </div>
            <div id="next" onclick="next()" class="button-next"> </div>

        </div>

    </section>





</div>



@section('scripts')
    <!--Contador colección-->
    <script>
        function visible(partial) {
            var $t = partial,
                $w = jQuery(window),
                viewTop = $w.scrollTop(),
                viewBottom = viewTop + $w.height(),
                _top = $t.offset().top,
                _bottom = _top + $t.height(),
                compareTop = partial === true ? _bottom : _top,
                compareBottom = partial === true ? _top : _bottom;

            return (
                compareBottom <= viewBottom && compareTop >= viewTop && $t.is(":visible")
            );
        }

        $(window).scroll(function () {
            if (visible($(".count-digit"))) {
                if ($(".count-digit").hasClass("counter-loaded")) return;
                $(".count-digit").addClass("counter-loaded");

                $(".count-digit").each(function () {
                    var $this = $(this);
                    jQuery({ Counter: 0 }).animate(
                        { Counter: $this.text() },
                        {
                            duration: 5000,
                            easing: "swing",
                            step: function () {
                                $this.text(Math.ceil(this.Counter));
                            }
                        }
                    );
                });
            }
        });



        //<!--slider educacion-->

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
