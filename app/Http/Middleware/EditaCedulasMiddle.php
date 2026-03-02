<?php

namespace App\Http\Middleware;

use App\Models\CatJardinesModel;
use App\Models\SpUrlCedulaModel;
use App\Models\UserRolesModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EditaCedulasMiddle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        ###################################################
        ###### Determina permisos. Atn: esta página puede tener permisos por 2 vías:
        ###### admin le brinda privilegios de edición sobre uno o más jardines
        ###### traduce le brinda privilegios (solo de edición de texto) a un jardín y una lengua
        ###################################################

        ##### Obtiene el id de cédula que viene en la URL
        $cedID=$request->route()->parameter('cedID');

        ##### Obtiene array de jardines que tiene autorizado
        $JardinesQueEdita=UserRolesModel::where('rol_act','1')
            ->where('rol_usrid',Auth::id())
            ->where('rol_crolrol','cedulas')
            ->pluck('rol_tipo1')
            ->toArray();
        if(in_array('todas',$JardinesQueEdita)){
            $JardinesQueEdita=CatJardinesModel::pluck('cjar_siglas')->toArray();
        }

        ##### Obtiene array de lenguas por jardín a los que tiene permiso el traductor
        $LenguasQueTraduce=UserRolesModel::where('rol_act','1')
            ->where('rol_usrid',Auth::id())
            ->where('rol_crolrol','traduce')
            ->select('rol_tipo1','rol_tipo2')
            ->get();

        ##### Obtiene jardín al que pertenece la cédula
        $JardinDeCedula=SpUrlCedulaModel::where('ced_id',$cedID)
            ->value('ced_cjarsiglas');

        ##### Obtiene lengua en la que está la cédula
        $LenguaDeCedula=SpUrlCedulaModel::where('ced_id',$cedID)
            ->value('ced_clencode');

        ##### Obtiene el estado de la cédula
        $EstadoDeCedula=SpUrlCedulaModel::where('ced_id',$cedID)->value('ced_edo');

        ##### Revisa si otorga permiso de editor
        if( (in_Array('cedulas',session('rol')) AND (in_array($JardinDeCedula,$JardinesQueEdita) OR in_array('todas',$JardinesQueEdita) ) ) ){
            $cedulas='1';
        }else{
            $cedulas='0';
        }
#dd('no auto',$cedID,$LenguasQueTraduce,$JardinDeCedula, $LenguaDeCedula, $EstadoDeCedula);
        ##### Revisa si otorga permiso de traductor
        if(in_array('traduce',session('rol'))  AND $LenguasQueTraduce->where('rol_tipo1', $JardinDeCedula)->where('rol_tipo2',$LenguaDeCedula)->count() > 0   ){
            $traductor='1';

        }else{
            $traductor='0';
        }



        if(
            ($cedulas=='0' AND $traductor == '0') OR
            ($cedulas=='0' AND $traductor=='1' AND in_array($EstadoDeCedula, ['2','4']) )
        ){
            return redirect('/error No estás autorizado a este recurso');
        }


        return $next($request);
    }
}
