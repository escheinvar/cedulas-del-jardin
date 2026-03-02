<?php

namespace App\Livewire\Cedulas;

use App\Models\SpUrlCedulaModel;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class DistribuidorDeCedulasComponent extends Component
{

    public $url, $jardin, $lengua;

    public function mount(string $url, $jardin, $lengua){
        $this->url=$url;
        $this->jardin=$jardin;
        $this->lengua=$lengua;

    }

    public function render(){
        #$dato=SpUrlCedulaModel::where('ced_id',$CedId)->first();
        $dato=SpUrlCedulaModel::where('ced_urlurl',$this->url)
            ->where('ced_clencode',$this->lengua)
            ->where('ced_cjarsiglas',$this->jardin)
            ->get();
        if($dato->count() != '1'){
            redirect ('/especies');
        }else{
            session(['locale'=> $this->lengua]);
            session(['locale2'=> $this->lengua]);
            App::setLocale($this->lengua);
            $ruta="/sp/".$this->url."/".$this->jardin;
            redirect($ruta);
        }
       return view('livewire.cedulas.distribuidor-de-cedulas-component');
    }
}
