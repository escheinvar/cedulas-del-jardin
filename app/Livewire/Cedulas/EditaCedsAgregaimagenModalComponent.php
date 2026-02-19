<?php

namespace App\Livewire\Cedulas;

use Livewire\Component;

class EditaCedsAgregaimagenModalComponent extends Component
{
    public $imgId, $NvaImagenTipo;

    // public function mount($imgId){
    //     $this->imgId=$imgId;
    // }

    public function render()    {
        return view('livewire.cedulas.edita-ceds-agregaimagen-modal-component');
    }
}
