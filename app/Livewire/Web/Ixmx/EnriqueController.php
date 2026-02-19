<?php

namespace App\Livewire\Web\Ixmx;

use Livewire\Component;

class EnriqueController extends Component
{

     public function mount(){
        MyRegistraVisita('ixmx_enrique');
    }

    public function render()
    {
        return view('livewire.web.ixmx.enrique-controller');
    }
}
