<?php

namespace App\Livewire\Sistema;

use App\Models\buzon;
use App\Models\CatJardinesModel;
use App\Models\CatRolesModel;
use App\Models\ced_aporteusrs;
use App\Models\ced_autores;
use App\Models\cedulas_url;
use App\Models\Imagenes;
use App\Models\SpAporteUsrsModel;
use App\Models\UserRolesModel;
use App\Models\proy_proyectos;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


// #[Layout('components.layouts.SistemaBase')]
class HomeComponent extends Component
{
    ##### Variables de autorización de nivel de privilegio
    public $edit, $editMaster, $editjar, $JardUsr;
    public $VerProysArchiv; ##### Flag que muestra o no proyectosArchivados

    public function mount(){
        // $this->dispatch('VerificaVentanaEmergente');
        $this->VerProysArchiv=FALSE;
    }
    public function enconstruccion(){
        $this->dispatch('AvisoExitoHome',msj:'Sección en construcción!!. Por el momento, ve a tu buzón y envía un mensaje al administrador.');
    }

    ##### Termina imágens
    public function render(){
        ##### Revisa permisos del usuario
        $auts=['editor','admin','autor','traductor']; ##### array de roles autorizados a editar
        if(array_intersect($auts,session('rol'))){
            $this->edit='1';

        }else{
            $this->edit='0';
        }

        ##### Distingue permisos superiores
        if(array_intersect(['editor','admin'], session('rol'))){
            $this->editMaster='1';
        }else{
            $this->editMaster='0';
        }

        ##### jardines autorizados al usuario (puede incluir palabra "todos")
        $this->editjar = UserRolesModel::where('rol_usrid',Auth::user()->id)
            ->whereIn('rol_crolrol',$auts)
            ->where('rol_act','1')->where('rol_del','0')
            ->distinct('rol_cjarsiglas')
            ->pluck('rol_cjarsiglas')->toArray();

        #### Genera lista de jardines autorizados al usuario (sin palabra "todos")
        if(in_array('todos',$this->editjar)){
            $JardsUsr=CatJardinesModel::where('cjar_act','1')->where('cjar_del','0')
                ->orderBy('cjar_siglas')
                ->orderBy('cjar_name')
                ->get();
        }else{
            $JardsUsr=CatJardinesModel::where('cjar_act','1')->where('cjar_del','0')
                ->whereIn('cjar_siglas',$this->editjar)
                ->orderBy('cjar_siglas')
                ->orderBy('cjar_name')
                ->get();
        }

        ##### Obtiene cantidad de cedulas en edición
        if( array_intersect(['editor','admin'], session('rol'))  ){
            $cedulas=cedulas_url::whereIn('url_cjarsiglas', $JardsUsr->pluck('cjar_siglas')->toArray())
                ->where('url_act','1')->where('url_del','0')
                ->get();
        }elseif((array_intersect(['autor','traductor'],session('rol'))) ){
            $cedulas=cedulas_url::whereIn('url_cjarsiglas', $JardsUsr->pluck('cjar_siglas')->toArray())
                ->where('url_act','1')->where('url_del','0')
                ->join('ced_autores','aut_urlid','=','url_id')
                ->join('cat_autores','aut_cautid','=','caut_id')
                ->where('aut_del','0')->where('aut_act','1')
                ->where('caut_del','0')->where('caut_act','1')
                ->where('caut_usrid',Auth::user()->id)
                ->get();
        }else{
            $cedulas=collect();
        }

        ##### Obtiene datos de buzón
        $buzon=buzon::where('buz_to',Auth::user()->id)
            // ->orWhere('buz_from',Auth::user()->id)
            ->where('buz_del','0')
            ->get();

        ##### Recupera aportaciones a revisar
        $aporta=ced_aporteusrs::where('msg_act','1')
            ->whereIn('msg_cjarsiglas', $JardsUsr->pluck('cjar_siglas')->toArray())
            ->orderBy('msg_date','desc')
            ->with('jardin')
            ->with('cedula')
            ->get();

        ##### Enlista roles del usuario
        $MisRoles=UserRolesModel::where('rol_usrid',Auth::user()->id)->where('rol_act','1')->where('rol_del','0')->get();

        ###### Revisa si hay proyectos
        if($this->VerProysArchiv==FALSE){$verOno='>';}else{$verOno='>=';}

        if(array_intersect(['admin'],session('rol'))){
            $proyectos=proy_proyectos::where('proy_del','0')
                ->where('proy_act',$verOno,'0')
                ->with('estados')
                ->with('archivos')
                ->with('autor1')
                ->with('autor2')
                ->with('autor3')
                ->with('editor')
                ->with('admin')
                ->get();
        }else{
            $proyectos=proy_proyectos::where('proy_del','0')
                ->where('proy_act',$verOno,'0')
                ->where(function($q){
                    return $q
                    ->where('proy_autor1',Auth::user()->id)
                    ->orWhere('proy_autor2',Auth::user()->id)
                    ->orWhere('proy_autor3',Auth::user()->id)
                    ->orWhere('proy_admin',Auth::user()->id)
                    ->orWhere('proy_editor',Auth::user()->id);
                })
                ->with('estados')
                ->with('archivos')
                ->with('autor1')
                ->with('autor2')
                ->with('autor3')
                ->with('editor')
                ->with('admin')
                ->get();
        }

        $autores=UserRolesModel::where('rol_crolrol','autor')
            ->where('rol_act','1')
            ->where('rol_del','0')
            ->select(['rol_usrid','rol_cjarsiglas'])
            ->get();

        return view('livewire.sistema.home-component',[
            'cedulas'=>$cedulas,
            'aporta'=>$aporta,
            'roles'=>$MisRoles,
            'buzon'=>$buzon,
            'proyectos'=>$proyectos,
            'autores'=>$autores,
        ]);
    }

    ############### Para abrir el modal de solicitud de nvo rol
    public function AbrirModalParaPedirNvoRol(){
        #####<livewire:sistema.modal-home-solicita-rol-component />
        $this->dispatch('AbreModalPedirNvoRol');
    }

    ###### Para abrir el modal de Proyecto
    public function AbrirModalProyecto($proyid){
        #####<livewire:sistema.modal-proyecto-component />
        $datos=[
            'proyId'=>$proyid,   ### proy_id o 0 para nuevo
        ];
        $this->dispatch('AbreModalProyecto',$datos);
    }
}
