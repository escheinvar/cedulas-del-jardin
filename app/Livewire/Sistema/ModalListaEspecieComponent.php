<?php

namespace App\Livewire\Sistema;

use App\Models\CatKewModel;
use App\Models\ced_sp;
use App\Models\cedulas_url;
use App\Models\lista;
use Livewire\Attributes\On;
use Livewire\Component;


class ModalListaEspecieComponent extends Component
{
     /*############################################## ModalLista_Especies
    ###################################################################
    ##### Este modal, requiere dos varables, url_cjarsiglas y url_urltxt
    ##### Copiar AbrirModalDeBuscarEspecie en controller disparador
    ##### <livewire:sistema.modal-lista-especie-component />
    public function AbrirModalDeListaEspecie(){
        $datos=[
            'jardin'=>$this->lst_url->url_cjarsiglas,
            'lstId'=>$this->lst_id
        ];
        $this->dispatch('AbreModalDeListaDeEspecies',$datos);
    }
    ############################################################# */
    public $listasp_jardin, $listasp_id;  ##### Vars. grales.
    public $listasp_ConCatalogo; #### Indica si hay o no catálogo de sp.
    public $listasp_reino, $listasp_familia, $listasp_buscaGen, $listasp_gen;
    public $listasp_sp, $listasp_scname, $listasp_ssp, $listasp_var, $listasp_especies; ##### Variables de formaulario
    public $listasp_nombre, $listasp_orden, $listasp_razon;

    #[On('AbrirModalDeListaDeEspecies')]
    public function montarAbrirModalDeBuscarEspecie($datos){
        ##### recibe variables externas
        $this->listasp_jardin=$datos['jardin'];
        $this->listasp_id=$datos['lstId'];

        ##### Prepara variables de modal
        $this->listasp_ConCatalogo='0';
        $this->listasp_especies=collect();

        if($this->listasp_id != '0'){
            ##### Si es edición, carga datos
            $registro=lista::where('lst_id',$this->listasp_id)->first();
            $this->listasp_reino=$registro->lst_reino;
            $this->listasp_familia=$registro->lst_familia;
            $this->listasp_gen=$registro->lst_gen;
            $this->listasp_scname=$registro->lst_scname;
            $this->listasp_ssp=$registro->lst_ssp;
            $this->listasp_var=$registro->lst_var;
            $this->listasp_nombre=$registro->lst_name;
            $this->listasp_orden=$registro->lst_orden;
            $this->listasp_razon=$registro->lst_notas;

            ##### Determina si hay catálogo
            if($registro->lst_sp != '' and $registro->lst_reino=='planta'){
                $this->listasp_ConCatalogo='1';
            }
        }else{
            $this->listasp_orden=round(lista::max('lst_orden') + 1);
        }
    }

    public function limpiarModalDeBuscarEspecie(){
        $this->reset('listasp_familia','listasp_buscaGen','listasp_especies','listasp_scname','listasp_gen','listasp_ssp','listasp_var');
        $this->reset('listasp_nombre','listasp_orden','listasp_razon');
        $this->listasp_especies=collect();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function CerrarModalDeBuscarEspecie($reload){
        if(!isset($reload) or $reload==''){$reload='0';}
        $this->limpiarModalDeBuscarEspecie();
        $this->listasp_reino='';
        $this->dispatch('CierraModalDeListaDeEspecies',reload:$reload);
    }

    public function DeterminaReino(){
        ###### Reinos con catálogo
        $conCatalogo=['planta'];
        ###### Distingue catálogo vs no cat.
        if(in_array($this->listasp_reino, $conCatalogo)){
            $this->listasp_ConCatalogo='1';
        }else{
            $this->listasp_ConCatalogo='0';
        }
        ##### Limpia:
        $this->limpiarModalDeBuscarEspecie();
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
        if($this->listasp_id=='0'){
            ######### Verifica estructura:
            if($this->listasp_gen =='' AND ($this->listasp_scname!='') and $this->listasp_ConCatalogo=='0'){
                $this->addError('listasp_gen','Error de anidamiento (Falta indicar el género)');
                return;
            }
            if($this->listasp_sp =='' AND ($this->listasp_ssp!='' ) ){
                $this->addError('listasp_sp','Error de anidamiento (Falta indicar la especie)');
                return;
            }
            if(in_array($this->listasp_orden, lista::where('lst_cjarsiglas',$this->listasp_jardin)->where('lst_id','!=',$this->listasp_id)->pluck('lst_orden')->toArray())){
                $this->addError('listasp_orden','Ya existe un registro con este número de orden. Por favor elige otro.');
                return;
            }


            ########## Construye array de datos para catálogo de plantas
            if($this->listasp_reino=='planta'){
                ##### Valida familia
                if($this->listasp_familia != '' and $this->listasp_scname == ''){
                    ##### Verifica que exista la familia
                    if(CatKewModel::where('ckew_family','ilike',$this->listasp_familia)->count() =='0'){
                        $this->addError('listasp_familia','No hay registro de esta familia');
                        return;
                    }
                }
                ##### Verifica que exista al menos un dato
                // if($this->listasp_familia=='' and $this->listasp_scname ==''){
                //     $this->addError('listasp_scname','Debes ingresar familia, género o especie');
                //     return;
                // }

                ##### Obtiene datos del catálogo
                $sp=CatKewModel::where('ckew_taxonid',$this->listasp_scname)->first();
                if($this->listasp_scname != ''){
                    $familia=strtoupper($sp->ckew_family);
                    $nombre=$sp->ckew_scientfiicname;
                    $genero=$sp->ckew_genus;
                    $especie=$sp->ckew_specificepithet;
                    $subsp=$sp->ckew_infraspecificepithet;
                    $var=$this->listasp_var;
                }else{
                    $familia=$this->listasp_familia;
                    $nombre=null;
                    $genero=null;
                    $especie=null;
                    $subsp=null;
                    $var=null;
                }

                $datos=[
                    'lst_cjarsiglas'=>$this->listasp_jardin,
                    // 'lst_edo'=>'0',
                    'lst_orden'=>$this->listasp_orden,
                    'lst_reino'=>$this->listasp_reino,
                    'lst_familia'=>strtoupper($familia),
                    'lst_genero'=>$genero,
                    'lst_sp'=>$especie,
                    'lst_ssp'=>$subsp,
                    'lst_scname'=>$nombre,
                    'lst_var'=>$var,
                    'lst_name'=>$this->listasp_nombre,
                    'lst_notas'=>$this->listasp_razon,
                ];

                ########## Construye array de datos para sin catálogo
            }else{
            $nombre=$this->listasp_gen." ".$this->listasp_sp;
                if($this->listasp_ssp != ''){$nombre=$nombre." ".$this->listasp_ssp;}
                $datos=[
                    'lst_cjarsiglas'=>$this->listasp_jardin,
                    // 'lst_edo'=>'0',
                    'lst_orden'=>$this->listasp_orden,
                    'lst_reino'=>$this->listasp_reino,
                    'lst_familia'=>strtoupper($this->listasp_familia),
                    'lst_genero'=>$this->listasp_gen,
                    'lst_sp'=>$this->listasp_sp,
                    'lst_ssp'=>$this->listasp_ssp,
                    'lst_scname'=>$nombre,
                    'lst_var'=>$this->listasp_var,
                    'lst_name'=>$this->listasp_nombre,
                    'lst_notas'=>$this->listasp_razon,
                ];
            }
            ##### Crea registro
            $bla=lista::create($datos);
            #### Crea log
            paLog('Se incluye especie '.$nombre." al listado de especies",'lista',$bla->sp_id);

        }else{
            $original=lista::where('lst_id',$this->listasp_id)->first();
            $datos=[
                'lst_cjarsiglas'=>$this->listasp_jardin,
                // 'lst_edo'=>'0',
                'lst_orden'=>$this->listasp_orden,
                'lst_reino'=>$original->lst_reino,
                'lst_familia'=>$original->lst_familia,
                'lst_genero'=>$original->lst_genero,
                'lst_sp'=>$original->lst_sp,
                'lst_ssp'=>$original->lst_ssp,
                'lst_scname'=>$original->lst_scname,
                'lst_var'=>$original->lst_var,
                'lst_name'=>$this->listasp_nombre,
                'lst_notas'=>$this->listasp_razon,
            ];
            ##### Edita registro
            lista::where('lst_id',$this->listasp_id)->update($datos);
            #### Crea log
            paLog('Se edita especie en listado de especies','lista',$this->listasp_id);
        }

        #### Limpia
        $this->limpiarModalDeBuscarEspecie();
        $this->listasp_reino='';

        ##### Cierra
        $this->dispatch('CierraModalDeListaDeEspecies',reload:'1');
    }

    ################################################## Página general
    ##################################################################


    public function render(){


        return view('livewire.sistema.modal-lista-especie-component',[

        ]);
    }
}
