<?php

namespace App\Livewire\Web;

use Livewire\Component;
use Illuminate\Http\RedirectResponse;

class CodigoQrController extends Component
{
    public $qr;

    public function mount($codigoQR){
        MyRegistraVisita('web_codigoQR');
        if($codigoQR == 'bienvenida' OR $codigoQR=='despedida'){

        }else{
            return redirect('/errorNo existe ese QR (por el momento, solo bienvenida o despedida)');
        }

        $this->qr=$codigoQR;
    }

    public function render(){
        $ok='0';
        if($this->qr == 'bienvenida'){
            $texto='Esta va a ser alguna página de Bienvenida';
            $titulo="Bienvenida";
            $ok='1';
        }elseif($this->qr == 'despedida'){
            $texto='Esta va a ser la despedida';
            $titulo="Esperamos vuelvas pronto";
            $ok='1';
        }else{
            redirect('/error');
        }


        return view('livewire..web.codigo-qr-controller',[
            'texto'=>$texto,
            'titulo'=>$titulo,
        ]);
    }
}
