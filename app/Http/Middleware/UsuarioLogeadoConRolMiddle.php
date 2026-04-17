<?php

namespace App\Http\Middleware;

use App\Models\buzon;
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
            $roles=UserRolesModel::where('rol_act','1')
                ->where('rol_del','0')
                ->where('rol_usrid',Auth::user()->id)
                ->pluck('rol_crolrol')
                ->toArray();

            ##### Recupera el número de mensajes sin leer
            $buzon= buzon::where('buz_del','0')
                ->where('buz_act','1')
                ->where('buz_to',Auth::user()->id)
                ->count();


            if(in_array('cedulas',$roles)){
                $jards=UserRolesModel::where('rol_act','1')->where('rol_del','0')
                    ->where('rol_usrid',Auth::user()->id)
                    ->where('rol_crolrol','cedulas')
                    ->pluck('rol_tipo1')
                    ->toArray();
                if(in_array('todas',$jards)){
                    $jards=CatJardinesModel::pluck('cjar_siglas')->toArray();
                }
            }

            ##### Guarda variables de usuario,
            session([
                'rol'=>$roles,
                'buzon'=>$buzon,
            ]);

            ##### Define session de jardin
            if($request->session()->has('jardin')){}else{session(['jardin'=>'a']);}

            return $next($request);
        }else{
            #### Redirecciona
            Auth::logout();
            return redirect()->route('login');
        }

    }
}
