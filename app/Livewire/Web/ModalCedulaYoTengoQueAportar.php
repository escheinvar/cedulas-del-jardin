<?php

namespace App\Livewire\Web;

use App\Models\CatEntidadesInegiModel;
use App\Models\CatMunicipiosInegiModel;
use App\Models\ced_aporteusrs;
use App\Models\cedulas_url;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalCedulaYoTengoQueAportar extends Component
{

    /*################################################
    ##### Este modal, requiere se ejecute esta función
    ##### desde el controlador disparador:
    public function AbrirModalYoTengoAlgoQueAportar(){
        $dato=url_id;
        $this->dispatch('AbreModalYoTengoQueAportar',dato:$dato);
    }
    #################################################*/

    public $url_id; #### mensaje recibido desde fuera
    ###### variables:
    public $msg_nombre, $msg_alias, $msg_estado, $msg_mpio, $msg_comunidad;
    public $msg_lengua, $msg_edad, $msg_correo, $msg_tel, $msg_txt;



    #[On('AbreModalYoTengoQueAportar')]
    public function montaModal($dato) {
        $this->url_id=$dato['urlId'];
        $this->BorrarModal();
    }

    public function mount(){
        $this->msg_estado='';
    }

    public function BorrarModal(){
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['msg_nombre', 'msg_alias', 'msg_estado', 'msg_mpio', 'msg_comunidad', 'msg_lengua', 'msg_edad', 'msg_correo', 'msg_tel', 'msg_txt']);
    }

    public function CancelaMensajeUsr(){
        $this->BorrarModal();
        $this->dispatch('CierraModalYoTengoQueAportar');
    }

    public function GuardarNuevoMensaje(){
        ###### valida
        $this->validate([
            'msg_alias'=>'required',
            'msg_estado'=>'required',
            'msg_mpio'=>'required',
            'msg_comunidad'=>'required',
            'msg_lengua'=>'required',
            'msg_txt'=>'required|string|min:10',
        ]);
        ###### Genera set de datos
        $ced=cedulas_url::where('url_id',$this->url_id)->first();
        if(Auth::user()){$usr=Auth::user()->id;}else{$usr=null;}
        $dato=[
            'msg_edo'=>'0',
            'msg_cjarsiglas'=>$ced->url_cjarsiglas,
            'msg_urlid'=>$ced->url_id,
            'msg_url'=>$ced->url_url,
            'msg_urltxt'=>$ced->url_urltxt,
            'msg_nombre'=>$this->msg_nombre,
            'msg_usuario'=>$this->msg_alias,
            'msg_estado'=>$this->msg_estado,
            'msg_mpio'=>$this->msg_mpio,
            'msg_comunidad'=>$this->msg_comunidad,
            'msg_lengua'=>$this->msg_lengua,
            'msg_edad'=>$this->msg_edad,
            'msg_correo'=>$this->msg_correo,
            'msg_tel'=>$this->msg_tel,
            'msg_mensaje'=>$this->msg_txt,
            'msg_mensajeoriginal'=>$this->msg_txt,
            'msg_usr'=>$usr,
            'msg_date'=>date('Y-m-d'),
        ];

        ##### Guarda en BD
        $nvo=ced_aporteusrs::create($dato);

        ###### Guarda log
        paLog('Usuario envía msj','ced_aporteusrs',$nvo->id);

        ###### Envía msj
        $msj='Tu mensaje se envió y guardó correctamente en el servidor. Será publicado en cuanto sea revisado por un editor.';
        $this->dispatch('AvisoExitoMensajeNvo', msj:$msj);
        $this->CancelaMensajeUsr();

    }

    public function render(){
        if($this->msg_estado != ''){
            ##### Obtiene municipios
            $mpios=CatMunicipiosInegiModel::where('cmun_edoname',$this->msg_estado)->get();
        }else{
            $mpios=collect();
        }

        return view('livewire.web.modal-cedula-yo-tengo-que-aportar',[
            'estados'=>$estado=CatEntidadesInegiModel::get(),
            'mpios'=>$mpios,
        ]);
    }
}
