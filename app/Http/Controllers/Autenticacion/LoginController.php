<?php

namespace App\Http\Controllers\Autenticacion;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Middleware\userIpValidated;
use App\AccessObject\Nutibara\Tienda\Tienda AS TiendaDB;
use App\AccessObject\Nutibara\Clientes\TipoDocumento\TipoDocumento;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');        
    }

     /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $tipoDocumento=TipoDocumento::getTipoDocumento();
        return view('autenticacion.loginHuella',['tipoDocumentos'=>$tipoDocumento]);
    }

    public function showLoginFormAdmin()
    {
        return view('autenticacion.login');
    }

     /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return ['email'=>$request->{$this->username()},'password'=>$request->password,'estado'=>1];        
    }

     /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Cache::forget('user-online-' .Auth::user()->id);
        $this->guard()->logout();
        $request->session()->invalidate();

        return redirect('/login');
    }
}
