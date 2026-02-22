<?php

namespace App\Livewire\Sistema;

use App\Models\CatRolesModel;
use App\Models\SistBuzonMensajesModel;
use App\Models\User;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;



#[Layout('components.layouts.SistemaBase')]
class BuzonComponent extends Component{

    public $verLeidos, $VerEnviarMsj, $MsjA, $MsjAsunto, $RepplyTo, $Msj;
    public $ganonesLee, $ganonesBorra;

    public function mount(){
        $this->verLeidos='0';
        $this->VerEnviarMsj='0';
        $this->ganonesLee=[];
        $this->ganonesBorra=[];
        $this->ActualizaNumerosBuzon();
    }

    public function ActualizaNumerosBuzon(){
        $buzon= SistBuzonMensajesModel::where('buz_act','1')
            ->where(function($q){
                return $q
                ->where('buz_destino_usr',Auth::id())
                ->orWhereIn('buz_destino_rol',session('rol'));
            })
            ->where('buz_leido','0')
            ->count();

        session([
            'buzon'=>$buzon,
        ]);
    }
    public function VerNoVerLeidos(){
        if($this->verLeidos=='1'){
            $this->verLeidos='0';
        }else{
            $this->verLeidos='1';
        }
    }

    public function LeerMensajes(){
        foreach($this->ganonesLee as $i){
            $estado=SistBuzonMensajesModel::where('buz_id',$i)->value('buz_leido');
            if($estado=='1'){
                $nuevo='0';
            }else{
                $nuevo='1';
            }
            SistBuzonMensajesModel::where('buz_id',$i)->update([
                'buz_leido'=>$nuevo,
            ]);
        }
        $this->ganonesLee=[];
        $this->ActualizaNumerosBuzon();
    }

    public function BorrarMensajes(){
        foreach($this->ganonesBorra as $i){
            SistBuzonMensajesModel::where('buz_id',$i)->update([
                'buz_act'=>'0',
            ]);
        }
        $this->ganonesBorra=[];
        $this->ActualizaNumerosBuzon();
    }

    public function VerEnviar($valor){
        $this->VerEnviarMsj=$valor;
    }

    public function enviarMsj(){
        $this->validate([
            'MsjA'=>'required',
            'MsjAsunto'=>'required',
            'Msj'=>'required',
        ]);
        SistBuzonMensajesModel::create([
            'buz_modulo'=>'buzon',
            'buz_usr_origen'=>Auth::user()->id,
            'buz_destino_usr'=>$this->MsjA,
            'buz_notas'=>'Mensaje escrito y enviado por el usuario '.Auth::user()->usrname,
            'buz_asunto'=>$this->MsjAsunto,
            'buz_mensaje'=>$this->Msj,
            'buz_notas'=>'Respuesta a-> '.$this->RepplyTo['buz_mensaje'],
            'buz_date_origen'=>date('Y-m-d H:i:s.000'),
        ]);
        $this->cancelarMsj();
    }

    public function ReplyMsj($buzid){
        $this->VerEnviarMsj='1';
        $mensaje=SistBuzonMensajesModel::where('buz_id',$buzid)->first();
        $this->RepplyTo=$mensaje->toArray();
        $this->MsjA=$mensaje->buz_usr_origen;
        $this->MsjAsunto='Respuesta a "'.$mensaje->buz_asunto.'"';
    }

    public function cancelarMsj(){
        $this->MsjA='';
        $this->MsjAsunto='';
        $this->Msj='';
        $this->VerEnviarMsj='0';
        $this->RepplyTo='';
    }


    public function render(){
        ##### Lista de destinatarios para corro
        $participes=['cedulas','traduce','admin','webmaster'];
        if(array_intersect(session('rol'), $participes)){
            $dest=UserRolesModel::where('rol_act','1')
            ->whereIn('rol_crolrol',   $participes  )
            ->orderBy('rol_crolrol')
            ->orderBy('rol_tipo1')
            ->orderBy('rol_tipo2')
            ->join('users','rol_usrid','=','id')
            ->select('rol_usrid','rol_crolrol','rol_tipo1','rol_tipo2','usrname')
            ->get();

        }else{
            $dest=UserRolesModel::where('rol_act','1')
            ->where('rol_crolrol',   'admin'  )
            ->join('users','rol_usrid','=','id')
            ->select('rol_usrid','rol_crolrol','rol_tipo1','rol_tipo2','usrname')
            ->get();
        }

        $buzon= SistBuzonMensajesModel::where('buz_act','1')
            ->where(function($q){
                return $q
                ->where('buz_destino_usr',Auth::id())
                ->orWhereIn('buz_destino_rol',session('rol'));
            })
            ->orderBy('buz_date_origen','desc')
            ->join('users','buz_usr_origen','=','id')
            ->select('buz_id','buz_act','buz_leido','buz_usr_origen','buz_destino_usr','buz_notas','buz_asunto','buz_mensaje','buz_date_origen','usrname')
            ->get();
        $propios=SistBuzonMensajesModel::where('buz_usr_origen',Auth::user()->id)
            ->join('users','buz_destino_usr','=','id')
            ->select('buz_id','buz_destino_usr','buz_notas','buz_asunto','buz_mensaje','buz_date_origen','usrname')
            ->orderBy('buz_date_origen','desc')
            ->get();

        return view('livewire.sistema.buzon-component',[
            'buzon'=>$buzon,
            'dest'=>$dest,
            'propios'=>$propios,
        ]);
    }
}
