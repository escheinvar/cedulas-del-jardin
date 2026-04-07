<?php

namespace App\Livewire\Sistema;

use App\Models\cat_autores;
use App\Models\Imagenes;
use App\Models\cedulas_txt;
use App\Models\cedulas_url;
use App\Models\jardin_txt;
use App\Models\jardin_url;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class ModalEditaParrafoComponent extends Component
{
    use WithFileUploads;

    /*###########################################################
    ####### poner esta función en controlador que dispara
    #######   $id=jar_id  y  $orden=$jar_orden de tabal jardin_txt
    #######
    public function AbreModalEditaParrafo($id, $orden, $modulo, $jardin, $url, $reload){
        #####<livewire:sistema.modal-edita-parrafo-component />
        $data=[
            'id'=>$id,  #### id del párrafo o 0 para nuevo
            'orden'=>$orden, ##### Orden en el que aparece
            'modulo'=>$modulo, ##### Módulo en el que aparece (cedula, autor, jardin)
            'jardin'=>$jardin, ##### Jardín al que pertenece el párrafo
            'url'=>$key,  ##### url al que pertenece el párrafo
            'reload'=>'1', ##### flag de reinicio
           ];
        $this->dispatch('AbreModalDeParrafoWebJardin',$data);
    }
    ###########################################################*/

    ##### vars. recibidas desde externo con datos de quien se está editando:
    public $modJar_id, $modJar_orden, $modJar_modulo, $modJar_url, $modJar_cjarsiglas, $modJar_reload;
    ##### vars. del formulario_
    public $modJar_txt, $modJar_tipo, $modJar_archs, $VerOriginal, $VerHtml, $modJar_original;
    public $modJar_NvoAudio, $modJar_Audio, $modJar_Objetos, $modJar_VerModulo;


    #[On('AbreModalDeParrafoWebJardin')]
    public function recibeDatos($data){
        ##### Carga vars que vienen de controlador externo
        $this->modJar_id=$data['id'];
        $this->modJar_orden=$data['orden'];
        $this->modJar_modulo=$data['modulo'];
        $this->modJar_url=$data['url'];
        $this->modJar_cjarsiglas=$data['jardin'];
        $this->modJar_reload=$data['reload'];

        ############# Carga variables cuando id=0
        if($this->modJar_id=='0'){
            $this->modJar_txt='';
            $this->modJar_Audio='';
            $this->modJar_tipo='p';
            $copiaUorig='0';
            ##### Calcula orden nuevo:
            if($this->modJar_modulo=='cedula'){
                $ord=cedulas_txt::where('txt_cjarsiglas',$this->modJar_cjarsiglas)
                    ->where('txt_urlurl', $this->modJar_url)
                    ->where('txt_act','1')
                    ->where('txt_del','0')
                    ->max('txt_orden');
                $this->modJar_orden=$ord+1;


            }elseif(in_array($this->modJar_modulo,['inicio','autores','cedulas']) ){
                $ord=jardin_txt::where('jar_cjarsiglas',$this->modJar_cjarsiglas)
                    ->where('jar_urljurl', $this->modJar_url)
                    ->where('jar_act','1')
                    ->where('jar_del','0')
                    ->max('jar_orden');
                $this->modJar_orden=$ord+1;

            }elseif($this->modJar_modulo=='autor'){
                // $this->modJar_orden=$ord+1;

            }

        ############# Carga variables cuando id > 0
        }else{
            #######################################################
            ################ Carga variables de cedula (cedulas_txt)
            if($this->modJar_modulo=='cedula'){

                $dato=cedulas_txt::where('txt_id',$this->modJar_id)
                    ->with('url')
                    ->first();

                $this->modJar_tipo=$dato->txt_tipo;
                $this->modJar_orden=$dato->txt_orden;
                $this->modJar_txt=$dato->txt_txt;
                $this->modJar_Audio=$dato->txt_audio;
                $copiaUorig= $dato->url->url_tradid;

            #######################################################
            ############################ Carga variables de autor
            }elseif($this->modJar_modulo=='autor'){


            #######################################################
            ############################ Carga variables de inicio,
            ############################ autores, cedulas y otros (jardin_txt)
            // }elseif(in_array($this->modJar_modulo,['inicio','autores','cedulas']) ){
            }else{
                $dato=jardin_txt::where('jar_id',$this->modJar_id)
                    ->with('url')
                    ->first();
                $this->modJar_txt=$dato->jar_txt;
                $this->modJar_Audio=$dato->jar_audio;
                $copiaUorig= $dato->url->urlj_tradid;
            }

        }

        if($copiaUorig=='0'){
            // $this->modJar_original=jardin_txt::where('jar_id',$copiaUorig)->value('')
            $this->modJar_original='Este es un documento original';
        }else{
            $this->modJar_original=$dato->jar_txtoriginal;
        }
    }


    public function mount(){
        $this->VerHtml='0';
        $this->VerOriginal='0';
        $this->modJar_Objetos=collect();
        $this->modJar_VerModulo='web';
    }

    public function LimpiarModal(){
        $this->resetErrorBag();
        $this->resetValidation();
        $this->reset('modJar_txt','modJar_archs', 'modJar_original', 'modJar_NvoAudio', 'modJar_Audio');
    }

    public function CierraModalEditaTextoWebJardin(){
        $this->LimpiarModal();
        $this->dispatch('CierraModalDeParrafoWebJardin',reload:1);
    }

    public function GuardarDatos(){
        ##### Valida datos
        $this->validate([
            'modJar_orden'=>'required',
            'modJar_txt'=>'required',
        ]);

        ######################################################
        ############### Guarda en caso de cedulas (cedulas_txt)
        if($this->modJar_modulo=='cedula'){
            ##### Genera arreglo de datos
            $dato=[
                // 'url_id'=>$this->modJar_id,
                'txt_cjarsiglas'=>$this->modJar_cjarsiglas,
                'txt_urlid'=>cedulas_url::where('url_cjarsiglas',$this->modJar_cjarsiglas)->where('url_url',$this->modJar_url)->first()->value('url_id'),
                'txt_urlurl'=>$this->modJar_url,
                'txt_tipo'=>$this->modJar_tipo,
                'txt_orden'=>$this->modJar_orden,
                'txt_txt'=>$this->modJar_txt,

            ];

            ##### Guarda BD
            if($this->modJar_id == '0'){
                // $dato['txt_id']=$this->modJar_id;
                $bla=cedulas_txt::create($dato);
                $id=$bla->txt_id;
            }else{
                cedulas_txt::where('txt_id', $this->modJar_id)->update($dato);
                $id=$this->modJar_id;
            }
            ##### Guarda archivo de audio
            if($this->modJar_NvoAudio != ''){
                ##### Construye nombre
                $nombre=$this->modJar_cjarsiglas . "_" . $this->modJar_url . str_pad($this->modJar_orden,3,"0",STR_PAD_LEFT) . "." . $this->modJar_NvoAudio->getClientOriginalExtension();
                $ruta="/aud/";
                ##### Guarda archivo
                $this->modJar_NvoAudio->storeAs(path:'/public/'.$ruta, name:$nombre);
                ##### Guarda en BD
                cedulas_txt::where('txt_id',$id)->update([
                    'txt_audio'=>$ruta.$nombre
                ]);
                ##### hace log
                paLog('Se agrega nuevo audio','cedula_txt',$id);
            }

        ######################################################
        ############### Guarda en caso de autor (autor_txt)
        }elseif($this->modJar_modulo=='autor'){

        ######################################################
        ############### Guarda en caso de inicio, autores,
        ############### cedulas u otros (cedulas_txt)
        // }elseif(in_array($this->modJar_modulo,['inicio','autores','cedulas']) ){
        }else{
            $urljId=jardin_url::where('urlj_cjarsiglas',$this->modJar_cjarsiglas)
                ->where('urlj_url',$this->modJar_url)
                ->first()
                ->value('urlj_id');
            ##### Genera arreglo de datos
            $dato=[
                'jar_urljid'=> $urljId,
                'jar_urljurl'=>$this->modJar_url,
                'jar_cjarsiglas'=>$this->modJar_cjarsiglas,
                'jar_orden'=>$this->modJar_orden,
                'jar_txt'=>$this->modJar_txt,
                'jar_txtoriginal'=>$this->modJar_txt,
            ];

            ##### Guarda BD
            if($this->modJar_id == '0'){
                $bla=jardin_txt::create($dato);
                $id=$bla->jar_id;
            }else{
                jardin_txt::where('jar_id', $this->modJar_id)->update($dato);
                $id=$this->modJar_id;
            }
            ##### Guarda archivo de audio
            if($this->modJar_NvoAudio != ''){
                ##### Construye nombre
                $nombre=$this->modJar_cjarsiglas . "_" . $this->modJar_url . str_pad($this->modJar_orden,3,"0",STR_PAD_LEFT) . "." . $this->modJar_NvoAudio->getClientOriginalExtension();
                $ruta="/aud/";
                ##### Guarda archivo
                $this->modJar_NvoAudio->storeAs(path:'/public/'.$ruta, name:$nombre);
                ##### Guarda en BD
                jardin_txt::where('jar_id',$id)->update([
                    'jar_audio'=>$ruta.$nombre
                ]);
                ##### hace log
                paLog('Se agrega nuevo audio','jardin_txt',$id);

            }

            //a
        }

        #### Finaliza y cierra
        $this->CierraModalEditaTextoWebJardin();
    }

    public function VerOnoVerCodigoHtml(){
        if($this->VerHtml=='1'){
            $this->VerHtml ='0';
        }else{
            $this->VerHtml='1';
        }
    }

    public function VerONoVerOriginal(){
        if($this->VerOriginal=='1'){
            $this->VerOriginal ='0';
        }else{
            $this->VerOriginal='1';
        }
    }

    #[On('event-from-js')]
    public function CuandoInsertaTexto($codigo){
        $this->modJar_txt=$codigo;
    }

    public function SubirAudio(){
        ##### Valida archivo de audio
        $this->validate([
            'modJar_NvoAudio'=>'required|file|mimes:ogg,mpeg,wav,flac|max:10240',
        ]);
        $this->modJar_Audio= $this->modJar_NvoAudio->temporaryUrl();
    }

    public function BorrarAudio(){
        ########################################
        ############### Borra en caso de cedula
        if($this->modJar_modulo=='cedula'){
            cedulas_txt::where('txt_id',$this->modJar_id)->update([
                'txt_audio'=>null,
            ]);
            $this->modJar_NvoAudio='';
            $this->modJar_Audio='';
            ##### log
            paLog('Se eliminó el audio','jardin_txt',$this->modJar_id);

        ########################################
        ############### Borra en caso de autor
        }elseif($this->modJar_modulo=='autor'){

        ########################################
        ############### Borra en caso de jardín
        // }elseif($this->modJar_modulo=='jardin'){
        }else{
            jardin_txt::where('jar_id',$this->modJar_id)->update([
                'jar_audio'=>null,
            ]);
            $this->modJar_NvoAudio='';
            $this->modJar_Audio='';
            ##### log
            paLog('Se eliminó el audio','jardin_txt',$this->modJar_id);
        }
    }

    public function EliminarParrafo(){
        ########################################
        ############### Guarda en caso de cedulas
        if($this->modJar_modulo=='cedula'){
            cedulas_txt::where('txt_id',$this->modJar_id)->update([
                'txt_del'=>'1',
            ]);

        ########################################
        ############### Guarda en caso de autor
        }elseif($this->modJar_modulo=='autor'){

        ########################################
        ############### Guarda en caso de jardin
        // }elseif($this->modJar_modulo=='jardin' OR $this->modJar_modulo=='autores'){
        }else{
            jardin_txt::where('jar_id',$this->modJar_id)->update([
                'jar_del'=>'1',
            ]);
        }
        ##### Cierra modal
        $this->dispatch('CierraModalDeParrafoWebJardin',reload:'1');
    }

    #################################################################
    ######################################## Verificador de tags html
    public $ValidadorDeTag;
    public function validarHtml() {
        ######################################################
        ######## Código obtenido por Qwen para revisar. Se debe
        ######## indicar $variable (nombre de variable $this que
        ######## contiene el código html que se va a revisar
        ######## y donde se va a mostrar el @error: $this->variable.
        ######## También utiliza la variable $this->ValidadorDeTag='0';
        ######## como flag de existencia(1) de error o no (0);
        $variable='Imgmod_nvoobj';

        ##### Limpia
        $this->resetErrorBag();
        $this->resetValidation();
        $this->ValidadorDeTag='0';
        $html = trim($this->$variable);

        if($html == '') {
            $this->ValidadorDeTag='1';
            $this->addError($variable, 'El campo HTML no puede estar vacío.');
            return;
        }

        // 1️⃣ Análisis con DOMDocument + libxml
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();

        // Convertimos a HTML-ENTITIES para evitar problemas con UTF-8 en DOMDocument
        $encodedHtml = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

        // Cargamos sin auto-agregar <html>/<body> y en modo compacto
        @$dom->loadHTML($encodedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_COMPACT);

        $xmlErrors = libxml_get_errors();
        libxml_clear_errors();

        $severeErrors = [];
        foreach ($xmlErrors as $error) {
            // Nivel 3 = Error, Nivel 4 = Fatal
            if ($error->level >= LIBXML_ERR_ERROR) {
                $severeErrors[] = sprintf(
                    'Línea %d, Col %d: %s',
                    $error->line,
                    $error->column,
                    trim($error->message)
                );
            }
        }

        if (!empty($severeErrors)) {
            $this->ValidadorDeTag='1';
            $this->addError($variable, 'Errores de sintaxis detectados:<br>' . implode('<br>', $severeErrors));
            return;
        }

        ################### inicia tags no cerrados
        // Etiquetas void (no requieren cierre) según HTML5
        $voidTags = ['area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'link', 'meta', 'param', 'source', 'track', 'wbr'];

        // Extrae todas las etiquetas (apertura, cierre o self-closing)
        preg_match_all('/<(\/?)([a-zA-Z0-9]+)(?:\s[^>]*)?\/?>/', $html, $matches, PREG_SET_ORDER);

        $stack = [];
        foreach ($matches as $match) {
            $isClosing  = $match[1] === '/';
            $tagName    = strtolower($match[2]);

            // Ignoramos etiquetas que no necesitan cierre
            if (in_array($tagName, $voidTags)) continue;

            if ($isClosing) {
                if (empty($stack) || end($stack) !== $tagName) {
                    $this->ValidadorDeTag='1';
                    $this->addError($variable, "Etiqueta de cierre inesperada o desbalanceada: </$tagName>");
                    return;
                }
                array_pop($stack);
            } else {
                $stack[] = $tagName;
            }
        }

        if (!empty($stack)) {
            $unclosed = array_unique($stack);
            $this->ValidadorDeTag='1';
            $this->addError($variable, 'Etiquetas abiertas sin cerrar: ' . implode(', ', $unclosed));
        }
        ##################### Cierra tags no cerrados
        // if (!$this->hasErrors()) {
        //     $this->isValid = true;
        //     $this->dispatch('html-validated');
        // }
    }

    public function render(){

        return view('livewire.sistema.modal-edita-parrafo-component');
    }


    #################################################################
    ######################################## Verificador de tags html
    public function AbreModalVerObjetos($tipoDato){
        #####<livewire:sistema.modal-ver-objeto-component />
        ######################################################
        ############### Guarda en caso de cedula (autor_txt)
        if($this->modJar_modulo=='cedula'){


        ######################################################
        ############### Guarda en caso de autor (autor_txt)
        }elseif($this->modJar_modulo=='autor'){

        ######################################################
        ############### Guarda en caso de inicio, autores,
        ############### cedulas u otros (cedulas_txt)
        }else{

        }
        $data=[
                'jardin'=>$this->modJar_cjarsiglas,
                'modulo'=>$this->modJar_modulo,
                'url'=>$this->modJar_url,
                'tipoDato'=>$tipoDato,
            ];

        $this->dispatch('AbreModalDeVerObjetos',$data);
    }




}
