<?php

namespace App\Livewire\Web;

use Livewire\Component;
use Illuminate\Support\Facades\App;

class RecorridosController extends Component
{
    // public $idioma, $lenguas=['pt','en','es_mix_bj'];
    public $idioma, $lenguas=['pt','en'];

    public function mount(){
        $this->idioma= session('locale');
        MyRegistraVisita('web_recorridos');
    }

    public function idiomas(){
        session(['locale'=> $this->idioma]);
        App::setLocale($this->idioma);

        redirect('/recorridos');
    }

    public function render()
    {
        return view('livewire.web.recorridos-controller');
    }
}
