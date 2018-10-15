<?php 

namespace App\BusinessLogic\Autenticacion;
use App\AccessObject\Autenticacion\LoginAO;
use App\Usuario;
use Illuminate\Support\Str;

class AutenticacionBL 
{   
    /*Genera Token del Login */
	public static function validateUser($request)
    {
        $user=LoginAO::WhoIsUserByHuella($request->tipoDocumento,$request->documento);
        if(count($user)>0){
            $verifyToken=Str::random(100);
            if(Usuario::where('id',$user->id)->update(['verify_token'=>$verifyToken])){
                $user->verify_token=$verifyToken;
                return $user;
            }               
        }
        return false;
    }
    public static function createHuella($request)
    {
        $response=false;
        $userHuellaEntity=LoginAO::WhoIsClient($request->tipoDocumento,$request->documento)->toArray();
        if(count($userHuellaEntity)>0){
            $userHuellaEntity['huella']=$request->huella;
            if(LoginAO::IsHuella($userHuellaEntity)==0){
                if(LoginAO::CreateHuella($userHuellaEntity))
                    $response=true;
            }
        }
        return $response;
    }
    public static function WhoIsUser($request)
    {
        $response=array(
            "id"=>null,
            "name"=>null,
            "email"=>null,
            "updated_at"=>null,
            "verify_token"=>null,
            "isHuella"=>null,
            "state"=>false
        );
        $userHuellaEntity=LoginAO::WhoIsUser($request->tipoDocumento,$request->documento);
        if(count($userHuellaEntity)>0){
            $response=$userHuellaEntity->toArray();
            $response["state"]=true;
        }
        return $response;
    }

    public static function getTipoDocumentoByContrato()
	{
		return LoginAO::getTipoDocumentoByContrato();
    }
    
    public static function WhoIsUserByHuellaByContracto($request)
	{
        $response=LoginAO::WhoIsUserByHuellaByContracto($request->tipoDocumento,$request->documento);
        if(count($response)==0)
            $response=false;
        return $response;
    }
    
    public static function ValidateIsUserByHuellaByContracto($request)
	{
        $response=LoginAO::ValidateIsUserByHuellaByContracto($request->tipoDocumento,$request->documento);
        if($response==0){
            $userHuellaEntity=LoginAO::WhoIsClientByContrato($request->tipoDocumento,$request->documento);
            if(empty($userHuellaEntity) || $userHuellaEntity->esta_procesado===0)
                $response=["msm"=>"El cliente no existe","state"=>true];//No existe el cliente
            else
                $response=["state"=>false,"msm"=>"El cliente tiene una huella registrada en el sistema.\nPara actualizar la huella dactilar contacte su administrador, para que habilite el proceso."];
        }
        else
            $response=["msm"=>"El cliente existe","state"=>false];;//Existe el cliente
        return $response;
    }

    public static function createHuellaByContrato($request)
    {
        $response=["state"=>false,"msm"=>"Fallo el guardo de la huella"];
        $userHuellaEntity=LoginAO::WhoIsClientByContrato($request->tipoDocumento,$request->documento);
        if(count($userHuellaEntity)>0){
            $userHuellaEntity->huella=$request->huella;
            $userHuellaEntity->fecha=date("Y-m-d H:i:s");
            $userHuellaEntity->esta_procesado=0;
            //actualizo
            if(LoginAO::updateHuellaByContrato((array)$userHuellaEntity)){
                $response=["state"=>true,"msm"=>"Se actualizo la huella"];
            }
        }else{
            //inserto
            $client=LoginAO::ValidateClient($request->tipoDocumento,$request->documento);
            if(count($client)>0){
                $userHuellaEntity=array(
                    "id_tienda"=>$client->id_tienda,
                    "id_cliente"=>$client->id_cliente,
                    "updated_at"=>date("Y-m-d H:i:s"),
                    "huella"=>$request->huella
                );
                if(LoginAO::CreateHuella($userHuellaEntity)){
                    $response=["state"=>true,"msm"=>"Se guardo la huella"];
                }
            }else{
                $userHuellaEntity=array(
                    "id_tipo_documento"=>$request->tipoDocumento,
                    "documento"=>$request->documento,
                    "fecha"=>date("Y-m-d H:i:s"),
                    "esta_procesado"=>0,
                    "huella"=>$request->huella
                );
                if(LoginAO::createHuellaByContrato($userHuellaEntity)){
                    $response=["state"=>true,"msm"=>"Se guardo la huella"];
                }
            }            
        }
        return $response;
    }
}