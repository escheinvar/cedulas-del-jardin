<?php

namespace App\Livewire\Sistema;

use App\Models\buzon;
use App\Models\CatJardinesModel;
use App\Models\UserRolesModel;
use App\Models\usr_roles;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class BuzonController extends Component
{
    use WithPagination;

    public $buzon,$verLeidos,$verEnviados, $VerEnviarMsj, $MsjA, $MsjAsunto, $RepplyTo, $Msj;
    public $ganonesLee, $ganonesBorra,$SelectTodo;
    // public $destinatarios, $jardines, $jardinTo, $msjTo, $msjToName,$asunto, $mensaje,$msjNuevo, $replyTo;

    ##################################################################
    ########## NOTA: Este buzón utiliza la función gneneral /App/Helpers/EnviaMensajeAbuzon.php
    ##########       el cual usa la extensión Mailgun y sus archs /App/Mail/CorreoPorAvisoDeBuzon.php
    ##################################################################
    public function mount(){
        $this->verLeidos=FALSE;
        $this->verEnviados=FALSE;
        $this->ganonesLee=[];
        $this->ganonesBorra=[];
        $this->SelectTodo=FALSE;
        // $this->jardines=collect();
    }

    public function LeerMensajes(){
        foreach($this->ganonesLee as $i){
            $estado=buzon::where('buz_id',$i)->value('buz_act');
            if($estado=='1'){
                $nuevo='0';
            }else{
                $nuevo='1';
            }
            buzon::where('buz_id',$i)->update([
                'buz_act'=>$nuevo,
            ]);
        }
        $this->ganonesLee=[];
        // redirect('/buzon');
    }

    public function MarcarComoLeido($id){
        $estado=buzon::where('buz_id',$id)->value('buz_act');
        if($estado=='1'){
            $nuevo='0';
        }else{
            $nuevo='1';
        }
        buzon::where('buz_id',$id)->update([
            'buz_act'=>$nuevo,
        ]);
        ###### actualiza sesión
        $buzonSesion= buzon::where('buz_act','1')
            ->where('buz_del','0')
            ->where('buz_to',Auth::user()->id)
            ->count();
        session([
            'buzon'=>$buzonSesion,
        ]);
    }

    public function BorrarMensajes(){
        #foreach($this->ganonesBorra as $i){
        foreach($this->ganonesLee as $i){
            buzon::where('buz_id',$i)->update([
                'buz_del'=>'1',
                'buz_date_borrado'=>date('Y-m-d H:i:s'),
            ]);
        }
        #$this->ganonesBorra=[];
        $this->ganonesLee=[];
        redirect('/buzon');
    }

    public function MarcaDesmarcaTodo(){
        if($this->SelectTodo==TRUE){
            $this->ganonesLee=$this->buzon->pluck('buz_id');
        }else{
            $this->ganonesLee=[];
        }
    }

    public function render(){

        $buzonSesion= buzon::where('buz_act','1')
            ->where('buz_del','0')
            ->where('buz_to',Auth::user()->id)
            ->count();
        session([
            'buzon'=>$buzonSesion,
        ]);

        $paginas='5';
        if($this->verLeidos==TRUE){$leidos='<=';}else{$leidos='=';}
        if($this->verEnviados==TRUE){
            $this->buzon= buzon::where('buz_del','0')
            ->where('buz_act',$leidos,'1')
            ->where('buz_to',Auth::user()->id)
            ->orWhere('buz_from',Auth::user()->id)
            ->leftJoin('users','buz_from','=','id')
            ->orderBy('buz_date','desc')
            ->orderBy('buz_hora','desc')
            // ->paginate($paginas);
            ->get();
        }else{
            $this->buzon= buzon::where('buz_del','0')
                ->where('buz_act',$leidos,'1')
                ->where('buz_to',Auth::user()->id)
                ->leftJoin('users','buz_from','=','id')
                ->orderBy('buz_date','desc')
                ->orderBy('buz_hora','desc')
                // ->paginate($paginas);
                ->get();
        }



        return view('livewire.sistema.buzon-controller',[

        ]);
    }

    ########################################
    ###### Ejecuta modal de nuevo mensaje buzón
    public function AbreModalDeMensaje($buzID){
        ##### <livewire:sistema.modal-buzon-mensaje-controller />

        $data=['buzID'=>$buzID];
        $this->dispatch('AbreModalDeMensaje',$data);
    }




}
