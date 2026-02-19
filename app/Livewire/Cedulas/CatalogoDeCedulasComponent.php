<?php

namespace App\Livewire\Cedulas;

use App\Models\CatJardinesModel;
use App\Models\CatKewModel;
use App\Models\CatLenguasModel;
use App\Models\SistBuzonMensajesModel;
use App\Models\SpCedulasModel;
use App\Models\SpFotosModel;
use App\Models\SpUrlCedulaModel;
use App\Models\SpUrlModel;
use App\Models\User;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;

class CatalogoDeCedulasComponent extends Component
{
    #[Layout('components.layouts.SistemaBase')]

    public $NvoTema, $NvoJardin,$NvoLengua, $NvoCopia, $NvoCopia2, $Valida;
    public $VerCrearCedula, $VerNuevoTema;
    public $urlId, $urlUrl, $urlNombre, $urlReino, $urlSp, $urlNombrecomun, $urlSciname, $urlpalabras;
    public $urlGenero, $urlGeneros;


    public function mount(){
        if( in_array('cedulas',session('rol')) OR in_array('traduce',session('rol')) ){
            $this->NvoCopia='0';
            $this->VerCrearCedula='0';
            $this->VerNuevoTema='0';
            $this->urlGeneros=collect();
        }else {
            return redirect('/home');
        }
    }

    public function GeneraCedula(){
        ##### Valida campos
        $this->validate([
            'NvoTema'=>'required',
            'NvoJardin'=>'required',
            'NvoLengua'=>'required',
        ]);
        if($this->NvoCopia=='1'){
            $this->validate([
                'NvoCopia2'=>'required',
            ]);
        }
        ###### Valida  que no exista la cédula
        $ganon=SpUrlCedulaModel::where('ced_act','1')
            ->where('ced_urlurl',$this->NvoTema)
            ->where('ced_clencode',$this->NvoLengua)
            ->where('ced_cjarsiglas',$this->NvoJardin)
            ->count();
        if($ganon>0){
            $this->validate([
                'Valida'=>'required',
            ],['Valida.required'=>'Error. Esta cédula ya existe.']);
        }

        ##### Genera nueva cédula en BD
        $NuevaCedula=SpUrlCedulaModel::create([
            'ced_id'=>SpUrlCedulaModel::max('ced_id') + 1,
            'ced_act'=>'1',
            'ced_edo'=>'0',
            'ced_urlurl'=>$this->NvoTema,
            'ced_clencode'=>$this->NvoLengua,
            'ced_cjarsiglas'=>$this->NvoJardin,
            'ced_version'=>'1.0',
            'ced_versiondate'=>date('Y-m-d'),
        ]);

        ##### genera cédula nueva (en caso de)
        if($this->NvoCopia=='0'){
            SpCedulasModel::create([
                'txt_id'=>SpCedulasModel::max('txt_id') + 1,
                'txt_cedid'=>$NuevaCedula->ced_id,
                'txt_titulo'=>'1',
                'txt_order'=>'1',
                'txt_codigo'=>'Titulo',
                'txt_version'=>'0.0',
                'txt_resp'=>Auth::id(),
            ]);

        ##### Copia cédula (en caso de)
        } elseif ($this->NvoCopia=='1'){
            ##### copia texto
            $origen=SpCedulasModel::where('txt_cedid',$this->NvoCopia2)  #NvoCopia2=ced_id
                ->where('txt_act','1')
                ->get();

            ##### pega texto
            foreach($origen as $o){
                ##### copia BD
                $nvo=SpCedulasModel::create([
                    'txt_cedid'=>$NuevaCedula->ced_id,
                    'txt_titulo'=>$o->txt_titulo,
                    'txt_order'=>$o->txt_order,
                    'txt_codigo'=>$o->txt_codigo,
                    'txt_audio'=>$o->txt_audio,
                    'txt_autor'=>$o->txt_autor,
                    #'txt_version'=>$o->txt_version,
                    'txt_version'=>'0.0',
                    'txt_resp'=>Auth::id(),
                ]);
                ##### copia audios del texto
                if($o->txt_audio != '' ){
                    $datos=SpUrlCedulaModel::where('ced_id',$o->txt_cedid)->first();
                    $NvoNombreAudio=$datos->ced_urlurl."_".$this->NvoJardin."_".$this->NvoLengua."_".$nvo->txt_id.".".preg_replace('/^.*\./','',$o->txt_audio);
                    Storage::copy('/aPublic/cedulas/audios/'.$o->txt_audio,  '/aPublic/cedulas/audios/'.$NvoNombreAudio);
                }else{
                    $NvoNombreAudio=null;
                }
                ##### copia img1 del texto
                if($o->txt_img1 != '' ){
                    $datos=SpUrlCedulaModel::where('ced_id',$o->txt_cedid)->first();
                    $NvoNombreImg1=$datos->ced_urlurl."_".$this->NvoJardin."_".$this->NvoLengua."_".$nvo->txt_id."_img1.".preg_replace('/^.*\./','',$o->txt_img1);
                    Storage::copy('/aPublic/cedulas/'.$o->txt_img1,  '/aPublic/cedulas/'.$NvoNombreImg1);
                }else{
                    $NvoNombreImg1=null;
                }
                ##### copia img2 del texto
                if($o->txt_img2 != '' ){
                    $datos=SpUrlCedulaModel::where('ced_id',$o->txt_cedid)->first();
                    $NvoNombreImg2=$datos->ced_urlurl."_".$this->NvoJardin."_".$this->NvoLengua."_".$nvo->txt_id."_img2.".preg_replace('/^.*\./','',$o->txt_img2);
                    Storage::copy('/aPublic/cedulas/'.$o->txt_img2,  '/aPublic/cedulas/'.$NvoNombreImg2);
                }else{
                    $NvoNombreImg2=null;
                }
                ##### copia img3 del texto
                if($o->txt_img3 != '' ){
                    $datos=SpUrlCedulaModel::where('ced_id',$o->txt_cedid)->first();
                    $NvoNombreImg3=$datos->ced_urlurl."_".$this->NvoJardin."_".$this->NvoLengua."_".$nvo->txt_id."_img3.".preg_replace('/^.*\./','',$o->txt_img3);
                    Storage::copy('/aPublic/cedulas/'.$o->txt_img3,  '/aPublic/cedulas/'.$NvoNombreImg3);
                }else{
                    $NvoNombreImg3=null;
                }
                ##### copia video del texto
                if($o->txt_video != '' ){
                    $datos=SpUrlCedulaModel::where('ced_id',$o->txt_cedid)->first();
                    $NvoNombreVideo=$datos->ced_urlurl."_".$this->NvoJardin."_".$this->NvoLengua."_".$nvo->txt_id."_video.".preg_replace('/^.*\./','',$o->txt_video);
                    Storage::copy('/aPublic/cedulas/'.$o->txt_video,  '/aPublic/cedulas/'.$NvoNombreVideo);
                }else{
                    $NvoNombreVideo=null;
                }
                ##### Cambia BD
                SpCedulasModel::where('txt_id',$nvo->txt_id)->update([
                    'txt_audio'=>$NvoNombreAudio,
                    'txt_img1'=>$NvoNombreImg1,
                    'txt_img2'=>$NvoNombreImg2,
                    'txt_img3'=>$NvoNombreImg3,
                    'txt_video'=>$NvoNombreVideo,
                    'txt_resp'=>Auth::id(),
                ]);
            }

            ##### Revisa si hay imágenes para esa url-jardin
            $origen2=SpFotosModel::where('imgsp_act','1')
                ->where('imgsp_urlurl',$this->NvoTema)
                ->where('imgsp_cjarsiglas',$this->NvoJardin)
                ->get();

            ##### Si no hay imágenes para la url-jardin, las copia
            if($origen2->count() =='0'){
                ##### Obtiene el listado de imágenes
                $idOrigen=SpUrlCedulaModel::where('ced_act','1')->where('ced_id',$this->NvoCopia2)->first();
                $origen3=SpFotosModel::where('imgsp_act','1')
                    ->where('imgsp_urlurl',$idOrigen->ced_urlurl)
                    ->where('imgsp_cjarsiglas',$idOrigen->ced_cjarsiglas)
                    ->get();

                ##### Copia las imágenes (dado que no hay)
                foreach($origen3 as $o){
                    ##### Si hay imagen, copia el archivo
                    if($o->imgsp_file != ''){
                        $NvoNombre=$this->NvoTema."_".$this->NvoJardin."_".$o->imgsp_cimgname.".".preg_replace('/^.*\./','',$o->imgsp_file);
                        Storage::copy('/aPublic/cedulas/'.$o->imgsp_file,  '/aPublic/cedulas/'.$NvoNombre);
                    }else{$NvoNombre=null;}

                    ##### Si hay imagen de baja resolución, copia el archivo
                    if($o->imgsp_filelow != ''){
                        $NvoNombreLow=$this->NvoTema."_".$this->NvoJardin."_".$o->imgsp_cimgname."_low.".preg_replace('/^.*\./','',$o->imgsp_filelow);
                        Storage::copy('/aPublic/cedulas/'.$o->imgsp_filelow,  '/aPublic/cedulas/'.$NvoNombreLow);
                    }else{$NvoNombreLow=null;}

                    ##### Copia las nuevas imágenes en BD
                    SpFotosModel::create([
                        'imgsp_urlurl'=>$this->NvoTema,
                        'imgsp_cjarsiglas'=>$this->NvoJardin,
                        'imgsp_file'=>$NvoNombre,
                        'imgsp_filelow'=>$NvoNombreLow,
                        'imgsp_cimgname'=>$o->imgsp_cimgname,
                        'imgsp_autor'=>$o->imgsp_autor,
                        'imgsp_titulo'=>$o->imgsp_titulo,
                        'imgsp_pie'=>$o->imgsp_pie,
                        'imgsp_date'=>$o->imgsp_date,
                        'imgsp_descrip'=>$o->imgsp_descrip,
                        'imgsp_metadata'=>$o->imgsp_metadata,
                    ]);
                }
            }
            $this->VerCrearCedula='0';
        }
        ###### Envía mensaje a buzón (cedula del jardín y traductores de lengua en jardín)
        $revisores=UserRolesModel::where('rol_act','1')
            ->where(function ($q){
                return $q
                ->where('rol_crolrol','cedulas')
                ->where('rol_tipo1',$this->NvoJardin)
                ->orWhere('rol_tipo1','todas');
            })
            ->orWhere(function ($r){
                return $r
                ->where('rol_crolrol','traduce')
                ->where('rol_tipo1',$this->NvoJardin)
                ->where('rol_tipo2',$this->NvoLengua);
            })
            ->pluck('rol_usrid')
            ->toArray();


        $asunto='Se creó una nueva cédula';
        $mensaje="El usuario \"".Auth::user()->email."\" creó la nueva cédula \"".$this->NvoTema."\" del jardín \"".$this->NvoJardin."\" en lengua \"".$this->NvoLengua."\".";

        foreach($revisores as $r){
            SistBuzonMensajesModel::create([
                'buz_modulo'=>'cedulas',
                'buz_usr_origen'=>Auth::id(),
                'buz_destino_usr'=>$r,
                'buz_notas'=>'',
                'buz_asunto'=>$asunto,
                'buz_mensaje'=>$mensaje,
                'buz_date_origen'=>date('Y-m-d H:i:s'),
            ]);
        }

        ###### Regresa valores a cero
        $this->NvoTema="";
        $this->NvoJardin="";
        $this->NvoLengua="";
    }

    public function BorrarCedula($id){

        ##### Genera lista de archivos
        $textos=SpCedulasModel::where('txt_cedid',$id)->get();
        $audios=$textos->where('txt_audio','!=','')->pluck('txt_audio');
        $img1=$textos->where('txt_img1','!=','')->pluck('txt_img1');
        $img2=$textos->where('txt_img2','!=','')->pluck('txt_img2');
        $img3=$textos->where('txt_img3','!=','')->pluck('txt_img3');
        $videos=$textos->where('txt_video','!=','')->pluck('txt_video');
        ##### Borra audios
        if($audios->count() > 0 ){
            foreach($audios as $i){
                Storage::delete('/aPublic/cedulas/audios/'.$i);
            }
        }
        ##### Borra imagenes y videos
        if($img1->count() > 0 ){
            foreach($img1 as $i){
                Storage::delete('/aPublic/cedulas/'.$i);
            }
        }
        if($img2->count() > 0 ){
            foreach($img2 as $i){
                Storage::delete('/aPublic/cedulas/'.$i);
            }
        }
        if($img3->count() > 0 ){
            foreach($img3 as $i){
                Storage::delete('/aPublic/cedulas/'.$i);
            }
        }
        if($videos->count() > 0 ){
            foreach($videos as $i){
                Storage::delete('/aPublic/cedulas/'.$i);
            }
        }

        ##### Inactiva textos de cédula
        SpCedulasModel::where('txt_cedid',$id)->update([
            'txt_act'=>'0',
            'txt_resp'=>Auth::id(),
        ]);

        ##### Inactiva cedula
        SpUrlCedulaModel::where('ced_id',$id)->update([
            'ced_act'=>'0',
        ]);
        redirect('/catCedulas');
    }

    public function IrConLengua($lengua,$url,$jardin){
        session(['locale2'=>$lengua]);
        redirect('/sp/'.$url.'/'.$jardin);
    }

    public function BuscaSpPlanta(){
        $this->urlGeneros=CatKewModel::where('ckew_genus','ilike','%'.$this->urlGenero.'%')
            ->select('ckew_taxonid','ckew_scientfiicname')
            ->orderBy('ckew_scientfiicname','asc')
            ->get();
    }

    public function IniciarEdicion($cedId){
        $estado=SpUrlCedulaModel::where('ced_id',$cedId)->value('ced_edo');
        if($estado=='5'){
            $nuevo='3';
            ###### Envía mensaje a buzón de  odos los que sean cedula del jardin o cedula/todas
            $revisores=UserRolesModel::where('rol_act','1')
                ->where('rol_crolrol','cedulas')
                ->where(function($q) use($cedId){
                    return $q

                    ->where('rol_tipo1','todas')
                    ->orWhere('rol_tipo1', SpUrlCedulaModel::where('ced_id',$cedId)->value('ced_cjarsiglas'));
                })
                ->pluck('rol_usrid')
                ->toArray();
            $data=SpUrlCedulaModel::where('ced_id',$cedId)->first();
            $mensaje='El usuario "'.Auth::user()->email.'" inició la edición de la cédula del tema "'.$data->ced_urlurl.'" en lengua "'.$data->ced_clencode.'" del jardín "' .$data->ced_cjarsiglas.'".';
            foreach($revisores as $r){
                SistBuzonMensajesModel::create([
                    'buz_modulo'=>'cedulas',
                    'buz_usr_origen'=>Auth::id(),
                    'buz_destino_usr'=>$r,
                    'buz_notas'=>'',
                    'buz_asunto'=>'Suspensión de URL activa',
                    'buz_mensaje'=>$mensaje,
                    'buz_date_origen'=>date('Y-m-d H:i:s'),
                ]);
            }
        }else{
            $nuevo=$estado;
        }
        SpUrlCedulaModel::where('ced_id',$cedId)->update(['ced_edo'=>$nuevo]);
        redirect('/editaCedula/'.$cedId);
    }

    public function VerCrearNuevaCedula(){
        $this->VerCrearCedula='1';
    }

    public function CancelarNuevaCedula(){
        $this->VerCrearCedula='0';
    }

    public function ActivarNuevoTema(){
        $this->VerNuevoTema='1';
        $this->VerCrearCedula='0';

        $this->urlId='0';
        $this->urlUrl='';
        $this->urlNombre='';
        $this->urlReino='';
        $this->urlSp=null;
        $this->urlNombrecomun='';
        $this->urlpalabras='';
        $this->urlSciname=null;
        $this->urlGenero=null;
    }

    public function CancelarNuevoTema(){
        $this->VerNuevoTema='0';
        $this->VerCrearCedula='0';
    }

    public function GuardarNuevoTema(){
        ##### Valida cuestionario
        $this->validate([
            'urlNombre'=>'required',
            'urlUrl'=>'required|unique:sp_url,url_url,'.$this->urlId.',url_id',
            'urlReino'=>'required',
        ]);
        ##### Si es planta, busca el número de catálogo del ejemplar
        if($this->urlReino=='pl'){
            $NomSci=CatKewModel::where('ckew_taxonid',$this->urlSp)->value('ckew_scientfiicname');
        }else{
            $NomSci=$this->urlSciname;
        }
        ##### Si el rol cédula tiene privilegio "todos", activa el nuevo tema, de lo contrario, lo deja en inactivo
        $rolesCed=UserRolesModel::where('rol_act','1')
            ->where('rol_usrid',Auth::id())
            ->where('rol_crolrol','cedulas')
            ->where('rol_tipo1','todas')
            ->count();
        if($rolesCed > 0 ){
            $activo='1';
            $mensaje="El usuario ".Auth::user()->email." creó el nuevo tema: '".$this->urlNombre."' en la url '/".$this->urlUrl."'";
        }else{
            $activo='0';
        }
        SpUrlModel::updateOrCreate(['url_url'=>$this->urlUrl], [
            'url_act'=> $activo,
            'url_url'=>$this->urlUrl,
            'url_nombre'=>$this->urlNombre,
            'url_reino'=>$this->urlReino,
            'url_sp'=>$this->urlSp,
            'url_nombrecomun'=>$this->urlNombrecomun,
            'url_sciname'=>$NomSci,
            'url_palabras'=>$this->urlpalabras,
        ]);
        $this->VerNuevoTema='0';
        $this->VerCrearCedula='0';

        ##### Busca destinatarios de buzón
        $destinos=UserRolesModel::where('rol_act','1')->where('rol_crolrol','cedulas')->orWhere('rol_crolrol','traduce')->distinct('rol_usrid')->pluck('rol_usrid')->toArray();
        ##### Manda mensaje a buzón
        foreach($destinos as $dest){
            SistBuzonMensajesModel::create([
                'buz_modulo'=>'cedulas',
                'buz_usr_origen'=>Auth::id(),
                'buz_destino_usr'=>$dest,
                'buz_asunto'=>'Nuevo tema de cédula',
                'buz_mensaje'=>$mensaje,
                'buz_date_origen'=>date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function EliminarNuevoTema($urlId){
        $data=SpUrlModel::where('url_id',$urlId)
            ->leftJoin('sp_urlcedula','url_url','=','ced_urlurl')
            ->leftJoin('sp_cedulas','txt_cedid','=','ced_id')
            ->get();
        $dataTxt=$data->where('txt_cedid','>','0');
        $dataCed=$data->where('ced_urlurl','!=','');

        #dd($urlId,$data->count(),$dataTxt->count(),$dataCed->count());
        if($dataCed->count() > 0){
            foreach($data as $d){
                SpCedulasModel::where('txt_id',$d->txt_id)->delete();
            }
        }
        if($dataTxt->count() > 0){
            foreach($data as $d){
                SpUrlCedulaModel::where('ced_id',$d->ced_id)->delete();
            }
        }
        foreach($data as $d){
            SpUrlModel::where('url_id',$d->url_id)->delete();
        }

        #SpUrlCedulaModel::where('ced_urlurl')
        #SpCedulasModel::where()
    }

    public function EditarNuevoTema($TemaId){
        ##### Abre ventana de nuevo tema
        $this->VerCrearCedula='0';
        $this->VerNuevoTema='1';
        ##### Obtiene datos
        $Datos=SpUrlModel::where('url_id',$TemaId)->first();
        $this->urlId=$Datos->url_id;
        $this->urlNombre = $Datos->url_nombre;
        $this->urlUrl = $Datos->url_url;
        $this->urlReino = $Datos->url_reino;
        $this->urlGenero = '';
        $this->urlSp = $Datos->url_sp;
        $this->urlSciname = $Datos->url_sciname;
        $this->urlNombrecomun = $Datos->url_nombrecomun;
        $this->urlpalabras = $Datos->url_palabras;

        #dd($TemaId);
    }
    public function render(){
        ####### Obtiene listado de Jardines al que tiene acceso el admon,. de cedulas
        $Autorizados=UserRolesModel::where('rol_act','1')
            ->where('rol_usrid',Auth::id())
            ->where(function($q){
                return $q
                ->where('rol_crolrol','cedulas')
                ->orWhere('rol_crolrol','traduce');
            })
            ->pluck('rol_tipo1')
            ->toArray();

        if(in_array('todas',$Autorizados)){
            $Autorizados=CatJardinesModel::pluck('cjar_siglas')->toArray();
        }

        ##### Preescribe ejemplo de url
        if($this->urlUrl != ''){
            $ja=strtolower($this->urlUrl);
            $sacar=[ 'ñ', ' ',  'Ñ', '=',  '\'', '\\','á', 'é','í','ó','ú','Á','É','Í','Ó','Ú','$','&','%'];
            $ja=str_replace($sacar,'',$ja);
            $this->urlUrl=$ja;
        }

        ##### Obtiene catálogo de temas disponibles (al crear cédulas)
        $temas=SpUrlModel::all();

        ##### Obtiene listado de jardines sobre los cuales se puede actuar (al crear cédulas)
        $jardinesUsr=UserRolesModel::where('rol_act','1')
            ->where('rol_usrid',Auth::id())
            ->where('rol_crolrol','cedulas')
            ->pluck('rol_tipo1')
            ->toArray();

        if(in_array('todas',$jardinesUsr)){
            $jardines=CatJardinesModel::all();
        }else{
            $jardines=CatJardinesModel::whereIn('cjar_siglas',$jardinesUsr)->get();
        }


        ##### Obtiene catálogo de lenguas
        $CatLenguas=CatLenguasModel::select('clen_code','clen_lengua')
            ->orderBy('clen_lengua')
            ->get();

        ##### Obtiene listado de cédulas a las que tiene acceso el admon de cédulas
        $cedulas=SpUrlCedulaModel::where('ced_act','1')
            ->join('cat_jardines','ced_cjarsiglas','=','cjar_siglas')
            ->whereIn('ced_cjarsiglas',$Autorizados)
            ->orderBy('ced_urlurl','asc')
            ->orderBy('ced_cjarsiglas','asc')
            ->orderBy('ced_clencode','asc')
            ->get();

        ##### Obtiene roles
        $roles_ced=UserRolesModel::where('rol_act','1')
            ->where('rol_usrid',Auth::id())
            ->where('rol_crolrol','cedulas')
            ->orderBy('rol_tipo1','asc')
            ->get();
        $roles_tra=UserRolesModel::where('rol_act','1')
            ->where('rol_usrid',Auth::id())
            ->where('rol_crolrol','traduce')
            ->orderBy('rol_tipo1','asc')
            ->get();

        return view('livewire.cedulas.catalogo-de-cedulas-component',[
            'temas'=>$temas,
            'cedulas'=>$cedulas,
            'jardines'=>$jardines,
            'CatLenguas'=>$CatLenguas,
            'roles_ced'=>$roles_ced,
            'roles_tra'=>$roles_tra,
        ]);
    }
}
