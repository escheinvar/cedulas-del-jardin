<?php

namespace App\Livewire\Web;

use App\Models\alias_img;
use App\Models\cat_tipoimg;
use App\Models\CatJardinesModel;
use App\Models\Imagenes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use SimpleSoftwareIO\QrCode\Image;

class ModalImagenController extends Component
{
    use WithFileUploads;
    ###################################################
    /*#### En view, para editar imágenes, requiere que
    ###### se defina $this->edit=='1' y poner:
        <livewire:Web.ImagenController />

    ###### En view, para visualizar una o más imágenes:
        <?php $imags = imagenes::get(); ?>
        @include('plantillas.imagenes')
    ######
    ###### En controller:
        $this->edit=='1'; #### Para indicar modo edición
        public function AbreModalObjeto(){
            $data[
                'ImgId'=>       'Obligatorio: img_id de tabla imagenes ó 0 para nuevo',
                'SiglasJardin'=>'Obligatorio: siglas del jardín al que pertenece',
                'ModuloCatImg'=>'Obligatorio: cimg_modulo de tabla cat_imgs',
                'TipoCatImg'=>  'Obligatorio: cimg_tipo de tabla cat_imgs'
                'Url'=>         'url a la que pertenece o vacío',
                'Lengua'=>      'len_code de tabla lenguas o vacío',
                // 'Reload'=>'0 o 1. Al cerrar, se recarga (1) o no (0) la pag'
            ];
            $this->dispatch('abreModalDeImagen', $data);
        }
        public function CierraModalObjeto(){
            $this->dispatch('cierraModalDeImagen');
        }
    */#################################################
    ###################################################

    public $ImgId; ###### valor de img_id de tabla imagen ó 0 (para nuevo)
    public $ImgMod_jardin,$ImgMod_modulo,$ImgMod_tipomod,$ImgMod_url,$ImgMod_lengua, $ImgMod_reload;##### Vars recibidas desde controlador externo que dispara
    ##### Vars de formulario y BD
    public $ImgMod_act, $ImgMod_file, $ImgMod_tipo, $ImgMod_titulo, $ImgMod_tituloact;
    public $ImgMod_pie, $ImgMod_autor, $ImgMod_fecha, $ImgMod_ubica;
    public $ImgMod_lonx, $ImgMod_laty, $ImgMod_Nvofile, $ImgMod_fileSize, $ImgMod_resol, $ImgMod_NvoAlias;
    public $ImgModalias, $ImgModaliasNvo;


    #[On('abreModalDeImagen')]
    public function recibeValoresDeFuera($data){
        // dd($data);
        ##### Valida recepción de valores obligados
        if(!is_numeric($data['ImgId']) ){redirect('/errorNo se recibieron los parámetros del objeto');return;}
        if($data['SiglasJardin'] == '' ){redirect('/errorNo se recibieron los parámetros del objeto');return;}
        if($data['ModuloCatImg'] == '' ){redirect('/errorNo se recibieron los parámetros del objeto');return;}
        if($data['TipoCatImg'] == '' ){redirect('/errorNo se recibieron los parámetros del objeto');return;}
        if($data['ImgId']!='0' and  Imagenes::where('img_id',$data['ImgId'])->where('img_del','0')->count() != '1'){redirect('/errorParámetros de objeto incorrectos');return;}
        if(CatJardinesModel::where('cjar_siglas',$data['SiglasJardin'])->count() != '1'){redirect('/errorParámetros de objeto incorrectos');return;}

        ##### Carga variables enviados desde controlador externo
        $this->ImgId=$data['ImgId'];
        $this->ImgMod_jardin=$data['SiglasJardin'];
        $this->ImgMod_modulo=$data['ModuloCatImg'];
        $this->ImgMod_tipomod=$data['TipoCatImg'];
        $this->ImgMod_url=$data['Url'];
        $this->ImgMod_lengua=$data['Lengua'];
        // $this->ImgMod_reload=$data['Reload'];

        ##### Carga valores de base de datos
        if($this->ImgId=='0'){
            $this->LimpiarModalImg();
        }else{
            ##### Busca id en BD
            $dato=imagenes::where('img_id',$this->ImgId)->first();

            ##### Carga variables
            $this->ImgMod_file=$dato->img_file;
            $this->ImgMod_tipo=$dato->img_tipo;
            if($dato->img_act=='1'){$this->ImgMod_act=FALSE;}else{$this->ImgMod_act=TRUE;}
            $this->ImgMod_titulo=$dato->img_titulo;
            if($dato->img_tituloact=='1'){$this->ImgMod_tituloact=TRUE;}else{$this->ImgMod_tituloact=FALSE;}
            $this->ImgMod_pie=$dato->img_pie;
            $this->ImgMod_autor=$dato->img_autor;
            $this->ImgMod_fecha=$dato->img_fecha;
            $this->ImgMod_ubica=$dato->img_ubica;
            $this->ImgMod_lonx=$dato->img_lonx;
            $this->ImgMod_laty=$dato->img_laty;
            $this->ImgMod_Nvofile = '' ;
            $this->ImgMod_fileSize=$dato->img_size;
            // $res=explode(',',$dato->img_resolu);
            // $this->ImgMod_resol=['x'=>$res[0],'y'=>$res[1]];
            $this->ImgMod_resol=$dato->img_resolu;
        #dd($dato);
        }
    }

    public function mount(){
        $this->ImgMod_Nvofile='';
        $this->ImgMod_NvoAlias='';
        $this->ImgModaliasNvo=[];
    }

    public function LimpiarModalImg(){
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset('ImgMod_act','ImgMod_file','ImgMod_tipo','ImgMod_titulo','ImgMod_tituloact','ImgMod_pie','ImgMod_autor','ImgMod_fecha','ImgMod_ubica','ImgMod_lonx','ImgMod_laty','ImgMod_Nvofile','ImgMod_fileSize','ImgMod_resol','ImgMod_NvoAlias');
        $this->ImgModaliasNvo=[];
    }

    public function CerrarModalImg(){
        $this->LimpiarModalImg();
        $this->dispatch('cierraModalDeImagen',reload:1);
        redirect()->back();
    }

    public function GuardarObjeto(){
        ##### Valida cuestionario
        $this->validate([
            'ImgMod_titulo'=>'required',
            'ImgMod_autor'=>'required',
        ]);

        ##### Procesa checkbox
        if($this->ImgMod_act==TRUE){$act='0';}else{$act='1';}
        if($this->ImgMod_tituloact==TRUE){$titact='1';}else{$titact='0';}
        if($this->ImgMod_fecha==''){$this->ImgMod_fecha=null;}
        ##### Genera arreglo de datos
        $datos=[
            'img_act'=> $act,
            'img_cimgmodulo'=> $this->ImgMod_modulo,
            'img_cimgtipo'=> $this->ImgMod_tipomod,
            'img_cjarsiglas'=> $this->ImgMod_jardin,
            'img_urlurl'=> $this->ImgMod_url,
            'img_lencode'=> $this->ImgMod_lengua,
            'img_tipo'=> $this->ImgMod_tipo,
            'img_size'=> $this->ImgMod_fileSize,
            // 'img_resolu'=>$this->ImgMod_resol['x'].','.$this->ImgMod_resol['y'],
            'img_resolu'=>$this->ImgMod_resol,
            'img_titulo'=> $this->ImgMod_titulo,
            'img_tituloact'=> $titact,
            'img_pie'=> $this->ImgMod_pie,
            'img_autor'=> $this->ImgMod_autor,
            'img_fecha'=> $this->ImgMod_fecha,
            'img_ubica'=> $this->ImgMod_ubica,
            'img_laty'=> $this->ImgMod_laty,
            'img_lonx'=> $this->ImgMod_lonx,
            'img_usrid'=> Auth::user()->id,
        ];

        ##### Guarda datosen Base de datos
        if($this->ImgId=='0'){
            $bla=imagenes::create($datos);
            $id=$bla->img_id;
            ##### Guarda sus alias
            if(count($this->ImgModaliasNvo) > '0'){
                foreach($this->ImgModaliasNvo as $a){
                    alias_img::create([
                        'aimg_imgid'=>$id,
                        'aimg_txt'=>$a,
                        'aimg_lencode'=>'spa',
                    ]);
                    $this->ImgMod_NvoAlias='';
                    $this->ImgModaliasNvo=[];
                }
            }

        }else{
            imagenes::where('img_id',$this->ImgId)->update($datos);
            $id=$this->ImgId;
        }

        ##### obtiene o genera nombre de archivo
        if($this->ImgMod_Nvofile != ''){
            ##### Genera nombre
            $nombre='obj_'. STR_PAD($id,4,"0",STR_PAD_LEFT).'.'.$this->ImgMod_Nvofile->getClientOriginalExtension();
            $this->ImgMod_Nvofile->storeAs(path:'/public/img/', name:$nombre);
            ##### Guarda nombre en base de datos
            imagenes::where('img_id',$id)->update(['img_file'=>'/img/'.$nombre]);
        }else{
            $nombre=imagenes::where('img_id',$this->ImgId)->value('img_file');
        }

        ##### Finaliza y cierra
        $this->CerrarModalImg();
    }

    public function BorrarObjeto(){
        ##### Obtiene
        imagenes::where('img_id',$this->ImgId)->update([
            'img_del'=>'1',
        ]);
        $archivo=imagenes::where('img_id',$this->ImgId)->value('img_file');
        $nvoarch=preg_replace('/^\/img\//','/img_basura/',$archivo);
        // dd($archivo,$nvoarch);

        // unlink($archivo);
        Storage::move('/public/'.$archivo, '/public/'.$nvoarch);
        $this->dispatch('alertaBorradoImagen',msj:'La imagen se borró correctamente');
        $this->CerrarModalImg();
    }

    public function AgregarAlias(){
        if($this->ImgMod_NvoAlias!=''){
            $this->validate(['ImgMod_NvoAlias'=>'required']);
            alias_img::create([
                'aimg_imgid'=>$this->ImgId,
                'aimg_txt'=>$this->ImgMod_NvoAlias,
                'aimg_lencode'=>'spa',
            ]);
            $this->ImgMod_NvoAlias='';
        }
    }

    public function BorrarAlias($id){
        alias_img::where('aimg_id',$id)->update(['aimg_del'=>'1']);
    }

    public function AgregarAliasConIdNuevo(){
        $this->ImgModaliasNvo[]= $this->ImgMod_NvoAlias;
        $this->ImgMod_NvoAlias='';
    }

    public function BorrarAliasConIdNuevo($texto){
        $borra=array_search($texto, $this->ImgModaliasNvo);
        unset($this->ImgModaliasNvo[$borra]) ;
    }

    public function render() {
        ##### Cuando se carga una nueva imagen, carga los
        ##### datos de tipo de imagen
        if($this->ImgMod_Nvofile != ''){
            ###### Define el tipo de objeto
            $ext=$this->ImgMod_Nvofile->getClientOriginalExtension();

            if(preg_match('/jpg$|png$|jpeg$|tiff$|tif$|svg$/i',$ext)){
                $this->ImgMod_tipo='img';

            }elseif(preg_match('/MP4$|MOV$|AVI$|WMV$|MKV$|FLV$/i',$ext)){
                $this->ImgMod_tipo='vid';

            }elseif(preg_match('/ogg$|mp3$|wav$|flac$|aac$|wma$|m4a$/i',$ext)){
                $this->ImgMod_tipo='aud';

            }else{
                $this->ImgMod_tipo='otro';
            }

            if(in_array($this->ImgMod_tipo,['img','vid','aud','tau'])){
                ##### Toma objeto
                $this->ImgMod_file = $this->ImgMod_Nvofile->temporaryUrl();
                ##### Calcula tamaño en MB
                $this->ImgMod_fileSize = round($this->ImgMod_Nvofile->getSize() /1024 / 1024, 2);

                ##### Calcula resolución de imagen
                list($width, $height) = getimagesize($this->ImgMod_Nvofile->getRealPath());
                $this->ImgMod_resol=$width.",".$height;
            }
        }

        ##### Carga datos de alias
        if($this->ImgId != '0'){
            $this->ImgModalias=alias_img::where('aimg_imgid',$this->ImgId)
                ->where('aimg_act','1')->where('aimg_del','0')
                ->select('aimg_txt','aimg_id')->get();
        }

        return view('livewire.web.modal-imagen-controller',[
            // 'ImgModalias'=>$ImgModalias,
        ]);
    }
}
