<?php

namespace App\Livewire\Sistema;

use App\Models\CatKewModel;
use App\Models\lista_nombresc;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalListaEspecieNombrescComponent extends Component
{
    /*############################################## ModalLista_Especies
    ###################################################################
    ##### Este modal, requiere dos varables, url_cjarsiglas y url_urltxt
    ##### Copiar AbrirModalDeBuscarEspecie en controller disparador
    ##### <livewire:sistema.modal-lista-especie-component />
    public function AbrirModalDeNombreCientificoEnLista(){
        $datos=[
            'jardin'=>$this->lst_url->url_cjarsiglas,
            'lstId'=>$this->lst_id
        ];
        $this->dispatch('AbreModalDeNombreCientEnlista',$datos);
    } ############################################################# */

    public $listasp_jardin, $listasp_id; #### datos de fuera
    public $listasp_reino, $listasp_familia, $listasp_buscaGen, $listasp_scname, $listasp_scnamePre, $listasp_gen, $listasp_sp, $listasp_ssp, $listasp_var;
    public $listasp_especies, $listasp_ConCatalogo;

    #[On('AbrirModalDeNombreCientificoEnLista')]
    public function montarAbrirModalDeNombreCientifico($datos){
        $this->listasp_jardin=$datos['jardin'];
        $this->listasp_id=$datos['lstId'];

        ##### valores de inicio
         $this->listasp_ConCatalogo='0';
        $this->listasp_especies=collect();
    }


      public function DeterminaReino(){
        // ###### Reinos con catálogo
        // $conCatalogo=['planta'];
        // ###### Distingue catálogo vs no cat.
        // if(in_array($this->listasp_reino, $conCatalogo)){
        //     $this->listasp_ConCatalogo='1';
        // }else{
        //     $this->listasp_ConCatalogo='0';
        // }
        ##### Limpia:
        $this->reset('listasp_familia','listasp_buscaGen','listasp_especies',
            'listasp_gen','listasp_sp','listasp_ssp','listasp_var');
        $this->listasp_especies=collect();
        #$this->limpiarModalDeBuscarEspecie();
    }

    public function BuscaCatalogoDeSp(){
        ##### Valida cuestionario
        $this->validate([
            'listasp_buscaGen'=>'required|min:3' /* ######ojo: en Orchidaceae existe el género Aa (42sp); Asteraceae género lo (1sp) */
        ],[
            'listasp_buscaGen'=>'Debes escribir un mínimo de 3 caracteres'
        ]);

        ###### Busca en catálogo de plantas
        if($this->listasp_reino=='planta'){
            ##### Busca género o especie
            if($this->listasp_buscaGen != ''){
                $this->listasp_especies=CatKewModel::where('ckew_scientfiicname','ilike','%'.$this->listasp_buscaGen.'%')
                    ->orderBy('ckew_scientfiicname')
                    ->get();
            }
        }
    }

    public function GuardaSp(){
        #dd($this->all());
        ######### Verifica estructura jerarquica de nombre científico
        if($this->listasp_gen =='' AND  $this->listasp_ConCatalogo=='0'){
            $this->addError('listasp_gen','Error de anidamiento (Falta indicar el género)');
            return;
        }
        if($this->listasp_sp =='' AND ($this->listasp_ssp!='' ) ){
            $this->addError('listasp_sp','Error de anidamiento (Falta indicar la especie)');
            return;
        }

        ###### Verifica que exista la familia en catálogo cuando solo se mete familia en plantas
        if($this->listasp_reino=='planta' AND  $this->listasp_scnamePre == '' AND $this->listasp_familia != ''){
            ##### Verifica que exista la familia
            if(CatKewModel::where('ckew_family','ilike',$this->listasp_familia)->count() =='0'){
                $this->addError('listasp_familia','No hay registro de esta familia');
                return;
            }
            $this->listasp_familia=strtoupper($this->listasp_familia);
            $this->listasp_gen= '';
            $this->listasp_sp= '';
            $this->listasp_ssp= '';
            $this->listasp_scname= '';
        }
        if($this->listasp_reino=='planta' AND  $this->listasp_scnamePre != ''){
            ##### Obtiene datos del catálogo
            $kew=CatKewModel::where('ckew_taxonid',$this->listasp_scnamePre)->first();
            $this->listasp_familia=strtoupper($kew->ckew_family);
            $this->listasp_gen= $kew->ckew_genus;
            $this->listasp_sp= $kew->ckew_specificepithet;
            $this->listasp_ssp= $kew->ckew_infraspecificepithet;
            $this->listasp_scname= $kew->ckew_scientfiicname;
        }

        if($this->listasp_reino != 'planta'){
            $this->listasp_scname = $this->listasp_gen." ".$this->listasp_sp;
            if($this->listasp_ssp != ''){
                $this->listasp_scname=$this->listasp_scname." ".$this->listasp_ssp;
            }
        }

        // $this->GuardaRegistro('0');
        $datos=[
            'lstc_cjarsiglas'=>$this->listasp_jardin,
            'lstc_lstid'=>$this->listasp_id,
            'lstc_reino'=>$this->listasp_reino,
            'lstc_familia'=>strtoupper($this->listasp_familia),
            'lstc_genero'=>$this->listasp_gen,
            'lstc_sp'=>$this->listasp_sp,
            'lstc_ssp'=>$this->listasp_ssp,
            'lstc_scname'=>$this->listasp_scname,
            'lstc_var'=>$this->listasp_var,

        ];

        ##### Crea registro
        $bla=lista_nombresc::create($datos);
        // $this->listasp_id=$bla->lst_id;
        #### Crea log
        paLog('Se registra nueva especie al listado de '.$this->listasp_jardin, 'lista_nombresc',$bla->lstc_id);




    }

    public function render() {
        $conCatalogo=['planta'];
        if(in_array($this->listasp_reino, $conCatalogo)){
            $this->listasp_ConCatalogo='1';
        }else{
            $this->listasp_ConCatalogo='0';
        }

        return view('livewire.sistema.modal-lista-especie-nombresc-component');
    }
}
