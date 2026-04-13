<?php

namespace App\Livewire\Sistema;

use App\Models\cat_redes;
use App\Models\ced_externos;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ModalCedulaFuenteExternaComponennt extends Component
{
    use WithFileUploads;
    /*#################################################
    ############## requiere
    public function AbrirModalDeFuenteExterna($extid, $jardin, $urltxt){
        #####<livewire:sistema.modal-cedula-fuente-externa-componennt />
        $datos=[
            'extid'=>$extid,  #### id de ext_id o 0 para nuevo
            'jardin'=>$jardin, #### Jardín al que pertenece
            'urltxt'=>$urltxt,  ####urltxt (sin lengua) al que pertenece
        ];

        $this->dispatch('AbreModalFuenteExterna',$datos);
    }
    ################################################# */

    public $modext_id, $modext_jardin, $modext_urltxt; ##### datos que recibe de fuera
    ###### Datos de cuestionario
    public $modext_red, $modext_autor, $modext_urlautor, $modext_titulo;
    public $modext_explica, $modext_url, $modext_carat, $modext_caratNva, $modext_fecha;


    #[On('AbreModalFuenteExterna')]
    public function montandoModal($datos){
        $this->LimpiarModal();
        $this->modext_id=$datos['extid'];
        $this->modext_jardin=$datos['jardin'];
        $this->modext_urltxt=$datos['urltxt'];
        if($this->modext_id > '0'){
            $dato=ced_externos::where('ext_id',$this->modext_id)->first();
            $this->modext_red = $dato->ext_redid;
            $this->modext_titulo = $dato->ext_titulo;
            $this->modext_autor = $dato->ext_autorname;
            $this->modext_urlautor = $dato->ext_autorurl;
            $this->modext_explica = $dato->ext_explica;
            $this->modext_url = $dato->ext_url;
            $this->modext_fecha = $dato->ext_fecha;
            $this->modext_caratNva='';
            $this->modext_carat = $dato->ext_caratula;
        }
    }

    public function GuardaFuenteExterna(){
        ##### Valida datos
        $this->validate([
            'modext_red'=>'required',
            'modext_autor'=>'required',
            'modext_titulo'=>'required',
            'modext_explica'=>'required',
            'modext_url'=>'required',
        ]);

        ##### Genera arreglo de datos
        $datos=[
            'ext_jardin'=>$this->modext_jardin,
            'ext_urltxt'=>$this->modext_urltxt,
            'ext_redid'=>$this->modext_red,
            'ext_titulo'=>$this->modext_titulo,
            'ext_autorname'=>$this->modext_autor,
            'ext_autorurl'=>$this->modext_urlautor,
            'ext_explica'=>$this->modext_explica,
            'ext_url'=>$this->modext_url,
            // 'ext_caratula'=>$archivo,
            'ext_fecha'=>$this->modext_fecha,
        ];

        ##### Guarda datos en BD
        if($this->modext_id > 0){
            ced_externos::where('ext_id',$this->modext_id)->update($datos);
            $NvoId=$this->modext_id;
            ##### genera log
            paLog('Se editan datos de fuentes externas de cédula','ced_externos',$NvoId);
        }else{
            $ja=ced_externos::create($datos);
            $NvoId=$ja->ext_id;
            ##### genera log
            paLog('Se ingresa nuevo dato de fuentes externas de cédula','ced_externos',$NvoId);
        }

        ##### Genera nombre del archivo
        if($this->modext_caratNva != ''){
            ##### Genera nombre de archivo
            $ruta='/img/externos/';
            $archivo='liga_'.str_pad($NvoId,4,'0',STR_PAD_LEFT);
            $RutaArchivo=$ruta.$archivo;
            ##### Guarda archivo
            $this->modext_caratNva->storeAs(path:'/public/'.$ruta, name:$archivo);
        }else{
            ##### Genera Nombre de Archivo
            $RutaArchivo=$this->modext_carat;
        }

        ##### Guarda BD
        ced_externos::where('ext_id',$NvoId)->update([
            'ext_caratula'=>$RutaArchivo,
        ]);

        ##### Avisa
        $msj='La fuente externa se vinculó correctamente a la cédula';
        $this->dispatch('AvisoExitoFuenteExterna',msj:$msj);
        #####Cierra
        $this->CerrarModalDeFuenteExterna();
    }

    public function LimpiarModal(){
        $this->reset(['modext_red', 'modext_autor', 'modext_urlautor', 'modext_titulo','modext_explica', 'modext_url', 'modext_carat', 'modext_caratNva', 'modext_fecha']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function CerrarModalDeFuenteExterna(){
        $this->LimpiarModal();
        $this->dispatch('CierraModalFuenteExterna',reload:1);
    }

    public function render(){
        $redes=cat_redes::get();

        return view('livewire.sistema.modal-cedula-fuente-externa-componennt',[
            'redes'=>$redes,
        ]);
    }
}
