@section('title')
Recorridos en el Jardín
@endsection

@section('meta-description')
¿Listo para visitarnos? Conoce los horarios de nuestros recorridos diarios y todo lo que tenemos para ofrecerte.
@endsection

@section('banner')
banner-recorridos
@endsection

@section('banner-title')
    @if(session('locale')=='en')
        Plan <br>your visit
    @elseif(session('locale')=='pt')
        Planeje <br>sua visita
    @elseif(session('locale')=='es_mix_bj')
        Ndasa ndúví<br> ún ra kixi ún
        <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','0')"></i>
        <audio controls  id="sale_audio0" style="display:none;">
            <source src="audio/es_mix_bj/02_recorrido_00.ogg" type="audio/ogg">
        </audio>
    @else
        Planea<br>tu visita
    @endif
@endsection

<div>

    <!--S1 VISITAS-->
    <section class="visitas pt-4">
        <div class="container px-4 py-5" id="bienvenido">
            <div>
                @include('plantillas/plant_locale')
            </div>

            <div class="row justify-content-around text-center pb-4">
                <div class="col-sm-12 col-md-9 col-lg-9 col-xl-8 pt-5 px-4">
                    <h2 class="subtitulo">
                        @if(session('locale')=='en')
                            Guided tours
                        @elseif(session('locale')=='pt')
                            Visitas guiadas
                        @elseif(session('locale')=='es_mix_bj')
                            Ña kuvi kèe ndó kotondi’é ndó
                            <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','1')"></i>
                            <audio controls  id="sale_audio1" style="display:none;">
                                <source src="audio/es_mix_bj/02_recorrido_01.ogg" type="audio/ogg">
                            </audio>
                        @else
                            Visitas guiadas
                        @endif
                    </h2>
                    {{--
                    <p class="texto-principal">
                        @if(session('locale')=='en')
                            We appreciate your interest in the Garden and our work.
                            For the safety of visitors and plants, the Garden can only be visited on guided tours.
                            We do not have reservations or advance ticket sales.
                        @elseif(session('locale')=='pt')
                            Agradecemos o seu interesse pelo Jardim e pelo nosso trabalho.
                            Para segurança dos visitantes e das plantas, o Jardim só pode ser visitado em visitas guiadas.
                            Não temos reservas nem venda antecipada de ingressos.
                        @elseif(session('locale')=='es_mix_bj')
                            Tíxà’vi ndó vàxi ndó jardîn yó’o saá táxi ndó ndieé nda’á na jardín yó’o xí’ín tyiñu ké’én na.
                            Ñà ná kòó tàxìn ndó án ndiáa ñà kundo’o ndó saá tu itún kuálí iyo yó’o ná kòó kundivà’a nú,
                            xà’á ña yó’o, íyo iin na ìví kunúú nùú ndó kù’ùn ndó. Saá, ndátú’ún tu na xí’ín ndó, mí kìví kuàkèe
                            ndó jardîn yó’o mí kìví yó’o tyá’vi ndó, kòó xíni ñú’ú tya’vi yàtyì ndó.
                            <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','2')"></i>
                            <audio controls  id="sale_audio2" style="display:none;">
                                <source src="audio/es_mix_bj/02_recorrido_02.ogg" type="audio/ogg">
                            </audio>
                        @else
                            Agradecemos tu interés por el Jardín y por nuestro trabajo.
                            Por seguridad de los visitantes y de las plantas, el Jardín sólo puede ser visitado en recorridos guiados.
                            No contamos con reservaciones  ni venta de boletos con anticipación
                        @endif
                    </p>
                    --}}
                    @if(session('locale')=='en')
                        <p class="texto-principal">
                            Derived from the Decree published in the Extra of the Periódico Oficial, del Gobierno del Estado del Poder Ejecutivo del Estado de Oaxaca
                            on February 28, 2025, which reads:
                        </p>
                        <p class="texto-principal" style="border:1px solid black;">
                            <b>Sole</b>. The Oaxaca Ethnobotanical Garden is hereby dissolved as a Decentralized Body of the Secretariat of Administration.
                        </p>
                        <p class="texto-principal">
                            And derived from the similar document published in the same media on March 3, 2025, which states:
                        </p>
                        <p class="texto-principal">
                            <b>Article 3</b>: The purpose of the Oficina de Convencines, Congresos y Eventos de Oaxaca "OCCE Oaxaca"
                            is to advise, develop, and encourage plans, programs, and actions implemented to promote the State of Oaxaca in the field of tourism activities for meetings and romance at the international and national level, <br>
                            as well as the traditional and scientific knowledge of the Oaxacan flora.
                        </p>
                        <p>Please refer to <a href="https://www.oaxaca.gob.mx/occe/">said office</a> for any matters related to tourist or school tours.</p>

                    @elseif(session('locale')=='pt')
                        <p class="main-text">
                            Decorrente do Decreto publicado no Extra do Periódico Oficial del Gobierno del Estado del Poder Ejecutivo del Estado de Oaxaca
                            em 28 de fevereiro de 2025, que dispõe:
                        </p>
                        <p class="main-text" style="border:1px solid black;">
                            <b>Único</b>. O Jardim Etnobotânico de Oaxaca fica extinto como Órgão Descentralizado da Secretaria de Administração.

                        </p>
                        <p class="main-text">
                            E derivado de documento similar publicado na mesma mídia em 3 de março de 2025, que declara:
                        </p>
                        <p class="main-text">
                            <b>Artigo 3</b>: O Oficina de Convenciones, Congresos y Eventos de Oaxaca "OCCE Oaxaca" tem como objetivo assessorar, desenvolver e incentivar planos, programas e ações implementados para promover o Estado de Oaxaca no campo das atividades turísticas para reuniões e romance em nível internacional e nacional, <br>
                            bem como o conhecimento tradicional e científico da flora oaxaca.
                        </p>
                            <p>Consulte o <a href="https://www.oaxaca.gob.mx/occe/">referido escritório</a> para quaisquer questões relacionadas a passeios turísticos ou escolares.</p>
                    @else
                        <p class="texto-principal">
                            Derivado del <a href="https://jardinoaxaca.mx/imagenes/250228_DiarioOficialOaxaca_Jardin.pdf" target="new" class="nolink">Decreto publicado en el Extra Periódico Oficial, del Gobierno del Estado del Poder Ejecutivo del Estado de Oaxaca
                            el 28 de febrero de 2025</a>    , que a la letra dice:
                        </p>
                        <p class="texto-principal" style="border:1px solid black;">
                            <b>Único</b>. Se extingue el Jardín Etnobotánico de Oaxaca como Órgano Desconcentrado de la Secretaría de Administración.
                        </p>
                        <p class="texto-principal">
                            Y derivado del similar publicado en el <a href="https://jardinoaxaca.mx/imagenes/250303_DiarioOficialOaxaca_occe.pdf" target="new" class="nolink">mismo medio con fecha 3 de marzo de 2025</a>, que dice:
                        </p>
                        <p class="texto-principal">
                            <b>Artículo 3</b>: El objeto de la Oficina de Convenciones, Congresos y Eventos de Oaxaca "OCCE Oaxaca"
                            es asesorar, desarrollar e incentivar los planes progamas y acciones que se instrumenten para la promoción del Estado de Oaxaca en el ramo de la actividad
                            turística de reuniones y romance en el ámbito internacional o nacional, <br>
                            así como del conocimiento tradicional y científico de la flora oaxaqueña.
                        </p>
                        <p>Favor de remitirse a <a href="https://www.oaxaca.gob.mx/occe/">dicha oficina</a> para cualquier asunto relacionado a recorridos turísticos o escolares</p>
                    @endif
                </div>
            </div>

            {{--
            <div class="row justify-content-center text-center pt-4 pb-5">
                <div class="col-sm-12 col-md-auto pb-5">
                    <a href="#horarios" class="horarios">
                        @if(session('locale')=='en')
                            Schedules
                        @elseif(session('locale')=='pt')
                            Horários
                        @elseif(session('locale')=='es_mix_bj')
                            Ora kuvi kèe ndó
                        @else
                            Horarios
                        @endif
                    </a>
                    @if(session('locale')=='es_mix_bj')
                        <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','3')" style="color:#64383E"></i>
                        <audio controls  id="sale_audio3" style="display:none;">
                            <source src="audio/es_mix_bj/02_recorrido_03.ogg" type="audio/ogg">
                        </audio>
                    @endif
                </div>
                <div class="col-sm-12 col-md-auto">
                    <a href="#escolares" class="escolares">
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

            <div class="row justify-content-center galeria-recorridos py-4">
                <div class="col-sm-12 col-lg-9 ">
                    <div class=" owl-carousel owl-theme">
                        <div>
                            <a href="imagenes/slider-2_recorridos/img-01.jpg" data-fancybox="gallery1">
                                <img src="imagenes/slider-2_recorridos/img-pre-01.jpg" alt="Fachada del jardin">
                                <h3 class="w-100">
                                    @if(session('locale')=='en')
                                        Entrance to the Ethnobotanical Garden of Oaxaca |
                                        Photo: Ernesto de los Santos Reyes
                                    @elseif(session('locale')=='pt')
                                        Entrada no Jardim Etnobotânico de Oaxaca |
                                        Foto: Ernesto de los Santos Reyes
                                    @elseif(session('locale')=='es_mix_bj')
                                        Entrada del Jardín Etnobotánico de Oaxaca |
                                        Foto: Ernesto de los Santos Reyes
                                    @else
                                        Entrada del Jardín Etnobotánico de Oaxaca |
                                        Foto: Ernesto de los Santos Reyes
                                    @endif
                                </h3>
                            </a>
                        </div>
                        <div>
                            <a href="imagenes/slider-2_recorridos/img-02.jpg" data-fancybox="gallery1">
                                <img src="imagenes/slider-2_recorridos/img-pre-02.jpg" alt="Inicio de recorrido">
                                <h3 class="w-100">
                                    @if(session('locale')=='en')
                                        Tours National Botanical Gardens Day |
                                        Photo: Alma Pérez Bautista
                                    @elseif(session('locale')=='pt')
                                        Passeios de um dia no Jardim Botânico Nacional |
                                        Foto de : Alma Pérez Bautista
                                    @elseif(session('locale')=='es_mix_bj')
                                        Entrada del Jardín Etnobotánico de Oaxaca |
                                        Foto: Ernesto de los Santos Reyes
                                    @else
                                        Recorridos Día Nacional de los Jardínes Botánicos |
                                        Foto: Alma Pérez Bautista
                                    @endif
                                </h3>
                            </a>
                        </div>
                        <div>
                            <a href="imagenes/slider-2_recorridos/img-03.jpg" data-fancybox="gallery1">
                                <img src="imagenes/slider-2_recorridos/img-pre-03.jpg" alt="Vegetación del jardin">
                                <h3 class="w-100">
                                    @if(session('locale')=='en')
                                        Exploring the Garden, guided tour |
                                        Photo: Ernesto de los Santos Reyes
                                    @elseif(session('locale')=='pt')
                                        Exploração do Jardim, visita guiada |
                                        Foto: Ernesto de los Santos Reyes
                                    @elseif(session('locale')=='es_mix_bj')
                                        Entrada del Jardín Etnobotánico de Oaxaca |
                                        Foto: Ernesto de los Santos Reyes
                                    @else
                                        Explorando el Jardín, recorrido guiado |
                                        Foto: Ernesto de los Santos Reyes
                                    @endif
                                </h3>
                            </a>
                        </div>
                        <div>
                            <a href="imagenes/slider-2_recorridos/img-04.jpg" data-fancybox="gallery1">
                                <img src="imagenes/slider-2_recorridos/img-pre-04.jpg" alt="Visitantes cerca del espejo de agua">
                                <h3 class="w-100">
                                    @if(session('locale')=='en')
                                        Tour on National Day of Botanical Gardens |
                                        Photo: Alma Pérez Bautista
                                    @elseif(session('locale')=='pt')
                                        Tour no Dia do Jardim Botânico Nacional |
                                        Foto de : Alma Pérez Bautista
                                    @elseif(session('locale')=='es_mix_bj')
                                        Entrada del Jardín Etnobotánico de Oaxaca |
                                        Foto: Ernesto de los Santos Reyes
                                    @else
                                        Recorrido en el Día Nacional de los Jardínes Botnánicos |
                                        Foto: Alma Pérez Bautista
                                    @endif
                                </h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            --}}
        </div>
    </section>

    <!--S2 RECORRIDOS-->
    {{-- <section class="recorridos" id="horarios">
        <div class="container pb-5">
            <div class="row justify-content-between py-5 px-4">
                <div class="col-md-12 col-xl-6 info-horarios">
                    <div class="row idiomas">
                        <!-- --------------------------------------------------------------- -->
                        <!-- ----------------- Horarios de Recorridos ---------------------- -->
                        <div class="col">
                            <div class="row justify-content-center">
                                <div class="col-lg-10 col-xl-12">
                                    <h2 class="subtitulo">
                                        @if(session('locale')=='en')
                                            Schedules
                                        @elseif(session('locale')=='pt')
                                            Horários
                                           @elseif(session('locale')=='es_mix_bj')
                                            Ora kuvi kèe ndó
                                            <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','5')"></i>
                                            <audio controls  id="sale_audio5" style="display:none;">
                                                <source src="audio/es_mix_bj/02_recorrido_05.ogg" type="audio/ogg">
                                            </audio>
                                        @else
                                            Horarios
                                        @endif
                                    </h2>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-6 pt-4">
                                    @if(session('locale')=='en')
                                        <h3>Guided tours in Spanish</h3>
                                        <h4>Duration: 1 hour</h4>
                                        <p>Monday - Friday<br>10:30, 11:00, 11:30, 12:00 and 17:00 hours</p>

                                        <p>At the moment we only offer tours in Spanish</p>
                                    @elseif(session('locale')=='pt')
                                        <h3>Visitas guiadas em espanhol</h3>
                                        <h4>Duração: 1 hora</h4>
                                        <p>Segunda a sexta<br>10:30h, 11:00h, 11:30h, 12:00h e 17h</p>

                                        <p>No momento oferecemos passeios apenas em espanhol</p>
                                    @elseif(session('locale')=='es_mix_bj')
                                        <h3>ñà kèe ndó ra koo iin na kunúú kù’ùn xí’ín ndó
                                            <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','6')"></i>
                                            <audio controls  id="sale_audio6" style="display:none;">
                                                <source src="audio/es_mix_bj/02_recorrido_06.ogg" type="audio/ogg">
                                            </audio>
                                        </h3>
                                        <h4>Iin ora kúú ña kuátyìndó kuñu’u ndó
                                            <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','7')"></i>
                                            <audio controls  id="sale_audio7" style="display:none;">
                                                <source src="audio/es_mix_bj/02_recorrido_07.ogg" type="audio/ogg">
                                            </audio>
                                        </h4>
                                        <p>Lúne saá ndià viérne <br>10:30h, 11:00h, 11:30h, 12:00h, 17:00h<!--kàa ùxì, kàa ùxì iin, kàa xuvì xí’ín kàa ù’ùn xìkuaá-->
                                            <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','8')"></i>
                                            <audio controls  id="sale_audio8" style="display:none;">
                                                <source src="audio/es_mix_bj/02_recorrido_08.ogg" type="audio/ogg">
                                            </audio>
                                        </p>
                                            <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','9')"></i>
                                            <audio controls  id="sale_audio9" style="display:none;">
                                                <source src="audio/es_mix_bj/02_recorrido_09.ogg" type="audio/ogg">
                                            </audio>
                                        </p>
                                        <p>Vityin ra, kuití tù’un sá’án kúú na ndákani na nùú ndó, kòó ka inka tù’un
                                            <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','10')"></i>
                                            <audio controls  id="sale_audio10" style="display:none;">
                                                <source src="audio/es_mix_bj/02_recorrido_10.ogg" type="audio/ogg">
                                            </audio>
                                        </p>

                                    @else
                                        <h3>Recorridos guiados</h3>
                                        <h4>Duración: 1 hora</h4>
                                        <p>Lunes - viernes<br>10:30, 11:00, 11:30, 12:00 y 17:00 horas</p>

                                        <p>Por el momento, los recorridos solo son en español</p>

                                    @endif

                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-6 py-4">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row entradas pt-3">
                        <div class="col">
                            <div class="row justify-content-center">
                                <div class="col-lg-10 col-xl-12">
                                    <h2 class="subtitulo">
                                        @if(session('locale')=='en')
                                            Tickets
                                        @elseif(session('locale')=='pt')
                                            Ingressos
                                        @elseif(session('locale')=='es_mix_bj')
                                            Ñà tyá’vi ndó
                                            <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','11')"></i>
                                            <audio controls  id="sale_audio11" style="display:none;">
                                                <source src="audio/es_mix_bj/02_recorrido_11.ogg" type="audio/ogg">
                                            </audio>
                                        @else
                                            Entradas
                                        @endif
                                    </h2>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-6  pt-4">
                                    @if(session('locale')=='en')
                                        <h3>Guided tours (in Spanish)</h3>
                                        <p>Adults - $50.00 pesos</p>
                                        <p>Children from 0 to 12 years old - Free</p>
                                        <p>Students, teachers, senior citizens - Free <br>(With Mexican ID)</p>
                                        <p>People with disabilities - Free <br>(With Mexican ID)</p>
                                    @elseif(session('locale')=='pt')
                                        <h3>Visitas guiadas (em espanhol)</h3>
                                        <p>Adultos - US$ 50,00 pesos</p>
                                        <p>Crianças de 0 a 12 anos, - Grátis</p>
                                        <p>Estudantes, professores, idosos - Gratuito <br>(com credencial mexicana)</p>
                                        <p>Pessoas com deficiência - Gratuito<br>(Com credencial mexicana)</p>
                                    @elseif(session('locale')=='es_mix_bj')
                                        <h3>Ñà kèe ndó ra koo iin na kunúú kù’ùn xí’ín ndó
                                            <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','12')"></i>
                                            <audio controls  id="sale_audio12" style="display:none;">
                                                <source src="audio/es_mix_bj/02_recorrido_12.ogg" type="audio/ogg">
                                            </audio>
                                        </h3>
                                        <p>Ùvì xiko ùxì tyá’vi na ná’nu
                                            <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','13')"></i>
                                            <audio controls  id="sale_audio13" style="display:none;">
                                                <source src="audio/es_mix_bj/02_recorrido_13.ogg" type="audio/ogg">
                                            </audio>
                                        </p>
                                        <p>Kî’vi uun nà kuǎlí, nà sakán kāku iin saá ndià ùxì ùvì kuìyà.
                                            <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','14')"></i>
                                            <audio controls  id="sale_audio14" style="display:none;">
                                                <source src="audio/es_mix_bj/02_recorrido_14.ogg" type="audio/ogg">
                                            </audio>
                                        </p>
                                        <p>Nà ká’vi, nà sáñà’à xí’ín nà xìkuà’á kî’vi uun tu na kán va (xíni ñú’ú kuni’i na nǎ’na ñà
                                            ká’àn xà’á na kúú na na Ñuu kǒ’yo ká’nu).
                                            <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','15')"></i>
                                            <audio controls  id="sale_audio15" style="display:none;">
                                                <source src="audio/es_mix_bj/02_recorrido_15.ogg" type="audio/ogg">
                                            </audio>
                                        </p>
                                        <p>Nà kû’vì, nà kǔvi kaka, nà tǔvi nùú kî’vi uun tu na kán va (xíni ñú’ú kuni’i na nǎ’na ñà
                                            ká’àn xà’á na kúú na na Ñuu kǒ’yo ká’nu).
                                            <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','16')"></i>
                                            <audio controls  id="sale_audio16" style="display:none;">
                                                <source src="audio/es_mix_bj/02_recorrido_16.ogg" type="audio/ogg">
                                            </audio>
                                        </p>
                                    @else
                                        <h3>Recorridos guiados</h3>
                                        <p>Adultos - $50.00 pesos</p>
                                        <p>Niños de 0 a 12 años, - Gratis</p>
                                        <p>Estudiantes, maestros personas de la tercera edad - Gratis <br>(Con credencial mexicana)</p>
                                        <p>Personas con alguna discapacidad - Gratis<br>(Con credencial mexicana)</p>
                                    @endif
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-5 col-xl-6 py-4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xl-5 info-ubicacion">
                    <div class="row mapa">
                        <div class="col-sm-12">
                            <div class="row justify-content-center">
                                <div class="col-lg-10 col-xl-12">
                                    <h2 class="subtitulo">
                                        @if(session('locale')=='en')
                                            Location
                                        @elseif(session('locale')=='pt')
                                            Localização
                                        @elseif(session('locale')=='es_mix_bj')
                                            Nùú ndíkàà jardîn yó’o
                                            <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','17')"></i>
                                            <audio controls  id="sale_audio17" style="display:none;">
                                                <source src="audio/es_mix_bj/02_recorrido_17.ogg" type="audio/ogg">
                                            </audio>
                                        @else
                                            Ubicación
                                        @endif
                                    </h2>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-sm-12 col-md-10 col-lg-8 col-xl-10 col-xxl-9  py-4">
                                    <!-- el archivo marca error con width al 100%, pero no tiene problema en línea-->
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15256.577332703622!2d-96.7219608!3d17.0655913!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85c722394784bab5%3A0x2dd18b7042b6eabe!2sJard%C3%ADn%20Etnobot%C3%A1nico%20de%20Oaxaca!5e0!3m2!1ses-419!2smx!4v1690404367563!5m2!1ses-419!2smx"
                                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center info-preguntas pt-3">
                        <div class="col-lg-10 col-xl-12">
                            <h3>
                                @if(session('locale')=='en')
                                    Frequently Asked Questions
                                @elseif(session('locale')=='pt')
                                    Perguntas frequentes
                                @elseif(session('locale')=='es_mix_bj')
                                    Nèkée kúú ñà ndákatǔ’un sava na
                                    <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','18')"></i>
                                    <audio controls  id="sale_audio18" style="display:none;">
                                        <source src="audio/es_mix_bj/02_recorrido_18.ogg" type="audio/ogg">
                                    </audio>
                                @else
                                    Preguntas frecuentes
                                @endif
                            </h3>
                            <div class="accordion accordion-flush-recorridos" id="accordionFlushExample">
                                <!--ITEM 1-->
                                <div class="accordion-item-recorridos">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                            aria-expanded="false" aria-controls="flush-collapseOne">
                                            @if(session('locale')=='en')
                                                Where can I purchase my ticket?
                                            @elseif(session('locale')=='pt')
                                                Onde posso comprar meu ingresso?
                                            @elseif(session('locale')=='es_mix_bj')
                                                ¿Ndiáa satá yu voléto yù?
                                                <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','19')"></i>
                                                <audio controls  id="sale_audio19" style="display:none;">
                                                    <source src="audio/es_mix_bj/02_recorrido_19.ogg" type="audio/ogg">
                                                </audio>
                                            @else
                                                ¿Dónde puedo adquirir mi boleto?
                                            @endif
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            @if(session('locale')=='en')
                                                You can get your ticket once you enter the Garden and before the start of each tour.
                                                At the moment we do not have external points of sale, reservations or advance ticket sales.
                                            @elseif(session('locale')=='pt')
                                                Você pode adquirir seu ingresso assim que entrar no Jardim e antes do início de cada passeio.
                                                De momento não temos pontos de venda externos, reservas ou venda antecipada de bilhetes.
                                            @elseif(session('locale')=='es_mix_bj')
                                                Ná xàà ún kì’vi ún ini jardîn yó’o saá ví tyá’vi ún ra taxi na voléto ún nda’á ún.
                                                Kòó íxǐko na voléto yó’o ndiáa inka ña’ñu, ta nii kǔvi satá ndó ña vityin ta kì’vi ndó xí’ín ña inka kìví.
                                                <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','20')"></i>
                                                <audio controls  id="sale_audio20" style="display:none;">
                                                    <source src="audio/es_mix_bj/02_recorrido_20.ogg" type="audio/ogg">
                                                </audio>
                                            @else
                                                Puede conseguir su boleto una vez ingrese al Jardín y previo al inicio de cada recorrido.
                                                Por el momento no contamos con puntos de venta externos, reservaciones o venta de boletos con anticipación.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!--ITEM 2-->
                                <div class="accordion-item-recorridos">
                                    <h2 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                            aria-expanded="false" aria-controls="flush-collapseTwo">
                                            @if(session('locale')=='en')
                                                Can I book a private tour?
                                            @elseif(session('locale')=='pt')
                                                Posso reservar um tour privado?
                                            @elseif(session('locale')=='es_mix_bj')
                                                ¿Án kuvi ndukún yu iin na kátyiñu jardîn yó’o ra kù’ùn na xí’ín indàá saá mií yu koto ndiě’é yu?
                                                <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','21')"></i>
                                                <audio controls  id="sale_audio21" style="display:none;">
                                                    <source src="audio/es_mix_bj/02_recorrido_21.ogg" type="audio/ogg">
                                                </audio>
                                            @else
                                                ¿Puedo contratar un recorrido privado?
                                            @endif
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            @if(session('locale')=='en')
                                                We do not offer self-guided access to the Garden, nor private tours.
                                                We realize that many people who would like to visit this garden cannot wait.
                                                We sincerely apologize for this and ask for your understanding.
                                            @elseif(session('locale')=='pt')
                                                Não oferecemos acesso sem guia da equipe do Jardim, nem passeios privativos.
                                                Sabemos que muitas pessoas que gostariam de visitar este jardim não podem esperar.
                                                Lamentamos sinceramente e pedimos sua compreensão.
                                            @elseif(session('locale')=='es_mix_bj')
                                                Kǔvi kèe ndó tée kòó iin mí na jardín yó’o kunúú nùú ndó kù’ùn ndó, nii kòó kúvi kì’vi ndó tée
                                                sǔvi ora kúú ña. Kúndàà ini nà jardín yó’o kûnì ndó kèe ndó tée xà kìxaà ndó tyi kǔvi ka ndikó ndó
                                                inka kìví, ñà kán ndúkún ndi ñà ká’nu ini nùú ndó su tée xà nìyà’a óra ra kǔvi ka.
                                                <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','22')"></i>
                                                <audio controls  id="sale_audio22" style="display:none;">
                                                    <source src="audio/es_mix_bj/02_recorrido_22.ogg" type="audio/ogg">
                                                </audio>
                                            @else
                                                No ofrecemos acceso sin guía del Jardín, ni a recorridos privados.
                                                Estamos conscientes de que muchas personas que quisieran visitar este jardín no pueden esperar.
                                                Lo lamentamos sinceramente y pedimos su comprensión.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!--ITEM 3-->
                                <div class="accordion-item-recorridos">
                                    <h2 class="accordion-header" id="flush-headingThree">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                            aria-expanded="false" aria-controls="flush-collapseThree">
                                            @if(session('locale')=='en')
                                                Why is the number of visitors per group limited?
                                            @elseif(session('locale')=='pt')
                                                Por que o número de visitantes por grupo é limitado?
                                            @elseif(session('locale')=='es_mix_bj')
                                                ¿Natyun iin tàkà lo’o kúú na táxi na kuàkèe?
                                                <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','23')"></i>
                                                <audio controls  id="sale_audio23" style="display:none;">
                                                    <source src="audio/es_mix_bj/02_recorrido_23.ogg" type="audio/ogg">
                                                </audio>
                                            @else
                                                ¿Por qué se limita el número de visitantes por grupo?
                                            @endif
                                        </button>
                                    </h2>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body">
                                            @if(session('locale')=='en')
                                                For the safety of our visitors and the plants, the Garden can only be visited on guided tours.
                                                Each group is made up of 30 people and they are offered from Monday to Saturday at different times.
                                            @elseif(session('locale')=='pt')
                                                Para segurança dos nossos visitantes e das plantas, o Jardim só pode ser visitado em visitas guiadas.
                                                Cada grupo é formado por 30 pessoas e é oferecido de segunda a sábado em horários diferentes.
                                            @elseif(session('locale')=='es_mix_bj')
                                                Ñà ná kòó kundo’o ndó iin tùndí’ni saá tu itún kuálí íyo jardîn yó’o ná kòó tàxìn nú, ná kòó kundivà’a
                                                nú xíniñú’ún kunúú iin na kátyíñu jardîn yó’o nùú ndó kù’un ndó, kòó táxi na kèe mítú’ún ndó.
                                                Iin tàkà iin tàkà koo ndó kèe ndó, kū’vā òkò ùxì káá kúú na kêe. Kìví và’a kèe ndó kúú lúne iin saá ndià
                                                sávàdò, kuvi kèe ndó ña’a ta sáa kuvi tu kèe ndó xìkuaá.
                                                <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','24')"></i>
                                                <audio controls  id="sale_audio24" style="display:none;">
                                                    <source src="audio/es_mix_bj/02_recorrido_24.ogg" type="audio/ogg">
                                                </audio>
                                            @else
                                                Por seguridad de nuestr@s visitantes y de las plantas, el Jardín sólo puede ser visitado en recorridos guiados.
                                                Cada grupo se conforma de 30 personas y se ofrecen de lunes a sábado en diferentes horarios.
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    --}}





    <!--S3 RECORRIDOS-ESCOLARES-->
    {{-- <section class="recorridos-escolares" id="escolares">
        <div class="container pt-4">
            <div class="row justify-content-around py-5 px-4">
                <div class="col-sm-12 col-md-9 col-lg-8 col-xl-5 col-xxl-4 escuelas-texto py-5">
                    <div class="row">
                        <div class="col">
                            <h2 class="subtitulo">
                                @if(session('locale')=='en')
                                    School<br>tours
                                @elseif(session('locale')=='pt')
                                    Passeios<br>escolares
                                @elseif(session('locale')=='es_mix_bj')
                                    Ñà kì’vi na kuǎlí ká’vi
                                    <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','25')"></i>
                                    <audio controls  id="sale_audio25" style="display:none;">
                                        <source src="audio/es_mix_bj/02_recorrido_25.ogg" type="audio/ogg">
                                    </audio>
                                @else
                                    Recorridos<br>escolares
                                @endif
                            </h2>
                            <p>
                                @if(session('locale')=='en')
                                    We are pleased to offer free school tours for national public and private educational mexican institutions.
                                    These require reservations and are offered at the following times.
                                @elseif(session('locale')=='pt')
                                    Estamos muito satisfeitos em poder oferecer passeios escolares gratuitos para instituições mexicanas de ensino público e privado do mexico.
                                    Estes requerem reserva e são ministrados nos seguintes horários.
                                @elseif(session('locale')=='es_mix_bj')
                                    Kúsìí níi va ini nà jardín yó’o ñà vàxi na kuǎlí ká’vi kuto’ni na mí jardín yó’o, nà yó’o ra,
                                    nà kuàkèe uun va kúú na, kòó xíniñú’ú tyá’vi na. Kòó tyá’vi na nii na ká’vi ve’e sákua’a kuénta gobierno,
                                    ni na ká’vi ve’e sákuá’a kuénda nà mitú’ún. Ñà kuvi kèe na xíniñú’ú yàtyì kà ndatú’ún na xí’ín mí na jardîn
                                    yó’o ñà kán kuvi kundàà ini na ndiáa kìví kúú ña kúñà’à nà ndiki’in ña’á na. Saá kuvi kìndòo na kixi na
                                    iin kìví xí’ín óra ñà ndósó tìxín yó’o:
                                    <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','26')"></i>
                                    <audio controls  id="sale_audio26" style="display:none;">
                                        <source src="audio/es_mix_bj/02_recorrido_26.ogg" type="audio/ogg">
                                    </audio>
                                @else
                                    Nos da mucho gusto poder ofrecer recorridos escolares gratuitos para instituciones de educación pública y privada nacionales.
                                    Para poder agendar un recorrido escolar, requerimos de reservación previa. Los recorridos tienen una duración aproximada de una
                                    hora en grupos de 30 personas cada uno. Los recorridos escolares se inician en los siguientes horarios.
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            @if(session('locale')=='en')
                                <h3>Schedules</h3>
                                <h4>Duration 1 hour</h4>+
                                 a.m. <br> 1:00 p.m. to 3:00 p.m. <br>
                            @elseif(session('locale')=='pt')
                                <h3>Horários</h3>
                                <h4>Duração 1 hora</h4>
                                <p>Segunda a sexta<br>8h00 às 10h00<br> 13h00 às 15h00<br>
                            @elseif(session('locale')=='es_mix_bj')
                                    <h3>Óra</h3>
                                    <h4>Iin óra kúú ña kuàtyì nà kaka na ini jardîn</h4>
                                    <p>Lúne saá ndià viérne<br>kàa ùnà ña’à saá ndià kàa ùxì <br>kàa iin ká’ñu iin saá ndià kàa ùnì xìkaá<br>
                            @else
                                <h3>Horarios</h3>
                                <h4>Duración 1 hora</h4>
                                <p>Lunes a viernes<br>8:00 hrs, 9:00 hrs <br> 13:00 hrs y 14:00 hrs<br>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <h3>
                                @if(session('locale')=='en')
                                @elseif(session('locale')=='pt')
                                @elseif(session('locale')=='es_mix_bj')
                                @else
                                    Reservación
                                @endif
                            </h3>
                            <p>
                                @if(session('locale')=='en')
                                    To schedule a school tour, please send an email to <a href="mailto:escuelas@jardinoaxaca.mx" class="nolink">escuelas@jardinoaxaca.mx</a>
                                    attaching the request letter on letterhead addressed to  C. Geovanni Martínez Guerra,  Coordinador de Conservación y Preservación Etnobiológica,
                                    indicating the total number of attendees and suggesting the date and time for the tour(s).
                                    We recommend sending the request letter at least three weeks in advance, due to the high demand for requests.
                                @elseif(session('locale')=='pt')
                                    Para agendar uma visita escolar, envie um e-mail para <a href="mailto:escuelas@jardinoaxaca.mx" class="nolink">escuelas@jardinoaxaca.mx</a>
                                    anexando a carta de solicitação em papel timbrado e endereçada ao C. Geovanni Martínez Guerra,  Coordinador de Conservación y Preservación Etnobiológica,
                                    indicando o número total de participantes e sugerindo a data e a hora em que eles solicitam o(s) passeio(s).
                                    Recomendamos que você envie sua inscrição com pelo menos três semanas de antecedência devido à alta demanda.
                                @else
                                    Para agendar un recorrido escolar, envía un correo a <a href="mailto:escuelas@jardinoaxaca.mx" class="nolink">escuelas@jardinoaxaca.mx</a>
                                    adjuntando el oficio de solicitud en papel membretado y dirigido al C. Geovanni Martínez Guerra,  Coordinador de Conservación y Preservación Etnobiológica,
                                    indicando el número total de asistentes y sugiriendo la fecha y hora en la que solicitan el o los recorridos.
                                    Recomendamos enviar el oficio con al menos 3 semanas de anticipación, debido a la alta demanda de solicitudes.
                                @endif
                                <br>
                                <a href="mailto:escuelas@jardinoaxaca.mx" class="nolink">escuelas@jardinoaxaca.mx</a>.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9 col-lg-8 col-xl-6 col-xxl-6 galeria-escuelas pb-5">
                    <div class="row">
                        <div class="col">
                            <div class="owl-carousel owl-theme">
                                <div>
                                    <a href="imagenes/slider-3_recorridos/img-01.jpg" data-fancybox="gallery3">
                                        <img src="imagenes/slider-3_recorridos/img-pre-01.jpg" alt="Actividades del recorrido">
                                        <h3 class="w-100">
                                            @if(session('locale')=='en')
                                                School trip to the Ethnobotanical Garden of Oaxaca
                                            @elseif(session('locale')=='pt')
                                                Visita escolar ao Jardim Etnobotânico de Oaxaca
                                            @elseif(session('locale')=='es_mix_bj')
                                            @else
                                                Recorrido escolar en el Jardín Etnobotánico de Oaxaca
                                            @endif
                                        </h3>
                                    </a>
                                </div>
                                <div>
                                    <a href="imagenes/slider-3_recorridos/img-02.jpg" data-fancybox="gallery3">
                                        <img src="imagenes/slider-3_recorridos/img-pre-02.jpg" alt="Guía y alumnos en el Jardín Etnobotánico">
                                        <h3 class="w-100">
                                            @if(session('locale')=='en')
                                                School trip to the Ethnobotanical Garden of Oaxaca
                                            @elseif(session('locale')=='pt')
                                                Visita escolar ao Jardim Etnobotânico de Oaxaca
                                            @elseif(session('locale')=='es_mix_bj')
                                            @else
                                                Recorrido escolar en el Jardín Etnobotánico de Oaxaca
                                            @endif
                                        </h3>
                                    </a>
                                </div>
                                <div>
                                    <a href="imagenes/slider-3_recorridos/img-03.jpg" data-fancybox="gallery3">
                                        <img src="imagenes/slider-3_recorridos/img-pre-03.jpg" alt="Grupo recorriendo el Jardín">
                                        <h3 class="w-100">
                                            @if(session('locale')=='en')
                                                School trip to the Ethnobotanical Garden of Oaxaca
                                            @elseif(session('locale')=='pt')
                                                Visita escolar ao Jardim Etnobotânico de Oaxaca
                                            @elseif(session('locale')=='es_mix_bj')
                                            @else
                                                Recorrido escolar en el Jardín Etnobotánico de Oaxaca
                                            @endif
                                        </h3>
                                    </a>
                                </div>
                                <div>
                                    <a href="imagenes/slider-3_recorridos/img-04.jpg" data-fancybox="gallery3">
                                        <img src="imagenes/slider-3_recorridos/img-pre-04.jpg" alt="Grupo recorriendo el Jardín">
                                        <h3 class="w-100">
                                            @if(session('locale')=='en')
                                                School tour of San Andrés Chicahuaxtla, November 2024 | Photo: Enrique Scheinvar
                                            @elseif(session('locale')=='pt')
                                                Passeio escolar do San Andrés Chicahuaxtla, novembro de 2024 | Foto: Enrique Scheinvar
                                            @elseif(session('locale')=='es_mix_bj')
                                            @else
                                                Recorrido escolar de San Andrés Chicahuaxtla, noviembre, 2024 | Foto: Enrique Scheinvar
                                            @endif
                                        </h3>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    --}}

</div>
