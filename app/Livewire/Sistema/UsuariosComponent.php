<?php

namespace App\Livewire\Sistema;

use App\Models\CatJardinesModel;
use App\Models\CatLenguasModel;
use App\Models\CatRolesModel;
use App\Models\InstitucionesModel;
use App\Models\SistBuzonMensajesModel;
use App\Models\User;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;


class UsuariosComponent extends Component{
    #[Layout('components.layouts.SistemaBase')]

    public $VerEditUsr, $usrID,$correo,$act,$usrname, $nombre, $apellido, $org;
    public $NewRol, $NewRolJardin, $NewRolLengua;

    public function mount(){
        $this->VerEditUsr='0';
    }

    public function IniciaEdit($idUsr){
        $this->usrID=$idUsr;
        $this->VerEditUsr='1';
        $this->correo=User::where('id',$idUsr)->value('email');
        $this->act=User::where('id',$idUsr)->value('act');
        $this->usrname=User::where('id',$idUsr)->value('usrname');
        $this->nombre=User::where('id',$idUsr)->value('nombre');
        $this->apellido=User::where('id',$idUsr)->value('apellido');
        $this->org=User::where('id',$idUsr)->value('cinsid');
    }

    public function CancelaEdit(){
        $this->usrID="0";
        $this->VerEditUsr='0';
        $this->correo ='';
        $this->act='';
        $this->usrname ='';
        $this->nombre ='';
        $this->apellido ='';
        $this->org='';
        $this->NewRol='';
        $this->NewRolJardin='';
        $this->NewRolLengua='';
    }

    public function GuardaEdit(){
        #dd('falta validar');
        $this->validate([
            'correo'=>'required|unique:users,email,'.$this->usrID.',id',
            'usrname'=>'required|unique:users,usrname,'.$this->usrID.',id',
            'nombre'=>'required',
            'apellido'=>'required',
        ]);
        User::where('id',$this->usrID)->update([
            'email'=>$this->correo,
            'act'=>$this->act,
            'usrname'=>$this->usrname,
            'nombre'=>$this->nombre,
            'apellido'=>$this->apellido,
            'cinsid'=>$this->org,
        ]);
        if($this->NewRol != '') {
            if(in_array($this->NewRol, ['cedulas','traduce'])){
                UserRolesModel::create([
                    'rol_usrid'=>$this->usrID,
                    'rol_crolrol'=>$this->NewRol,
                    'rol_tipo1'=>$this->NewRolJardin,
                    'rol_tipo2'=>$this->NewRolLengua
                ]);
            }else{
                UserRolesModel::create([
                    'rol_usrid'=>$this->usrID,
                    'rol_crolrol'=>$this->NewRol,
                ]);
            }
            ##### Envía mensaje a usuario
            SistBuzonMensajesModel::create([
                'buz_modulo'=>'cedulas',
                'buz_usr_origen'=>Auth::id(),
                'buz_destino_usr'=>$this->usrID,
                'buz_notas'=>null,
                'buz_asunto'=>'Asignación de nuevo privilegio',
                'buz_mensaje'=>'Se te otorgó el privilegio de '.$this->NewRol." ".$this->NewRolJardin." ".$this->NewRolLengua."",
                'buz_date_origen'=>date('Y-m-d H:i:s'),
            ]);
        }
        $this->CancelaEdit();
    }

    public function BorraRol($rolID){
        ##### inactiva rol
        UserRolesModel::where('rol_id',$rolID)->update([
            'rol_act'=>'0',
        ]);
        ##### Envía mensaje a usuario
        $datoForMsg=UserRolesModel::where('rol_id',$rolID)->first();
        SistBuzonMensajesModel::create([
            'buz_modulo'=>'cedulas',
            'buz_usr_origen'=>Auth::id(),
            'buz_destino_usr'=>$datoForMsg->rol_usrid,
            'buz_notas'=>null,
            'buz_asunto'=>'Cambio de privilegios',
            'buz_mensaje'=>'Se desactivó el privilegio de '.$datoForMsg->rol_crolrol." (".$datoForMsg->rol_tipo1." ".$datoForMsg->rol_tipo1.")",
            'buz_date_origen'=>date('Y-m-d H:i:s'),
        ]);
    }

    public function render() {
        $usuarios=User::select(['id','act','email','usrname','nombre','apellido'])
            ->orderBy('email','asc')
            ->get();

        $roles=UserRolesModel::where('rol_act','1')
            ->orderBy('rol_crolrol','asc')
            ->orderBy('rol_tipo1','asc')
            ->orderBy('rol_tipo2','asc')
            ->get();
            $catLenguas=CatLenguasModel::orderBy('clen_lengua','asc')->get();
            #dd($roles,$catLenguas);

        return view('livewire.sistema.usuarios-component',[
            'usuarios'=>$usuarios,
            'roles'=>$roles,
            'orgs'=>InstitucionesModel::orderBy('cins_institucion')->get(),
            'catRoles'=>CatRolesModel::select('crol_rol','crol_describe')->get(),
            'catJards'=>CatJardinesModel::OrderBy('cjar_nombre')->get(),
            'catLenguas'=>$catLenguas,
        ]);
    }
}
