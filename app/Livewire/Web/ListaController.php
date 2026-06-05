<?php

namespace App\Livewire\Web;

use App\Models\jardin_url;
use App\Models\lista;
use Livewire\Attributes\Layout;
use Livewire\Component;

class ListaController extends Component
{

    public $edit;
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

    public function AbrirModalDeListaEspecie($id){
        $datos=[
            'jardin'=>$this->url->urlj_cjarsiglas,
            'lstId'=>$id,
        ];

        $this->dispatch('AbrirModalDeListaDeEspecies',$datos);
    }

    public function ActivarInactivar($id){
        $registro=lista::find($id);
        if($registro->lst_act == '1'){$registro->lst_act='0';}else{$registro->lst_act='1';}
        $registro->save();
    }

    public function Eliminar($id){
        lista::where('lst_id',$id)->update(['lst_del'=>'1']);
    }

    public function Renumerar(){

    }

    public function render(){
        ###### Determina permisos
        $this->edit='0';
        if(session('rol')){
            if(array_intersect(['admin'], session('rol')) ){
                $this->edit='1';
            }
        }

        ##### Genera lista de especies
        $lista=lista::query();
        if($this->edit != '1'){$lista->where('lst_act','1');}

        $lista=$lista->where('lst_cjarsiglas',$this->url->urlj_cjarsiglas)
            ->where('lst_del','0')
            ->orderBy('lst_orden','asc')
            ->get();

        $Num=lista::where('lst_cjarsiglas', $this->url->urlj_cjarsiglas)->where('lst_del','0')->count();
        $Max=lista::where('lst_cjarsiglas', $this->url->urlj_cjarsiglas)->where('lst_del','0')->max('lst_orden');
        return view('livewire.web.lista-controller',[
            'lista'=>$lista,
            'Num'=>$Num,
            'Max'=>$Max,

        ]);
    }


}
