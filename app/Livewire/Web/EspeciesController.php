<?php

namespace App\Livewire\Web;

use App\Models\EspeciesModel;
use App\Models\SpUrlCedulaModel;
use App\Models\SpUrlModel;
use Livewire\Component;

class EspeciesController extends Component
{
    public function mount(){
        MyRegistraVisita('web_especies');
    }

    public function render(){
        // $cedulas=SpUrlModel::where('url_act','1')->orderBy('url_nombre','asc')->get();
        $cedulas=SpUrlCedulaModel::where('ced_act','1')
        ->where('ced_edo','>=','3')
        ->where('ced_clencode','spa')
        ->where('ced_cjarsiglas','JebOax')
        ->leftJoin('sp_url','url_url','=','ced_urlurl')
        ->get();

        return view('livewire.web.especies-controller',[
            'cedulas'=>$cedulas,
        ]);
    }
}
