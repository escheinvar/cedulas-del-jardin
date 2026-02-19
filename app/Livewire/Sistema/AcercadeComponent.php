<?php

namespace App\Livewire\Sistema;

use Livewire\Attributes\Layout;
use Livewire\Component;



#[Layout('components.layouts.SistemaBase')]

class AcercadeComponent extends Component
{
    public function render()
    {
        return view('livewire.sistema.acercade-component');
    }
}
