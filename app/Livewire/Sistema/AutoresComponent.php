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


class AutoresComponent extends Component
{

    use WithFileUploads;

    public $edit, $editjar; ### Variables de autorización


    public function AbreModalAutores($par1){
        if($this->edit=='1'){
            $data=['cautId'=>$par1];
            $this->dispatch('AbreModalDeAutores',$data);
        }
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
            // redirect('/noauth/Solo accede rol '.implode(',',$auts).' con acceso a todos');
        }
        if(!array_intersect($auts,session('rol') )) {redirect('/noauth/Solo accede rol '.implode(',',$auts).' con acceso a todos');}

        return view('livewire.sistema.autores-component',[
            'autores'=>cat_autores::get(),
        ]);
    }
}
