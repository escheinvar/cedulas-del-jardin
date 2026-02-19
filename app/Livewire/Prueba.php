<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.SistemaBase')]
class Prueba extends Component
{

    public function mount(){


        session(
            ['rol'=>['admin','traduce']]
        );
    }

    public function render(){
        return view('livewire.prueba');
    }
}
