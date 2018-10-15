<?php

namespace App\Http\Controllers\Nutibara\Contratos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Contratos\AnularContrato;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\BusinessLogic\Nutibara\Contratos\CrudCerrarContrato;
use App\BusinessLogic\Nutibara\Clientes\Empleado\CrudEmpleado;
use App\BusinessLogic\Nutibara\Contratos\CrudContrato;

class AnularController extends Controller
{
    public function index($codigoContrato,$idTiendaContrato,$idRemitente=0)
    {   
		$data = Contrato::getContratoById($codigoContrato,$idTiendaContrato);
		$aplicacion_retroventa = Contrato::aplicacionRetroventa($codigoContrato, $idTiendaContrato);
		$var_menos_porcentaje = (isset($aplicacion_retroventa->menos_porcentaje)) ? $aplicacion_retroventa->menos_porcentaje : 0;
		$var_menos_porcentaje = ($var_menos_porcentaje != null) ? $var_menos_porcentaje : 0;

		$var_menos_meses = (isset($aplicacion_retroventa->menos_meses)) ? $aplicacion_retroventa->menos_meses : 0;
		$var_menos_meses = ($var_menos_meses != null) ? $var_menos_meses : 0;

		$infoActualContrato = Contrato::infoActualContrato($codigoContrato, $idTiendaContrato, $var_menos_porcentaje, $var_menos_meses,0);
		$retroventa_menos = $infoActualContrato[0]->valor_retroventa;
		$descuento_retroventa = ( 0 );
		$contrato=CrudCerrarContrato::getInfoCerrarContrato($codigoContrato,$idTiendaContrato);
		$precio_total = 0;
		$porcentaje_retroventa = $data->porcentaje_retroventa;
		$fecha_terminacion_cabecera = $data->fecha_terminacion;
		$tercero = CrudContrato::getInfoTercero($codigoContrato, $idTiendaContrato);
		$tipo_parentesco = CrudEmpleado::getSelectList('tipo_parentesco');
		$items = Contrato::getItemsContratoById($codigoContrato,$idTiendaContrato);
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
				'href'=>'contrato/index',
				'text'=>'Consulta de contrato'
			],
			[
				'href'=>'contrato/anular/'.$codigoContrato.'/'.$idTiendaContrato,
				'text'=>'Anular contrato'
			]
		);
        $contrato=AnularContrato::getInfoAnular($codigoContrato,$idTiendaContrato);
        return view('Contratos.anular.index',['contrato'=>$contrato,
                                                'idRemitente'=>$idRemitente,
                                                'urls' => $urls,
                                                'id'=>$codigoContrato,
												'id_tienda'=>$idTiendaContrato,
												'precio_total'=>$precio_total,
												'precio_total' => $precio_total,
												'porcentaje_retroventa' => $porcentaje_retroventa,
												'fecha_terminacion_cabecera' => $fecha_terminacion_cabecera,
												'infoActualContrato'=>$infoActualContrato,
												'attribute' => $data,
												'tercero' => $tercero,
												'tipo_parentesco' => $tipo_parentesco,
												'items' => $items,
												'retroventa_menos' => $retroventa_menos,
												'descuento_retroventa' => $descuento_retroventa,
         ]);
    }

    public function SolicitarAnularAction(Request $request)
    {
        $mensaje=AnularContrato::SolicitarAnularAction($request);
		return response()->json(['msm'=>$mensaje]);
    }

    public function AprobarSolicitudAction(Request $request)
    {
		$mensaje=AnularContrato::AprobarSolicitudAction($request);
		dd($mensaje);
		return response()->json(['msm'=>$mensaje]);
    }

    public function RechazarSolicitudAction(Request $request)
    {
        $mensaje=AnularContrato::RechazarSolicitudAction($request);
		return response()->json(['msm'=>$mensaje]);
    }

    public function AnularContratoAction(Request $request)
    {
		$mensaje=AnularContrato::AnularContratoAction($request);
		if($mensaje['val']){
			$datos_especificos = [
				//id de la tienda del contrato
				'numero_1' => $request->idTienda,
				//
				'dato_1' => null,
				//fecha de la anulación
				'fecha_1' => Carbon::now(),

				//código del contrato
				'numero_2' => $request->codigoContrato,
				//
				'dato_2' => null,
				//
				'fecha_2' => null,
				
				//id estado del contrato
				'numero_3' => env('ESTADO_CONTRATO_RESTABLECER'),
				//
				'dato_3' => null,
				//
				'fecha_3' => null,

				'transaccion' => "update",
				'operacion' => "Anular contrato",
				'log' => null,
			];
			CrudContrato::crearAuditoria($datos_especificos);
		}
		return response()->json(['msm'=>$mensaje]);
    }
}
