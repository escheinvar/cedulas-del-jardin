<?php

namespace App\Livewire\Sistema;

use App\Models\ced_alias;
use App\Models\ced_catalogos;
use App\Models\cedulas_url;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalCedulaAliasComponent extends Component
{
    ##### variables recibidas desde controlador eterno
    public $alias_id, $alias_urlid;
    ##### variable del modal
    public $alias_trad, $alias_url, $alias_jardin;
    public $alias_tipo, $alias_txt, $alias_txt_tr;

    /*############################################## ModalAlias_uso
    ###################################################################
    ##### Este modal, requiere cuatro varables:
    public function AbrirModalDeAlias(){
        $datos=[
            'aliasId'=>'0', ### o id del uso
            'urlId'=>url_id, #### id de la cédula
            // 'jardin'=>$this->url->url_cjarsiglas,
            // 'urltxt'=>$this->url->url_urltxt
        ];
        $this->dispatch('AbreModalUsoEnCedula',$datos);
    }
    #################################################################### */


    #[On('AbreModalAlias')]
    public function montarDatos($datos){
        ##### recibe variables externas
        $this->alias_id=$datos['aliasId'];
        $this->alias_urlid=$datos['urlId'];

        ##### Calcula variables
        $cedula=cedulas_url::where('url_id',$this->alias_urlid)->first();
        $this->alias_trad=$cedula->url_tradid;
        $this->alias_url=$cedula->url_urlurl;
        $this->alias_jardin=$cedula->url_cjarsiglas;
        if($this->alias_id > '0'){
            $dato=ced_alias::where('ali_id',$this->alias_id)->first();
            $this->alias_tipo=$dato->ali_calitipo;
            $this->alias_txt=$dato->ali_txt;
            $this->alias_txt_tr=$dato->ali_txt_tr;
        }
    }

    public function mount(){
        $this->alias_id='';
        $this->alias_urlid='';
        // $this->alias_ced=collect(['url_url'=>'', 'url_cjarsiglas'=>'']);
        $this->alias_trad='0';
        $this->alias_url='';
        $this->alias_jardin='';
        $this->alias_tipo='Palabra clave';
    }

    public function LimpiarModalDeAlias(){
        $this->reset(['alias_trad', 'alias_url', 'alias_jardin', 'alias_tipo', 'alias_txt', 'alias_txt_tr']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function CerrarModalDeAlias(){
        $this->LimpiarModalDeAlias();
        $this->dispatch('CierraModalAlias');
    }

    public function ActualizaVariablesEnComponente(){
        ##### Actualiza variables en livewire
        $preDato=cedulas_url::where('url_id',$this->alias_urlid)
                ->with('alias')
                ->first();
        $CedAlias=$preDato->alias;
        $this->dispatch('RecibeVariablesDeAlias',dato:$CedAlias);
    }

    public function GuardarAlias(){
        ##### Valida formulario
        if($this->alias_id > '0'){
            $this->validate([
                'alias_tipo'=>'required',
                'alias_txt'=>'required',
                'alias_txt_tr'=>'required',
            ]);
        }else{
            $this->validate([
                'alias_tipo'=>'required',
                'alias_txt'=>'required',
            ]);
        }
        ##### Calcula valores para generar
        $cedula=cedulas_url::where('url_id',$this->alias_urlid)->first();
        if($this->alias_id == '0'){
            $txtTr=$this->alias_txt;
        }else{
            $txtTr=$this->alias_txt_tr;
        }

        ##### Compila datos
        $datos=[
            'ali_cjarsiglas'=>$cedula->url_cjarsiglas,
            'ali_urltxt'=>$cedula->url_urltxt,
            'ali_calitipo'=>$this->alias_tipo,
            'ali_txt'=>$this->alias_txt,
            'ali_txt_tr'=>$txtTr,
        ];
        if($this->alias_id=='0'){
            ##### Calcula todas las copias y genera alias en cada una de ellas
            $hermanitos=cedulas_url::where('url_cjarsiglas',$cedula->url_cjarsiglas)
                ->where('url_urltxt',$cedula->url_urltxt)
                ->get();
            foreach($hermanitos as $h){
                $datosH=$datos;
                $datosH['ali_urlid']=$h->url_id;
                $datosH['ali_urlurl']=$h->url_url;
                $nvo=ced_alias::create($datosH);
                paLog('Se genera alias','ced_alias',$nvo->ali_id);
            }
            ##### Da aviso
            $this->dispatch('AvisoExitoAlias',msj:'Se generó la palabra clave');
        }else{
            $datos['ali_urlid']= $this->alias_urlid;
            $datos['ali_urlurl']=$cedula->url_url;
            ced_alias::where('ali_id',$this->alias_id)->update($datos);
            paLog('Se edita alias','ced_alias',$this->alias_id);
            ##### Da aviso
            $this->dispatch('AvisoExitoAlias',msj:'Se guardaron los cambios de palabra clave');
        }

        $this->ActualizaVariablesEnComponente();

        ##### Cierra modal
        $this->CerrarModalDeAlias();
    }

    public function EliminarAlias(){
        $ganon=ced_alias::where('ali_id',$this->alias_id)->first();
        ced_alias::where('ali_cjarsiglas',$ganon->ali_cjarsiglas)
            ->where('ali_urltxt',$ganon->ali_urltxt)
            ->where('ali_txt',$ganon->ali_txt)
            ->update(['ali_del'=>'1']);
        paLog('Se eliminan todos los alias de '.$ganon->ali_urltxt.' en '.$ganon->ali_cjarsiglas, 'alil_urltxt','varios id');

        ##### Actualiza
        $this->ActualizaVariablesEnComponente();
        ##### Cierra
        $this->CerrarModalDeAlias();
    }

    public function render(){
        $tipos=ced_catalogos::where('cat_tipo','alias')->get();
        return view('livewire.sistema.modal-cedula-alias-component',[
            'tipoAlias'=>$tipos,
        ]);
    }
}
