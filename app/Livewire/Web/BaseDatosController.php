<?php

namespace App\Livewire\Web;

use App\Models\ClavosColectasModel;
use Livewire\Component;
use Livewire\WithPagination;

class BaseDatosController extends Component
{
    use WithPagination;

    public $base,$sale;
    public $clavo, $genero, $especie, $nombre;

    public function mount(){
        $this->sale="";
    }


    public function buscar(){
        $base=ClavosColectasModel::query();

        ###### Busca por clavo
        if($this->clavo){
            ##### Busca expresión lógica
            if(in_array(substr($this->clavo,0,2), ['==','>>','<<','>=','<=','!=']) ){
                ##### separa la lógica y la operación
                $log=substr($this->clavo,0,2);
                $op=preg_replace("/^$log/","",$this->clavo);
                ##### Si es lógica de dos caracteres tons quita uno
                if(in_array($log,['==','>>','>>'])){$log=substr($log,0,1);}
                ##### hace búsqueda
                $base->where('cl_numero_clavo',$log,$op);
                #$this->sale='logico';

            }elseif(substr($this->clavo,0,5)=="ilike"){
                $op=preg_replace("/^ilike /","",$this->clavo);
                $base->where('cl_numero_clavo','ilike',$op);
                #$this->sale='ilike';

            }else{
                $this->clavo=preg_replace('/\D/', '', $this->clavo);
                $base->where('cl_numero_clavo',$this->clavo);
                #$this->sale='igual';
            }
        }

        ##### Busca por género
        if($this->genero){
            if(substr($this->genero,0,5) == "ilike"){
                $op=preg_replace("/^ilike /","",$this->genero);
                #dd($op);
                $base->where('cl_genero','ilike',$op);
                #$this->sale="ilike";
            }else{
                $base->where('cl_genero',$this->genero);
                #$this->sale="texto";
            }
        }

        ##### Busca por especie
        if($this->especie){
            if(substr($this->especie,0,5) == "ilike"){
                $op=preg_replace("/^ilike /","",$this->especie);
                #dd($op);
                $base->where('cl_especie','ilike',$op);
                $this->sale="ilike";
            }else{
                $base->where('cl_especie',$this->especie);
                $this->sale="texto";
            }
        }

        ##### Busca por nombre común
        if($this->nombre){
            if(substr($this->especie,0,5) == "ilike"){
                $op=preg_replace("/^ilike /","",$this->nombre);
                #dd($op);
                $base->where('cl_nombre_comun','ilike',$op);
                #$this->sale="ilike";
            }else{
                $base->where('cl_nombre_comun',$this->nombre);
                #$this->sale="texto";
            }
        }

        ##### Ejecuta búsqueda
        $this->base=$base->join('pl_clavos_georeferencia_copy1','cl_idcolectas','=','cl_colectas_idcolectas')->get();
       # dd($this->base);

    }

    public function render() {
        $sale='a';
        return view('livewire.web.base-datos-controller',[
            'sale'=>$sale,
        ]);
    }
}
