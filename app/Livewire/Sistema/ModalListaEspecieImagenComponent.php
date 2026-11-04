<?php

namespace App\Livewire\Sistema;

use App\Models\lista_img;
use App\Models\lista;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ModalListaEspecieImagenComponent extends Component
{
    /*############################################## ModalLista_Imagenes
    ###################################################################
    ##### Este modal, requiere dos varables, url_cjarsiglas y url_urltxt
    ##### Copiar AbrirModalDeBuscarEspecie en controller disparador
    ##### <livewire:sistema.modal-lista-especie-imagen-component />
    public function AbrirModalDeListaImagen($id){
        $datos=[
            'jardin'=>$this->lst_url->url_cjarsiglas,
            'lstId'=>$this->lst_id,
            'lstimgId'=>$id,
        ];
        $this->dispatch('AbreModalDeListaImagen',$datos);
    }
    ############################################################# */
    Use WithFileUploads;

    public $lstimg_lstid, $lstimg_jardin, $lstimg_imgid;
    public $lstimg_nvaImg, $lstimg_img, $lstimg_act, $lstimg_orden, $lstimg_titulo, $lstimg_autor, $lstimg_explica;

    #[On('AbreModalDeListaImagen')]
    public function montarAbrirModalDeBuscarEspecie($datos){
        ##### recibe variables externas
        $this->lstimg_imgid=$datos['lstimgId'];
        $this->lstimg_jardin=$datos['jardin'];
        $this->lstimg_lstid=$datos['lstId'];

        ##### Prepara variables
        $this->lstimg_nvaImg = '';
        if($this->lstimg_imgid > '0'){
            $dato=lista_img::where('lstimg_id',$this->lstimg_imgid)->first();
            $this->lstimg_act=$dato->lstimg_act;
            $this->lstimg_img=$dato->lstimg_img;
            $this->lstimg_orden=$dato->lstimg_orden;
            $this->lstimg_titulo=$dato->lstimg_titulo;
            $this->lstimg_autor=$dato->lstimg_autor;
            $this->lstimg_explica=$dato->lstimg_explica;
        }else{
            $ja=lista_img::where('lstimg_lstid',$this->lstimg_lstid)->where('lstimg_del','0')->max('lstimg_orden');
            if(is_null($ja)){$ja='0';}
            $this->lstimg_orden=$ja + 1;
            $this->lstimg_act='1';
        }

    }

    public function GuardaModalImagen(){
        ##### Valida
        if($this->lstimg_imgid=='0'){
            $this->validate([
                'lstimg_nvaImg'=>'required',
            ],['lstimg_nvaImg'=>'Se requiere una imagen']);
            ##### En caso de que aún no exista id de lista, genera la lista
            if($this->lstimg_lstid=='0'){
                $nvo=lista::create([
                    'lst_cjarsiglas'=>$this->lstimg_jardin,
                    'lst_orden'=>lista::where('lst_cjarsiglas',$this->lstimg_jardin)->where('lst_del','0')->max('lst_orden') + 1,
                ]);
                $this->lstimg_lstid=$nvo->lst_id;
            }
        }else{
            $this->validate([
                'lstimg_img'=>'required',
            ],['lstimg_img'=>'Se requiere una imagen']);
        }

        ##### Genera dato
        $datos=[
            'lstimg_act'=>$this->lstimg_act,
            'lstimg_orden'=>$this->lstimg_orden,
            'lstimg_lstid'=>$this->lstimg_lstid,
            'lstimg_titulo'=>$this->lstimg_titulo,
            'lstimg_autor'=>$this->lstimg_autor,
            'lstimg_explica'=>$this->lstimg_explica,
        ];
        ##### Genera nombre de img y guarda en BD
        if($this->lstimg_imgid=='0'){
            ##### Crea nueva imagen y la sube
             $nombreImagen=$this->lstimg_jardin.'-'.$this->lstimg_lstid."_".
                'img.'.$this->lstimg_orden.
                $this->lstimg_nvaImg->getClientOriginalExtension();

            $this->lstimg_nvaImg->storeAs('public/listas',$nombreImagen);
            $datos['lstimg_img']='/listas/'.$nombreImagen;
            ##### Guarda en BD
            $bla=lista_img::create($datos);

        }else{
            ##### Guarda nombre de imagen
            $datos['lstimg_img']=$this->lstimg_img;
            ##### Guarda en BD
            lista_img::where('lstimg_id',$this->lstimg_imgid)->update($datos);
        }
        $this->dispatch('ImagenNuevaALista',dato1:'');
        ##### Cierra
        $this->CerrarModalDeListaImagen();
    }

    public function EliminarImagen(){
        ##### obtiene nombre y borra en BD
        $nombre=lista_img::where('lstimg_id',$this->lstimg_imgid)->first();
        lista_img::where('lstimg_id',$this->lstimg_imgid)->update(['lstimg_del'=>'1']);
        ##### Borra fisicamente
        $arch="/public".$nombre->lstimg_img;
        if(Storage::exists($arch)){
            Storage::delete($arch);
        }
        ##### CierraModal
        $this->CerrarModalDeListaImagen();
    }

    public function LimpiarModal(){
        $this->resetValidation();
        $this->resetErrorBag();
        $this->reset(['lstimg_nvaImg','lstimg_nvaImg', 'lstimg_img', 'lstimg_orden', 'lstimg_titulo', 'lstimg_autor', 'lstimg_explica']);
    }

    public function ActualizarDatosEnModalDeListaEspecie(){
        $img= lista_img::where('lstimg_lstid',$this->lstimg_imgid)
            ->where('lstimg_del','0')
            ->orderBy('lstimg_orden')
            ->get();
        $NvoId=$this->lstimg_lstid;
        $this->dispatch('VariableDesdeImagen',dato:$img, dato2:$NvoId);
    }

    public function CerrarModalDeListaImagen(){
        $this->ActualizarDatosEnModalDeListaEspecie();
        $this->LimpiarModal();
        $this->dispatch('CierraModalDeListaImagen',reload:0);
    }

    public function render() {
        return view('livewire.sistema.modal-lista-especie-imagen-component');
    }
}
