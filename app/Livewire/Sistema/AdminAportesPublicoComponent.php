<?php

namespace App\Livewire\Sistema;

use App\Models\CatJardinesModel;
use App\Models\ced_aporteusrs;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminAportesPublicoComponent extends Component
{

    public $edit, $editMaster,$editjar;

    public function mount(){

    }

    public function CambiaEdoMsg($idmsg,$edo){
        ced_aporteusrs::where('msg_id',$idmsg)->update(['msg_edo'=>$edo]);
    }

    public function BorrarMsg($idmsg){
        ced_aporteusrs::where('msg_id',$idmsg)->update(['msg_act'=>'0']);
    }
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

        ##### Recupera aportaciones a revisar
        $aporta=ced_aporteusrs::where('msg_act','1')
            ->whereIn('msg_cjarsiglas', $JardsUsr->pluck('cjar_siglas')->toArray())
            ->orderBy('msg_date','desc')
            ->with('jardin')
            ->with('cedula')
            ->orderBy('msg_edo')
            ->orderBy('msg_date')
            ->get();

        return view('livewire.sistema.admin-aportes-publico-component',[
            'aporta'=>$aporta,
        ]);
    }

    ####################################################################
    ############### Modal para editar aporte
    public function AbrirModalParaEditarAporteDeVisitante($id){
        #####<livewire:sistema.modal-admin-aportes-publico-component />
        $dato=[
            'msgId'=>$id,
        ];
        $this->dispatch('AbreModalParaEditarAporteDeVisitante', $dato);
    }
}
