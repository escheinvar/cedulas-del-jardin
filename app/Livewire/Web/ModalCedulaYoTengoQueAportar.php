<?php

namespace App\Livewire\Web;

use Livewire\Component;

class ModalCedulaYoTengoQueAportar extends Component
{

    /*################################################
    ##### Este modal, requiere se ejecute esta función
    ##### desde el controlador disparador:
    public function AbrirModalYoTengoAlgoQueAportar(){
        $this->dispatch('AbreModalYoTengoQueAportar');
    }
    #################################################*/

    public function CancelaMensajeUsr(){
        $this->dispatch('CierraModalYoTengoQueAportar');
    }

    public function GuardarNuevoMensaje(){
        dd('falta');
    }

    public function render(){
        return view('livewire.web.modal-cedula-yo-tengo-que-aportar');
    }
}
