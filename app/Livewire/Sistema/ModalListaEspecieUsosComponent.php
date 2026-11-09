<?php

namespace App\Livewire\Sistema;

use App\Models\cat_usos;
use App\Models\ced_catalogos;
use App\Models\lista;
use App\Models\lista_usos;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalListaEspecieUsosComponent extends Component
{

/*############################################## ModalLista_Imagenes
    ###################################################################
    ##### Este modal, requiere dos varables, url_cjarsiglas y url_urltxt
    ##### Copiar AbrirModalDeBuscarEspecie en controller disparador
    ##### <livewire:sistema.modal-lista-especie-usos-component />
    public function AbrirModalDeAsignaUsoEnLista($id){
        $datos=[
            'jardin'=>$this->listasp_jardin,
            'lstId'=>$this->listasp_id,
            'lsusoId'=>$id,
        ];
        $this->dispatch('AbreModalDeUsoEnLista',$datos);
    }
    ############################################################# */

    public $jardin, $lstId, $lstusoId; ##### Vars que recibe
    public $modUso_catego, $modUso_uso, $modUso_uso2, $modUso_parte, $modUso_parte2, $modUso_explica;
    public $modPartes;

    #[On('AbreModalDeUsoEnLista')]
    public function montarAbrirModalDeBuscarEspecie($datos){
        ##### recibe variables externas
        $this->jardin=$datos['jardin'];
        $this->lstusoId=$datos['lsusoId'];
        $this->lstId=$datos['lstId'];

        ##### carga valores
        if($this->lstusoId=='0'){
            $this->modPartes=[];
        }else{
            $valor=lista_usos::where('lsuso_id',$this->lstusoId)->first();
            $this->modUso_catego=$valor->lsuso_catego;
            $this->modUso_uso=$valor->lsuso_uso;
            // if($this->modUso_uso=='Otro/NA'){$this->modUso_uso2='':}
            $this->modUso_explica=$valor->lsuso_describe;
// dd($this->modUso_uso);

            ##### Recupera partes
            if($valor->lsuso_parte != ''){
                $this->modPartes=explode(';',$valor->lsuso_parte);
            }else{
                $this->modPartes=[];
            }
        }
    }
    public function mount(){
        ##### carga varis
        $this->modPartes=[];
    }

    public function LimpiarModalDeUso(){
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['modUso_catego', 'modUso_uso', 'modUso_uso2', 'modUso_parte',
            'modUso_parte2', 'modUso_explica']);
    }

    public function CerrarModalDeAsignaUsoEnLista(){
        $this->LimpiarModalDeUso();
        $this->dispatch('CierraModalDeUsoEnLista');
    }

    public function AgregarParte(){
        if($this->modUso_parte != '' AND $this->modUso_parte != 'Otra'){
            $parte=$this->modUso_parte;

        }elseif($this->modUso_parte != '' AND $this->modUso_parte == 'Otra'){
            $this->validate([
                'modUso_parte2'=>'required'
                ],[
                'modUso_parte2'=>'Debes indicar la parte'
            ]);
            $parte=$this->modUso_parte2;
        }
        array_push($this->modPartes, $parte);
        $this->modUso_parte='';
        $this->modUso_parte2='';
    }

    public function BorrarParte($parte){
        if(count($this->modPartes) > '1'){
            $valor=array_search($parte, $this->modPartes);
            unset($this->modPartes[$valor]);

        }else{
            $this->modPartes=[];
        }
    }

    public function GuardarUso(){
        ##### Verifica si no hay parte sin guardar
        if($this->modUso_parte2 != '' OR $this->modUso_parte != ''){
            $this->AgregarParte();
        }

        ##### Verifica que no haya uso-otro vacío
        if($this->modUso_uso != '' AND $this->modUso_uso == 'Otro/NA'){
            $this->validate([
                'modUso_uso2'=>'required',
            ],['modUso_uso2'=>'Debes indicar el uso']);
            $uso=$this->modUso_uso2;
        }elseif($this->modUso_uso != ''){
            $uso=$this->modUso_uso;
        }

        ##### Datos
        $dato=[
            'lsuso_lstid'=>$this->lstId,
            'lsuso_catego'=>$this->modUso_catego,
            'lsuso_uso'=>$uso,
            'lsuso_parte'=>implode(';',$this->modPartes),
            'lsuso_describe'=>$this->modUso_explica,
        ];

        ##### Guarda en BD
        if($this->lstusoId=='0'){
            lista_usos::create($dato);
        }else{
            lista_usos::where('lsuso_id',$this->lstusoId)->update($dato);
        }
        #### Actualiza datos
        $this->EnviarDatosAModalDeListaEspecie();

        #### cierra
        $this->CerrarModalDeAsignaUsoEnLista();
    }

     public function EnviarDatosAModalDeListaEspecie(){
        $dato=lista_usos::where('lsuso_lstid',$this->lstId)
            ->where('lsuso_del','0')
            ->orderBy('lsuso_id')
            ->get();

        $this->dispatch('VariableDesdeUsos',dato:$dato);
        $this->usos=$dato;
    }



    public function render(){

        if($this->modUso_catego != ''){
            $usos=cat_usos::where('cuso_catego',$this->modUso_catego)->get();
        }else{
            // $usos=cat_usos::get();
            $usos=collect();
        }
        $usos=$usos;

        $CatUso=cat_usos::distinct()->pluck('cuso_catego')->toArray();
        $partesPlanta=ced_catalogos::where('cat_tipo','parteplanta')->get();

        return view('livewire.sistema.modal-lista-especie-usos-component',[
            'CatUso'=>$CatUso,
            'partes'=>$partesPlanta,
            'usos'=>$usos,
        ]);
    }
}
