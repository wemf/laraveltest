<?php

namespace App\Http\Controllers\Autenticacion;

use App\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Mail;
use App\Mail\verifyEmail;
use Session;
use App\AccessObject\Nutibara\Clientes\Empleado\Empleado;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/users';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('usuario');
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('usuario');
    }
    
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('autenticacion.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

     /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register2(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->createVerifyToken($request->all());
        if($user!=false){
            event(new Registered($user));
            return redirect(route('login'));
        }else{
            return redirect()->back();            
        }
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        if($user['state']!=false){
            event(new Registered($user['user']));
            return redirect('/users')->with($user['msm']);
        }else{
            return redirect()->back()->with($user['msm']);          
        }
    }

    public function registerAjax(Request $request)
    {   
        // dd($request->all());
        $user = $this->create($request->all());
        if($user['state']!=false){
            event(new Registered($user['user']));
            $user['msm']=$user['msm']['message'];
            $id = Empleado::updateClientUser($request->codigo_cliente,$request->id_tienda,$user['user']->id,$request->email);
        }else{
            $user['msm']=$user['msm']['error'];
        }
        $a=array(
            'msm'=>$user['msm'],
            'val'=>$user['state']
         );
         return response()->json(['msm'=>$a]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $response=array(
            'msm'=>array(),
            'state'=>true,
            'user'=>array()
        );
        $pass=(isset($data['password']))?$data['password']:(Str::random(40));
        $isUser=Usuario::where(['email'=>$data['email'],'estado'=>1])->count();
        if($isUser==0){
            $msm=ucwords(strtolower($data['name'])).' Registrado correctamente!'.' con el Email: '.strtolower($data['email']);
            $response['msm']=['message'=>$msm];
            $response['user']= Usuario::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($pass),
                'modo_ingreso' => $data['modo_ingreso'],
                'id_role'=>$data['id_role'],
                'estado'=>1
            ]);
        }else{
            $msm='Hola '.ucwords(strtolower($data['name'])).' el email: '.strtolower($data['email'].' ya se encuentra en uso.');            
            $response['msm']=['error'=>$msm];
            $response['state']=false;
        }
        return $response;
    }

    protected function createVerifyToken(array $data)
    {
        $isUser=Usuario::where(['email'=>$data['email'],'estado'=>1])->count();
        if($isUser==0){
            $msm=ucwords(strtolower($data['name'])).' Registrado!'.' para activar la cuenta se a enviado un link de activación al email: '.strtolower($data['email']);
            Session::flash('status',$msm);
            $user= Usuario::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'verify_token'=>Str::random(40),
                'id_role'=>$data['id_role']                
            ]);
            $thisUser=Usuario::findOrFail($user->id);
            $this->sendEmail($thisUser);
            return $user;
        }else{
            $msm='Hola '.ucwords(strtolower($data['name'])).' el email: '.strtolower($data['email'].' ya se encuentra en uso.');            
            Session::flash('status',$msm);            
            return false;
        }
    }

    public function sendEmail($thisUser)
    {
        Mail::to($thisUser['email'])->send(new verifyEmail($thisUser));
    }

    public function verifyEmailFirst()
    {
        return view('email.verifyEmailFirst');
    }

    public function sendEmailDone($email,$verifyToken)
    {
        $isUser=Usuario::where(['email'=>$email,'verify_token'=>$verifyToken])->count();        
        if($isUser>0){
            $isValided=Usuario::where(['email'=>$email,'verify_token'=>$verifyToken])->update(['estado'=>1,'verify_token'=>NULL]);
            if($isValided){
                Session::flash('status','Cuenta activada! Inicie sesion.');
            }else{
                Session::flash('status','Cuenta no activada!.');
            } 
        }else{
            Session::flash('status','URL caducada.');
        }
        return redirect(route('login'));
    }
}
 