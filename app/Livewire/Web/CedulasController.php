<?php

namespace App\Livewire\Web;

use App\Models\cedulas_url;
use App\Models\Imagenes;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CedulasController extends Component
{
    public $jardin, $url; ##### Vars. recibidas por URL
    public $edit, $enEdit; ###### Vars. de edición
    ###### Variables de página cédulas:
    public $traducciones; ##### get() de cédulas con igual urltxt
    public $objs; ##### get() de fotos de la cédulas

    #[Layout('plantillas.baseJardin')]
    public function mount($jardin,$url){
        ##### Carga variables recibidas por URL: carga jardín
        $this->jardin=$jardin;

        ##### Carga variables recibidas por URL: carga datos url
        $this->url=cedulas_url::where('url_cjarsiglas','ilike',strtolower($jardin))
            ->where('url_url',$url)
            ->where('url_del','0')
            ->with('jardin')
            ->with('lenguas')
            ->with('autores')
            ->first();

        if(is_null($this->url)) {
            redirect('/errorLa dirección indicada es incorrecta');
        }else{
            if( $this->url->url_act=='0' or $this->url->count() < '0'){
                redirect('/errorLa dirección indicada es incorrecta');
            }
        }

        ##### Carga todas las traducciones de la url
        $this->traducciones=cedulas_url::where('url_cjarsiglas', $this->url->url_cjarsiglas)
            ->where('url_urltxt',$this->url->url_urltxt)
            ->where('url_id','!=',$this->url->url_id)
            ->where('url_act','1')->where('url_del','0')
            ->with('lenguas')
            ->with('jardin') ##quitar cuando quite $traducciones en lína 169 de la vista
            ->orderBy('url_lencode')
            ->get();
    }

    public function AbreModalObjeto($id,$tipo){
        $data=[
            'ImgId'=>$id,
            'SiglasJardin'=>$this->url->url_cjarsiglas,
            'ModuloCatImg'=>'cedula',
            'TipoCatImg'=>$tipo,  #'Obligatorio: cimg_tipo de tabla cat_imgs'
            'Url'=>$this->url->url_url,
            'Lengua'=>$this->url->url_lencode,      #'len_code de tabla lenguas o vacío',
            'Reload'=> '1',     #'0 o 1. Al cerrar, se recarga (1) o no (0) la pag'
        ];
        $this->dispatch('abreModalDeImagen', $data);
    }

    public function EliminaImagen($id){
        Imagenes::where('img_id',$id)->update([
            'img_del'=>'1',
        ]);
        $this->dispatch('AvisoExitoCedula',msj:'Se eliminó correctamente la imágen.');
    }

    public function render(){
        ##### Revisa permisos del usuario
        $auts=['editor','admin','traductor','autor']; ##### array de roles autorizados a editar
        $this->edit='0';
        if(session('rol')){
            if(array_intersect($auts,session('rol')) ){
                $this->edit='1';
            }else{
                $this->edit='0';
            }
        }

        ##### Revisa si la página es pública:
        if($this->url->url_edo <= '4'){
            $this->enEdit='1';
        }else{
            $this->enEdit='0';
        }

        ##### Obtiene fotos, audios y videos de la cédula
        $this->objs=Imagenes::where('img_urlurl',$this->url->url_url)
            ->where('img_act','1')->where('img_del','0')
            ->get();



        return view('livewire.web.cedulas-controller');
    }
}


