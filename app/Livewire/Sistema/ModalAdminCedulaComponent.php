<?php

namespace App\Livewire\Sistema;

use App\Models\cat_tipocedula;
use App\Models\cedulas_url;
use App\Models\ced_autores;
use App\Models\ced_sp;
use App\Models\ced_alias;
use App\Models\ced_ubica;
use App\Models\ced_usos;
use App\Models\cedulas_txt;
use App\Models\lenguas;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalAdminCedulaComponent extends Component
{
    /*############################################################
    ##### Este modal muestra opciones para crear o editar los metadatos de
    ##### una cédula. Para ejecutarse desde un componente externo, requiere las
    ##### variables id y jardin (id= Id de la cédula o 0 para nueva; jardin=siglas
    ##### del jardín al que pertenece).
    public function AbreModalCedula($id,$jardin){
        $data=['idCed'=>$id, 'jardin'=>$jardin];
        $this->dispatch('AbreModalDeCedula',$data);
    }
    ##############################################################*/

    ##### Vars. recibidas desde modal disparador
    public $jardinSel;
    ##### vars. del modal Edición de ćedula
    public $cedulaId, $origtrad, $copiade, $tipoCedula, $lengua;
    public $url, $titulo, $tituloOrig, $resumen, $resumenOrig, $act;
    public $CedAutores, $CedEditores, $CedTraductores,$CedSp, $CedUsos, $CedUbica, $CedAlias;
    public $verTituloOrig, $verResumenOrig, $verAutor, $verEditor, $verTraductor, $verUbicacion, $verAlias, $verSp, $verUso;

    #[On('AbreModalDeCedula')]
    public function AbriendoModalCedula($datos){
        // $this->LimpiaModal();
        $this->jardinSel=$datos['jardin'];
        $id=$datos['idCed'];

        ##### Carga variables del usuario
        $this->cedulaId=$id;
        if($id > '0'){
            ##### Lee el campo
            $dato=cedulas_url::where('url_id',$this->cedulaId)
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
            $this->tituloOrig=$dato->url_tituloorig;
            $this->resumen=$dato->url_resumen;
            $this->resumenOrig=$dato->url_resumenorig;
            // $this->CedAutores=$dato->autores;
        }else{
            // $this->CedAutores=collect();
            $this->LimpiaModal();
        }
    }

    public function mount(){
        $this->jardinSel='';
        $this->origtrad='original';
        $this->verAutor='1'; $this->verEditor='1'; $this->verTraductor='1';
        $this->verUbicacion='0'; $this->verAlias='0'; $this->verSp='0'; $this->verUso='0';
        $this->verTituloOrig='0'; $this->verResumenOrig='0';
    }

    public function LimpiaModal(){
        $this->reset('origtrad', 'copiade', 'tipoCedula', 'lengua', 'url', 'titulo', 'tituloOrig', 'resumen', 'resumenOrig', 'act');
        $this->reset(['verAutor', 'verEditor', 'verTraductor', 'verUbicacion', 'verAlias', 'verSp', 'verUso']);
        // $this->act=FALSE;
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function CierraModalCedula(){
        $this->LimpiaModal();
        $this->dispatch('CierraModalDeCedula',reload:1);
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
        ##### en caso de copias, copia alias, ubicaciones yel contenido de la página,
        if($this->origtrad=='traducción'){
            ###OJO::: copiar: texto, copiar alias, y copiar ubicaciones de original
        //     $original=cedulas_txt::where('ced_urlid',$this->copiade)
        //         ->where('ced_act','1')->where('ced_del','0')
        //         ->get();
        //     foreach($original as $or){
        //         $copia= $or->replicate();
        //         $copia->ced_urljid = $id;
        //         $copia->ced_txtoriginal = $or->ced_txt;
        //         $copia->save();
        //     }
        }
        $this->CierraModalCedula();
    }

    public function AbreModalDeBuscarAutor($tipo){
        if($tipo=='Autor'){$this->verAutor='1';}
        elseif($tipo=='Editor'){$this->verEditor='1';}
        elseif($tipo=='Traductor'){$this->verTraductor='1';}

        $datos=['tipo'=>$tipo, 'cedulaId'=>$this->cedulaId, 'jardinSel'=>$this->jardinSel];
        $this->dispatch('AbreModalDeBuscarAutor',$datos);
    }

    public function AbrirModalDeUbicacion($ubicaId){
        $this->verUbicacion='1';
        $datos=[
            'ubicaId'=>$ubicaId,
            'urlid'=>cedulas_url::where('url_id',$this->cedulaId)->value('url_id'),
        ];
        $this->dispatch('AbreModalAsignaUbicacion',$datos);
    }

    public function BorrarAutor($id,$tipo,$key){
        if($tipo=='Autor'){
            #### Como el autor es el mismo en las copias, asigna autor a todas las url de la key
            ced_autores::where('aut_key',$key)
                ->where('aut_tipo','Autor')
                ->where('aut_cautid',   ced_autores::where('aut_id',$id)->value('aut_cautid'))
                ->update(['aut_del'=>'1']);
            paLog('Se elimina autor de todas las cedulas key '.$key,'ced_autores','varios id');
        }else{
            ced_autores::where('aut_id',$id)->update(['aut_del'=>'1']);
            paLog('Se elimina autor id '.$id.' a cédula '.$this->cedulaId,'ced_autores',$id);
        }
        ######## Recarga variable (para actualizar lista en modal)
        $dato=cedulas_url::where('url_id',$this->cedulaId)
            ->with('autores')
            ->first();
        $this->CedAutores=$dato->autores;
    }

    public function AbrirModalDeBuscarEspecie(){
        $this->verSp='1';
        $datos=[
            'jardin'=>$this->jardinSel,
            'urltxt'=>cedulas_url::where('url_id',$this->cedulaId)->value('url_urltxt'),
        ];
        $this->dispatch('AbreModalDeBuscarEspecie',$datos);
    }

    public function BorrarEspecieDeCedula($id){
        ###### Elimina usos de la especie
        $ja=ced_usos::where('uso_spid',$id)->update(['uso_del'=>'1']);
        if($ja > '0'){
            paLog('Se eliminaron usos de sp id'.$id, 'ced_usos','uno o más');
        }
        ##### Elimina especie
        ced_sp::where('sp_id',$id)->update(['sp_del'=>'1']);
        paLog('Se eliminó una especie','ced_sp',$id);
    }

    public function AbrirModalDeUso($usoId, $spId){
        $this->verUso='1';
        $datos=[
                'usoid'=>$usoId, ### o id del uso
                'spid'=>$spId, ### Id de sp_id de tabla ced_sp
                'jardin'=>$this->jardinSel,
                'urltxt'=>cedulas_url::where('url_id',$this->cedulaId)->value('url_urltxt'),
            ];
        $this->dispatch('AbreModalUsoEnCedula',$datos);
    }

    public function AbrirModalDeAlias($aliasId){
        $this->verAlias='1';
        $datos=[
            'aliasId'=>$aliasId, ### o id del uso
            'urlId'=>$this->cedulaId,
            // 'jardin'=>$this->jardinSel,
            // 'urltxt'=>cedulas_url::where('url_id',$this->cedulaId)->value('url_urltxt'),
        ];

        $this->dispatch('AbreModalAlias',$datos);
    }

    public function VerNoVer($tipo){
        if($this->$tipo=='1'){$this->$tipo='0';}else{$this->$tipo='1';}
    }

    public function EliminarSitioWeb(){
        // dd('fin',$this->cedulaId);
        $del=cedulas_url::where('url_id',$this->cedulaId)
            ->with('autores')
            ->with('editores')
            ->with('traductores')
            ->with('especies')
            ->with('usos')
            ->with('ubicaciones')
            ->with('alias')
            ->first();
        ##### Elimina editores
        foreach($del->editores as $x){
            $a=ced_autores::where('aut_id',$x->aut_id)->update(['aut_del'=>'1']);
            paLog('Se elimina cédula id '.$this->cedulaId.' y sus autores','ced_autores',$x->aut_id);
        }
        ##### Elimina traductores
        foreach($del->traductores as $x){
            $a=ced_autores::where('aut_id',$x->aut_id)->update(['aut_del'=>'1']);
            paLog('Se elimina cédula id '.$this->cedulaId.' y sus traductores','ced_autores',$x->aut_id);
        }
        ##### Elimina especies
        foreach($del->especies as $x){
            $a=ced_sp::where('sp_id',$x->sp_id)->update(['sp_del'=>'1']);
            paLog('Se elimina cédula id '.$this->cedulaId.' y sus especies','ced_sp',$x->sp_id);
        }
        ##### Elimina usos
        foreach($del->usos as $x){
            $a=ced_usos::where('uso_id',$x->uso_id)->update(['uso_del'=>'1']);
            paLog('Se elimina cédula id '.$this->cedulaId.' y sus usos','ced_usos',$x->uso_id);
        }
        ##### Elimina ubicaciones
        foreach($del->ubicaciones as $x){
            $a=ced_ubica::where('ubi_id',$x->ubi_id)->update(['ubi_del'=>'1']);
            paLog('Se elimina cédula id '.$this->cedulaId.' y sus ubicaciones','ced_ubica',$x->ubi_id);
        }
        ##### Elimina alias
        foreach($del->alias as $x){
            $a=ced_alias::where('ali_id',$x->ali_id)->update(['ali_del'=>'1']);
            paLog('Se elimina cédula id '.$this->cedulaId.' y sus alias','ced_alias',$x->ali_id);
        }

        ##### Elimina textos
        cedulas_txt::where('txt_cjarsiglas',$del->url_cjarsiglas)
            ->where('txt_urlurl', $del->url_url)
            ->update(['txt_del'=>'1']);
        paLog('Se elimina cédula id '.$this->cedulaId.' y todos sus textos','cedulas_txt','varios id');

        ##### Elimina cédula
        cedulas_url::where('url_id',$this->cedulaId)->update(['url_del'=>'1']);
        paLog('Se elimina la cédula id '.$this->cedulaId, 'cedulas_url',$this->cedulaId);

        ###### Mensaje
        $this->dispatch('AvisoExitoCedula',msj:'Se elimino la cédula y todos sos datos');
        ###### Redirecciona
        redirect('/admin_cedulas');
    }

    public function render() {
        ##### Obtiene total de url's originales (para el menú de copiar desde original)
        $CedsOriginales= cedulas_url::where('url_cjarsiglas','ilike',$this->jardinSel)
            ->where('url_tradid', '0')
            ->where('url_del','0')
            ->orderBy('url_tradid','asc')
            ->orderBy('url_id','asc')
            ->get();

        ##### Obtiene lista de autores de la cédula
        if($this->cedulaId > '0'){
            $dato=cedulas_url::where('url_id',$this->cedulaId)
                ->with('autores')
                ->with('editores')
                ->with('traductores')
                ->with('especies')
                ->with('usos')
                ->with('ubicaciones')
                ->with('alias')
                ->first();

            $this->CedAutores=$dato->autores;
            $this->CedEditores=$dato->editores;
            $this->CedTraductores=$dato->traductores;
            $this->CedSp=$dato->especies;
            $this->CedUsos=$dato->usos;
            $this->CedUbica=$dato->ubicaciones;
            $this->CedAlias=$dato->alias;
        }else{
            $this->CedAutores=collect();
            $this->CedEditores=collect();
            $this->CedTraductores=collect();
            $this->CedSp=collect();
            $this->CedUsos=collect();
            $this->CedUbica=collect();
            $this->CedAlias=collect();
        }


        return view('livewire.sistema.modal-admin-cedula-component',[
            'CedsOriginales'=>$CedsOriginales,
            'lenguas'=>lenguas::orderBy('len_lengua')->get(),  ##### Lista de lenguas del catálogo
            'TiposDeCedula'=>cat_tipocedula::get(),
        ]);
    }
}
