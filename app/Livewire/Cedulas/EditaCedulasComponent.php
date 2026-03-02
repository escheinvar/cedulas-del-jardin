<?php

namespace App\Livewire\Cedulas;

use App\Models\CatEtiquetasImgModel;
use App\Models\CatJardinesModel;
use App\Models\CatKewModel;
use App\Models\CatLenguasModel;
use App\Models\SistBuzonMensajesModel;
use App\Models\SpCedulasModel;
use App\Models\SpFotosModel;
use App\Models\SpUrlCedulaModel;
use App\Models\SpUrlCedulaVersionModel;
use App\Models\SpUrlModel;
use App\Models\UserRolesModel;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Termwind\Components\Span;

#[Layout('plantillas.PlantillaSistemaBase')]
class EditaCedulasComponent extends Component
{
    use WithFileUploads;

    public $cedID, $TxtIdEnEdicion, $codedit;
    public $NvoTitulo, $NvoOrder, $NvoCodigo,$NvoAudio;
    public $NvaImagen, $NvaImagenTipo, $NvaImgDate, $NvaImgAutor,$NvaImgTitulo, $NvaImgDescr ;
    public $NvoVideo, $NvoImg1, $NvoImg2, $NvoImg3, $NvaVersion;
    public $DelAudio, $DelVideo, $DelImg1, $DelImg2, $DelImg3;
    public $cedulas, $traductor, $NvaVersionCedula,$NvaCita, $NvoDoi, $NotasDeCorreccion;


    public function mount($cedID){
        $this->cedID=$cedID;
        $this->TxtIdEnEdicion='0';
        $this->NvaVersion=true;
        $this->NvaVersionCedula=false;
        $this->NvaCita=SpUrlCedulaModel::where('ced_id',$cedID)->value('ced_cita');
        $this->NotasDeCorreccion='';
        $this->NvoDoi=SpUrlCedulaModel::where('ced_id',$cedID)->value('ced_doi');


        ##### OJO: si tiene doi y no soy cedulas/todas, no debería poder editar.

        // ###################################################
        // ###### Determina permisos. Atn: esta página puede tener permisos por 2 vías:
        // ###### admin le brinda privilegios de edición sobre uno o más jardines
        // ###### traduce le brinda privilegios (solo de edición de texto) a un jardín y una lengua
        // ###################################################
        // ##### Obtiene jardines a los que tiene permiso el editor
        $this->cedulas='0';
        $JardinesQueEdita=UserRolesModel::where('rol_act','1')
            ->where('rol_usrid',Auth::id())
            ->where('rol_crolrol','cedulas')
            ->pluck('rol_tipo1')
            ->toArray();

        if(count($JardinesQueEdita) > 0 ) {
            $this->cedulas='1';
            if(in_array('todas',$JardinesQueEdita)){
                $JardinesQueEdita=CatJardinesModel::pluck('cjar_siglas')->toArray();
                $this->cedulas='2';
            }
        }

        ##### Obtiene array de lenguas por jardín a los que tiene permiso el traductor
        $LenguasQueTraduce=UserRolesModel::where('rol_act','1')
            ->where('rol_usrid',Auth::id())
            ->where('rol_crolrol','traduce')
            ->select('rol_tipo1','rol_tipo2')
            ->get();

        ##### Obtiene jardín de la cédula
        $JardinDeCedula=SpUrlCedulaModel::where('ced_act','1')
            ->where('ced_id',$cedID)
            ->value('ced_cjarsiglas');

        ##### Obtiene lengua de la cédula
        $LenguaDeCedula=SpUrlCedulaModel::where('ced_act','1')
            ->where('ced_id',$cedID)
            ->value('ced_clencode');

        ##### Revisa si otorga permiso de editor
        // if( (in_Array('cedulas',session('rol')) AND (in_array($JardinDeCedula,$JardinesQueEdita) OR in_array('todas',$JardinesQueEdita) ) ) ){
        //     $this->cedulas='1';
        // }else{
        //     $this->cedulas='0';
        // }


        ##### Revisa si otorga permiso de traductor
        if(in_array('traduce',session('rol'))  AND $LenguasQueTraduce->where('rol_tipo1', $JardinDeCedula)->where('rol_tipo2',$LenguaDeCedula)->count() > 0   ){
            $this->traductor='1';

        }else{
            $this->traductor='0';
        }
        if( $this->cedulas=='0' AND $this->traductor == '0'){
            return redirect('/error No cuentas con las credenciales necesarias');
        }
        #$this->cedulas='0';

    }

    public function BorraFoto($foto){
        ##### Identifica la foto a borrar
        $datos=SpUrlCedulaModel::where('ced_id',$this->cedID)->first();
        $fotoID=SpFotosModel::where('imgsp_urlurl',$datos->ced_urlurl)
            ->where('imgsp_cjarsiglas',$datos->ced_cjarsiglas)
            ->where('imgsp_cimgname',$foto)
            ->first();

        ##### Borra el archivo de la foto
        Storage::delete('/aPublic/cedulas/'.$fotoID->imgsp_file);
        if($fotoID->imgsp_filelow != ''){
            Storage::delete('/aPublic/cedulas/'.$fotoID->imgsp_filelow);
        }

        ##### Borra foto en BD
        SpFotosModel::where('imgsp_id',$fotoID->imgsp_id)->update([
            'imgsp_act'=>'0',
        ]);
    }

    public function SubirFoto(){
        $this->validate([
            'NvaImagen'=>'required',
            'NvaImagenTipo'=>'required',
        ]);
        ##->Cargar metadatos?
        ##### Obtiene datos de cédula
        $urlced=SpUrlCedulaModel::where('ced_id',$this->cedID)
            ->join('sp_url','ced_urlurl','=','url_url')
            ->leftJoin('cat_lenguas','clen_code','=','ced_clencode')
            ->first();
        ##### Genera nuevo nombre de imágen
        $nombre=$urlced->ced_urlurl."_".$urlced->ced_cjarsiglas."_".$this->NvaImagenTipo.".".$this->NvaImagen->getClientOriginalExtension();
        ##### Guarda la imágen como archivo y en BD
        $this->NvaImagen->storeAs(path:'/aPublic/cedulas/',name:$nombre);
        SpFotosModel::create([
            'imgsp_urlurl'=>$urlced->ced_urlurl,
            'imgsp_cjarsiglas'=>$urlced->ced_cjarsiglas,
            'imgsp_file'=>$nombre,
            'imgsp_cimgname'=>$this->NvaImagenTipo,
            'imgsp_date'=>$this->NvaImgDate,
            'imgsp_autor'=>$this->NvaImgAutor,
            'imgsp_titulo'=>$this->NvaImgTitulo,
            'imgsp_pie'=>$this->NvaImgDescr,
        ]);
        $this->NvaImagen="";
        $this->NvaImagenTipo="";
        #dd($this->NvaImagen->getClientOriginalName(),$nombre);
    }

    public function DeterminaParrafoAeditar($id){
        $this->TxtIdEnEdicion=$id;
        $codedit=SpCedulasModel::where('txt_id',$id)->first();
        $this->NvoTitulo= $codedit->txt_titulo;
        $this->NvoOrder= $codedit->txt_order;
        $this->NvoCodigo= $codedit->txt_codigo;
    }

    public function CancelaCambio(){
        $this->TxtIdEnEdicion=null;
        $this->NvoTitulo=null;
        $this->NvoOrder=null;
        $this->NvoCodigo=null;
    }

    public function GuardarCambios(){
        ##### Inactiva
        SpCedulasModel::where('txt_id',$this->TxtIdEnEdicion)->update([
            'txt_act'=>'0',
        ]);
        ##### Obtiene datos
        $datos=SpCedulasModel::where('txt_id',$this->TxtIdEnEdicion)->first();
        $datosCedula=SpUrlCedulaModel::where('ced_id',$datos->txt_cedid)->first();
        ###### Crea nombre de archivos: especie_jardin_lengua_
        $nombre=$datosCedula->ced_urlurl."_".$datosCedula->ced_cjarsiglas."_".$datosCedula->ced_clencode;

        ##### Calcula versión
        if($this->NvaVersion==true){
            $version=SpCedulasModel::where('txt_id',$this->TxtIdEnEdicion)->value('txt_version') + 0.1;
        }else{
            $version=SpCedulasModel::where('txt_id',$this->TxtIdEnEdicion)->value('txt_version');
        }

        ###### Guarda nueva cédula (sin arhivos)
        $nuevo=SpCedulasModel::create([
            'txt_cedid'=>$datos->txt_cedid,
            'txt_titulo'=>$this->NvoTitulo,
            'txt_order'=>$this->NvoOrder,
            'txt_codigo'=>$this->NvoCodigo,
            'txt_autor'=>$datos->txt_autor,
            'txt_version'=>$version,
            'txt_resp'=>Auth::id(),
        ]);

        ##### Genera nombre de audio y guarda el archivo Y bd
        if($this->NvoAudio !=''){
            $nombre2=$nombre."_".$nuevo->txt_id."_audio.".$this->NvoAudio->getClientOriginalExtension();
            $this->NvoAudio->storeAs('/aPublic/cedulas/audios/', $nombre2);
            SpCedulasModel::where('txt_id',$nuevo->txt_id)->update(['txt_audio'=>$nombre2]);
        }else{
            SpCedulasModel::where('txt_id',$nuevo->txt_id)->update(['txt_audio'=>$datos->txt_audio]);
        }
        ##### Genera nombre de video y guarda el archivo Y bd
        if($this->NvoVideo !=''){
            $nombre2=$nombre."_".$nuevo->txt_id."_video.".$this->NvoVideo->getClientOriginalExtension();
            $this->NvoVideo->storeAs('/aPublic/cedulas/', $nombre2);
            SpCedulasModel::where('txt_id',$nuevo->txt_id)->update(['txt_video'=>$nombre2]);
        }else{
            SpCedulasModel::where('txt_id',$nuevo->txt_id)->update(['txt_video'=>$datos->txt_video]);
        }
        ##### Genera nombre de img1 y guarda el archivo Y bd
        if($this->NvoImg1 !=''){
            $nombre2=$nombre."_".$nuevo->txt_id."_img1.".$this->NvoImg1->getClientOriginalExtension();
            $this->NvoImg1->storeAs('/aPublic/cedulas/', $nombre2);
            SpCedulasModel::where('txt_id',$nuevo->txt_id)->update(['txt_img1'=>$nombre2]);
        }else{
            SpCedulasModel::where('txt_id',$nuevo->txt_id)->update(['txt_img1'=>$datos->txt_img1]);
        }
        ##### Genera nombre de img1 y guarda el archivo Y bd
        if($this->NvoImg2 !=''){
            $nombre2=$nombre."_".$nuevo->txt_id."_img2.".$this->NvoImg2->getClientOriginalExtension();
            $this->NvoImg2->storeAs('/aPublic/cedulas/', $nombre2);
            SpCedulasModel::where('txt_id',$nuevo->txt_id)->update(['txt_img2'=>$nombre2]);
        }else{
            SpCedulasModel::where('txt_id',$nuevo->txt_id)->update(['txt_img2'=>$datos->txt_img2]);
        }
        ##### Genera nombre de img1 y guarda el archivo Y bd
        if($this->NvoImg3 !=''){
            $nombre2=$nombre."_".$nuevo->txt_id."_img3.".$this->NvoImg3->getClientOriginalExtension();
            $this->NvoImg3->storeAs('/aPublic/cedulas/', $nombre2);
            SpCedulasModel::where('txt_id',$nuevo->txt_id)->update(['txt_img3'=>$nombre2]);
        }else{
            SpCedulasModel::where('txt_id',$nuevo->txt_id)->update(['txt_img3'=>$datos->txt_img3]);
        }
        ###### Si hay que borrar audio, lo borra:
        if($this->DelAudio==true){
            Storage::delete('/aPublic/cedulas/audios/'.$datos->txt_audio);
            SpCedulasModel::where('txt_id',$nuevo->txt_id)->update(['txt_audio'=>null]);
        }
        ###### Si hay que borrar video, lo borra:
        if($this->DelVideo==true){
            Storage::delete('/aPublic/cedulas/'.$datos->txt_video);
            SpCedulasModel::where('txt_id',$nuevo->txt_id)->update(['txt_video'=>null]);
        }
        ###### Si hay que borrar img1, lo borra:
        if($this->DelImg1==true){
            Storage::delete('/aPublic/cedulas/'.$datos->txt_img1);
            SpCedulasModel::where('txt_id',$nuevo->txt_id)->update(['txt_img1'=>null]);
        }
        ###### Si hay que borrar img2, lo borra:
        if($this->DelImg2==true){
            Storage::delete('/aPublic/cedulas/'.$datos->txt_img2);
            SpCedulasModel::where('txt_id',$nuevo->txt_id)->update(['txt_img2'=>null]);
        }
        ###### Si hay que borrar img3, lo borra:
        if($this->DelImg3==true){
            Storage::delete('/aPublic/cedulas/'.$datos->txt_img3);
            SpCedulasModel::where('txt_id',$nuevo->txt_id)->update(['txt_img3'=>null]);
        }
        $this->NvoAudio=$this->NvoVideo=$this->NvoImg1=$this->NvoImg2=$this->NvoImg3=null;
        redirect('/editaCedula/'.$this->cedID);
    }

    public function NuevoParrafo(){
      SpCedulasModel::create([
        'txt_cedid'=>$this->cedID,
        'txt_titulo'=>'0',
        'txt_order'=>SpCedulasModel::where('txt_cedid',$this->cedID)->max('txt_order') + 1,
        'txt_codigo'=>'Lorem Ipsum...',
        #'txt_audio'=>null,
        'txt_autor'=>Auth::id(),
        'txt_version'=>'0.0',
        'txt_resp'=>Auth::id(),
      ]);
    }

    public function BorrarParrafo($id){
        ##### Busdca archivo de audio y lo borra (en su caso)
        $origen=SpCedulasModel::where('txt_id',$id)->first();
        #dd($id,$origen);
        if($origen->txt_audio != ''){ Storage::delete('/aPublic/cedulas/audios/'.$origen->txt_audio);}
        if($origen->txt_video != ''){ Storage::delete('/aPublic/cedulas/'.$origen->txt_video);}
        if($origen->txt_img1 != ''){ Storage::delete('/aPublic/cedulas/'.$origen->txt_img1);}
        if($origen->txt_img2 != ''){ Storage::delete('/aPublic/cedulas/'.$origen->txt_img2);}
        if($origen->txt_img3 != ''){ Storage::delete('/aPublic/cedulas/'.$origen->txt_img3);}

        SpCedulasModel::where('txt_id',$id)->update([
            'txt_act'=>'0',
            'txt_resp'=>Auth::id(),
        ]);
    }

    public function EnviarCedula($valor){
        ##### Obtiene datos para el mensaje
        $jardin=SpUrlCedulaModel::where('ced_id',$this->cedID)->value('ced_cjarsiglas');
        $cedula=SpUrlCedulaModel::where('ced_id',$this->cedID)->value('ced_urlurl');
        $lengua=SpUrlCedulaModel::where('ced_id',$this->cedID)->value('ced_clencode');
        $Notas='';

        ##### Prepara variables
        if($valor=='1' OR $valor=='5' or $valor=='3'){
            if($valor=='1' or $valor=='3'){
                $asunto='Corregir cédula';
                $mensaje="Se solicitaron correcciones a la cédula \"".$cedula."\" del jardín \"".$jardin."\" en lengua \"".$lengua."\"";
            }else{
                $asunto="Cédula publicada";
                $mensaje="La cédula \"".$cedula."\" del jardín \"".$jardin."\" en lengua \"".$lengua."\" ya fue publicada";
            }
            ##### Obtiene lista de revisores a los que se envía mensaje (traductores del jardin y de la lengua)
            $revisores=UserRolesModel::where('rol_act','1')
                ->where('rol_crolrol','traduce')
                ->where('rol_tipo1', SpUrlCedulaModel::where('ced_id',$this->cedID)->value('ced_cjarsiglas'))
                ->where('rol_tipo2', SpUrlCedulaModel::where('ced_id',$this->cedID)->value('ced_clencode'))
                ->pluck('rol_usrid')
                ->toArray();

        }elseif($valor=='2' or $valor=='4'){
            if($valor=='2'){
                $asunto='Revisar nueva cédula';
                $mensaje="La cédula \"".$cedula."\" del jardín \"".$jardin."\" en lengua \"".$lengua."\" se envía para su revisión.";
            }else{
                $asunto='Revisar cédula editada';
                $mensaje="La Cédula \"".$cedula."\" del jardín \"".$jardin."\" en lengua \"".$lengua."\" se editó y se envía para su revisión.";
            }
            ##### Obtiene lista de revisores a los que se envía mensaje (todos los que sean cedula del jardin o cedula/todas)
            $revisores=UserRolesModel::where('rol_act','1')
                ->where('rol_crolrol','cedulas')
                ->where(function($q){
                    return $q
                    ->where('rol_tipo1','todas')
                    ->orWhere('rol_tipo1', SpUrlCedulaModel::where('ced_id',$this->cedID)->value('ced_cjarsiglas'));
                })
                ->pluck('rol_usrid')
                ->toArray();
            #dd($revisores);
        }elseif($valor=='0'){
            //
        }

        ##### Cambia estado de cédula en BD
        SpUrlCedulaModel::where('ced_id',$this->cedID)->update([
            'ced_edo'=>$valor,
        ]);

        ##### Envía mensaje a buzón
        foreach($revisores as $r){
            SistBuzonMensajesModel::create([
                'buz_modulo'=>'cedulas',
                'buz_usr_origen'=>Auth::id(),
                'buz_destino_usr'=>$r,
                'buz_notas'=>$this->NotasDeCorreccion,
                'buz_asunto'=>$asunto,
                'buz_mensaje'=>$mensaje,
                'buz_date_origen'=>date('Y-m-d H:i:s'),
            ]);
        }

        redirect('/catCedulas');
    }

    public function NuevaCita(){
        SpUrlCedulaModel::where('ced_id',$this->cedID)->update([
            'ced_cita'=>$this->NvaCita,
        ]);
    }

    public function NuevaVersion(){
        ###### Obtiene versión previa
        $vieja=SpUrlCedulaModel::where('ced_id',$this->cedID)->value('ced_version');

        ###### Cambia a la nueva versión de la cédula
        SpUrlCedulaModel::where('ced_id',$this->cedID)->update([
            'ced_version'=> $vieja + 0.1,
        ]);
        ###### Resetea todas las versiones de párrafo
        SpCedulasModel::where('txt_cedid',$this->cedID)->where('txt_act','1')->update([
            'txt_version'=> '0.0',
        ]);
        redirect('/sppdf/'.$this->cedID.'/b64');
    }

    public function NuevoDoi(){
        // $this->validate([
        //     'NvoDoi'=>'required',
        // ]);
        SpUrlCedulaModel::where('ced_id',$this->cedID)->update([
            'ced_doi'=>$this->NvoDoi,
        ]);
    }

    public function render() {
        $urlced=SpUrlCedulaModel::where('ced_id',$this->cedID)
            ->join('sp_url','ced_urlurl','=','url_url')
            ->leftJoin('cat_lenguas','clen_code','=','ced_clencode')
            ->first();

        $textos=SpCedulasModel::where('txt_cedid',$this->cedID)
            ->where('txt_act','1')
            ->orderBy('txt_order')
            ->get();
        $fotos=SpFotosModel::where('imgsp_urlurl',$urlced->ced_urlurl)
            ->where('imgsp_cjarsiglas',$urlced->ced_cjarsiglas)
            ->where('imgsp_act','1')
            ->get();
        $jardinData=CatJardinesModel::where('cjar_siglas',$urlced->ced_cjarsiglas)->first();

        $version=[
            'ced_id'=>$urlced->ced_id,
            'cedula'=>$urlced->ced_urlurl.'/'.$urlced->ced_cjarsiglas.'/'.$urlced->ced_clencode,
            'ced_version'=>$urlced->ced_version,
            'ced_versiondate'=>$urlced->ced_versiondate,
            'ced_cita'=>$urlced->ced_cita,
            'ced_doi'=>$urlced->ced_doi,
            'ced_nombre'=>SpUrlModel::where('url_url',$urlced->ced_urlurl)->value('url_nombre'),
            'jardin'=>CatJardinesModel::where('cjar_siglas',$urlced->ced_cjarsiglas)->value('cjar_nombre'),
            'idioma2'=>CatLenguasModel::where('clen_code',$urlced->ced_clencode)->value('clen_lengua'),
            'versiones'=>SpUrlCedulaVersionModel::where('cedv_cedid',$urlced->ced_id)->select('cedv_id','cedv_cedversion','created_at')->get(),
        ];

        ##### Obtiene el listado de posición de imágenes ya utilizado
        $YaUsados=SpFotosModel::where('imgsp_urlurl',$urlced->ced_urlurl)
            ->where('imgsp_cjarsiglas',$urlced->ced_cjarsiglas)
            ->where('imgsp_act','1')
            ->pluck('imgsp_cimgname')
            ->toArray();
        ##### Obtiene catálogo de posición de imágenes y le saca los ya utilizados
        $tipoImgs=CatEtiquetasImgModel::where('cimg_gral','especie')
            ->where('cimg_tipo','cedula')
            ->select('cimg_name')
            ->whereNotIn('cimg_name',$YaUsados)
            ->get();

        ###### Roles Involucrados
        $roles=UserRolesModel::where('rol_act','1')
            ->whereIn('rol_crolrol',['cedulas','traduce'])
            ->where('rol_tipo1',$jardinData->cjar_siglas)
            ->orWhere('rol_tipo1','todas')
            ->join('users','rol_usrid','=','id')
            ->select('rol_crolrol','rol_tipo1','rol_tipo2','usrname','email')
            ->get();

        return view('livewire.cedulas.edita-cedulas-component',[
            'urlced'=>$urlced,
            'texto'=>$textos,
            'titulos'=>$textos->where('txt_titulo','1'),
            'fotos'=>$fotos,
            'jardinData'=>$jardinData,
            'version'=>$version,
            'tipoImgs'=>$tipoImgs,
            'roles'=>$roles,
        ]);
    }
}
