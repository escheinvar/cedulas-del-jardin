<?php

namespace App\Livewire\Sistema;

use App\Models\cat_tipocedula;
use App\Models\CatJardinesModel;
use App\Models\cedulas_txt;
use App\Models\cedulas_url;
use App\Models\lenguas;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminCedulasComponent extends Component
{
    public $edit, $editjar; ##### Variables de permisos del usuario
    public $jardinSel, $sentido, $orden, $edoEdit, $abiertos; ##### Vars de formulario de búsqueda y de tabla
    ### vars. del modal:
    public $cedulaId, $origtrad, $copiade, $tipoCedula, $lengua;
    public $url, $titulo, $tituloOrig, $resumen, $resumenOrig, $act;




    public function mount(){
        $this->jardinSel='JebOax';
        $this->orden='_id';
        $this->sentido='asc';
        $this->origtrad='original';
        // $this->CedsOriginales=collect();
    }

    public function render(){
        ##### Revisa permisos del usuario
        $auts=['editor','admin']; ##### array de roles autorizados a editar
        if(array_intersect($auts,session('rol'))){
            $this->edit='1';

        }else{
            $this->edit='0';
            redirect('/noauth/Solo accede rol '.implode(',',$auts));
        }

        ##### jardines autorizados al usuario (puede incluir "todos")
        $this->editjar = UserRolesModel::where('rol_usrid',Auth::user()->id)
            ->whereIn('rol_crolrol',$auts)
            ->where('rol_act','1')->where('rol_del','0')
            ->distinct('rol_cjarsiglas')
            ->pluck('rol_cjarsiglas')->toArray();

        #### Genera lista de jardines autorizados al usuario (sin palabra "todos")
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

        ##### Obtiene cantidad de cedulas en edición:
        $this->abiertos=cedulas_url::whereIn('url_cjarsiglas', $JardsUsr->pluck('cjar_siglas')->toArray())
            ->where('url_edo','<','5')   ####0:crea, 1:edicion 2:revision, 3:autoriza, 4:publicado 5:publicadoCnSolEdit.
            ->where('url_act','1')->where('url_del','0')
            ->count();

        ##### Obtiene lista de url's accesibles por usuario
        if($this->jardinSel != ''){
            $urls=cedulas_url::query();
            $urls=$urls->where('url_cjarsiglas','ilike',$this->jardinSel);
            $urls=$urls->orderBy('url_cjarsiglas','asc')
                ->orderBy('url_urltxt','asc')
                ->orderBy('url_tradid','asc')
                ->where('url_del','0')
                ->with('jardin')
                ->with('lenguas')
                ->get();
        }else{
            $urls=collect();
        }

        ##### Obtiene total de url's originales
        $CedsOriginales= cedulas_url::where('url_cjarsiglas','ilike',$this->jardinSel)
            ->where('url_tradid', '0')
            ->where('url_del','0')
            ->orderBy('url_tradid','asc')
            ->orderBy('url_id','asc')
            ->get();

        return view('livewire.sistema.admin-cedulas-component',[
            'JardsDelUsr'=>$JardsUsr,  ##### Lista de siglas de jardines autorizados
            'lenguas'=>lenguas::get(),  ##### Lista de lenguas del catálogo
            'CedsOriginales'=>$CedsOriginales, ##### Lista de cédulas originales (para copiar)
            'TiposDeCedula'=>cat_tipocedula::get(),
            'urls'=>$urls,   ##### Tabla de urls para ver en tabla
            ]);
    }

    ####################################################################
    ####################################### Funciones de Modal de Cédula
    ####################################################################
    public function AbreModalCedula($id,$jardin){ #($tipo,$var){
        $this->LimpiaModal();
        $this->jardinSel=$jardin;

        if($this->edit=='1'){
            ##### Carga variables del usuario
            // $this->tipo=$tipo;
            $this->cedulaId=$id;
            if($id > '0'){
                ##### Lee el campo
                $dato=cedulas_url::where('url_id',$id)->first();
                ##### Carga datos
                $this->url=$dato->url_url;
                if($dato->url_act=='1'){$this->act=TRUE;}else{$this->act=FALSE;}
                if($dato->url_tradid=='0'){$this->origtrad='original';}else{$this->origtrad='traducción';}
                if($dato->url_tradid > '0'){$this->copiade=$dato->url_tradid;}
                $this->tipoCedula=$dato->url_ccedtipo;
                $this->lengua=$dato->url_lencode;
                $this->titulo=$dato->url_titulo;
                $this->tituloOrig=$dato->url_tituloOrig;
                $this->resumen=$dato->url_resumen;
                $this->resumenOrig=$dato->url_resumenOrig;

            }else{
                $this->LimpiaModal();
            }

            #### Abre modal
            $this->dispatch('AbreModalDeCedula');
        }
    }

    public function LimpiaModal(){
        // $this->reset('NvoBanner', 'origtrad', 'copiade', 'lengua', 'url', 'titulo', 'descrip', 'bannerimg', 'bannertitle');
        // $this->act=FALSE;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function CierraModalCedula(){
        $this->LimpiaModal();
        $this->dispatch('CierraModalDeCedula');
    }

    public function DeterminaVariablesDeCopia(){
        if($this->origtrad=='traducción' and $this->copiade != ''){

            $original=cedulas_url::where('url_id',$this->copiade)->first();
            $this->tipoCedula=$original->url_ccedtipo;
            $this->url=$original->url_url.'_'.$this->lengua;
            $this->titulo = $original->url_titulo;
            $this->tituloOrig = $original->url_tituloorig;
            $this->resumen = $original->url_resumen;
            $this->resumenOrig = $original->url_resumenorig;
        }
        if($this->origtrad=="original"){$this->copiade ='';}
    }

    public function GuardaCedula(){
        #### Valida cuestionario
        $this->validate([
            'origtrad'=>'required',
            'tipoCedula'=>'required',
            'lengua'=>'required',
            'url'=> 'required',
            'titulo'=>'required',

        ]);

        ##### Valida que haya copia
        // if($this->origtrad =='traducción' and $this->cedulaId == '0'){
        if($this->origtrad =='traducción' and $this->cedulaId == '0'){
            $this->validate(['copiade'=>'required']);

            $urltxt=cedulas_url::where('url_id',$this->copiade)->value('url_urltxt');
            $ja=cedulas_url::where('url_cjarsiglas',$this->jardinSel)
                ->where('url_urltxt',$urltxt)
                ->where('url_lencode',$this->lengua)
                ->count();
            if($ja > '0'){$this->addError('lengua','Ya existe una copia en esta lengua');return;}
        }

        #### Valida que no se use nombres reservados o prohibidos
        $tabu=['']; #$tabu=['inicio','autores','cedulas'];
        if($this->cedulaId=='0' and in_array($this->url, $tabu)) {
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
        $ja=cedulas_url::where('url_cjarsiglas',$this->jardinSel)
            ->where('url_url',$this->url)
            ->where('url_id','!=',$this->cedulaId)
            ->count();
        if($ja > '0'){$this->addError('url','Esta url ya existe en tu jardín');return;}

        // ##### transforma checkboxes y variables
        if($this->act==TRUE){$act='1';}else{$act='0';}
        if($this->origtrad=='original'){
            $trad=0;
            $urltxt=$this->url;
            $titOrig=$this->titulo;
            $resOrig=$this->resumen;
        }else{
            $trad=$this->copiade;
            $urltxt=cedulas_url::where('url_id',$this->copiade)->value('url_url');
            $titOrig=cedulas_url::where('url_id',$this->copiade)->value('url_titulo');
            $resOrig=cedulas_url::where('url_id',$this->copiade)->value('url_resumen');
        }

        // ##### Genera datos
        $datos=[
            'url_act'=>$act,
            'url_ccedtipo'=>$this->tipoCedula,
            'url_cjarsiglas'=>$this->jardinSel,  ### jardin
            'url_urltxt'=>$urltxt,               ### url original
            'url_url'=>$this->url,               ### url ó url_len
            'url_lencode'=>$this->lengua,        #### lengua
            'url_tradid'=>$trad,                 ### id del original (en copia) o 0
            'url_titulo'=>$this->titulo,
            'url_tituloorig'=>$titOrig,
            'url_resumen'=>$this->resumen,
            'url_resumenorig'=>$resOrig,
        ];


        ##### Guarda en Base de datos
        if($this->cedulaId=='0'){
            $ja=cedulas_url::create($datos);
            $id=$ja->urlj_id;
            #### Crea log
            paLog('Genera nueva cédula web ('.$this->url.') de '.$this->jardinSel,'cedulas_url',$id);
        }else{
            cedulas_url::where('url_id',$this->cedulaId)->update($datos);
            $id=$this->cedulaId;
            #### Crea log
            paLog('Edita los datos generales de la cédula ('.$this->url.') de '.$this->jardinSel,'jardin_url',$id);
        }
         ##### en caso de copias, copia el contenido de la página
        // if($this->origtrad=='traducción'){
        //     $original=cedulas_txt::where('ced_urlid',$this->copiade)
        //         ->where('ced_act','1')->where('ced_del','0')
        //         ->get();
        //     foreach($original as $or){
        //         $copia= $or->replicate();
        //         $copia->ced_urljid = $id;
        //         $copia->ced_txtoriginal = $or->ced_txt;
        //         $copia->save();
        //     }
        // }
        $this->CierraModalCedula();
    }

    ####################################################################
    ################################# Funciones de Modal de Buscar Autor
    ####################################################################
    public function AbreModalDeBuscarAutor(){
        $this->dispatch('AbreModalDeBuscarAutor');
    }

    public function CierraModalDeBuscarAutor(){
        $this->dispatch('CierraModalDeBuscarAutor');
    }
}
