<?php

namespace App\Livewire\Web;

use App\Models\cat_autores;
use App\Models\ced_autores;
use App\Models\Imagenes;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AutoresController extends Component
{
    public $jardin, $url; ##### Vars. recibidas por URL
    public $edit, $editMaster, $enEdit; ###### Vars. de edición
    ###### Variables de página cédulas:

    #[Layout('plantillas.baseJardin')]
    public function mount($jardin,$url){
        ##### Carga variables recibidas por URL: carga jardín
        $this->jardin=$jardin;

        ##### Carga variables recibidas por URL: carga datos url
        $this->url=cat_autores::whereRaw('LOWER(caut_cjarsiglas) = ?',strtolower($jardin))
            ->where('caut_url',$url)
            ->where('caut_del','0')
            ->with('jardin')
            // ->with('lenguas')
            ->first();

        if(is_null($this->url)) {
            redirect('/errorLa dirección indicada es incorrecta');
        }else{
            if( $this->url->url_act=='0' or $this->url->count() < '0'){
                redirect('/errorLa dirección indicada es incorrecta');
            }
        }
        // dd($this->url);
    }



    public function render(){
        ##### Verifica que sí tenga permiso web:
        if($this->url->caut_web=='0'){
            redirect('/errorLo sentimos, el sitio que buscas no existe.');
        }
        ##### Revisa permisos del usuario
        $auts=['editor','admin']; ##### array de roles autorizados a editar
        $this->edit='0';
        if(session('rol')){
            if(array_intersect($auts,session('rol'))){
                $this->edit='1';
                $this->editMaster='1';
            }else{
                $this->edit='0';
                $this->editMaster='0';
            }
        }
        $objs=Imagenes::where('img_cjarsiglas',$this->jardin)
            ->where('img_urltxt',$this->url->caut_url)
            ->where('img_del','0')
            ->where('img_act','1')
            ->get();


        return view('livewire.web.autores-controller',[
            'objs'=>$objs,
        ]);
    }

    #################################################################
    ######################### Modal para incertar objeto
    public function AbrirModalPaIncertarObjeto($imgId, $cimgmodulo, $cimgtipo, $imgkey, $reload){
        #####<livewire:sistema.modal-inserta-objeto-component />
        $datos=[
            'imgId'=>$imgId,               ### img_id o 0 para nuevo
            'cimgmodulo'=>$cimgmodulo,   ### cimg_modulo de cat_img (cedula,jardin,autor) o null
            'cimgtipo'=>$cimgtipo,        ###cimg_tipo de cat_img (web, portada, ppal,lat, etc...)  o null
            'imgkey'=>$this->jardin.'@'.$this->url->caut_url, ### key: Jardin@urltxt (sin traduccción)  o null
            'reload'=>$reload,            ### indica si hace reload(1) o no(0) al guardar
        ];
        $this->dispatch('AbreModalIncertaObjeto',$datos);
    }
    #################################################################
    ######################### Modal para editar autor
     public function AbreModalAutores($par1){
        if($this->edit=='1'){
            $data=[
                'cautId'=>$par1,
                'cjarsiglas'=>$this->jardin,
            ];
            $this->dispatch('AbreModalDeAutores',$data);
        }
    }
}
