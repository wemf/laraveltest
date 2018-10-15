<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Middleware\userIpValidated;

class stateStoreValidated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {     
        $ip = new userIpValidated();
        $canIp=DB::select('CALL validar_estado_tienda(?,?)',array(Auth::id(),$ip->getRealIP()));
        if(end($canIp)->isValidatedStore)
        {
            return $next($request);
        }else{
            Auth::logout();
            $request->session()->invalidate();
            return redirect('/login')->with(['error'=>'Esta ubicación no está permitida, contacte a su administrador para registrar la ubicación de la tienda.']);
        }
        
    }
}
