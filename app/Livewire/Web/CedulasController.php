<?php

namespace App\Livewire\Web;

use App\Models\ced_autores;
use App\Models\ced_sp;
use App\Models\ced_ubica;
use App\Models\ced_usos;
use App\Models\cedulas_txt;
use App\Models\cedulas_url;
use App\Models\Imagenes;
use App\Models\nom054semarnat;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Image;

class CedulasController extends Component
{
    public $jardin, $url; ##### Vars. recibidas por URL, y luego en url se guarda el first() de toda la info de cedula_url
    public $edit, $enEdit, $editMaster; ###### Vars. de edición
    ###### Variables de página cédulas:
    public $traducciones; ##### get() de cédulas con igual urltxt
    public $objs; ##### get() de fotos de la cédulas
    public $idiomaSelected; ##### Idioma seleccionado en el select de vista
    public $txt; #### get() de cedula_txt con todo el texto
    public $verSp, $verUbica, $verAlias; ##### flags para VerNoVer apartados de sp, ubicación y alias.
    public $alias, $ubicaciones; ### datos de alias y de locs de la cédula
    public $meses, $UrlRedes, $qrSize;
    public $aportes; ##### get() de aportes de usuarios publicos
    public $ligas;  ##### get() de ligas extra

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
            ->with('editores')
            ->with('traductores')
            ->with('ubicaciones')
            ->with('alias')
            ->with('especies')
            ->with('usos')
            ->with('versiones')
            ->first();

        if(is_null($this->url)) {
            redirect('/errorLa dirección indicada es incorrecta');
        }else{
            if( $this->url->url_act=='0' or $this->url->count() < '0'){
                redirect('/errorLa dirección indicada es incorrecta');
            }
        }

        ##### Carga todas las traducciones de la url
        $this->traducciones=cedulas_url::where('url_key', $this->url->url_key)
            // ->where('url_urltxt',$this->url->url_urltxt)
            ->where('url_id','!=',$this->url->url_id)
            ->where('url_act','1')->where('url_del','0')
            ->where('url_ciclo','>','0')
            ->with('lenguas')
            ->with('jardin') ##quitar cuando quite $traducciones en lína 169 de la vista
            ->orderBy('url_lencode')
            ->get();

        ##### Carga vauribbles
        $this->verSp='0';
        $this->verUbica='0';
        $this->verAlias='0';
        $this->meses=['0','enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','dieciembre'];
        $this->UrlRedes=url('/').'/cedula/'.$this->url->url_cjarsiglas.'/'.$this->url->url_url;
        $this->qrSize='20';

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

    public function BorrarEspecie($id){
        ced_sp::where('sp_id',$id)->update([
            'sp_del'=>'1',
        ]);
    }

    public function VerNoVer($apartado){
        if($this->$apartado =='0'){$this->$apartado='1';}else{$this->$apartado='0';}
    }

    public function render(){
        ##### Revisa permisos del usuario (rol)
        $this->edit='0';
        if(session('rol')){
            if(array_intersect(['editor','admin'], session('rol')) AND
                $this->url->url_edit=='1'){
                $this->edit='1';
                 $this->editMaster='1';

            ##### Si es autor o traductor, revisa que esté en la lista de autores o traductores de la cédula
            }elseif(array_intersect(['traductor','autor'], session('rol'))
              AND
              ($this->url->url_edit=='1')
              AND
              ( in_array(Auth::user()->id, $this->url->autores->pluck('caut_usrid')->toArray())
              OR
              in_array(Auth::user()->id, $this->url->traductores->pluck('caut_usrid')->toArray()) )
              AND
              in_array($this->url->url_edo, ['0','2'])
            ){
                $this->edit='1';
                $this->editMaster='0';

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
        $this->objs=Imagenes::where('img_key',$this->url->url_key)
            ->where('img_act','1')->where('img_del','0')
            ->get();

        ##### Carga párrafos de texto de la cédula
        $this->txt=cedulas_txt::where('txt_cjarsiglas',$this->url->url_cjarsiglas)
            ->where('txt_urlurl',$this->url->url_url)
            ->where('txt_act','1')->where('txt_del','0')
            ->orderBy('txt_orden')
            ->get();

        ##### Carga datos y metadatos de la cédula
        $cedula=cedulas_url::where('url_id',$this->url->url_id)
            ->with('jardin')
            ->with('lenguas')
            ->with('autores')
            ->with('traductores')
            ->with('ubicaciones')
            ->with('alias')
            ->first();

        // $objsPpal=Imagenes::where('img_key',$this->url->url_key)
        //     ->where('img_act','1')->where('img_del','0')
        //     ->where('img_cimgtipo','ppal1')
        //     ->get();

        $especies=ced_sp::where('sp_cjarsiglas',$this->url->url_cjarsiglas)
            ->where('sp_urltxt',$this->url->url_urltxt)
            ->where('sp_act','1')->where('sp_del','0')
            ->orderBy('sp_id','asc')
            ->with('usos')
            ->leftJoin('nom059semarnat', function($q){
                $q->on('nom_genero','ilike','sp_genero')
                ->on('nom_especie','ilike','sp_especie')
                ->on('nom_infrasp','ilike','sp_ssp');
            })
            ->get();

        $this->alias=$cedula->alias;
        $this->ubicaciones=$cedula->ubicaciones;

        ##### Obtiene aportes
        $this->aportes=collect();

        ##### Obtiene ligas
        $this->ligas=collect();

        return view('livewire.web.cedulas-controller',[
            'cedula'=>$cedula,
            // 'objsPpal'=>$objsPpal,
            'especies'=>$especies,
        ]);
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
                'modulo'=>'cedula',
                'jardin'=>$this->url->url_cjarsiglas,
                'url'=>$this->url->url_url,
                'reload'=>$reload,
            ];
            $this->dispatch('AbreModalDeParrafoWebJardin',$data);
        }
    }


    ############################################################
    ############################## Modal Traduce Titulo
    public function AbirModalTraduceTitulo(){
        #####<livewire: web.web.cedulas.controller  />
        $this->dispatch('AbreModalTraduceTitulo');
    }
    public function CerrarModalTraduceTitulo(){
        #####<livewire: web.web.cedulas.controller  />
        $this->dispatch('CierraModalTraduceTitulo');
    }
    public function GuardaTituloTraducido(){
        #####<livewire: web.web.cedulas.controller  />
        $this->validate([
            'NuevoTituloTraducido'=>'required'
        ]);
        cedulas_url::where('url_id',$this->url->url_id)->update([
            'url_titulo'=>$this->NuevoTituloTraducido,
        ]);
        redirect('/cedula/'.$this->url->url_cjarsiglas.'/'.$this->url->url_url);
    }

    ##########################################################
    ################## Modal externo Agregar Ubicación
    public function AbrirModalDeUbicacion($ubicaId){
        #####<livewire:sistema.modal-cedula-ubicaciones-component />
        $datos=[
            'ubicaId'=>$ubicaId,
            'urlid'=>$this->url->url_id,
        ];
        $this->dispatch('AbreModalAsignaUbicacion',$datos);
    }

    ##########################################################
    ################## Modal externo Agregar Alias
    public function AbrirModalDeAlias($aliasId){
        #####<livewire:sistema.modal-cedula-alias-component />
        $this->verAlias='1';
        $datos=[
            'aliasId'=>$aliasId, ### o id del uso
            'urlId'=>$this->url->url_id,
        ];
        $this->dispatch('AbreModalAlias',$datos);
    }

    ##########################################################
    ################## Modal externo Cambio de estado
    public function AbreModalDeCambioDeEstado($id){
        #####<livewire:sistema.modal-cedula-cambia-estado-component />
        $data=['urlId'=>$id];
        $this->dispatch('AbreModalCambiaEdoCedula',$data);
    }

    ##########################################################
    ################## Modal externo Yo tengo algo que aportar
    public function AbrirModalYoTengoAlgoQueAportar(){
        ##### <livewire:web.modal-cedula-yo-tengo-que-aportar />
        $this->dispatch('AbreModalYoTengoQueAportar');
    }

    ###########################################################
    ################## Modal externo abrir buscar objeto
    // public function AbrirModalPaIncertarObjeto($tipo){
    public function AbrirModalPaIncertarObjeto($imgId, $cimgmodulo, $cimgtipo, $imgkey, $reload){
        #####<livewire:sistema.modal-inserta-objeto-component />
        if($imgkey==''){$imgkey=$this->url->url_key;}
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


