<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Usuario;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\BusinessLogic\Autenticacion\AutenticacionBL;
use App\Http\Requests\User\UserValidateHuella;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 422);
        }

        $input = $request->all();
        $input['password'] = bcrypt($request->get('password'));
        $user = User::create($input);
        $token =  $user->createToken('MyApp')->accessToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token =  $user->createToken('MyApp')->accessToken;
            return response()->json([
                'token' => $token,
                'user' => $user
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function profile()
    {
        $user = Auth::user();
        return response()->json(compact('user'), 200);
    }

    public function validateUser(UserValidateHuella $request)
    {
        /*
        401 Unauthorized
        Similar al 403 Forbidden, pero específicamente para su uso cuando la autentificación es posible pero ha fallado o aún no ha sido provista. 
        */
        $user=AutenticacionBL::validateUser($request);
        if($user!=false)
            return response()->json($user, 200);
        else
            return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function WhoIsUser(UserValidateHuella $request)
    {
        $user=AutenticacionBL::WhoIsUser($request);
        if($user!=false)
            return response()->json($user, 200);
        else
            return response()->json(['error' => 'Unauthorized'], 401);
    }
    public function createHuella(UserValidateHuella $request)
    {
        $user=AutenticacionBL::createHuella($request);
        if($user!=false)
            return response()->json($user, 200);
        else
            return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function getTipoDocumentoByContrato()
	{
		$response = AutenticacionBL::getTipoDocumentoByContrato();
		return  response()->json($response);
    }
    
    public function WhoIsUserByHuellaByContracto(UserValidateHuella $request)
	{
		$user = AutenticacionBL::WhoIsUserByHuellaByContracto($request);
        if($user!=false)
            return response()->json($user, 200);
        else
            return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function ValidateIsUserByHuellaByContracto(UserValidateHuella $request)
	{
		$user = AutenticacionBL::ValidateIsUserByHuellaByContracto($request);
        return response()->json($user, 200);
    }

    public function createHuellaByContrato(UserValidateHuella $request)
    {
        $user=AutenticacionBL::createHuellaByContrato($request);
        return response()->json($user, 200);
    }
}
