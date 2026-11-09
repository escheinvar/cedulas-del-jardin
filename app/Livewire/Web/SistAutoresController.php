<?php

namespace App\Livewire\Web;

use Livewire\Component;
use App\Models\cat_autores;
use App\Models\CatJardinesModel;

class SistAutoresController extends Component
{
    public $buscaText, $buscaJardin, $buscaLengua;

    public function mount(){
        $this->buscaText='';
        $this->buscaJardin='%';
        $this->buscaLengua='%';
    }

    public function render(){
        ###### Obtiene lista de autores
        $autores=cat_autores::query();
        $autores=$autores->orderBy('caut_nombre','asc')
            ->orderBy('caut_apellido1','asc')
            ->with('cedulas')
            ->with('urlautor')
            ->with('objetos');

        ##### Busca por nombre
        if(strlen($this->buscaText) >'2'){
            $autores=$autores->where(function($q){
                return $q
                ->where('caut_nombre','ilike','%'.$this->buscaText.'%')
                ->orWhere('caut_apellido1','ilike','%'.$this->buscaText.'%')
                ->orWhere('caut_apellido2','ilike','%'.$this->buscaText.'%');
            });
        }

        $autores=$autores->get();
        $jardines=CatJardinesModel::orderBy('cjar_id')->get();
        $lenguas=collect();

        return view('livewire.web.sist-autores-controller',[
            'autores'=>$autores,
            'jardines'=>$jardines,
            'lenguas'=>$lenguas,
        ]);
    }
}
