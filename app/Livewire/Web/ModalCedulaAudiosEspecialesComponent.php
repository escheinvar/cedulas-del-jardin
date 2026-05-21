<?php

namespace App\Livewire\Web;

use App\Models\cedulas_url;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;


class ModalCedulaAudiosEspecialesComponent extends Component
{
    use WithFileUploads;

    public $modal_urlId, $modal_tipo;
    public $NuevoTituloTraducido, $NuevoAudio, $url, $modal_archivo;

    /*########################################################
    ###### Para ejecutar:
    public function AbirModalTraduceTitulo($tipo){
        #####<livewire: web.web.cedulas.controller  />
        $data=[
            'urlId'=>$this->url->url_id,
            'tipo'=>$tipo,
            // 'NuevoTituloTraducido'=>$this->url->url_titulo,
        ];
        $this->dispatch('AbreModalTraduceTitulo', $data);
    }
    #########################################################*/
    #[On('AbreModalTraduceTitulo')]
    public function montarModal($data){
        $this->modal_urlId = $data['urlId'];
        $this->modal_tipo = $data['tipo'];
        $this->url = cedulas_url::where('url_id',$this->modal_urlId)->first();

        if($this->modal_tipo == 'Titulo'){
            $this->NuevoTituloTraducido = $this->url->url_titulo;
            $this->modal_archivo = $this->url->url_audiotitulo;
        }elseif($this->modal_tipo == 'Autores'){
            $this->NuevoTituloTraducido ='';
            $this->modal_archivo = $this->url->url_audioautor;


        }elseif($this->modal_tipo == 'Traductor'){
            $this->NuevoTituloTraducido = '';
            $this->modal_archivo = $this->url->url_audiotraductor;

        }
    }

    public function mount(){
        // $this->url = collect();
    }
    public function CerrarModalTraduceTitulo(){
        #####<livewire: web.web.cedulas.controller  />
        $this->dispatch('CierraModalTraduceTitulo');
        $this->dispatch('RecargarPagina');
    }

    public function GuardaTituloTraducido(){
        if($this->modal_tipo == 'Título'){
            $this->validate([
                'NuevoTituloTraducido'=>'required'
            ]);
            cedulas_url::where('url_id',$this->url->url_id)->update([
                'url_titulo'=>$this->NuevoTituloTraducido,
            ]);
        }

        cedulas_url::where('url_id',$this->url->url_id)->update([
            'url_titulo'=>$this->NuevoTituloTraducido,
        ]);
        redirect('/cedula/'.$this->url->url_cjarsiglas.'/'.$this->url->url_url);
    }

    public function SubirAudioTitulo(){
        if($this->NuevoAudio){
            #### valida formulario
            $this->validate([
                'NuevoAudio'=>'file|mimes:audio/mpeg,mpga,mp3,wav,ogg,aac|max:10240', // Máximo 10MB
            ]);
            if($this->modal_tipo == 'Titulo'){
                $txt = 'titulo';
            }elseif($this->modal_tipo == 'Autores'){
                $txt = 'autor';
            }elseif($this->modal_tipo == 'Traductor'){
                $txt = 'traductor';
            }

            #### Genera nombre de archivo y ruta
            $nombreArchivo = $this->url->url_urltxt.'_'.$this->url->url_cjarsiglas.'_'.$this->url->url_lencode.'_00_'.$txt.'.'.$this->NuevoAudio->getClientOriginalExtension();
            $rutaArchivo = '/cedulas/audios/';

            ##### Guarda archivo
            $this->NuevoAudio->storeAs('/public'.$rutaArchivo, $nombreArchivo);

            ##### Modifica base de datos
            if($this->modal_tipo == 'Titulo'){
                cedulas_url::where('url_id',$this->url->url_id)->update([
                    'url_audiotitulo'=>$rutaArchivo.$nombreArchivo,
                ]);

            }elseif($this->modal_tipo == 'Autores'){
                cedulas_url::where('url_id',$this->url->url_id)->update([
                    'url_audioautor'=>$rutaArchivo.$nombreArchivo,
                ]);
                $this->CerrarModalTraduceTitulo();

            }elseif($this->modal_tipo == 'Traductor'){
                cedulas_url::where('url_id',$this->url->url_id)->update([
                    'url_audiotraductor'=>$rutaArchivo.$nombreArchivo,
                ]);
                $this->CerrarModalTraduceTitulo();


            }
            $this->modal_archivo = $rutaArchivo.$nombreArchivo;


            $this->url->url_audiotitulo = $rutaArchivo.$nombreArchivo;
        }
    }

    public function EliminarAudioTitulo(){
        ##### Modifica base de datos
        if($this->modal_tipo == 'Titulo'){
            cedulas_url::where('url_id',$this->url->url_id)->update([
                'url_audiotitulo'=>null,
            ]);

        }elseif($this->modal_tipo == 'Autores'){
            cedulas_url::where('url_id',$this->url->url_id)->update([
                'url_audioautor'=>null,
            ]);
        }elseif($this->modal_tipo == 'Traductor'){
            cedulas_url::where('url_id',$this->url->url_id)->update([
                'url_audiotraductor'=>null,
            ]);
        }
        $this->modal_archivo = null;
    }

    public function render(){
        return view('livewire.web.modal-cedula-audios-especiales-component');
    }
}
