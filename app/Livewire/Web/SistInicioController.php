<?php

namespace App\Livewire\Web;

use Livewire\Component;


class SistInicioController extends Component
{

    public $idioma, $lenguas=['pt','en','es_mix_bj'];

    public function render(){
        return view('livewire.web.sist-inicio-controller');
    }
}
