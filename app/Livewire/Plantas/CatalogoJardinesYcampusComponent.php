<?php

namespace App\Livewire\Plantas;

use App\Models\CatCampusModel;
use App\Models\CatEntidadesInegiModel;
use App\Models\CatJardinesModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('plantillas.PlantillaSistemaBase')]
class CatalogoJardinesYcampusComponent extends Component
{

    use WithFileUploads;

    public $HayJardin,$jar_name,$jar_nombre, $jar_siglas, $jar_tipo, $jar_direccion, $jar_edo, $jar_tel, $jar_mail, $jar_logo, $jar_logoNuevo;
    public $campuses;
    public $HayCampus, $cam_name, $cam_nombre, $cam_direccion;

    public function mount(){
        $this->HayJardin='';
        $this->HayCampus='0';
    }

    public function ProcedeJardin($id){
        if($id > '0'){
            $this->HayJardin = $id;
            $datoJardin=CatJardinesModel::where('cjar_id',$id)->first();
            $this->jar_name = $datoJardin->cjar_name;
            $this->jar_nombre = $datoJardin->cjar_nombre;
            $this->jar_siglas = $datoJardin->cjar_siglas;
            $this->jar_tipo = $datoJardin->cjar_tipo;
            $this->jar_direccion = $datoJardin->cjar_direccion;
            $this->jar_edo = $datoJardin->cjar_edo;
            $this->jar_tel = $datoJardin->cjar_tel;
            $this->jar_mail = $datoJardin->cjar_mail;
            $this->jar_logo = $datoJardin->cjar_logo;
            $this->campuses=CatCampusModel::where('ccam_cjarid',$datoJardin->cjar_id)->where('ccam_act','1')->get();
        }else{
            $this->HayJardin='0';
            $this->jar_name = '';
            $this->jar_nombre = '';
            $this->jar_siglas = '';
            $this->jar_tipo = '';
            $this->jar_direccion = '';
            $this->jar_tel = '';
            $this->jar_mail = '';
            $this->jar_logo = '';
            $this->campuses=[];
        }
    }

    public function ProcedeCampus($id){
        if($id > '0'){
            $this->HayCampus=$id;
            $datoCampus=CatCampusModel::where('ccam_id',$id)->where('ccam_act','1')->first();
            $this->cam_name = $datoCampus-> ccam_name;
            $this->cam_nombre = $datoCampus-> ccam_nombre;
            $this->cam_direccion = $datoCampus -> ccam_direccion;
        }else{
            $this->HayCampus='0';
            $this->cam_name = '';
            $this->cam_nombre = '';
            $this->cam_direccion = '';
        }
    }

    public function EditaJardin($id){
        $this->validate([
            'jar_name'=>'required',
            'jar_nombre'=>'required',
            'jar_siglas'=>'required|unique:cat_jardines,cjar_siglas,'.$id.',cjar_id',
        ]);
        ##### Procesa imágen (nombre y guarda)
        if($this->jar_logoNuevo != ''){
            $LogoNombre=$this->jar_siglas.".".$this->jar_logoNuevo->getClientOriginalExtension();
            $this->jar_logoNuevo->storeAs('/aPublic/avatar/jardines/', $LogoNombre);
        }else{
            $LogoNombre= $this->jar_logo;
        }

        CatJardinesModel::updateOrCreate(['cjar_id'=>$id, 'cjar_name'=>$this->jar_name], [
            'cjar_name'=>$this->jar_name,
            'cjar_nombre'=>$this->jar_nombre,
            'cjar_siglas'=>$this->jar_siglas,
            'cjar_tipo'=>$this->jar_tipo,
            'cjar_direccion'=>$this->jar_direccion,
            'cjar_tel'=>$this->jar_tel,
            'cjar_mail'=>$this->jar_mail,
            'cjar_edo'=>$this->jar_edo,
            'cjar_logo'=>$LogoNombre,
        ]);
        redirect('/catalogo/campus');
    }

    public function BorraLogo($id, $archivo){
        ##### La borra en la base
        CatJardinesModel::where('cjar_id',$id)->update(['cjar_logo'=>null,]);
        ##### La borra en la carpeta
        Storage::delete("/aPublic/avatar/jardines/".$archivo);
        redirect('/catalogo/campus');
    }

    public function EditaCampus($id){
        CatCampusModel::updateOrCreate(['ccam_id'=>$id], [
            'ccam_cjarid'=> $this->HayJardin,
            'ccam_name'=>$this->cam_name,
            'ccam_nombre'=>$this->cam_nombre,
            'ccam_direccion'=>$this->cam_direccion,
        ]);
        redirect('/catalogo/campus');
    }


    public function render(){
        $NumDeCampus = CatCampusModel::where('ccam_act','1')->select('ccam_cjarid', DB::raw('count(ccam_cjarid) as total'))->groupBy('ccam_cjarid')->get();

        return view('livewire.plantas.catalogo-jardines-ycampus-component',[
            'jardines'=>CatJardinesModel::orderBy('cjar_id','asc')->get(),
            'NumDeCampus'=>$NumDeCampus,
            'Entidades'=>CatEntidadesInegiModel::all(),
        ]);
    }
}
