<?php

namespace App\Livewire\Sistema;

use App\Models\CatKewModel;
use App\Models\lista_nombres;
use App\Models\lista_nombresc;
use App\Models\lista_img;
use App\Models\lista;
use App\Models\lenguas;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;


class ModalListaEspecieComponent extends Component
{
    /*############################################## ModalLista_Especies
    ###################################################################
    ##### Este modal, requiere dos varables, url_cjarsiglas y url_urltxt
    ##### Copiar AbrirModalDeBuscarEspecie en controller disparador
    ##### <livewire:sistema.modal-lista-especie-component />
    public function AbrirModalDeListaEspecie(){
        $datos=[
            'jardin'=>$this->lst_url->url_cjarsiglas,
            'lstId'=>$this->lst_id
        ];
        $this->dispatch('AbreModalDeListaDeEspecies',$datos);
    }
    ############################################################# */
    Use WithFileUploads;

    public $listasp_jardin, $listasp_id;  ##### Vars. grales.
    public $listasp_nombre, $listasp_orden, $listasp_razon, $listasp_img, $listasp_url; ##### Variables de formaulario
    public $listasp_nuevoNombre, $listasp_nuevoAudio, $listasp_nuevoAudio2, $listasp_nuevaLengua; ##### Variables de nombres comunes
    public $img;

    #[On('AbrirModalDeListaDeEspecies')]
    public function montarAbrirModalDeBuscarEspecie($datos){
        ##### recibe variables externas
        $this->listasp_jardin=$datos['jardin'];
        $this->listasp_id=$datos['lstId'];

        $this->listasp_nuevaLengua='spa';

        if($this->listasp_id != '0'){
            ##### Si es edición, carga datos
            $registro=lista::where('lst_id',$this->listasp_id)->first();

            $this->listasp_img=$registro->lst_img;
            $this->listasp_url=$registro->lst_url;
            $this->listasp_razon=$registro->lst_notas;
            $this->listasp_orden=$registro->lst_orden;

        }else{
            $this->limpiarModalDeBuscarEspecie();
            $this->listasp_orden=lista::where('lst_cjarsiglas',$this->listasp_jardin)
                ->where('lst_del','0')
                ->max('lst_orden') + 1;
        }
    }

    public function limpiarModalDeBuscarEspecie(){
        $this->reset('listasp_nombre','listasp_orden','listasp_razon','listasp_img','listasp_url');
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function CerrarModalDeBuscarEspecie($reload){
        if(!isset($reload) or $reload==''){$reload='1';}
        $this->limpiarModalDeBuscarEspecie();
        $this->dispatch('CierraModalDeListaDeEspecies',reload:$reload);
    }


    public function GuardaRegistro($cierra){
        ######### Nota: if $cierra==1, cierra modal y limpia variables;
        #########       if $cierra==0, solo guarda y deja modal abierto;
        $datos=[
            'lst_cjarsiglas'=>$this->listasp_jardin,
            'lst_orden'=>$this->listasp_orden,
            'lst_url'=>$this->listasp_url,
            'lst_notas'=>$this->listasp_razon,
        ];

        if($this->listasp_id=='0'){
            ###### valida que no exista otro registro con el mismo número de orden
            if(in_array($this->listasp_orden, lista::where('lst_cjarsiglas',$this->listasp_jardin)->where('lst_id','!=',$this->listasp_id)->where('lst_del','0')->pluck('lst_orden')->toArray())){
                $this->addError('listasp_orden','Ya existe un registro con este número de orden. Por favor elige otro.');
                return;
            }

            ##### Crea registro
            $bla=lista::create($datos);
            $this->listasp_id=$bla->lst_id;
            #### Crea log
            paLog('Se genera nuevo elemento de lista al listado de '.$this->listasp_jardin, 'lista',$this->listasp_id);

        }else{
            ##### Edita registro
            lista::where('lst_id',$this->listasp_id)->update($datos);
            #### Crea log
            paLog('Se edita elemento de lista en el listado de '.$this->listasp_jardin, 'lista',$this->listasp_id);
        }

        if($cierra=='1'){
            #### Limpia
            $this->limpiarModalDeBuscarEspecie();
            // $this->listasp_reino='';

            ##### Cierra
            $this->dispatch('CierraModalDeListaDeEspecies',reload:'1');
        }
    }

    public function BorrarNombre($id){
        lista_nombres::where('lstn_id',$id)->update(['lstn_del'=>'1']);
    }

    public function DesactivarNombre($id){
        $act=lista_nombres::where('lstn_id',$id)->value('lstn_act');
        if($act=='1'){$nvo='0';}else{$nvo='1';}
        lista_nombres::where('lstn_id',$id)->update(['lstn_act'=>$nvo]);
    }

    public function BorrarAudioNuevo(){
        $this->listasp_nuevoAudio='';
    }

    public function SubirNuevoAudio($id){
        #dd($this->listasp_nuevoAudio2);
        $datos=lista_nombres::where('lstn_id',$id)->first();
        #dd($id, $datos);
        $nombreAudio=$this->listasp_jardin.'-'.$datos->lstn_lstid."_".
                str_replace(' ','',ucwords($datos->lstn_name)).'_'.
                $datos->lstn_lencode.'.'.
                $this->listasp_nuevoAudio2->getClientOriginalExtension();

        $this->listasp_nuevoAudio2->storeAs('public/listas',$nombreAudio);
        $datos['lstn_audio']='/listas/'.$nombreAudio;
    }

    public function AgregrarNuevoNombre(){
        ##### Valida
        $this->validate([
            'listasp_nuevoNombre'=>'required',
            'listasp_nuevaLengua'=>'required'
        ],[
            'listasp_nuevoNombre.required'=>'Debes indicar un nombre',
            'listasp_nuevaLengua.required'=>'Debes indicar una lengua'
        ]);

        if($this->listasp_id=='0' OR $this->listasp_id==''){
         $this->GuardaRegistro('0');
        }
        ##### Guarda en BD
        $len=lenguas::where('len_code',$this->listasp_nuevaLengua)->first();
        $datos=[
            'lstn_lstid'=>$this->listasp_id,
            'lstn_name'=>$this->listasp_nuevoNombre,
            'lstn_lengua'=>$len->len_autonimias.' ('.$len->len_lengua.')',
            'lstn_lencode'=>$this->listasp_nuevaLengua,
        ];
        if($this->listasp_nuevoAudio != ''){
            $nombreAudio=$this->listasp_jardin.'-'.$this->listasp_id."_".
                str_replace(' ','',ucwords($this->listasp_nuevoNombre)).'_'.
                $this->listasp_nuevaLengua.'.'.
                $this->listasp_nuevoAudio->getClientOriginalExtension();

            $this->listasp_nuevoAudio->storeAs('public/listas',$nombreAudio);
            $datos['lstn_audio']='/listas/'.$nombreAudio;
        }
        lista_nombres::create($datos);

        $this->reset('listasp_nuevoNombre','listasp_nuevaLengua','listasp_nuevoAudio');
    }

    public function BorrarURL(){
        $this->listasp_url='';
    }

    public function AbrirModalDeNombreCientificoEnLista(){
        $datos=[
            'jardin'=>$this->listasp_jardin,
            'lstId'=>$this->listasp_id
        ];
        $this->dispatch('AbreModalDeNombreCientEnlista',$datos);
    }

     public function AbrirModalDeListaImagen($id){
        $datos=[
            'jardin'=>$this->listasp_jardin,
            'lstId'=>$this->listasp_id,
            'lstimgId'=>$id,
        ];
        $this->dispatch('AbreModalDeListaImagen',$datos);
    }

    public function DesactivaNombreCient($id){
        $act=lista_nombresc::where('lstsc_id',$id)->value('lstsc_act');
        if($act=='1'){$nvo='0';}else{$nvo='1';}
        lista_nombresc::where('lstsc_id',$id)->update(['lstsc_act'=>$nvo]);
    }

    public function BorrarNombreCient($id){
        lista_nombresc::where('lstsc_id',$id)->update(['lstsc_del'=>'1']);
    }

    public function render(){
        ##### Carga lista de nombres
        $nombres= lista_nombres::where('lstn_lstid',$this->listasp_id)
                ->where('lstn_del','0')
                ->orderBy('lstn_id')
                ->get();
        $nombresCient= lista_nombresc::where('lstsc_lstid',$this->listasp_id)
                ->where('lstsc_del','0')
                ->orderBy('lstsc_id')
                ->get();
        $img= lista_img::where('lstimg_lstid',$this->listasp_id)
            ->where('lstimg_del','0')
            ->orderBy('lstimg_orden')
            ->get();
        $this->img=$img;

        $lenguas=lenguas::orderBy('len_lengua')->get();


        return view('livewire.sistema.modal-lista-especie-component',[
            'nombres'=>$nombres,
            'lenguas'=>$lenguas,
            'nombresCient'=>$nombresCient,
            // 'img'=>$img,
        ]);
    }
}
