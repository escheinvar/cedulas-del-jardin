<?php

namespace App\Livewire\Sistema;

use Livewire\Component;

class ModalListaEspecieNombresLenguaComponent extends Component
{
    /*############################################## ModalLista_Imagenes
    ###################################################################
    ##### Este modal, requiere dos varables, url_cjarsiglas y url_urltxt
    ##### Copiar AbrirModalDeBuscarEspecie en controller disparador
    ##### <livewire:sistema.modal-lista-especie-usos-component />
    public function AbrirModalDeNombreLengua($id){
        $datos=[
            'jardin'=>$this->listasp_jardin,
            'lstId'=>$this->listasp_id,
            'lsusoId'=>$id,
        ];
        $this->dispatch('AbreModalDeNombreLengua',$datos);
    }
    ############################################################# */


    public function render(){
        return view('livewire.sistema.modal-lista-especie-nombres-lengua-component');
    }
}
