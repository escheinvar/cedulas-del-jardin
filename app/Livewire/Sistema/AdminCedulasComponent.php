<?php

namespace App\Livewire\Sistema;


use App\Models\cat_tipocedula;
use App\Models\CatJardinesModel;
use App\Models\ced_alias;
use App\Models\ced_sp;
use App\Models\ced_autores;
use App\Models\cat_autores;
use App\Models\cedulas_txt;
use App\Models\cedulas_url;
use App\Models\lenguas;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminCedulasComponent extends Component
{
    public $edit, $editMaster, $editjar; ##### Variables de permisos del usuario
    ##### Vars de formulario de búsqueda y de tabla
    public $urls, $jardinSel, $BuscaLengua, $BuscaEstado, $BuscaTexto, $BuscaOriginal, $BuscaAutor;
    public $sentido, $orden, $edoEdit, $abiertos, $cambiaPars;
    public $OcultaPublicadas;

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
        $this->orden='url_tituloorig';
        $this->sentido='asc';

        $this->jardinSel=session('jardin');
        foreach(['BuscaLengua','BuscaEstado','BuscaOriginal','OcultaPublicadas','BuscaAutor','BuscaTexto'] as $mod){
            if(isset(session('tempSession')[$mod])  AND  session('tempSession')[$mod] != '' ){
                // dd(session('tempSession'));
                $this->$mod = session('tempSession')[$mod];

            }else {
                $this->$mod='';
            }
        }
        // $this->urls=cedulas_url::get();
        $this->urls=collect();

        $this->BuscarEnTextoDeCedulas();
    }

    public function DefineCambio($Modelo){
        $this->cambiaPars='1';
        // if($Modelo=='jardin'){
        //     session(['jardin'=>$this->jardinSel]);
        // }else{
        //     session(['tempSession'=>[$Modelo=>$this->$Modelo]]);
        // }
    }

    public function BuscarEnTextoDeCedulas(){
        $this->cambiaPars='0';

        ##### Revisa permisos del usuario
        $auts=['editor','admin','autor','traductor']; ##### array de roles autorizados a editar

        ##### array de jardines autorizados al usuario (puede incluir palabra "todos")
        $this->editjar = UserRolesModel::where('rol_usrid',Auth::user()->id)
            ->whereIn('rol_crolrol',$auts)
            ->where('rol_act','1')->where('rol_del','0')
            ->distinct('rol_cjarsiglas')
            ->pluck('rol_cjarsiglas')->toArray();

        #### Genera colect de jardines autorizados al usuario (sin palabra "todos")
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

        if(cedulas_url::count() > '0' ){
            $urls=cedulas_url::query();

            ###### Restringe a cédulas de jardines autorizados
            $urls=$urls->whereIn('url_cjarsiglas', $JardsUsr->pluck('cjar_siglas')->toArray());

            ##### Restringe a cédulas en las que son autores (salvo a admin, que debe ver todas)
            if( !array_intersect(['admin'], session('rol'))) {
                $Mias=ced_autores::join('cat_autores', 'aut_cautid','=','caut_id')
                    ->where('caut_usrid', Auth::user()->id)
                    ->pluck('aut_urlid')
                    ->toArray();
                $urls=$urls->whereIn('url_id',$Mias);
            }

            ##### Búsqueda por campo de select jardin
            if($this->jardinSel != ''){
                $urls=$urls->where('url_cjarsiglas','ilike',$this->jardinSel);
            }
            ##### Obtiene cédulas originales (checkbox)
            if($this->BuscaOriginal==TRUE){
                $urls=$urls->where('url_tradid','0');
            }

            ##### Obtiene lista de Cédulas por lengua (select lengua)
            if($this->BuscaLengua != ''){
                $urls=$urls->where('url_lencode',$this->BuscaLengua);
            }

            ##### Obtiene lista de Cédulas por estado (select estado)
            if($this->BuscaEstado != ''){
                $urls=$urls->where('url_edo',$this->BuscaEstado);
            }

            ##### Obtiene lista de Cédulas por texto (input texto)
            if($this->BuscaTexto != ''){
                #### Busca en url, titulo o resumen.
                $EnUrl=cedulas_url::where(function($q){
                    return $q
                    ->where('url_url','ilike', '%'.$this->BuscaTexto.'%')
                    ->orWhere('url_titulo','ilike', '%'.$this->BuscaTexto.'%')
                    ->orWhere('url_resumen','ilike', '%'.$this->BuscaTexto.'%');
                    })
                    ->pluck('url_id')
                    ->toArray();

                ##### Busca en alias
                $EnAlias=ced_alias::where('ali_txt_tr','ilike', '%'.$this->BuscaTexto.'%')
                    ->where('ali_act','1')
                    ->where('ali_del','0')
                    ->pluck('ali_urlid')
                    ->toArray();
                ##### Busca en nombres cientíicos
                $EnEspecies=ced_sp::where('sp_scname','ilike', '%'.$this->BuscaTexto.'%')
                    ->leftJoin('cedula_url', 'sp_key','=','url_key')
                    ->where('sp_act','1')
                    ->where('sp_del','0')
                    ->pluck('url_id')
                    ->toArray();
                ##### Uno todos
                $ganones= array_unique(array_merge($EnUrl,$EnAlias,$EnEspecies));

                #### muestra los ganones
                $urls=$urls->whereIn('url_id',$ganones);
            }

            ##### Obtiene lista de Cédulas por autor
            if($this->BuscaAutor != ''){
                $autoresPosibles=cat_autores::where('caut_nombre','ilike', '%'.$this->BuscaAutor.'%')
                    ->orWhere('caut_apellido1','ilike', '%'.$this->BuscaAutor.'%')
                    ->orWhere('caut_apellido2','ilike', '%'.$this->BuscaAutor.'%')
                    ->orWhere('caut_nombreautor','ilike', '%'.$this->BuscaAutor.'%')
                    ->join('ced_autores','aut_cautid','=','caut_id')
                    ->where('caut_del','0')
                    ->where('caut_act','1')
                    ->where('aut_del','0')
                    ->where('aut_act','1')
                    ->pluck('aut_urlid')
                    ->toArray();
                $urls=$urls->whereIn('url_id', $autoresPosibles);
            }

            ##### Revisa opción de solo publicadas (checkbox)
            if($this->OcultaPublicadas==TRUE){
                $urls=$urls->where('url_edo','<=','4');
            }

            ### Finaliza búsqueda de url
            $urls=$urls->orderBy('url_cjarsiglas','asc')
                    ->orderBy($this->orden,$this->sentido)
                    ->where('url_del','0')
                    ->with('jardin')
                    ->with('lenguas')
                    ->with('autores')
                    ->with('editores')
                    ->with('traductores')
                    ->with('ubicaciones')
                    ->with('especies')
                    ->with('alias');

        }else{
                 $urls=cedulas_url::query();
        }
        $this->urls=$urls->get();

        ##### Guarda variables de sesión
        session(['jardin'=>$this->jardinSel]);
        foreach(['BuscaLengua','BuscaEstado','BuscaOriginal','BuscaAutor','BuscaTexto','OcultaPublicadas'] as $mod){
            $bla[$mod]=$this->$mod;
        }
        session(['tempSession'=>$bla]);
    }

    public function ordenaTabla($orden){
        $this->orden=$orden;
        if($this->sentido=='asc'){
            $this->sentido='desc';
        }else{
            $this->sentido='asc';
        }
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

    public function BorrarCampo($campo){
        $this->reset([$campo]);
        $this->cambiaPars='1';
    }

    public function render(){
        // dd(session()->all());
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

        ##### array de jardines autorizados al usuario (puede incluir palabra "todos")
        $this->editjar = UserRolesModel::where('rol_usrid',Auth::user()->id)
            ->whereIn('rol_crolrol',$auts)
            ->where('rol_act','1')->where('rol_del','0')
            ->distinct('rol_cjarsiglas')
            ->pluck('rol_cjarsiglas')->toArray();

        #### Genera colect de jardines autorizados al usuario (sin palabra "todos")
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
        // if(cedulas_url::count() > '0' ){
        //     $urls=cedulas_url::query();

        //     ###### Restringe a cédulas de jardines autorizados
        //     $urls=$urls->whereIn('url_cjarsiglas', $JardsUsr->pluck('cjar_siglas')->toArray());

        //     ##### Restringe a cédulas en las que son autores (salvo a admin, que debe ver todas)
        //     if( !array_intersect(['admin'], session('rol'))) {
        //         $Mias=ced_autores::join('cat_autores', 'aut_cautid','=','caut_id')
        //             ->where('caut_usrid', Auth::user()->id)
        //             ->pluck('aut_urlid')
        //             ->toArray();
        //         $urls=$urls->whereIn('url_id',$Mias);
        //     }

        //     ##### Búsqueda por campo de select jardin
        //     if($this->jardinSel != ''){
        //         $urls=$urls->where('url_cjarsiglas','ilike',$this->jardinSel);
        //     }
        //     ##### Obtiene cédulas originales (checkbox)
        //     if($this->BuscaOriginal==TRUE){
        //         $urls=$urls->where('url_tradid','0');
        //     }

        //     ##### Obtiene lista de Cédulas por lengua (select lengua)
        //     if($this->BuscaLengua != ''){
        //         $urls=$urls->where('url_lencode',$this->BuscaLengua);
        //     }

        //     ##### Obtiene lista de Cédulas por estado (select estado)
        //     if($this->BuscaEstado != ''){
        //         $urls=$urls->where('url_edo',$this->BuscaEstado);
        //     }

        //     ##### Obtiene lista de Cédulas por texto (input texto)
        //     if($this->BuscaTexto != ''){
        //         // #### Busca en url, titulo o resumen.
        //         // $EnUrl=cedulas_url::where(function($q){
        //         //     return $q
        //         //     ->where('url_url','ilike', '%'.$this->BuscaTexto.'%')
        //         //     ->orWhere('url_titulo','ilike', '%'.$this->BuscaTexto.'%')
        //         //     ->orWhere('url_resumen','ilike', '%'.$this->BuscaTexto.'%');
        //         //     })
        //         //     ->pluck('url_id')
        //         //     ->toArray();
        //         //     // dd($EnUrl);
        //         // ##### Busca en alias
        //         // $EnAlias=ced_alias::where('ali_txt_tr','ilike', '%'.$this->BuscaTexto.'%')
        //         //     ->where('ali_act','1')
        //         //     ->where('ali_del','0')
        //         //     ->pluck('ali_urlid')
        //         //     ->toArray();
        //         // ##### Busca en nombres cientíicos
        //         // $EnEspecies=ced_sp::where('sp_scname','ilike', '%'.$this->BuscaTexto.'%')
        //         //     ->leftJoin('cedula_url', 'sp_key','=','url_key')
        //         //     ->where('sp_act','1')
        //         //     ->where('sp_del','0')
        //         //     ->pluck('url_id')
        //         //     ->toArray();
        //         // ##### Uno todos
        //         // $ganones= array_unique(array_merge($EnUrl,$EnAlias,$EnEspecies));

        //         // #### muestra los ganones
        //         // $urls=$urls->whereIn('url_id',$ganones);
        //     }

        //     ##### Obtiene lista de Cédulas por autor
        //     if($this->BuscaAutor != ''){
        //         $autoresPosibles=cat_autores::where('caut_nombre','ilike', '%'.$this->BuscaAutor.'%')
        //             ->orWhere('caut_apellido1','ilike', '%'.$this->BuscaAutor.'%')
        //             ->orWhere('caut_apellido2','ilike', '%'.$this->BuscaAutor.'%')
        //             ->orWhere('caut_nombreautor','ilike', '%'.$this->BuscaAutor.'%')
        //             ->join('ced_autores','aut_cautid','=','caut_id')
        //             ->where('caut_del','0')
        //             ->where('caut_act','1')
        //             ->where('aut_del','0')
        //             ->where('aut_act','1')
        //             ->pluck('aut_urlid')
        //             ->toArray();
        //         $urls=$urls->whereIn('url_id', $autoresPosibles);
        //     }

        //     ##### Revisa opción de solo publicadas (checkbox)
        //     if($this->OcultaPublicadas==TRUE){
        //         $urls=$urls->where('url_edo','<=','4');
        //     }

        //     ### Finaliza búsqueda de url
        //     $urls=$urls->orderBy('url_cjarsiglas','asc')
        //             ->orderBy($this->orden,$this->sentido)
        //             ->where('url_del','0')
        //             ->with('jardin')
        //             ->with('lenguas')
        //             ->with('autores')
        //             ->with('editores')
        //             ->with('traductores')
        //             ->with('ubicaciones')
        //             ->with('especies')
        //             ->with('alias');

        // }else{
        //          $urls=cedulas_url::query();
        // }
        // $this->urls=$urls->get();


        ##### Obtiene cantidad de cedulas en edición
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
            'JardsDelUsr'=>$JardsUsr,  ##### Lista de jardines autorizados
            'lenguas'=>lenguas::orderBy('len_lengua')->get(),  ##### Lista de lenguas del catálogo
            // 'urls'=>$urls,   ##### Tabla de urls para ver en tabla
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
