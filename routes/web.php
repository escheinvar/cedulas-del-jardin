<?php

use App\Http\Controllers\cedulas\especies_pdf_controller;
use App\Http\Controllers\login\loginController;
use App\Http\Controllers\login\logoutController;
use App\Http\Middleware\EditaCedulasMiddle;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\UsuarioLogeadoConRolMiddle;
use App\Livewire\Admin\Nuevousuario01Controller;
use App\Livewire\Admin\NuevoUsuarioController;
use App\Livewire\Cedulas\AportesComponent;
use App\Livewire\Cedulas\BuscadorCedulasComponent;
use App\Livewire\Cedulas\CatalogoDeCedulasComponent;
use App\Livewire\Cedulas\DistribuidorDeCedulasComponent;
use App\Livewire\Cedulas\EditaCedulasComponent;
use App\Livewire\Cedulas\EspeciesComponent;
use App\Livewire\Login\RecuperaPasswd01Controller;
use App\Livewire\Login\RecuperaPasswdController;
use App\Livewire\Plantas\CatalogoCamellonesYJardinesComponent;
use App\Livewire\Plantas\CatalogoCamellonesYJardinesComponent2;
use App\Livewire\Plantas\CatalogoJardinesYcampusComponent;
use App\Livewire\Plantas\ImportaPlantasComponent2;
use App\Livewire\Plantas\ImportaPlantasComponent;
use App\Livewire\Prueba;
use App\Livewire\Sistema\AcercadeComponent;
use App\Livewire\Sistema\BuzonComponent;
use App\Livewire\Sistema\BuzonController;
use App\Livewire\Sistema\ErrorComponent;
use App\Livewire\Sistema\FichaClavoComponent;
use App\Livewire\Sistema\FichaEspecieComponent;
use App\Livewire\Sistema\FichaParadaCompenent;
use App\Livewire\Sistema\HomeComponent;
use App\Livewire\Sistema\MapaComponent;
use App\Livewire\Sistema\UsuariosComponent;
use App\Livewire\Sistema\VisitasComponent;
use App\Livewire\Web\BaseDatosController;
use App\Livewire\Web\ColaboradoresController;
use App\Livewire\Web\ColeccionesController;
use App\Livewire\Web\DirectiorioController;
use App\Livewire\Web\EspeciesController;
use App\Livewire\Web\EspeciesIxmController;
use App\Livewire\Web\EventosController;
use App\Livewire\Web\HistoriaController;
use App\Livewire\Web\InicioController;
use App\Livewire\Web\Ixmx\EnriqueController;
use App\Livewire\Web\MapaController;
use App\Livewire\Web\RecorridosController;
use App\Livewire\Web\ServiciosController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" mi
ddleware group. Make something great!
|
*/
/* ------------------------------------ PÁGINA WEB PÚBLICA ------------------------ */
Route::get('/', InicioController::class)->name('inicio');
Route::get('/recorridos', RecorridosController::class)->name('recorridos');
Route::get('/informes', RecorridosController::class)->name('recorridos');
Route::get('/mapa', MapaController::class)->name('mapa');
Route::get('/historia', HistoriaController::class)->name('historia');
Route::get('/servicios', ServiciosController::class)->name('servicios');
Route::get('/colecciones', ColeccionesController::class)->name('colecciones');
Route::get('/directorio', DirectiorioController::class)->name('directorio');
Route::get('/colaboradores', ColaboradoresController::class)->name('colaboradores');
Route::get('/actividades',EventosController::class)->name('actividades');
Route::get('/pruebillas_php',function(){ dd(phpinfo());});
Route::get('/baseDeDatos',BaseDatosController::class)->name('baseDeDatos');
Route::get('/acercade', AcercadeComponent::class)->name('acercade');
/* ------------------------------------ PÁGINA WEB PÚBLICA IXMx ------------------------ */
Route::get('/enrique',EnriqueController::class)->name('enrique');



/* ---------------------------------------- LOGIN / LOGOUT ------------------------- */
Route::get('/ingreso',[loginController::class,'index'])->name('login');
Route::post('/ingreso',[loginController::class,'store']);
Route::post('/logout',[logoutController::class,'store'])->name('logout');
Route::get('/recuperaAcceso', RecuperaPasswdController::class);
Route::get('/recuperaContrasenia/{token}',RecuperaPasswd01Controller::class);
Route::get('/erro{tipo}',ErrorComponent::class)->name('error');

/* -------------------------- REGISTRO DE USUARIOS ----------------------------- */
Route::get('/nuevousr',NuevoUsuarioController::class)->name('nuevousr');
Route::get('/nuevousr01/{token}',Nuevousuario01Controller::class);


/* -------------------------- SECCIÓN AUTORIZADA ----------------------------- */
/* --------------------------------------------------------------------------- */
#Route::middleware(['auth.basic'])->group(function(){
Route::middleware([UsuarioLogeadoConRolMiddle::class,Authenticate::class])->group(function(){
    Route::get('/home',HomeComponent::class)->name('home');
    // Route::get('/buzon',BuzonComponent::class)->name('buzon');
    Route::get('/buzon',BuzonController::class)->name('buzon');
    Route::get('/aportes',AportesComponent::class)->name('aportes');
    Route::get('/usuarios',UsuariosComponent::class)->name('usuarios');
    Route::get('/vervisitas',VisitasComponent::class)->name('visitas');
    /* -------------------------- SECCIÓN DE PLANTAS ----------------------------- */
    /* --------------------------------------------------------------------------- */
    // Route::get('/importaPlantas',ImportaPlantasComponent::class)->name('importa');
    // Route::get('/importaPlantas_ver/{claveID}',ImportaPlantasComponent2::class)->name('importa2');
    // Route::get('/catalogo/camellones', CatalogoCamellonesYJardinesComponent::class)->name('catcamellones');
    // Route::get('/catalogo/camellon/{camID}', CatalogoCamellonesYJardinesComponent2::class)->name('catcamellones');
    Route::get('/catalogo/campus', CatalogoJardinesYcampusComponent::class)->name('CatCampus');

    /* --------------------------- SECCION CÉDULAS -------------------------------- */
    /* ---------------------------------------------------------------------------- */
    Route::get('/catCedulas',CatalogoDeCedulasComponent::class)->name('catCedulas');
    Route::get('/editaCedula/{cedID}',EditaCedulasComponent::class)->name('editorCedulas')->middleware(([EditaCedulasMiddle::class]));
});

/* --------------------------- SECCION CÉDULAS -------------------------------- */
/* ---------------------------------------------------------------------------- */
Route::get('/sp/{url}/{jardin}', EspeciesComponent::class)->name('cedula');
Route::get('/sppdf/{cedID}/{tipo}',[especies_pdf_controller::class, 'index']);
Route::get('/buscar', BuscadorCedulasComponent::class)->name('buscadorDeCedulas');
Route::get('/len/{url}/{jardin}/{lengua}', DistribuidorDeCedulasComponent::class)->name('distrilengua');



/*------------------------------ CÉDULAS DE ESPECIES --------------------------------------- */
#Route::get('/especies',EspeciesController::class)->name('especies');
Route::get('/especies', BuscadorCedulasComponent::class)->name('buscadorDeCedulas');
Route::get('/especiesixmx',EspeciesIxmController::class)->name('especiesIxMx');

/*---------- temps --------------*/
// Route::get('/elmapa',MapaComponent::class)->name('elmapa');
// Route::get('/laespecie',FichaEspecieComponent::class)->name('laespecie');
// Route::get('/elclavo/{clavo}',FichaClavoComponent::class)->name('elclavo');
// Route::get('/parada/{parada}',FichaParadaCompenent::class)->name('laparada');

Route::get ('/prueba',Prueba::class)->name('prueba');


