<?php

namespace App\Livewire\Sistema;

use App\Models\cat_autores;
use App\Models\CatCampusModel;
use App\Models\CatEntidadesInegiModel;
use App\Models\CatJardinesModel;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;


class AdminAutoresComponent extends Component
{

    use WithFileUploads;

    public $edit, $editjar; ### Variables de autorización
    ####### Vars de pag web:
    public $orden, $sent, $jardinSel, $abiertos;

    public function mount(){
        $this->orden='caut_id';
        $this->sent='asc';
        $this->jardinSel='JebOax'; #### Pasar a '' !!!!
    }

    public function AbreModalAutores($par1){
        if($this->edit=='1'){
            $data=[
                'cautId'=>$par1,
                'cjarsiglas'=>$this->jardinSel,
            ];
            $this->dispatch('AbreModalDeAutores',$data);
        }
    }

    public function CambiaConOsinWeb($id){
        $valor=cat_autores::where('caut_id',$id)->value('caut_web');
        if($valor=='0'){$nuevo='1';}else{$nuevo='0';}
        cat_autores::where('caut_id',$id)->update(['caut_web'=>$nuevo]);
        ###### Genera Log
        paLog('Cambio de edo web a '.$nuevo.' de usr '.$id,'cat_autores',$id);
    }

    public function CambiaEditNoEdit($id){
        $valor=cat_autores::where('caut_id',$id)->value('caut_edit');
        if($valor=='0'){$nuevo='1';}else{$nuevo='0';}
        cat_autores::where('caut_id',$id)->update(['caut_edit'=>$nuevo]);
        ###### Genera Log
        paLog('Cambio estado de edición a '.$nuevo.' de usr '.$id,'cat_autores',$id);
    }

    public function render(){
        ##### Revisa permisos del usuario
        $auts=['admin'];
        $this->editjar = UserRolesModel::where('rol_usrid',Auth::user()->id)
            ->whereIn('rol_crolrol',$auts)
            ->where('rol_act','1')->where('rol_del','0')
            ->pluck('rol_cjarsiglas')->toArray();
        // if(array_intersect($auts,session('rol')) and in_array('todos',$this->editjar) ){
        if(array_intersect($auts,session('rol'))  ){
            $this->edit='1';
        }else{
            $this->edit='0';
        }
        if(!array_intersect($auts,session('rol') )) {redirect('/noauth/Solo accede rol '.implode(',',$auts).' con acceso a todos');}


        ##### jardines autorizados al usuario
        $this->editjar = UserRolesModel::where('rol_usrid',Auth::user()->id)
            ->whereIn('rol_crolrol',$auts)
            ->where('rol_act','1')->where('rol_del','0')
            ->distinct('rol_cjarsiglas')
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

        ######################## Obtiene lista de autores
        $autores=cat_autores::query();
        $autores=$autores->where('caut_del','0')
            ->orderBy($this->orden,$this->sent)
            ->with('urlautor')
            ->with('cedulas')
            ->get();

        return view('livewire.sistema.admin-autores-component',[
            'autores'=>$autores,
            'JardsDelUsr'=>$JardsUsr,
        ]);
    }
}
