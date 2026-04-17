<?php

namespace App\Livewire\Sistema;

use App\Models\CatJardinesModel;
use App\Models\CatRolesModel;
use App\Models\User;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ModalAdminUsuariosComponent extends Component
{
    use WithFileUploads;

    /*############################################################
    ####### Para ejecutar, requiere la variable id del usuario:
    public function AbrirModalDeRolesDeUsuario(){
        #####<livewire:sistema.modal-admin-usuarios-component />
        $data=[
            'usrId'
        ];
        $this->dispatch('AbreModalRolesDeUsuario',$data);
    }
    ############################################################*/

    public $usrId; ##### var. que recibe de fuera
    public $editjar; #### para permisos de jardin
    ##### variables del cuestionario
    public $correo, $usrname, $nombre, $apellido, $nace, $avatar;
    public $Inactiva, $mensajes, $rolesUsr, $NvoRol, $NvoJardin, $NvoAvatar;
    #[On('AbreModalRolesDeUsuario')]

    public function MontandoModalRolesDeUsuario($data){
        $this->usrId= $data['usrId'];

        ##### Carga variables del usuario
        // $this->usrId=$this->usrId;
        $this->correo=User::where('id',$this->usrId)->value('email');
        $this->usrname=User::where('id',$this->usrId)->value('usrname');
        $this->nombre=User::where('id',$this->usrId)->value('nombre');
        $this->apellido=User::where('id',$this->usrId)->value('apellido');
        $this->nace=User::where('id',$this->usrId)->value('nace');
        $this->avatar=User::where('id',$this->usrId)->value('avatar');
        $act=User::where('id',$this->usrId)->value('act');
        if($act=='1'){$this->Inactiva=FALSE;}else{$this->Inactiva=TRUE;}
        $men=User::where('id',$this->usrId)->value('mensajes');
        if($men=='1'){$this->mensajes=TRUE;}else{$this->mensajes=FALSE;}
    }

    public function LimpiarModal(){
        $this->reset(['usrId','correo','usrname','nombre','apellido','nace','avatar','Inactiva','NvoAvatar','mensajes']);
        $this->rolesUsr=[];
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function CierraModal(){
        $this->LimpiarModal();
        $this->dispatch('CierraModalRolesDeUsuario',reload:1);
    }

    public function InactivarRol_Modal($rolId){
        ###### Verifica que no se quede sin admin@todos
        ###### revisa el rol a eliminar
        $RolAeliminar=UserRolesModel::where('rol_id',$rolId)
            ->value('rol_crolrol');

        ##### si el rol es admin, revisa que no sea el último con "todos" activo
        if($RolAeliminar == 'admin'){
            ###### cuenta admin@todos
            $cuentaAdminsTodos=UserRolesModel::where('rol_crolrol','admin')
                ->where('rol_cjarsiglas','todos')
                ->where('rol_act','1')->where('rol_del','0')
                ->count();
            if($cuentaAdminsTodos == '1'){
                $this->addError('ErrorAdmin','El sistema no se puede quedar sin admin@todos. Antes de eliminar, asigna otro usuario como admin@todos');
                return;
            }
        }

        UserRolesModel::where('rol_id',$rolId)->update([
            'rol_act'=>'0',
        ]);

        ##### Genera Log
        paLog('Se inactivó el rol id '.$rolId, 'UserRolesModel',$rolId);

        ##### Envía correo
        $datoPacorreo=UserRolesModel::where('rol_id',$rolId)
            ->first();
        $to=$this->usrId;        ##### id de users de destino
        $from=Auth::user()->id;      ##### id de users de quien escribe o 0 para sistema
        $ifReply='0';   ##### 0 para mensajes nuevos o msj_id para respuesta a msj previo
        $asunto="Cambio de estado de rol en el Sistema de Cédulas del Jardín";
        $mensaje='Se te retiraron los privilegios del rol de <b>'. $datoPacorreo->rol_crolrol .'</b> en el jardín <b>'.$datoPacorreo->rol_cjarsiglas.
            "</b> (ver <a href='".url('/homeConfig')."'>configuración de usuario</a>)";
        $notas='';
        ##### Envía mensaje con función de helper
        $a=EnviaMensajeAbuzon($to,$from,$asunto, $mensaje,$notas,$ifReply);
        if($a > '0'){
            $this->dispatch('AvisoExitoModalUsuarios', msj:'Error en el envío del mensaje');
            return;
        }

        ##### Limpia vars
        $this->NvoRol='';
        $this->NvoJardin='';
    }

    public function AgregarRol_Modal(){
        $this->validate([
            'NvoRol'=>'required',
            'NvoJardin'=>'required',
        ]);
        $bla=UserRolesModel::create([
            'rol_id'=>UserRolesModel::max('rol_id')+1,
            'rol_usrid'=>$this->usrId,
            'rol_cjarsiglas'=>$this->NvoJardin,
            'rol_crolrol'=>$this->NvoRol,
        ]);

        ##### Genera Log
        paLog('Se otorga rol '.$this->NvoRol.' en '.$this->NvoJardin.' a usr '.$this->usrId, 'UserRolesModel',$bla->rol_id);

        ##### Envía correo
        $to=$this->usrId;        ##### id de users de destino
        $from=Auth::user()->id;      ##### id de users de quien escribe o 0 para sistema
        $ifReply='0';   ##### 0 para mensajes nuevos o msj_id para respuesta a msj previo
        $asunto="Asignación de nuevo rol en el Sistema de Cédulas del Jardín";
        $mensaje='Se te otorgó el rol de <b>'. $this->NvoRol .'</b> en el jardín <b>'.$this->NvoJardin.
            "</b> (ver <a href='".url('/homeConfig')."'>configuración de usuario</a>)";
        $notas='';
        ##### Envía mensaje con función de helper
        $a=EnviaMensajeAbuzon($to,$from,$asunto, $mensaje,$notas,$ifReply);
        if($a > '0'){
            $this->dispatch('AvisoExitoModalUsuarios', msj:'Error en el envío del mensaje');
            return;
        }

        ##### Limpia
        $this->NvoRol='';
        $this->NvoJardin='';
    }

    public function GuardaModal(){
        $this->validate([
            'nombre'=>'required',
            'apellido'=>'required',
            'usrname'=>'required|unique:users,usrname,'.$this->usrId,
        ]);
        ##### Si hay rol pendiente de guardar, lo guarda
        if($this->NvoJardin !='' AND $this->NvoRol != ''){$this->AgregarRol_Modal();}
        ##### convierte variable checkbox
        if($this->Inactiva==TRUE){$act='0';}else{$act='1';}
        if($this->mensajes==TRUE){$mens='1';}else{$mens='0';}
        ##### guarda
        User::where('id',$this->usrId)->update([
            'act'=>$act,
            'usrname'=>$this->usrname,
            'nombre'=>$this->nombre,
            'apellido'=>$this->apellido,
            'nace'=>$this->nace,
            'mensajes'=>$mens,
        ]);
        ##### Si hay nuevo avatar, lo guarda
        if($this->NvoAvatar != ''){
            $nombre="usuario_".$this->usrId.".".$this->NvoAvatar->getClientOriginalExtension();
            $ruta="/avatar/usr/";
            $this->NvoAvatar->storeAs(path:'/public/'.$ruta, name: $nombre);
            User::where('id',$this->usrId)->update([
                'avatar'=>$ruta.$nombre,
            ]);
        }
        $this->CierraModal();
    }

    public function render(){
        ##### Revisa permisos del usuario
        $auts=['admin'];

        ##### jardines autorizados al usuario
        $this->editjar = UserRolesModel::where('rol_usrid',Auth::user()->id)
            ->whereIn('rol_crolrol',$auts)
            ->where('rol_act','1')->where('rol_del','0')
            ->pluck('rol_cjarsiglas')->toArray();


        #### Genera lista de jardines según los autorizados al usuario
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

        ############# Carga roles
        $this->rolesUsr=UserRolesModel::where('rol_usrid',$this->usrId)
            ->where('rol_del','0')
            ->where('rol_act','1')
            ->orderBy('rol_cjarsiglas')
            ->get();

        return view('livewire.sistema.modal-admin-usuarios-component',[
            'catRoles'=>CatRolesModel::select('crol_rol','crol_describe')->orderBy('crol_rol')->get(),
            'JardsDelUsr'=>$JardsUsr,
        ]);
    }
}
