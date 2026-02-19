<?php

namespace App\Livewire\Web;

use Livewire\Component;
use Illuminate\Support\Facades\App;

class InicioController extends Component
{

    public $idioma, $lenguas=['pt','en','es_mix_bj'];

    public function mount(){
        $this->idioma= session('locale');
        MyRegistraVisita('web_inicio');
    }

    public function idiomas(){
        session(['locale'=> $this->idioma]);
        App::setLocale($this->idioma);

        redirect('/');
    }

    public function render(){
        return view('livewire.web.inicio-controller');
    }
}
