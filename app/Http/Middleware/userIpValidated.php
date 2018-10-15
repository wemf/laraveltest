<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use DB;
use tienda;

class userIpValidated
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

        $canIp=DB::select('CALL buscar_ip_asociadas(?,?)',array(Auth::id(),$this->getRealIP()));
        $canStore=DB::select('CALL validar_estado_tienda(?,?)',array(Auth::id(),$this->getRealIP()));
        if(end($canIp)->isValidatedIp)
        {
            if(end($canStore)->isValidatedStore){
                return $next($request);
            }else{
                Auth::logout();
                $request->session()->invalidate();
                return redirect('/login')->with(['error'=>'La tienda ya se encuentra cerrada.']);
            }
            
        }else{
            Auth::logout();
            $request->session()->invalidate();
            return redirect('/login')->with(['error'=>'Esta ubicación no está permitida, contacte a su administrador para registrar la ubicación de la tienda.']);
        }
        
    }

    public function getRealIP()
    {   
        return tienda::GetRealIP(); 
    }
}
