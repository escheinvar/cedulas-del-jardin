<?php

namespace App\Livewire\Sistema;

use App\Models\cat_autores;
use App\Models\CatJardinesModel;
use App\Models\CatRolesModel;
use App\Models\jardin_txt;
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

class AdminWebComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $edit,$editjar; ##### Variables de permisos del usuario
    public $jardinSel, $sentido, $orden, $edoEdit; ##### Vars de formulario de búsqueda y de tabla
    public $abiertos; ##### vars de info. al usuario
    public $tipo, $jardinId; ##### Variables de modal
    ##### Variables de formulario de modal
    public $NvoBanner, $origtrad, $copiade, $lengua, $url, $act, $titulo, $descrip, $bannerimg, $bannertitle;

    public function mount(){
        $this->jardinSel='JebOax';
        $this->orden='_id';
        $this->sentido='asc';
        $this->origtrad='original';
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
    #####################  Iniciamos funciones de modal
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
                if($dato->urlj_tradid=='0'){$this->origtrad='original';}else{$this->origtrad='traducción';}
                if($dato->urlj_tradid > '0'){$this->copiade=$dato->urlj_tradid;}
                $this->lengua=$dato->urlj_lencode;
                $this->titulo=$dato->urlj_titulo;
                $this->descrip=$dato->urlj_descrip;
                $this->bannerimg=$dato->urlj_bannerimg;
                $this->bannertitle=$dato->urlj_bannertitle;
            }else{
                $this->LimpiaModal();
            }

            #### Abre modal
            $this->dispatch('AbreModalUrlJardin');
        }
    }

    public function DeterminaVariablesDeCopia(){
        if($this->origtrad=='traducción' and $this->copiade != ''){
            $original=jardin_url::where('urlj_id',$this->copiade)->first();
            $this->url=$original->urlj_url.'_'.$this->lengua;
            $this->bannertitle= $original->urlj_bannertitle;
            $this->titulo = $original->urlj_titulo;
            $this->descrip = $original->urlj_descrip;
            $this->bannerimg= $original->urlj_bannerimg;
        }
        if($this->origtrad=="original"){$this->copiade ='';}
    }

    public function LimpiaModal(){
        $this->reset('NvoBanner', 'origtrad', 'copiade', 'lengua', 'url', 'titulo', 'descrip', 'bannerimg', 'bannertitle');
        $this->act=FALSE;
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
            'origtrad'=>'required',
            'lengua'=>'required',
            'url'=> 'required',
            'bannertitle'=>'required',
        ]);

        ##### Valida que haya copia
        if($this->origtrad =='traducción' and $this->jardinId == '0'){
            $this->validate(['copiade'=>'required']);

            $urltxt=jardin_url::where('urlj_id',$this->copiade)->value('urlj_urltxt');
            $ja=jardin_url::where('urlj_cjarsiglas',$this->jardinSel)
                ->where('urlj_urltxt',$urltxt)
                ->where('urlj_lencode',$this->lengua)
                ->count();
            if($ja > '0'){$this->addError('lengua','Ya existe una copia en esta lengua');return;}
        }

        #### Valida que no se use nombres prohibidos
        $tabu=['inicio','autores','cedulas'];
        if($this->jardinId=='0' and in_array($this->url, $tabu)) {
            $this->addError('url','inicio un nombre reservado y no se puede usar');
            return;
            $this->url='';
        }

        ##### Valida que url no tenga espacios ni ñ ni caracteres
        if(preg_match('/\W/',$this->url)){
            $this->addError('url','Url no puede tener acentos, eñe, espacios ni caracteres');
            return;
        }

        ##### Valida que no exista ya el nombre en el jardín
        $ja=jardin_url::where('urlj_cjarsiglas',$this->jardinSel)
            ->where('urlj_url',$this->url)
            ->where('urlj_id','!=',$this->jardinId)
            ->count();
        if($ja > '0'){$this->addError('url','Esta url ya existe en tu jardín');return;}

        ##### transforma checkboxes y variables
        if($this->act==TRUE){$act='1';}else{$act='0';}
        if($this->origtrad=='original'){$trad=0;}else{$trad=$this->copiade;}
        if($this->origtrad=='original'){$urltxt=$this->url;}else{$urltxt=jardin_url::where('urlj_id',$this->copiade)->value('urlj_url');  $this->copiade;}
        ##### Genera datos
        $datos=[
            'urlj_cjarsiglas'=>$this->jardinSel,
            'urlj_url'=>$this->url,
            'urlj_urltxt'=>$urltxt,
            'urlj_tradid'=>$trad,
            'urlj_lencode'=>$this->lengua,
            'urlj_act'=>$act,
            'urlj_titulo'=>$this->titulo,
            'urlj_descrip'=>$this->descrip,
            // 'urlj_bannerimg'=>$this->,
            'urlj_bannertitle'=>$this->bannertitle,
        ];
        ##### en caso de copias, copia el banner
        if($this->origtrad=='traducción'){
            $datos['urlj_bannerimg']=$this->bannerimg;
        }

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

        ##### en caso de copias, copia el contenido de la página
        if($this->origtrad=='traducción'){
            $original=jardin_txt::where('jar_urljid',$this->copiade)
                ->where('jar_act','1')->where('jar_del','0')
                ->get();
            foreach($original as $or){
                $copia= $or->replicate();
                $copia->jar_urljid = $id;
                $copia->jar_txtoriginal = $or->jar_txt;
                $copia->save();
            }
        }


        $this->CierraModal();
    }

    public function BorrarImagenModal($id){
        jardin_url::where('urlj_id',$id)->update(['urlj_bannerimg'=>null,]);
        #### Crea log
        paLog('Se elimina imagen principal a página web ('.$this->url.') de '.$this->jardinSel,'jardin_url',$id);
        $this->bannerimg=''; $this->NvoBanner='';
    }

    public function EliminarSitioWeb(){
        ##### lee datos
        $dato=jardin_url::where('urlj_id',$this->jardinId)->first();

        jardin_url::where('urlj_id',$this->jardinId)->update([
            'urlj_del'=>'1',
            'urlj_url'=>$dato->urlj_url.'Eliminado'.date('Y-m-d'),
        ]);

        ##### Genera log
        paLog('Se elimina la página '.$this->url, 'jardin_url',$this->jardinId);

        $this->dispatch('AvisoExitoAdminWeb',msj:'La página fue eliminada correctamente');
        $this->CierraModal();
    }
    ###################################################
    ####################  Terminamos funciones de modal

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

        ##### Obtiene cantidad de urls en edición:
        $this->abiertos=jardin_url::whereIn('urlj_cjarsiglas',$JardsUsr->pluck('cjar_siglas')->toArray())
            ->where('urlj_edit','1')
            ->where('urlj_act','1')->where('urlj_del','0')
            ->count();


        ##### Obtiene lista de url's accesibles por usuario
        if($this->jardinSel != ''){
            $urls=jardin_url::query();
            $urls=$urls->where('urlj_cjarsiglas','ilike',$this->jardinSel);
            $urls=$urls->orderBy('urlj_cjarsiglas','asc')
                ->orderBy('urlj_urltxt','asc')
                ->orderBy('urlj_tradid','asc')
                ->where('urlj_del','0')
                ->with('jardin')
                ->with('lenguas')
                ->get();
        }else{
            $urls=collect();
        }

        ##### Obtiene total de url's originales
        $originales= jardin_url::where('urlj_cjarsiglas','ilike',$this->jardinSel)
            ->where('urlj_tradid', '0')
            ->where('urlj_del','0')
            ->orderBy('urlj_tradid','asc')
            ->orderBy('urlj_id','asc')
            ->get();

        ##### Obtiene lista de autores
        $auts=cat_autores::query();
        $auts=$auts->get();

        return view('livewire.sistema.admin-web-component',[
            'JardsDelUsr'=>$JardsUsr,
            'lenguas'=>lenguas::get(),
            'originales'=>$originales,
            'urls'=>$urls,
            'auts'=>$auts,
        ]);
    }
}






