<?php

namespace App\Livewire\Sistema;

use App\Models\CatJardinesModel;
use App\Models\CatRolesModel;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalHomeSolicitaRolComponent extends Component
{
    /*#############################################################
    ############### Para abrir el modal:
    public function AbrirModalParaPedirNvoRol(){
        #####<livewire:sistema.modal-home-solicita-rol-component />
        $this->dispatch('AbreModalPedirNvoRol');
    }
    ###############################################################*/

    public $jardinesRol, $rolesRol, $jardinRol, $rolRol, $msjRol;

    public function LimpiarModalParaPedirNvoRol(){
        $this->reset(['jardinRol', 'rolRol', 'msjRol']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function CerrarModalParaPedirNvoRol(){
        $this->LimpiarModalParaPedirNvoRol();
        $this->dispatch('CierraModalPedirNvoRol');

    }

    public function SolicitarRol(){
        ##### Valida
        $this->validate([
            'jardinRol'=>'required',
            'rolRol'=>'required',
            'msjRol'=>'required|string|min:10'
        ]);

        ##### Busca administradores:
        $admins=UserRolesModel::whereIn('rol_cjarsiglas',['todos',$this->jardinRol])
            ->where('rol_crolrol','admin')
            ->where('rol_del','0')
            ->where('rol_act','1')
            ->distinct('rol_usrid')
            ->pluck('rol_usrid')
            ->toArray();

        ##### Envía mensaje a buzón
        foreach($admins as $a){
            $to=$a;        ##### id de users de destino
            $from=Auth::user()->id;      ##### id de users de quien escribe o 0 para sistema
            $ifReply='0';   ##### 0 para mensajes nuevos o msj_id para respuesta a msj previo
            $asunto="Solicitud de asignación de rol";
            $mensaje='El usuario: usr <b>'. Auth::user()->usrname .'</b> (id '.Auth::user()->id.') '.Auth::user()->email.' solicita el rol <b>'.$this->rolRol.'</b> en el jardín <b>'.$this->jardinRol.
                "</b> (ir a <a href='".url('/admin_usuarios')."'>admin de usuarios</a>)";
            $notas=$this->msjRol;
            ##### Envía mensaje con función de helper
            $a=EnviaMensajeAbuzon($to,$from,$asunto, $mensaje,$notas,$ifReply);
            if($a > '0'){
                $this->dispatch('AvisoExitoHome', msj:'Error en el envío del mensaje');
                return;
            }
        }
        ###### Limpia cuestionario
        $this->reset(['jardinRol','rolRol','msjRol']);
        $this->resetErrorBag();
        $this->resetValidation();
        // $this->verNvoRol='0';
        $this->dispatch('AvisoExitoHome',msj:'Tu solicitud fue enviada al administrador');
    }


    public function render() {
        $this->jardinesRol=CatJardinesModel::get();
        $this->rolesRol=CatRolesModel::get();
        return view('livewire.sistema.modal-home-solicita-rol-component',[
            'jardinesRol',
            'rolesRol',
        ]);
    }
}
