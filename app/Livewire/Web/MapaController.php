<?php

namespace App\Livewire\Web;

use Livewire\Component;
use Illuminate\Support\Facades\App;

class MapaController extends Component
{
    public $idioma, $lenguas=['pt','en'];
    public $mapa;

    public function mount(){
        $this->idioma= session('locale');
        $this->mapa="/imagenes/mapa/mapa-pre-01.png";
        MyRegistraVisita('web_mapa');
    }

    public function cambiaFoto($section){
        if($section == 'dentro'){
            $this->mapa = "/imagenes/mapa/mapa-pre-02.png";

        }elseif($section == 'sobresalientes'){
            $this->mapa = "/imagenes/mapa/mapa-pre-04.png";

        }elseif($section == 'secciones'){
            $this->mapa = "/imagenes/mapa/mapa-pre-03.png";

        }else{
            $this->mapa = "/imagenes/mapa/mapa-pre-01.png";
        }

    }

    public function idiomas(){
        session(['locale'=> $this->idioma]);
        App::setLocale($this->idioma);

        redirect('/mapa');
    }

    public function render() {
        return view('livewire.web.mapa-controller');
    }
}
