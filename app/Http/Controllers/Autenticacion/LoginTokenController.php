<?php

namespace App\Http\Controllers\Autenticacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Usuario;
use App\Mail\generateToken as EmailValidateToken;
use Mail;
use Illuminate\Support\Str;
use DateTime;
use App\AccessObject\Autenticacion\LoginAO;


class LoginTokenController extends Controller
{
  
    public function LoginToken(Request $request)
    {
        $user=$this->ValidateToken($request->token);
        if($user=='caduco'){
            return redirect()->back()->with(['error'=>'Error de autenticación, Token caduco.']);
        }        
        if($user=='invalido'){
            return redirect()->back()->with(['error'=>'Error de autenticación, Token invalido.']);
        }
        if($user==false){
            return redirect()->back()->with(['error'=>'Error de autenticación, credenciales inválidas.']);
        }        
        Auth::login($user);
        return redirect('/home');
    }

    public function GenerateToken(Request $request)
    {
        $user=LoginAO::WhoIsUser($request->tipoDocumento,$request->documento);
        if(count($user)>0){
            if(Usuario::where('id',$user->id)->where('modo_ingreso',1)->count()==1){
                Usuario::where('id',$user->id)->update(['verify_token'=>Str::random(8)]);
                $thisUser=Usuario::findOrFail($user->id);
                if(count($thisUser)>0){
                    $this->sendEmail($thisUser); 
                    return redirect()->back()->with(['success'=>'Se ha generado el Token y enviado al correo: '.$thisUser->email]);  
                }
            }else{
                return redirect()->back()->with(['error'=>'El usuario no está autorizado para ingresar por este medio. Contacte a su administrador y solicite que le cambie el modo de ingreso.']);
            }
        }
        return redirect()->back()->with(['error'=>'Error de autenticación, credenciales inválidas.']);
    }

    private function ValidateToken($token)
    {
        $estado=false;
        $user=Usuario::where('verify_token',$token)->where('estado',1)->first();
        if(count($user)>0){
            $fechaDB=$user->updated_at;
            $date1 = new DateTime();
            $date2 = new DateTime($fechaDB);
            $interval = $date1->diff($date2);
            if($interval->y==0 && $interval->m==0 && $interval->d==0 && $interval->h==0 && $interval->i<16){
                Usuario::where('id',$user->id)->update(['verify_token'=>'']);
                $thisUser=Usuario::findOrFail($user->id);
                if(count($thisUser)>0){
                    return $thisUser;
                }                
            }else{
                $estado='caduco';
            }
        }else{
            $estado='invalido';
        }
        return $estado;
    }

    private function sendEmail($thisUser)
    {
        Mail::to($thisUser['email'])->send(new EmailValidateToken($thisUser));
    }
}
