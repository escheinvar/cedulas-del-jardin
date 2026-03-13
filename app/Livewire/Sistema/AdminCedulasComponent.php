<?php

namespace App\Livewire\Sistema;

use App\Models\cat_autores;
use App\Models\cat_tipocedula;
use App\Models\CatJardinesModel;
use App\Models\ced_autores;
use App\Models\cedulas_txt;
use App\Models\cedulas_url;
use App\Models\lenguas;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminCedulasComponent extends Component
{
    public $edit, $editjar; ##### Variables de permisos del usuario
    public $jardinSel, $BuscaLengua, $BuscaEstado, $BuscaTexto, $sentido, $orden, $edoEdit, $abiertos; ##### Vars de formulario de búsqueda y de tabla
    ##### vars. del modal Edición de ćedula
    public $cedulaId, $origtrad, $copiade, $tipoCedula, $lengua, $CedAutores;
    public $url, $titulo, $tituloOrig, $resumen, $resumenOrig, $act;
    ##### Vars del modal Buscar Autor:
    public $BuscaAutor_BuscaNombre, $BuscaAutor_BuscaApellido, $BuscaAutor_Posibles;
    public $BuscaAutor_tipo, $BuscaAutor_Ganon, $BuscaAutor_id, $BuscaAutor_name, $BuscaAutor_comunidad;
    public $BuscaAutor_institu, $BuscaAutor_correo, $BuscaAutor_corresponding;


    #################################################################################
    /*##### Inicia con la vista mostrando en $this->urls con el listado de cédulas.
            Cuando se pica en editar, se ejecuta AbreModalCedula(), se guarda
            $this->cedulaId (con Id de la cédula) y se abre el "modal de edición de ćedula".
            Dentro del "Modal de edición de cédula" se puede invocar el "Modal de buscar autor"
            (para determinar autores)
    */

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
        $this->jardinSel='JebOax';
        // $this->orden='_id';
        // $this->sentido='asc';
        $this->origtrad='original';
        ##### del modal busca autor:
        $this->BuscaAutor_Posibles=collect();
        $this->BuscaAutor_BuscaNombre='';
        $this->BuscaAutor_BuscaApellido='';
        $this->BuscaAutor_Ganon=collect();

    }

    public function ordenaTabla(){
        //
    }

    public function CambiaAmodoEdicion($id){
        $edo=cedulas_url::where('url_id',$id)->value('url_edit');
        if($edo=='0'){$nvo='1';}else{$nvo='0';}
        cedulas_url::where('url_id',$id)->update(['url_edit'=>$nvo]);
    }

    public function CambiaEstadoCedula($id,$edo){
        if($edo=='5'){
            dd('lógica de cierre de ciclo: ¿registro año?, ¿es nueva versión?',
            'en lugar de ir aquí, abrir modal de versión donde ve estadísticas y determina versión?');
        }

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

    public function render(){
        ##### Revisa permisos del usuario
        $auts=['editor','admin']; ##### array de roles autorizados a editar
        if(array_intersect($auts,session('rol'))){
            $this->edit='1';

        }else{
            $this->edit='0';
            redirect('/noauth/Solo accede rol '.implode(',',$auts));
        }

        ##### jardines autorizados al usuario (puede incluir "todos")
        $this->editjar = UserRolesModel::where('rol_usrid',Auth::user()->id)
            ->whereIn('rol_crolrol',$auts)
            ->where('rol_act','1')->where('rol_del','0')
            ->distinct('rol_cjarsiglas')
            ->pluck('rol_cjarsiglas')->toArray();

        #### Genera lista de jardines autorizados al usuario (sin palabra "todos")
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

        ##### Obtiene cantidad de cedulas en edición:
        $this->abiertos=cedulas_url::whereIn('url_cjarsiglas', $JardsUsr->pluck('cjar_siglas')->toArray())
            ->where('url_edo','<','5')   ####0:crea, 1:edicion 2:revision, 3:autoriza, 4:publicado 5:publicadoCnSolEdit.
            ->where('url_act','1')->where('url_del','0')
            ->count();

        ##### Obtiene lista de url's accesibles por usuario
        $urls=collect();
        if($this->jardinSel != ''){
            $urls=cedulas_url::query();
            $urls=$urls->where('url_cjarsiglas','ilike',$this->jardinSel);

        }
        ##### Obtiene lista de url's por lengua
        if($this->BuscaLengua != ''){
            $urls=$urls->where('url_lencode',$this->BuscaLengua);
        }

        ##### Obtiene lista de url's por estado
        if($this->BuscaEstado != ''){
            $urls=$urls->where('url_edo',$this->BuscaEstado);
        }

        ##### Obtiene lista de url's por estado
        if($this->BuscaTexto != ''){
            $urls=$urls->where(function($q){
                return $q
                ->where('url_url','ilike', '%'.$this->BuscaTexto.'%')
                ->orWhere('url_titulo','ilike', '%'.$this->BuscaTexto.'%')
                ->orWhere('url_resumen','ilike', '%'.$this->BuscaTexto.'%');
            });
        }

        ### Finaliza búsqueda de url
        $urls=$urls->orderBy('url_cjarsiglas','asc')
                ->orderBy('url_url','asc')
                ->where('url_del','0')
                ->with('jardin')
                ->with('lenguas')
                ->with('autores')
                ->get();

        ##### Obtiene total de url's originales
        $CedsOriginales= cedulas_url::where('url_cjarsiglas','ilike',$this->jardinSel)
            ->where('url_tradid', '0')
            ->where('url_del','0')
            ->orderBy('url_tradid','asc')
            ->orderBy('url_id','asc')
            ->get();

        return view('livewire.sistema.admin-cedulas-component',[
            'JardsDelUsr'=>$JardsUsr,  ##### Lista de siglas de jardines autorizados
            'lenguas'=>lenguas::orderBy('len_lengua')->get(),  ##### Lista de lenguas del catálogo
            'CedsOriginales'=>$CedsOriginales, ##### Lista de cédulas originales (para copiar)
            'TiposDeCedula'=>cat_tipocedula::get(),
            'urls'=>$urls,   ##### Tabla de urls para ver en tabla
            ]);
    }

    ####################################################################
    ####################################### Funciones de Modal de Cédula
    ####################################################################
    public function LimpiaModal(){
        $this->reset('origtrad', 'copiade', 'tipoCedula', 'lengua', 'url', 'titulo', 'tituloOrig', 'resumen', 'resumenOrig', 'act');
        // $this->act=FALSE;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function AbreModalCedula($id,$jardin){ #($tipo,$var){
        $this->LimpiaModal();
        $this->jardinSel=$jardin;

        if($this->edit=='1'){
            ##### Carga variables del usuario
            // $this->tipo=$tipo;
            $this->cedulaId=$id;
            if($id > '0'){
                ##### Lee el campo
                $dato=cedulas_url::where('url_id',$id)
                    ->with('autores')
                    ->first();

                ##### Carga datos
                $this->url=$dato->url_url;
                if($dato->url_act=='1'){$this->act=TRUE;}else{$this->act=FALSE;}
                if($dato->url_tradid=='0'){$this->origtrad='original';}else{$this->origtrad='traducción';}
                if($dato->url_tradid > '0'){$this->copiade=$dato->url_tradid;}
                $this->tipoCedula=$dato->url_ccedtipo;
                $this->lengua=$dato->url_lencode;
                $this->titulo=$dato->url_titulo;
                $this->tituloOrig=$dato->url_tituloOrig;
                $this->resumen=$dato->url_resumen;
                $this->resumenOrig=$dato->url_resumenOrig;
                $this->CedAutores=$dato->autores;

            }else{
                $this->CedAutores=collect();
                $this->LimpiaModal();
            }

            #### Abre modal
            $this->dispatch('AbreModalDeCedula');
        }
    }

    public function CierraModalCedula(){
        $this->LimpiaModal();
        $this->dispatch('CierraModalDeCedula');
    }

    public function DeterminaVariablesDeCopia(){
        if($this->origtrad=='traducción' and $this->copiade != ''){

            $original=cedulas_url::where('url_id',$this->copiade)->first();
            $this->tipoCedula=$original->url_ccedtipo;
            $this->url=$original->url_url.'_'.$this->lengua;
            $this->titulo = $original->url_titulo;
            $this->tituloOrig = $original->url_tituloorig;
            $this->resumen = $original->url_resumen;
            $this->resumenOrig = $original->url_resumenorig;
        }
        if($this->origtrad=="original"){$this->copiade ='';}
    }

    public function ProponUrl(){
        $entra=strtolower(quitarAcentos($this->titulo));
        $entra=preg_replace('/[^A-Za-z0-9-]/', '', $entra);
        $this->url= $entra;
    }

    public function GuardaCedula(){
        #### Valida cuestionario
        $this->validate([
            'origtrad'=>'required',
            'tipoCedula'=>'required',
            'lengua'=>'required',
            'url'=> 'required',
            'titulo'=>'required',

        ]);

        ##### Valida que haya copia
        // if($this->origtrad =='traducción' and $this->cedulaId == '0'){
        if($this->origtrad =='traducción' and $this->cedulaId == '0'){
            $this->validate(['copiade'=>'required']);

            $urltxt=cedulas_url::where('url_id',$this->copiade)->value('url_urltxt');
            $ja=cedulas_url::where('url_cjarsiglas',$this->jardinSel)
                ->where('url_urltxt',$urltxt)
                ->where('url_lencode',$this->lengua)
                ->count();
            if($ja > '0'){$this->addError('lengua','Ya existe una copia en esta lengua');return;}
        }

        #### Valida que no se use nombres reservados o prohibidos
        $tabu=['']; #$tabu=['inicio','autores','cedulas'];
        if($this->cedulaId=='0' and in_array($this->url, $tabu)) {
            $this->addError('url','inicio un nombre reservado y no se puede usar');
            return;
            $this->url='';
        }

        ##### Valida que url no tenga espacios ni ñ ni caracteres
        if(preg_match('/\W/',$this->url)){
            $this->addError('url','Url no puede tener acentos, eñe, espacios ni caracteres');
            return;
        }

        ##### Valida que no exista ya el nombre en el jardín
        $ja=cedulas_url::where('url_cjarsiglas',$this->jardinSel)
            ->where('url_url',$this->url)
            ->where('url_id','!=',$this->cedulaId)
            ->count();
        if($ja > '0'){$this->addError('url','Esta url ya existe en tu jardín');return;}

        // ##### transforma checkboxes y variables
        if($this->act==TRUE){$act='1';}else{$act='0';}
        if($this->origtrad=='original'){
            $trad=0;
            $urltxt=$this->url;
            $titOrig=$this->titulo;
            $resOrig=$this->resumen;
        }else{
            $trad=$this->copiade;
            $urltxt=cedulas_url::where('url_id',$this->copiade)->value('url_url');
            $titOrig=cedulas_url::where('url_id',$this->copiade)->value('url_titulo');
            $resOrig=cedulas_url::where('url_id',$this->copiade)->value('url_resumen');
        }

        // ##### Genera datos
        $datos=[
            'url_act'=>$act,
            'url_ccedtipo'=>$this->tipoCedula,
            'url_cjarsiglas'=>$this->jardinSel,  ### jardin
            'url_urltxt'=>$urltxt,               ### url original
            'url_url'=>$this->url,               ### url ó url_len
            'url_lencode'=>$this->lengua,        #### lengua
            'url_tradid'=>$trad,                 ### id del original (en copia) o 0
            'url_titulo'=>$this->titulo,
            'url_tituloorig'=>$titOrig,
            'url_resumen'=>$this->resumen,
            'url_resumenorig'=>$resOrig,
        ];

        ##### Guarda en Base de datos
        if($this->cedulaId=='0'){
            $ja=cedulas_url::create($datos);
            $id=$ja->urlj_id;
            #### Crea log
            paLog('Genera nueva cédula web ('.$this->url.') de '.$this->jardinSel,'cedulas_url',$id);
        }else{
            cedulas_url::where('url_id',$this->cedulaId)->update($datos);
            $id=$this->cedulaId;
            #### Crea log
            paLog('Edita los datos generales de la cédula ('.$this->url.') de '.$this->jardinSel,'jardin_url',$id);
        }
         ##### en caso de copias, copia el contenido de la página
        // if($this->origtrad=='traducción'){
        //     $original=cedulas_txt::where('ced_urlid',$this->copiade)
        //         ->where('ced_act','1')->where('ced_del','0')
        //         ->get();
        //     foreach($original as $or){
        //         $copia= $or->replicate();
        //         $copia->ced_urljid = $id;
        //         $copia->ced_txtoriginal = $or->ced_txt;
        //         $copia->save();
        //     }
        // }
        $this->CierraModalCedula();
    }

    ########################################################################################
    ################################################# Funciones de Modal de Buscar Autor
    ########################################################################################
    /*  Desde el modal de edición de cédula, se abre el modal con AbremodalDeBuscarAutor().
        Dentro del modal, ejecuta búsqueda con BuscarAutores() que afecta la variable
        $this->BuscaAutor_Posibles (con lista de autores buscados). Si no se encuentra
        ningún autor, se puede ejecutar AbrirModalDeNuevoAutor() para que abra el
        modal externo, pero si se selecciona un autor, se ejecuta ConfirmarDatosDeAutor()
        el cual da valor a $this->Buscar_Autor_Ganon para que se vea el segundo formulario
        de datos de autor.
    #######################################################################################*/

    public function AbreModalDeBuscarAutor($tipo){
        $this->BuscaAutor_tipo=$tipo;
        $this->dispatch('AbreModalDeBuscarAutor');
    }

    public function LimpiaBusqueda1(){
        $this->reset('BuscaAutor_tipo','BuscaAutor_BuscaNombre','BuscaAutor_BuscaApellido','BuscaAutor_Ganon');
    }

    public function LimpiaBusqueda2(){
        // $this->reset('BuscaAutor_Ganon');
        $this->BuscaAutor_Ganon=collect();
    }

    public function CierraModalDeBuscarAutor(){
        $this->LimpiaBusqueda1();
        $this->LimpiaBusqueda2();
        $this->BuscaAutor_Posibles=collect();

        $this->dispatch('CierraModalDeBuscarAutor');
    }

    public function BuscarAutores(){
        $this->LimpiaBusqueda2();

        ##### Genera query de búsqueda
        $busqueda=cat_autores::query();
        $busqueda=$busqueda->where('caut_cjarsiglas',$this->jardinSel)
            ->where('caut_act','1')
            ->where('caut_del','0');

        ###### Busca por nombre
        if($this->BuscaAutor_BuscaNombre != '' ){
            $busqueda=$busqueda->where('caut_nombre','ilike', '%'.$this->BuscaAutor_BuscaNombre.'%');
        }

        ##### Busca por apellidos
        if($this->BuscaAutor_BuscaApellido != ''){
            $busqueda=$busqueda->where(function($q){
                return $q
                ->whereRaw("unaccent(caut_apellido1) ILIKE unaccent(?)", ['%'.$this->BuscaAutor_BuscaApellido.'%'])
                ->orWhereRaw("unaccent(caut_apellido2) ILIKE unaccent(?)", ['%'.$this->BuscaAutor_BuscaApellido.'%']);
            });
        }

        ##### Finaliza búsqueda
        $this->BuscaAutor_Posibles=$busqueda->orderBy('caut_nombre','asc')
            ->orderBy('caut_apellido1','asc')
            ->get();
    }

    public function ConfirmarDatosDeAutor($id){
        ##### Vacía los campos de búsqueda
        $this->BuscaAutor_BuscaNombre='';
        $this->BuscaAutor_BuscaApellido='';

        ##### Obtiene datos del Autor:
        $dato=cat_autores::where('caut_id',$id)->first();
        $this->BuscaAutor_id=$dato->caut_id;
        $this->BuscaAutor_name=$dato->caut_nombreautor;
        $this->BuscaAutor_comunidad= $dato->caut_comunidad;
        $this->BuscaAutor_institu= $dato->caut_institu;
        $this->BuscaAutor_correo= $dato->caut_correo;
        $this->BuscaAutor_Ganon=$dato;
    }

    public function AgregarAutorACedula(){
        ##### Procesa checkbox
        if($this->BuscaAutor_corresponding == TRUE){$corr='1';}else{$corr='0';}
        ##### Genera array de datos:
        $datos=[
            'aut_cautid'=>$this->BuscaAutor_id,
            'aut_urlid'=>$this->cedulaId, #### if id != 0
            'aut_corresponding'=>$corr,
            'aut_name'=>$this->BuscaAutor_name,
            'aut_correo'=>$this->BuscaAutor_correo,
            'aut_institucion'=>$this->BuscaAutor_institu,
            'aut_comunidad'=>$this->BuscaAutor_comunidad,
            'aut_tipo'=>$this->BuscaAutor_tipo,
        ];
        if($this->cedulaId > '0'){
            ###### Si hay id asignado, guarda en BD
            $bla=ced_autores::create($datos);
            $id=$bla->aut_id;
            #### Genera log
            paLog('Se agrega '.$this->BuscaAutor_tipo.' id '.$this->BuscaAutor_id.' a cédula '.$this->cedulaId,'ced_autores',$id);

            ######## Recarga variable (para actualizar lista en modal)
            $dato=cedulas_url::where('url_id',$this->cedulaId)
                ->with('autores')
                ->first();
            $this->CedAutores=$dato->autores;

        }

        ##### Finaliza con mensaje y cierre
        $this->dispatch('AvisoExitoCedula',msj:'Se agregó correctamente el autor');
        $this->dispatch('LimpiaBusqueda1');
        $this->dispatch('LimpiaBusqueda2');
        $this->BuscaAutor_Ganon=collect();
        $this->dispatch('CierraModalDeBuscarAutor');
    }

    public function AbrirModalDeNuevoAutor(){
        ##### Limpia búsqueda
        $this->BuscaAutor_BuscaNombre='';
        $this->BuscaAutor_BuscaApellido='';
        ##### Cierra modal de búsqueda de autores
        $this->dispatch('CierraModalDeBuscarAutor',reload:'0');
        ##### Abre modal para ingresar nuevo autor a catálogo
        $datos=[
            'cautId'=>'0',
            'cjarsiglas'=>$this->jardinSel,
            'reload'=>'0',
        ];
        $this->dispatch('AbreModalDeAutores',$datos);
    }

    public function BorrarAutor($id){
        ced_autores::where('aut_id',$id)->update(['aut_del'=>'1']);
        paLog('Se elimina '.$this->BuscaAutor_tipo.' id '.$this->BuscaAutor_id.' a cédula '.$this->cedulaId,'ced_autores',$id);
        ######## Recarga variable (para actualizar lista en modal)
        $dato=cedulas_url::where('url_id',$this->cedulaId)
            ->with('autores')
            ->first();
        $this->CedAutores=$dato->autores;
    }
}
