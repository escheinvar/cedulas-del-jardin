<?php

namespace App\Livewire\Sistema;

use App\Models\CatJardinesModel;
use App\Models\proy_proyectos;
use App\Models\proy_estado;
use App\Models\proy_archivos;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ModalProyectoComponenet extends Component
{
    use WithFileUploads;

    ###############################################################
    ##### Explica dinámica:  Siempre va a haber dos estados activos
    ##### en predo_act=1 y predo_act=2 (todos los act=0 son pasados e inactivos)
    ##### act=1 es el estado en el que está ahora y act=2 es el próximo
    ##### estado (el que se está preparando para envío), pero que como
    ##### todavía no sabemos cómo va a resultar, tiene edo=100 y estado=null;

    ##### Vars enviadas desde componente
    public $proyId;  ### Id del proyecto
    ##### Vars
    public $proy;  ###### Carga toda la tabla del proyecto (con todos sus estados y archivos)
    public $Arechaza, $Amodif,$Aeditor,$Arevisor,$Aautor,$Aautoriza;##### Flag para mostrar o no botones de acción
    public $Bcrear,$Badmin,$Badmin2,$Beditor,$BirApub; ##### Flag para mostrar o no botones de acción
    public $cancha; ##### Nombre del rol activo en cada estado
    public $titulo,$jardin,$tituloId; ##### Datos del proyecto
    public $edit; #### permisos por rol
    public $proyEdo; ##### guarda renglón de proy_estado de próximo estado
    public $proyArchs; #### guarda todos los renglones de archivos de próximo estado
    public $ArchFormato,$ArchSol,$ArchPpal,$ArchMaterial,$NvoComents,$ArchRevision; ### formulario
    public $NuevoEditor; ##### forumlario
    /*####################################################
    ###### Para ejecutarse, requiere de la función:
    public function AbrirModalProyecto($proyid){
        #####<livewire:sistema.modal-proyecto-component />
        $datos=[
            'proyId'=>$proyid,   ### proy_id o 0 para nuevo
        ];
        $this->dispatch('AbreModalProyecto',$datos);
    }
   ####################################################*/
    public function mount(){
        $this->proyId='0';
        $this->proy=collect();
        $this->proyEdo=collect();
        $this->proyArchs=collect();
        $this->cancha='';
        $this->NuevoEditor ='';
    }

    #[On('AbreModalProyecto')]
    public function MontandoElModal($data){
        ##### Carga el id desde componente que dispara
        $this->proyId=$data['proyId'];

        ##### Si tiene id, carga los datos del proyeto
        if($this->proyId > '0'){
            ##### Carga datos del proyecto y todos sus estados y archivos
            $this->proy=proy_proyectos::where('proy_id',$this->proyId)
                ->with('estados')
                ->with('archivos')
                ->with('autor1')
                ->with('autor2')
                ->with('autor3')
                ->with('editor')
                ->with('admin')
                ->first();
            #### Carga título en texto
            $this->tituloId=$this->proy->proy_jardin.'_'.str_pad($this->proy->proy_id, 4,"0",STR_PAD_LEFT);
        }
    }

    public function LimpiarModal(){
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset(['titulo','jardin','tituloId','proyEdo', 'proyArchs']);
    }

    public function CerrarModalProyecto(){
        $this->LimpiarModal();
        $this->dispatch('CierraModalProyecto');
    }

    public function CrearProyecto(){
        ###############################################################
        ##### Crea proyecto actual (act=1) y próximo (act=2 y edo=100)
        ###############################################################
        ##### Valida cuestionario
        $this->validate([
            'titulo'=>'required',
            'jardin'=>'required',
        ]);
        ##### Verifica que no exista
        $busca=proy_proyectos::where('proy_titulo',$this->titulo)
            ->where('proy_jardin',$this->jardin)
            ->where('proy_del','0')
            ->count();
        ##### Si existe, manda error
        if($busca > '0'){
            $this->addError('titulo','Ya existe un proyecto con este título');
            return;
        }
        ##### Crea Proyecto en BD
        $proy=proy_proyectos::create([
            'proy_titulo'=>$this->titulo,
            'proy_jardin'=>$this->jardin,
            'proy_autor1'=>Auth::user()->id,
        ]);
        ##### Crea estado actual
        proy_estado::create([
            'predo_proyid'=>$proy->proy_id,
            'predo_edo'=>'0.1',
            'predo_estado'=>'Proyecto creado',
        ]);
        ##### Crea estado futuro
        proy_estado::create([
            'predo_proyid'=>$proy->proy_id,
            'predo_act'=>'2', #### Indica que es futuro
            'predo_edo'=>'100',
            'predo_estado'=>null,
        ]);

        ##### Vuelve a cargar variables en pantalla
        $this->MontandoElModal(['proyId'=>$proy->proy_id]);

        ##### Crea Carpeta de archivos
        Storage::makeDirectory('/public/proyectos/'.$this->tituloId);

        #######################################################
        ################################ Envía mensajes a buzón
        #### Detecta administrdores:
        $admins=UserRolesModel::where('rol_crolrol','admin')
            ->where(function($q){
                return $q
                ->where('rol_cjarsiglas','todos')
                ->orWhere('rol_cjarsiglas',$this->proy->proy_jardin);
            })
            ->where('rol_act','1')
            ->where('rol_del','0')
            ->select('rol_usrid')
            ->distinct('rol_usrid')
            ->pluck('rol_usrid')
            ->toArray();

        ###### Detecta si el usuario solicitante tiene rol de autor:
        $rolDeAutor=UserRolesModel::where('rol_crolrol','autor')
            ->where(function($q){
                    return $q
                    ->where('rol_cjarsiglas','todos')
                    ->orWhere('rol_cjarsiglas',$this->proy->proy_jardin);
                })
            ->where('rol_usrid',Auth::user()->id)
            ->where('rol_act','1')
            ->where('rol_del','0')
            ->count();
        if($rolDeAutor < '1'){##############################################################################################################
        ################################ Envía mensajes a buzón
        #### Detecta administrdores:
        $admins=UserRolesModel::where('rol_crolrol','admin')
            ->where(function($q){
                return $q
                ->where('rol_cjarsiglas','todos')
                ->orWhere('rol_cjarsiglas',$this->proy->proy_jardin);
            })
            ->where('rol_act','1')
            ->where('rol_del','0')
            ->select('rol_usrid')
            ->distinct('rol_usrid')
            ->pluck('rol_usrid')
            ->toArray();

        ###### Detecta si el usuario solicitante tiene rol de autor:
        $rolDeAutor=UserRolesModel::where('rol_crolrol','autor')
            ->where(function($q){
                    return $q
                    ->where('rol_cjarsiglas','todos')
                    ->orWhere('rol_cjarsiglas',$this->proy->proy_jardin);
                })
            ->where('rol_usrid',Auth::user()->id)
            ->where('rol_act','1')
            ->where('rol_del','0')
            ->count();
        if($rolDeAutor < '1'){
            ##### Si el creador no cuenta con el rol de autor, envía aviso al admin.
            $asunto='Creación de proyecto SIN ROL DE AUTOR';
            $mensaje='El usuario <b style="color:red;"><u>SIN ROL DE AUTOR</u></b> "'.Auth::user()->usrname.'",'.
                ' id "'.Auth::user()->id.'",'.
                ' y correo "'.Auth::user()->email.'"'.
                ' generó un nuevo proyecto en Las Cédulas del Jardín: <b>'.$this->tituloId.': '.$this->proy->proy_titulo.'</b>'.
                ' pero no cuenta con el rol de autor en el jardín solicitado.<br>'.
                ' No va a poder enviarte su proyecto hasta que le des el rol de <b>autor</b><br>'.
                ' Haz clic aquí para <a href="'.url('/home').'#'.$this->tituloId.'">ver el proyecto</a>'.
                ' y aquí para <a href="'.url('/admin_usuarios').'">otorgar el rol</a>.';


            ##### Envía correos a administradores de creación
            foreach($admins as $a){
                EnviaMensajeAbuzon(
                    $a,  #'to'=>$a,         ### id usr del destinatario
                    '0', #'from'=>'0',       ### id usr del remitente o 0 para sistema
                    $asunto, #'asunto'=>$asunto,     ### texto del asunto
                    $mensaje, #'mensaje'=> ,     ### <html> del mensaje
                    '', #'notas'=>'',      ### <html> de las notas
                    '0' #'ifReply=>'''     ### msj_id del mensaje al que se responde (o 0 para mensaje nuevo)
                );
            }
        }
        ################################ Envía mensajes a buzón
        #### Detecta administrdores:
        $admins=UserRolesModel::where('rol_crolrol','admin')
            ->where(function($q){
                return $q
                ->where('rol_cjarsiglas','todos')
                ->orWhere('rol_cjarsiglas',$this->proy->proy_jardin);
            })
            ->where('rol_act','1')
            ->where('rol_del','0')
            ->select('rol_usrid')
            ->distinct('rol_usrid')
            ->pluck('rol_usrid')
            ->toArray();

        ###### Detecta si el usuario solicitante tiene rol de autor:
        $rolDeAutor=UserRolesModel::where('rol_crolrol','autor')
            ->where(function($q){
                    return $q
                    ->where('rol_cjarsiglas','todos')
                    ->orWhere('rol_cjarsiglas',$this->proy->proy_jardin);
                })
            ->where('rol_usrid',Auth::user()->id)
            ->where('rol_act','1')
            ->where('rol_del','0')
            ->count();
        if($rolDeAutor < '1'){
            ##### Si el creador no cuenta con el rol de autor, envía aviso al admin.
            $asunto='Creación de proyecto SIN ROL DE AUTOR';
            $mensaje='El usuario <b style="color:red;"><u>SIN ROL DE AUTOR</u></b> "'.Auth::user()->usrname.'",'.
                ' id "'.Auth::user()->id.'",'.
                ' y correo "'.Auth::user()->email.'"'.
                ' generó un nuevo proyecto en Las Cédulas del Jardín: <b>'.$this->tituloId.': '.$this->proy->proy_titulo.'</b>'.
                ' pero no cuenta con el rol de autor en el jardín solicitado.<br>'.
                ' No va a poder enviarte su proyecto hasta que le des el rol de <b>autor</b><br>'.
                ' Haz clic aquí para <a href="'.url('/home').'#'.$this->tituloId.'">ver el proyecto</a>'.
                ' y aquí para <a href="'.url('/admin_usuarios').'">otorgar el rol</a>.';


            ##### Envía correos a administradores de creación
            foreach($admins as $a){
                EnviaMensajeAbuzon(
                    $a,  #'to'=>$a,         ### id usr del destinatario
                    '0', #'from'=>'0',       ### id usr del remitente o 0 para sistema
                    $asunto, #'asunto'=>$asunto,     ### texto del asunto
                    $mensaje, #'mensaje'=> ,     ### <html> del mensaje
                    '', #'notas'=>'',      ### <html> de las notas
                    '0' #'ifReply=>'''     ### msj_id del mensaje al que se responde (o 0 para mensaje nuevo)
                );
            }
        }
            ##### Si el creador no cuenta con el rol de autor, envía aviso al admin.
            $asunto='Creación de proyecto SIN ROL DE AUTOR';
            $mensaje='El usuario <b style="color:red;"><u>SIN ROL DE AUTOR</u></b> "'.Auth::user()->usrname.'",'.
                ' id "'.Auth::user()->id.'",'.
                ' y correo "'.Auth::user()->email.'"'.
                ' generó un nuevo proyecto en Las Cédulas del Jardín: <b>'.$this->tituloId.': '.$this->proy->proy_titulo.'</b>'.
                ' pero no cuenta con el rol de autor en el jardín solicitado.<br>'.
                ' No va a poder enviarte su proyecto hasta que le des el rol de <b>autor</b><br>'.
                ' Haz clic aquí para <a href="'.url('/home').'#'.$this->tituloId.'">ver el proyecto</a>'.
                ' y aquí para <a href="'.url('/admin_usuarios').'">otorgar el rol</a>.';

            ##### Envía correos a administradores de creación
            foreach($admins as $a){
                EnviaMensajeAbuzon(
                    $a,  #'to'=>$a,         ### id usr del destinatario
                    '0', #'from'=>'0',       ### id usr del remitente o 0 para sistema
                    $asunto, #'asunto'=>$asunto,     ### texto del asunto
                    $mensaje, #'mensaje'=> ,     ### <html> del mensaje
                    '', #'notas'=>'',      ### <html> de las notas
                    '0' #'ifReply=>'''     ### msj_id del mensaje al que se responde (o 0 para mensaje nuevo)
                );
            }
        }
    }

    public function SubirArchivo($tipo){
        ###### Guarda ruta de archivos
        $ruta='/proyectos/'.$this->tituloId.'/';

        ####### Determina variables según tipo de archivo
        if($tipo=='Formato'){
            $nombreUsr=$this->ArchFormato->getClientOriginalName();
            $nombre="01".$tipo."_".$this->tituloId.'_'.date('Y-m-d').": ".date('His').".".$this->ArchFormato->getClientOriginalExtension();
            $this->ArchFormato->storeAs(path:'/public/'.$ruta.'/', name:$nombre);
            $this->ArchFormato='';
        }elseif($tipo=='Solicitud'){
            $nombreUsr=$this->ArchSol->getClientOriginalName();
            $nombre="02".$tipo."_".$this->tituloId.'_'.date('Y-m-d').":".date('His').".".$this->ArchSol->getClientOriginalExtension();
            $this->ArchSol->storeAs(path:'/public/'.$ruta.'/', name:$nombre);
            $this->ArchSol='';
        }elseif($tipo=='Principal'){
            $nombreUsr=$this->ArchPpal->getClientOriginalName();
            $nombre="03".$tipo."_".$this->tituloId.'_'.date('Y-m-d').":".date('His').".".$this->ArchPpal->getClientOriginalExtension();
            $this->ArchPpal->storeAs(path:'/public/'.$ruta.'/', name:$nombre);
            $this->ArchPpal='';
        }elseif($tipo=='Material'){
            $nombreUsr=$this->ArchMaterial->getClientOriginalName();
            $nombre="04".$tipo."_".$this->tituloId.'_'.date('Y-m-d').":".date('His').".".$this->ArchMaterial->getClientOriginalExtension();
            $this->ArchMaterial->storeAs(path:'/public/'.$ruta.'/', name:$nombre);
            $this->ArchMaterial='';
        }elseif($tipo=='Revision'){
            $nombreUsr=$this->ArchRevision->getClientOriginalName();
            $nombre="05.".$this->proyEdo->predo_id.$tipo."_".$this->tituloId.'_'.date('Y-m-d').":".date('His').".".$this->ArchRevision->getClientOriginalExtension();
            $this->ArchRevision->storeAs(path:'/public/'.$ruta.'/', name:$nombre);
            $this->ArchRevision='';
        }



        proy_archivos::create([
            'prmat_proyid'=>$this->proy->proy_id,
            'prmat_predoid'=>$this->proy->estados->where('predo_act','2')->where('predo_del','0')->value('predo_id'),
            'prmat_archivo'=>$ruta.$nombre,
            // 'prmat_nombrearch'=>$nombreUsr,
            'prmat_nombrearch'=>$nombre,
            'prmat_tipo'=>$tipo,
            'prmat_usr'=>Auth::user()->id,
            'prmat_comentario'=>null,
        ]);

    }

    public function EliminarArchivo($id){
        proy_archivos::where('prmat_id',$id)->update([
            'prmat_del'=>'1',
        ]);
        $arch=proy_archivos::where('prmat_id',$id)->value('prmat_archivo');
        Storage::delete('/public'.$arch);
    }

    public function CambiaEstado($NvoEdo){
        ###### Carga el Texto de título de cada estado
        if($NvoEdo=='0.2'){
            $texto='En revisión por administrador';
            $ProxRol='admin';
        }elseif($NvoEdo=='0.3'){
            $texto='Proyecto rechazado';
            $ProxRol='autor';
        }elseif($NvoEdo=='0.4'){
            $texto='En revisión por el autor';
            $ProxRol='autor';
        }elseif($NvoEdo=='0.5'){
            $texto='Revisión por administrador';
            $ProxRol='admin';
        }elseif($NvoEdo=='1.0'){
            $this->validate(['NuevoEditor'=>'required']); ### Valida al editor
            $texto='Editor asignando revisores';
            $ProxRol='editor';

        }elseif($NvoEdo=='1.1'){
            $texto='En revisión por el autor';
            $ProxRol='autor';
        }elseif($NvoEdo=='1.2'){
            $texto='En revisión por el editor';
            $ProxRol='editor';
        }elseif($NvoEdo=='2.0'){
            $texto='En proceso de publicación';
            $ProxRol='autor';
        }

        ##### Pasa estado actual a inactivo
        proy_estado::where('predo_del','0')
            ->where('predo_proyid',$this->proy->proy_id)
            ->where('predo_act','1')
            ->update([
                'predo_act'=>'0',
            ])
            ;

        ##### Pasa estado futuro a actual
        proy_estado::where('predo_del','0')
            ->where('predo_proyid',$this->proy->proy_id)
            ->where('predo_act','2')
            ->update([
                'predo_act'=>'1',
                'predo_edo'=>$NvoEdo,
                'predo_estado'=>$texto,
                'predo_comentario'=>$this->NvoComents,
            ]);

        ##### Crea nuevo estado futuro
        proy_estado::create([
            'predo_proyid'=>$this->proy->proy_id,
            'predo_act'=>'2', #### Indica que es futuro
            'predo_edo'=>'100',
            'predo_estado'=>null,
        ]);

        ##### Asigna al administrador
        if($NvoEdo=='0.3' OR $NvoEdo=='0.4' OR $NvoEdo=='1.0'){
            proy_proyectos::where('proy_id',$this->proyId)->update([
                'proy_admin'=>Auth::user()->id,
            ]);
        }
        ##### Asigna al editor
        if($NvoEdo=='1.0'){
            proy_proyectos::where('proy_id',$this->proyId)->update([
                'proy_editor'=>$this->NuevoEditor,
            ]);
        }
        #######################################################
        ################################ Envía mensajes a buzón
        #### Detecta destinatarios según paso
        $destino=[];
        if($ProxRol=='autor'){
            $destino[]= proy_proyectos::where('proy_id',$this->proyId)->value('proy_autor1');
            $destino[]= proy_proyectos::where('proy_id',$this->proyId)->value('proy_autor2');
            $destino[]= proy_proyectos::where('proy_id',$this->proyId)->value('proy_autor3');
        }elseif($ProxRol=='editor'){
            $destino[]= proy_proyectos::where('proy_id',$this->proyId)->value('proy_editor');
        }elseif($ProxRol=='admin'){
            $destino[]=proy_proyectos::where('proy_id',$this->proyId)->value('proy_admin');

            ##### Si aún no se ha determinado, busca admin  gral.
            if($destino[0]==null  OR $destino[0]==''){
                $destino=UserRolesModel::where('rol_crolrol','admin')
                    ->where(function($q){
                        return $q
                        ->where('rol_cjarsiglas','todos')
                        ->orWhere('rol_cjarsiglas',$this->proy->proy_jardin);
                    })
                    ->where('rol_act','1')
                    ->where('rol_del','0')
                    ->select('rol_usrid')
                    ->distinct('rol_usrid')
                    ->pluck('rol_usrid')
                    ->toArray();
            }
        }
        #dd($destino);
        if($NvoEdo == '0.2'){
            #### Si se trata de un rechazo, pon este mensaje
            $asunto='Nuevo anteproyecto '.$this->tituloId;
            $mensaje='Un usuario envía al administrador, el NUEVO PROYECTO <b>'.$this->tituloId.': '.$this->proy->proy_titulo.'</b>'.
                ' para su primer revisión de cumplimiento de norma editorial de'.
                ' <a href="'.url('/').'">Las cédulas del Jardín</a>.<br>'.
                ' Haz clic aquí para <a href="'.url('/home').'#'.$this->tituloId.'">ver el proyecto '.$this->tituloId.'</a>';

        }elseif($NvoEdo =='0.3' OR $NvoEdo =='0.4'){
            #### Si se trata de un rechazo, o de solicitud de corrección por el admin,, pon este mensaje
            $asunto='Observaciones al anteproyecto '.$this->tituloId;
            $mensaje='El administrador del portal <a href="'.url('/').'">Las Cédulas del Jardín</a> revisó el '.
                ' cumplimiento de la norma editorial del '.
                ' anteproyecto <b>'.$this->tituloId.': '.$this->proy->proy_titulo.'</b>'.
                ' que ingresaste y tiene observaciones que debes atender.<br>'.
                ' Para ver las observaciones haz clic aquí <a href="'.url('/home').'#'.$this->tituloId.'">ver el proyecto '.$this->tituloId.'</a>';
        }elseif($NvoEdo =='1.0'){
            #### Revisiones de editor al usuario
            $asunto='Designación como Editor de '.$this->tituloId;
            $mensaje='Fuiste asignado como <b>editor</b> '.
                ' del proyecto <b>'.$this->tituloId.': '.$this->proy->proy_titulo.'</b>'.
                ' en <a href="'.url('/').'">Las Cédulas del Jardín</a>.<br>'.
                ' Debes revisar el proyecto, escoger a uno o dos revisores externos y '.
                ' enviarles el proyecto para robustecer el documento. Luego envía las observaciones al autor.<br>'.
                ' Para ver los documentos haz clic aquí <a href="'.url('/home').'#'.$this->tituloId.'">ver el proyecto '.$this->tituloId.'</a>';
        }elseif($NvoEdo =='1.1'){
            #### Revisiones de editor al usuario
            $asunto='Observaciones al proyecto '.$this->tituloId;
            $mensaje='El editor asignado de "Las Cédulas del Jardín", y/o los revisores externos, tienen observaciones al '.
                ' proyecto <b>'.$this->tituloId.': '.$this->proy->proy_titulo.'</b>'.
                ' que ingresaste al portal y que debes atender.<br>'.
                ' Para ver las observaciones haz clic aquí <a href="'.url('/home').'#'.$this->tituloId.'">ver el proyecto '.$this->tituloId.'</a>';
        }elseif($NvoEdo =='2.0'){
            #### Fonalización de proceso de publicación
            $asunto='Se inicia el proceso de publicación del proyecto '.$this->tituloId;
            $mensaje='El editor asignado de "Las Cédulas del Jardín", acaba de aprobar el '.
                ' proyecto <b>'.$this->tituloId.': '.$this->proy->proy_titulo.'</b>'.
                ' que ingresaste al portal. Ahora estamos listos para iniciar el proceso de publicación.<br>'.
                ' a partir de este momento, el seguimiento del proyecto es en la sección "administrador de cédulas" (Menú Cédulas->Administrar)'.
                ' Para ver el proceso de publicación, haz clic aquí <a href="'.url('/admin_cedulas').'">ver administrador de publicaciones</a>.';
        }else{
            ##### Si no es un rechazo, pon este mensaje
            $asunto='Te envían proyecto '.$this->tituloId.' para revisar como '.$ProxRol;
            $mensaje='Te envían observaciones al proyecto de publicación <b>'.$this->tituloId.': '.$this->proy->proy_titulo.'</b>'.
                ' para que lo revises como <b>'.$ProxRol. '</b> de la plataforma '.
                ' <a href="'.url('/').'">Las cédulas del Jardín</a>.<br>'.
                ' Haz clic aquí para <a href="'.url('/home').'#'.$this->tituloId.'">ver el proyecto '.$this->tituloId.'</a>';

        }

        ##### Envía correos a administradores de creación
        foreach($destino as $a){
            EnviaMensajeAbuzon(
                $a,  #'to'=>$a,         ### id usr del destinatario
                '0', #'from'=>'0',       ### id usr del remitente o 0 para sistema
                $asunto, #'asunto'=>$asunto,     ### texto del asunto
                $mensaje, #'mensaje'=> ,     ### <html> del mensaje
                '', #'notas'=>'',      ### <html> de las notas
                '0' #'ifReply=>'''     ### msj_id del mensaje al que se responde (o 0 para mensaje nuevo)
            );
        }

        $this->CerrarModalProyecto();
        ##### Si se aprueba, abre modal
        if($NvoEdo=='2.0'){
            ##### Prepara y abre le Modal de crear cédula
            $extra=[
                'jardin'=>$this->proy->proy_jardin,
                'titulo'=>'Gran título',
            ];
            $data=['idCed'=>'0', 'jardin'=>$this->proy->jardin, 'extra'=>$extra];
            $this->dispatch('AbreModalDeCedula',$data);
        }
    }

    public function BorrarAutorProyecto($proyId,$tipoAutor){
        dd('en construcción');
    }

    public function AgregarAutorProyecto($proyId){
        dd('en construcción');
    }

    public function EliminarProyecto(){
        proy_proyectos::where('proy_id',$this->proyId)->update([
            'proy_del'=>'1',
        ]);
        redirect('/home');
    }

    public function ArchivarProyecto(){
        $valor=proy_proyectos::where('proy_id',$this->proyId)->value('proy_act');
        if($valor=='1'){$nuevo='0';}else{$nuevo='1';}
        proy_proyectos::where('proy_id',$this->proyId)->update([
            'proy_act'=>$nuevo,
        ]);
        $this->dispatch('AvisoExitoProyecto',msj:'El proyecto fue archivado. Puedes desarchivarlo cuando gustes');
        redirect('/home');
    }

    public function render(){
        ##### Carga línea de estado futuro
        if($this->proyId > '0'){
            $this->proyEdo=$this->proy
                ->estados
                ->where('predo_act','2')
                ->first();

            ####Carga tabla de archivos del estado futuro
            $this->proyArchs=proy_archivos::where('prmat_predoid',$this->proyEdo->predo_id)
                ->where('prmat_del','0')
                ->get();
        }

        ####### Resetea botones de acción
        $this->Arechaza= $this->Amodif= $this->Aeditor='none';
        $this->Arevisor= $this->Aautor= $this->Aautoriza='none';
        $this->Bcrear= $this->Badmin= $this->Badmin2= $this->Beditor= $this->BirApub='none';

        ####### Verifica botones según cada estado
        if($this->proyId == '0'){
            $this->Bcrear='inline-block';
            $this->cancha="autor";
        }elseif($this->proyId > '0'){
            $edoActual=$this->proy->estados->where('predo_act','1')->value('predo_edo');
            if($edoActual == '0.0'){
                $this->Bcrear='inline-block';
                $this->cancha="autor";
            }elseif($edoActual == '0.1'){
                $this->Badmin='inline-block';
                $this->cancha="autor";
            }elseif($edoActual == '0.2'){
                $this->Arechaza='inline-block';
                $this->Amodif='inline-block';
                $this->Aeditor='inline-block';
                $this->cancha="admin";
            }elseif($edoActual == '0.3'){
                $this->cancha="admin";
            }elseif($edoActual == '0.4'){
                $this->Badmin2='inline-block';
                $this->cancha="autor";
            }elseif($edoActual == '0.5'){
                $this->Amodif = 'inline-block';
                $this->Aeditor = 'inline-block';
                $this->cancha="admin";
            }elseif($edoActual == '1.0'){
                $this->Aautor='inline-block';
                $this->Aautoriza = 'inline-block';
                $this->cancha="editor";
            }elseif($edoActual == '1.1'){
                $this->Beditor = 'inline-block';
                $this->cancha="autor";
            }elseif($edoActual == '1.2'){
                $this->Aautor = 'inline-block';
                $this->Aautoriza = 'inline-block';
                $this->cancha="editor";
            }elseif($edoActual == '2.0'){
                $this->BirApub = 'inline-block';
                $this->cancha="editor";
            }
        }
        $this->edit='0';
        ###### Revisa si se tiene permiso según el rol
        if(in_array($this->cancha, session('rol'))){
            $this->edit='1';
        }
        if($this->proyId=='0' OR $this->proy->estados->where('predo_act','1')->value('predo_edo') <= '0.1'){
            $this->edit='1';
        }

        ###### Reenvía variables $proyectos a home (para que se actualce)
        if(session('rol')){
            if(array_intersect(['admin'],session('rol'))){
                $proyectos=proy_proyectos::where('proy_del','0')
                    ->with('estados')
                    ->with('archivos')
                    ->with('autor1')
                    ->with('autor2')
                    ->with('autor3')
                    ->with('editor')
                    ->with('admin')
                    ->get();
            // }elseif(array_intersect(['editor','admin','autor','traductor'],session('rol'))){
            }else{
                $proyectos=proy_proyectos::where('proy_del','0')
                    ->where(function($q){
                        return $q
                        ->where('proy_autor1',Auth::user()->id)
                        ->orWhere('proy_autor2',Auth::user()->id)
                        ->orWhere('proy_autor3',Auth::user()->id)
                        ->orWhere('proy_admin',Auth::user()->id)
                        ->orWhere('proy_editor',Auth::user()->id);
                    })
                    ->with('estados')
                    ->with('archivos')
                    ->with('autor1')
                    ->with('autor2')
                    ->with('autor3')
                    ->with('editor')
                    ->with('admin')
                    ->get();
            }
            $this->dispatch('RecibeVariablesEnHome',$proyectos);

        }else{
            $proyectos=collect();
        }

        ####### Genera listado de editores para seleccionar en menú:
        if($this->proyId > '0'){
            $editores=UserRolesModel::where('rol_crolrol','editor')
                ->where(function($q){
                    return $q
                    ->where('rol_cjarsiglas','todos')
                    ->orWhere('rol_cjarsiglas',$this->proy->proy_jardin);
                })
                ->where('rol_act','1')
                ->where('rol_del','0')
                ->leftJoin('users','rol_usrid','=','id')
                ->select(['rol_usrid','rol_cjarsiglas','rol_crolrol','nombre','apellido'])
                ->orderBy('nombre')
                ->get();
        }else{
            $editores=collect();
        }

        return view('livewire.sistema.modal-proyecto-componenet',[
            'jardines'=>CatJardinesModel::where('cjar_act','1')->where('cjar_del','0')->get(),
            'editores'=>$editores,
        ]);
    }
}
