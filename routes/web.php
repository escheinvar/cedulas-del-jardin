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
use App\Livewire\Cedulas\CatalogoDeCedulasComponent;
use App\Livewire\Cedulas\DistribuidorDeCedulasComponent;
use App\Livewire\Cedulas\EditaCedulasComponent;
use App\Livewire\Cedulas\EspeciesComponent;
use App\Livewire\Login\RecuperaPasswd01Controller;
use App\Livewire\Login\RecuperaPasswdController;
use App\Livewire\Plantas\CatalogoJardinesYcampusComponent;
use App\Livewire\Sistema\BuzonController;
use App\Livewire\Sistema\ErrorComponent;
use App\Livewire\Sistema\HomeComponent;
use App\Livewire\Sistema\HomeConfigController;
use App\Livewire\Sistema\UsuariosComponent;
use App\Livewire\Sistema\VisitasComponent;
use App\Livewire\Web\AutoresController;
use App\Livewire\Web\BuscadorCedulasComponent;
use App\Livewire\Web\InicioController;
use App\Livewire\Web\JardinesController;
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
#Route::get('/acercade', AcercadeComponent::class)->name('acercade');
Route::get('/jardines',JardinesController::class)->name('jardines');
Route::get('/autores',AutoresController::class)->name('autores');
Route::get('/cedulasdeljardin', BuscadorCedulasComponent::class)->name('cedulas');



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
Route::middleware([UsuarioLogeadoConRolMiddle::class,Authenticate::class])->group(function(){
    Route::get('/home',HomeComponent::class)->name('home');
    Route::get('/homeConfig', HomeConfigController::class)->name('homeConfig');
    Route::get('/buzon',BuzonController::class)->name('buzon');
    Route::get('/aportes',AportesComponent::class)->name('aportes');
    Route::get('/usuarios',UsuariosComponent::class)->name('usuarios');
    Route::get('/vervisitas',VisitasComponent::class)->name('visitas');
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




