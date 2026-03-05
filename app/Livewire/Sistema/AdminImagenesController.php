<?php

namespace App\Livewire\Sistema;

use App\Models\cat_img;
use App\Models\CatJardinesModel;
use App\Models\Imagenes;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminImagenesController extends Component
{
    public $edit, $editjar; #### Variables de edición
    public $ModoTabla, $orden, $sent, $BuscaJardin, $BuscaTxt, $BuscaTipo, $BuscaMod, $BuscaSubMod, $BuscaUrl; #### Variable de tabla

    ########################## inicia imágenes
    public function AbreModalObjeto($id){
        if($id=='0'){
            $data=[
                'ImgId'=>'0',    # 'Obligatorio: img_id de tabla imagenes ó 0 para nuevo',
                'SiglasJardin'=>$this->BuscaJardin, #Obligatorio: siglas del jardín al que pertenece',
                'ModuloCatImg'=>$this->BuscaMod, #Obligatorio: cimg_modulo de tabla cat_imgs',
                'TipoCatImg'=>$this->BuscaSubMod, #  'Obligatorio: cimg_tipo de tabla cat_imgs'
                'Url'=>$this->BuscaUrl,        # 'url a la que pertenece o vacío',
                'Lengua'=>'',     # 'len_code de tabla lenguas o vacío',
                'Reload'=>'1',
            ];
        }else {
            $ganon=Imagenes::where('img_id',$id)->first();
            $data=[
                'ImgId'=>$id,    # 'Obligatorio: img_id de tabla imagenes ó 0 para nuevo',
                'SiglasJardin'=>$ganon->img_cjarsiglas,
                'ModuloCatImg'=>$ganon->img_cimgmodulo,
                'TipoCatImg'=>$ganon->img_cimgtipo,
                'Url'=>$ganon->img_urlurl,
                'Lengua'=>$ganon->img_lencode,
                'Reload'=>'1',
            ];

        }

        $this->dispatch('abreModalDeImagen', $data);
    } ########################## termina imágenes

    public function mount($tipo){
        ### imagenes=Tabla; imagen=Imgs
        if($tipo=='nes'){$this->ModoTabla='1';}else{$this->ModoTabla='0';}
        $this->orden='img_id';
        $this->sent='asc';
        $this->BuscaJardin='';
        $this->BuscaTxt='';
        $this->BuscaMod='';
    }

    public function CambiaModo(){
        if($this->ModoTabla=='1'){
            redirect('/admin_imagen');
        }else{
            redirect('/admin_imagenes');
        }
    }

    public function Orden($orden){
        $this->orden=$orden;
        if($this->sent=='asc'){$this->sent='desc';}else{$this->sent='asc';}
    }

    public function render(){
        #######################################################
        ########################### Revisa permisos del usuario
        $auts=['webmaster','editor'];
        if(array_intersect($auts,session('rol'))){
            $this->edit='1';
        }else{
            $this->edit='0';
            redirect('/noauth/Solo accede rol '.implode(',',$auts));
        }
        ##### jardines autorizados al usuario
        $this->editjar = UserRolesModel::where('rol_usrid',Auth::user()->id)
            ->whereIn('rol_crolrol',$auts)
            ->where('rol_act','1')->where('rol_del','0')
            ->pluck('rol_cjarsiglas')->toArray();

        ##### Carga tabla de jardines autorizados al usuario
        if(in_array('todos',$this->editjar)){
            $jardines=CatJardinesModel::select('cjar_siglas')->get();
        }else{
            $jardines=CatJardinesModel::whereIn('cjar_siglas',$this->editjar)
                ->select('cjar_siglas')
                ->get();
        }

        #######################################################
        ############################## Genera tabla de imágenes
        ##### Genera tabla de imágenes
        $imagenes=Imagenes::query();

        ##### Genera tabla de imágenes: busca en jardines
        if($this->BuscaJardin == ''){
            $imagenes=$imagenes->whereIn('img_cjarsiglas',$jardines);
        }else{
            $imagenes=$imagenes->where('img_cjarsiglas',$this->BuscaJardin);
        }

        ##### Genera tabla de imágenes: busca en txt
        if($this->BuscaTxt != ''){
            $imagenes->where(function($q){
                return $q
                ->where('img_titulo','ilike','%'.$this->BuscaTxt.'%')
                ->orWhere('img_pie','ilike','%'.$this->BuscaTxt.'%')
                ->orWhere('img_autor','ilike','%'.$this->BuscaTxt.'%');
            })
            ->orWhereHas('alias', function($r){
                return $r
                ->where('aimg_txt','ilike','%'.$this->BuscaTxt.'%');
            });
        }

        ##### Genera tabla de imágenes: busca por tipo
        if($this->BuscaTipo != ''){
            $imagenes->where('img_tipo',$this->BuscaTipo);
        }

        ##### Genera tabla de imágenes: busca por módulo
        if($this->BuscaMod != ''){
            $imagenes=$imagenes->where('img_cimgmodulo',$this->BuscaMod);
        }
        if($this->BuscaMod != 'cedula'){$this->BuscaUrl='';}

        ##### Genera tabla de imágenes: busca por sub-módulo
        if($this->BuscaSubMod != ''){
            $imagenes=$imagenes->where('img_cimgtipo',$this->BuscaSubMod);
        }

        ##### GBenera tabla de imágenes: busca por url
        if($this->BuscaMod=='cedula' AND $this->BuscaUrl != ''){
            $imagenes=$imagenes->where('img_urlurl',$this->BuscaUrl);
        }

        ##### Genera tabla de imágenes genera búsqueda
        $imagenes=$imagenes->where('img_del','0')
            ->with('alias')
            ->orderBy($this->orden,$this->sent)
            ->paginate(15);

        #######################################################
        ############################## Carga tablas para selects
        ##### Carga tabla de jardines
        if(in_array('todos',$this->editjar)){
            $jardines=CatJardinesModel::select('cjar_siglas')->get();
        }else{
            $jardines=CatJardinesModel::whereIn('cjar_siglas',$this->editjar)
                ->select('cjar_siglas')
                ->get();
        }

        ##### Carga tabla de módulos
        $modulos=cat_img::select('cimg_modulo')
            ->distinct('cimg_modulo')
            ->orderBy('cimg_modulo')
            ->get();

        ##### Carga tabla de submódulos
        if($this->BuscaMod != ''){
            $submodulos=cat_img::where('cimg_modulo',$this->BuscaMod)
                ->select('cimg_tipo')
                ->distinct('cimg_tipo')
                ->orderBy('cimg_tipo')
                ->get();
        }else{
            $submodulos=collect();
        }

        return view('livewire.sistema.admin-imagenes-controller',[
            'imagenes'=>$imagenes,
            'jardines'=>$jardines,
            'modulos'=>$modulos,
            'submodulos'=>$submodulos,
        ]);
    }
}
