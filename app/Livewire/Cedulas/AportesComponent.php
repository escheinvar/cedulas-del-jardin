<?php

namespace App\Livewire\Cedulas;

use App\Models\CatJardinesModel;
use App\Models\SpAporteUsrsModel;
use App\Models\UserRolesModel;
use Database\Seeders\SpAporteUsrsSeeder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.SistemaBase')]
class AportesComponent extends Component
{

    public $ModoEdit, $edo, $orden, $sent;
    public $TextoEdita;

    public function mount(){
        $this->ModoEdit='0';
        $this->edo='0';
        $this->orden='msg_date';
        $this->sent='asc';
    }


    public function ordena($campo){
        $this->orden=$campo;
        if($this->sent=='asc'){
            $this->sent='desc';
        }else{
            $this->sent='asc';
        }
    }

    public function CambiaEdoMsg($idmsg,$edo){
        SpAporteUsrsModel::where('msg_id',$idmsg)->update(['msg_edo'=>$edo]);
        $this->edo=$edo;
    }

    public function IniciaEdita($id){
        $this->ModoEdit=$id;
        $this->TextoEdita=SpAporteUsrsModel::where('msg_id',$id)->value('msg_mensaje');
    }

    public function CancelaEditar(){
        $this->ModoEdit='0';
    }

    public function GuardarEdita($id){
        $viejo=SpAporteUsrsModel::where('msg_id',$id)->first();
        $nuevo=$viejo->replicate();
        $nuevo->msg_mensaje= $this->TextoEdita;
        $nuevo->save();
        SpAporteUsrsModel::where('msg_id',$id)->update(['msg_act'=>'0']);
        $this->ModoEdit='0';
    }

    public function render(){
        if(!in_array('cedulas',session('rol'))){
            redirect('/home');
        }
        $jards=UserRolesModel::where('rol_act','1')
            ->where('rol_usrid',Auth::user()->id)
            ->where('rol_crolrol','cedulas')
            ->pluck('rol_tipo1')
            ->toArray();
        if(in_array('todas',$jards)){
            $jards=CatJardinesModel::pluck('cjar_siglas')->toArray();
        }

        ##### Recupera aportaciones a revisar
        $aporta=SpAporteUsrsModel::leftJoin('sp_urlcedula','ced_id','=','msg_cedid')
            ->where('msg_act','1')
            ->where('msg_edo','=',$this->edo)
            ->whereIn('ced_cjarsiglas',$jards)
            ->orderBy($this->orden,$this->sent)
            ->get();

        return view('livewire.cedulas.aportes-component',[
            'aporta'=>$aporta,
        ]);
    }
}
