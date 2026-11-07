<?php

namespace App\Livewire\Sistema;

use App\Models\autor_txt;
use App\Models\autor_url;
use App\Models\cat_autores;
use App\Models\cedulas_txt;
use App\Models\cedulas_url;
use App\Models\jardin_txt;
use App\Models\jardin_url;
use App\Models\lista;
use App\Models\lista_txt;
use HTMLPurifier;
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

        ##########################################
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

            }elseif($this->modJar_modulo=='autor'){
                $ord=autor_txt::where('autxt_cjarsiglas',$this->modJar_cjarsiglas)
                    ->where('autxt_aurlurltxt', $this->modJar_url)
                    ->where('autxt_act','1')
                    ->where('autxt_del','0')
                    ->max('autxt_orden');

            }elseif($this->modJar_modulo=='lista'){
                $ord=lista_txt::where('lstxt_cjarsiglas',$this->modJar_cjarsiglas)
                    ->where('lstxt_act','1')
                    ->where('lstxt_del','0')
                    ->max('lstxt_orden');

            }else{
                $ord=jardin_txt::where('jar_cjarsiglas',$this->modJar_cjarsiglas)
                    ->where('jar_urljurl', $this->modJar_url)
                    ->where('jar_act','1')
                    ->where('jar_del','0')
                    ->max('jar_orden');
            }
            $this->modJar_orden=round($ord+1,0);

        ############# Carga variables cuando id > 0
        }else{
            #######################################################
            ################ Carga variables de lista (lista_txt)
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
                $dato=autor_txt::where('autxt_id',$this->modJar_id)
                    ->with('url')
                    ->with('cedulas')
                    ->with('jardin')
                    ->first();
                $this->modJar_tipo=$dato->autxt_tipo;
                $this->modJar_orden=$dato->autxt_orden;
                $this->modJar_txt=$dato->autxt_txt;
                $this->modJar_Audio=$dato->autxt_audio;
                $copiaUorig= $dato->url->url_tradid;


            #######################################################
            ############################ Carga variables de inicio,
            ############################ autores, cedulas y otros (jardin_txt)
            // }elseif(in_array($this->modJar_modulo,['inicio','autores','cedulas']) ){
            }elseif($this->modJar_modulo=='lista'){
                $dato=lista_txt::where('lstxt_id',$this->modJar_id)
                    ->first();
                $this->modJar_txt=$dato->lstxt_txt;
                $this->modJar_Audio=$dato->lstxt_audio;
                $this->modJar_tipo=$dato->lstxt_tipo;
                $this->modJar_orden=$dato->lstxt_orden;
                // $copiaUorig= $this->modJar_id;
                $copiaUorig= '0';
            }else{
                $dato=jardin_txt::where('jar_id',$this->modJar_id)
                    ->with('url')
                    ->first();
                $this->modJar_txt=$dato->jar_txt;
                $this->modJar_Audio=$dato->jar_audio;
                $this->modJar_tipo=$dato->jar_tipo;
                $this->modJar_orden=$dato->jar_orden;
                $copiaUorig= $dato->url->urlj_tradid;
            }

        }

        if($copiaUorig=='0'){
            // $this->modJar_original=jardin_txt::where('jar_id',$copiaUorig)->value('')
            $this->modJar_original='Este es un documento original';
        }else{
            if($this->modJar_modulo=='cedula'){
                $this->modJar_original=$dato->txt_txtoriginal;
            }elseif($this->modJar_modulo=='autor'){
                $this->modJar_original=$dato->autxt_txtoriginal;
            }else{
                $this->modJar_original=$dato->jar_txtoriginal;
            }
        }
    }


    public function mount(){
        $this->VerHtml='0';
        $this->VerOriginal='0';
        $this->modJar_Objetos=collect();
        $this->modJar_VerModulo='web';
        $this->ValidadorDeTag='0';
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
        ##### Valida código
        $this->validarHtml();
        if($this->ValidadorDeTag=='1'){
            return;
        }

        ######################################################
        ############### Guarda en caso de cedulas (cedulas_txt)
        if($this->modJar_modulo=='cedula'){
            ##### Genera arreglo de datos
            $dato=[
                // 'url_id'=>$this->modJar_id,
                'txt_cjarsiglas'=>$this->modJar_cjarsiglas,
                'txt_urlid'=>cedulas_url::where('url_cjarsiglas',$this->modJar_cjarsiglas)->where('url_url',$this->modJar_url)->value('url_id'),
                'txt_urlurl'=>$this->modJar_url,
                'txt_tipo'=>$this->modJar_tipo,
                'txt_orden'=>$this->modJar_orden,
                'txt_txt'=>$this->modJar_txt,
            ];

            ##### Guarda BD
            if($this->modJar_id == '0'){
                // $dato['txt_id']=$this->modJar_id;
                $dato['txt_txtoriginal']=$this->modJar_txt;
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
                $ruta="/cedulas/audios/";
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
            ##### Genera arreglo de datos
            $autURl=autor_url::where('aurl_cjarsiglas',$this->modJar_cjarsiglas)
                ->where('aurl_url',$this->modJar_url)
                ->where('aurl_act','1')->where('aurl_del','0')
                ->first();

            $dato=[
                // 'url_id'=>$this->modJar_id,
                'autxt_cjarsiglas'=>$this->modJar_cjarsiglas,
                'autxt_aurlid'=>$autURl->aurl_id,
                'autxt_aurlurltxt'=>$this->modJar_url,
                'autxt_aurlurl'=>$autURl->aurl_url,
                'autxt_tipo'=>$this->modJar_tipo,
                'autxt_orden'=>$this->modJar_orden,
                'autxt_txt'=>$this->modJar_txt,
            ];

            ##### Guarda BD
            if($this->modJar_id == '0'){
                // $dato['txt_id']=$this->modJar_id;
                $dato['autxt_txtoriginal']=$this->modJar_txt;
                $bla=autor_txt::create($dato);
                $id=$bla->autxt_id;
            }else{
                autor_txt::where('autxt_id', $this->modJar_id)->update($dato);
                $id=$this->modJar_id;
            }
            ##### Guarda archivo de audio
            if($this->modJar_NvoAudio != ''){
                ##### Construye nombre
                $nombre=$this->modJar_cjarsiglas . "_" . $this->modJar_url . str_pad($this->modJar_orden,3,"0",STR_PAD_LEFT) . "." . $this->modJar_NvoAudio->getClientOriginalExtension();
                $ruta="/audios/";
                ##### Guarda archivo
                $this->modJar_NvoAudio->storeAs(path:'/public/'.$ruta, name:$nombre);
                ##### Guarda en BD
                autor_txt::where('autxt_id',$id)->update([
                    'autxt_audio'=>$ruta.$nombre
                ]);
                ##### hace log
                paLog('Se agrega nuevo audio','cedula_txt',$id);
            }

        ######################################################
        ############### Guarda en caso de inicio, autores,
        ############### cedulas u otros (cedulas_txt)
        // }elseif}elseif($this->modJar_modulo=='autor'){
            ##### Genera arreglo de datos
            $autURl=autor_url::where('aurl_cjarsiglas',$this->modJar_cjarsiglas)
                ->where('aurl_url',$this->modJar_url)
                ->where('aurl_act','1')->where('aurl_del','0')
                ->first();

            $dato=[
                // 'url_id'=>$this->modJar_id,
                'autxt_cjarsiglas'=>$this->modJar_cjarsiglas,
                'autxt_aurlid'=>$autURl->aurl_id,
                'autxt_aurlurltxt'=>$this->modJar_url,
                'autxt_aurlurl'=>$autURl->aurl_url,
                'autxt_tipo'=>$this->modJar_tipo,
                'autxt_orden'=>$this->modJar_orden,
                'autxt_txt'=>$this->modJar_txt,
            ];

            ##### Guarda BD
            if($this->modJar_id == '0'){
                // $dato['txt_id']=$this->modJar_id;
                $dato['autxt_txtoriginal']=$this->modJar_txt;
                $bla=autor_txt::create($dato);
                $id=$bla->autxt_id;
            }else{
                autor_txt::where('autxt_id', $this->modJar_id)->update($dato);
                $id=$this->modJar_id;
            }
            ##### Guarda archivo de audio
            if($this->modJar_NvoAudio != ''){
                ##### Construye nombre
                $nombre=$this->modJar_cjarsiglas . "_" . $this->modJar_url . str_pad($this->modJar_orden,3,"0",STR_PAD_LEFT) . "." . $this->modJar_NvoAudio->getClientOriginalExtension();
                $ruta="/audios/";
                ##### Guarda archivo
                $this->modJar_NvoAudio->storeAs(path:'/public/'.$ruta, name:$nombre);
                ##### Guarda en BD
                autor_txt::where('autxt_id',$id)->update([
                    'autxt_audio'=>$ruta.$nombre
                ]);
                ##### hace log
                paLog('Se agrega nuevo audio','cedula_txt',$id);
            }

        ######################################################
        ############### Guarda en caso de inicio, autores,
        ############### cedulas u otros (cedulas_txt)
        }elseif($this->modJar_modulo=='lista'){
            $dato=[
                // 'url_id'=>$this->modJar_id,
                'lstxt_cjarsiglas'=>$this->modJar_cjarsiglas,
                'lstxt_tipo'=>$this->modJar_tipo,
                'lstxt_orden'=>$this->modJar_orden,
                'lstxt_txt'=>$this->modJar_txt,
                'lstxt_txtoriginal'=>$this->modJar_txt,
                // 'lstxt_audio'=>'',
            ];

            ##### Guarda BD
            if($this->modJar_id == '0'){
                $dato['lstxt_txtoriginal']=$this->modJar_txt;
                $bla=lista_txt::create($dato);
                $id=$bla->lstxt_id;
            }else{
                lista_txt::where('lstxt_id', $this->modJar_id)->update($dato);
                $id=$this->modJar_id;
            }
            ##### Guarda archivo de audio
            if($this->modJar_NvoAudio != ''){
                ##### Construye nombre
                $nombre=$this->modJar_cjarsiglas . "_lista" . str_pad($this->modJar_orden,3,"0",STR_PAD_LEFT) . "." . $this->modJar_NvoAudio->getClientOriginalExtension();
                $ruta="/audios/";
                ##### Guarda archivo
                $this->modJar_NvoAudio->storeAs(path:'/public/'.$ruta, name:$nombre);
                ##### Guarda en BD
                lista_txt::where('lstxt_id',$id)->update([
                    'lstxt_audio'=>$ruta.$nombre
                ]);
                ##### hace log
                paLog('Se agrega nuevo audio','lista_txt',$id);
            }

        }else{
            $urljId=jardin_url::where('urlj_cjarsiglas',$this->modJar_cjarsiglas)
                ->where('urlj_url',$this->modJar_url)
                ->value('urlj_id');
            ##### Genera arreglo de datos

            $dato=[
                'jar_urljid'=> $urljId,
                'jar_urljurl'=>$this->modJar_url,
                'jar_cjarsiglas'=>$this->modJar_cjarsiglas,
                'jar_orden'=>$this->modJar_orden,
                'jar_tipo'=>$this->modJar_tipo,
                'jar_txt'=>$this->modJar_txt,
            ];

            ##### Guarda BD
            if($this->modJar_id == '0'){
                $dato['jar_txtoriginal']=$this->modJar_txt;
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
                $ruta="/audios/";
                ##### Guarda archivo
                $this->modJar_NvoAudio->storeAs(path:'/public/'.$ruta, name:$nombre);
                ##### Guarda en BD
                jardin_txt::where('jar_id',$id)->update([
                    'jar_audio'=>$ruta.$nombre
                ]);
                ##### hace log
                paLog('Se agrega nuevo audio','jardin_txt',$id);
            }
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
            autor_txt::where('autxt_id',$this->modJar_id)->update([
                'autxt_audio'=>null,
            ]);
            $this->modJar_NvoAudio='';
            $this->modJar_Audio='';
            ##### log
            paLog('Se eliminó el audio','autor_txt',$this->modJar_id);

        ########################################
        ############### Borra en caso de autor
        }elseif($this->modJar_modulo=='lista'){
            lista_txt::where('lstxt_id',$this->modJar_id)->update([
                'lstxt_audio'=>null,
            ]);
            $this->modJar_NvoAudio='';
            $this->modJar_Audio='';
            ##### log
            paLog('Se eliminó el audio','lista_txt',$this->modJar_id);

        ########################################
        ############### Borra en caso de jardín

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
            autor_txt::where('autxt_id',$this->modJar_id)->update([
                'autxt_del'=>'1',
            ]);

        ########################################
        ############### Guarda en caso de autor
        }elseif($this->modJar_modulo=='lista'){
            lista_txt::where('lstxt_id',$this->modJar_id)->update([
                'lstxt_del'=>'1',
            ]);

        ########################################
        ############### Guarda en caso de jardin
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
    /**
     * Valida y opcionalmente sanitiza contenido HTML
     *
     * @param string $variableName Nombre de la propiedad en $this que contiene el HTML
     * @param bool $sanitizar Si true, aplica HTMLPurifier tras validar
     * @param array $allowedTags Lista blanca de tags permitidos (null = todos)
     * @return bool True si es válido, false si tiene errores
     */
    public $ValidadorDeTag;

    public function validarHtml(string $variableName = 'modJar_txt', bool $sanitizar = false, ?array $allowedTags = null): bool{
        // ========================================
        // 1️⃣ INICIALIZACIÓN Y LIMPIEZA
        // ========================================
        $this->resetErrorBag();
        $this->resetValidation();
        $this->ValidadorDeTag = '0';

        // Acceso seguro a variable dinámica
        if (!property_exists($this, $variableName)) {
            $this->ValidadorDeTag = '1';
            $this->addError($variableName, "La propiedad '{$variableName}' no existe en este componente.");
            return false;
        }

        $html = trim($this->{$variableName});

        // Validación de contenido vacío
        if ($html === '') {
            $this->ValidadorDeTag = '1';
            $this->addError($variableName, 'El campo HTML no puede estar vacío.');
            return false;
        }

        // ========================================
        // 2️⃣ PRE-PROCESAMIENTO: Limpieza segura
        // ========================================
        // Eliminar comentarios HTML y CDATA para evitar falsos positivos en el regex
        $cleanHtml = preg_replace('/<!--.*?-->|<!\[CDATA\[.*?\]\]>/s', '', $html);

        // Extraer contenido de <script> y <style> para no parsear su interior como HTML
        $protectedBlocks = [];
        $cleanHtml = preg_replace_callback(
            '/<(script|style)\b[^>]*>.*?<\/\1>/is',
            function($matches) use (&$protectedBlocks) {
                $id = '%%PROTECTED_' . count($protectedBlocks) . '%%';
                $protectedBlocks[$id] = $matches[0];
                return $id;
            },
            $cleanHtml
        );

        // ========================================
        // 3️⃣ VALIDACIÓN CON DOMDocument + libxml
        // ========================================
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument('1.0', 'UTF-8');

        // Configuración para evitar que DOMDocument agregue estructura automática
        $options = LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_COMPACT | LIBXML_NOERROR | LIBXML_NOWARNING;

        // Convertir encoding para compatibilidad con DOMDocument
        $encodedHtml = mb_convert_encoding($cleanHtml, 'HTML-ENTITIES', 'UTF-8');

        // Cargar HTML con manejo controlado de errores
        $loaded = $dom->loadHTML($encodedHtml, $options);

        // Procesar errores severos del parser
        $xmlErrors = libxml_get_errors();
        libxml_clear_errors();

        $severeErrors = [];
        foreach ($xmlErrors as $error) {
            // Solo considerar errores de nivel 3 (error) o 4 (fatal)
            if ($error->level >= LIBXML_ERR_ERROR) {
                // Filtrar warnings conocidos de HTML5 que no son críticos
                $msg = trim($error->message);
                if (!preg_match('/Tag \w+ invalid|DOCTYPE declared|html\/head\/body implied/i', $msg)) {
                    $severeErrors[] = sprintf(
                        'Línea %d: %s',
                        $error->line,
                        preg_replace('/\s+/', ' ', $msg)
                    );
                }
            }
        }

        if (!empty($severeErrors)) {
            $this->ValidadorDeTag = '1';
            $this->addError(
                $variableName,
                "Errores de sintaxis HTML:\n• " . implode("\n• ", array_unique($severeErrors))
            );
            return false;
        }

        // ========================================
        // 4️⃣ VALIDACIÓN DE TAGS CON STACK (HTML5-AWARE)
        // ========================================
        // Tags void (autocerrados) según HTML5 spec
        $voidTags = array_flip([
            'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input',
            'link', 'meta', 'param', 'source', 'track', 'wbr', 'command', 'keygen'
        ]);

        // Tags con cierre implícito según HTML5 spec
        $optionalCloseTags = array_flip([
            'p', 'li', 'dt', 'dd', 'rt', 'rp', 'td', 'th', 'tr', 'colgroup',
            'optgroup', 'option', 'tbody', 'tfoot', 'thead'
        ]);

        // Regex mejorado: soporta namespaces (svg:rect), ignora contenido protegido
        $tagPattern = '/<(\/?)([a-zA-Z][a-zA-Z0-9:\-]*)(?:\s[^>]*)?(\/?)>/';

        if (!preg_match_all($tagPattern, $cleanHtml, $matches, PREG_SET_ORDER)) {
            // Si no hay tags, pero el contenido no está vacío, validar que sea texto plano válido
            if (preg_match('/[<>]/', $cleanHtml)) {
                $this->ValidadorDeTag = '1';
                $this->addError($variableName, "Se detectaron caracteres '<' o '>' sin formar una etiqueta válida.");
                return false;
            }
        }

        $stack = [];
        $lineage = []; // Para mensajes de error más precisos

        foreach ($matches as $match) {
            $isClosing   = $match[1] === '/';
            $isSelfClose = $match[3] === '/';
            $tagName     = strtolower($match[2]);

            // Ignorar placeholders de bloques protegidos
            if (str_starts_with($tagName, '%%protected')) continue;

            // Ignorar tags void y self-closing explícitos
            if (isset($voidTags[$tagName]) || $isSelfClose) {
                continue;
            }

            if ($isClosing) {
                // Buscar el tag de apertura correspondiente en el stack
                $foundIndex = -1;
                for ($i = count($stack) - 1; $i >= 0; $i--) {
                    if ($stack[$i] === $tagName) {
                        $foundIndex = $i;
                        break;
                    }
                }

                if ($foundIndex === -1) {
                    // Tag de cierre sin apertura
                    $this->ValidadorDeTag = '1';
                    $this->addError(
                        $variableName,
                        "Etiqueta de cierre sin apertura: </{$tagName}>" .
                        (!empty($lineage) ? "\nContexto: </" . implode('></', array_reverse($lineage)) . ">" : '')
                    );
                    return false;
                }

                // Si hay tags intermedios, reportarlos como no cerrados
                if ($foundIndex < count($stack) - 1) {
                    $unclosed = array_slice($stack, $foundIndex + 1);
                    $this->ValidadorDeTag = '1';
                    $this->addError(
                        $variableName,
                        "Etiquetas sin cerrar antes de </{$tagName}>: <" . implode('>, <', $unclosed) . ">"
                    );
                    return false;
                }

                // Remover del stack y lineage
                array_pop($stack);
                array_pop($lineage);

            } else {
                // Tag de apertura: manejar cierre implícito de tags HTML5
                if (!empty($stack) && isset($optionalCloseTags[$tagName])) {
                    $current = end($stack);
                    // Si el tag actual puede cerrar implícitamente al anterior del mismo tipo
                    if ($current === $tagName) {
                        array_pop($stack);
                        array_pop($lineage);
                    }
                    // Reglas específicas de anidación (ej: <p> no puede contener <div>)
                    elseif ($current === 'p' && in_array($tagName, ['div', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'ul', 'ol', 'table', 'blockquote'])) {
                        array_pop($stack); // Cierra <p> implícitamente
                        array_pop($lineage);
                    }
                }

                $stack[] = $tagName;
                $lineage[] = $tagName;
            }
        }

        // Verificar tags sin cerrar al final
        if (!empty($stack)) {
            $unclosed = array_unique($stack);
            $this->ValidadorDeTag = '1';
            $this->addError(
                $variableName,
                "Etiquetas abiertas sin cerrar: <" . implode('>, <', $unclosed) . ">"
            );
            return false;
        }

        // ========================================
        // 5️⃣ VALIDACIÓN DE TAGS PERMITIDOS (Whitelist)
        // ========================================
        if ($allowedTags !== null && is_array($allowedTags) && !empty($allowedTags)) {
            $allowedLower = array_map('strtolower', $allowedTags);
            $foundTags = [];

            foreach ($matches as $match) {
                $tag = strtolower($match[2]);
                if (!isset($voidTags[$tag]) && !in_array($tag, $allowedLower)) {
                    $foundTags[] = "<{$tag}>";
                }
            }

            if (!empty($foundTags)) {
                $this->ValidadorDeTag = '1';
                $this->addError(
                    $variableName,
                    "Tags no permitidos: " . implode(', ', array_unique($foundTags)) .
                    "\nTags permitidos: " . implode(', ', $allowedTags)
                );
                return false;
            }
        }

        // ========================================
        // 6️⃣ SANITIZACIÓN OPCIONAL (HTMLPurifier)
        // ========================================
        if ($sanitizar) {
            if (!class_exists('HTMLPurifier')) {
                \Log::warning('HTMLPurifier no está instalado. Ejecuta: composer require ezyang/htmlpurifier');
                $this->addError($variableName, "Sanitización solicitada pero HTMLPurifier no está disponible.");
                return false;
            }

            try {
                $config = HTMLPurifier_Config::createDefault();
                $config->set('Core.Encoding', 'UTF-8');
                $config->set('HTML.Allowed', $allowedTags ? implode(',', $allowedTags) : null);
                $config->set('Attr.AllowedFrameTargets', ['_blank']);
                $config->set('CSS.AllowedProperties', ['font', 'font-size', 'font-weight', 'font-style', 'font-family', 'text-decoration', 'color', 'background-color', 'text-align', 'width', 'height', 'margin', 'padding']);
                $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true, 'data' => true]);

                $purifier = new HTMLPurifier($config);
                $this->{$variableName} = $purifier->purify($this->{$variableName});

            } catch (\Exception $e) {
                \Log::error('Error en HTMLPurifier: ' . $e->getMessage());
                $this->ValidadorDeTag = '1';
                $this->addError($variableName, "Error al sanitizar el contenido HTML.");
                return false;
            }
        }

        // ========================================
        // 7️⃣ ÉXITO
        // ========================================
        return true;
    }


    public function BorrarTodoCodigo(){
        $this->modJar_txt='';
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
