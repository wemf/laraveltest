<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
//Route::group(['middleware'=>['auth:api','userIpValidated']],function(){
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('profile', 'Api\AuthController@profile');
    //Modulo de Inicio de sesion de Empleado
    Route::post('validate/user', 'Api\AuthController@validateUser');
    Route::post('user/create/huella', 'Api\AuthController@createHuella');
    Route::post('who/user', 'Api\AuthController@WhoIsUser');
    Route::get('clientes/tipodocumento/get', 'Nutibara\Clientes\TipoDocumento\TipoDocumentoController@getSelectList2');
    //Modulo de Cotractos
    Route::get('clientes/tipodocumento/get/by/contrato', 'Api\AuthController@getTipoDocumentoByContrato');
    Route::post('who/user/by/contrato', 'Api\AuthController@WhoIsUserByHuellaByContracto');
    Route::post('validate/user/by/contrato', 'Api\AuthController@ValidateIsUserByHuellaByContracto');
    Route::post('user/create/huella/by/contrato', 'Api\AuthController@createHuellaByContrato');
});