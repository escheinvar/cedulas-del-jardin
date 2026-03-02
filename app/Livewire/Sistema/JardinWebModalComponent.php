<?php

namespace App\Livewire\Sistema;

use App\Models\cat_autores;
use App\Models\jardin_txt;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class JardinWebModalComponent extends Component
{
    use WithFileUploads;

    public $modJar_id, $modJar_orden; ##### Variable con id del párrafo a editar de jardin_txt
    public $modJar_txt, $modJar_archs; ##### Variables de formulario.


    #[Layout('plantillas.baseJardin')]
    public function mount(){    }

    #[On('AbreModalDeParrafoWebJardin')]
    public function recibeDatos($data){
        ##### Carga vars que vienen de URL
        $this->modJar_id=$data['id'];
        $this->modJar_orden=$data['orden'];

        ##### Carga variables
        if($this->modJar_id=='0'){
            // $this->LimpiarModal();

        }else{
            $dato=jardin_txt::where('jar_id',$this->modJar_id)->first();
            $this->modJar_orden=$dato->jar_orden;
            $this->modJar_txt=$dato->jar_txt;
        }
    }

    ###########################################################
    ####### poner esta función en controlador que dispara
    #######   $id=jar_id  y  $orden=$jar_orden de tabal jardin_txt

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
        #### Finaliza y cierra
        $this->CierraModalAutores();
    }

    public function render(){
        ##### Carga archivos file
        $dato=jardin_txt::where('jar_id',$this->modJar_id)->first();
        $archs=[];
        if($dato){
            foreach(['jar_arch1','jar_arch2','jar_arch3','jar_arch4','jar_arch5'] as $i){
                if($dato->$i != '' and Storage::disk('public')->exists($dato->$i)){
                    $archs[$i]=$dato->$i;
                }
            }
            // dd($dato,$archs,count($archs));
        }

        return view('livewire.sistema.jardin-web-modal-component',[
            'archs'=>$archs,
        ]);
    }
}
