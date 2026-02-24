<?php

namespace App\Livewire\Sistema;
use App\Models\CatJardinesModel;
use App\Models\CatRolesModel;
use App\Models\User;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class UsuariosComponent extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $edit,$editjar; ##### Variables de permisos del usuario
    public $jardinSel, $rolSel, $nombreSel; ##### Vars de formulario de búsqueda
    public  $usrId,$correo,$usrname,$nombre,$apellido,$nace; ##### Vars de formulario de modal
    public  $Inactiva,$mensajes,$avatar,$NvoAvatar,$rolesUsr,$orden,$sentido; #### vars de modal
    public  $NvoRol, $NvoJardin; ##### vars de modal

    public function mount(){
        $this->rolesUsr=[];
        $this->orden='email';
        $this->sentido='asc';
        $this->jardinSel='';
        $this->rolSel='';
    }

    public function ordenaTabla($ord){
        if($this->sentido=='asc'){
            $this->sentido='desc';
        }else{
            $this->sentido='asc';
        }
        $this->orden=$ord;
    }

    public function render() {
        ##### Revisa permisos del usuario
        $auts=['admin'];
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

        ##### Tabla de usuarios con su rol
        $usuarios=User::query();
        $usuarios=$usuarios->select(['id','act','email','usrname','nombre','apellido','nace','avatar'])
            ->with('roles')
            ->orderBy($this->orden,$this->sentido)
            ->with('roles');

        ##### Tabla de usuarios: Selecciona usuarios asignados a un jardín...
        if($this->jardinSel != ''){
            $usuarios=$usuarios->whereHas('roles', function($q){
                $q->where('rol_cjarsiglas',$this->jardinSel)
                    ->orWhere('rol_cjarsiglas','todos');
            });
        }

        ##### Tabla de usuarios: Tabla de usuarios con rol....
        if($this->rolSel != ''){
            $usuarios=$usuarios->whereHas('roles', function($q) {
                $q->where('rol_crolrol',$this->rolSel);
            });
        }

        ##### Tabla de usuarios: Tabla de usuarios con nombre....
        if($this->nombreSel != ''){
            $usuarios=$usuarios->where('usrname','ilike', '%'.$this->nombreSel.'%')
                ->orWhere('nombre','ilike', '%'.$this->nombreSel.'%')
                ->orWhere('apellido','ilike', '%'.$this->nombreSel.'%')
                ->orWhere('email','ilike', '%'.$this->nombreSel.'%');
        }
        $usuarios=$usuarios->paginate('20');

        return view('livewire.sistema.usuarios-component',[
            'usuarios'=>$usuarios,
            'catRoles'=>CatRolesModel::select('crol_rol','crol_describe')->orderBy('crol_rol')->get(),
            'JardsDelUsr'=>$JardsUsr,
        ]);
    }





    ###################################################
    ###################  Iniciamos funciones de modal
    public function AbreModal($var){
        ##### Carga variables del usuario
        $this->usrId=$var;
        $this->correo=User::where('id',$var)->value('email');
        $this->usrname=User::where('id',$var)->value('usrname');
        $this->nombre=User::where('id',$var)->value('nombre');
        $this->apellido=User::where('id',$var)->value('apellido');
        $this->nace=User::where('id',$var)->value('nace');
        $this->avatar=User::where('id',$var)->value('avatar');
        $act=User::where('id',$var)->value('act');
        if($act=='1'){$this->Inactiva=FALSE;}else{$this->Inactiva=TRUE;}
        $men=User::where('id',$var)->value('mensajes');
        if($men=='1'){$this->mensajes=TRUE;}else{$this->mensajes=FALSE;}
        $this->rolesUsr=UserRolesModel::where('rol_usrid',$var)
            ->where('rol_del','0')
            ->where('rol_act','1')
            ->orderBy('rol_cjarsiglas')
            ->get();
        #### Abre modal
        $this->dispatch('AbreModal');
    }

    public function CierraModal(){
        $this->reset(['usrId','correo','usrname','nombre','apellido','nace','avatar','Inactiva','NvoAvatar','mensajes']);
        $this->rolesUsr=[];
        $this->dispatch('CierraModal');
    }

    public function InactivarRol($rolId){
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
        $this->NvoRol='';
        $this->NvoJardin='';
        $this->AbreModal($this->usrId);
        ##### Genera Log
        paLog('Se inactivó el rol id '.$rolId, 'UserRolesModel',$rolId);
    }

    public function AgregarRol(){
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
        $this->NvoRol='';
        $this->NvoJardin='';
        $this->AbreModal($this->usrId);
        ##### Genera Log
        paLog('Se otorga rol '.$this->NvoRol.' en '.$this->NvoJardin.' a usr '.$this->usrId, 'UserRolesModel',$bla->rol_id);
    }

    public function GuardaModal(){
        $this->validate([
            'nombre'=>'required',
            'apellido'=>'required',
            'usrname'=>'required|unique:users,usrname,'.$this->usrId,
        ]);
        ##### Si hay rol pendiente de guardar, lo guarda
        if($this->NvoJardin !='' AND $this->NvoRol != ''){$this->AgregarRol();}
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
}
