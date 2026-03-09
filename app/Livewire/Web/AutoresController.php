<?php

namespace App\Livewire\Web;

use App\Models\cat_autores;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AutoresController extends Component
{
    public $jardin, $url; ##### Vars. recibidas por URL
    public $edit, $enEdit; ###### Vars. de edición
    ###### Variables de página cédulas:

    #[Layout('plantillas.baseJardin')]
    public function mount($jardin,$url){
        ##### Carga variables recibidas por URL: carga jardín
        $this->jardin=$jardin;
        // dd(strtolower($jardin),$url);

        ##### Carga variables recibidas por URL: carga datos url
        $this->url=cat_autores::whereRaw('LOWER(caut_cjarsiglas) = ?',strtolower($jardin))
            ->where('caut_url',$url)
            ->where('caut_del','0')
            ->with('jardin')
            // ->with('lenguas')
            ->first();

        if(is_null($this->url)) {
            redirect('/errorLa dirección indicada es incorrecta');
        }else{
            if( $this->url->url_act=='0' or $this->url->count() < '0'){
                redirect('/errorLa dirección indicada es incorrecta');
            }
        }
        // dd($this->url);
    }

    public function render(){
        ##### Verifica que sí tenga permiso web:
        if($this->url->caut_web=='0'){
            redirect('/errorLo sentimos, el sitio que buscas no existe.');
        }
        ##### Revisa permisos del usuario
        $auts=['editor','admin']; ##### array de roles autorizados a editar
        $this->edit='0';
        if(session('rol')){
            if(array_intersect($auts,session('rol'))){
                $this->edit='1';
            }else{
                $this->edit='0';
            }
        }

        return view('livewire.web.autores-controller');
    }
}
