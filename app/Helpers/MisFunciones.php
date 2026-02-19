<?php

use App\Models\SistVisitasModel;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;

##### Ejecutar: composer dump-autoload


if(! function_exists('MyRegistraVisita')){
    ##### registra la visita de un usuario
    ##### en la base de datos. Se ejecuta desde back.
    function MyRegistraVisita($url2) {
        ##### Prepara variable
        if(is_array($url2)){
            $url3=$url2[1];
            $url2=$url2[0];
        }else{
            $url3=null;
        }
        ##### Revisa si hay token (no token=primera vez)
        if(session('token') !=''){
            $unico='0';
        }else{
            $unico='1';
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
        #dd(session('rol'), is_array(session('rol')), is_null(session('rol')));
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
        SistVisitasModel::firstOrCreate(['vis_url'=>url()->current(),   'vis_tocken'=>session('token'), 'vis_locale2'=>session('locale2')] ,[
            'vis_id'=>SistVisitasModel::max('vis_id') +1 ,
            'vis_unique'=>$unico,
            'vis_ip'=>request()->ip(),
            'vis_url'=>url()->current(),
            'vis_url2'=>$url2,
            'vis_url3'=>$url3,
            'vis_locale'=>session('locale'),
            'vis_locale2'=>session('locale2'),
            'vis_tocken'=>session('token'),
            'vis_pais'=>$pais,
            'vis_regionName'=>$region,
            'vis_ciudad'=>$ciudad,
            'vis_x'=>$x,
            'vis_y'=>$y,
            'vis_usr'=>$usr,
            'vis_rol'=>$roles,
        ]);
    }
}
