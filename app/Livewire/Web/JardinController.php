<?php

namespace App\Livewire\Web;

use App\Models\jardin_txt;
use App\Models\jardin_url;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

class JardinController extends Component
{
    ###### controlador  que maneja las peticiones de /en/jardin/url
    ###### (ojo: las peticiones /jardin/JebOax van al controlador JardinController2)

    public $url; ##### Variables que recibe por la url
    public $edit, $editjar; ##### Vars de autorización de edición
    public $enEdit; #### Indica el id que está siendo editado

    #[Layout('plantillas.baseJardin')]
    public function mount($jardin,$pag=null){
        if($pag==null){
            ##### Valida url $jardin y $url
            $this->url=jardin_url::whereRaw('LOWER(urlj_cjarsiglas) = ?', strtolower($jardin))
                ->where('urlj_url','inicio')
                ->where('urlj_act','1')->where('urlj_del','0')
                ->with('jardin')
                ->first();
            // dd('a',$jardin,$pag,$this->url);
        }else{
            $this->url=jardin_url::whereRaw('LOWER(urlj_cjarsiglas) = ?', strtolower($jardin))
                ->where('urlj_url',$pag)
                ->where('urlj_act','1')->where('urlj_del','0')
                ->with('jardin')
                ->first();
            // dd('b',$jardin,$pag,$this->url);
        }


        if($this->url == null){
            redirect('/error La url que ingresaste es incorrecta');
            return;
        }
        ##### Si no hay banner, pone uno default
        $default='/imagenes/banners/fondo-directorio.jpg';
        if($this->url->urlj_bannerimg==''){
            $this->url->urlj_bannerimg=$default;
        }
        $this->enEdit='';
    }

    public function IniciaEdicion($id){
        $this->enEdit=$id;
        $this->dispatch('ventana');
    }

    public function AbreModalEditaTextoWebJardin($id, $orden){
        if($this->edit=='1'){
            $data=['id'=>$id, 'orden'=>$orden];
            $this->dispatch('AbreModalDeParrafoWebJardin',$data);
        }
    }

    public function render(){
        $this->edit='0';
        ##### Revisa permisos del usuario
        $auts=['webmaster'];
        if(Auth::user()){
            $this->editjar = UserRolesModel::where('rol_usrid',Auth::user()->id)
                ->whereIn('rol_crolrol',$auts)
                ->where('rol_act','1')->where('rol_del','0')
                ->pluck('rol_cjarsiglas')->toArray();

            if(array_intersect($auts,session('rol'))   and ### si tengo rol autorizdo y..
                array_intersect(['todos',$this->url->urlj_cjarsiglas],$this->editjar)  and ####...y tengo acceso al jardin o a todos y...
                $this->url->urlj_edit=='1' ){  ####...y la url está en modo edición
                $this->edit='1';
            }else{
                $this->edit='0';
                // redirect('/noauth/Solo accede rol '.implode(',',$auts).' con acceso a todos');
            }
            if(!array_intersect($auts,session('rol') )) {redirect('/noauth/Solo accede rol '.implode(',',$auts).' con acceso a todos');}
        }

        ##### Carga texto
        $txt=jardin_txt::where('jar_urljid',$this->url->urlj_id)
            ->where('jar_act','1')->where('jar_del','0')
            ->orderBy('jar_orden')
            ->get();
        return view('livewire.web.jardin-controller',[
            'txt'=>$txt,
        ]);
    }
}
