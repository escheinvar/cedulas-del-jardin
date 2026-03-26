<?php

namespace App\Livewire\Sistema;

use App\Models\cat_usos;
use App\Models\ced_sp;
use App\Models\ced_catalogos;
use App\Models\ced_usos;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalCedulaUsoComponent extends Component
{
    ########################## Variables recibidas desde controlador disparador
    public $uso_sp; ##### url envía valor spid y se obtiene uso_sp=ced_sp::first() de la especie
    public $uso_usoid; ##### valor id del uso
    public $uso_jardin; ##### siglas del jardin
    public $uso_urltxt; ##### nombre de cedula (sin traducción)
    ################### variables de cuestionario
    public $uso_catego, $uso_uso, $uso_parte, $uso_usosPartes, $uso_explica;

    /*############################################## ModalAlias_uso
    ###################################################################
    ##### Este modal, requiere cuatro varables:
    public function AbrirModalDeUso(){
        $datos=[
            'usoid'=>'0', ### o id del uso
            'spid'=>'sp_id', ### Id de sp_id de tabla ced_sp
            'jardin'=>$this->url->url_cjarsiglas,
            'urltxt'=>$this->url->url_urltxt
        ];
        $this->dispatch('AbreModalUsoEnCedula',$datos);
    }
    #################################################################### */

    #[On('AbreModalUsoEnCedula')]
    public function montarDatos($datos){
        ##### recibe variables externas
        $this->uso_sp=ced_sp::where('sp_id',$datos['spid'])->first();
        $this->uso_usoid=$datos['usoid'];
        $this->uso_jardin=$datos['jardin'];
        $this->uso_urltxt=$datos['urltxt'];
        if($this->uso_usoid > '0'){
            #### Carga datos:
            $dato=ced_usos::where('uso_id',$this->uso_usoid)->first();
            $this->uso_catego= $dato->uso_categoria;
            $this->uso_uso= $dato->uso_uso;
            $this->uso_explica=$dato->uso_describe;
            $this->uso_uso=cat_usos::where('cuso_uso', $dato->uso_uso)->value('cuso_id');
            ### ojo: las partes usadas ($this->uso_usosPartes) se cargan en render
            ###### carga array de usos existentes

            $partes=ced_usos::where('uso_cjarsiglas',$this->uso_jardin)
                ->where('uso_urltxt',$this->uso_urltxt)
                ->where('uso_spid',$this->uso_sp->sp_id)
                ->where('uso_act','1')->where('uso_del','0')
                ->value('uso_partes');
            if($partes != ''){
                $this->uso_usosPartes=explode(';',$partes);

            }


        }else{
            $this->uso_catego= '';
            $this->uso_uso= '';
            $this->uso_explica='';
            $this->uso_usosPartes=[];
            ### ojo: las partes usadas ($this->uso_usosPartes) se cargan en render
        }

    }

    public function mount(){
        $this->uso_sp=ced_sp::first();
        $this->uso_usosPartes=[];
    }

    public function limpiarModalUsoEnCedula(){
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['uso_catego', 'uso_uso', 'uso_parte',  'uso_explica']);
        $this->uso_usosPartes=[];
    }

    public function CerrarModalUsoEnCedula($reload){
        $this->limpiarModalUsoEnCedula();
        $this->dispatch('CierraModalUsoEnCedula',reload:$reload);
    }

    public function AgregarParte(){
        if(in_array($this->uso_parte,$this->uso_usosPartes)){
            $this->addError('uso_parte','Esta parte ya está incluida');
            return;
        }

        if($this->uso_parte != ''){
            $this->uso_usosPartes[]=$this->uso_parte;
        }
        $this->uso_parte='';
        $this->resetErrorBag();
    }

    public function BorrarParte($parte){
        $key=array_search($parte, $this->uso_usosPartes);
        if( count($this->uso_usosPartes) == '1'){
            $this->uso_usosPartes=[];

        }else{
            unset($this->uso_usosPartes[$key]);
        }

    }

    public function SeleccionaUso(){
        $this->uso_uso='';
    }

    public function GuardarUso(){
        ##### Valida datos
        $this->validate([
            'uso_catego'=>'required',
            'uso_uso'=>'required',
        ]);

        ##### Construye arra
        $datos=[
            'uso_spid'=>$this->uso_sp->sp_id,
            'uso_cjarsiglas'=>$this->uso_jardin,
            'uso_urltxt'=>$this->uso_urltxt,
            'uso_categoria'=>$this->uso_catego,
            'uso_uso'=>cat_usos::where('cuso_id',$this->uso_uso)->value('cuso_uso'),
            'uso_partes'=>implode(';',$this->uso_usosPartes),
            'uso_describe'=>$this->uso_explica,
        ];

        ##### Guarda datos
        if($this->uso_usoid=='0'){
            $nvo=ced_usos::create($datos);
            ##### Genera Log
            paLog('Se agrega uso a '.$this->uso_urltxt.' de '.$this->uso_jardin, 'ced_usos',  $nvo->uso_id);
        }else{
            ced_usos::where('uso_id',$this->uso_usoid)->update($datos);
            ##### Genera Log
            paLog('Se edita uso de '.$this->uso_urltxt.' de '.$this->uso_jardin, 'ced_usos',  $this->uso_usoid);
        }
        $this->limpiarModalUsoEnCedula();
        $this->CerrarModalUsoEnCedula('1');
    }

    public function EliminarUso(){
        ced_usos::where('uso_id',$this->uso_usoid)->update([
            'uso_del'=>'1',
        ]);
        $this->CerrarModalUsoEnCedula('1');
    }

    public function render(){
        ###### Carga categorias
        $categorias=cat_usos::distinct('cuso_catego')
            ->orderBy('cuso_catego')
            ->select('cuso_catego')
            ->get();

        ##### Carga usos
        if($this->uso_catego!=''){
            $usos=cat_usos::where('cuso_catego',$this->uso_catego)->get();
        }else{
            $usos=collect();
        }

        ####### Carga partes
        $partes=collect();
        if($this->uso_sp !='' ){
            if($this->uso_sp->sp_reino=='planta'){
                $partes=ced_catalogos::where('cat_tipo','parteplanta')->get();
            }
        }

        return view('livewire.sistema.modal-cedula-uso-component',[
            'categorias'=>$categorias,
            'usos'=>$usos,
            'partes'=>$partes,
        ]);
    }
}
