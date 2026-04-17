<?php

namespace App\Livewire\Web;

use Livewire\Component;

class SistAutoresController extends Component
{
    public $buscaText, $buscaJardin, $buscaLengua;

    public function mount(){
        $this->buscaText='';
        $this->buscaJardin='%';
        $this->buscaLengua='%';
    }

    public function render(){
        $autores=collect();
        $jardines=collect();
        $lenguas=collect();

        return view('livewire.web.sist-autores-controller',[
            'autores'=>$autores,
            'jardines'=>$jardines,
            'lenguas'=>$lenguas,
        ]);
    }
}
