<?php

namespace App\Livewire\Sistema;

use App\Models\CatLenguasModel;
use App\Models\lenguas;
use App\Models\User;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LenguasComponent extends Component
{
    use WithPagination;

    public $edit,$editjar; ##### Variables de permisos del usuario
    public $orden,$sentido,$orden2,$sentido2; ##### Variables de tabla de lenguas
    public $VerNuevo; #### Variables de transición a búsqueda de nueva lengua
    public $lenguaSel, $localSel, $codeSel; ##### Variables de nueva lengua

    public function mount(){
        $this->orden='len_id';
        $this->sentido='asc';
        $this->orden2='clen_id';
        $this->sentido2='asc';
        $this->VerNuevo='0';
        // $this->lenguas=collect();
        $this->lenguaSel="";
        $this->localSel="";
    }

    public function ordenaTabla($ord){
        if($this->sentido=='asc'){
            $this->sentido='desc';
        }else{
            $this->sentido='asc';
        }
        $this->orden=$ord;
    }

    public function ordenaTabla2($ord){
        if($this->sentido2=='asc'){
            $this->sentido2='desc';
        }else{
            $this->sentido2='asc';
        }
        $this->orden2=$ord;
    }

    public function VerNuevaLengua(){
        ##### Cambia estado VerNuevo
        if($this->VerNuevo=='0'){$this->VerNuevo='1';}else{$this->VerNuevo='0';}
    }

    public function BorrarBusqueda($cual){
        $this->$cual='';
    }

    public function AgregarNuevaLengua($LenCode){
        ##### Carga datos
        $datos=CatLenguasModel::where('clen_code',$LenCode)->first();

        ##### Escribe datos
        lenguas::create([
            'len_code'=>$datos->clen_code,
            'len_lengua'=>$datos->clen_lengua,
            'len_altnames'=>$datos->clen_nombres,
            'len_autonimias'=>$datos->clen_autonimia,
        ]);
        $this->dispatch('AvisoExitoLengua',msj:'La lengua '.$datos->clen_lengua.' se agregó correctamente al sistema');
    }

    public function render() {
        ##### Revisa permisos del usuario
        $auts=['admin'];
        ##### jardines autorizados al usuario
        $this->editjar = UserRolesModel::where('rol_usrid',Auth::user()->id)
            ->whereIn('rol_crolrol',$auts)
            ->where('rol_act','1')->where('rol_del','0')
            ->pluck('rol_cjarsiglas')->toArray();
        if(array_intersect($auts,session('rol')) and in_array('todos',$this->editjar)){
            $this->edit='1';
        }else{
            $this->edit='0';
            redirect('/noauth/Solo accede rol '.implode(',',$auts).'@todos');
        }

        $lenguasActivas=lenguas::orderBy($this->orden,$this->sentido)->paginate(20);


        #####################################################
        ##### Genera Tabla para agregar  nueva lengua
        if($this->VerNuevo=='1'){
            $len=CatLenguasModel::query();

            ##### Busca por nombre de lengua, autonimia u otros nombres
            if($this->lenguaSel != ''){
                $len=$len->where(function($q){
                    return $q
                    ->where('clen_lengua','ilike','%'.$this->lenguaSel.'%')
                    ->orWhere('clen_nombres','ilike','%'.$this->lenguaSel.'%')
                    ->orWhere('clen_autonimia','ilike','%'.$this->lenguaSel.'%');
                });
            }

            ##### Búsqueda por ubicación
            if($this->localSel != ''){
                $len=$len->where('clen_localidad','ilike','%'.$this->localSel.'%');
            }

            ##### Búsqueda por código
            if($this->codeSel != ''){
                $len=$len->where('clen_code','ilike','%'.$this->codeSel.'%');
            }

            ##### Ejecuta búsqueda
            $len=$len->orderBy($this->orden2,$this->sentido2)
                ->where('clen_code','!=','none')
                ->get();
        }else{
            $len=collect();
        }



        return view('livewire.sistema.lenguas-component',[
            'lenguasActivas'=>$lenguasActivas,
            'lenguas'=>$len,
        ]);
    }
}






