<?php

namespace App\Livewire\Sistema;

use App\Models\autor_url;
use App\Models\cat_autores;
use App\Models\ced_autores;
use App\Models\cedulas_url;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalCedulaBuscautorComponent extends Component
{
    public $BuscaAutor_tipo, $cedulaId, $jardinSel;
    ##### Vars del modal Buscar Autor:
    public $BuscaAutor_BuscaNombre, $BuscaAutor_BuscaApellido, $BuscaAutor_Posibles;
    public $BuscaAutor_Ganon, $BuscaAutor_id, $BuscaAutor_name, $BuscaAutor_comunidad;
    public $BuscaAutor_institu, $BuscaAutor_correo, $BuscaAutor_corresponding;

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

    #[On('AbreModalDeBuscarAutor')]
    public function AbreModalDeBuscarAutor($datos){
        $this->BuscaAutor_tipo=$datos['tipo'];
        $this->cedulaId=$datos['cedulaId'];
        $this->jardinSel=$datos['jardinSel'];
        // $this->dispatch('AbreModalDeBuscarAutor');
    }

    public function mount(){
        ##### del modal busca autor:
        $this->BuscaAutor_Posibles=collect();
        $this->BuscaAutor_BuscaNombre='';
        $this->BuscaAutor_BuscaApellido='';
        $this->BuscaAutor_Ganon=collect();

        $this->cedulaId='0';
        $this->jardinSel='';

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

        $this->dispatch('CierraModalDeBuscarAutor',reload:'0');
    }

    public function BuscarAutores(){
        $this->LimpiaBusqueda2();

        ##### Genera query de búsqueda
        $busqueda=cat_autores::query();
        $busqueda=$busqueda->where('caut_act','1')
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

        ##### En caso de Editor, restringe a puro registrado
        if($this->BuscaAutor_tipo=="Editor"){
            // $busqueda=$busqueda->where('caut_usrid','>','0');
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
        $data=cedulas_url::where('url_id',$this->cedulaId)
            ->with('lenguas')
            ->first();
        $UrlKey=$data->url_key;
        $jardin=$data->url_cjarsiglas;
        $urltxt=$data->url_urltxt;

        $datos=[
            'aut_cautid'=>$this->BuscaAutor_id,
            'aut_urlid'=>$this->cedulaId, #### if id != 0
            'aut_cjarsiglas'=>$jardin,
            'aut_urltxt'=>$urltxt,
            'aut_key'=>$UrlKey,
            'aut_corresponding'=>$corr,
            'aut_name'=>$this->BuscaAutor_name,
            'aut_correo'=>$this->BuscaAutor_correo,
            'aut_institucion'=>$this->BuscaAutor_institu,
            'aut_comunidad'=>$this->BuscaAutor_comunidad,
            'aut_tipo'=>$this->BuscaAutor_tipo,
        ];

        if($this->cedulaId > '0'){
            #### guarda al autor (si es autor, lo copia en copias)
            if($this->BuscaAutor_tipo == 'Autor'){
                ##### Identifica todas las copias de este key
                $ganones=cedulas_url::where('url_key',$UrlKey)->get();
                ##### Guarda autores en cada una de las copias
                foreach($ganones as $g){
                    $datos2=$datos;
                    $datos2['aut_urlid']=$g->url_id;
                    ###### Si hay id asignado, guarda en BD
                    $bla=ced_autores::create($datos2);
                    $id=$bla->aut_id;
                    #### Genera log
                    paLog('Se agrega '.$this->BuscaAutor_tipo.' id '.$this->BuscaAutor_id.' a cédula '.$this->cedulaId,'ced_autores',$id);
                }

            }else{
                ###### Si hay id asignado, guarda en BD
                $bla=ced_autores::create($datos);
                $id=$bla->aut_id;
                #### Genera log
                paLog('Se agrega '.$this->BuscaAutor_tipo.' id '.$this->BuscaAutor_id.' a cédula '.$this->cedulaId,'ced_autores',$id);
            }
            ######## Recarga variable (para actualizar lista en modal)
            $dato=cedulas_url::where('url_id',$this->cedulaId)
                ->with('autores')
                ->first();
            $ja=$dato->autores;

            $this->dispatch('RecibeVariablesDeBuscaAutor',dato:$ja);
        }
        ###### Revisa si el autor tiene url en este jardín y en su caso, lo crea
        $webs=autor_url::where('aurl_cjarsiglas', $jardin)
            ->where('aurl_cautid',$this->BuscaAutor_id)
            ->where('aurl_del','0')
            ->count();
        if($webs < '1'){
            $autor=cat_autores::where('caut_id',$this->BuscaAutor_id)->first();

            $nvo=autor_url::create([
                'aurl_cautid'=>$this->BuscaAutor_id,
                'aurl_cjarsiglas'=>$jardin,
                'aurl_urltxt'=>$autor->caut_url,
                'aurl_url'=>$autor->caut_url,
                'aurl_lencode'=>'spa',
                'aurl_tradid'=>'0',
                // 'aurl_resumen'=>'',
                // 'aurl_resumenorig'=>'',
            ]);
            ##### Palog
            paLog('se genera página de autor','autor_url',$nvo->aurl_id);

        }
        ##### Revisa si el autor/editor/trad. tiene cuenta de usuario
        $buscaId=cat_autores::where('caut_id',$this->BuscaAutor_id)->where('caut_del','0')->where('caut_act','1')->value('caut_usrid');
        ##### Envía el correo
        if($buscaId > '0'){
            ##### construye variables
            if($this->BuscaAutor_tipo =='Autor'){
                $lengua=' en su lengua original y <b>todas sus traducciones</b> subsecuentes';
            }else{
                $lengua=' en lengua <b>'.$data->lenguas->len_autonimias.'</b> ('.$data->lenguas->len_lengua.': '.$data->lenguas->len_code.')';
            }

            ##### Envía correo
            $to=$buscaId;        ##### id de users de destino
            $from=Auth::user()->id;      ##### id de users de quien escribe o 0 para sistema
            $ifReply='0';   ##### 0 para mensajes nuevos o msj_id para respuesta a msj previo
            $asunto="Asignación de privilegios de autor/traductor/editor sobre una cédula del Jardín";
            $mensaje='Se te asignó el privilegio de <b>'. $this->BuscaAutor_tipo .
                '</b> sobre la cédula <b>'. $urltxt .'</b> ' .$lengua.
                '</b>  del jardín <b>'.$jardin.
                '</b>.<br> Ya puedes ingresar al sistema para trabajar en ella.'.
                "</b> (ver <a href='".url('/cedula')."/".$data->url_cjarsiglas."/".$data->url_url."'>".
                "cédula</a> o ir al <a href='".url('/admin_cedulas')."'>administrador de cédulas</a>)";
            $notas='';
            ##### Envía mensaje con función de helper
            $a=EnviaMensajeAbuzon($to,$from,$asunto, $mensaje,$notas,$ifReply);
            if($a > '0'){
                $this->dispatch('AvisoExitoModalUsuarios', msj:'Error en el envío del mensaje');
                return;
            }
        }


        ##### Finaliza con mensaje y cierre
        $this->dispatch('AvisoExitoBuscaAutorCedula',msj:'Se agregó correctamente el autor');
        $this->dispatch('LimpiaBusqueda1');
        $this->dispatch('LimpiaBusqueda2');
        $this->BuscaAutor_Ganon=collect();
        $this->dispatch('CierraModalDeBuscarAutor',reload:'0');
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


    public function render() {
        return view('livewire.sistema.modal-cedula-buscautor-component');
    }
}
