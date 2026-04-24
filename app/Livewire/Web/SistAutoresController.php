<?php

namespace App\Livewire\Web;

use Livewire\Component;
use App\Models\cat_autores;

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
        $autores=cat_autores::orderBy('caut_nombre','asc')
            ->orderBy('caut_apellido1','asc')
            ->with('cedulas')
            ->with('urlautor')
            ->with('objetos')
            ->get();

        $jardines=collect();
        $lenguas=collect();
// dd($autores);
        return view('livewire.web.sist-autores-controller',[
            'autores'=>$autores,
            'jardines'=>$jardines,
            'lenguas'=>$lenguas,
        ]);
    }
}
