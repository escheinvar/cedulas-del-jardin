<?php

namespace App\Livewire\Web;

use App\Models\ced_aporteusrs;
use App\Models\ced_alias;
use App\Models\ced_externos;
use App\Models\ced_sp;
use App\Models\sist_visitas;
use App\Models\ced_usos;
use App\Models\cedulas_txt;
use App\Models\cedulas_url;
use App\Models\Imagenes;
use App\Models\nom054semarnat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CedulasController extends Component
{
    use WithFileUploads;

    public $jardin, $url; ##### Vars. recibidas por URL, y luego en url se guarda el first() de toda la info de cedula_url
    public $edit, $enEdit, $editMaster; ###### Vars. de edición
    ###### Variables de página cédulas:
    public $traducciones; ##### get() de cédulas con igual urltxt
    public $objs; ##### get() de fotos de la cédulas
    public $idiomaSelected; ##### Idioma seleccionado en el select de vista
    public $txt; #### get() de cedula_txt con todo el texto
    public $verSp, $verUbica, $verAlias; ##### flags para VerNoVer apartados de sp, ubicación y alias.
    public $alias, $ubicaciones; ### datos de alias y de locs de la cédula
    public $meses, $UrlRedes, $qrSize;
    public $aportes; ##### get() de aportes de usuarios publicos
    public $ligas;  ##### get() de ligas extra
    public $especies; ##### get() de especies
    public $riesgo; #### Categorias cites y Redlist
    public $hermanas; #### get() de cedulas similares (sp, o alias)

    ###### Variables de modal Traduce titulo
    // public $NuevoTituloTraducido, $NuevoAudio;

    #[Layout('plantillas.baseJardin')]
    public function mount($jardin,$url){
        $this->reset();
        ##### Carga variables recibidas por URL: carga jardín
        $this->jardin=$jardin;

        ##### Carga variables recibidas por URL: carga datos url
        $this->url=cedulas_url::where('url_cjarsiglas','ilike',strtolower($jardin))
            ->where('url_url',$url)
            ->where('url_del','0')
            ->with('jardin')
            ->with('lenguas')
            ->with('autores')
            ->with('editores')
            ->with('traductores')
            ->with('ubicaciones')
            ->with('alias')
            ->with('especies')
            ->with('usos')
            ->with('versiones')
            ->first();

        if(is_null($this->url)) {
            redirect('/errorLa dirección indicada es incorrecta');
        }else{
            if( $this->url->url_act=='0' or $this->url->count() < '0'){
                redirect('/errorLa dirección indicada es incorrecta');
            }
        }

        ###### Registra estadísticas de visita
        if($this->url->url_edo >='5' and is_null(session('rol'))){
            MyRegistraVisita(['ced','aut','jar'][0], $this->url->url_id, 'cedula');
        }

        ##### Carga todas las traducciones de la url
        $this->traducciones=cedulas_url::where('url_key', $this->url->url_key)
            ->where('url_id','!=',$this->url->url_id)
            ->where('url_act','1')->where('url_del','0')
            // ->where('url_ciclo','>','0')
            ->with('lenguas')
            ->with('jardin') ##quitar cuando quite $traducciones en lína 169 de la vista
            ->orderBy('url_lencode')
            ->get();

        ##### Carga varibbles
        $this->verSp='0';
        $this->verUbica='0';
        $this->verAlias='0';
        $this->meses=['0','enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','dieciembre'];
        $this->UrlRedes=url('/').'/cedula/'.$this->url->url_cjarsiglas.'/'.$this->url->url_url;
        $this->qrSize='80';

        ##### Carga especies
        $this->especies=ced_sp::where('sp_cjarsiglas',$this->url->url_cjarsiglas)
            ->where('sp_urltxt',$this->url->url_urltxt)
            ->where('sp_act','1')->where('sp_del','0')
            ->orderBy('sp_id','asc')
            ->with('usos')
            ->leftJoin('nom059semarnat', function($q){
                $q->on('nom_genero','ilike','sp_genero')
                ->on('nom_especie','ilike','sp_especie')
                ->on('nom_infrasp','ilike','sp_ssp');
            })
            ->get();


        ################## Inicia WebService RedList y Cites
        if($this->especies->count() > '0'){
            foreach($this->especies as $e){
                $RedListToken='V6NT8Woe3ZnPcRZxiALB54eaedAMjkQMjDEV';

                $RedListApi = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $RedListToken, // Or 'Token ' for some APIs
                ])->get('https://api.iucnredlist.org/api/v4/taxa/scientific_name',[
                    'genus_name'=>$e->sp_genero,
                    'species_name'=>$e->sp_especie,
                    'infra_name'=>$e->sp_ssp,
                    // 'genus_name'=>'Dioon',
                    // 'species_name'=>'califanoi',
                    // 'infra_name'=>'',
                ]);
                if ($RedListApi->successful()) {
                    #dd('exito',count($RedListApi->json()['assessments']));
                    if(count($RedListApi->json()['assessments']) > 0){
                        $Riesgo[$e->sp_scname]['redlist']=[
                            'estatus'=>$RedListApi->status(),
                            'dato'=>$RedListApi->json()['assessments'][0]
                        ];
                    }else{
                        $Riesgo[$e->sp_scname]['redlist']=[
                            'estatus'=>'400',
                            'dato'=>''
                        ];
                    }

                } else {
                    $Riesgo[$e->sp_scname]['redlist']=[
                        'estatus'=>$RedListApi->status(),
                        'dato'=>$RedListApi->body()
                    ];
                }

                ############################# Api de Cites
                $CitesToken='wooIyHq5e7kH8DIsA8YxDgtt';
                $CitesApi = Http::withHeaders([
                    'Accept' => 'application/json',
                    'X-Authentication-Token'=>$CitesToken,
                ])->get('https://api.speciesplus.net/api/v1/taxon_concepts',[
                    'name'=>$e->sp_scname,
                    // 'name'=>'Loxodonta africana',
                    // 'name'=>'Taxodium mucrunatum'
                ]);

                if ($CitesApi->successful()) {
                    $Riesgo[$e->sp_scname]['cites']=[
                        'estatus'=>$CitesApi->status(),
                        'dato'=>$CitesApi->json(),
                    ];
                } else {
                    $Riesgo[$e->sp_scname]['cites']=[
                        'estatus'=>$CitesApi->status(),
                        'dato'=>[$CitesApi->body()],
                    ];
                }
            }
            $this->riesgo=$Riesgo;
        }

        ################## Busca otras cédulas con = sp o palabra clave
        #### obtiene lista de sp y de alias de esta cédula
        $Misp=$this->url->especies->pluck('sp_scname')->toArray();
        $Mialias=$this->url->alias->pluck('ali_txt')->toArray();
        #### Si tiene 1 sp, busca la misma en otras
        if(count($Misp) > '0'){
            $ganones1=ced_sp::whereIn('sp_scname',$Misp)
                ->where('sp_key', '!=', $this->url->url_key)
                ->where('sp_act','1')
                ->where('sp_del','0')
                ->pluck('sp_key')
                ->toArray();

        }else{
            $ganones1=[];
        }
        #### Si tiene 1 alias, busca en otras cédulas
        if(count($Mialias) > '0'){
            $ganones2=ced_alias::whereIn('ali_txt',$Mialias)
                ->where('ali_key', '!=', $this->url->url_key)
                ->where('ali_act','1')
                ->where('ali_del','0')
                ->pluck('ali_key')
                ->toArray();
        }else{
            $ganones2=[];
        }
        if(count($ganones1)> '0' OR count($ganones2)>'0'){
            $ganones=array_merge($ganones1,$ganones2);
            $ganones=array_unique($ganones);
            $this->hermanas=cedulas_url::whereIn('url_key',$ganones)
                ->where('url_tradid','0')
                ->with('jardin')
                ->with('objetos')
                ->get();
        }else{
            $this->hermanas=collect();
        }

    }

    public function EliminaImagen($id){
        Imagenes::where('img_id',$id)->update([
            'img_del'=>'1',
        ]);
        $this->dispatch('AvisoExitoCedula',msj:'Se eliminó correctamente la imágen.');
    }

    public function CambiaIdiomaCedula(){
        if($this->idiomaSelected != ''){
            $ruta='/cedula/'.$this->url->url_cjarsiglas.'/'.$this->idiomaSelected;
            redirect ($ruta);
        }
    }

    public function BorrarEspecie($id){
        ced_sp::where('sp_id',$id)->update([
            'sp_del'=>'1',
        ]);
    }

    public function VerNoVer($apartado){
        if($this->$apartado =='0'){$this->$apartado='1';}else{$this->$apartado='0';}
    }

    public function VerQR(){
        if( $this->qrSize=='80'){
        $this->qrSize='200';
        }elseif( $this->qrSize=='200'){
            $this->qrSize='600';
        }elseif( $this->qrSize=='600'){
            $this->qrSize='80';
        }
    }

    public function BajarQR(){
        return response()->streamDownload(
            function(){
                echo QrCode::size($this->qrSize)->margin(2)
                    ->generate( url('/').'/cedula/'.$this->url->url_cjarsiglas.'/'.$this->url->url_url );
            },
            'CodigoQR.png',
            [
                'Content-Type'=>'image/png'
            ]
            );
    }

    public function EliminarExterno($idExt){
        ced_externos::where('ext_id',$idExt)->update([
            'ext_del'=>'1',
        ]);
    }

    public function render(){
        ##### Revisa permisos del usuario (rol)
        $this->edit='0';
        if(session('rol')){
            if(array_intersect(['admin'], session('rol'))   AND    $this->url->url_edit=='1'){
                $this->edit='1';
                $this->editMaster='1';

            }elseif(array_intersect(['editor'], session('rol'))   AND    $this->url->url_edit=='1'    AND    $this->url->url_edo < '4'){
                $this->edit='1';
                $this->editMaster='1';

            ##### Si es autor o traductor, revisa que esté en la lista de autores o traductores de la cédula
            }elseif(array_intersect(['traductor','autor'], session('rol'))
              AND
              ($this->url->url_edit=='1')
              AND
              ( in_array(Auth::user()->id, $this->url->autores->pluck('caut_usrid')->toArray())
              OR
              in_array(Auth::user()->id, $this->url->traductores->pluck('caut_usrid')->toArray()) )
              AND
              in_array($this->url->url_edo, ['0','2'])
            ){
                $this->edit='1';
                $this->editMaster='0';

            }else{
                $this->edit='0';
            }
        }


        ##### Revisa si la página es pública:
        if($this->url->url_edo <= '4'){
            $this->enEdit='1';
        }else{
            $this->enEdit='0';
        }

        ##### Obtiene fotos, audios y videos de la cédula
        $this->objs=Imagenes::where('img_key',$this->url->url_key)
            ->where('img_act','1')->where('img_del','0')
            ->get();

        ##### Carga párrafos de texto de la cédula
        $this->txt=cedulas_txt::where('txt_cjarsiglas',$this->url->url_cjarsiglas)
            ->where('txt_urlurl',$this->url->url_url)
            ->where('txt_act','1')->where('txt_del','0')
            ->orderBy('txt_orden')
            ->get();

        ##### Carga datos y metadatos de la cédula
        $cedula=cedulas_url::where('url_id',$this->url->url_id)
            ->with('jardin')
            ->with('lenguas')
            ->with('autores')
            ->with('traductores')
            ->with('ubicaciones')
            ->with('alias')
            ->first();

        // $especies=ced_sp::where('sp_cjarsiglas',$this->url->url_cjarsiglas)
        //     ->where('sp_urltxt',$this->url->url_urltxt)
        //     ->where('sp_act','1')->where('sp_del','0')
        //     ->orderBy('sp_id','asc')
        //     ->with('usos')
        //     ->leftJoin('nom059semarnat', function($q){
        //         $q->on('nom_genero','ilike','sp_genero')
        //         ->on('nom_especie','ilike','sp_especie')
        //         ->on('nom_infrasp','ilike','sp_ssp');
        //     })
        //     ->get();

        $this->alias=$cedula->alias;
        $this->ubicaciones=$cedula->ubicaciones;

        ##### Obtiene aportes
        $this->aportes=ced_aporteusrs::where('msg_cjarsiglas',$this->url->url_cjarsiglas)
            ->where('msg_urltxt',$this->url->url_urltxt)
            ->where('msg_del','0')->where('msg_act','1')
            ->where('msg_edo','3')
            ->get();;

        ##### Obtiene ligas
        $this->ligas=ced_externos::where('ext_jardin',$this->url->url_cjarsiglas)
            ->where('ext_urltxt',$this->url->url_urltxt)
            ->where('ext_act','1')
            ->where('ext_del','0')
            ->orderBy('ext_id')
            ->with('red')
            ->get();
            // dd($this->ligas);
        ##### Conteo de visitantes
        $NumVists=sist_visitas::where('vis_url',url()->current())->count();


        return view('livewire.web.cedulas-controller',[
            'cedula'=>$cedula,
            // 'especies'=>$especies,
            'NumVisits'=>$NumVists,

        ]);
    }







    ############################################################
    ############################## Abre modal de editor de texto
    public function AbreModalEditaParrafo($id, $orden, $modulo, $jardin, $url,$reload){
        #####<livewire:sistema.jardin-web-modal-component />
        if($this->edit=='1'){
            ##### Abre modal
            $data=[
                'id'=>$id,
                'orden'=>$orden,
                'modulo'=>'cedula',
                'jardin'=>$this->url->url_cjarsiglas,
                'url'=>$this->url->url_url,
                'reload'=>$reload,
            ];
            $this->dispatch('AbreModalDeParrafoWebJardin',$data);
        }
    }

    ############################################################
    ############################## Modal Traduce Titulo
    public function AbirModalTraduceTitulo($tipo){
        #####<livewire: web.web.cedulas.controller  />
        $data=[
            'urlId'=>$this->url->url_id,
            'tipo'=>$tipo,
            // 'NuevoTituloTraducido'=>$this->url->url_titulo,
        ];
        $this->dispatch('AbreModalTraduceTitulo', $data);
    }
    // public function CerrarModalTraduceTitulo(){
    //     #####<livewire: web.web.cedulas.controller  />
    //     $this->dispatch('CierraModalTraduceTitulo');
    // }
    // public function GuardaTituloTraducido(){
    //     #####<livewire: web.web.cedulas.controller  />
    //     $this->validate([
    //         'NuevoTituloTraducido'=>'required'
    //     ]);
    //     cedulas_url::where('url_id',$this->url->url_id)->update([
    //         'url_titulo'=>$this->NuevoTituloTraducido,
    //     ]);
    //     redirect('/cedula/'.$this->url->url_cjarsiglas.'/'.$this->url->url_url);
    // }
    // public function SubirAudioTitulo(){
    //     if($this->NuevoAudio){
    //         #### valida formulario
    //         $this->validate([
    //             'NuevoAudio'=>'file|mimes:audio/mpeg,mpga,mp3,wav,ogg,aac|max:10240', // Máximo 10MB
    //         ]);
    //         #### Genera nombre de archivo y ruta
    //         $nombreArchivo = $this->url->url_urltxt.'_'.$this->url->url_cjarsiglas.'_'.$this->url->url_lencode.'_00_titulo.'.$this->NuevoAudio->getClientOriginalExtension();
    //         $rutaArchivo = '/cedulas/audios/';
    //         ##### Guarda archivo
    //         $this->NuevoAudio->storeAs('/public'.$rutaArchivo, $nombreArchivo);
    //         ##### Modifica base de datos
    //         cedulas_url::where('url_id',$this->url->url_id)->update([
    //             'url_audiotitulo'=>$rutaArchivo.$nombreArchivo,
    //         ]);

    //         $this->url->url_audiotitulo = $rutaArchivo.$nombreArchivo;
    //     }
    // }
    // public function EliminarAudioTitulo(){
    //     ##### Elimina archivo
    //     // if($this->url->url_audiotitulo){
    //     //     \Storage::delete($this->url->url_audiotitulo);
    //     // }
    //     ##### Modifica base de datos
    //     cedulas_url::where('url_id',$this->url->url_id)->update([
    //         'url_audiotitulo'=>null,
    //     ]);
    //     $this->url->url_audiotitulo = null;
    // }

    ##########################################################
    ################## Modal externo Agregar Ubicación
    public function AbrirModalDeUbicacion($ubicaId){
        #####<livewire:sistema.modal-cedula-ubicaciones-component />
        $datos=[
            'ubicaId'=>$ubicaId,
            'urlid'=>$this->url->url_id,
        ];
        $this->dispatch('AbreModalAsignaUbicacion',$datos);
    }

    ##########################################################
    ################## Modal externo Agregar Alias
    public function AbrirModalDeAlias($aliasId){
        #####<livewire:sistema.modal-cedula-alias-component />
        $this->verAlias='1';
        $datos=[
            'aliasId'=>$aliasId, ### o id del uso
            'urlId'=>$this->url->url_id,
        ];
        $this->dispatch('AbreModalAlias',$datos);
    }

    ##########################################################
    ################## Modal externo Cambio de estado
    public function AbreModalDeCambioDeEstado($id){
        #####<livewire:sistema.modal-cedula-cambia-estado-component />
        $data=['urlId'=>$id];
        $this->dispatch('AbreModalCambiaEdoCedula',$data);
    }

    ##########################################################
    ################## Modal externo Yo tengo algo que aportar
    public function AbrirModalYoTengoAlgoQueAportar(){
        ##### <livewire:web.modal-cedula-yo-tengo-que-aportar />
        $dato=[
            'urlId'=>$this->url->url_id,
        ];
        $this->dispatch('AbreModalYoTengoQueAportar',$dato);
    }

    ###########################################################
    ################## Modal externo abrir buscar objeto
    // public function AbrirModalPaIncertarObjeto($tipo){
    public function AbrirModalPaIncertarObjeto($imgId, $cimgmodulo, $cimgtipo, $imgkey, $reload){
        #####<livewire:sistema.modal-inserta-objeto-component />
        if($imgkey==''){$imgkey=$this->url->url_key;}
        $datos=[
            'imgId'=>$imgId,           ### img_id o 0 para nuevo
            'cimgmodulo'=>$cimgmodulo,     ### cimg_modulo de cat_img (cedula,jardin,autor) o null
            'cimgtipo'=>$cimgtipo,          ###cimg_tipo de cat_img (web, portada, ppal,lat, etc...)  o null
            'imgkey'=>$imgkey,  #### key: Jardin@urltxt (sin traduccción)  o null
            'reload'=>$reload,          ##### indica si hace reload(1) o no(0) al guardar
        ];
        $this->dispatch('AbreModalIncertaObjeto',$datos);
    }

    ####################################################################
    ############### Modal para ver objetos
    public function AbreModalVerObjetos($tipoDato){
        #####<livewire:sistema.modal-ver-objeto-component />
        $data=[
                'jardin'=>$this->url->url_cjarsiglas,
                'modulo'=>'cedula',
                'url'=>$this->url->url_url,
                'tipoDato'=>'',
            ];

        $this->dispatch('AbreModalDeVerObjetos',$data);
    }

    ####################################################################
    ############### Modal para editar aporte
    public function AbrirModalParaEditarAporteDeVisitante($id){
        #####<livewire:sistema.modal-admin-aportes-publico-component />
        $dato=[
            'msgId'=>$id,
        ];
        $this->dispatch('AbreModalParaEditarAporteDeVisitante', $dato);
    }

    ####################################################################
    ############### Modal para abrir fuente externa
    public function AbrirModalDeFuenteExterna($extid, $jardin, $urltxt){
        #####<livewire:sistema.modal-cedula-fuente-externa-componennt />
        $datos=[
            'extid'=>$extid,  #### id de ext_id o 0 para nuevo
            'jardin'=>$jardin, #### Jardín al que pertenece
            'urltxt'=>$urltxt,  ####urltxt (sin lengua) al que pertenece
        ];

        $this->dispatch('AbreModalFuenteExterna',$datos);
    }
}


