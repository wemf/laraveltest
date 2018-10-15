<?php

namespace App\Http\Controllers\Autenticacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Usuario;
use App\Mail\validateToken as EmailValidateToken;
use Mail;
use Illuminate\Support\Str;
use DateTime;

class TokenValidatorController extends Controller
{
    public function view()
    {        
        return view('autenticacion.administrator.genetateToken');
    }

    public function LoginToken($email,$verifyToken)
    {
        $user=$this->ValidateToken($email,$verifyToken);
        Auth::login($user);
        return redirect('/home');
    }

    public function GenerateToken($id)
    {
        Usuario::where('id',(int)$id)->update(['verify_token'=>Str::random(40)]);
        $thisUser=Usuario::findOrFail($id);
        $this->sendEmail($thisUser); 
        return redirect()->back()->with(['message'=>'Se generado el link  de inicio de sesión y enviado al correo.']);     
    }

    private function ValidateToken($email,$verifyToken)
    {
        $user=Usuario::where('email',$email)->where('estado',1)->first();
        $fechaDB=$user->updated_at;
        $tokenDB=$user->verify_token;
        if($verifyToken==$tokenDB){
            $date1 = new DateTime();
            $date2 = new DateTime($fechaDB);
            $interval = $date1->diff($date2);
            if($interval->y==0 && $interval->m==0 && $interval->d==0 && $interval->h==0 && $interval->i<16){
                Usuario::where('id',$user->id)->update(['verify_token'=>'']);
                $thisUser=Usuario::findOrFail($user->id);
                return $thisUser;
            }else{
                die('Error: Este Link caduco.');
            }
        }else{
            die('Error: Token invalido.');
        }

    }

    private function sendEmail($thisUser)
    {
        Mail::to($thisUser['email'])->send(new EmailValidateToken($thisUser));
    }
}
