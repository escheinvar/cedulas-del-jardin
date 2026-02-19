@section('title')
Directorio
@endsection

@section('meta-description')
Directorio: Grupo de diseño, Director, Responsables, Auxiliares docentes, Horticultores, Guías y Voluntarios del Jardín Etnobotánico de Oaxaca.
@endsection

@section('banner')
banner-directorio
@endsection

@section('banner-title')
Directorio
@endsection


<div>
    <!-- DIRECTORIO-->
    <section class="directorio pt-4">
        <div class="container px-4 py-5" id="bienvenido">
            <div>
                @include('plantillas/plant_locale')
            </div>

            <div class="row diseno justify-content-end pt-3 ">
                <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6 ">
                    <h2 class="subtitulo">Grupo de Diseño del Jardín</h2>
                    <p>
                        Maestro Francisco Toledo (†) <br>
                        Luis Zárate <br>
                        Dr. Alejandro de Ávila Blomberg (Director fundador)
                    </p>
                </div>
            </div>

            <div class="row responsables pt-3">
                <div class="col">
                    <div class="row subtitulo justify-content-end">
                        <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6 ">
                            <h3 class="subtitulo">Responsables del Jardín</h3>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3">
                            <h4>Dirección del Jardín</h4>
                            <p>Francisco Javier Andrés Pacheco, <small><br><A HREF="https://www.oaxaca.gob.mx/occe/" class="nolink">Director general de la Oficina de Convenciones, Congresos y Eventos de Oaxaca (OCCE)</A>*<br>
                                *<small>Por decreto en el Periódico Oficial del <a href="/imagenes/250228_DiarioOficialOaxaca_Jardin.pdf" target="new" class="nolink">28 de febrero</a> y <a href="/imagenes/250303_DiarioOficialOaxaca_occe.pdf" target="new" class="nolink">3 de marzo</a> de 2025</small></small></p>


                        </div>

                        <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3">
                            <h4>Coordinación de Conservación y Preservación Etnobiológica</h4>
                            <p>Geovanni Martínez Guerra</p>

                            <h4>Departamento de Estudios Etnobiológicos</h4>
                            <p> Vianney Hernández Gómez</p>

                            <h4>Departamento de Difusión Etnobiológica</h4>
                            <p>Javier Bustamante San Juan</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row auxiliares pt-3">
                <div class="col">
                    <div class="row subtitulo justify-content-end">
                        <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6 ">
                            <h3 class="subtitulo">Auxiliares </h3>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3">
                            <h4>Infraestructura y Eventos</h4>
                            <p>Jorge Juárez García</p>

                            <h4>Biblioteca</h4>
                            <p> Mariana Hortencia Muñoz Herrera</p>
                            <p> Jacqueline Itzel Jiménez López</p>

                            {{-- <ul>
                                <li>Ing. Vianney Hernández Gómez</li>
                                <li>Biol. David Alejandro Velasco Filio</li>
                                <li>.</li>
                            </ul> --}}
                        </div>

                        <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3">
                             <h4>Administración</h4>
                            <p>Guadalupe Ortega Aguilar</p>

                            <h4>Recorridos escolares</h4>
                            <p>Miriam Beatríz Contreras Ramírez</p>

                            <h4>Colecciones</h4>
                            <p>David Alejandro Velasco Filio</p>
                            {{-- <ul>
                                <li>Arq. Valeria Rubio García</li>
                                <li>Biol. Geovanni Martínez Guerra</li>
                                <li>Biol. Jacqueline Itzel Jiménez López</li>
                            </ul> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row horticultores pt-3 pb-5">
                <div class="col">
                    <div class="row subtitulo justify-content-end">
                        <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                            <h3 class="subtitulo">Horticultor@s</h3>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3">
                            <ul>
                                <li>Gabriela Herlinda Navarro Reyes</li>
                                <li>Mariela Pérez López</li>
                                <li>Gabriela Talledos Robles</li>
                                <li>Jesús Santiago Fernandez Silva</li>
                                <li>Jesús Cruz Cruz</li>
                                <li>Benjamín Gálvez Aguilar</li>
                                <li>Abdiel Mizraim Rodríguez Ramírez</li>
                            </ul>
                        </div>

                        <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3">
                            <ul>
                                <li>Mauro Daniel Ramírez Pérez</li>
                                <li>Norberto Esteban Rodríguez Ramírez</li>
                                <li>Lucio Ruíz Velasco</li>
                                <li>Abad Morales Bernardo</li>
                                <li>Erika Isabel Castellanos Zavaleta</li>
                                <li>Carlos Miguel Ruiz Camacho</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row horticultores pt-3 pb-5">
                <div class="col">
                    <div class="row subtitulo justify-content-end">
                        <div class="col-sm-12 col-md-10 col-lg-8 col-xl-6">
                            <h3 class="subtitulo">Investigador@s por México</h3>
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3">
                            <ul>
                                <li><a href="#" class="nolink">Dra. Xitlali Aguirre Dugua</a><br><!-- xitlali.aguirre@secihti.mx --><br></li><br>
                                <li><a href="#" class="nolink">Dra. Niza Gámez Tamariz</a><br>niza.gamez@secihti.mx</li>
                            </ul>
                        </div>

                        <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3">
                            <ul>
                                <li><a href="#" class="nolink">Dra. Mariana Zarazúa</a><br>mariana.zarazua@secihti.mx</li><br>
                                <li><a href="/enrique" class="nolink">Dr. Enrique Scheinvar</a><br>enrique.scheinvar@secihti.mx</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
