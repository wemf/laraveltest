<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class isFuncionalidad
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $funcion)
    {
        if(Auth::user()->inFuncionalidad($funcion)){
            return $next($request);//Tiene permisos sobre la funcion A;
        }       
       return redirect('/home')->with('error','No tiene permiso para acceder a la funcionalidad solicitada.');
    }
}
