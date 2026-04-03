<?php

namespace App\Livewire\Sistema;

use App\Models\alias_img;
use App\Models\Imagenes;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;


class ModalInsertaObjetoComponent extends Component
{
    use WithFileUploads;

    #### vars. recibidas de fuera
    public $Imgmod_id, $Imgmod_cimgmodulo, $Imgmod_cimgtipo, $Imgmod_key, $Imgmod_reload;
    ##### vars. de formulario
    public $Imgmod_tipoobjeto, $Imgmod_nvoobj, $Imgmod_verobjeto;
    public $Imgmod_alias, $Imgmod_aliasNvo,$Imgmod_NvoAlias;
    ##### vars. de la BD
    public $Imgmod_cjarsiglas, $Imgmod_tipo, $Imgmod_urltxt, $Imgmod_urlid;
    public $Imgmod_file,  $Imgmod_youtube, $Imgmod_html, $Imgmod_size;
    public $Imgmod_resolu,  $Imgmod_titulo, $Imgmod_tituloact, $Imgmod_act, $Imgmod_pie;
    public $Imgmod_autor, $Imgmod_fecha, $Imgmod_ubica, $Imgmod_lonx, $Imgmod_laty;
    public $Imgmod_usrid;


   /*####################################################
    ###### Para ejecutarse, requiere de la función:
    public function AbrirModalPaIncertarObjeto($imgId, $cimgmodulo, $cimgtipo, $imgkey, $reload){
        #####<livewire:sistema.modal-inserta-objeto-component />
        $datos=[
            'imgId'=>0,               ### img_id o 0 para nuevo
            'cimgmodulo'=>'cedula',   ### cimg_modulo de cat_img (cedula,jardin,autor) o null
            'cimgtipo'=>'web',        ###cimg_tipo de cat_img (web, portada, ppal,lat, etc...)  o null
            'imgkey'=>'JebOax@huaje', ### key: Jardin@urltxt (sin traduccción)  o null
            'reload'=>'0',            ### indica si hace reload(1) o no(0) al guardar
        ];
        $this->dispatch('AbreModalIncertaObjeto',$datos);
    }
   ####################################################*/

    #[On('AbreModalIncertaObjeto')]
    public function MontandoElModal($data){
        // dd('falta:','cargar img desde id','al borrar img, pasar a carpeta trash','pasar todo admin img a nvo modalInserta','verificar que sirva en web de jardines y en autores');
        ##### Carga el id
        $this->Imgmod_id=$data['imgId'];
        $this->Imgmod_reload=$data['reload'];
        ##### Si es edición, carga los datos:
        if($this->Imgmod_id == '0'){
            ##### Carga valores enviados
            $this->Imgmod_cimgmodulo=$data['cimgmodulo'];
            $this->Imgmod_cimgtipo=$data['cimgtipo'];
            $this->Imgmod_key=$data['imgkey'];

        }else{
            ###### Carga datos de la base de datos:
            $dato=Imagenes::where('img_id',$this->Imgmod_id)->first();
            $this->Imgmod_cimgmodulo=$dato->img_cimgmodulo;
            $this->Imgmod_cimgtipo=$dato->img_cimgtipo;
            $this->Imgmod_key=$dato->img_key;
            $this->Imgmod_verobjeto='1';
            $this->Imgmod_tipo=$dato->img_tipo;
            $this->Imgmod_file=$dato->img_file;
            $this->Imgmod_key=$dato->img_key;
            $this->Imgmod_size=$dato->img_size;
            $this->Imgmod_cimgmodulo=$dato->img_cimgmodulo;
            $this->Imgmod_resolu=$dato->img_resolu;
            $this->Imgmod_titulo=$dato->img_titulo;
            if($dato->img_tituloact=='0'){$this->Imgmod_tituloact=FALSE;}else{$this->Imgmod_tituloact=TRUE;}
            if($dato->img_act=='0'){$this->Imgmod_act=TRUE;}else{$this->Imgmod_act=FALSE    ;}
            $this->Imgmod_autor=$dato->img_autor;
            $this->Imgmod_fecha=$dato->img_fecha;
            $this->Imgmod_pie=$dato->img_pie;
            $this->Imgmod_ubica=$dato->img_ubica;
            $this->Imgmod_laty=$dato->img_laty;
            $this->Imgmod_lonx=$dato->img_lonx;
            ##### Cargar datos de alias
            $this->CargarDatosDeAlias();
        }
    }

    public function mount(){
        $this->Imgmod_id='0';
        $this->Imgmod_verobjeto='0';

        ###### Carga los alias
        if($this->Imgmod_id == '0'){
            $this->Imgmod_tipoobjeto='archivo';
            $this->Imgmod_alias=[];
        }else{
            $this->Imgmod_alias=alias_img::where('aimg_imgid',$this->ImgId)
                ->where('aimg_act','1')->where('aimg_del','0')
                ->select('aimg_txt','aimg_id')->get();
        }
    }

    public function CargarDatosDeAlias(){
        ###### Carga datos de alias
        $this->Imgmod_alias=alias_img::where('aimg_imgid',$this->Imgmod_id)
            ->where('aimg_act','1')
            ->where('aimg_del','0')
            ->get();
    }

    public function LimpiarModalIncertaObjeto(){
        $this->Imgmod_verobjeto='0';
        $this->Imgmod_alias=[];
        $this->reset(['Imgmod_nvoobj','Imgmod_cjarsiglas','Imgmod_urltxt','Imgmod_urlid',
            'Imgmod_file','Imgmod_youtube','Imgmod_html','Imgmod_size','Imgmod_resolu',
            'Imgmod_titulo','Imgmod_tituloact','Imgmod_pie','Imgmod_autor','Imgmod_fecha',
            'Imgmod_ubica','Imgmod_lonx','Imgmod_laty','Imgmod_usrid'
        ]);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function CerrarModalIncertaObjeto(){
        $this->LimpiarModalIncertaObjeto();
        $this->dispatch('CierraModalIncertaObjeto', reload:$this->Imgmod_reload);
    }

    public function LeerObjeto(){
        if($this->Imgmod_nvoobj != ''){
            if($this->Imgmod_tipoobjeto=='archivo'){
                ###### Define el tipo de objeto a partir de la extensión
                $ext=$this->Imgmod_nvoobj->getClientOriginalExtension();
                if(preg_match('/jpg$|png$|jpeg$|tiff$|tif$|svg$/i',$ext)){
                    $this->Imgmod_tipo='img';
                }elseif(preg_match('/MP4$|MOV$|AVI$|WMV$|MKV$|FLV$/i',$ext)){
                    $this->Imgmod_tipo='vid';
                }elseif(preg_match('/ogg$|mp3$|wav$|flac$|aac$|wma$|m4a$/i',$ext)){
                    $this->Imgmod_tipo='aud';
                }else{
                    $this->Imgmod_tipo='otro';
                }

            }elseif($this->Imgmod_tipoobjeto=='youtube'){
                $this->Imgmod_tipo='you';

            }elseif($this->Imgmod_tipoobjeto=='codigo'){
                $this->Imgmod_tipo='htm';
            }

            if(in_array($this->Imgmod_tipo,['img','vid','aud'])){
                ##### Toma objeto
                $this->Imgmod_file = $this->Imgmod_nvoobj->temporaryUrl();
                ##### Calcula tamaño en MB
                $this->Imgmod_size = round($this->Imgmod_nvoobj->getSize() /1024 / 1024, 2);

                ##### Calcula resolución de imagen
                list($width, $height) = getimagesize($this->Imgmod_nvoobj->getRealPath());
                $this->Imgmod_resolu=$width.",".$height;
            }
        }
        ##### Activa mostrar la sección de datos
        $this->Imgmod_verobjeto='1';
    }

    public function AgregarAlias(){
        ##### Guarda nuevo alias (id=0)
        if($this->Imgmod_id=='0'){
            $this->Imgmod_alias[]= $this->Imgmod_NvoAlias;
            $this->Imgmod_NvoAlias='';
        ##### Guarda alias en base de datos
        }else{
            $nvo=alias_img::create([
                'aimg_imgid'=>$this->Imgmod_id,
                'aimg_txt'=>$this->Imgmod_NvoAlias,
            ]);
            $this->Imgmod_NvoAlias='';
            $this->CargarDatosDeAlias();
        }
    }

    public function BorrarAlias($textoOid){
        if($this->Imgmod_id=='0'){
            $borra=array_search($textoOid, $this->Imgmod_alias);
            unset($this->Imgmod_alias[$borra]);
        }else{
            alias_img::where('aimg_id',$textoOid)->update(['aimg_del'=>'1']);
        }

        $this->CargarDatosDeAlias();
    }


    public function GuardarDatos(){
        ##### Valida cuestionario
        $this->validate([
            // 'Imgmod_nvoobj'=>'required',
            'Imgmod_titulo'=>'required',
            'Imgmod_autor'=>'required',
        ]);

        ##### Procesa checkbox y variables
        if($this->Imgmod_act==TRUE){$act='0';}else{$act='1';}
        if($this->Imgmod_tituloact==TRUE){$titact='1';}else{$titact='0';}
        if($this->Imgmod_fecha==''){$this->Imgmod_fecha=null;}
        if($this->Imgmod_tipoobjeto=='archivo'){ $youtube=''; $html='';} #$file='subiendo...';
        if($this->Imgmod_tipoobjeto=='youtube'){$file=''; $youtube=$this->Imgmod_nvoobj; $html='';}
        if($this->Imgmod_tipoobjeto=='codigo'){$file=''; $youtube=''; $html=$this->Imgmod_nvoobj;}

        ##### Genera arreglo de datos
        $datos=[
            'img_act'=> $act,
            'img_cjarsiglas'=> preg_replace('/@.*/','',$this->Imgmod_key),
            'img_urltxt'=>preg_replace('/.*@/','',$this->Imgmod_key),
            'img_urlid'=>null,
            'img_cimgmodulo'=>$this->Imgmod_cimgmodulo,
            'img_cimgtipo'=> $this->Imgmod_cimgtipo,
            'img_tipo'=> $this->Imgmod_tipo,

            // 'img_file'=>$file,
            'img_youtube'=>$youtube,
            'img_html'=>$html,

            'img_size'=> $this->Imgmod_size,
            'img_resolu'=>$this->Imgmod_resolu,
            'img_titulo'=> $this->Imgmod_titulo,
            'img_tituloact'=> $titact,
            'img_pie'=> $this->Imgmod_pie,
            'img_autor'=> $this->Imgmod_autor,
            'img_fecha'=> $this->Imgmod_fecha,
            'img_ubica'=> $this->Imgmod_ubica,
            'img_laty'=> $this->Imgmod_laty,
            'img_lonx'=> $this->Imgmod_lonx,
            'img_usrid'=> Auth::user()->id,
        ];

        ##### Guarda datosen Base de datos
        if($this->Imgmod_id=='0'){
            ##### guarda bd de imagenes
            $bla=imagenes::create($datos);
            $id=$bla->img_id;

            ##### Guarda sus alias
            if($this->Imgmod_id == '0' AND count($this->Imgmod_alias) > '0'){
                foreach($this->Imgmod_alias as $a){
                    alias_img::create([
                        'aimg_imgid'=>$id,
                        'aimg_txt'=>$a,
                    ]);
                    $this->Imgmod_alias=[];
                    $this->Imgmod_NvoAlias='';
                }
            }

            ##### Genera log
            paLog('Se guarda nuevo objeto','imagenes',$id);

        }else{
            imagenes::where('img_id',$this->Imgmod_id)->update($datos);
            $id=$this->Imgmod_id;
            ##### Genera log
            paLog('Se editan datos de objeto','imagenes',$id);
        }

        ##### obtiene o genera nombre de archivo
        if($this->Imgmod_id=='0' AND $this->Imgmod_tipoobjeto=='archivo' and $this->Imgmod_nvoobj != ''){
            ##### Genera nombre
            $nombre='obj_'. STR_PAD($id,4,"0",STR_PAD_LEFT).'.'.$this->Imgmod_nvoobj->getClientOriginalExtension();
            $this->Imgmod_nvoobj->storeAs(path:'/public/img/', name:$nombre);
            ##### Guarda nombre en base de datos
            imagenes::where('img_id',$id)->update(['img_file'=>'/img/'.$nombre]);
        }

        ##### Finaliza y cierra
        $this->CerrarModalIncertaObjeto($id);
    }

    public function verificarTagsAbiertos($html) {
        // // Desactivar errores estándar de libxml
        // libxml_use_internal_errors(true);

        // $dom = new DOMDocument();
        // // Cargar el HTML
        // $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // // Obtener los errores generados por etiquetas mal cerradas
        // $errors = libxml_get_errors();

        // if (empty($errors)) {
        //     return "Todos los tags están cerrados correctamente.";
        // } else {
        //     foreach ($errors as $error) {
        //         echo "Error en línea {$error->line}: Tag no cerrado o mal formado.<br>";
        //     }
        // }
        // libxml_clear_errors();
    }

    public function render(){
        // $apariciones=cedula::where('jar_txt','ilike','%'.$this->Imgmod_file.'%')
        //     ->where('jar_act','1')
        //     ->where('jar_del','0')
        //     ->with('url')
        //     ->get();

        return view('livewire.sistema.modal-inserta-objeto-component');
    }
}
