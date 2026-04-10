<?php

namespace App\Livewire\Web;

use App\Models\autor_url;
use App\Models\cat_autores;
use App\Models\ced_autores;
use App\Models\cedulas_url;
use App\Models\jardin_txt;
use App\Models\jardin_url;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Mpdf\Tag\I;

class JardinController extends Component
{
    ###### controlador  que maneja las peticiones de /en/jardin/url
    ###### (ojo: las peticiones /jardin/JebOax van al controlador JardinController2)

    public $edit, $editjar; ##### Vars de autorización de edición
    ####### Vars de página:
    public $url; ##### Carga la info de jar_url de página activa
    public $traduccion;  #### jar_url de traducciones de la misma página

    #[Layout('plantillas.baseJardin')]
    public function mount($jardin,$pag=null){
        ##### Recibe parámetros por url y los procesa
        if($pag==null){
            ##### Valida url $jardin y $url y carga $this->url
            $this->url=jardin_url::whereRaw('LOWER(urlj_cjarsiglas) = ?', strtolower($jardin))
                ->where('urlj_url','inicio')
                ->where('urlj_act','1')->where('urlj_del','0')
                ->with('jardin')
                ->with('lenguas')
                ->first();

        }else{
            $this->url=jardin_url::whereRaw('LOWER(urlj_cjarsiglas) = ?', strtolower($jardin))
                ->where('urlj_url',$pag)
                ->where('urlj_act','1')->where('urlj_del','0')
                ->with('jardin')
                ->first();

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

        ##### define variables
        $this->traduccion='';
    }

    public function CambiaAunaTraduccion(){
        if($this->traduccion != ''){
            $dato=jardin_url::where('urlj_id',$this->traduccion)->first();

            // dd($dato,'/jardin/'.$dato->urlj_cjarsiglas.'/'.$dato->urlj_url);

            redirect('/jardin/'.$dato->urlj_cjarsiglas.'/'.$dato->urlj_url);
        }
    }

    // public function AbreModalEditaTextoWebJardin($id, $orden){
    public function AbreModalEditaParrafo($id, $orden){
        if($this->edit=='1'){
            ###### Si es nuevo, calcula el orden
            if($id=='0'){
                $orden=jardin_txt::where('jar_urljid',$this->url->urlj_id)
                    ->where('jar_act','1')->where('jar_del','0')
                    ->max('jar_orden') + 1;
            }
            ##### Abre modal
            $data=[
                'id'=>$id,
                'orden'=>$orden,
                'modulo'=>$this->url->urlj_url,
                'url'=>$this->url->urlj_url,
                'jardin'=>$this->url->urlj_cjarsiglas,
                'reload'=>'0',
            ];
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
            }
            // if(!array_intersect($auts,session('rol') )) {redirect('/noauth/Solo accede rol '.implode(',',$auts).' con acceso a todos');}
        }

        ##### Carga texto
        $txt=jardin_txt::where('jar_cjarsiglas',$this->url->urlj_cjarsiglas)     #where('jar_urljid',$this->url->urlj_id)
            ->where('jar_urljurl',$this->url->urlj_url)
            ->where('jar_act','1')->where('jar_del','0')
            ->orderBy('jar_orden')
            ->get();

        ##### Carga traducciones
        $traducciones=jardin_url::where('urlj_cjarsiglas', $this->url->urlj_cjarsiglas)
            ->where('urlj_urltxt',$this->url->urlj_urltxt)
            ->where('urlj_url','!=',$this->url->urlj_url)
            ->where('urlj_act','1')->where('urlj_del','0')
            ->with('lenguas')
            ->orderBy('urlj_lencode')
            ->get();

        ############## Carga cédulas (pag. cédulas)
        $cedulas=cedulas_url::where('url_cjarsiglas',$this->url->urlj_cjarsiglas)
            ->where('url_del','0')
            ->with('lenguas')
            ->orderBy('url_url')
            ->get();

        ############## Carga lista de autores únicos del jardín (recordar que se puede repetir un autor)
        $IdDeAutores=ced_autores::where('aut_cjarsiglas',$this->url->urlj_cjarsiglas)
            ->where('aut_act','1')
            ->where('aut_del','0')
            ->distinct('aut_cautid')
            ->pluck('aut_cautid')
            ->toArray();

        ###### Obtiene lista de autores
        $autores=cat_autores::whereIn('caut_id',$IdDeAutores)
        ->orderBy('caut_nombre','asc')
        ->orderBy('caut_apellido1','asc')
        ->with('cedulas')
        ->with('urlautor')
            ->get();
// dd($autores);

        return view('livewire.web.jardin-controller',[
            'txt'=>$txt,
            'traducciones'=>$traducciones,
            'cedulas'=>$cedulas,
            'autores'=>$autores,
        ]);
    }
}
