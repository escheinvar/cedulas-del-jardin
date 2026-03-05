<?php

namespace App\Livewire\Sistema;

use App\Models\cat_autores;
use App\Models\Imagenes;
use App\Models\jardin_txt;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class JardinWebModalComponent extends Component
{
    use WithFileUploads;

    ###########################################################
    ####### poner esta función en controlador que dispara
    #######   $id=jar_id  y  $orden=$jar_orden de tabal jardin_txt
    #######
    ### public function AbreModalEditaTextoWebJardin($id, $orden){
    ###     if($this->edit=='1'){
    ###         $data=['id'=>$id, 'orden'=>$orden];
    ###         $this->dispatch('AbreModalDeParrafoWebJardin',$data);
    ###     }
    ### }
    ###########################################################

    ##### vars. recibidas desde externo con datos de quien se está editando:
    public $modJar_id, $modJar_orden, $modJar_urljid;
    public $modJar_urljurl, $modJar_urljurltxt, $modJar_cjarsiglas;
    ##### vars. del formulario:
    public $modJar_txt, $modJar_archs, $VerOriginal, $VerHtml, $modJar_original;
    public $modJar_NvoAudio, $modJar_Audio;



    #[Layout('plantillas.baseJardin')]
    public function mount(){
        $this->VerHtml='0';
        $this->VerOriginal='0';
    }

    #[On('AbreModalDeParrafoWebJardin')]
    public function recibeDatos($data){
        ##### Carga vars que vienen de controlador externo
        $this->modJar_id=$data['id'];
        $this->modJar_orden=$data['orden'];
        $this->modJar_urljid=$data['urljid'];
        $this->modJar_urljurl=$data['urljurl'];
        $this->modJar_cjarsiglas=$data['cjarsiglas'];
        $this->modJar_urljurltxt=$data['urljurltxt'];


        ##### Carga variables
        if($this->modJar_id=='0'){
            $this->LimpiarModal();
            $copiaUorig='0';

        }else{
            $dato=jardin_txt::where('jar_id',$this->modJar_id)
                ->with('url')
                ->first();
            $this->modJar_orden=$dato->jar_orden;
            $this->modJar_txt=$dato->jar_txt;
            $this->modJar_Audio=$dato->jar_audio;

            ##### Revisa si es copia u original
            $copiaUorig= $dato->url->urlj_tradid;
        }

        if($copiaUorig=='0'){
            // $this->modJar_original=jardin_txt::where('jar_id',$copiaUorig)->value('')
            $this->modJar_original='Este es un documento original';
        }else{
            $this->modJar_original=$dato->jar_txtoriginal;
        }
    }


    public function LimpiarModal(){
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset('modJar_txt','modJar_archs', 'modJar_original', 'modJar_NvoAudio', 'modJar_Audio');
    }

    public function CierraModalEditaTextoWebJardin(){
        $this->LimpiarModal();
        $this->dispatch('CierraModalDeParrafoWebJardin',reload:1);
    }

    public function GuardarDatos(){
        ##### Valida datos
        $this->validate([
            'modJar_orden'=>'required',
            'modJar_txt'=>'required',
        ]);

        ##### Genera arreglo de datos
        $dato=[
            'jar_urljid'=>$this->modJar_urljid,
            'jar_urljurl'=>$this->modJar_urljurl,
            'jar_cjarsiglas'=>$this->modJar_cjarsiglas,
            'jar_orden'=>$this->modJar_orden,
            'jar_txt'=>$this->modJar_txt,

            ];

        ##### Guarda BD
        if($this->modJar_id == '0'){
            $bla=jardin_txt::create($dato);
            $id=$bla->jar_id;
        }else{
            jardin_txt::where('jar_id', $this->modJar_id)->update($dato);
            $id=$this->modJar_id;
        }
        #### Finaliza y cierra
        $this->CierraModalEditaTextoWebJardin();
        // return $id;
    }

    public function VerOnoVerCodigoHtml(){
        if($this->VerHtml=='1'){
            $this->VerHtml ='0';
        }else{
            $this->VerHtml='1';
        }
    }

    public function VerONoVerOriginal(){
        if($this->VerOriginal=='1'){
            $this->VerOriginal ='0';
        }else{
            $this->VerOriginal='1';
        }
    }

    public function AbreModalObjeto($id){
            $data=[
                'ImgId'=>$id,        #'Obligatorio: img_id de tabla imagenes ó 0 para nuevo',
                'SiglasJardin'=>$this->modJar_cjarsiglas, #'Obligatorio: siglas del jardín al que pertenece',
                'ModuloCatImg'=>'jardin', #'Obligatorio: cimg_modulo de tabla cat_imgs',
                'TipoCatImg'=>'web',   #'Obligatorio: cimg_tipo de tabla cat_imgs'
                'Url'=>'',          #'url a la que pertenece o vacío',
                'Lengua'=>'0',      #'len_code de tabla lenguas o vacío',
                'Reload'=>'0',

            ];
        $this->dispatch('abreModalDeImagen', $data);
    }

    public function AbreModalVerImagenParrafo(){
        $this->dispatch('AbreModalDeVerImagenParrafo');
    }


    public function CierraModalVerImagenParrafo(){
        $this->dispatch('CierraModalDeVerImagenParrrafo');
    }

    #[On('event-from-js')]
    public function CuandoInsertaTexto($codigo){
        // dd('desdeJava',$codigo);
        $this->modJar_txt=$codigo;
    }

    public function BorrarAudio(){
        // $this->modJar_Audio='';
        // dd('borrar');
    }

    public function render(){
        ##### Si se sube un nuevo audio, lo carga a BD:
        if($this->modJar_NvoAudio != ''){
            dd('hay nuevo');
        }
        ##### Obtiene tipo de imagen
        if($this->modJar_urljurltxt=='autores'){
            $mod='autor';
        }elseif($this->modJar_urljurltxt=='cedula'){
            $mod='cedula';
        }else{
            $mod='jardin';
        }
        $img=Imagenes::where('img_act','1')->where('img_del','0')
            ->where('img_cjarsiglas',$this->modJar_cjarsiglas)
            ->with('alias')
            ->get();

        return view('livewire.sistema.jardin-web-modal-component',[
            'img'=>$img->where('img_tipo','img'),
            'aud'=>$img->where('img_tipo','aud'),
            'vid'=>$img->where('img_tipo','vid'),
        ]);
    }
}
