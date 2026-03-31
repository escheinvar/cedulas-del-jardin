<?php

namespace App\Livewire\Sistema;

use App\Models\ced_autores;
use App\Models\ced_version;
use App\Models\cedulas_url;
use Livewire\Attributes\On;
use Livewire\Component;
use Safe\url;

class ModalCedulaCambiaEstadoComponent extends Component
{
 /*###########################################
    ##### Tabla de cambios de estado:
    edo       Autor   Editor  Administrador
    0crea     1       4       1,5
    1edita    -       2,4     2,5
    2revisa   3       4       1,5
    3edita    -       2,4     2,5
    4autori   -       -       1,2,5
    5publicado6       6       6
    6PideEdit -       2       1,2,cancela
 #############################################*/

    public $CambiaEdo_ced; #### first() de cedulas_url de esta cédula
    public $CambiaEdo_urlid, $CambiaEdo_urledo; ### valores específicos de cédula
    public $e0, $e1, $e2, $e3, $e4, $e5, $e6; #### flags. para activar o no botones
    public $verPublicar, $verDoi; ### Flags para mostrar o no secciones
    public $ErrorAlert, $NvoDoi, $CambiaEdo_version; #### valores de cuestionario

 /*############################################################
    ##### Este modal muestra opciones para cambio de estado de
    ##### una cédula. Para ejecutarse desde un componente externo, requiere
    ##### el Id de la cédula (url_id)
    public function AbreModalDeCambioDeEstado($id){
         $data=['urlId'=>$id];
        $this->dispatch('AbreModalCambiaEdoCedula',$data);
    }
 ##############################################################*/

    #[On('AbreModalCambiaEdoCedula')]
    public function montarDesdeExterno($data){
        $this->CambiaEdo_urlid=$data['urlId'];
        $this->CambiaEdo_urledo=cedulas_url::where('url_id',$data['urlId'])->value('url_edo');
        $this->CambiaEdo_ced=cedulas_url::where('url_id',$data['urlId'])
            ->with('autores')
            ->with('editores')
            ->with('traductores')
            ->with('ubicaciones')
            ->with('alias')
            ->with('especies')
            ->with('usos')
            ->first();
        $this->verPublicar='0';
    }

    public function VerNoVerDoi(){
        if($this->verDoi=='1'){
            $this->verDoi='0';
        }else{
            $this->verDoi='1';
        }

    }

    public function mount(){
        $this->verPublicar='0';
        $this->ErrorAlert='0';
        $this->verDoi='0';
        $this->CambiaEdo_version='0';
    }

    public function LimpiarModalDeCambiosDeEstado(){
        $this->reset(['ErrorAlert','verPublicar','verDoi', 'NvoDoi', 'e0', 'e1', 'e2', 'e3', 'e4', 'e5', 'e6']);
        $this->mount();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function CerrarModalDeCambioDeEstado(){
        $this->LimpiarModalDeCambiosDeEstado();
        $this->dispatch('CierraModalCambiaEdoCedula');
    }

    public function CambiaEstado($edo){
        ##### Cambia el estado de la cédula
        cedulas_url::where('url_id',$this->CambiaEdo_urlid)->update([
            'url_edo'=>$edo,
        ]);
        ##### Genera log
        paLog('La cédula '.$this->CambiaEdo_urlid.' se cambia a estado '.$edo,'cedulas_url',$this->CambiaEdo_urlid);
        ###### Manda correo electrónico

        ##### Cierra modal
        $this->dispatch('RecargarPagina');
        $this->CerrarModalDeCambioDeEstado();
    }

    public function PublicaCedula(){
        ##### Determina Año (solo en ciclo 0)
        if($this->CambiaEdo_ced->url_ciclo == '0'){
            $anio=date('Y');
        }else{
            $anio=$this->CambiaEdo_ced->url_anio;
        }

        ##### Calcula versión
        if($this->CambiaEdo_version=='1'){
            $version=$this->CambiaEdo_ced->url_version + 0.10;
            ##### Crea PDF

            ##### Guarda nueva versión
            ced_version::create([
                'ver_cedid'=>$this->CambiaEdo_ced->url_id,
                'ver_version'=>$version,
                'ver_mes'=>date('n'),
                'ver_anio'=>date('Y'),
                'ver_dia'=>date('d'),
                'ver_hora'=>date('H:i'),
                'ver_pdf'=>'MyPdf',
            ]);

        }else{
            $version=$this->CambiaEdo_ced->url_version;
        }

        ##### Genera Cita
        if($this->CambiaEdo_version=='1' OR $this->CambiaEdo_ced->url_ciclo=='0'){
            $num='0'; $cita=''; $autores='';$trads='';
            ##### Autores
            foreach($this->CambiaEdo_ced->autores as $a){
                $num++;
                $autores=$autores.$a->autor->caut_nombreautor;
                if($this->CambiaEdo_ced->autores->count() > '1' and $num==($this->CambiaEdo_ced->autores->count() - 1) ){
                    $autores=$autores.' y ';
                }elseif($this->CambiaEdo_ced->autores->count() > '1' and $num < ($this->CambiaEdo_ced->autores->count()-1)){
                    $autores=$autores.', ';
                }
            }
            ##### Año, titulo
            $cita=$autores.' '.$anio.' '.$this->CambiaEdo_ced->url_titulo.' ' ;

            ##### Traducción
            if($this->CambiaEdo_ced->url_tradid > '0'){
                ##### Lengua
                $trads='('.$this->CambiaEdo_ced->lenguas->len_lengua.'; ';
                ##### Traductores
                $num='0';
                foreach($this->CambiaEdo_ced->traductores as $a){
                    $num++;
                    $trads=$trads.$a->autor->caut_nombreautor;
                    if($this->CambiaEdo_ced->traductores->count() > '1' and $num==($this->CambiaEdo_ced->traductores->count() - 1) ){
                        $trads=$trads.' y ';
                    }elseif($this->CambiaEdo_ced->traductores->count() > '1' and $num < ($this->CambiaEdo_ced->traductores->count()-1)){
                        $trads=$trads.', ';
                    }
                }
                $trads=$trads.'). ';
            }
            ##### Version
            $cita=$cita.$trads.' v.'.$version;
            $cita=$cita.' Cédulas del Jardín en lenguas originarias. ';
            ##### URL
            if($this->CambiaEdo_ced->url_doi != ''){
                    $cita=$cita.'https://doi.org/'.$this->CambiaEdo_ced->url_doi;
            }else{
                $cita=$cita.url('/').'/'.$this->CambiaEdo_ced->url_cjarsiglas.'/'.$this->CambiaEdo_ced->url_url;
            }
        }else{
            // dd($this->CambioEdo_ced);
            $cita=$this->CambiaEdo_ced->url_cita;
            $autores=$this->CambiaEdo_ced->url_cita_aut;
            $trads=$this->CambiaEdo_ced->url_cita_trad;
        }

        ##### Cambia el estado de la cédula
        cedulas_url::where('url_id',$this->CambiaEdo_urlid)->update([
            'url_edo'=>'5',
            'url_edit'=>'0',
            'url_ciclo'=>$this->CambiaEdo_ced->url_ciclo + 1,
            'url_version'=>$version,
            'url_cita'=>$cita,
            'url_cita_aut'=>$autores,
            'url_cita_trad'=>$trads,
            'url_anio'=>$anio,
        ]);
        ##### Genera log
        paLog('Se publica cédula','cedulas_url',$this->CambiaEdo_urlid);
        ###### Manda correo electrónico

        ##### Cierra modal
        $this->dispatch('RecargarPagina');
        $this->CerrarModalDeCambioDeEstado();

    }

    public function ConfirmarPublicacion(){
        ##### Valida que haya todos los datos
        if(($this->CambiaEdo_ced->autores->count() < '1') OR
          ($this->CambiaEdo_ced->editores->count() < '1') OR
          (($this->CambiaEdo_ced->url_tradid > '0') AND ($this->CambiaEdo_ced->traductores->count() < '1')) OR
          ($this->CambiaEdo_ced->ubicaciones->count() < '1') OR
          ($this->CambiaEdo_ced->alias->count() < '1')  ){
            $this->ErrorAlert='1';
            $this->verPublicar='0';
            return;
        }else{
            ##### Cambia flag a 1 para ver sección
            $this->verPublicar='1';
        }
    }

    public function RegistrarDoi(){
        ##### valida campo
        $this->validate([
            'NvoDoi'=>'required',
        ]);
        ##### valida estructura de DOI
        ##### Guarda DOI
        cedulas_url::where('url_id',$this->CambiaEdo_ced->url_id)->update([
            'url_doi'=>$this->NvoDoi,
        ]);

        ##### Genera Doi
        paLog('Vincula DOI a cédula','url_doi',$this->CambiaEdo_ced->url_id);

        ##### Actualiza datos
        $this->CambiaEdo_ced->url_doi=$this->NvoDoi;

        ##### Cierra sección
        $this->verDoi='0';
    }

    public function BorrarDoi(){
        ##### Guarda DOI
        cedulas_url::where('url_id',$this->CambiaEdo_ced->url_id)->update([
            'url_doi'=>null,
        ]);

        ##### Genera Doi
        paLog('Se borró DOI de cédula','url_doi',$this->CambiaEdo_ced->url_id);

        ##### Actualiza datos
        $this->CambiaEdo_ced->url_doi=null;
    }

    public function GeneraVersion() {
        dd('Genera pdf con versión y lo guarda');
    }

    public function render() {
        if($this->CambiaEdo_urlid > '0'){
            ################## Verifica estado
            if(array_intersect(['admin'],session('rol')) ){
                if($this->CambiaEdo_urledo=='0'){      $this->e0=''; $this->e1=''; $this->e2='disabled'; $this->e3='disabled'; $this->e4='disabled'; $this->e5=''; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='1'){ $this->e0='disabled'; $this->e1=''; $this->e2=''; $this->e3='disabled'; $this->e4='disabled'; $this->e5=''; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='2'){ $this->e0='disabled'; $this->e1=''; $this->e2=''; $this->e3='disabled'; $this->e4='disabled'; $this->e5=''; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='3'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2=''; $this->e3=''; $this->e4='disabled'; $this->e5=''; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='4'){ $this->e0='disabled'; $this->e1=''; $this->e2=''; $this->e3='disabled'; $this->e4=''; $this->e5=''; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='5'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='disabled'; $this->e3='disabled'; $this->e4='disabled'; $this->e5=''; $this->e6='';
                }elseif($this->CambiaEdo_urledo=='6'){ $this->e0='disabled'; $this->e1='1'; $this->e2='1'; $this->e3='disabled'; $this->e4='disabled'; $this->e5=''; $this->e6='';}

            }elseif(array_intersect(['editor'],session('rol')) ){
                if($this->CambiaEdo_urledo=='0'){      $this->e0=''; $this->e1='disabled'; $this->e2='disabled'; $this->e3='disabled'; $this->e4=''; $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='1'){ $this->e0='disabled'; $this->e1=''; $this->e2=''; $this->e3='disabled'; $this->e4=''; $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='2'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2=''; $this->e3='disabled'; $this->e4=''; $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='3'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2=''; $this->e3=''; $this->e4=''; $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='4'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='disabled'; $this->e3='disabled'; $this->e4=''; $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='5'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='disabled'; $this->e3='disabled'; $this->e4='disabled'; $this->e5=''; $this->e6='';
                }elseif($this->CambiaEdo_urledo=='6'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2=''; $this->e3='disabled'; $this->e4='disabled'; $this->e5='disabled'; $this->e6='';}

            }elseif(array_intersect(['autor','traductor'],session('rol')) ){
                if($this->CambiaEdo_urledo=='0'){          $this->e0=''; $this->e1=''; $this->e2='disabled'; $this->e3='disabled'; $this->e4='disabled'; $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='1'){ $this->e0='disabled'; $this->e1=''; $this->e2='disabled'; $this->e3='disabled'; $this->e4='disabled'; $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='2'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2=''; $this->e3=''; $this->e4='disabled'; $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='3'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='disabled'; $this->e3=''; $this->e4='disabled'; $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='4'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='disabled'; $this->e3='disabled'; $this->e4=''; $this->e5='disabled'; $this->e6='disabled';
                }elseif($this->CambiaEdo_urledo=='5'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='disabled'; $this->e3='disabled'; $this->e4='disabled'; $this->e5=''; $this->e6='';
                }elseif($this->CambiaEdo_urledo=='6'){ $this->e0='disabled'; $this->e1='disabled'; $this->e2='disabled'; $this->e3='disabled'; $this->e4='disabled'; $this->e5='disabled'; $this->e6='';}
            }
        }else{
            $this->CambiaEdo_urlid='0';
            $this->CambiaEdo_urledo='6';
            $this->e0='disabled'; $this->e1='disabled'; $this->e2='disabled'; $this->e3='disabled'; $this->e4='disabled'; $this->e5='disabled'; $this->e6='disabled';
        }

        return view('livewire.sistema.modal-cedula-cambia-estado-component');
    }
}
