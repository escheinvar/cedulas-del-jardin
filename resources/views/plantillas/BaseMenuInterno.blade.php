<div>
    <div class="offcanvas-body m-1" style="background-color: #CDC6B9">
        <a class="nav-link @if(preg_match("/jardin(?!.*cedulas$)(?!.*autores$)(?!.*listado$)/", request()->path()) ) active @endif" href="/jardin/@yield('siglasMin')" style="display:inline-block;">
            El Jardín
        </a>

        <a class="nav-link @if(preg_match("/jardin\/.*\/cedulas/", request()->path()) ) active @endif" href="/jardin/@yield('siglasMin')/cedulas" style="display:inline-block;">
            Cédulas
        </a>

        <a class="nav-link @if(preg_match("/jardin\/.*\/listado/", request()->path()) ) active @endif" href="/jardin/@yield('siglasMin')/listado" style="display:inline-block;">
            Listado
        </a>

        <a class="nav-link @if(preg_match("/jardin\/.*\/autores/", request()->path()) ) active @endif" href="/jardin/@yield('siglasMin')/autores" style="display:inline-block;">
            Autores
        </a>

        <a class="nav-link @if(preg_match("/jardiness/", request()->path()) ) active @endif" href="/jardiness" style="display:inline-block;">
            Otros jardines
        </a>
        <img src="@yield('logo')" alt="logo del sistema" style="width:80px;margin:5px;">
    </div>
</div>
