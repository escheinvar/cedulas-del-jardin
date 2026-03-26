<?php

namespace App\Livewire\Sistema;

use App\Models\CatEntidadesInegiModel;
use App\Models\CatMunicipiosInegiModel;
use App\Models\ced_sp;
use App\Models\ced_ubica;
use App\Models\cedulas_url;
use Livewire\Attributes\On;
use Livewire\Component;

class ModalCedulaUbicacionesComponent extends Component
{
    ##### Variables recibidas desde fuera
    public $ubica_ubicaId, $ubica_id;
    ##### Variables de la modal
    public $ubica_url, $ubica_copia;
    public $ubica_edo, $ubica_mpio, $ubica_localidad, $ubica_paraje;
    public $ubica_ubicacion, $ubica_ubicacion_tr, $ubica_x, $ubica_y;

    /*############################################## ModalAlias_uso
    ###################################################################
    ##### Este modal, requiere una varable:
    public function AbrirModalDeUbicacion(){
        $datos=[
            'ubicaId'=>'0' #### para nueva, o ubica_id con id de ubicación a editar
            'urlid'=>IdDeCedula(url_id)
        ];
        $this->dispatch('AbreModalAsignaUbicacion',$datos);
    }
    #################################################################### */


    #[On('AbreModalAsignaUbicacion')]
    public function montarDatos($datos){
        ##### recibe variables externas
        $this->ubica_ubicaId=$datos['ubicaId'];
        $this->ubica_id=$datos['urlid'];
        $this->ubica_url=cedulas_url::where('url_id',$this->ubica_id)->first();
        if($this->ubica_ubicaId > '0'){
            ###### carga datos de la ubicación
            $dato=ced_ubica::where('ubi_id',$this->ubica_ubicaId)->first();
            // dd($dato);
            ##### asigna variables
            $this->ubica_edo=$dato->ubi_edo;
            $this->ubica_mpio=$dato->ubi_mpio;
            $this->ubica_localidad=$dato->ubi_localidad;
            $this->ubica_paraje=$dato->ubi_paraje;
            $this->ubica_ubicacion=$dato->ubi_ubicacion;
            $this->ubica_ubicacion_tr=$dato->ubi_ubicacion_tr;
            $this->ubica_x=$dato->ubi_x;
            $this->ubica_y=$dato->ubi_y;
        }
    }

    public function mount(){
        $this->ubica_ubicaId='0';
        $this->ubica_id='';
        $this->ubica_copia='1';
        $this->ubica_edo='';
        $this->ubica_mpio='';
    }

    public function LimpiarModalDeUbicacion(){
        $this->reset(['ubica_url','ubica_copia','ubica_edo','ubica_mpio','ubica_localidad','ubica_paraje','ubica_ubicacion','ubica_ubicacion_tr','ubica_x','ubica_y']);
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function CerrarModalDeUbicacion(){
        $this->LimpiarModalDeUbicacion();
        $this->dispatch('CierraModalAsignaUbicacion');
    }

    public function CalculaTextoUbicacion(){
        $this->reset('ubica_ubicacion');
        if($this->ubica_edo != '' ){$ubica=$this->ubica_edo.", México.";}
        if($this->ubica_mpio != '') {$ubica=$this->ubica_mpio.", ".$this->ubica_edo.", México";}
        if($this->ubica_localidad != ''){$loc=". Localidad ".$this->ubica_localidad;}else{$loc="";}
        if($this->ubica_paraje != ''){$par=" (paraje ".$this->ubica_paraje.")";}else{$par="";}
        $this->ubica_ubicacion=$ubica.$loc.$par;
    }

    public function GuardarUbicacion(){
        #### Valida que coords sean numericas
        if($this->ubica_x != '' OR $this->ubica_y != ''){
            $this->validate([
                'ubica_x'=>'required|numeric',
                'ubica_y'=>'required|numeric',
            ]);
        }
        #### Valida que haya traducción
        if($this->ubica_copia=='1'){
            $this->validate(['ubica_ubicacion'=>'required', 'ubica_ubicacion_tr'=>'required']);

        }else{
            $this->validate(['ubica_ubicacion'=>'required']);
            $this->ubica_ubicacion_tr=$this->ubica_ubicacion;
        }

        ##### agrupa datos
        $datos=[
            'ubi_cjarsiglas'=>$this->ubica_url->url_cjarsiglas,
            // 'ubi_urlid'=>$this->ubica_url->url_id,
            'ubi_urltxt'=>$this->ubica_url->url_urltxt,
            // 'ubi_urlurl'=>$this->ubica_url->url_url,
            'ubi_edo'=>$this->ubica_edo,
            'ubi_mpio'=>$this->ubica_mpio,
            'ubi_localidad'=>$this->ubica_localidad,
            'ubi_paraje'=>$this->ubica_paraje,
            'ubi_x'=>$this->ubica_x,
            'ubi_y'=>$this->ubica_y,
            'ubi_ubicacion'=>$this->ubica_ubicacion,
            'ubi_ubicacion_tr'=>$this->ubica_ubicacion_tr,
        ];
        if($this->ubica_ubicaId=='0'){
            ##### Genera lista de todas las traducciones (para poner nueva ubicación en todas)
            $hermanitos=cedulas_url::where('url_cjarsiglas',$this->ubica_url->url_cjarsiglas)
                ->where('url_urltxt',$this->ubica_url->url_urltxt)
                ->get();

            foreach($hermanitos as $h){
                #### Agrupa datos
                $datosh=$datos;
                $datosh['ubi_urlid']=$h->url_id;
                $datosh['ubi_urlurl']=$h->url_url;
                ##### Guarda datos:
                $nvo=ced_ubica::create($datosh);
                #### Genera log
                paLog('Se generó ubicación de '.$this->ubica_url->url_url, 'ced_ubica',$nvo->ubi_id);
            }
            ##### Da aviso
            $this->dispatch('AvisoExitoAsignaUbica',msj:'Se generó exitosamente el registro de ubicación');
        }else{
            ##### guarda datos
            ced_ubica::where('ubi_id',$this->ubica_ubicaId)->update($datos);
            #### Genera log
            paLog('Se editaron datos de ubicación de '.$this->ubica_url->url_url, 'ced_ubica',$this->ubica_ubicaId);
            ##### Da aviso
            $this->dispatch('AvisoExitoAsignaUbica',msj:'Se editó exitosamente el registro de ubicación');
        }

        ##### Actualiza datos
        $ja=cedulas_url::where('url_id',$this->ubica_url->url_id)
            ->with('autores')
            ->with('ubicaciones')
            ->first();
        $dato=$ja->ubicaciones;
        $this->dispatch('RecibeVariablesDeUbicacion',dato:$dato);

        ##### Cierra
        $this->CerrarModalDeUbicacion();
    }

    public function EliminarUbicacion(){
        ced_ubica::where('ubi_cjarsiglas',$this->ubica_url->url_cjarsiglas)
            ->where('ubi_urltxt',$this->ubica_url->url_urltxt)
            ->update([
                'ubi_del'=>'1',
            ]);
        paLog('Se borraron todas las ubicaciones de '.$this->ubica_url->url_cjarsiglas."/".$this->ubica_url->url_urltxt, 'ced_ubica','varios');
        // ced_ubica::where('ubi_id',$this->ubica_ubicaId)->update([
        //     'ubi_del'=>'1',
        // ]);
        ##### Actualiza datos
        $ja=cedulas_url::where('url_id',$this->ubica_url->url_id)
            ->with('autores')
            ->with('ubicaciones')
            ->first();
        $dato=$ja->ubicaciones;
        $this->dispatch('RecibeVariablesDeUbicacion',dato:$dato);

        $this->CerrarModalDeUbicacion();
    }

    public function render(){
        ##### Determina si es copia o no
        if($this->ubica_url AND $this->ubica_url->url_urltxt== $this->ubica_url->url_url){
            $this->ubica_copia='0';
        }else{
            $this->ubica_copia='1';
        }
        ##### Carga estados de la rep
        $mpios=CatMunicipiosInegiModel::where('cmun_edoname',$this->ubica_edo)
            ->orderBy('cmun_mpioname')
            ->get();

        return view('livewire.sistema.modal-cedula-ubicaciones-component',[
            'edos'=>CatEntidadesInegiModel::get(),
            'mpios'=>$mpios,
        ]);
    }
}
