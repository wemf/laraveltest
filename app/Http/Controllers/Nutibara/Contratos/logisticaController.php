<?php

namespace App\Http\Controllers\Nutibara\Contratos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Contratos\logisticaContrato;
use App\AccessObject\Nutibara\Contratos\Logistica as ModelLogistica;
use App\AccessObject\Nutibara\Tienda\Tienda as ModelTienda;
use App\AccessObject\Nutibara\Pais\Pais as ModelPais;
use Illuminate\Support\Facades\Session;
use App\Http\Middleware\userIpValidated;
use Mail;

class logisticaController extends Controller
{
    
    public function logistica()
    {
        $tiendas = ModelTienda::getSelectList();
        $urls=array(
            [
                'href'=>'home',
                'text'=>'home'
            ],
            [
                'href'=>'contrato/index',
                'text'=>'Gestión de contrato'
            ],
            [
                'href'=>'contrato/logistica',
                'text'=>'Logistica'
            ]
        );
        return view('Contratos.logistica',['urls'=>$urls,'tiendas' => $tiendas]);
    }

    public function get(Request $request)
    {
        return logisticaContrato::get($request);
    }

    public function create()
    {
        $tiendaPrincipal = logisticaContrato::getSelectListPrincipal();
        $pais =  ModelPais::getSelectList();
        $ipValidation = new userIpValidated();
		$tienda = logisticaContrato::getTiendaByIp($ipValidation->getRealIP());
        $urls=array(
            [
                'href'=>'home',
                'text'=>'home'
            ],
            [
                'href'=>'contrato/index',
                'text'=>'Gestión de contrato'
            ],
            [
                'href'=>'contrato/logistica',
                'text'=>'Logistica'
            ],
            [
                'href'=>'contrato/logistica/create',
                'text'=>'Crear guía'
            ]
        );
        return view('Contratos.crearGuia',['urls'=>$urls,'tienda'=>$tienda,'tiendaPrincipal'=>$tiendaPrincipal,'pais'=>$pais]);
    }

    public function seguimiento(request $request)
    {
        $id = $request->id;
        $resoluciones = ModelLogistica::getResolucionesByIdResolucion($id);
        $guia = ModelLogistica::getGuiaSeguimiento($id);
        $urls=array(
            [
                'href'=>'home',
                'text'=>'home'
            ],
            [
                'href'=>'contrato/index',
                'text'=>'Gestión de contrato'
            ],
            [
                'href'=>'contrato/logistica',
                'text'=>'Logistica'
            ],
            [
                'href'=>'contrato/logistica/seguimiento/'.$id,
                'text'=>'Seguimiento guía'
            ]
        );
        return view('Contratos.seguimiento',['urls'=>$urls,'resoluciones' => $resoluciones,'guia'=>$guia]);
    }

    public function trazabilidad(request $request)
    {
        $id = $request->id;
        $traza = logisticaContrato::getTrazabilidad($id);
        $urls=array(
            [
                'href'=>'home',
                'text'=>'home'
            ],
            [
                'href'=>'contrato/index',
                'text'=>'Gestión de contrato'
            ],
            [
                'href'=>'contrato/logistica',
                'text'=>'Logistica'
            ],
            [
                'href'=>'contrato/logistica/trazabilidad/'.$id,
                'text'=>'Trazabilidad guía'
            ]
        );
        return view('Contratos.trazabilidad',['urls'=>$urls,'traza'=>$traza]);
    }

    public function anular(request $request)
    {
        $id = $request->id;
        $resoluciones = ModelLogistica::getResolucionesByIdResolucion($id);
        $guia = ModelLogistica::getGuiaSeguimiento($id);
        $urls=array(
            [
                'href'=>'home',
                'text'=>'home'
            ],
            [
                'href'=>'contrato/index',
                'text'=>'Gestión de contrato'
            ],
            [
                'href'=>'contrato/logistica',
                'text'=>'Logistica'
            ],
            [
                'href'=>'contrato/logistica/anular/'.$id,
                'text'=>'Anular guía'
            ]
        );
        return view('Contratos.anularGuia',['urls'=>$urls,'resoluciones' => $resoluciones,'guia'=>$guia]);
    }

    public function getResolucionesById(request $request)
    {
        $id = $request->id;
        $response = logisticaContrato::getResolucionesById($id);
        return response()->json($response);
    }

    public function getSedePrincipal(request $request)
    {
        $id = $request->id;
        $response = logisticaContrato::getSedePrincipal($id);
        return response()->json($response);
    }

    public function createPost(request $request)
    {
        $msm = logisticaContrato::createPost($request);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
        return response()->json($msm);
    }

    public function prueba()
    {
        return $msm = logisticaContrato::createPost($request=null);
    }
    public function getEmpleadosTienda(request $request)
    {
        $id = $request->id;
        $response = logisticaContrato::getEmpleadosTienda($id);
        return response()->json($response);
    }

    public function getSelectListByTipe(request $request)
    {
        $tipe = $request->tipe;
        $city = $request->city;
        $id_tienda = $request->id_tienda;
        $response = logisticaContrato::getSelectListByTipe($tipe,$city,$id_tienda);
        return response()->json($response);
    }

    public function anularGuia(request $request)
    {   
        $id = $request->id;
        $msm = logisticaContrato::anularGuia($request,$id);
        if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
        return response()->json($msm);
    }

    public function seguimientoGuia(request $request)
    {   
        $id = $request->id;
        $msm = logisticaContrato::seguimientoGuia($request,$id);
        if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
        return response()->json($msm);
    }
}







?>