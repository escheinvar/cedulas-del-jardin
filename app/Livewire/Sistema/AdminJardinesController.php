<?php

namespace App\Livewire\Sistema;

use App\Models\CatCampusModel;
use App\Models\CatEntidadesInegiModel;
use App\Models\CatJardinesModel;
use App\Models\jardin_url;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;


class AdminJardinesController extends Component
{

    use WithFileUploads;

    public $edit, $editjar; ### Variables de autorización
    ##### Variables de Modal
    public $IdJardin, $jar_name, $jar_nombre, $jar_siglas, $jar_tipo;
    public $jar_direccion, $jar_edo, $jar_tel, $jar_mail, $jar_logo;
    public $jar_logoNuevo, $jar_red_face, $jar_red_insta, $jar_red_youtube, $jar_red_www;
    public $jar_red_ubica, $jar_red_red1, $jar_red_red2;


    public function mount(){
        $this->IdJardin='0';
        $this->jar_logoNuevo='';
    }

    public function BorraLogo($archivo){
        ##### La borra en la base
        CatJardinesModel::where('cjar_id',$this->IdJardin)->update(['cjar_logo'=>null,]);
        ##### La borra en la carpeta
        Storage::delete("/public/avatar/jardines/".$archivo);
        $this->jar_logo='';
        ##### crea log
        paLog('Borra logo de jardín','CatJardinesModel',$this->IdJardin);
        // redirect('/admin_jardines');
    }

    public function AbreModalJardin($idJar){
        if($this->edit=='1'){
            $this->IdJardin=$idJar;
            if($idJar > '0'){
                $datoJardin=CatJardinesModel::where('cjar_id',$idJar)->first();
                $this->jar_name = $datoJardin->cjar_name;
                $this->jar_nombre = $datoJardin->cjar_nombre;
                $this->jar_siglas = $datoJardin->cjar_siglas;
                $this->jar_tipo = $datoJardin->cjar_tipo;
                $this->jar_direccion = $datoJardin->cjar_direccion;
                $this->jar_edo = $datoJardin->cjar_edo;
                $this->jar_tel = $datoJardin->cjar_tel;
                $this->jar_mail = $datoJardin->cjar_mail;
                $this->jar_logo = $datoJardin->cjar_logo;
                $this->jar_red_face = $datoJardin->cjar_face;
                $this->jar_red_insta = $datoJardin->cjar_insta;
                $this->jar_red_youtube = $datoJardin->cjar_youtube;
                $this->jar_red_www = $datoJardin->cjar_www;
                $this->jar_red_ubica = $datoJardin->cjar_ubica;
                // $this->jar_red_red1 = $datoJardin->cjar_red1;
                // $this->jar_red_red2 = $datoJardin->cjar_red2;
            }else{
                $this->jar_name = '';
                $this->jar_nombre = '';
                $this->jar_siglas = '';
                $this->jar_tipo = '';
                $this->jar_direccion = '';
                $this->jar_tel = '';
                $this->jar_mail = '';
                $this->jar_logo = '';

            }
            $this->dispatch('AbreModalJardin');
        }
    }

    public function CierraModalJardin(){
        $this->resetValidation();
        $this->resetErrorBag();
        $this->reset('jar_name', 'jar_nombre', 'jar_siglas', 'jar_tipo',
            'jar_direccion', 'jar_edo', 'jar_tel', 'jar_mail', 'jar_logo',
            'jar_logoNuevo', 'jar_red_face', 'jar_red_insta', 'jar_red_youtube', 'jar_red_www',
            'jar_red_ubica', 'jar_red_red1', 'jar_red_red2');

        $this->dispatch('CierraModalJardin');
    }

    public function GuardaModal(){
        ##### Valida cuestionario
        $this->validate([
            'jar_siglas'=>'required|unique:cat_jardines,cjar_siglas,'.$this->IdJardin.',cjar_id',
            'jar_name'=>'required',
            'jar_nombre'=>'required',
            'jar_edo'=>'required',
        ]);

        ##### Procesa imágen (nombre y guarda)
        if($this->jar_logoNuevo != ''){
            $LogoNombre=$this->jar_siglas.".".$this->jar_logoNuevo->getClientOriginalExtension();
            $this->jar_logoNuevo->storeAs('/public/avatar/jardines/', $LogoNombre);
            $this->jar_logo='/avatar/jardines/'.$LogoNombre;
            $LogoNombre='/avatar/jardines/'.$LogoNombre;
        }else{
            $LogoNombre= $this->jar_logo;
        }

        ##### Genera array de nuevos datos
        $datos=['cjar_name'=>$this->jar_name,
            'cjar_nombre'=>$this->jar_nombre,
            'cjar_siglas'=>$this->jar_siglas,
            'cjar_tipo'=>$this->jar_tipo,
            'cjar_direccion'=>$this->jar_direccion,
            'cjar_tel'=>$this->jar_tel,
            'cjar_mail'=>$this->jar_mail,
            'cjar_edo'=>$this->jar_edo,
            'cjar_logo'=>$LogoNombre,
            'cjar_face'=>$this->jar_red_face,
            'cjar_insta'=>$this->jar_red_insta,
            'cjar_youtube'=>$this->jar_red_youtube,
            'cjar_www'=>$this->jar_red_www,
            // 'cjar_red1'=>$this->jar_red_red1,
            // 'cjar_red2'=>$this->jar_red_red2,
            'cjar_ubica'=>$this->jar_red_ubica,
            ];

        ##### Guarda en la base de datos
        if($this->IdJardin=='0'){
            $datos['cjar_id']= CatJardinesModel::max('cjar_id') + 1;
            CatJardinesModel::create($datos);
            ##### Genera log
            paLog('Crea nuevo jardín '.$this->jar_name,'CatJardinesModel',$datos['cjar_id']);

            ##### Genera página url inicio del jardín
            foreach(['inicio','autores','cedulas'] as $pag){
                $ja=jardin_url::create([
                'urlj_cjarsiglas'  =>$this->jar_siglas,
                'urlj_urltxt'=>$pag,
                'urlj_url'=>$pag,
                'urlj_act'=>'0',
                'urlj_titulo'=>$this->jar_nombre,
                'urlj_descrip'=>'Página de .'.$pag.' del '.$this->jar_nombre.' en el Sistema de Cédulas del Jardín en lenguas originarias',
                'urlj_bannertitle'=>$this->jar_nombre,
                ]);

                ##### Genera log
                paLog('Crea nueva url '.$pag.' de'.$this->jar_siglas,'jardin_url',$ja->urlj_id);
            }


        }else{
            CatJardinesModel::where('cjar_id',$this->IdJardin)->update($datos);
            #### genera log
            paLog('Edita datos de jardín '.$this->jar_name,'CatJardinesModel',$this->IdJardin);
        }
        redirect('/admin_jardines');
    }

    public function render(){
        ##### Revisa permisos del usuario
        $auts=['admin'];
        $this->editjar = UserRolesModel::where('rol_usrid',Auth::user()->id)
            ->whereIn('rol_crolrol',$auts)
            ->where('rol_act','1')->where('rol_del','0')
            ->pluck('rol_cjarsiglas')->toArray();
        if(array_intersect($auts,session('rol')) and in_array('todos',$this->editjar) ){
            $this->edit='1';
        }else{
            $this->edit='0';
        }
        if(!array_intersect($auts,session('rol') )) {redirect('/noauth/Solo accede rol '.implode(',',$auts).' con acceso a todos');}



        return view('livewire.sistema.admin-jardines-Controller',[
            'jardines'=>CatJardinesModel::orderBy('cjar_id','asc')->get(),
            'Entidades'=>CatEntidadesInegiModel::all(),
        ]);
    }
}
