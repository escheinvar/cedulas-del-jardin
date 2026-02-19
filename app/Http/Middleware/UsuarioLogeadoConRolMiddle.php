<?php

namespace App\Http\Middleware;

use App\Models\CatJardinesModel;
use App\Models\SistBuzonMensajesModel;
use App\Models\SpAporteUsrsModel;
use App\Models\UserRolesModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UsuarioLogeadoConRolMiddle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response{

        if(Auth::user()) {
            $roles=UserRolesModel::where('rol_act','1')->where('rol_usrid',Auth::id())->pluck('rol_crolrol')->toArray();

            ######################### Revisa buzón y aportaciones
            ##### Recupera el número de mensajes sin leer
            $buzon= SistBuzonMensajesModel::where('buz_act','1')
                ->where(function($q){
                    return $q
                    ->where('buz_destino_usr',Auth::id())
                    ->orWhereIn('buz_destino_rol',session('rol'));
                })
                ->where('buz_leido','0')
                ->count();


            if(in_array('cedulas',$roles)){
                $jards=UserRolesModel::where('rol_act','1')
                    ->where('rol_usrid',Auth::user()->id)
                    ->where('rol_crolrol','cedulas')
                    ->pluck('rol_tipo1')
                    ->toArray();
                if(in_array('todas',$jards)){
                    $jards=CatJardinesModel::pluck('cjar_siglas')->toArray();
                }

                ##### Recupera cantidad de aportaciones PENDIENTES DE APROBAR
                $aportes=SpAporteUsrsModel::leftJoin('sp_urlcedula','ced_id','=','msg_cedid')
                    ->where('msg_act','1')
                    ->where('msg_edo','0')
                    ->whereIn('ced_cjarsiglas',$jards)
                    ->count();
            }else{
                $aportes='0';
            }

            ##### Guarda variables de usuario,
            session([
                'rol'=>$roles,
                'buzon'=>$buzon,
                'aportes'=>$aportes,
            ]);
            return $next($request);
        }else{
            #### Redirecciona
            Auth::logout();
            return redirect()->route('login');
        }

    }
}
