<?php

namespace App\Livewire\Web;

use App\Models\ced_autores;
use App\Models\cedulas_txt;
use App\Models\cedulas_url;
use App\Models\Imagenes;
use Livewire\Attributes\Layout;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Image;

class CedulasController extends Component
{
    public $jardin, $url; ##### Vars. recibidas por URL, y luego en url se guarda toda la info de cedula_url
    public $edit, $enEdit; ###### Vars. de edición
    ###### Variables de página cédulas:
    public $traducciones; ##### get() de cédulas con igual urltxt
    public $objs; ##### get() de fotos de la cédulas
    public $idiomaSelected; ##### Idioma seleccionado en el select de vista
    public $txt; #### get() de cedula_txt con todo el texto

    ###### Variables de modal Traduce titulo
    public $NuevoTituloTraducido;

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

    public function AbreModalObjetoEnCedula($id,$tipo){
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

    public function CambiaIdiomaCedula(){
        if($this->idiomaSelected != ''){
            $ruta='/cedula/'.$this->url->url_cjarsiglas.'/'.$this->idiomaSelected;
            redirect ($ruta);
        }
    }

    public function AbreModalEditaTextoWebJardin($id, $orden){
        if($this->edit=='1'){
            ###### Si es nuevo, calcula el orden
            if($id=='0'){
                // $orden=jardin_txt::where('jar_urljid',$this->url->urlj_id)
                //     ->where('jar_act','1')->where('jar_del','0')
                //     ->max('jar_orden') + 1;
            }
            ##### Abre modal
            $data=[
                'id'=>$id,
                'orden'=>$orden, '',

                'urljid'=>$this->url->urlj_id,
                'urljurl'=>$this->url->urlj_url,
                'urljurltxt'=>$this->url->urlj_urltxt,
                'cjarsiglas'=>$this->url->urlj_cjarsiglas,

            ];
            $this->dispatch('AbreModalDeParrafoWebJardin',$data);
        }
    }


    public function render(){
        ##### Revisa permisos del usuario (rol y no doi)
        $auts=['editor','admin','traductor','autor']; ##### array de roles autorizados a editar
        $this->edit='0';
        if(session('rol')){
            if(array_intersect($auts,session('rol')) AND
                $this->url->url_edit=='1' AND
                $this->url->url_doi ==''
            ){
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
        $this->objs=Imagenes::where('img_cjarsiglas',$this->url->url_cjarsiglas)
            ->where('img_urlurl',$this->url->url_url)
            ->where('img_act','1')->where('img_del','0')
            ->get();

        ##### Carga párrafos de texto de la cédula
        $this->txt=cedulas_txt::where('txt_cjarsiglas',$this->url->url_cjarsiglas)
            ->where('txt_urlurl',$this->url->url_url)
            ->where('txt_act','1')->where('txt_del','0')
            ->orderBy('txt_orden')
            ->get();

        ###### Carga autores de la cédula
        $autores=ced_autores::where('aut_urlid',$this->url->url_id)
            ->where('aut_tipo','Autor')
            ->where('aut_act','1')->where('aut_del','0')
            ->orderBy('aut_id')
            ->with('autor')
            ->get();

        $traductores=ced_autores::where('aut_urlid',$this->url->url_id)
            ->where('aut_tipo','Traductor')
            ->where('aut_act','1')->where('aut_del','0')
            ->orderBy('aut_id')
            ->with('autor')
            ->get();

        $editores=ced_autores::where('aut_urlid',$this->url->url_id)
            ->where('aut_tipo','Editor')
            ->where('aut_act','1')->where('aut_del','0')
            ->orderBy('aut_id')
            ->with('autor')
            ->get();

        $objsPpal=Imagenes::where('img_urlurl',$this->url->url_url)
            ->where('img_act','1')->where('img_del','0')
            ->where('img_cimgtipo','ppal1')
            ->get();

        // dd($objsPpal);

        return view('livewire.web.cedulas-controller',[
            'autores'=>$autores,
            'traductores'=>$traductores,
            'editores'=>$editores,
            'objsPpal'=>$objsPpal,
        ]);
    }

    ############################################################
    ############################## Modal Traduce Titulo
    public function AbirModalTraduceTitulo(){
        $this->dispatch('AbreModalTraduceTitulo');
    }
    public function CerrarModalTraduceTitulo(){
        $this->dispatch('CierraModalTraduceTitulo');
    }
    public function GuardaTituloTraducido(){
        $this->validate([
            'NuevoTituloTraducido'=>'required'
        ]);
        cedulas_url::where('url_id',$this->url->url_id)->update([
            'url_titulo'=>$this->NuevoTituloTraducido,
        ]);
        redirect('/cedula/'.$this->url->url_cjarsiglas.'/'.$this->url->url_url);
    }

}


