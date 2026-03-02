<?php

namespace App\Livewire\Sistema;

use App\Models\cat_autores;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class AutoresModalComponent extends Component
{
    use WithFileUploads;

    public $ModAut_IdAutor; ##### Variable con idde autor o 0 recibida desde componente
    ##### Variables de formulario:
    public $ModAut_nombre, $ModAut_apellido, $ModAut_autorname, $ModAut_correo;
    public $ModAut_institu, $ModAut_orcid, $ModAut_img, $ModAut_NvaImg;
    public $ModAut_web, $ModAut_mailpublic,$ModAut_tipo;

    #[On('AbreModalDeAutores')]
    public function recibeDatos($data){
        $this->ModAut_IdAutor=$data['cautId'];
        if($this->ModAut_IdAutor=='0'){
            $this->reset('ModAut_nombre','ModAut_apellido','ModAut_autorname','ModAut_correo', 'ModAut_institu','ModAut_orcid','ModAut_img','ModAut_NvaImg','ModAut_web', 'ModAut_mailpublic','ModAut_tipo');
        }else{
            $datos=cat_autores::where('caut_id',$this->ModAut_IdAutor)->first();

            $this->ModAut_nombre = $datos->caut_nombre;
            $this->ModAut_apellido = $datos->caut_apellidos;
            $this->ModAut_autorname = $datos->caut_nombreautor;
            $this->ModAut_correo = $datos->caut_correo;
            $this->ModAut_institu = $datos->caut_institu;
            $this->ModAut_orcid = $datos->caut_orcid;
            $this->ModAut_img = $datos->caut_img;
            $this->ModAut_tipo = $datos->caut_tipo;
            if($datos->caut_web=='1'){$this->ModAut_web=true;}else{$this->ModAut_web=false;}
            if($datos->caut_mailpublic=='1'){$this->ModAut_mailpublic=true;}else{$this->ModAut_mailpublic=false;}
        }
    }

    public function CierraModalAutores(){
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset('ModAut_nombre','ModAut_apellido','ModAut_autorname','ModAut_correo', 'ModAut_institu','ModAut_orcid','ModAut_img','ModAut_NvaImg','ModAut_web', 'ModAut_mailpublic','ModAut_tipo');
        $this->dispatch('CierraModalDeAutores',reload:1);
    }

    public function GuardarDatos(){
        ##### Valida cuestionario
        $this->validate([
            'ModAut_nombre'=>'required',
            'ModAut_apellido'=>'required',
            'ModAut_autorname'=>'required',
            'ModAut_tipo'=>'required',
        ]);

        ##### Transforma checkboxes
        if($this->ModAut_web==true){$web='1';}else{$web='0';}
        if($this->ModAut_mailpublic==true){$public='1';}else{$public='0';}

        ##### Construye nuevos datos
        $datos=[
            'caut_nombre'=>$this->ModAut_nombre,
            'caut_apellidos'=>$this->ModAut_apellido,
            'caut_nombreautor'=>$this->ModAut_autorname,
            'caut_correo'=>$this->ModAut_correo,
            'caut_institu'=>$this->ModAut_institu,
            'caut_orcid'=>$this->ModAut_orcid,
            'caut_tipo'=>$this->ModAut_tipo,
            'caut_web'=>$web,
            'caut_mailpublic'=>$public,
        ];

        ##### Guarda base de datos
        if($this->ModAut_IdAutor=='0'){
            $va=cat_autores::create($datos);
            $vaId=$va->caut_id;
            #### registra log
            paLog('Registra nuevo autor '.$this->ModAut_nombre.'_'.$this->ModAut_apellido.' en catálogo','cat_autores',$vaId );
        }else{
            cat_autores::where('caut_id',$this->ModAut_IdAutor)->update($datos);
            $vaId=$this->ModAut_IdAutor;
            #### registra log
            paLog('Edita datos de autor '.$this->ModAut_nombre.'_'.$this->ModAut_apellido.' en catálogo','cat_autores',$this->ModAut_IdAutor );
        }

        ##### Construye nombre de imagen y la guarda
        if($this->ModAut_NvaImg != ''){
            $nombre=  "autor_".str_pad($vaId,3,"0",STR_PAD_LEFT).".".$this->ModAut_NvaImg->getClientOriginalExtension();
            $this->ModAut_NvaImg->storeAs(path:'/public/avatar/autores/', name:$nombre);
            cat_autores::where('caut_id',$vaId)->update([
                'caut_img'=>'/avatar/autores/'.$nombre,
            ]);
            #### registra log
            paLog('Edita imagen de autor '.$this->ModAut_nombre.'_'.$this->ModAut_apellido.' en catálogo','cat_autores',$vaId );
        }
        #### Finaliza y cierra
        $this->CierraModalAutores();
    }

    public function BorrarImagen($IdAutor){
        cat_autores::where('caut_id',$IdAutor)->update([
            'caut_img'=>null,
        ]);
        $this->ModAut_img='';
        $this->ModAut_NvaImg='';
        ##### Genera log
        paLog('Se eliminó la imágen del autor id'.$IdAutor,'cat_autores',$IdAutor);

    }

    public function render(){
        return view('livewire.sistema.autores-modal-component');
    }
}
