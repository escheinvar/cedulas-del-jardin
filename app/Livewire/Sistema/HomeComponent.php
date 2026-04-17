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
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


// #[Layout('components.layouts.SistemaBase')]
class HomeComponent extends Component
{
    ##### Variables de autorización de nivel de privilegio
    public $edit, $editMaster, $editjar, $JardUsr;
    ##### Variables de solicitud de nuevo rol
    // public $verNvoRol, $jardinesRol, $rolesRol, $jardinRol, $rolRol, $msjRol;

    public function mount(){
        // $this->verNvoRol='0';

    }

    // public function VerNoVerNvoRol(){
    //     if($this->verNvoRol=='1'){
    //         $this->verNvoRol='0';
    //     }else{
    //         $this->verNvoRol='1';
    //     }
    //     $this->jardinesRol=CatJardinesModel::get();
    //     $this->rolesRol=CatRolesModel::get();
    // }



    ##### Termina imágens
    public function render(){
        ##### Revisa permisos del usuario
        $auts=['editor','admin','autor','traductor']; ##### array de roles autorizados a editar
        if(array_intersect($auts,session('rol'))){
            $this->edit='1';

        }else{
            $this->edit='0';
            // redirect('/noauth/Solo accede rol '.implode(',',$auts));
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

        return view('livewire.sistema.home-component',[
            'cedulas'=>$cedulas,
            'aporta'=>$aporta,
            'roles'=>$MisRoles,
            'buzon'=>$buzon,
        ]);
    }

    ############### Para abrir el modal de solicitud de nvo rol
    public function AbrirModalParaPedirNvoRol(){
        #####<livewire:sistema.modal-home-solicita-rol-component />
        $this->dispatch('AbreModalPedirNvoRol');
    }
}
