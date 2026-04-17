<?php

namespace App\Livewire\Sistema;
use App\Models\CatJardinesModel;
use App\Models\CatRolesModel;
use App\Models\lenguas;
use App\Models\SpUrlModel;
use App\Models\User;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use \Livewire\Attributes\Session;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class AdminUsuariosComponent extends Component
{

    use WithPagination;

    public  $edit,$editjar; ##### Variables de permisos del usuario
    public  $jardinSel, $rolSel, $nombreSel; ##### Vars de formulario de búsqueda
    public $sentido, $orden;
    // public  $usrId,$correo,$usrname,$nombre,$apellido,$nace; ##### Vars de formulario de modal
    // public  $Inactiva,$mensajes,$avatar,$NvoAvatar,$rolesUsr,$orden,$sentido; #### vars de modal
    // public  $NvoRol, $NvoJardin; ##### vars de modal

    public function mount(){
        // $this->rolesUsr=[];
        $this->orden='email';
        $this->sentido='asc';
        $this->jardinSel=session('jardin');
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

    public function DefineJardin(){
        session(['jardin'=>$this->jardinSel]);
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

        return view('livewire.sistema.admin-usuarios-component',[
            'usuarios'=>$usuarios,
            'catRoles'=>CatRolesModel::select('crol_rol','crol_describe')->orderBy('crol_rol')->get(),
            'JardsDelUsr'=>$JardsUsr,
            // 'lenguas'=>lenguas::get(),
        ]);
    }

    ####### Ejecuta modal de usuario
    public function AbrirModalDeRolesDeUsuario($usrId){
        #####<livewire:sistema.modal-admin-usuarios-component />
        $data=[
            'usrId'=>$usrId,
        ];
        $this->dispatch('AbreModalRolesDeUsuario',$data);
    }
}
