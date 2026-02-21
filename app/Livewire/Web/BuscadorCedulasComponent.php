<?php

namespace App\Livewire\Web;

use App\Models\SpUrlCedulaModel;
use App\Models\SpUrlModel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BuscadorCedulasComponent extends Component
{
    public $buscaText, $buscaJardin, $buscaLengua;

    public function mount(){
        MyRegistraVisita('web_buscaCedulas');
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

        $cedulas=DB::table('sp_urlcedula')
            ->where('ced_act','1')
            ->where('ced_edo','5')
            ->where('ced_cjarsiglas','like',$this->buscaJardin)
            ->where('ced_clencode','like',$this->buscaLengua)
            ->where(function($q) use ($texto) {
                return $q
                ->where('ced_urlurl','like','%'.$texto.'%')
                ->orWhere('url_url','like','%'.$texto.'%')
                ->orWhere('url_nombre','like','%'.$texto.'%')
                ->orWhere('url_nombrecomun','like','%'.$texto.'%')
            ;})
            ->leftJoin('sp_url','url_url','=','ced_urlurl')
            ->leftJoin('cat_lenguas', 'ced_clencode', '=', 'clen_code')
            ->leftJoin('cat_jardines','cjar_siglas','=','ced_cjarsiglas')
            ->orderBy('url_nombre')
            ->orderBy('ced_cjarsiglas')
            ->orderBy('ced_clencode')
            ->get();


        $cedulas2=SpUrlCedulaModel::where('ced_act','1')
            ->where('ced_edo','5')
            ->leftJoin('sp_url','url_url','=','ced_urlurl')
            ->leftJoin('cat_lenguas', 'ced_clencode', '=', 'clen_code')
            ->leftJoin('cat_jardines','cjar_siglas','=','ced_cjarsiglas')
            ->orderBy('url_nombre')
            ->orderBy('ced_clencode')
            ->get();

        $jardines=$cedulas2->unique('ced_cjarsiglas');
        $lenguas=$cedulas2->unique('ced_clencode');

        return view('livewire.web.buscador-cedulas-component',[
            'cedulas'=>$cedulas,
            'jardines'=>$jardines,
            'lenguas'=>$lenguas,
        ]);
    }
}
