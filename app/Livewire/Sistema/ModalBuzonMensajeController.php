<?php

namespace App\Livewire\Sistema;

use App\Models\buzon;
use App\Models\CatJardinesModel;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalBuzonMensajeController extends Component
{
    /*##################################### Para abrir el modal,
      ##### Requiere la variable $buzID con Id del mensaje o 0 para nuevo
    public function AbreModalDeMensaje($buzID){
        ##### <livewire:sistema.modal-buzon-mensaje-controller />

        $data=['buzID'=>$buzID];
        $this->dispatch('AbreModalDeMensaje',$data);
    }
    ################################################## */

    public $destinatarios, $jardinTo, $rolTo, $msjTo, $msjToName,$asunto, $mensaje,$msjNuevo, $replyTo;



    #[On('AbreModalDeMensaje')]
    public function MontandoModalDeMensaje($data){
        $buzId=$data['buzID'];
        $this->msjNuevo=$buzId;
        if($this->msjNuevo=='0'){
            $this->msjTo='';
            $this->msjToName='';
            $this->replyTo='';
        }else{
            $this->msjTo=buzon::where('buz_id',$buzId)->value('buz_from');
            $this->msjToName=buzon::where('buz_id',$buzId)->join('users','buz_from','=','id')->value('usrname');
            $this->replyTo=$buzId;
        }
    }

    public function mount(){
        $this->msjNuevo='';
        $this->rolTo='';
    }

    public function CierraModalMensaje(){
        $this->reset(['msjTo','msjToName','mensaje','asunto']);
        $this->resetErrorBag();
        $this->resetValidation();
        $this->dispatch('CierraModalDeMensaje');
    }

    public function EnviarMensaje(){
        $this->validate([
            'msjTo'=>'required',
            'asunto'=>'required',
            'mensaje'=>'required'
        ]);
        if($this->msjNuevo=='0'){
            $MiNota='';
        }else{
            $origen=buzon::where('buz_id',$this->replyTo)
                ->with('para')
                ->with('de')
                ->first();
            $MiNota='<nota>'.
                $origen->de->nombre.' '.$origen->de->apellido.' escribió: '.
                '<b>Asunto: '.$origen->buz_asunto.'</b> '.
                $origen->buz_mensaje.
                $origen->buz_notas.
                '</nota>';
        }

        ##### Envía mensaje a buzón
        EnviaMensajeAbuzon(
            $this->msjTo,     ### to:id usr del destinatario
            Auth::user()->id, ### from: id usr del remitente o 0 para sistema
            $this->asunto,    ### asunto: texto del asunto
            $this->mensaje,   ### mensaje: <html> del mensaje
            $MiNota,          ### notas: <html> de las notas
            $this->msjNuevo   ### ifReply; msj_id del mensaje al que se responde (o 0 para mensaje nuevo)
        );

        $this->CierraModalMensaje();
    }

    public function render()    {
        ##### Carga lista de jardines
        $jardines=CatJardinesModel::get();

        if($this->jardinTo != ''){
            $rolesEnJar=UserRolesModel::whereIn('rol_cjarsiglas',['todos',$this->jardinTo])
                ->where('rol_usrid','!=',Auth::user()->id)
                ->where('rol_del','0')
                ->where('rol_act','1')
                ->distinct('rol_crolrol')
                ->pluck('rol_crolrol')
                ->toArray();
        }else{
            $rolesEnJar=[];
        }

        ##### Lista de destinatarios en "enviar mensaje a..."
        if($this->jardinTo != '' and $this->rolTo != ''){
            $dest=UserRolesModel::whereIn('rol_cjarsiglas',['todos',$this->jardinTo])
                ->where('rol_crolrol',$this->rolTo)
                ->where('rol_usrid','!=',Auth::user()->id)
                ->where('rol_del','0')
                ->where('rol_act','1')
                ->with('usr')
                ->orderBy('rol_tipo1','asc')
                ->orderBy('rol_crolrol','asc')
                ->get();

        }else{
            $dest=collect();
        }

        return view('livewire.sistema.modal-buzon-mensaje-controller',[
            'jardines'=>$jardines,
            'rolesEnJar'=>$rolesEnJar,
            'dest'=>$dest,
        ]);
    }
}
