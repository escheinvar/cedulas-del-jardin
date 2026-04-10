<?php

namespace App\Livewire\Web;

use App\Models\autor_txt;
use App\Models\ced_autores;
use App\Models\autor_url;
use App\Models\Imagenes;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AutoresController extends Component
{
    public $jardin, $url; ##### Vars. recibidas por URL
    public $edit, $editMaster, $enEdit; ###### Vars. de edición
    ###### Variables de página autores:
    public $traduccion;

    #[Layout('plantillas.baseJardin')]
    public function mount($jardin,$url){
        ##### Carga variables recibidas por URL: carga jardín
        $this->jardin=$jardin;

        ##### Carga variables recibidas por URL: carga datos url
        $this->url=autor_url::whereRaw('LOWER(aurl_cjarsiglas) = ?',strtolower($jardin))
            ->where('aurl_url',$url)
            ->where('aurl_del','0')
            ->with('autor')
            ->with('lengua')
            ->with('jardin')
            ->first();
        // dd($this->url);

        if(is_null($this->url)) {
            redirect('/errorLa dirección indicada es incorrecta');
        }else{
            if( $this->url->url_act=='0' or $this->url->count() < '0'){
                redirect('/errorLa dirección indicada es incorrecta');
            }
        }

    }

    public function CambiaAunaTraduccion(){
        if($this->traduccion != ''){
            $dato=autor_url::where('aurl_id',$this->traduccion)->first();
            // dd($dato,'/jardin/'.$dato->urlj_cjarsiglas.'/'.$dato->urlj_url);
            redirect('/autor/'.$dato->aurl_cjarsiglas.'/'.$dato->aurl_url);
        }
    }

    public function render(){
        ##### Revisa permisos del usuario
        $auts=['admin','webmaster']; ##### array de roles autorizados a editar
        $this->edit='0';
        if(session('rol')){
            if(array_intersect($auts,session('rol')) and $this->url->aurl_edit=='1' ){
                $this->edit='1';
                $this->editMaster='1';
            }else{
                $this->edit='0';
                $this->editMaster='0';
            }
        }

        ##### Revisa si la página es pública:
        if($this->url->aurl_edit == '1'){
            $this->enEdit='1';
        }else{
            $this->enEdit='0';
        }

        ##### Carga textos
        $txt=autor_txt::where('autxt_cjarsiglas',$this->jardin)
            ->where('autxt_aurlurltxt',$this->url->aurl_urltxt)
            ->where('autxt_act','1')->where('autxt_del','0')
            ->orderBy('autxt_orden')
            ->with('cedulas')
            ->with('url')
            ->get();

        ##### Carga Objetos
        $objs=Imagenes::where('img_cjarsiglas',$this->jardin)
            ->where('img_urltxt',$this->url->aurl_urltxt)
            ->where('img_del','0')
            ->where('img_act','1')
            ->get();
        ##### Carga las cédulas del autor
        $ceds=ced_autores::where('aut_cautid',$this->url->autor->caut_id)
            ->where('aut_act','1')->where('aut_del','0')
            ->with('autor')
            ->with('cedula')
            ->get();

        ##### Detecta Traducciones
        $traducciones=autor_url::where('aurl_cjarsiglas', $this->jardin)
            ->where('aurl_urltxt',$this->url->aurl_urltxt)
            ->where('aurl_url','!=',$this->url->aurl_url)
            ->where('aurl_act','1')->where('aurl_del','0')
            ->with('lengua')
            ->orderBy('aurl_lencode')
            ->get();

        return view('livewire.web.autores-controller',[
            'objs'=>$objs,
            'txt'=>$txt,
            'ceds'=>$ceds,
            'traducciones'=>$traducciones,
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
            'imgkey'=>$this->jardin.'@'.$this->url->aurl_urltxt, ### key: Jardin@urltxt (sin traduccción)  o null
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

    ############################################################
    ############################## Abre modal de editor de texto
    public function AbreModalEditaParrafo($id, $orden, $modulo, $jardin, $url,$reload){
        #####<livewire:sistema.jardin-web-modal-component />
        if($this->edit=='1'){
            ##### Abre modal
            $data=[
                'id'=>$id,
                'orden'=>$orden,
                'modulo'=>'autor',
                'jardin'=>$this->jardin,
                'url'=>$this->url->aurl_url,
                'reload'=>$reload,
            ];

            $this->dispatch('AbreModalDeParrafoWebJardin',$data);
        }
    }
}
