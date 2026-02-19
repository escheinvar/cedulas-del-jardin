@section('title') Jardín Etnobiológico de Oaxaca @endsection

@section('meta-description') "Somos un espacio cultural dedicado a la conservación y propagación de plantas nativas de Oaxaca. ¡Ven y conoce parte de la gran diversidad e historia del estado!" @endsection

@section('banner-title')
    @if(session('locale')=='en')
        Ethnobiological <br>Garden <br>of Oaxaca
    @elseif(session('locale')=='pt')
        Jardim <br>Etnobiológico <br>de Oaxaca
    @elseif(session('locale')=='es_mix_bj')
        Jardîn <br>Etnoviológìkò <br>Ñuu Ndǔvá
        {{-- <audio id="SpAudio01">
            <source src='audio/es_mix_bj/01inicio_00.ogg' type="audio/ogg"> El navegador no soporta el audio
        </audio>
        <i class="bi bi-volume-down-fill" id="IconPlay01" onclick="playAudio('01')" style="cursor:pointer;display:inline;vertical-align:top;"></i>
        <i class="bi bi-volume-mute-fill" id="IconStop01" onclick="pauseAudio('01')" style="cursor:pointer;display:none; vertical-align:top;"></i> --}}

    @else
        Amigos del Jardín <br>Etnobiológico<br> de Oaxaca
        {{-- <audio id="SpAudio01">
            <source src='/audio/es/01inicio_00.ogg' type="audio/ogg"> El navegador no soporta el audio
        </audio>
        <i class="bi bi-volume-down-fill" id="IconPlay01" onclick="playAudio('01')" style="cursor:pointer;display:inline;vertical-align:top;"></i>
        <i class="bi bi-volume-mute-fill" id="IconStop01" onclick="pauseAudio('01')" style="cursor:pointer;display:none; vertical-align:top;"></i> --}}
    @endif
@endsection

@section('banner') banner-index @endsection

<div>
    <!--S1 PRESENTACION-->
    <section class="presentacion pt-4">
        <div class="container pt-5 px-3" id="bienvenido">
            <div>
                @include('plantillas/plant_locale')
            </div>

            <div class="row justify-content-around py-5">
                <div class="col-sm-auto col-md-6 col-lg-5 text-end px-4 mb-4">
                    <h2 class="cita">
                        @if(session('locale')=='en')
                            "A space created to show live the relationships between the natural history of Oaxaca and its cultural diversity"
                        @elseif(session('locale')=='pt')
                            "Um espaço criado para mostrar ao vivo as relações entre a história natural de Oaxaca e sua diversidade cultural"
                        @elseif(session('locale')=='es_mix_bj')
                            "kùva’à ñà ñà kuvi kundaa ini yó nìsaa xíniñú’ú na ñuu yó Ñuu Ndǔvá ndi’í mií nùú itún ìkù xí’ín ndi’i ka ñà’a kána tiañu ikú ñuu yó"
                        @else
                            “Un espacio creado para mostrar en vivo las relaciones entre la historia natural de Oaxaca y su diversidad cultural”
                            <audio id="SpAudio_UnEspacioCreado">
                                <source src='/audio/es/01inicio_01.ogg' type="audio/ogg"> El navegador no soporta el audio
                            </audio>
                            <i class="bi bi-volume-down-fill" id="IconPlay_UnEspacioCreado" onclick="playAudio('_UnEspacioCreado')" style="cursor:pointer;display:inline; ;vertical-align:top;"></i>
                            <i class="bi bi-volume-mute-fill" id="IconStop_UnEspacioCreado" onclick="pauseAudio('_UnEspacioCreado')" style="cursor:pointer;display:none; ;vertical-align:top;"></i>
                        @endif
                    </h2>
                    <h4 class="autor-cita">Dr. Alejandro de Ávila Blomberg</h4>
                    <p class="autor-cita">
                        @if(session('locale')=='en')
                            Founding Director of the Ethnobiological Garden
                        @elseif(session('locale')=='pt')
                            Diretor Fundador do Jardim Etnobiológico
                        @elseif(session('locale')=='es_mix_bj')
                            Rà nìkà’àn xà’á Jardîn etnoviológìkò kùva’à ñà ta kúú ra rà ínuu kí’ín kuénda xí’ín ña.
                        @else
                            Director Fundador del Jardín Etnobiológico
                            <audio id="SpAudio_DrAle">
                                <source src='/audio/es/01inicio_03.ogg' type="audio/ogg"> El navegador no soporta el audio
                            </audio>
                            <i class="bi bi-volume-down-fill" id="IconPlay_DrAle" onclick="playAudio('_DrAle')" style="cursor:pointer;display:inline; ;vertical-align:top;"></i>
                            <i class="bi bi-volume-mute-fill" id="IconStop_DrAle" onclick="pauseAudio('_DrAle')" style="cursor:pointer;display:none; ;vertical-align:top;"></i>


                        @endif
                    </p>
                </div>
                <div class="col-sm-auto col-md-6 col-lg-6 col-xl-5 text-start py-2 px-4">
                    <p class="texto-principal">
                        @if(session('locale')=='en')
                            Proposed in 1993 as a civil society initiative, it has hundreds of species donated by Oaxacan communities
                            and with which we safeguard a small part of the immense biocultural heritage of the state of Oaxaca.
                        @elseif(session('locale')=='pt')
                            Proposto em 1993 como uma iniciativa da sociedade civil, conta com centenas de espécies doadas por comunidades de Oaxaca
                            e com a qual protegemos uma pequena parte do imenso patrimônio biocultural do estado de Oaxaca.
                        @elseif(session('locale')=='es_mix_bj')
                            Ndàtǔ’ún tá’án na xà’á ña kuìyà 1993 ñà koo ña iin sociedad civil, ta vityin ra kuà’á níi nùú itún,
                            ìkù, yaví, ita, kuà’á ka ñà’a iyo nùú ña. Ndi’i ña yó’o ra, na nda’á Ñuu Ndǔvá nìsòkó ña, saá vityin,
                            yó’o kí’ín na jardín kuénda xí’ín ña, ndiáa nà xà kúú ra lo’o tyíín nùú ikú kuîí íyo Ñuu Ndǔvá.
                        @else
                            Propuesto en 1993 como iniciativa de la sociedad civil, cuenta con cientos de especies donadas por las comunidades oaxaqueñas
                            y con las que resguardamos una pequeña parte del inmenso patrimonio biocultural del estado de Oaxaca.
                            <audio id="SpAudio_PropuestoEn">
                                <source src='/audio/es/01inicio_02.ogg' type="audio/ogg"> El navegador no soporta el audio
                            </audio>
                            <i class="bi bi-volume-down-fill" id="IconPlay_PropuestoEn" onclick="playAudio('_PropuestoEn')" style="cursor:pointer;display:inline; ;vertical-align:top;"></i>
                            <i class="bi bi-volume-mute-fill" id="IconStop_PropuestoEn" onclick="pauseAudio('_PropuestoEn')" style="cursor:pointer;display:none; ;vertical-align:top;"></i>


                        @endif
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!--S2 ENTERATE-->
    <section class="enterate pt-4">
        <div class="container py-5 px-4">
            <div class="row pb-5">
                <div class="col-sm-10 col-md-8 col-lg-5 enterate-titulo">
                    <h3 class="subtitulo">
                        @if(session('locale')=='en')
                            Find out
                        @elseif(session('locale')=='pt')
                            Descobrir
                        @elseif(session('locale')=='es_mix_bj')
                            Kùndàà ka ini xà’á ña
                        @else
                            Entérate
                        @endif
                    </h3>
                </div>
            </div>
            <div class="row pb-5" >
                <div class="col wrapper pb-5">
                    <div style="width:100%">
                        <span style="text-align: left; display:inline-block; width:50%;">
                            <!-- Recorridos-->
                            @if(session('locale')=='es_mix_bj')
                                {{-- <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','4a')"></i>
                                <audio controls  id="sale_audio4a" style="display:none;">
                                    <source src="audio/es_mix_bj/01inicio_04a.ogg" type="audio/ogg" >
                                </audio> --}}
                            @endif
                        </span>
                        <span style="text-align:right; float: right; width:50%;">
                            <!-- Mapa -->
                            @if(session('locale')=='es_mix_bj')
                                {{-- <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','4b')"></i>
                                <audio controls  id="sale_audio4b" style="display:none;">
                                    <source src="audio/es_mix_bj/01inicio_04b.ogg" type="audio/ogg" >
                                </audio><br> --}}
                            @endif
                        </span>
                    </div>
                    <div class="home-hero">
                        <a href="/recorridos" class="recorridos-menu">
                            @if(session('locale')=='en')
                                <h3>Tours</h3>
                                <p>Schedules | Tickets | Location</p>
                            @elseif(session('locale')=='pt')
                                <h3>Passeios</h3>
                                <p>Horários | Ingressos | Localização</p>
                            @elseif(session('locale')=='es_mix_bj')
                                <h3>Ña kuvi kèe ndó</h3>
                                <p> Horários| Ingresos | Ubicación </p>
                            @else
                                <h3>Recorridos</h3>
                                <p>Horarios | Entradas | Ubicación</p>
                            @endif
                        </a>

                        <a href="/mapa" class="mapa-menu">
                            @if(session('locale')=='en')
                                <h3>Map</h3>
                                <p>Zones | Highlights</p>
                            @elseif(session('locale')=='pt')
                                <h3>Mapa</h3>
                                <p>Zonas | Lugares excepcionais</p>
                            @elseif(session('locale')=='es_mix_bj')
                                <h3>ñá’à ñà nùú yó nùú íyo iin iin ñà’a </h3>
                                <p> Zonas | Lugares sobresalientes</p>
                            @else
                                <h3>Mapa</h3>
                                <p>Zonas | Lugares sobresalientes</p>
                            @endif
                        </a>

                        <a href="/actividades" class="actividades-menu">
                            @if(session('locale')=='en')
                                <h3>Activities</h3>
                                <p>Announcements | Upcoming events</p>
                            @elseif(session('locale')=='pt')
                                <h3>Atividades</h3>
                                <p>Avisos | Próximos eventos</p>
                            @elseif(session('locale')=='es_mix_bj')
                                <h3>Tyiñu ké’é na </h3>
                                <p>Avisos | Próximos eventos</p>
                            @else
                                <h3>Actividades</h3>
                                <p>Avisos | Próximos eventos</p>
                            @endif
                        </a>

                        <a href="/servicios" class="educacion-menu">
                            @if(session('locale')=='en')
                                <h3>Services</h3>
                                <p>Library | Herbarium </p>
                            @elseif(session('locale')=='pt')
                                <h3>Serviços</h3>
                                <p>Biblioteca | Herbário </p>
                            @elseif(session('locale')=='es_mix_bj')
                                <h3>ñà kùtu’va na </h3>
                                <p>nùú íyo tutu ka’vi na | nùú íyo ndi’i ìkù nda’á itún ká’vi na </p>
                            @else
                                <h3>Servicios</h3>
                                <p>Biblioteca | Herbario </p>
                            @endif
                        </a>
                    </div>
                    <div style="width:100%">
                        <span style="text-align: left; display:inline-block; width:50%;">
                            <!-- Actividades-->
                            @if(session('locale')=='es_mix_bj')
                                {{-- <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','4c')"></i>
                                <audio controls  id="sale_audio4c" style="display:none;">
                                    <source src="audio/es_mix_bj/01inicio_04c.ogg" type="audio/ogg" >
                                </audio> --}}
                            @endif
                        </span>
                        <span style="text-align:right; float: right; width:50%;">
                            <!-- Educación -->
                            @if(session('locale')=='es_mix_bj')
                                {{-- <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','4d')"></i>
                                <audio controls  id="sale_audio4d" style="display:none;">
                                    <source src="audio/es_mix_bj/01inicio_04d.ogg" type="audio/ogg" >
                                </audio><br> --}}
                            @endif
                        </span>
                    </div>
                </div>
                <div class="col-2">
                    <!-- ---------------- Espacio para algo -->
                </div>
            </div>
        </div>
    </section>



    <!--S3 GALERIA-INICIO-->
    <section class="galeria-inicio pt-5">
        <div class="container py-5 px-4">
            <div class="row pb-5">
                <div class="col">
                    <h2>
                        @if(session('locale')=='en')
                            Visit the Ethnobiological Garden of Oaxaca
                        @elseif(session('locale')=='pt')
                            Visite o Jardim Etnobiológico de Oaxaca
                        @elseif(session('locale')=='es_mix_bj')
                            Kixi ún kotondiě’é ún Jardîn Etnoviológìkò Ñuu Ndǔvá
                            {{-- <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','5')"></i>
                            <audio controls  id="sale_audio5" style="display:none;">
                                <source src="audio/es_mix_bj/01inicio_05.ogg" type="audio/ogg" >
                            </audio> --}}
                        @else
                            Visita el Jardín Etnobiológico de Oaxaca
                        @endif
                    </h2>
                    <div class="owl-carousel owl-theme">
                        <div>
                            <a href="/imagenes/slider-1_inicio/img-01.jpg" data-fancybox="gallery">
                                <img src="/imagenes/slider-1_inicio/img-pre-01.jpg" alt="Árboles del Jardín">
                                <h3 class="w-100">
                                    @if(session('locale')=='en')
                                        Inside the Ethnobiological Garden of Oaxaca1 | Photo: Ernesto de los Santos Reyes
                                    @elseif(session('locale')=='pt')
                                        Interior do Jardim Etnobiológico de Oaxaca | Foto: Ernesto de los Santos Reyes
                                    @elseif(session('locale')=='es_mix_bj')
                                        So’o káá ini jardîn Etnoviológìkò Ñuu Ndǔvá | Foto: Ernesto de los Santos Reyes

                                    @else
                                        Vista de columnares desde un copal | Foto: Ernesto de los Santos Reyes
                                    @endif
                                </h3>
                            </a>
                        </div>
                        <div>
                            <a href="imagenes/slider-1_inicio/img-05.webp" data-fancybox="gallery">
                                <img src="imagenes/slider-1_inicio/img-pre-05.webp" alt="Camino de piedra">
                                <h3 class="w-100">
                                    @if(session('locale')=='en')
                                        Inside the Ethnobiological Garden of Oaxaca2 | Photo: Ernesto de los Santos Reyes
                                    @elseif(session('locale')=='pt')
                                        Interior do Jardim Etnobiológico de Oaxaca | Foto: Ernesto de los Santos Reyes
                                    @elseif(session('locale')=='es_mix_bj')
                                        So’o káá ini jardîn Etnoviológìkò Ñuu Ndǔvá | Foto: Ernesto de los Santos Reyes
                                    @else
                                        El Espejo de Agua  | Foto: Ernesto de los Santos Reyes
                                    @endif
                                </h3>
                            </a>
                        </div>
                        <div>
                            <a href="imagenes/slider-1_inicio/img-pre-06.webp" data-fancybox="gallery">
                                <img src="imagenes/slider-1_inicio/img-pre-06.webp" alt="Espejo de agua">
                                <h3 class="w-100">
                                    @if(session('locale')=='en')
                                        Inside the Ethnobiological Garden of Oaxaca3 | Photo: Geovanny Martínez Guerra
                                    @elseif(session('locale')=='pt')
                                        Interior do Jardim Etnobiológico de Oaxaca | Foto: Geovanny Martínez Guerra
                                    @elseif(session('locale')=='es_mix_bj')
                                        So’o káá ini jardîn Etnoviológìkò Ñuu Ndǔvá | Foto: Geovanny Martínez Guerra
                                    @else
                                        Hongos en el Jardín Etnobiológico | Foto: Geovanny Martínez Guerra
                                    @endif
                                </h3>
                            </a>
                        </div>
                        <div>
                            <a href="imagenes/slider-1_inicio/img-pre-07.webp" data-fancybox="gallery">
                                <img src="imagenes/slider-1_inicio/img-pre-07.webp" alt="Cactáceas">
                                <h3 class="w-100">
                                    @if(session('locale')=='en')
                                        Inside the Ethnobiological Garden of Oaxaca4 | Photo: Ernesto de los Santos Reyes
                                    @elseif(session('locale')=='pt')
                                        Interior do Jardim Etnobiológico de Oaxaca | Foto: Ernesto de los Santos Reyes
                                    @elseif(session('locale')=='es_mix_bj')
                                        So’o káá ini jardîn Etnoviológìkò Ñuu Ndǔvá | Foto: Ernesto de los Santos Reyes
                                    @else
                                        Agaves del Jardín | Foto: Ernesto de los Santos Reyes
                                    @endif
                                </h3>
                            </a>
                        </div>
                        <div>
                            <a href="imagenes/slider-1_inicio/img-04.jpg" data-fancybox="gallery">
                                <img src="imagenes/slider-1_inicio/img-pre-08.webp" alt="Cactáceas">
                                <h3 class="w-100">
                                    @if(session('locale')=='en')
                                        Inside the Ethnobiological Garden of Oaxaca5 | Photo: Ernesto de los Santos Reyes
                                    @elseif(session('locale')=='pt')
                                        Interior do Jardim Etnobiológico de Oaxaca | Foto: Ernesto de los Santos Reyes
                                    @elseif(session('locale')=='es_mix_bj')
                                        So’o káá ini jardîn Etnoviológìkò Ñuu Ndǔvá | Foto: Ernesto de los Santos Reyes
                                    @else
                                        Vista desde los baños | Foto: Ernesto de los Santos Reyes
                                    @endif
                                </h3>
                            </a>
                        </div>
                        <div>
                            <a href="imagenes/slider-1_inicio/img-pre-09.webp" data-fancybox="gallery">
                                <img src="imagenes/slider-1_inicio/img-pre-09.webp" alt="Cactáceas">
                                <h3 class="w-100">
                                    @if(session('locale')=='en')
                                        Inside the Ethnobiological Garden of Oaxaca 6 | Photo: Ernesto de los Santos Reyes
                                    @elseif(session('locale')=='pt')
                                        Interior do Jardim Etnobiológico de Oaxaca | Foto: Ernesto de los Santos Reyes
                                    @elseif(session('locale')=='es_mix_bj')
                                        So’o káá ini jardîn Etnoviológìkò Ñuu Ndǔvá | Foto: Ernesto de los Santos Reyes
                                    @else
                                        El jardín de piedras | Foto: Ernesto de los Santos Reyes
                                    @endif
                                </h3>
                            </a>
                        </div>
                        <div>
                            <a href="imagenes/slider-1_inicio/img-pre-10.webp" data-fancybox="gallery">
                                <img src="imagenes/slider-1_inicio/img-pre-10.webp" alt="Cactáceas">
                                <h3 class="w-100">
                                    @if(session('locale')=='en')
                                        Inside the Ethnobiological Garden of Oaxaca 7 | Photo: Ernesto de los Santos Reyes
                                    @elseif(session('locale')=='pt')
                                        Interior do Jardim Etnobiológico de Oaxaca | Foto: Ernesto de los Santos Reyes
                                    @elseif(session('locale')=='es_mix_bj')
                                        So’o káá ini jardîn Etnoviológìkò Ñuu Ndǔvá | Foto: Ernesto de los Santos Reyes
                                    @else
                                        Agaves guiengola y amate amarillo | Foto: Ernesto de los Santos Reyes
                                    @endif
                                </h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="padding:10px;font-size:80%;"><i>
            @if(session('locale')=='es_mix_bj')
                Traducción Tu'un Savi: Juana Mendoza Ruiz.
                {{-- <i class="bi bi-volume-up-fill" onclick="VerNoVer('audio','6')"></i>
                <audio controls  id="sale_audio6" style="display:none;">
                    <source src="audio/es_mix_bj/01inicio_06.ogg" type="audio/ogg" >
                </audio> --}}
            @endif
        </i></div>
    </section>

</div>
