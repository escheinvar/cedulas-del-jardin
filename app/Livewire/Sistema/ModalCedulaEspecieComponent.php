<?php

namespace App\Livewire\Sistema;

use App\Models\CatKewModel;
use App\Models\ced_sp;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalCedulaEspecieComponent extends Component
{
    ############################################## ModalAlias_Especies
    ###################################################################
    ##### Este modal, requiere dos varables, url_cjarsiglas y url_urltxt
    ##### Copiar AbrirModalDeBuscarAutor en controller disparador
    // public function AbrirModalDeBuscarAutor(){
    //     $datos=[
    //         'jardin'=>$this->url->url_cjarsiglas,
    //         'urltxt'=>$this->url->url_urltxt
    //     ];
    //     $this->dispatch('AbreModalDeBuscarAutor',$datos);
    // }
    public $aliasp_jardin, $aliasp_urltxt;  ##### Vars. grales.
    public $aliasp_ConCatalogo; #### Indica si hay o no catálogo de sp.
    public $aliasp_reino, $aliasp_familia, $aliasp_buscaGen, $aliasp_gen;
    public $aliasp_sp, $aliasp_ssp, $aliasp_var, $aliasp_especies; ##### Variables de formaulario

    #[On('AbreModalDeBuscarAutor')]
    public function montarAbrirModalDeBuscarAutor($datos){
        ##### recibe variables externas
        $this->aliasp_jardin=$datos['jardin'];
        $this->aliasp_urltxt=$datos['urltxt'];

        ##### Prepara variables de modal
        $this->aliasp_ConCatalogo='0';
        $this->aliasp_especies=collect();
    }

    public function limpiarModalDeBuscarAutor(){
        $this->reset('aliasp_familia','aliasp_buscaGen','aliasp_especies','aliasp_sp','aliasp_gen','aliasp_ssp','aliasp_var');
        $this->aliasp_especies=collect();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function CerrarModalDeBuscarAutor(){
        $this->limpiarModalDeBuscarAutor();
        $this->aliasp_reino='';
        $this->dispatch('CierraModalDeBuscarAutor',reload:'1');
    }

    public function DeterminaReino(){
        ###### Reinos con catálogo
        $conCatalogo=['planta'];
        ###### Distingue catálogo vs no cat.
        if(in_array($this->aliasp_reino, $conCatalogo)){
            $this->aliasp_ConCatalogo='1';
        }else{
            $this->aliasp_ConCatalogo='0';
        }
        ##### Limpia:
        $this->limpiarModalDeBuscarAutor();
    }

    public function BuscaCatalogoDeSp(){
        ##### Valida cuestionario
        $this->validate([
            'aliasp_buscaGen'=>'required|min:3' /* ######ojo: en Orchidaceae existe el género Aa (42sp); Asteraceae género lo (1sp) */
        ],[
            'aliasp_buscaGen'=>'Debes escribir un mínimo de 3 caracteres'
        ]);

        ###### Busca en catálogo de plantas
        if($this->aliasp_reino=='planta'){
            ##### Busca género o especie
            if($this->aliasp_buscaGen != ''){
                $this->aliasp_especies=CatKewModel::where('ckew_scientfiicname','ilike','%'.$this->aliasp_buscaGen.'%')
                    ->orderBy('ckew_scientfiicname')
                    ->get();
            }
        }
    }

    public function GuardaSp(){
        ######### Verifica estructura:
        if($this->aliasp_gen =='' AND ($this->aliasp_sp!='') and $this->aliasp_ConCatalogo=='0'){
            $this->addError('aliasp_gen','Error de anidamiento (Falta indicar el género)');
            return;
        }
        if($this->aliasp_sp =='' AND ($this->aliasp_ssp!='' OR $this->aliasp_var!='') ){
            $this->addError('aliasp_sp','Error de anidamiento (Falta indicar la especie)');
            return;
        }

        ########## Construye array de datos para catálogo de plantas
        if($this->aliasp_ConCatalogo=='1' and $this->aliasp_reino=='planta'){
            ##### Valida familia
            if($this->aliasp_familia != '' and $this->aliasp_sp == ''){
                ##### Verifica que exista la familia
                if(CatKewModel::where('ckew_family','ilike',$this->aliasp_familia)->count() =='0'){
                    $this->addError('aliasp_familia','No hay registro de esta familia');
                    return;
                }
            }
            ##### Verifica que exista al menos un dato
            if($this->aliasp_familia=='' and $this->aliasp_sp ==''){
                $this->addError('aliasp_sp','Debes ingresar familia, género o especie');
                return;
            }

            ##### Obtiene datos del catálogo
            $sp=CatKewModel::where('ckew_taxonid',$this->aliasp_sp)->first();
            if($this->aliasp_sp != ''){
                $familia=strtoupper($sp->ckew_family);
                $nombre=$sp->ckew_scientfiicname;
                $genero=$sp->ckew_genus;
                $especie=$sp->ckew_specificepithet;
                $subsp=$sp->ckew_infraspecificepithet;
                $var=$this->aliasp_var;
            }else{
                $familia=$this->aliasp_familia;
                $nombre=null;
                $genero=null;
                $especie=null;
                $subsp=null;
                $var=null;
            }

            $datos=[
                'sp_cjarsiglas'=>$this->aliasp_jardin,
                'sp_urltxt'=>$this->aliasp_urltxt,
                'sp_scname'=>$nombre,
                'sp_reino'=>$this->aliasp_reino,
                'sp_familia'=>strtoupper($familia),
                'sp_genero'=>$genero,
                'sp_especie'=>$especie,
                'sp_ssp'=>$subsp,
                'sp_var'=>$var,
            ];

        }

        ########## Construye array de datos para sin catálogo
        if($this->aliasp_ConCatalogo=='0'){
            $nombre=$this->aliasp_gen." ".$this->aliasp_sp;
            if($this->aliasp_ssp != ''){$nombre=$nombre." ".$this->aliasp_ssp;}
            $datos=[
                'sp_cjarsiglas'=>$this->aliasp_jardin,
                'sp_urltxt'=>$this->aliasp_urltxt,
                'sp_scname'=>$nombre,
                'sp_reino'=>$this->aliasp_reino,
                'sp_familia'=>strtoupper($this->aliasp_familia),
                'sp_genero'=>$this->aliasp_gen,
                'sp_especie'=>$this->aliasp_sp,
                'sp_ssp'=>$this->aliasp_ssp,
                'sp_var'=>$this->aliasp_var,
            ];
        }

        ##### Guarda datos:
        $bla=ced_sp::create($datos);

        #### Crea log
        paLog('Se vincula la cedula '.$this->aliasp_jardin."-".$this->aliasp_urltxt.' a la sp '.$nombre,'ced_sp',$bla->sp_id);

        #### Limpia
        $this->limpiarModalDeBuscarAutor();
        $this->aliasp_reino='';

        #### Aviso
        $this->dispatch('AvisoExitoAliasCedula',msj:'Se vinculó la cédula a la especie correctamente');

        ##### Cierra
        $this->dispatch('CierraModalDeBuscarAutor',reload:'1');
    }

    ################################################## Página general
    ##################################################################
    public function render() {
        return view('livewire.sistema.modal-cedula-especie-component');
    }
}
