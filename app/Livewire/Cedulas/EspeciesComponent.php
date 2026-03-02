<?php

namespace App\Livewire\Cedulas;

use App\Models\CatCampusModel;
use App\Models\CatJardinesModel;
use App\Models\CatKewModel;
use App\Models\CatLenguasModel;
use App\Models\nom054semarnat;
use App\Models\SistBuzonMensajesModel;
use App\Models\SpAporteUsrsModel;
use App\Models\SpCedulasModel;
use App\Models\SpFotosModel;
use App\Models\SpUrlCedulaModel;
use App\Models\SpUrlCedulaVersionModel;
use App\Models\SpUrlModel;
use App\Models\UserRolesModel;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



#[Layout('plantillas.PlantillaWebSinScroll')]
class EspeciesComponent extends Component
{

    public $url, $jardin, $idioma, $CedId, $qrSize;
    public $verMsg, $MsgOrigen, $MsgEdad, $MsgMensaje;

    public function mount($url, $jardin){

        ##### Guarda en variable la lengua, url y el jardín
        if(session('locale2')==''){
            session(['locale2'=>'spa']);
        }
        $this->url=$url;
        $this->jardin=$jardin;
        $this->idioma=session('locale2');
        $this->CedId=SpUrlCedulaModel::where('ced_act','1')
            ->where('ced_urlurl',$url)
            ->where('ced_cjarsiglas',$jardin)
            ->where('ced_clencode',$this->idioma)
            ->value('ced_id');
        $this->qrSize='80';
        $this->verMsg='0';

        MyRegistraVisita(['ced_'.$url.'_'.$jardin.'_'.$this->idioma, $this->CedId]);
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
                    ->generate( url('/').'/sp/'.$this->url.'/'.$this->jardin );
            },
            'CodigoQR.png',
            [
                'Content-Type'=>'image/png'
            ]
            );
    }

    public function idiomas(){
        ##### Actualiza idioma en sesión
        ##### cuando se pica cambio de lengua
        session(['locale'=> $this->idioma]);
        session(['locale2'=> $this->idioma]);
        App::setLocale($this->idioma);
        redirect('/sp/'.$this->url.'/'.$this->jardin);
    }

    public function EntraMensajeUsr(){
        ##### Valida campos
        $this->validate([
            'MsgMensaje'=>'required|min:10',
        ]);
        ##### Guarda mensaje
        SpAporteUsrsModel::create([
            'msg_act'=>'1',
            'msg_edo'=>'0',
            'msg_cedid'=>$this->CedId,
            'msg_usr'=>Auth::user()->id,
            'msg_usuario'=>Auth::user()->usrname,
            'msg_origen'=>$this->MsgOrigen,
            'msg_edad'=>$this->MsgEdad,
            'msg_mensaje'=>$this->MsgMensaje,
            'msg_date'=>date('Y-m-d'),
        ]);
        ##### Envía mensaje a cedula y traduce
        ##### Obtiene lista de revisores a los que se envía mensaje (traductores del jardin y de la lengua)
        $revisores=UserRolesModel::where('rol_act','1')
            ->where(function($q){
                return $q
                ->where('rol_crolrol','traduce')
                ->where('rol_tipo1', SpUrlCedulaModel::where('ced_id',$this->CedId)->value('ced_cjarsiglas'))
                ->where('rol_tipo2', SpUrlCedulaModel::where('ced_id',$this->CedId)->value('ced_clencode'));
            })
            ->orWhere(function($q){
                return $q
                ->where('rol_crolrol','cedulas')
                ->where('rol_tipo1',SpUrlCedulaModel::where('ced_id',$this->CedId)->value('ced_cjarsiglas') )
                ->orWhere('rol_tipo1','todas');
            })
            ->pluck('rol_usrid')
            ->toArray();
        ##### Envía mensaje a cada encargado
        foreach($revisores as $i){
            SistBuzonMensajesModel::create([
                'buz_modulo'=>'cedulas/usuarios',
                'buz_usr_origen'=>Auth::user()->id,
                'buz_destino_usr'=>$i,
                'buz_notas'=>$this->MsgMensaje,
                'buz_asunto'=>'Usuario público ingresón información a cédula',
                'buz_mensaje'=>'El usuario '.$this->MsgOrigen.'aportó información a la cédula "'.$this->url.'" en lengua "'.$this->idioma.'" del jardín "'.$this->jardin.'(Id: '.$this->CedId.').',
                'buz_date_origen'=>date('Y-m-d H:i:s'),

            ]);
        }
        $this->CancelaMensajeUsr();
    }

    public function VerMensaje($edo){
        $this->verMsg=$edo;
    }

    public function CancelaMensajeUsr(){
        $this->verMsg='0';
        $this->MsgOrigen='';
        $this->MsgEdad='';
        $this->MsgMensaje='';
    }

    public function render(){
        ##### Confirma url, lengua y jardín
        $datoUrl=SpUrlCedulaModel::join('sp_url','url_url','=','ced_urlurl')
            ->where('ced_act','1')
            ->where('ced_edo','5')
            ->where('ced_urlurl',$this->url)
            ->where('ced_clencode',session('locale2'))
            ->where('ced_cjarsiglas',$this->jardin)
        ->first();

        ##### Si no existe idioma de ficha para session(locale2),
        ##### Cambia session(locale2)  al primer idioma o jardín existente para esa ficha
        if(is_null($datoUrl)){
            $CedulasExistentes=SpUrlCedulaModel::where('ced_act','1')
                #->where('ced_edo','5')  ###oJO: SE SILENCÍA PARA VER CÉDULAS EN CONSTRUCCIÓN
                ->where('ced_urlurl',$this->url)
                ->first();
            $datoUrl=SpUrlCedulaModel::join('sp_url','url_url','=','ced_urlurl')
                ->where('ced_act','1')
                #->where('ced_edo','5') ###oJO: SE SILENCÍA PARA VER CÉDULAS EN CONSTRUCCIÓN
                ->where('ced_urlurl',$this->url)
                ->where('ced_clencode',$CedulasExistentes->ced_clencode)
                ->where('ced_cjarsiglas',$CedulasExistentes->ced_cjarsiglas)
                ->first();
            session(['locale2'=>$datoUrl->ced_clencode]);
        }
        #dd($this->url, $this->jardin, session('locale2'), $datoUrl);


        ##### si no hay url o jardín, redirecciona a error
        if($datoUrl =='' or is_null($datoUrl)){redirect('/errorNo URL');die();}

        ##### Obtiene datos taxonómicos principales de la especie
        if($datoUrl->url_reino =='pl'){
            $taxo['id']=$datoUrl->url_sp;
            $taxo['nombrecomun']=$datoUrl->url_nombrecomun;
            $taxo['reino']='Plantae';
            $taxo['familia']=CatKewModel::where('ckew_taxonid',$datoUrl->url_sp)->get()->value('ckew_family');
            $taxo['sp']=CatKewModel::where('ckew_taxonid',$datoUrl->url_sp)->get()->value('ckew_scientfiicname');
            $taxo['autor']=CatKewModel::where('ckew_taxonid',$datoUrl->url_sp)->get()->value('ckew_scientfiicnameautorship');
            $taxo['genero']=CatKewModel::where('ckew_taxonid',$datoUrl->url_sp)->get()->value('ckew_genus');
            $taxo['especie']=CatKewModel::where('ckew_taxonid',$datoUrl->url_sp)->get()->value('ckew_specificepithet');
            $taxo['infrasp']=CatKewModel::where('ckew_taxonid',$datoUrl->url_sp)->get()->value('ckew_infraspecificepithet');
        }elseif($datoUrl->url_reino =='an'){  #### en tanto no exista catálogo de plantas u hongos....
            $taxo['id']=$datoUrl->url_sp;
            $taxo['nombrecomun']=$datoUrl->url_nombrecomun;
            $taxo['reino']='Animalia';
            $taxo['familia']='';
            $taxo['sp']='';
            $taxo['autor']='';
            $taxo['genero']='';
            $taxo['especie']='';
            $taxo['infrasp']='';
        }else{
            $taxo['id']='0';
            $taxo['nombrecomun']=$datoUrl->url_nombrecomun;
            $taxo['reino']=$datoUrl->url_reino;
            $taxo['familia']='';
            $taxo['sp']='';
            $taxo['autor']='';
            $taxo['genero']='';
            $taxo['especie']='';
            $taxo['infrasp']='';
        }

        ################## Inicia Token RedList y Cites
        $RedListToken='V6NT8Woe3ZnPcRZxiALB54eaedAMjkQMjDEV';
        $RedListApi = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $RedListToken, // Or 'Token ' for some APIs
        ])->get('https://api.iucnredlist.org/api/v4/taxa/scientific_name',[
            'genus_name'=>$taxo['genero'],
            'species_name'=>$taxo['especie'],
            'infra_name'=>$taxo['infrasp'],
        ]);
        if ($RedListApi->successful()) {
            #dd('exito',count($RedListApi->json()['assessments']));
            if(count($RedListApi->json()['assessments']) > 0){
                $RedList=[
                    'estatus'=>$RedListApi->status(),
                    'dato'=>$RedListApi->json()['assessments'][0]
                ];
            }else{
                $RedList=[
                    #'estatus'=>$RedListApi->status(),
                    #'dato'=>$RedListApi->body()
                    'estatus'=>'400',
                    'dato'=>''
                ];
            }

        } else {
            #dd('NoExito', $RedListApi->body());
            $RedList=[
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
            'name'=>$taxo['sp'],
            // 'name'=>'Loxodonta africana',
            // 'name'=>'Taxodium mucrunatum'
        ]);

        if ($CitesApi->successful()) {
            $Cites=[
                'estatus'=>$CitesApi->status(),
                'dato'=>$CitesApi->json(),
            ];
        } else {
            $Cites=[
                'estatus'=>$CitesApi->status(),
                'dato'=>[$CitesApi->body()],
            ];
        }
        #dd($CitesApi,$Cites, );
        ############################# Búsqueda de NOM-054-Semarnat

        $Nom054sem=nom054semarnat::where('nom_genero',$taxo['genero'])
            ->where('nom_especie',$taxo['especie'])
            ->get();
        #dd($Nom054sem, $Nom054sem->count());
        // $Nom054sem=nom054semarnat::where('nom_genero','Agave')
        //     ->where('nom_especie','abisaii')
        //     ->get();
        #dd($Nom054sem, $Nom054sem->count());
        ################## Fin de Token de RedList y Cites


        ###### Obtiene todo el texto de la especie, en el idioma y para el jardín seleccionado
        $texto=SpCedulasModel::where('txt_act','1')
            ->where('txt_cedid',$datoUrl->ced_id)
            ->orderBy('txt_order','asc')             #### párrafos ordenados por campo order
            ->get();

        ###### De la selección de textos, extrae los títulos (para construir menú)
        $titulos= $texto->where('txt_titulo','1');

        ##### obtiene las fotos de la cédula
        $fotos=SpFotosModel::where('imgsp_act','1')
            ->where('imgsp_urlurl',$this->url)
            ->where('imgsp_cjarsiglas',$this->jardin)
            ->get();

        #####  Obtiene las lenguas disponibles para esta cédula
        $lenguas = SpUrlCedulaModel::join('cat_lenguas','clen_code','=','ced_clencode')
            ->where('ced_act','1')
            ->where('ced_edo','5')
            ->where('ced_urlurl',$this->url)
            ->where('ced_cjarsiglas',$this->jardin)
            ->get();

        ##### Obtiene datos de los jardín que cuentan con esta misma cédula
        $jardinData=SpUrlCedulaModel::where('ced_urlurl',$this->url)
            ->where('ced_act','1')
            ->where('ced_edo','5')
            ->join('cat_jardines','cjar_siglas','=','ced_cjarsiglas')
            ->distinct('cjar_nombre')
            ->get();

        // ##### Obtiene datos de los clavos del jardín
        // $clavos=['695', '698', '966', '2525'];
        // $herbario=[ '1050', '1099', '1085', '1045', '1398', '1765'];
        // $otrosJardines=['Jardín Comunitario de Matatlán','Parque Primavera'];

        ###### Redirecciona enficha caso de no existir  o url válida
        if(is_null($texto) OR $texto->count() < 1 OR is_null($jardinData) ){
            redirect('/error No URL');
            #dd('No existe la URL');
            die();
        }

        ##### Obtiene datos de versión
        $version=[
            'ced_id'=>$datoUrl->ced_id,
            'cedula'=>$datoUrl->ced_urlurl.'/'.$datoUrl->ced_cjarsiglas.'/'.$datoUrl->ced_clencode,
            'ced_version'=>$datoUrl->ced_version,
            'ced_versiondate'=>$datoUrl->ced_versiondate,
            'ced_cita'=>$datoUrl->ced_cita,
            'ced_doi'=>$datoUrl->ced_doi,
            'ced_nombre'=>SpUrlModel::where('url_url',$this->url)->value('url_nombre'),
            'jardin'=>CatJardinesModel::where('cjar_siglas',$this->jardin)->value('cjar_nombre'),
            'versiones'=>SpUrlCedulaVersionModel::where('cedv_cedid',$datoUrl->ced_id)->select('cedv_id','cedv_cedversion','created_at')->get(),

        ];

        #### Obtiene tabla de aporte de usuarios con estado 5 o estado <5Pero de usr
        $usrAuto='0';
        if(Auth::user()==true){
            $usrAuto = Auth::user()->id;
        }else{
            $usrAuto='0';
        }

        $aportes=SpAporteUsrsModel::where('msg_act','1')
            ->where('msg_cedid',$this->CedId)
            ->where(function($r) use($usrAuto){
                return $r
                ->where('msg_edo', '3')
                ->orWhere(function($q)use($usrAuto){
                    return $q
                    ->where('msg_edo','<','3')
                    ->where('msg_usr',$usrAuto);
                });
            })
        ->get();
        #dd($RedList['estatus'],$RedList['dato'],$taxo);
        return view('livewire.cedulas.especies-component',[
            'taxo'=>$taxo,
            'titulos'=>$titulos,
            'texto'=>$texto,
            'fotos'=>$fotos,
            'lenguas'=>$lenguas,
            'jardinData'=>$jardinData,
            // 'clavos'=>$clavos,
            // 'herbario'=>$herbario,
            // 'otrosJardines'=>$otrosJardines,
            'version'=>$version,
            'aportes'=>$aportes,
            'idioma2'=>CatLenguasModel::where('clen_code',$datoUrl->ced_clencode)->value('clen_lengua'),
            'redList'=>$RedList,
            'cites'=>$Cites,
            'nom054sem'=>$Nom054sem,
        ]);
    }
}
