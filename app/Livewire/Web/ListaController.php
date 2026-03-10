<?php

namespace App\Livewire\Web;

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\jardin_url;

class ListaController extends Component
{
    public $url;


    #[Layout('plantillas.baseJardin')]
    public function mount($jardin){
        ##### Recibe parámetros por url y los procesa
        $this->url=jardin_url::whereRaw('LOWER(urlj_cjarsiglas) = ?', strtolower($jardin))
            ->where('urlj_url','inicio')
            ->where('urlj_act','1')->where('urlj_del','0')
            ->with('jardin')
            ->with('lenguas')
            ->first();


        if($this->url == null){
            redirect('/error La url que ingresaste es incorrecta');
            return;
        }

        ##### Si no hay banner, pone uno default
        $default='/imagenes/banners/fondo-directorio.jpg';
        if($this->url->urlj_bannerimg==''){
            $this->url->urlj_bannerimg=$default;
        }
    }

    public function render(){
        return view('livewire.web.lista-controller');
    }
}
