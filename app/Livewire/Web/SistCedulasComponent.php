<?php

namespace App\Livewire\Web;

use App\Models\SpUrlCedulaModel;
use App\Models\cedulas_url;
use App\Models\SpUrlModel;
use App\Models\ced_sp;
use App\Models\ced_alias;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SistCedulasComponent extends Component
{
    public $buscaText, $ganonesText, $buscaJardin, $buscaLengua;

    public function mount(){
        $this->buscaText='';
        $this->buscaJardin='';
        $this->buscaLengua='';
        $this->ganonesText=[];
    }

    // public function CambiaLengua($CedId){
    //     $dato=SpUrlCedulaModel::where('ced_id',$CedId)->first();
    //     session(['locale'=> $dato->ced_clencode]);
    //     session(['locale2'=> $dato->ced_clencode]);
    //     App::setLocale($dato->ced_clencode);
    //     $ruta="/sp/".$dato->ced_urlurl."/".$dato->ced_cjarsiglas;
    //     redirect($ruta);
    // }

    public function BuscaPorTexto(){
        $this->ganonesText=[];
        $this->validate([
            'buscaText'=>'required|string|min:3',
        ]);

        ##### busca en título, resumen y cita
        $ceds=cedulas_url::where('url_act','1')->where('url_del','0')
            ->where(function($q){
                return $q
                ->where('url_titulo','ilike','%'.$this->buscaText.'%')
                ->orWhere('url_tituloorig','ilike','%'.$this->buscaText.'%')
                ->orWhere('url_resumen','ilike','%'.$this->buscaText.'%')
                ->orWhere('url_resumenorig','ilike','%'.$this->buscaText.'%')
                ->orWhere('url_cita','ilike','%'.$this->buscaText.'%');
            })
            ->pluck('url_id')
            ->toArray();

        ##### Busca por nombre científico
        $nomsc=ced_sp::where('sp_scname','ilike','%'.$this->buscaText.'%')
            ->leftJoin('cedula_url','sp_key','url_key')
            ->where('sp_act','1')->where('sp_del','0')
            ->pluck('url_id')
            ->toArray();

        ###### Busca por alias
        $alias=ced_alias::where('ali_txt_tr','ilike','%'.$this->buscaText.'%')
            ->where('ali_act','1')->where('ali_del','0')
            ->pluck('ali_urlid')
            ->toArray();

        $todo=array_merge($ceds,$nomsc,$alias);
        $this->ganonesText=array_unique($todo);
    }

    public function BorrarTexto(){
        $this->buscaText='';
        $this->ganonesText=[];
    }


    public function render() {
        ####### Inicia búsqueda de cédulas
        $cedulas=cedulas_url::query();

        $cedulas=$cedulas->where('url_act','1')
            ->where('url_del','0')
            ->where('url_ciclo','>','0')
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
            ->inRandomOrder();

        ##### Busca por jardín
        if($this->buscaJardin != ''){
            $cedulas=$cedulas->where('url_cjarsiglas',$this->buscaJardin);
        }

        ##### Busca por lengua
        if($this->buscaLengua != ''){
            $cedulas=$cedulas->where('url_lencode',$this->buscaLengua);
        }

        ##### Busca por nombres
        if(count($this->ganonesText) > '0' or $this->buscaText != ''){
            $cedulas=$cedulas->whereIn('url_id',$this->ganonesText);
        }


        ###### Genera listado de lenguas para formulario
        $lenguas=cedulas_url::where('url_ciclo','>','0')
            ->leftJoin('lenguas', 'url_lencode', '=', 'len_code')
            ->where('url_act','1')
            ->where('url_del','0')
            ->distinct('url_lencode')
            ->select('url_lencode','len_lengua','len_autonimias')
            ->get();

        ##### Genera listado de jardines para formulario
        $jardines=cedulas_url::where('url_ciclo','>','0')
            ->leftJoin('cat_jardines', 'cjar_siglas', '=', 'url_cjarsiglas')
            ->where('url_act','1')
            ->where('url_del','0')
            ->distinct('cjar_siglas')
            ->select('cjar_siglas','cjar_nombre','cjar_name')
            ->get();


        return view('livewire.web.sist-cedulas-component',[
            'cedulas'=>$cedulas->get(),
            'jardines'=>$jardines,
            'lenguas'=>$lenguas,
        ]);
    }
}
