<?php

namespace App\Livewire\Sistema;

use App\Models\Imagenes;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalVerObjetoComponent extends Component
{

    public $modver_jardin, $modver_modulo, $modver_url, $modver_tipoObjeto;
    public $modver_objetos, $modver_tipoRecibido, $modver_tipoSelected; #### vars. recibidas de fuera
    #################################################################
    ########## Abre modal de objetos
    #[On('AbreModalDeVerObjetos')]
    public function MontandoDatosPaVer($data){
        $this->modver_jardin=$data['jardin'];
        $this->modver_modulo=$data['modulo'];
        $this->modver_url=$data['url'];
        $this->modver_tipoObjeto=$data['tipoDato'];
        if($this->modver_tipoObjeto==''){
            $this->modver_tipoSelected='%';
            $this->modver_tipoRecibido='0';
        }else{
            $this->modver_tipoSelected=$this->modver_tipoObjeto;
            $this->modver_tipoRecibido='1';
        }
        #dd($data);
    }

    public function mount(){
        $this->modver_objetos=collect();
        $this->modver_tipoSelected='';
    }

    public function CierraModalVerObjetos(){
        $this->dispatch('CierraModalDeVerObjetos');
    }

    public function render() {


        ################## Descarga objetos
        $this->modver_objetos=Imagenes::where('img_act','1')->where('img_del','0')
            ->where('img_cjarsiglas',$this->modver_jardin)
            ->where('img_cimgmodulo',$this->modver_modulo)
            ->where('img_tipo','ilike', $this->modver_tipoSelected)
            ->with('alias')
            ->get();
#dd($this->modver_objetos,$this->modver_jardin, $this->modver_modulo,$this->modver_tipoSelected);
        return view('livewire.sistema.modal-ver-objeto-component');
    }

    #################################################################
    #######################   Abre modal para NUEVO objeto
    public function AbrirModalPaIncertarObjeto($imgId, $cimgmodulo, $cimgtipo, $imgkey, $reload){

        #####<livewire:sistema.modal-inserta-objeto-component />
        if($imgkey==''){
            $imgkey=$this->modver_jardin.'@'.$this->modver_url;
        }

        $datos=[
            'imgId'=>$imgId,           ### img_id o 0 para nuevo
            'cimgmodulo'=>$cimgmodulo,     ### cimg_modulo de cat_img (cedula,jardin,autor) o null
            'cimgtipo'=>$cimgtipo,          ###cimg_tipo de cat_img (web, portada, ppal,lat, etc...)  o null
            'imgkey'=>$imgkey,  #### key: Jardin@urltxt (sin traduccción)  o null
            'reload'=>$reload,          ##### indica si hace reload(1) o no(0) al guardar
        ];

        $this->dispatch('AbreModalIncertaObjeto',$datos);
    }
}
