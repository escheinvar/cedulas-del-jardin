<?php

namespace App\Livewire\Sistema;

use Livewire\Component;

class ErrorComponent extends Component
{
    public $error;

    public function mount($tipo){
        ###### Quita la r de erroR
        $this->error=substr($tipo,1);
    }

    public function render(){
        if($this->error==''){
            $msg='No se puede continuar.';

        }elseif($this->error=='1'){

            $msg='No estás autorizado a este recurso';
        }elseif($this->error=='2'){
            $msg="Esta página ya caducó o no existe";

        }else{
            $msg=$this->error;
        }

        return view('livewire.sistema.error-component',[
            'msg'=>$msg,
        ]);
    }
}
