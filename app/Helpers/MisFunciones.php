<?php

use App\Models\autor_url;
use App\Models\cedulas_url;
use App\Models\historial;
use App\Models\sist_visitas;
use Illuminate\Support\Facades\Auth;
use Safe\url;
use Stevebauman\Location\Facades\Location;



##### Ejecutar: composer dump-autoload


if(! function_exists('MyRegistraVisita')){
    /*##### Cuando se ejecuta en mount(), registra en la base de datos
    ##### sist_visitas, el ingreso de cada visitante a una url.
    ##### Solo requiere que se invoque y que se indique:
    ##### el $moduloVis = ['ced','aut','jar','otro'] indicando tabla cedula_url, autor_url o jardin_url
    ##### el $idVis con el id de la página: url_id, aurl_id o urlj_id (según tabla)
        MyRegistraVisita( ['ced','aut','jar','otro'][0],  $this->url_id,   'MyFlag');
    */
    function MyRegistraVisita($moduloVis, $idVis, $flag) {
        if($moduloVis=='ced'){
            $dato=cedulas_url::where('url_id',$idVis)->first();
            $jardin=$dato->url_cjarsiglas;
            $modulo='cedula';
            $urltxt=$dato->url_urltxt;
            $lengua=$dato->url_lencode;
        }elseif($moduloVis=='aut'){
            $dato=autor_url::where('aurl_id',$idVis)->first();
            $jardin=$dato->aurl_cjarsiglas;
            $modulo='autor';
            $urltxt=$dato->aurl_urltxt;
            $lengua=$dato->aurl_lencode;

        }elseif($moduloVis=='jar'){
            $dato=autor_url::where('aurl_id',$idVis)->first();
            $jardin=$dato->urlj_cjarsiglas;
            $modulo='jardin';
            $urltxt=$dato->urlj_urltxt;
            $lengua=$dato->urlj_lencode;
        }else{
            $jardin=null;
            $modulo=null;
            $urltxt=null;
            $lengua=null;
        }

        ##### Revisa si hay token (no token=primera vez)
        if(session('token') !=''){
            $entrada='0';
        }else{
            $entrada='1';
            session(['token'=>date('Ymd-His_').request()->ip()]);
        }
        ##### Obtiene datos de ip
        $ip=request()->ip();

        $datos=Location::get( $ip );

        if($datos != false){
            $pais=$datos->countryName;
            $region=$datos->regionName;
            $ciudad=$datos->cityName;
            $x=$datos->longitude;
            $y=$datos->latitude;
        }else{
            $pais=null;
            $region=null;
            $ciudad=null;
            $x=null;
            $y=null;
        }

        if (Auth::user()==true){
            $usr=Auth::user()->id;
            if( is_array(session('rol')) ){
                $roles=implode(",",session('rol'));
            }else{
                $roles=null;
            }
        }else{
            $usr=null;
            $roles=null;
        }

        ##### Crea registro por token/url/lenguaLocal (si el usuario cambia una de estas variables, se genera un nuevo registro)
        sist_visitas::firstOrCreate(['vis_url'=>url()->current(),   'vis_tocken'=>session('token')] ,[
            'vis_id'=>sist_visitas::max('vis_id') +1 ,
            'vis_entrada'=>$entrada,

            'vis_jardin'=>$jardin,
            'vis_modulo'=>$modulo,
            'vis_urltxt'=>$urltxt,
            'vis_lengua'=>$lengua,
            'vis_url'=>url()->current(),
            'vis_flag'=>$flag,

            'vis_ip'=>request()->ip(),
            'vis_locale'=>session('locale'),
            'vis_pais'=>$pais,
            'vis_regionName'=>$region,
            'vis_ciudad'=>$ciudad,
            'vis_x'=>$x,
            'vis_y'=>$y,

            'vis_usr'=>$usr,
            'vis_rol'=>$roles,
            'vis_tocken'=>session('token'),
            ]);
    }
}


if(! function_exists('paLog')){
    function paLog($mensaje,$tabla,$tablaId){
        historial::create([
            'log_log'=>$mensaje,
            'log_tabla'=>$tabla,
            'log_tablaid'=>$tablaId,

            'log_usrid'=>Auth::user()->id,
            'log_fecha'=>date('Y-m-d'),
            'log_Hora'=>date('H:i:s'),
        ]);
    }

}

####### Quitar acentos y sustituye ñ por n
if(! function_exists('quitarAcentos')){
    function quitarAcentos ($string) {

        if ( !preg_match('/[\x80-\xff]/', $string) )
            return $string;

        $chars = array(
            // Decompositions for Latin-1 Supplement
            chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
            chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
            chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
            chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
            chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
            chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
            chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
            chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
            chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
            chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
            chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
            chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
            chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
            chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
            chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
            chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
            chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
            chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
            chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
            chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
            chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
            chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
            chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
            chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
            chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
            chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
            chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
            chr(195).chr(191) => 'y',
            // Decompositions for Latin Extended-A
            chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
            chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
            chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
            chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
            chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
            chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
            chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
            chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
            chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
            chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
            chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
            chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
            chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
            chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
            chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
            chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
            chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
            chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
            chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
            chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
            chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
            chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
            chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
            chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
            chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
            chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
            chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
            chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
            chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
            chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
            chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
            chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
            chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
            chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
            chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
            chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
            chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
            chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
            chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
            chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
            chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
            chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
            chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
            chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
            chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
            chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
            chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
            chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
            chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
            chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
            chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
            chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
            chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
            chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
            chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
            chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
            chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
            chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
            chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
            chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
            chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
            chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
            chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
            chr(197).chr(190) => 'z', chr(197).chr(191) => 's',
            // para la ñ:
            chr(195).chr(177) => 'n',chr(195).chr(149) => 'N'
        );

        $string = strtr($string, $chars);

        return $string;
    }
}
