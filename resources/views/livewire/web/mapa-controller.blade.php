@section('title')
Mapa del Jardín
@endsection

@section('meta-description')
¿Necesitas un mapa? Descubre que áreas forman parte del Jardín Etnobotánico. Ven y conoce algunas de las secciones, esculturas y espacios que nos caracterizan.
@endsection

@section('banner')
banner-mapa
@endsection

@section('banner-title')
    @if(session('locale')=='en')
        Map of the <br>Ethnobiological Garden
    @elseif(session('locale')=='pt')
        Mapa do jardim<br>Etnobiológico
    @else
        Mapa del jardín<br>Etnobiológico
    @endif
@endsection

<div>
    <!--S1 MAPA-->
    <section class="mapa-jardin pt-4">
        <div class="container px-4 py-5 " id="bienvenido">
            <div>
                @include('plantillas/plant_locale')
            </div>

            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-6 ">
                    <h2 wire:click="cambiaFoto('general')" class="subtitulo">
                        @if(session('locale')=='en')
                            Map of the Ethnobiological Garden
                        @elseif(session('locale')=='pt')
                            Mapa do jardim<br>Etnobiológico
                        @else
                            Mapa del jardín<br>Etnobiológico
                        @endif
                    </h2>
                </div>
            </div>

            <div class="row justify-content-center pb-5">
                <div class="col-sm-12 col-md-10 col-lg-6 col-xl-6 col-xxl-5 mapa-imagen">
                    <a href="/imagenes/mapa/mapa-pre-01.png" data-fancybox="gallery3">
                        <img src={{$mapa}} alt="Mapa del Jardín Etnobotánico" class="w-100">
                    </a>
                </div>
                <div class="col-sm-12 col-md-10 col-lg-5 col-xl-5 col-xxl-5 mapa-lugares py-5" wire:ignore>
                    <div class="accordion accordion-flush-mapa" id="accordionFlushExample">
                        <!--ITEM 1-->
                        <div class="accordion-item-mapa">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button wire:click="cambiaFoto('dentro')" class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseOne" aria-expanded="false"
                                    aria-controls="flush-collapseOne">
                                    @if(session('locale')=='en')
                                        Inside the Garden
                                    @elseif(session('locale')=='pt')
                                        Dentro do jardim
                                    @else
                                        Dentro del Jardín
                                    @endif
                                </button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                <div class="row accordion-body pt-4">
                                    <div class="col-sm-6 col-md-5 col-lg-12 col-xl-6">
                                        <ol>
                                            @if(session('locale')=='en')
                                                <li>Entry </li>
                                                <li>Box Office </li>
                                                <li>Library </li>
                                                <li>Ladies' Restroom </li>
                                                <li>Men's restroom </li>
                                                <li>Staircase</li>
                                            @elseif(session('locale')=='pt')
                                                <li>Entrada</li>
                                                <li>Bilheteria </li>
                                                <li>Biblioteca </li>
                                                <li>Banheiro feminino </li>
                                                <li>Banheiro masculino </li>
                                                <li>Escadaria</li>
                                            @else
                                                <li>Entrada </li>
                                                <li>Taquilla </li>
                                                <li>Biblioteca </li>
                                                <li>Sanitario de damas </li>
                                                <li>Sanitario de caballeros </li>
                                                <li>Cubo de escalera</li>
                                            @endif
                                        </ol>

                                    </div>
                                    <div class="col-sm-6 col-md-5 col-lg-12 col-xl-6">
                                        <ol start="7">
                                            @if(session('locale')=='en')

                                                <li>Greenhouse</li>
                                                <li>Plazuela</li>
                                                <li>Sanitary</li>
                                                <li>The Huaje Coutyard</li>
                                                <li>Atrium</li>
                                            @elseif(session('locale')=='pt')

                                                <li>Estufa</li>
                                                <li>Plazuela</li>
                                                <li>Sanitário</li>
                                                <li>Pátio El Guaje</li>
                                                <li>Átrio</li>
                                            @else

                                                <li>Invernadero</li>
                                                <li>Plazuela</li>
                                                <li>Sanitario</li>
                                                <li>Patio El Huaje</li>
                                                <li>Atrio</li>

                                            @endif
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--ITEM 2-->
                        <div class="accordion-item-mapa">
                            <h2 class="accordion-header" id="flush-headingTwo">
                                <button wire:click="cambiaFoto('sobresalientes')" class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                    aria-controls="flush-collapseTwo">
                                    @if(session('locale')=='en')
                                        Outstanding attractions
                                    @elseif(session('locale')=='pt')
                                        Atrações marcantes
                                    @else
                                        Atractivos sobresalientes
                                    @endif
                                </button>
                            </h2>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                <div class="row accordion-body pt-4">
                                    <div class="col-sm-6 col-md-6 col-lg-12 col-xl-6">
                                        <ol type="A">
                                            @if(session('locale')=='en')
                                                <li>Sculpture by Jorge Dubón</li>
                                                <li>Sculpture by Luis Zárate: Cuanana Mirror</li>
                                                <li>Sculpture by JorgeYáspick</li>
                                                <li>Sculpture by Francisco Toledo: The blood of Mitla </li>
                                                <li>Sculptural benches</li>

                                            @elseif(session('locale')=='pt')
                                                <li>Escultura de Jorge Dubón</li>
                                                <li>Escultura de Luis Zárate: Espelho Cuanana</li>
                                                <li>Escultura de JorgeYáspick</li>
                                                <li>Escultura de Francisco Toledo: O sangue de Mitla </li>
                                                <li>Bancos esculturais</li>

                                            @else
                                                <li>Escultura de Jorge Du Bón</li>
                                                <li>Escultura de Luis Zárate: Espejo de Cuanana</li>
                                                <li>Escultura de Jorge Yáspick</li>
                                                <li>Escultura de Francisco Toledo: La Sangre de Mitla </li>
                                                <li>Bancas escultóricas</li>

                                            @endif
                                        </ol>
                                    </div>
                                    <div class="col-sm-5 col-md-6 col-lg-12 col-xl-6">
                                        <ol type="A" start="6">
                                            @if(session('locale')=='en')
                                                <li>Old road </li>
                                                <li>16th century pond</li>
                                                <li>Ceramic kiln</li>
                                                <li>Lime kilns</li>
                                                <li>Washrooms</li>

                                            @elseif(session('locale')=='pt')
                                                <li>Estrada antiga</li>
                                                <li>Lago do século XVI</li>
                                                <li>Forno de cerâmica</li>
                                                <li>Fornos de cal</li>
                                                <li>Lavanderias</li>

                                            @else
                                                <li>Calzada antigua </li>
                                                <li>Estanque del siglo XVI</li>
                                                <li>Horno de cerámica</li>
                                                <li>Horno de cal</li>
                                                <li>Lavaderos</li>

                                            @endif
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--ITEM 3-->
                        <div class="accordion-item-mapa">
                            <h2 class="accordion-header" id="flush-headingThree">
                                <button wire:click="cambiaFoto('secciones')" class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseThree" aria-expanded="false"
                                    aria-controls="flush-collapseThree">
                                    @if(session('locale')=='en')
                                        Thematic sections
                                    @elseif(session('locale')=='pt')
                                        Seções temáticas
                                    @else
                                        Secciones temáticas
                                    @endif
                                </button>
                            </h2>
                            <div id="flush-collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                <div class="row accordion-body pt-4">
                                    <div class="col-sm-6 col-md-6 col-lg-12 col-xl-6">
                                        <ol type="I">
                                            @if(session('locale')=='en')
                                                <li>Vegetation of the Oaxaca Valley</li>
                                                <li>Rock garden </li>
                                                <li>Medicinal plants</li>
                                                <li>Indigenous agriculture </li>
                                                <li>Orchards and plots </li>
                                                <li>Educational section</li>
                                                <li>Tropical rainforest </li>
                                            @elseif(session('locale')=='pt')
                                                <li>Vegetação do Vale de Oaxaca</li>
                                                <li>Jardim de pedras </li>
                                                <li>Plantas medicinais</li>
                                                <li>Agricultura indígena </li>
                                                <li>Pomares e parcelas</li>
                                                <li>Seção educacional</li>
                                                <li>Floresta tropical úmida </li>
                                            @else
                                                <li>Vegetación del valle de Oaxaca</li>
                                                <li>Jardín de rocas </li>
                                                <li>Plantas medicinales</li>
                                                <li>Agricultura indígena </li>
                                                <li>Huertos y solares </li>
                                                <li>Sección educativa</li>
                                                <li>Bosque tropical húmedo </li>
                                            @endif
                                        </ol>
                                    </div>
                                    <div class="col-sm-5 col-md-6 col-lg-12 col-xl-6">
                                        <ol type="I" start="8">
                                            @if(session('locale')=='en')
                                                <li>Mountain forest</li>
                                                <li>Plants of the arts</li>
                                                <li>Prickly pear forest</li>
                                                <li>Guilá Naquítz Vegetation</li>
                                                <li>Dry tropical forest</li>
                                                <li>Xerophilous scrubland</li>
                                                <li>Limestone zone</li>
                                            @elseif(session('locale')=='pt')
                                                <li>Floresta montanhosa</li>
                                                <li>Plantas das artes</li>
                                                <li>Floresta de figo das indias</li>
                                                <li>Vegetação do Guilá Naquítz</li>
                                                <li>Floresta tropical seca</li>
                                                <li>Esfoliante xerófilo</li>
                                                <li>Zona calcária</li>
                                            @else
                                                <li>Bosque de montaña</li>
                                                <li>Plantas de las artes</li>
                                                <li>Nopaleras</li>
                                                <li>Vegetación de Guilá Naquítz</li>
                                                <li>Bosque tropical seco</li>
                                                <li>Matorral Xerófilo</li>
                                                <li>Zona Caliza</li>
                                            @endif
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>





    <section class="lugares-sobresalientes py-5">
        <div class="container lugares pt-4">
            <!---------------------------------------------------------------------------------------->
            <!------------------------------- Patio el huaje ------------------------------->
            <div class="slide-container active">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">
                            @if(session('locale')=='en')
                                Huaje Courtyard and Blood Fountain of Mitla
                            @elseif(session('locale')=='pt')
                                Pátio del Huaje e Fonte do Sangue de Mitla
                            @else
                                Patio del Huaje y Fuente de la Sangre de Mitla
                            @endif
                        </h2>
                        {{-- <h3>
                            Patio del Huaje y Fuente de la Sangre de Mitla
                        </h3> --}}

                        @if(session('locale')=='en')
                            <p>Located on the street of Macedonio Alcalá, on the side of the former convent of Santo Domingo in what was the reading patio for Dominican novices,
                                The Patio "El Huaje" is a beautiful space designed by Maestro Francisco Toledo and planned as the entrance to the Garden.</p>
                            <p>Cover with red clay balconies presenting the important elements at its ends: a large tree of Huaje,
                                majestic legume that gives its name to the city of Oaxaca and the marvelous sculpture "La Sangre de Mitla", also the work of Maestro Toledo.</p>
                            <p>"La Sangre de Mitla", is a fountain made with a sabino tree covered in volcanic mica that bleeds with teñida water. red for shell money,
                                that runs over the Greeks that evoke the legendary city from which its name comes.</p>
                        @elseif(session('locale')=='pt')
                            <p>Ubicado sobre a rua de Macedonio Alcalá, um costado do ex convento de Santo Domingo no que fuera o pátio de palestras dos noviços dominicos,
                                el Patio "El Huaje" é um espaço lindo projetado pelo Maestro Francisco Toledo e que foi planejado como entrada do Jardín.</p>
                            <p>Cubierto con baldosas de lama vermelha apresenta dois elementos importantes em seus extremos: uma gran árvore "de Huaje",
                                majestosa leguminosa que dá seu nome à cidade de Oaxaca e a grandiosa escultura "La Sangre de Mitla" obra também do Maestro Toledo.</p>
                            <p>"La Sangre de Mitla", é uma fonte elaborada com árvore de sabino coberta de mica vulcânica que chora sangue de água tingido de vermelho pela grana conchinilla,
                                que corre sobre as grecas que evocam a lendária cidade de quem fornece seu nome.</p>
                        @else
                            <p>Ubicado sobre la calle de Macedonio Alcalá, a un costado del ex convento de Santo Domingo en lo que fuera el patio de lectura de novicios dominicos,
                                el Patio "El Huaje" es un hermoso espacio diseñado por el Maestro Francisco Toledo y que se planeó como entrada del Jardín.</p>
                            <p>Cubierto con baldosas de barro rojo presenta dos importantes elementos en sus extremos: un gran árbol del Huaje,
                                majestuosa leguminosa que da su nombre a la ciudad de Oaxaca y la grandiosa escultura "La Sangre de Mitla" obra también del Maestro Toledo.</p>
                            <p>"La Sangre de Mitla", es una fuente elaborada con árbol de sabino cubierto de mica volcánica que llora sangre de agua teñida de rojo por grana conchinilla,
                                que corre sobre las grecas que evocan a la legendaria ciudad de la que proviene su nombre.</p>
                        @endif

                    </div>

                    <div class="image">
                        <a href="imagenes/slider-4_mapa/img-01.jpg" data-fancybox="gallery4">
                            <img src="imagenes/slider-4_mapa/img-pre-01.jpg"
                                alt="Fuente la Sangre de Mitla en el Patio huaje">
                            <h4 class="w-100">
                                @if(session('locale')=='en')
                                @elseif(session('locale')=='pt')
                                @else
                                    Patio huaje | Foto: Ernesto de los Santos Reyes
                                @endif
                            </h4>
                        </a>
                    </div>
                </div>
            </div>
        {{--
            <div class="slide-container">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">
                            @if(session('locale')=='en')
                            @elseif(session('locale')=='pt')
                            @else
                                Atractivos <br> sobresalientes
                            @endif
                        </h2>
                        <h3>
                            @if(session('locale')=='en')
                            @elseif(session('locale')=='pt')
                            @else
                                Invernadero de cristal
                            @endif
                        </h3>
                        <p>
                            @if(session('locale')=='en')
                            @elseif(session('locale')=='pt')
                            @else
                                Conocido también como Pabellón Educativo de Orquídeas, es una estructura de 120 metros
                                cuadrados diseñada por el estudio FGP Atelier, encabezado por el arquitecto mexicano
                                Francisco Gonzáles Pulido. Este cuenta con dos cámaras al interior que regulan su
                                temperatura (templada y tropical) a través de un sistema geotermal, permitiendo así la
                                conservación de un amplio número de especies. La construcción es un ejemplo sobresaliente de
                                tecnología sustentable, ya que emplea tanto celdas solares, como válvulas de riego y
                                nebulizadores que funcionan gracias a una gran cisterna de agua pluvial.
                            @endif
                        </p>
                    </div>
                    <div class="image">
                        <a href="imagenes/slider-4_mapa/img-02.jpg" data-fancybox="gallery4">
                            <img src="imagenes/slider-4_mapa/img-pre-02.jpg" alt="Invernadero de cristal">
                            <h4 class="w-100">
                                @if(session('locale')=='en')
                                @elseif(session('locale')=='pt')
                                @else
                                    Invernadero de cristal | Foto: Ernesto de los Santos Reyes
                                @endif
                            </h4>
                        </a>
                    </div>
                </div>
            </div>
        --}}

            <!---------------------------------------------------------------------------------------->
            <!------------------------------- Espejo de Cuanana ------------------------------->
            <div class="slide-container">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">
                            @if(session('locale')=='en')
                                Cuanana Mirror
                            @elseif(session('locale')=='pt')
                               Espelho de Cuanana
                            @else
                                Espejo de Cuanana
                            @endif
                        </h2>


                            @if(session('locale')=='en')
                                <p>The Cuanana Mirror, is a sculptural drinking fountain for birds made by the Oaxaqueño sculptor Luis Zárate.</p>
                                <p>This work is located at the northern end of the garden and can be seen from the window in the garden located on the street of C. de Berriozábal.</p>
                            @elseif(session('locale')=='pt')
                                <p>O Espelho de Cuanana, é um bebedouro escultórico para aves realizado pelo escultor oaxaqueño Luis Zárate.</p>
                                <p>Esta obra se encontra no extremo norte do jardim e pode ser contemplada desde a janela do jardim que fica na rua de C. de Berriozábal.</p>
                            @else
                                <p>El Espejo de Cuanana, es un bebedero escultórico para aves realizada por el escultor oaxaqueño Luis Zárate.</p>
                                <p>Esta obra se encuentra en el extremo norte del jardín y puede ser contemplada desde la ventana al jardín que se ubica en la calle de C. de Berriozábal.</p>
                            @endif

                    </div>
                    <div class="image">
                        <a href="imagenes/slider-4_mapa/img-03.jpg" data-fancybox="gallery4">
                            <img src="imagenes/slider-4_mapa/img-pre-03.jpg"
                                alt="Escultura Espejo de Cuanana de Luis Zárate">
                            <h4 class="w-100">
                                @if(session('locale')=='en')
                                    Espejo de Cuanana | Photo: Ernesto de los Santos Reyes
                                @elseif(session('locale')=='pt')
                                    Espejo de Cuanana
                                    | Foto: Ernesto de los Santos Reyes
                                @else
                                    Espejo de Cuanana
                                    | Foto: Ernesto de los Santos Reyes
                                @endif
                            </h4>
                        </a>
                    </div>
                </div>
            </div>

            <!---------------------------------------------------------------------------------------->
            <!------------------------------- Escultura de Jorge Dubón ------------------------------->
            <div class="slide-container">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">
                            @if(session('locale')=='en')
                                Sculpture By Jorge Du Bón
                            @elseif(session('locale')=='pt')
                                Escultura de Jorge Du Bón
                            @else
                                Escultura de Jorge Du Bón
                            @endif
                        </h2>
                        @if(session('locale')=='en')
                            <p>This monumental sculpture made of Ahuehuete wood was created by him
                                Chiapaneco sculptor Jorge Du Bon is located at the gate near the Jardín.</p>
                        @elseif(session('locale')=='pt')
                            <p>Esta escultura monumental realizada na madeira de Ahuehuete, foi realizada por el
                                Escultor Chiapaneco Jorge Du Bon e se encontra localizado na porta do Jardín.</p>
                        @else
                            <p>Esta escultura monumental realizada en madera de Ahuehuete, fue realizada por el
                                escultor chiapaneco Jorge Du Bon y se encuentra ubicado en la puerta sur del Jardín.</p>
                        @endif

                    </div>
                    <div class="image">
                        <a href="imagenes/slider-4_mapa/img-03.jpg" data-fancybox="gallery4">
                            <img src="imagenes/slider-4_mapa/img-pre-04.jpg"
                                alt="Escultura Espejo de Cuanana de Luis Zárate">
                            <h4 class="w-100">
                                @if(session('locale')=='en')
                                @elseif(session('locale')=='pt')
                                @else
                                    Escultura de Jorge Dubón | Foto:
                                @endif
                            </h4>
                        </a>
                    </div>
                </div>
            </div>

             <!---------------------------------------------------------------------------------------->
            <!------------------------------- Cruz de maíz ------------------------------->
            <div class="slide-container">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">
                            @if(session('locale')=='en')
                                Corn Cross
                            @elseif(session('locale')=='pt')
                                Cruz do Milho
                            @else
                                Cruz del Maíz
                            @endif
                        </h2>

                        @if(session('locale')=='en')
                            <p>Located in its geographic center and considered one of the most important spaces in the Garden,
                                la Cruz de Maíz holds and guards what has been considered the unifying element
                                of Mesoamerican culture and identity, the maíz and their direct ancestors, Tripsacum and the Teocintle</p>
                            <p>With their broken paths and beautiful Greek Mixtecs, the ancestors of the maize, are surrounded by their
                                eternal companions: calabazas, chiles, frijoles, amaranths and quelites, as well as many other species,
                                that can be enjoyed in this garden space.</p>
                        @elseif(session('locale')=='pt')
                            <p>Localizado no seu centro geográfico e considerado como um dos espaços mais importantes do Jardim,
                                a Cruz do milho enarbola e guarda o que é considerado como o elemento unificador
                                da cultura e identidade mesoamericana, o milho e seus ancestrais diretos, Tripsacum y o Teocintle</p>
                            <p>Com suas estradas quebradas e belas rendas mixtecas, os ancestrais do milho, cercam-se de seus
                                companheiros eternos: abóboras, pimentas, feijões, amarantos e quelites, além de muitas outras espécies,
                                que pode ser apreciado neste espaço ajardinado.</p>
                        @else
                            <p>Ubicado en su centro geográfico y considerado como uno de los espacios más importantes del Jardín,
                                la Cruz de Maíz enarbola y custodia lo que se ha considerado como el elemento unificador
                                de la cultura e identidad mesoamericana, el maíz y sus ancestros directos, Tripsacum y el Teocintle</p>
                            <p>Con sus caminos quebrados y hermosas greca Mixtecas, los ancestros del maíz, se rodean de sus
                                eternos acompañantes: calabazas, chiles, frijoles, amarantos y quelites, así como de muchas otras especies,
                                que pueden ser apreciadas en este espacio del jardín.</p>
                        @endif

                    </div>
                    <div class="image">
                        <a href="imagenes/slider-4_mapa/img-03.jpg" data-fancybox="gallery4">
                            <img src="imagenes/slider-4_mapa/img-pre-04.jpg"
                                alt="Escultura Espejo de Cuanana de Luis Zárate">
                            <h4 class="w-100">
                                @if(session('locale')=='en')
                                @elseif(session('locale')=='pt')
                                @else
                                    La cruz del maíz | Foto:
                                @endif
                            </h4>
                        </a>
                    </div>
                </div>
            </div>

            <!---------------------------------------------------------------------------------------->
            <!------------------------------- Hornos de cal ------------------------------->
            <div class="slide-container">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">
                            @if(session('locale')=='en')
                                Lime kilns
                            @elseif(session('locale')=='pt')
                                Fornos de cal
                            @else
                                Hornos de cal
                            @endif
                        </h2>

                        @if(session('locale')=='en')
                            <p>In the archaeological rescue process carried out during the construction of the Garden in 1994,
                                whether they were hallaron of the horns of lime or caleras that are estimated to have been
                                built prior to the construction of the convent in 1570, which could have been used
                                for the elaboration of mortar used in its construction.</p>
                            <p>This space consists of two large horns where betrayed lime stone is introduced
                                from the hill of San Antonio de la Cal and which was calcined at high temperatures using large
                                cantities of wood until forming the so-called quicklime, which was erased with water from adyacent piles
                                to form the mortar.</p>
                            <p>In this space, you will be able to observe species that grow on limestone rocks like the beautiful <i>Agave guiengola</i>,
                                Soy palms, jars, sotolines, gallinites and other plants.</p>
                        @elseif(session('locale')=='pt')
                            <p>No processo de resgate de ruínas realizado durante a construção do Jardim em 1994,
                                foram encontrados dos chifres de cal o caleras que se estima deve ter sido
                                construído anteriormente à edificação do convento em 1570, e que poderia ter sido usado
                                para a elaboração de morteiro utilizado em sua construção.</p>
                            <p>Este espaço consta de dois grandes chifres nos que se introduzem a pedra caliza que se trouxe
                                do cerro de San Antonio de la Cal e que se calcina a altas temperaturas usando grandes
                                cantidades de leña até formar a chamada cal viva, que foi apagada com água das pilhas adiacentes
                                para formar o mortero.</p>
                            <p>Neste espaço, você poderá observar espécies que crescem sobre roca caliza como o lindo <i>Agave guiengola</i>,
                                a palma de soyate, las jarrillas, los sotolines, las gallinitas y otras plantas.</p>
                        @else
                            <p>En el proceso de rescate arqueológico realizado durante la construcción del Jardín en 1994,
                                se hallaron dos hornos de cal o caleras que se estima debieron haber sido
                                construidos previo a la edificación del convento en 1570, ya que pudieron haber sido utilizados
                                para la elaboración de mortero utilizado en su construcción.</p>
                            <p>Este espacio consta de dos grandes hornos en los que se introducía piedra caliza traída
                                desde el cerro de San Antonio de la Cal y que se calcinaba a altas temperaturas usando grandes
                                cantidades de leña hasta formar la llamada cal viva, que era apagada con agua de las piletas adyacentes
                                para formar el mortero.</p>
                            <p>En este espacio, podrás observar especies que crecen sobre roca caliza como el hermoso <i>Agave guiengola</i>,
                                las palmas de soyate, las jarrillas, los sotolines, las gallinitas y otras plantas.</p>
                        @endif

                    </div>
                    <div class="image">
                        <a href="imagenes/slider-4_mapa/img-03.jpg" data-fancybox="gallery4">
                            <img src="imagenes/slider-4_mapa/img-pre-04.jpg"
                                alt="Escultura Espejo de Cuanana de Luis Zárate">
                            <h4 class="w-100">
                                @if(session('locale')=='en')
                                @elseif(session('locale')=='pt')
                                @else
                                    Hornos de cal | Foto:
                                @endif
                            </h4>
                        </a>
                    </div>
                </div>
            </div>

            <!---------------------------------------------------------------------------------------->
            <!------------------------------- Hornnos de cerámica ------------------------------->
            <div class="slide-container">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">
                            @if(session('locale')=='en')
                                Ceramic oven
                            @elseif(session('locale')=='pt')
                                Forno de cerâmica
                            @else
                                Horno de cerámica
                            @endif
                        </h2>

                            @if(session('locale')=='en')
                                <p>This horn was found during the archaeological rescue during the construction of the Botanical Garden
                                    in 1994 along with several ties (pieces) of Mayolic ceramics.</p>
                                <p>Mayolica is a glazed ceramic with brilliant colors created by ancient Egyptians and Babylonians
                                    and that reaches us thanks to the Islamic civilization that took place in the south of Spain, from where it reached Oaxaca.</p>
                                <p> In the judgment of archaeologists, there is evidence to consider that this horn could also have been used
                                    to make clay partitions used in the bovedas of Santo Domingo.</p>
                                <p> This complex colonial craftsmanship machinery is accompanied by species related
                                    with the arts of Oaxaca, such as coyuchi and ixtle cotton fibers, as well as their natural colorants:
                                    the money cochinilla in the nopal, the añil, the ink hoja, the organ, the cuautle, among others.</p>
                            @elseif(session('locale')=='pt')
                                <p>Este chifre foi encontrado no resgate arqueológico durante a construção do Jardim Botânico
                                    em 1994 junto com diversos tietes (pedazos) de cerâmica mayólica.</p>
                                <p>A mayólica é uma cerâmica vitrificada com cores brilhantes criada pelos antigos egípcios e babilônios
                                    e que nos trouxe graças à civilização islâmica que chegou ao sul da Espanha, de onde chegou a Oaxaca.</p>
                                <p> A juicio dos arqueólogos, há evidências para considerar que este chifre também pode ter sido utilizado
                                    para fazer tijolos usadas nas bóvedas do Santo Domingo.</p>
                                <p> esta complexa maquinaria de arte em cerâmica colonial, está acompanhada de espécies relacionadas
                                    com as artes de Oaxaca, como as fibras de algodão "coyuchi" e o ixtle, assim como seus corantes naturais:
                                    a grana cochinilla no nopal, o añil, a hoja de tinta, o órgão, o cuautle, entre outros.</p>
                            @else
                                <p>Este horno fue hayado en el rescate arqueológico durante la construcción del Jardín Botánico
                                    en 1994 junto con diversos tiestos (pedazos) de cerámica mayólica.</p>
                                <p>La mayólica es una cerámica vidriada con colores brillantes creada por los angiguos ejipcios y babilonios
                                    y que llega a nosotros gracias a la civilización islámica que la llevó al sur de España, desde donde llegó a Oaxaca.</p>
                                <p> A juicio de los arqueólogos, existe evidencia para considerar que este horno también pudo haber sido utilizado
                                    para hacer tabiques de barro utilizados en las bóvedas de Santo Domingo.</p>
                                <p> Esta compleja maquinaria del arte de alfarería colonial, está acompañada de especies relacionadas
                                    con las artes de Oaxaca, como las fibras de algodón coyuchi e ixtle,  así como de sus colorantes naturales:
                                    la grana cochinilla en el nopal, el añil, la hoja de tinta, el órgano, el cuautle, entre otros.</p>
                            @endif

                    </div>
                    <div class="image">
                        <a href="imagenes/slider-4_mapa/img-03.jpg" data-fancybox="gallery4">
                            <img src="imagenes/slider-4_mapa/img-pre-04.jpg"
                                alt="Escultura Espejo de Cuanana de Luis Zárate">
                            <h4 class="w-100">
                                @if(session('locale')=='en')
                                @elseif(session('locale')=='pt')
                                @else
                                    Hornos de cerámica | Foto:
                                @endif
                            </h4>
                        </a>
                    </div>
                </div>
            </div>


            <!---------------------------------------------------------------------------------------->
            <!------------------------------- Lavaderos ------------------------------->
            <div class="slide-container">
                <div class="slide">
                    <div class="content">
                        <h2 class="subtitulo">
                            @if(session('locale')=='en')
                                The Washing place
                            @elseif(session('locale')=='pt')
                                Os Lavaderos
                            @else
                                Los Lavaderos
                            @endif
                        </h2>

                        @if(session('locale')=='en')
                            <p>During the archaeological recovery, in the northern part of the Garden, next to what was the reading patio of the Dominican novices,
                                three small brick ponds were unearthed where the novices washed their clothes, a stone pond and a round basin covered with Talavera tiles from Puebla
                                where the novices bathed.</p>

                            <p style="padding-left:3rem;"><i>"...then at the end of the dormitory (of the novitiate) there is a passage by a staircase to a large,
                                very spacious patio where there is a very wide water pond, and in front a stable, where there are large washbasins
                                a yard high like tables and basins to overflow the water, and wash
                                the habits and other clothes..."</i>
                                <br>
                                Fray Francisco de Burgoa, XVII century"</p>
                            <p>In this space we can find species traditionally used as soap in Oaxaca such as pipe (<i>Sapindus saponaria</i>)
                                or the bark of the tlapacone (<i>Fouquieria formosa</i>).</p>
                        @elseif(session('locale')=='pt')
                            <p>Durante a recuperação arqueológica, na parte norte do Jardim, de um lado do que era o pátio de leitura dos noviços dominicos,
                                Foram desenterrados três pequenos lagoas de tijolos onde os noviços lavavam a roupa, um lago de pedra e uma bacia redonda coberta com telhas de Talavera de Puebla.
                                onde os noviços se banhavam.</p>

                            <p style="padding-left:3rem;"><i>"...então no final do dormitório (do noviciado) há uma passagem por uma escada que leva a um pátio
                                grande e muito espaçoso onde há uma grande piscina de água
                                de largura, e na frente um bloco, onde há grandes lavatórios de
                                uma vara tão alta quanto mesas e bacias para transbordar a água e lavar
                                hábitos e outras roupas..."</i>
                                <br>
                                Frei Francisco de Burgoa, século XVII"</p>
                            <p>Neste espaço podemos encontrar espécies tradicionalmente utilizadas como sabão em Oaxaca, como o pipe (<i>Sapindus saponaria</i>)
                                ou a casca do tlapacone (<i>Fouquieria formosa</i>).</p>
                        @else
                            <p>Durante la recuperación arqueológica, en la parte norte del Jardín, a un costado de lo que fuera el patio de lectura de los novicios dominicos,
                                se desenterraron tres estanques pequeños de ladrillo donde los novicios lavaban su ropa, un estanque de piedra y una pila redonda revestida de azulejo de talavera de Puebla
                                donde los novicios se bañaban.</p>

                            <p style="padding-left:3rem;"><i>"...luego en el fin del dormitorio (del noviciado) hay un paso por una escalera a un patio
                                grande, y muy espacioso donde está un estanque de agua muy
                                anchuroso, y enfrente una cuadra, donde hay lavatorios grandes de
                                una vara de altos como mesas y pilas para rebalsar el agua, y lavar
                                los hábitos y demás ropa..."</i>
                                <br>
                                Fray Francisco de Burgoa, S. XVII"</p>
                            <p>En este espacio podemos encontrar especies utilizadas tradicionalmente como jabón en Oaxaca como el pipe (<i>Sapindus saponaria</i>)
                                o la corteza del tlapacone (<i>Fouquieria formosa</i>).</p>
                        @endif

                    </div>
                    <div class="image">
                        <a href="imagenes/slider-4_mapa/img-03.jpg" data-fancybox="gallery4">
                            <img src="imagenes/slider-4_mapa/img-pre-04.jpg"
                                alt="Escultura Espejo de Cuanana de Luis Zárate">
                            <h4 class="w-100">
                                @if(session('locale')=='en')
                                @elseif(session('locale')=='pt')
                                @else
                                    Lavaderos | Foto:
                                @endif
                            </h4>
                        </a>
                    </div>
                </div>
            </div>



            <div id="prev" onclick="prev()" class="button-prev"> </div>
            <div id="next" onclick="next()" class="button-next"> </div>

        </div>

    </section>





@section('scripts')
    <!--- ----------------- 2 ---------------------->
    <!--slider lugares sobresalientes-->
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
</div>
