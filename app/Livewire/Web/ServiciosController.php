<?php

namespace App\Livewire\Web;

use Livewire\Component;
use Illuminate\Support\Facades\App;

class ServiciosController extends Component
{
    public $idioma, $lenguas=[];

    public function mount(){
        $this->idioma= session('locale');
        MyRegistraVisita('web_servicios');
    }

    public function idiomas(){
        session(['locale'=> $this->idioma]);
        App::setLocale($this->idioma);

        redirect('/recorridos');
    }

    public function render(){
        return view('livewire.web.servicios-controller');
    }
}
