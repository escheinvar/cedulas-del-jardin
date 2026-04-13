<?php

namespace App\Livewire\Sistema;

use App\Models\ced_aporteusrs;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalAdminAportesPublicoComponent extends Component
{
    /*################################################################
    ####### Para usar este modal, debes indicar el id del mensaje a
    ####### revisar
    public function AbrirModalParaEditarAporteDeVisitante($msg_id){
        #####<livewire:sistema.modal-admin-aportes-publico-component />
        $dato=[
            'msgId'=>$msg_id,
        ];
        $this->dispatch('AbreModalParaEditarAporteDeVisitante',$dato);
    }
    ################################################################*/

    public $ModalMsg_id, $msg, $ModalMsg_mensaje;

    #[On('AbreModalParaEditarAporteDeVisitante')]
    public function montandomodal($dato){
        $this->ModalMsg_id=$dato['msgId'];
        $this->msg=ced_aporteusrs::where('msg_id',$this->ModalMsg_id)->first();
        $this->ModalMsg_mensaje=ced_aporteusrs::where('msg_id',$this->ModalMsg_id)->value('msg_mensaje');
    }

    public function mount(){
        $this->msg=collect();
    }

    public function CerrarModalParaEditarAporteDeVisitante(){
        $this->dispatch('CierraModalParaEditarAporteDeVisitante');
    }

    public function CambiaEstado($edo){

        ###### Cambia el estado
        ced_aporteusrs::where('msg_id',$this->ModalMsg_id)->update([
            'msg_edo'=>$edo,
            'msg_mensaje'=>$this->ModalMsg_mensaje,
        ]);
        ##### Genera log
        paLog('Cambia estado de aporte público','ced_aporteusrs',$this->ModalMsg_id);
        ##### Cierra modal
        $this->dispatch('CierraModalParaEditarAporteDeVisitante');
        redirect('/admin_aportes');
    }

    public function render()  {
        return view('livewire.sistema.modal-admin-aportes-publico-component');
    }
}
