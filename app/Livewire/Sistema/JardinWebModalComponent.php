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


    ##### vars. recibidas desde externo con datos de quien se está editando:
    public $modJar_id, $modJar_orden, $modJar_urljid;
    public $modJar_urljurl, $modJar_cjarsiglas;
    ##### vars. del formulario:
    public $modJar_txt, $modJar_archs;


    #[Layout('plantillas.baseJardin')]
    public function mount(){
        //
    }

    #[On('AbreModalDeParrafoWebJardin')]
    public function recibeDatos($data){
        ##### Carga vars que vienen de controlador externo
        $this->modJar_id=$data['id'];
        $this->modJar_orden=$data['orden'];
        $this->modJar_urljid=$data['urljid'];
        $this->modJar_urljurl=$data['urljurl'];
        $this->modJar_cjarsiglas=$data['cjarsiglas'];
        ##### Carga variables
        if($this->modJar_id=='0'){
            $this->LimpiarModal();

        }else{
            $dato=jardin_txt::where('jar_id',$this->modJar_id)->first();
            $this->modJar_orden=$dato->jar_orden;
            $this->modJar_txt=$dato->jar_txt;
        }
    }

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

    public function LimpiarModal(){
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset('modJar_txt', 'modJar_archs');
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

    public function AbreModalObjeto($id){
            $data=[
                'ImgId'=>$id,        #'Obligatorio: img_id de tabla imagenes ó 0 para nuevo',
                'SiglasJardin'=>$this->modJar_cjarsiglas, #'Obligatorio: siglas del jardín al que pertenece',
                'ModuloCatImg'=>'jardin', #'Obligatorio: cimg_modulo de tabla cat_imgs',
                'TipoCatImg'=>'web',   #'Obligatorio: cimg_tipo de tabla cat_imgs'
                'Url'=>'',          #'url a la que pertenece o vacío',
                'Lengua'=>'0'      #'len_code de tabla lenguas o vacío',

            ];
        $this->dispatch('abreModalDeImagen', $data);
    }

    public function render(){

        ##### Carga archivos file
        $dato=jardin_txt::where('jar_id',$this->modJar_id)->first();
        $archs=['ar1'=>null,'ar2'=>null,'ar3'=>null,'ar4'=>null,'ar5'=>null];
        if($dato != null){
            if($dato->jar_arch1 != ''){$archs['ar1']=Imagenes::where('img_id',$dato->jar_arch1)->get();}
            if($dato->jar_arch2 != ''){$archs['ar2']=Imagenes::where('img_id',$dato->jar_arch2)->get();}
            if($dato->jar_arch3 != ''){$archs['ar3']=Imagenes::where('img_id',$dato->jar_arch3)->get();}
            if($dato->jar_arch4 != ''){$archs['ar4']=Imagenes::where('img_id',$dato->jar_arch4)->get();}
            if($dato->jar_arch5 != ''){$archs['ar5']=Imagenes::where('img_id',$dato->jar_arch5)->get();}
        }



        return view('livewire.sistema.jardin-web-modal-component',[
            'archs'=>$archs,
        ]);
    }
}
