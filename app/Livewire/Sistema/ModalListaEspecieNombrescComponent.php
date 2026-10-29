<?php

namespace App\Livewire\Sistema;

use App\Models\CatKewModel;
use App\Models\lista_nombresc;
use App\Models\lista;
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

    public $listasc_jardin, $listasc_id; #### datos de fuera
    public $listasc_reino, $listasc_familia, $listasc_buscaGen, $listasc_scname, $listasc_scnamePre, $listasc_gen, $listasc_sp, $listasc_ssp, $listasc_var;
    public $listasc_especies, $listasc_ConCatalogo;

    #[On('AbreModalDeNombreCientEnlista')]
    public function montarAbrirModalDeNombreCientifico($datos){
        $this->listasc_jardin=$datos['jardin'];
       $this->listasc_id=$datos['lstId'];

        ##### valores de inicio
        $this->listasc_ConCatalogo='0';
        $this->listasc_especies=collect();
    }


      public function DeterminaReino(){
        // ###### Reinos con catálogo
        // $conCatalogo=['planta'];
        // ###### Distingue catálogo vs no cat.
        // if(in_array($this->listasc_reino, $conCatalogo)){
        //     $this->listasc_ConCatalogo='1';
        // }else{
        //     $this->listasc_ConCatalogo='0';
        // }
        ##### Limpia:
        $this->reset('listasc_familia','listasc_buscaGen','listasc_especies',
            'listasc_gen','listasc_sp','listasc_ssp','listasc_var');
        $this->listasc_especies=collect();
        #$this->limpiarModalDeBuscarEspecie();
    }

    public function BuscaCatalogoDeSp(){
        ##### Valida cuestionario
        $this->validate([
            'listasc_buscaGen'=>'required|min:3' /* ######ojo: en Orchidaceae existe el género Aa (42sp); Asteraceae género lo (1sp) */
        ],[
            'listasc_buscaGen'=>'Debes escribir un mínimo de 3 caracteres'
        ]);

        ###### Busca en catálogo de plantas
        if($this->listasc_reino=='planta'){
            ##### Busca género o especie
            if($this->listasc_buscaGen != ''){
                $this->listasc_especies=CatKewModel::where('ckew_scientfiicname','ilike','%'.$this->listasc_buscaGen.'%')
                    ->orderBy('ckew_scientfiicname')
                    ->get();
            }
        }
    }

    public function GuardaSp(){
        ######### Verifica estructura jerarquica de nombre científico
        if($this->listasc_gen =='' AND  $this->listasc_ConCatalogo=='0'){
            $this->addError('listasc_gen','Error de anidamiento (Falta indicar el género)');
            return;
        }
        if($this->listasc_sp =='' AND ($this->listasc_ssp!='' ) ){
            $this->addError('listasc_sp','Error de anidamiento (Falta indicar la especie)');
            return;
        }

        ###### Verifica que exista la familia en catálogo cuando solo se mete familia en plantas
        if($this->listasc_reino=='planta' AND  $this->listasc_scnamePre == '' AND $this->listasc_familia != ''){
            ##### Verifica que exista la familia
            if(CatKewModel::where('ckew_family','ilike',$this->listasc_familia)->count() =='0'){
                $this->addError('listasc_familia','No hay registro de esta familia');
                return;
            }
            $this->listasc_familia=strtoupper($this->listasc_familia);
            $this->listasc_gen= '';
            $this->listasc_sp= '';
            $this->listasc_ssp= '';
            $this->listasc_scname= '';
        }

        ##### Si es planta, obtiene datos de kew
        if($this->listasc_reino=='planta' AND  $this->listasc_scnamePre != ''){
            $kew=CatKewModel::where('ckew_taxonid',$this->listasc_scnamePre)->first();
            $this->listasc_familia=strtoupper($kew->ckew_family);
            $this->listasc_gen= $kew->ckew_genus;
            $this->listasc_sp= $kew->ckew_specificepithet;
            $this->listasc_ssp= $kew->ckew_infraspecificepithet;
            $this->listasc_scname= $kew->ckew_scientfiicname;
        }

        ##### Si no es planta, obtiene datos de cuestionario
        if($this->listasc_reino != 'planta'){
            $this->listasc_scname = $this->listasc_gen." ".$this->listasc_sp;
            if($this->listasc_ssp != ''){
                $this->listasc_scname=$this->listasc_scname." ".$this->listasc_ssp;
            }
        }

        ##### Si aún no hay registro de lista (istasc_id==0), entonces lo crea primero
        if($this->listasc_id=='0'){
            ##### Crea registro
            $bla=lista::create([
                'lst_cjarsiglas'=>$this->listasc_jardin,
            ]);
            ##### Toma nuevo valor de id
            $this->listasc_id= $bla->lst_id;
            ##### Manda id al modal de especie (pues inició como 0)
            $this->dispatch('VariableDesdeNombreCientificoANombre',$this->listasc_id);
        }

        // $this->GuardaRegistro('0');
        $datos=[
            // 'lstc_cjarsiglas'=>$this->listasc_jardin,
            'lstsc_lstid'=>$this->listasc_id,
            'lstsc_reino'=>$this->listasc_reino,
            'lstsc_familia'=>strtoupper($this->listasc_familia),
            'lstsc_genero'=>$this->listasc_gen,
            'lstsc_sp'=>$this->listasc_sp,
            'lstsc_ssp'=>$this->listasc_ssp,
            'lstsc_scname'=>$this->listasc_scname,
            'lstsc_var'=>$this->listasc_var,
        ];
        ##### Crea registro
        $bla=lista_nombresc::create($datos);

        // $this->listasc_id=$bla->lst_id;
        #### Crea log
        paLog('Se registra nueva especie al listado de '.$this->listasc_jardin, 'lista_nombresc',$bla->lstc_id);

        $this->CerrarModalNombreCient();



    }

    public function limpiarModalNombreCient(){
        $this->reset('listasc_reino', 'listasc_familia', 'listasc_buscaGen', 'listasc_scname',
            'listasc_scnamePre', 'listasc_gen', 'listasc_sp', 'listasc_ssp', 'listasc_var');
        $this->listasc_ConCatalogo='0';
        $this->listasc_especies=collect();

        $this->resetValidation();
    }

    public function CerrarModalNombreCient(){

        #### Reenvía id a modal de especie (por si cambio el id 0 a un número)
        $this->dispatch('VariableDesdeNombreCientificoANombre',dato:$this->listasc_id);
        $this->limpiarModalNombreCient();
        $this->dispatch('CierraModalDeNombreCientEnLista',reload:0);
    }

    public function render() {
        $conCatalogo=['planta'];
        if(in_array($this->listasc_reino, $conCatalogo)){
            $this->listasc_ConCatalogo='1';
        }else{
            $this->listasc_ConCatalogo='0';
        }

        return view('livewire.sistema.modal-lista-especie-nombresc-component');
    }
}
