<?php

namespace App\Http\Middleware;

use App\Models\cedulas_url;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerificaUrlCedula
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        ##### Obtiene el id de cédula que viene en la URL
        $cedJardin=$request->route()->parameter('jardin');
        $cedUrl=$request->route()->parameter('url');

        $ced=cedulas_url::whereRaw('LOWER(url_cjarsiglas) = ?',strtolower($cedJardin))
            ->where('url_url',$cedUrl)
            ->count();

        if($ced != '1'){
            return redirect('/errorNo existe la dirección indicada');
        }

        return $next($request);
    }
}
