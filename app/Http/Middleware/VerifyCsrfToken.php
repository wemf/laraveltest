<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Illuminate\Support\Facades\Auth;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];

    protected function tokensMatch($request)
    {
        $token = $this->getTokenFromRequest($request);
        $match = hash_equals($request->session()->token(), $token);
        if($match && Auth::check())
        {
            return is_string($request->session()->token()) && is_string($token) &&  hash_equals($request->session()->token(), $token);
        }
        else
        {
          if(!Auth::check())
          {
                Auth::logout();
                return redirect('/login');
          }
          else
          {
              return redirect()->back()->with(['error'=>'La aplicación ha estado inactiva por un largo tiempo.\nPor favor, recargue la página.(CTRL + F5)']); 
          }          
        }

    }
}
