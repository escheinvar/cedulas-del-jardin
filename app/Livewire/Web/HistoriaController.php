<?php

namespace App\Livewire\Web;

use Livewire\Component;
use Illuminate\Support\Facades\App;

class HistoriaController extends Component
{
    public $idioma, $lenguas=[];

    public function mount(){
        $this->idioma= session('locale');
        MyRegistraVisita('web_historia');
    }

    public function idiomas(){
        session(['locale'=> $this->idioma]);
        App::setLocale($this->idioma);

        redirect('/mapa');
    }

    public function render() {
        return view('livewire.web.historia-controller');
    }
}
