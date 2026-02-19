<?php

namespace App\Livewire\Web;

use App\Models\SpUrlCedulaModel;
use App\Models\SpUrlModel;
use Livewire\Component;

class EspeciesIxmController extends Component
{
    public function mount(){
        MyRegistraVisita('web_especies_IxMx');
    }
    public function render() {
        #$cedulas=SpUrlModel::where('url_act','1')->orderBy('url_nombre','asc')->get();
        $cedulas=SpUrlCedulaModel::where('ced_act','1')
        ->where('ced_edo','5')
        ->where('ced_cjarsiglas','IxMxJebOax')
        ->leftJoin('sp_url','url_url','=','ced_urlurl')
        ->get();

        return view('livewire.web.especies-ixm-controller',[
            'cedulas'=>$cedulas,
        ]);
    }
}
