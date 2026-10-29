<?php

namespace App\Livewire\Sistema;

use App\Models\CatKewModel;
use App\Models\lista_nombres;
use App\Models\lista_nombresc;
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

    // public $listasp_ConCatalogo; #### Indica si hay o no catálogo de sp.
    // public $listasp_reino, $listasp_familia, $listasp_buscaGen, $listasp_gen;
    // public $listasp_sp, $listasp_scname, $listasp_scnamePre, $listasp_ssp, $listasp_var, $listasp_especies; ##### Variables de formaulario
    public $listasp_nombre, $listasp_orden, $listasp_razon, $listasp_img, $listasp_url; ##### Variables de formaulario
    public $listasp_nuevoNombre, $listasp_nuevoAudio, $listasp_nuevaLengua, $listasp_nuevaImagen; ##### Variables de nombres comunes

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
            // $this->listasp_orden=round(lista::max('lst_orden') + 1);
        }
    }

    public function limpiarModalDeBuscarEspecie(){
        // $this->reset('listasp_familia','listasp_buscaGen','listasp_especies','listasp_scname', 'listasp_gen','listasp_ssp','listasp_var','listasp_scnamePre');
        $this->reset('listasp_nombre','listasp_orden','listasp_razon','listasp_img','listasp_url','listasp_nuevaImagen');

        // $this->listasp_especies=collect();
        $this->resetValidation();
        $this->resetErrorBag();
    }

    public function CerrarModalDeBuscarEspecie($reload){
        if(!isset($reload) or $reload==''){$reload='1';}
        $this->limpiarModalDeBuscarEspecie();
        // $this->listasp_reino='';
        $this->dispatch('CierraModalDeListaDeEspecies',reload:$reload);

    }

    // public function DeterminaReino(){
    //     // ###### Reinos con catálogo
    //     // $conCatalogo=['planta'];
    //     // ###### Distingue catálogo vs no cat.
    //     // if(in_array($this->listasp_reino, $conCatalogo)){
    //     //     $this->listasp_ConCatalogo='1';
    //     // }else{
    //     //     $this->listasp_ConCatalogo='0';
    //     // }
    //     ##### Limpia:
    //     $this->reset('listasp_familia','listasp_buscaGen','listasp_especies','listasp_scname',
    //         'listasp_gen','listasp_sp','listasp_ssp','listasp_var');
    //     $this->listasp_especies=collect();
    //     #$this->limpiarModalDeBuscarEspecie();
    // }

    // public function BuscaCatalogoDeSp(){
    //     ##### Valida cuestionario
    //     $this->validate([
    //         'listasp_buscaGen'=>'required|min:3' /* ######ojo: en Orchidaceae existe el género Aa (42sp); Asteraceae género lo (1sp) */
    //     ],[
    //         'listasp_buscaGen'=>'Debes escribir un mínimo de 3 caracteres'
    //     ]);

    //     ###### Busca en catálogo de plantas
    //     if($this->listasp_reino=='planta'){
    //         ##### Busca género o especie
    //         if($this->listasp_buscaGen != ''){
    //             $this->listasp_especies=CatKewModel::where('ckew_scientfiicname','ilike','%'.$this->listasp_buscaGen.'%')
    //                 ->orderBy('ckew_scientfiicname')
    //                 ->get();
    //         }
    //     }
    // }

    // public function PreSeleccionaSp(){
    //     #dd($this->all());
    //     ######### Verifica estructura jerarquica de nombre científico
    //     if($this->listasp_gen =='' AND ($this->listasp_scname!='') and $this->listasp_ConCatalogo=='0'){
    //         $this->addError('listasp_gen','Error de anidamiento (Falta indicar el género)');
    //         return;
    //     }
    //     if($this->listasp_sp =='' AND ($this->listasp_ssp!='' ) ){
    //         $this->addError('listasp_sp','Error de anidamiento (Falta indicar la especie)');
    //         return;
    //     }

    //     ###### Verifica que exista la familia en catálogo cuando solo se mete familia en plantas
    //     if($this->listasp_reino=='planta' AND  $this->listasp_scnamePre == '' AND $this->listasp_familia != ''){
    //         ##### Verifica que exista la familia
    //         if(CatKewModel::where('ckew_family','ilike',$this->listasp_familia)->count() =='0'){
    //             $this->addError('listasp_familia','No hay registro de esta familia');
    //             return;
    //         }
    //         $this->listasp_familia=strtoupper($this->listasp_familia);
    //         $this->listasp_gen= '';
    //         $this->listasp_sp= '';
    //         $this->listasp_ssp= '';
    //         $this->listasp_scname= '';
    //     }
    //     if($this->listasp_reino=='planta' AND  $this->listasp_scnamePre != ''){
    //         ##### Obtiene datos del catálogo
    //         $kew=CatKewModel::where('ckew_taxonid',$this->listasp_scnamePre)->first();
    //         $this->listasp_familia=strtoupper($kew->ckew_family);
    //         $this->listasp_gen= $kew->ckew_genus;
    //         $this->listasp_sp= $kew->ckew_specificepithet;
    //         $this->listasp_ssp= $kew->ckew_infraspecificepithet;
    //         $this->listasp_scname= $kew->ckew_scientfiicname;
    //     }

    //     if($this->listasp_reino != 'planta'){
    //         $this->listasp_scname = $this->listasp_gen." ".$this->listasp_sp;
    //         if($this->listasp_ssp != ''){
    //             $this->listasp_scname=$this->listasp_scname." ".$this->listasp_ssp;
    //         }
    //     }

    //     $this->GuardaRegistro('0');

    // }

    public function GuardaRegistro($cierra){

        ######### Nota: if $cierra==1, cierra modal y limpia variables;
        #########       if $cierra==0, solo guarda y deja modal abierto;
        $datos=[
            'lst_cjarsiglas'=>$this->listasp_jardin,
            'lst_orden'=>$this->listasp_orden,
            'lst_url'=>$this->listasp_url,
            'lst_notas'=>$this->listasp_razon,
        ];

        ##### Verifica si hay imagen nueva
        if($this->listasp_nuevaImagen != ''){
            $nombreImagen='listaImg-'.$this->listasp_jardin.'_'.
                str_replace(' ','',ucwords($this->listasp_id)).'.'.
                $this->listasp_nuevaImagen->getClientOriginalExtension();
            $this->listasp_nuevaImagen->storeAs('public/listas',$nombreImagen);
            $datos['lst_img']='/listas/'.$nombreImagen;
        }else{
            $datos['lst_img']=$this->listasp_img;
        }

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
            #$original=lista::where('lst_id',$this->listasp_id)->first();
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

    public function BorrarSp(){
        dd('Cambiar por nueva tabla');
        // $this->reset('listasp_familia','listasp_buscaGen','listasp_especies','listasp_scname',
        //     'listasp_gen','listasp_sp','listasp_ssp','listasp_var');
        // $this->listasp_especies=collect();
        lista::where('lst_id',$this->listasp_id)->update([
            'lst_reino'=>'',
            'lst_familia'=>'',
            'lst_genero'=>'',
            'lst_sp'=>'',
            'lst_ssp'=>'',
            'lst_scname'=>'',
            'lst_var'=>''
        ]);

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

    public function AgregrarNuevoNombre(){
        #dd($this->listasp_id);
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
            $nombreAudio='lista-'.$this->listasp_jardin.'_'.
                str_replace(' ','',ucwords($this->listasp_nuevoNombre)).'_'.
                $this->listasp_nuevaLengua.'.'.
                $this->listasp_nuevoAudio->getClientOriginalExtension();

            $this->listasp_nuevoAudio->storeAs('public/listas',$nombreAudio);
            $datos['lstn_audio']='/listas/'.$nombreAudio;
        }
        lista_nombres::create($datos);

        $this->reset('listasp_nuevoNombre','listasp_nuevaLengua','listasp_nuevoAudio');
    }

    public function BorrarImagen($tipo){
        if($tipo=='bd'){
            lista::where('lst_id',$this->listasp_id)->update(['lst_img'=>'']);
            $this->listasp_img='';
            $this->listasp_nuevaImagen='';
        }elseif($tipo=='tmp'){
            $this->listasp_nuevaImagen='';
        }

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

    public function DesactivaNombreCient($id){
        $act=lista_nombresc::where('lstsc_id',$id)->value('lstsc_act');
        if($act=='1'){$nvo='0';}else{$nvo='1';}
        lista_nombresc::where('lstsc_id',$id)->update(['lstsc_act'=>$nvo]);
    }

    public function BorrarNombreCient($id){
        lista_nombresc::where('lstsc_id',$id)->update(['lstsc_del'=>'1']);
    }





    public function render(){
        ###### Distingue catálogo vs no cat.
        // $conCatalogo=['planta'];
        // if(in_array($this->listasp_reino, $conCatalogo)){
        //     $this->listasp_ConCatalogo='1';
        // }else{
        //     $this->listasp_ConCatalogo='0';
        // }

        ##### Carga lista de nombres
        $nombres= lista_nombres::where('lstn_lstid',$this->listasp_id)
                ->where('lstn_del','0')
                ->orderBy('lstn_id')
                ->get();
         $nombresCient= lista_nombresc::where('lstsc_lstid',$this->listasp_id)
                ->where('lstsc_del','0')
                ->orderBy('lstsc_id')
                ->get();
        $lenguas=lenguas::orderBy('len_lengua')->get();

        return view('livewire.sistema.modal-lista-especie-component',[
            'nombres'=>$nombres,
            'lenguas'=>$lenguas,
            'nombresCient'=>$nombresCient,
        ]);
    }
}
