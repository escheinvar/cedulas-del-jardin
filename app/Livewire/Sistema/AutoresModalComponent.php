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
    public $ModAut_jardin, $ModAut_nombre, $ModAut_apellido1, $ModAut_apellido2, $ModAut_url, $ModAut_autorname, $ModAut_correo;
    public $ModAut_institu, $ModAut_orcid, $ModAut_img, $ModAut_NvaImg;
    public $ModAut_web, $ModAut_mailpublic,$ModAut_tipo;

    #[On('AbreModalDeAutores')]
    public function recibeDatos($data){
        $this->ModAut_IdAutor=$data['cautId'];
        $this->ModAut_jardin=$data['cjarsiglas'];

        if($this->ModAut_IdAutor=='0'){
            $this->LimpiaModalAutores();

        }else{
            $datos=cat_autores::where('caut_id',$this->ModAut_IdAutor)->first();
            $this->ModAut_jardin= $datos->caut_cjarsiglas;
            $this->ModAut_nombre = $datos->caut_nombre;
            $this->ModAut_apellido1 = $datos->caut_apellido1;
            $this->ModAut_apellido2 = $datos->caut_apellido2;
            $this->ModAut_url = $datos->caut_url;
            $this->ModAut_autorname = $datos->caut_nombreautor;
            $this->ModAut_correo = $datos->caut_correo;
            $this->ModAut_institu = $datos->caut_institu;
            $this->ModAut_orcid = $datos->caut_orcid;
            $this->ModAut_img = $datos->caut_img;
            // $this->ModAut_tipo = $datos->caut_tipo;
            if($datos->caut_web=='1'){$this->ModAut_web=true;}else{$this->ModAut_web=false;}
            if($datos->caut_mailpublic=='1'){$this->ModAut_mailpublic=true;}else{$this->ModAut_mailpublic=false;}
        }
    }

    public function LimpiaModalAutores(){
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset('ModAut_nombre','ModAut_apellido1','ModAut_apellido2','ModAut_url','ModAut_autorname','ModAut_correo', 'ModAut_institu','ModAut_orcid','ModAut_img','ModAut_NvaImg','ModAut_web', 'ModAut_mailpublic','ModAut_tipo');
    }

    public function CierraModalAutores(){
        $this->LimpiaModalAutores();
        $this->dispatch('CierraModalDeAutores',reload:1);
    }

    public function  CalculaNombre(){
        $ap1=ucwords(strtolower($this->ModAut_apellido1));
        $ap2=ucwords(strtolower($this->ModAut_apellido2));
        $nom=substr(strtoupper($this->ModAut_nombre), 0,1);
        $this->ModAut_autorname=$ap1."-".$ap2." ".$nom.".";
        $this->ModAut_url=strtolower(preg_replace('/[^a-zA-Z0-9]/', '',   quitarAcentos($this->ModAut_autorname)));
    }

    public function CalculaUrl(){
        $entra=$this->ModAut_autorname;
        $sale=quitarAcentos($entra);
        $sale=preg_replace('/[^a-zA-Z0-9]/', '', $sale);
        $this->ModAut_url=strtolower($sale);
    }

    public function GuardarDatos(){
        ##### Valida cuestionario
        $this->validate([
            'ModAut_nombre'=>'required',
            'ModAut_apellido1'=>'required',
            'ModAut_autorname'=>'required',
            'ModAut_url'=>'required',
        ]);

        ##### Valida url sea única
        $busca=cat_autores::where('caut_url','ilike',$this->ModAut_url)
            ->where('caut_del','0')->where('caut_act','1')
            ->where('caut_id','!=',$this->ModAut_IdAutor)
            ->count();
        // dd($this->ModAut_url, $busca);
        if($busca > '0'){
            $this->addError('ModAut_autorname','Este nombre de autor ya está registrado!');
            return;
        }

        ##### Transforma checkboxes
        if($this->ModAut_web==true){$web='1';}else{$web='0';}
        if($this->ModAut_mailpublic==true){$public='1';}else{$public='0';}

        ##### Construye nuevos datos
        $datos=[
            'caut_cjarsiglas'=>$this->ModAut_jardin,
            'caut_nombre'=>$this->ModAut_nombre,
            'caut_apellido1'=>$this->ModAut_apellido1,
            'caut_apellido2'=>$this->ModAut_apellido2,
            'caut_nombreautor'=>$this->ModAut_autorname,
            'caut_correo'=>$this->ModAut_correo,
            'caut_institu'=>$this->ModAut_institu,
            'caut_orcid'=>$this->ModAut_orcid,
            // 'caut_tipo'=>$this->ModAut_tipo,
            'caut_url'=>$this->ModAut_url,
            'caut_web'=>$web,
            'caut_mailpublic'=>$public,
        ];

        ##### Guarda base de datos
        if($this->ModAut_IdAutor=='0'){
            $va=cat_autores::create($datos);
            $vaId=$va->caut_id;
            #### registra log
            paLog('Registra nuevo autor '.$this->ModAut_nombre.'_'.$this->ModAut_apellido1.' en catálogo','cat_autores',$vaId );
        }else{
            cat_autores::where('caut_id',$this->ModAut_IdAutor)->update($datos);
            $vaId=$this->ModAut_IdAutor;
            #### registra log
            paLog('Edita datos de autor '.$this->ModAut_nombre.'_'.$this->ModAut_apellido1.' en catálogo','cat_autores',$this->ModAut_IdAutor );
        }

        ##### Construye nombre de imagen y la guarda
        if($this->ModAut_NvaImg != ''){
            $nombre=  "autor_".str_pad($vaId,3,"0",STR_PAD_LEFT).".".$this->ModAut_NvaImg->getClientOriginalExtension();
            $this->ModAut_NvaImg->storeAs(path:'/public/avatar/autores/', name:$nombre);
            cat_autores::where('caut_id',$vaId)->update([
                'caut_img'=>'/avatar/autores/'.$nombre,
            ]);
            #### registra log
            paLog('Edita imagen de autor '.$this->ModAut_nombre.'_'.$this->ModAut_apellido1.' en catálogo','cat_autores',$vaId );
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
