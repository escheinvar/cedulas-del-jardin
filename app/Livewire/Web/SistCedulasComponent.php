<?php

namespace App\Livewire\Web;

use App\Models\SpUrlCedulaModel;
use App\Models\cedulas_url;
use App\Models\SpUrlModel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SistCedulasComponent extends Component
{
    public $buscaText, $buscaJardin, $buscaLengua;

    public function mount(){
        $this->buscaText='';
        $this->buscaJardin='%';
        $this->buscaLengua='%';
    }

    public function CambiaLengua($CedId){
        $dato=SpUrlCedulaModel::where('ced_id',$CedId)->first();

        session(['locale'=> $dato->ced_clencode]);
        session(['locale2'=> $dato->ced_clencode]);
        App::setLocale($dato->ced_clencode);
        $ruta="/sp/".$dato->ced_urlurl."/".$dato->ced_cjarsiglas;
        redirect($ruta);
    }

    public function render() {
        if($this->buscaText==''){
            $texto='%';
        }else{
            $texto=$this->buscaText;
        }

        $cedulas=cedulas_url:: #where('url_ciclo','>','0')
            where('url_act','1')
            ->where('url_del','0')
            ->with('jardin')
            ->with('objetos')
            ->with('lenguas')
            ->with('ubicaciones')
            ->with('alias')
            ->with('especies')
            ->with('usos')
            ->with('jardin')
            ->with('autores')
            ->with('traductores')
            ->inRandomOrder()
            ->get();




        $lenguas=cedulas_url::where('url_ciclo','>','0')
            ->leftJoin('lenguas', 'url_lencode', '=', 'len_code')
            ->where('url_act','1')
            ->where('url_del','0')
            ->distinct('url_lencode')
            ->select('url_lencode','len_lengua','len_autonimias')
            ->get();

        $jardines=cedulas_url::where('url_ciclo','>','0')
            ->leftJoin('cat_jardines', 'cjar_siglas', '=', 'url_cjarsiglas')
            ->where('url_act','1')
            ->where('url_del','0')
            ->distinct('cjar_siglas')
            ->select('cjar_siglas','cjar_nombre','cjar_name')
            ->get();

        return view('livewire.web.sist-cedulas-component',[
            'cedulas'=>$cedulas,
            'jardines'=>$jardines,
            'lenguas'=>$lenguas,
        ]);
    }
}
