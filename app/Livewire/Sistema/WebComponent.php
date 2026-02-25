<?php

namespace App\Livewire\Sistema;

use App\Models\cat_autores;
use App\Models\CatJardinesModel;
use App\Models\CatRolesModel;
use App\Models\jardin_url;
use App\Models\lenguas;
use App\Models\SpUrlModel;
use App\Models\User;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class WebComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $edit,$editjar; ##### Variables de permisos del usuario
    public $jardinSel, $sentido, $orden, $edoEdit; ##### Vars de formulario de búsqueda y de tabla
    public $tipo, $jardinId; ##### Variables de modal
    ##### Variables de formulario de modal
    public $NvoBanner, $url, $act, $titulo, $descrip, $bannerimg, $bannertitle;

    public function mount(){
        $this->jardinSel='JebOax';
        $this->orden='urlj_id';
        $this->sentido='asc';
    }

    public function ordenaTabla($ord){
        if($this->sentido=='asc'){
            $this->sentido='desc';
        }else{
            $this->sentido='asc';
        }
        $this->orden=$ord;
    }

    public function CambiaEstadoEdicion($id){
        $estado=jardin_url::where('urlj_id',$id)->value('urlj_edit');
        if($estado=='0'){$edo='1';}else{$edo='0';}
        jardin_url::where('urlj_id',$id)->update(['urlj_edit'=>$edo]);
    }

    ###################################################
    ###################  Iniciamos funciones de modal
    public function AbreModalWeb($tipo,$var){
        $this->LimpiaModal();
        if($this->edit=='1'){
            ##### Carga variables del usuario
            $this->tipo=$tipo;
            $this->jardinId=$var;
            if($var != '0'){
                ##### Lee el campo
                $dato=jardin_url::where('urlj_id',$var)->first();
                ##### Carga datos
                $this->url=$dato->urlj_url;
                if($dato->urlj_act=='1'){$this->act=TRUE;}else{$this->act=FALSE;}
                $this->titulo=$dato->urlj_titulo;
                $this->descrip=$dato->urlj_descrip;
                $this->bannerimg=$dato->urlj_bannerimg;
                $this->bannertitle=$dato->urlj_bannertitle;
            }else{
                $this->act=TRUE;
                $this->reset('url','act','titulo','descrip','bannerimg','bannertitle','NvoBanner');
            }

            #### Abre modal
            $this->dispatch('AbreModalUrlJardin');
        }
    }

    public function LimpiaModal(){
        $this->reset('url','act','titulo','descrip','bannerimg','bannertitle','NvoBanner');
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function CierraModal(){
        $this->LimpiaModal();
        $this->dispatch('CierraModalUrlJardin');
    }

    public function GuardaModal(){
        #### Valida cuestionario
        $this->validate([
            'url'=> 'required',
            'bannertitle'=>'required',
        ]);

        #### Valida que no se use index
        if($this->jardinId=='0' and $this->url=='inicio'){
            $this->addError('url','inicio un nombre reservado y no se puede usar');
            $this->url='';
        }
        ##### Valida que no exista ya el nombre en el jardín
        $ja=jardin_url::where('urlj_cjarsiglas',$this->jardinSel)
            ->where('urlj_url',$this->url)
            ->where('urlj_id','!=',$this->jardinId)
            ->count();
        if($ja > '0'){$this->addError('url','Esta url ya existe en tu jardín');return;}

        ##### transforma checkboxes
        if($this->act==TRUE){$act='1';}else{$act='0';}

        ##### Genera datos
        $datos=[
            'urlj_cjarsiglas'=>$this->jardinSel,
            'urlj_url'=>$this->url,
            'urlj_act'=>$act,
            'urlj_titulo'=>$this->titulo,
            'urlj_descrip'=>$this->descrip,
            // 'urlj_bannerimg'=>$this->,
            'urlj_bannertitle'=>$this->bannertitle,
        ];
        ##### Guarda en Base de datos
        if($this->jardinId=='0'){
            $ja=jardin_url::create($datos);
            $id=$ja->urlj_id;
            #### Crea log
            paLog('Genera nueva página web ('.$this->url.') de '.$this->jardinSel,'jardin_url',$id);
        }else{
            jardin_url::where('urlj_id',$this->jardinId)->update($datos);
            $id=$this->jardinId;
            #### Crea log
            paLog('Edita página web ('.$this->url.') de '.$this->jardinSel,'jardin_url',$id);
        }

        ##### Prepara imagen
        if($this->NvoBanner != ''){
            ###### Genera nombre de archvo
            $nombre='jar_'.str_pad($this->jardinId,3,"0",STR_PAD_LEFT).'_banner.'. $this->NvoBanner->getClientOriginalExtension();
            $ruta='/jardines/';
            ##### Guarda archivo
            $this->NvoBanner->storeAs(path:'/public/'.$ruta, name:$nombre);
            ##### Cambia BD
            jardin_url::where('urlj_id',$id)->update([
                'urlj_bannerimg'=>$ruta.$nombre
            ]);
            #### Crea log
            paLog('Se carga nueva imagen principal a página web ('.$this->url.') de '.$this->jardinSel,'jardin_url',$id);
        }


        $this->CierraModal();
    }

    public function BorrarImagenModal($id){
        jardin_url::where('urlj_id',$id)->update(['urlj_bannerimg'=>null,]);
        #### Crea log
        paLog('Se elimina imagen principal a página web ('.$this->url.') de '.$this->jardinSel,'jardin_url',$id);
        $this->bannerimg=''; $this->NvoBanner='';
    }

    public function render() {
        ##### Revisa permisos del usuario
        $auts=['webmaster'];
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


        #### Genera lista de jardines autorizados al usuario
        if(in_array('todos',$this->editjar)){
            $JardsUsr=CatJardinesModel::where('cjar_act','1')->where('cjar_del','0')
                ->orderBy('cjar_siglas')
                ->orderBy('cjar_name')
                ->get();
        }else{
            $JardsUsr=CatJardinesModel::where('cjar_act','1')->where('cjar_del','0')
                ->whereIn('cjar_siglas',$this->editjar)
                ->orderBy('cjar_siglas')
                ->orderBy('cjar_name')
                ->get();
        }

        ##### Obtiene lista de urs's
        if($this->jardinSel != ''){
            $urls=jardin_url::query();
            $urls=$urls->where('urlj_cjarsiglas',$this->jardinSel);
            $urls=$urls->orderBy($this->orden, $this->sentido);
            $urls=$urls->get();
        }else{
            $urls=collect();
        }

        ##### Obtiene lista de autores
        // $auts=cat_autores::query();
        // $auts=$auts->where('urlj_cjarsiglas',$this->jardinSel);
        // $auts=$auts->get();

        return view('livewire.sistema.web-component',[
            'JardsDelUsr'=>$JardsUsr,
            'lenguas'=>lenguas::get(),
            'urls'=>$urls,

        ]);
    }
}






