<?php

namespace App\Livewire\Web;

use Livewire\Component;

class ColaboradoresController extends Component
{
    public function mount(){
        MyRegistraVisita('web_colaboradores');
    }

    public function render(){
        return view('livewire.web.colaboradores-controller');
    }
}
