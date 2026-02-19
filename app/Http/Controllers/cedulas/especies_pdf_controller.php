<?php

namespace App\Http\Controllers\cedulas;

use App\Http\Controllers\Controller;
use App\Models\CatJardinesModel;
use App\Models\CatKewModel;
use App\Models\CatLenguasModel;
use App\Models\SpCedulasModel;
use App\Models\SpFotosModel;
use App\Models\SpUrlCedulaModel;
use App\Models\SpUrlCedulaVersionModel;
use App\Models\SpUrlModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class especies_pdf_controller extends Controller{

    public function index(string $cedID, $tipo){
        ######################################################################
        #################################################### Obtiene variables
        $datoUrl=SpUrlCedulaModel::where('ced_id',$cedID)
            ->join('sp_url','ced_urlurl','=','url_url')
            ->first();

        ##### Obtiene datos taxonómicos principales de la especie
        if($datoUrl->url_reino =='pl'){
            $taxo['id']=$datoUrl->url_sp;
            $taxo['nombrecomun']=$datoUrl->url_nombrecomun;
            $taxo['reino']='Plantae';
            $taxo['familia']=CatKewModel::where('ckew_taxonid',$datoUrl->url_sp)->get()->value('ckew_family');
            $taxo['sp']=CatKewModel::where('ckew_taxonid',$datoUrl->url_sp)->get()->value('ckew_scientfiicname');
            $taxo['autor']=CatKewModel::where('ckew_taxonid',$datoUrl->url_sp)->get()->value('ckew_scientfiicnameautorship');
        }elseif($datoUrl->url_reino =='an'){  #### en tanto no exista catálogo de plantas u hongos....
            $taxo['id']=$datoUrl->url_sp;
            $taxo['nombrecomun']=$datoUrl->url_nombrecomun;
            $taxo['reino']='Animalia';
            $taxo['familia']='';
            $taxo['sp']='';
            $taxo['autor']='';
        }else{
            $taxo['id']='0';
            $taxo['nombrecomun']=$datoUrl->url_nombrecomun;
            $taxo['reino']=$datoUrl->url_reino;
            $taxo['familia']='';
            $taxo['sp']='';
            $taxo['autor']='';
        }

        ##### Obtiene datos de los jardín que cuentan con esta misma cédula
        $jardinData=SpUrlCedulaModel::where('ced_urlurl',$datoUrl->ced_urlurl)
            ->where('ced_act','1')
            ->where('ced_edo','5')
            ->join('cat_jardines','cjar_siglas','=','ced_cjarsiglas')
            ->distinct('cjar_nombre')
            ->get();

        ##### obtiene las fotos de la cédula
        $fotos=SpFotosModel::where('imgsp_act','1')
            ->where('imgsp_urlurl',$datoUrl->ced_urlurl)
            ->where('imgsp_cjarsiglas',$datoUrl->ced_cjarsiglas)
            ->get();

        #####  Obtiene las lenguas disponibles para esta cédula
        $lenguas = SpUrlCedulaModel::join('cat_lenguas','clen_code','=','ced_clencode')
            ->where('ced_id',$datoUrl->ced_id)
            ->get();

        ###### Obtiene todo el texto de la especie, en el idioma y para el jardín seleccionado
        $texto=SpCedulasModel::where('txt_act','1')
            ->where('txt_cedid',$datoUrl->ced_id)
            ->orderBy('txt_order','asc')             #### párrafos ordenados por campo order
            ->get();

        ###### De la selección de textos, extrae los títulos (para construir menú)
        $titulos= $texto->where('txt_titulo','1');

        ##### Obtiene datos de versión
        $version=[
            'ced_id'=>$datoUrl->ced_id,
            'cedula'=>$datoUrl->ced_urlurl.'/'.$datoUrl->ced_cjarsiglas.'/'.$datoUrl->ced_clencode,
            'ced_version'=>$datoUrl->ced_version,
            'ced_versiondate'=>$datoUrl->ced_versiondate,
            'ced_cita'=>$datoUrl->ced_cita,
            'ced_nombre'=>SpUrlModel::where('url_url',$datoUrl->ced_urlurl)->value('url_nombre'),
            'jardin'=>CatJardinesModel::where('cjar_siglas',$datoUrl->ced_cjarsiglas)->value('cjar_nombre'),
        ];

        ######################################################################
        ##################################### Genera gran variable para enviar
        $variables=[
            'jardin'=>$datoUrl->ced_cjarsiglas,
            'url'=>$datoUrl->ced_urlurl,
            'taxo'=>$taxo,
            'titulos'=>$titulos,
            'texto'=>$texto,
            'fotos'=>$fotos,
            'lenguas'=>$lenguas,
            'jardinData'=>$jardinData,
            'version'=>$version,
            'idioma'=>$datoUrl->ced_clencode,
            'idioma2'=>CatLenguasModel::where('clen_code',$datoUrl->ced_clencode)->value('clen_lengua'),
        ];

        ######################################################################
        ########################################################### Genera pdf
        if($tipo=='pdf'){

            $pdf=PDF::LoadView('pdf.especies-pdf-component',$variables);
            return $pdf->stream('CedulaParaImprimir.pdf');

        ######################################################################
        ######################################################### Genera vista
        }elseif($tipo=='b64'){
            ##### Si no hay permiso, lo regresa
            if(!in_array('cedulas',session('rol'))){
                return redirect()->back();
            }

            ##### Crea pdf en Base64
            $pdf=PDF::LoadView('pdf.especies-pdf-component',$variables);
            $pdf64='data:application/pdf;base64,'.base64_encode($pdf->stream());
            ##### Guarda versión en base de datos
            SpUrlCedulaVersionModel::firstOrCreate(['cedv_cedid'=>$cedID,'cedv_cedversion'=>$version['ced_version']],[
                'cedv_cedid'=>$cedID,
                'cedv_cedversion'=>$version['ced_version'],
                'cedv_usr'=>Auth::user()->id,
                'cedv_pdf'=>$pdf64,
            ]);
            return redirect()->back();
        }else{

            return view('pdf.especies-pdf-component',$variables);
        }
    }

    public function store(Request $request){
        //
    }
}
