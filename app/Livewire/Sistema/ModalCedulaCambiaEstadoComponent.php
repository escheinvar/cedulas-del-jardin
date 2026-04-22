<?php

namespace App\Livewire\Sistema;

use App\Models\cat_autores;
use App\Models\ced_autores;
use App\Models\ced_sp;
use App\Models\ced_version;
use App\Models\cedulas_url;
use App\Models\cedulas_txt;
use App\Models\Imagenes;
use App\Models\UserRolesModel;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use Safe\url;

class ModalCedulaCambiaEstadoComponent extends Component
{
 /*###########################################
    ##### Tabla de cambios de estado:
    edo         Autor   Editor  Administrador
    0crea       1       4       1,5
    1edita      -       2,4     2,5
    2revisa     3       4       1,5
    3edita      -       2,4     2,5
    4autori     -       -       1,2,5
    5publicado  6       6       2,3
    6PideEdit   -       2       1,2,cancela
 #############################################*/

    public $CambiaEdo_ced; #### first() de cedulas_url de esta cédula
    public $CambiaEdo_urlid, $CambiaEdo_urledo; ### valores específicos de cédula
    public $e0, $e1, $e2, $e3, $e4, $e5, $e6; #### flags. para activar o no botones
    public $verPublicar, $verDoi; ### Flags para mostrar o no secciones
    public $ErrorAlert, $NvoDoi, $CambiaEdo_version; #### valores de cuestionario

 /*############################################################
    ##### Este modal muestra opciones para cambio de estado de
    ##### una cédula. Para ejecutarse desde un componente externo, requiere
    ##### el Id de la cédula (url_id)
    public function AbreModalDeCambioDeEstado($id){
         $data=['urlId'=>$id];
        $this->dispatch('AbreModalCambiaEdoCedula',$data);
    }
 ##############################################################*/

    #[On('AbreModalCambiaEdoCedula')]
    public function montarDesdeExterno($data){
        $this->CambiaEdo_urlid=$data['urlId'];
        $this->CambiaEdo_urledo=cedulas_url::where('url_id',$data['urlId'])->value('url_edo');
        $this->CambiaEdo_ced=cedulas_url::where('url_id',$data['urlId'])
            ->with('autores')
            ->with('editores')
            ->with('traductores')
            ->with('ubicaciones')
            ->with('alias')
            ->with('especies')
            ->with('usos')
            ->with('lenguas')
            ->first();
        $this->verPublicar='0';
    }

    public function VerNoVerDoi(){
        if($this->verDoi=='1'){
            $this->verDoi='0';
        }else{
            $this->verDoi='1';
        }

    }

    public function mount(){
        $this->verPublicar='0';
        $this->ErrorAlert='0';
        $this->verDoi='0';
        $this->CambiaEdo_version='0';
    }

    public function LimpiarModalDeCambiosDeEstado(){
        $this->reset(['ErrorAlert','verPublicar','verDoi', 'NvoDoi', 'e0', 'e1', 'e2', 'e3', 'e4', 'e5', 'e6']);
        $this->mount();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function CerrarModalDeCambioDeEstado(){
        $this->LimpiarModalDeCambiosDeEstado();
        $this->dispatch('CierraModalCambiaEdoCedula');
    }

    public function CambiaEstado($edo){
        ##### Cambia el estado de la cédula (excepto estado 5:publicado)
        cedulas_url::where('url_id',$this->CambiaEdo_urlid)->update([
            'url_edo'=>$edo,
        ]);
        ##### Genera log
        paLog('La cédula '.$this->CambiaEdo_urlid.' se cambia a estado '.$edo,'cedulas_url',$this->CambiaEdo_urlid);


        ##### Detecta usuarios involucrados según el estado que toca
        ### edo 1,3: editor   |  edo 2: autor-trad
        ### edo 4:  admin     |  edo 5,6: autor-trad y editor
        $buscaId1=ced_autores::query();
        $buscaId1=$buscaId1->where('aut_urlid',$this->CambiaEdo_urlid)
            ->where('aut_del','0')
            ->where('aut_act','1');

        if(in_array($edo,['1','3'])){
            #### Busca editores
            $buscaId1=$buscaId1->where('aut_tipo','Editor')
                ->distinct('aut_cautid')
                ->pluck('aut_cautid')
                ->toArray();
            $texto1="fue terminada por el autor ó traductor y se envía a ";
            $texto2=" (editor) para su revisión";
            $texto3="editor";

        }elseif(in_array($edo,['2'])){
            ##### Busca autores o traductores
            $buscaId1=$buscaId1->whereIn('aut_tipo',['Autor','Traductor'])
                ->distinct('aut_cautid')
                ->pluck('aut_cautid')
                ->toArray();
            $texto1="fue editada por el editor y se envía a ";
            $texto2=" (autor o traductor) para su revisión";
            $texto3="autor/traductor";

        }elseif(in_array($edo,['4'])){
            ###### Busca administradores del jarrdín
            $buscaId1=UserRolesModel::whereIn('rol_cjarsiglas',['todos', $this->CambiaEdo_ced->url_cjarsiglas])
                ->where('rol_crolrol','admin')
                ->where('rol_act','1')
                ->where('rol_del','0')
                ->distinct('rol_usrid')
                ->pluck('rol_usrid')
                ->toArray();
            $texto1="fue revisada  por el editor y se encuentra lista para ser publicada por ";
            $texto2=" (administrador del sistema)";
            $texto3="administrador";

        }elseif(in_array($edo,['6'])){
            $buscaId1=$buscaId1->distinct('aut_cautid')
                ->pluck('aut_cautid')
                ->toArray();
            $texto1="se encuentra publicada, pero se solicitó autorización del administrador ";
            $texto2=" para iniciar su edición";
            $texto3="administrador";
        }
        ###### Detecta los usuarios con ID
        $buscaId2=cat_autores::whereIn('caut_id',$buscaId1)
            ->where('caut_act','1')
            ->where('caut_del','0')
            ->where('caut_usrid','>','0')
            ->distinct('caut_usrid')
            ->get();


        ##### Envía el correo
        foreach($buscaId2 as $a){
            ##### Obtiene datos
            $nom=$a->caut_nombre." ".$a->caut_apellido;
            $url=cedulas_url::where('url_id',$this->CambiaEdo_urlid)->with('lenguas')->first();
            ##### Envía correo
            $to=$a->caut_usrid;        ##### id de users de destino
            $from=Auth::user()->id;      ##### id de users de quien escribe o 0 para sistema
            $ifReply='0';   ##### 0 para mensajes nuevos o msj_id para respuesta a msj previo
            $asunto="Se te envía la cédula ".$url->url_titulo." para su revisión.";
            $mensaje='La cédula <b>"'. $url->url_titulo .'"</b>'.
                ' en lengua <b>'. $url->lenguas->len_autonimias .'</b> ('.$url->lenguas->len_lengua.') ['.$url->lenguas->len_code.']'.
                ' del jardín <b>'. $url->url_cjarsiglas .'</b> '.
                $texto1." <b>". $a->caut_nombre." ".$a->caut_apellido1."</b> ".$texto2.
                " <small>(ver la <a href='".url('/cedula')."/".$url->url_cjarsiglas."/".$url->url_url."'> cédula </a> o ir al <a href='".url('/admin_cedulas')."'>administrador de cédulas</a> <i>--necesitas acceder al sistema antes --</i>)</small>";
            $notas='';
            ##### Envía mensaje con función de helper
            $a=EnviaMensajeAbuzon($to,$from,$asunto, $mensaje,$notas,$ifReply);
            if($a > '0'){
                $this->dispatch('AvisoExitoModalUsuarios', msj:'Error en el envío del mensaje');
                return;
            }
        }

        ##### Cierra modal
        $this->dispatch('RecargarPagina');
        $this->CerrarModalDeCambioDeEstado();
    }

    public function GeneraPDF($version){
        ####################################### Crea PDF
        ##### Carga datos y metadatos de la cédula para el pdf:
        $cedula=cedulas_url::where('url_id',$this->CambiaEdo_ced->url_id)
            ->with('jardin')
            ->with('lenguas')
            ->with('autores')
            ->with('traductores')
            ->with('ubicaciones')
            ->with('alias')
            ->first();
        $especies=ced_sp::where('sp_cjarsiglas',$this->CambiaEdo_ced->url_cjarsiglas)
            ->where('sp_urltxt',$this->CambiaEdo_ced->url_urltxt)
            ->where('sp_act','1')->where('sp_del','0')
            ->orderBy('sp_id','asc')
            ->with('usos')
            ->leftJoin('nom059semarnat', function($q){
                $q->on('nom_genero','ilike','sp_genero')
                ->on('nom_especie','ilike','sp_especie')
                ->on('nom_infrasp','ilike','sp_ssp');
            })
            ->get();
        $traducciones=cedulas_url::where('url_key', $this->CambiaEdo_ced->url_key)
            ->where('url_id','!=',$this->CambiaEdo_ced->url_id)
            ->where('url_act','1')->where('url_del','0')
            // ->where('url_ciclo','>','0')
            ->with('lenguas')
            ->with('jardin') ##quitar cuando quite $traducciones en lína 169 de la vista
            ->orderBy('url_lencode')
            ->get();

        $objs=Imagenes::where('img_key',$this->CambiaEdo_ced->url_key)
            ->where('img_act','1')->where('img_del','0')
            ->get();
        $txt=cedulas_txt::where('txt_cjarsiglas',$this->CambiaEdo_ced->url_cjarsiglas)
        ->where('txt_urlurl',$this->CambiaEdo_ced->url_url)
        ->where('txt_act','1')->where('txt_del','0')
        ->orderBy('txt_orden')
        ->get();

        $meses=['0','enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','dieciembre'];
        $UrlRedes=url('/').'/cedula/'.$this->CambiaEdo_ced->url_cjarsiglas.'/'.$this->CambiaEdo_ced->url_url;
        $qrSize='80';

        ###### Carga el pdf
        $pdf=PDF::loadView('/livewire/web/cedulas-controller-pdf',[
            'cedula'=>$cedula,
            'especies'=>$especies,
            'url'=>$this->CambiaEdo_ced,
            'edit'=>'0',
            'editMaster'=>'0',
            'enEdit'=>'0',
            'traducciones'=>$traducciones,
            'objs'=>$objs,
            'txt'=>$txt,
            'meses'=>$meses,
            'UrlRedes'=>$UrlRedes,
            'qrSize'=>$qrSize,
            'aportes'=>collect(),
            'ligas'=>collect(),
            'EsUnPdf'=>'TRUE',

        ]);
        $pdf->setPaper('letter','portrait');
        $NombrePdf='cedulas/pdf/cedula_'.$cedula->url_cjarsiglas.'_'.$cedula->url_url.'_V'.$version.'.pdf';
        // $pdf->save('cedulas/pdf/cedula_'.$cedula->url_cjarsiglas.'_'.$cedula->url_url.'_V'.$version.'.pdf');
        $pdf->save($NombrePdf);
        return $NombrePdf;
        ############################## Termina pdf

    }

    public function PublicaCedula(){
        ##### Determina Año (solo en ciclo 0)
        if($this->CambiaEdo_ced->url_ciclo == '0'){
            $anio=date('Y');
        }else{
            $anio=$this->CambiaEdo_ced->url_anio;
        }

        ##### Calcula versión
        if($this->CambiaEdo_version=='1' or $this->CambiaEdo_ced->url_ciclo=='0'){
            $version=$this->CambiaEdo_ced->url_version + 0.10;

            ##### Guarda nueva versión
            $RegVer=ced_version::create([
                'ver_cedid'=>$this->CambiaEdo_ced->url_id,
                'ver_version'=>$version,
                'ver_mes'=>date('n'),
                'ver_anio'=>date('Y'),
                'ver_dia'=>date('d'),
                'ver_hora'=>date('H:i'),
                'ver_pdf'=>'creando..',
            ]);

        }else{
            $version=$this->CambiaEdo_ced->url_version;


        }

        ##### Genera Cita
        if($this->CambiaEdo_version=='1' OR $this->CambiaEdo_ced->url_ciclo=='0'){
            $num='0'; $cita=''; $autores='';$trads='';
            ##### Autores
            foreach($this->CambiaEdo_ced->autores as $a){
                $num++;
                $autores=$autores.$a->autor->caut_nombreautor;
                if($this->CambiaEdo_ced->autores->count() > '1' and $num==($this->CambiaEdo_ced->autores->count() - 1) ){
                    $autores=$autores.' y ';
                }elseif($this->CambiaEdo_ced->autores->count() > '1' and $num < ($this->CambiaEdo_ced->autores->count()-1)){
                    $autores=$autores.', ';
                }
            }
            ##### Año, titulo
            $cita=$autores.' '.$anio.' '.$this->CambiaEdo_ced->url_titulo.' ' ;

            ##### Traducción
            if($this->CambiaEdo_ced->url_tradid > '0'){
                ##### Lengua
                $trads='('.$this->CambiaEdo_ced->lenguas->len_lengua.'; ';
                ##### Traductores
                $num='0';
                foreach($this->CambiaEdo_ced->traductores as $a){
                    $num++;
                    $trads=$trads.$a->autor->caut_nombreautor;
                    if($this->CambiaEdo_ced->traductores->count() > '1' and $num==($this->CambiaEdo_ced->traductores->count() - 1) ){
                        $trads=$trads.' y ';
                    }elseif($this->CambiaEdo_ced->traductores->count() > '1' and $num < ($this->CambiaEdo_ced->traductores->count()-1)){
                        $trads=$trads.', ';
                    }
                }
                $trads=$trads.'). ';
            }
            ##### Version
            $cita=$cita.$trads.' v.'.$version;
            $cita=$cita.' Cédulas del Jardín en lenguas originarias. ';
            ##### URL
            if($this->CambiaEdo_ced->url_doi != ''){
                    $cita=$cita.'https://doi.org/'.$this->CambiaEdo_ced->url_doi;
            }else{
                $cita=$cita.url('/').'/'.$this->CambiaEdo_ced->url_cjarsiglas.'/'.$this->CambiaEdo_ced->url_url;
            }

            ######## Genera pdf de la nueva versión
            $NvoPdfName=$this->GeneraPDF($version);
            ced_version::where('ver_id',$RegVer->ver_id)->update([
                'ver_pdf'=>"/".$NvoPdfName,
            ]);


        }else{
            $cita=$this->CambiaEdo_ced->url_cita;
            $autores=$this->CambiaEdo_ced->url_cita_aut;
            $trads=$this->CambiaEdo_ced->url_cita_trad;
        }

        ##### Cambia el estado de la cédula
        cedulas_url::where('url_id',$this->CambiaEdo_urlid)->update([
            'url_edo'=>'5',
            'url_edit'=>'0',
            'url_ciclo'=>$this->CambiaEdo_ced->url_ciclo + 1,
            'url_version'=>$version,
            'url_cita'=>$cita,
            'url_cita_aut'=>$autores,
            'url_cita_trad'=>$trads,
            'url_anio'=>$anio,
        ]);
        ##### Genera log
        paLog('Se publica cédula','cedulas_url',$this->CambiaEdo_urlid);

        ###### Envía mensaje de buzón. Busca autores con cuenta y sin cuenta
        $ListaUnicaDeAutores=ced_autores::where('aut_urlid',$this->CambiaEdo_urlid)
            ->where('aut_act','1')->where('aut_del','0')
            ->distinct('aut_cautid')
            ->pluck('aut_cautid')
            ->toArray();
        $autoresConCta=cat_autores::whereIn('caut_id',$ListaUnicaDeAutores)
            ->where('caut_usrid','>','0')
            ->get();
        $autoresSinCta=cat_autores::whereIn('caut_id',$ListaUnicaDeAutores)
            ->whereNotIn('caut_id',  $autoresConCta->pluck('caut_id')->toArray())
            ->where('caut_correo','!=','')
            ->get();

        ##### Prepara textos para correos
        if($this->CambiaEdo_version=='1'){$textin1=' nueva ';}else{$textin1=' misma ';}
        if($this->CambiaEdo_ced->url_ciclo=='0'){$TextoX=' finalizó su primer ciclo de revisiones ';}else{$TextoX=' finalizó su ciclo número '.$this->CambiaEdo_ced->url_ciclo.' de revisiones ';}
        $Texto='La cédula "<b>'.$this->CambiaEdo_ced->url_titulo.'</b>" '.
                ' en lengua '.$this->CambiaEdo_ced->lenguas->len_autonimias." (".$this->CambiaEdo_ced->lenguas->len_lengua.")".
                " del jardín ".$this->CambiaEdo_ced->url_cjarsiglas.
                $TextoX.
                " y acaba de ser liberada al público en la URL: ".url('/cedula')."/".$this->CambiaEdo_ced->url_cjarsiglas."/".$this->CambiaEdo_ced->url_url.
                " (".$textin1." versión ".$this->CambiaEdo_ced->url_version.")".
                "</b> (ver <a href='".url('/cedula')."/".$this->CambiaEdo_ced->url_cjarsiglas."/".$this->CambiaEdo_ced->url_url."'>cédula</a>)";
        $Asuntillo="Aviso de liberación al público de la cédula ".$this->CambiaEdo_ced->url_titulo;

        ##### Envía el mensaje de buzón a usuarios con cuenta
        if($autoresConCta->count() > '0'){
            foreach($autoresConCta as $a){
                $to=$a->caut_usrid;        ##### id de users de destino
                $from=Auth::user()->id;      ##### id de users de quien escribe o 0 para sistema
                $ifReply='0';   ##### 0 para mensajes nuevos o msj_id para respuesta a msj previo
                $asunto=$Asuntillo;
                $mensaje=$a->caut_nombre." ".$a->caut_apellido1.":<br>".$Texto;
                $notas='';
                ##### Envía mensaje con función de helper
                $a=EnviaMensajeAbuzon($to,$from,$asunto, $mensaje,$notas,$ifReply);
                // dd('conCta',$a,$to);
                if($a > '0'){
                    $this->dispatch('AvisoExitoModalUsuarios', msj:'Error en el envío del mensaje');
                    return;
                }
            }
        }

        ##### Envía mensaje de buzón a usuarios sin cuenta
        if($autoresSinCta->count() > '0'){
            foreach($autoresSinCta as $a){
                $CatAutorId=$a->caut_id;

                $asunto=$Asuntillo;
                $mensaje=$a->caut_nombre." ".$a->caut_apellido1." ".$a->caut_apellido2.":<br>".$Texto;
                $notas='';
                ##### Envía mensaje con función de helper
                $a=EnviarMensajeAmail($CatAutorId, $asunto, $mensaje, $notas);

                if($a > '0'){
                    $this->dispatch('AvisoExitoModalUsuarios', msj:'Error en el envío del mensaje');
                    return;
                }
            }
        }

        ##### Cierra modal
        $this->dispatch('RecargarPagina');
        $this->CerrarModalDeCambioDeEstado();

    }

    public function ConfirmarPublicacion(){
        ##### Valida que haya todos los datos
        if(($this->CambiaEdo_ced->autores->count() < '1') OR
          ($this->CambiaEdo_ced->editores->count() < '1') OR
          (($this->CambiaEdo_ced->url_tradid > '0') AND ($this->CambiaEdo_ced->traductores->count() < '1')) OR
          ($this->CambiaEdo_ced->ubicaciones->count() < '1') OR
          ($this->CambiaEdo_ced->alias->count() < '1')  ){
            $this->ErrorAlert='1';
            $this->verPublicar='0';
            return;
        }else{
            ##### Cambia flag a 1 para ver sección
            $this->verPublicar='1';
        }
    }

    public function RegistrarDoi(){
        ##### valida campo
        $this->validate([
            'NvoDoi'=>'required',
        ]);
        ##### valida estructura de DOI
        ##### Guarda DOI
        cedulas_url::where('url_id',$this->CambiaEdo_ced->url_id)->update([
            'url_doi'=>$this->NvoDoi,
        ]);

        ##### Genera Doi
        paLog('Vincula DOI a cédula','url_doi',$this->CambiaEdo_ced->url_id);

        ##### Actualiza datos
        $this->CambiaEdo_ced->url_doi=$this->NvoDoi;

        ##### Cierra sección
        $this->verDoi='0';
    }

    public function BorrarDoi(){
        ##### Guarda DOI
        cedulas_url::where('url_id',$this->CambiaEdo_ced->url_id)->update([
            'url_doi'=>null,
        ]);

        ##### Genera Doi
        paLog('Se borró DOI de cédula','url_doi',$this->CambiaEdo_ced->url_id);

        ##### Actualiza datos
        $this->CambiaEdo_ced->url_doi=null;
    }

    public function render() {
        if($this->CambiaEdo_urlid > '0'){
            ################## Verifica estado
            if(array_intersect(['admin'],session('rol')) ){
                if($this->CambiaEdo_urledo=='0'){      $this->e0='';         $this->e1='';         $this->e2='disabled'; $this->e3='disabled'; $this->e4='disabled'; $this->e5=''; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='1'){ $this->e0='disabled'; $this->e1='';         $this->e2='';         $this->e3='disabled'; $this->e4='disabled'; $this->e5=''; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='2'){ $this->e0='disabled'; $this->e1='';         $this->e2='';         $this->e3='disabled'; $this->e4='disabled'; $this->e5=''; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='3'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='';         $this->e3='';         $this->e4='disabled'; $this->e5=''; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='4'){ $this->e0='disabled'; $this->e1='';         $this->e2='';         $this->e3='disabled'; $this->e4='';         $this->e5=''; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='5'){ $this->e0='disabled'; $this->e1='';         $this->e2='';         $this->e3='disabled'; $this->e4='disabled'; $this->e5=''; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='6'){ $this->e0='disabled'; $this->e1='';         $this->e2='';         $this->e3='disabled'; $this->e4='disabled'; $this->e5=''; $this->e6='';}

            }elseif(array_intersect(['editor'],session('rol')) ){
                if($this->CambiaEdo_urledo=='0'){      $this->e0='';         $this->e1='disabled'; $this->e2='disabled'; $this->e3='disabled'; $this->e4='';         $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='1'){ $this->e0='disabled'; $this->e1='';         $this->e2='';         $this->e3='disabled'; $this->e4='';         $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='2'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='';         $this->e3='disabled'; $this->e4='';         $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='3'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='';         $this->e3='';         $this->e4='';         $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='4'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='disabled'; $this->e3='disabled'; $this->e4='';         $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='5'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='disabled'; $this->e3='disabled'; $this->e4='disabled'; $this->e5='';         $this->e6='';
                }elseif($this->CambiaEdo_urledo=='6'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='';         $this->e3='disabled'; $this->e4='disabled'; $this->e5='disabled'; $this->e6='';}

            }elseif(array_intersect(['autor','traductor'],session('rol')) ){
                if($this->CambiaEdo_urledo=='0'){      $this->e0='';         $this->e1='';         $this->e2='disabled'; $this->e3='disabled'; $this->e4='disabled'; $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='1'){ $this->e0='disabled'; $this->e1='';         $this->e2='disabled'; $this->e3='disabled'; $this->e4='disabled'; $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='2'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='';         $this->e3='';         $this->e4='disabled'; $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='3'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='disabled'; $this->e3='';         $this->e4='disabled'; $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='4'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='disabled'; $this->e3='disabled'; $this->e4='';         $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='5'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='disabled'; $this->e3='disabled'; $this->e4='disabled'; $this->e5='';         $this->e6='';
                }elseif($this->CambiaEdo_urledo=='6'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='disabled'; $this->e3='disabled'; $this->e4='disabled'; $this->e5='disabled'; $this->e6='';}
            }
        }else{
            $this->CambiaEdo_urlid='0';
            $this->CambiaEdo_urledo='6';
            $this->e0='disabled'; $this->e1='disabled'; $this->e2='disabled'; $this->e3='disabled'; $this->e4='disabled'; $this->e5='disabled'; $this->e6='disabled';
        }

        return view('livewire.sistema.modal-cedula-cambia-estado-component');
    }
}
