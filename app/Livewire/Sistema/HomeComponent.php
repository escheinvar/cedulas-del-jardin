<?php

namespace App\Livewire\Sistema;

use App\Models\Imagenes;
use App\Models\SpAporteUsrsModel;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;


// #[Layout('components.layouts.SistemaBase')]
class HomeComponent extends Component
{
    public $MisAportes;
    public $IdTemp, $IdTemp2, $IdTemp3; #### Temporal: para cargar algo de prueba

    public $edit='1';
    public function mount(){
        $this->MisAportes='0';
    }

    public function VerNoverAportes(){
        if($this->MisAportes=='0'){
            $this->MisAportes='1';
        }else{
            $this->MisAportes='0';
        }
    }

    public function CambiaEdoMsg($idmsg,$edo){
        SpAporteUsrsModel::where('msg_id',$idmsg)->update(['msg_edo'=>$edo]);
    }

    public function BorrarMsg($idmsg){
        SpAporteUsrsModel::where('msg_id',$idmsg)->update(['msg_act'=>'0']);
    }


    ##### Termina imágens
    public function render(){
        ##### Recupera aportaciones a revisar
        $aporta=SpAporteUsrsModel::where('msg_act','1')
            ->where('msg_usr',Auth::user()->id)
            ->leftJoin('sp_urlcedula','ced_id','=','msg_cedid')
            ->orderBy('msg_date','desc')
            ->get();
        $MisRoles=UserRolesModel::where('rol_usrid',Auth::user()->id)->where('rol_act','1')->where('rol_del','0')->get();

        return view('livewire.sistema.home-component',[
            'aporta'=>$aporta,
            'roles'=>$MisRoles,
        ]);
    }
}
