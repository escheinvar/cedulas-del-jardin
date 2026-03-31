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
    public $edit, $editMaster, $editjar; ##### Variables de permisos del usuario
    public $jardinSel, $BuscaLengua, $BuscaEstado, $BuscaTexto, $sentido, $orden, $edoEdit, $abiertos; ##### Vars de formulario de búsqueda y de tabla

    #################################################################################
    /*##### Tabla de cambios de estado:
    edo       Autor   Editor  Administrador
    0crea     1       4       1,5
    1edita    -       2,4     2,5
    2revisa   3       4       1,5
    3edita    -       2,4     2,5
    4autori   -       -       1,2,5
    5publicado6       6       6
    6PideEdit -       2       1,2,cancela
    */

    public function mount(){
        $this->jardinSel='JebOax';
    }

    public function ordenaTabla(){
        //
    }

    public function CambiaAmodoEdicion($id){
        $edo=cedulas_url::where('url_id',$id)->value('url_edit');
        if($edo=='0'){
            $nvo='1';
        }else{
            $nvo='0';
        }
        cedulas_url::where('url_id',$id)->update(['url_edit'=>$nvo]);

    }

    public function CambiaEstadoCedula($id,$edo){
        if($edo=='5'){
            dd('lógica de cierre de ciclo: ¿registro año?, ¿es nueva versión?',
            'en lugar de ir aquí, abrir modal de versión donde ve estadísticas y determina versión?');
        }

        ##### Calcula ciclo
        $previo=cedulas_url::where('url_id',$id)->value('url_ciclo');
        if($edo=='5'){
            $ciclo=$previo +1;
        }else{
            $ciclo=$previo;
        }

        ##### Calcula estado de edición
        if($edo <='4'){$editar='1';}else{$editar='0';}
        ##### Modifica base
        cedulas_url::where('url_id',$id)->update([
            'url_edit'=>$editar,
            'url_edo'=>$edo,
            'url_ciclo'=>$ciclo,
        ]);
        ##### Actualiza variable

        ### Crea log
        paLog('Se cambió el estado de la cédula a '.$edo,'cedulas_url',$id);
    }

    public function render(){
        ##### Revisa permisos del usuario
        $auts=['editor','admin','autor','traductor']; ##### array de roles autorizados a editar
        if(array_intersect($auts,session('rol'))){
            $this->edit='1';

        }else{
            $this->edit='0';
            redirect('/noauth/Solo accede rol '.implode(',',$auts));
        }

        ##### Distingue permisos superiores
        if(array_intersect(['editor','admin'], session('rol'))){
            $this->editMaster='1';
        }else{
            $this->editMaster='0';
        }

        ##### jardines autorizados al usuario (puede incluir palabra "todos")
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

        ############################# Inicia lista de Cédulas
        ##### Obtiene lista de Cédulas accesibles por usuario
        $urls=collect();
        if($this->jardinSel != ''){
            $urls=cedulas_url::query();
            $urls=$urls->where('url_cjarsiglas','ilike',$this->jardinSel);
        }

        ##### Obtiene lista de Cédulas por lengua (en caso de búsqueda por lengua)
        if($this->BuscaLengua != ''){
            $urls=$urls->where('url_lencode',$this->BuscaLengua);
        }

        ##### Obtiene lista de Cédulas por estado
        if($this->BuscaEstado != ''){
            $urls=$urls->where('url_edo',$this->BuscaEstado);
        }

        ##### Obtiene lista de Cédulas por texto
        if($this->BuscaTexto != ''){
            $urls=$urls->where(function($q){
                return $q
                ->where('url_url','ilike', '%'.$this->BuscaTexto.'%')
                ->orWhere('url_titulo','ilike', '%'.$this->BuscaTexto.'%')
                ->orWhere('url_resumen','ilike', '%'.$this->BuscaTexto.'%');
            });
        }

        ### Finaliza búsqueda de url
        $urls=$urls->orderBy('url_cjarsiglas','asc')
                ->orderBy('url_url','asc')
                ->where('url_del','0')
                ->with('jardin')
                ->with('lenguas')
                ->with('autores')
                ->with('editores')
                ->with('traductores')
                ->with('ubicaciones')
                ->with('alias');

        ##### En autor y traductor, restringe a cédulas autorizadas
        if( (array_intersect(['autor','traductor'],session('rol'))) and  (!array_intersect(['editor','admin'], session('rol'))) ){
            $urls=$urls->join('ced_autores','aut_urlid','=','url_id')
                ->join('cat_autores','aut_cautid','=','caut_id')
                ->where('aut_del','0')->where('aut_act','1')
                ->where('caut_del','0')->where('caut_act','1')
                ->where('caut_usrid',Auth::user()->id);
        }

        ##### Obtiene cantidad de cedulas en edición:
        if( array_intersect(['editor','admin'], session('rol'))  ){
            $this->abiertos=cedulas_url::whereIn('url_cjarsiglas', $JardsUsr->pluck('cjar_siglas')->toArray())
                ->where('url_act','1')->where('url_del','0')
                ->get();
        }elseif((array_intersect(['autor','traductor'],session('rol'))) ){
            $this->abiertos=cedulas_url::whereIn('url_cjarsiglas', $JardsUsr->pluck('cjar_siglas')->toArray())
                ->where('url_act','1')->where('url_del','0')
                ->join('ced_autores','aut_urlid','=','url_id')
                ->join('cat_autores','aut_cautid','=','caut_id')
                ->where('aut_del','0')->where('aut_act','1')
                ->where('caut_del','0')->where('caut_act','1')
                ->where('caut_usrid',Auth::user()->id)
                ->get();
        }

        return view('livewire.sistema.admin-cedulas-component',[
            'JardsDelUsr'=>$JardsUsr,  ##### Lista de siglas de jardines autorizados
            'lenguas'=>lenguas::orderBy('len_lengua')->get(),  ##### Lista de lenguas del catálogo
            'urls'=>$urls->get(),   ##### Tabla de urls para ver en tabla
            ]);
    }

    public function AbreModalCedula($id,$jardin){
        $data=['idCed'=>$id, 'jardin'=>$jardin];
        $this->dispatch('AbreModalDeCedula',$data);
    }

    public function AbreModalDeCambioDeEstado($id){
         $data=['urlId'=>$id];
        $this->dispatch('AbreModalCambiaEdoCedula',$data);
    }
}
