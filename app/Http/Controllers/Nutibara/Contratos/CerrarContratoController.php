<?php

namespace App\Http\Controllers\Nutibara\Contratos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Contratos\CrudCerrarContrato;
use Illuminate\Support\Facades\Session;
use App\BusinessLogic\FileManager\FileManagerSingle;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\BusinessLogic\Nutibara\Clientes\Empleado\CrudEmpleado;
use App\BusinessLogic\Nutibara\Contratos\CrudContrato;
use Carbon\Carbon;

class CerrarContratoController extends Controller
{
    public function index($codigoContrato,$idTiendaContrato,$idRemitente = 0)
    {	
		$data = Contrato::getContratoById($codigoContrato,$idTiendaContrato);
		$items = Contrato::getItemsContratoById($codigoContrato,$idTiendaContrato);
		$contrato=CrudCerrarContrato::getInfoCerrarContrato($codigoContrato,$idTiendaContrato);
		$aplicacion_retroventa = Contrato::aplicacionRetroventa($codigoContrato, $idTiendaContrato);

		$var_menos_porcentaje = (isset($aplicacion_retroventa->menos_porcentaje)) ? $aplicacion_retroventa->menos_porcentaje : 0;
		$var_menos_porcentaje = ($var_menos_porcentaje != null) ? $var_menos_porcentaje : 0;

		$var_menos_meses = (isset($aplicacion_retroventa->menos_meses)) ? $aplicacion_retroventa->menos_meses : 0;
		$var_menos_meses = ($var_menos_meses != null) ? $var_menos_meses : 0;

		$infoActualContrato = Contrato::infoActualContrato($codigoContrato, $idTiendaContrato, $var_menos_porcentaje, $var_menos_meses);
		$retroventa_menos = ( $infoActualContrato[0]->valor_retroventa_menos_porcentaje < $infoActualContrato[0]->valor_retroventa_menos_meses ) ? $infoActualContrato[0]->valor_retroventa_menos_porcentaje : $infoActualContrato[0]->valor_retroventa_menos_meses;
		$descuento_retroventa = ( $infoActualContrato[0]->valor_retroventa - $retroventa_menos );
		$precio_total = 0;
		$porcentaje_retroventa = $data->porcentaje_retroventa;
		$fecha_terminacion_cabecera = $data->fecha_terminacion;
		$tercero = CrudContrato::getInfoTercero($codigoContrato, $idTiendaContrato);
		$tipo_parentesco = CrudEmpleado::getSelectList('tipo_parentesco');
        $urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/index',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'contrato/index',
				'text'=>'Gestionar Contratos'
			],
			[
				'href' => 'contrato/cerrarcontrato/'.$codigoContrato.'/'.$idTiendaContrato,
				'text' => 'Cerrar Contrato'
			],
		);
		return view('Contratos.cerrarcontrato',['contrato'=>$contrato,
												'urls'=>$urls,
												'idRemitente'=>$idRemitente,
												'id'=>$codigoContrato,
												'id_tienda'=>$idTiendaContrato,
												'precio_total'=>$precio_total,
												'precio_total' => $precio_total,
												'porcentaje_retroventa' => $porcentaje_retroventa,
												'fecha_terminacion_cabecera' => $fecha_terminacion_cabecera,
												'infoActualContrato'=>$infoActualContrato,
												'attribute' => $data,
												'tipo_parentesco' => $tipo_parentesco,
												'tercero' => $tercero,
												'items' => $items,
												'retroventa_menos' => $retroventa_menos,
												'descuento_retroventa' => $descuento_retroventa,
		]);
    }

    public function CerrarUpdate(request $request)
	{	
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/index',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'contrato/index',
				'text'=>'Gestionar Contratos'
			],
		);
		$msm=CrudCerrarContrato::CerrarUpdate($request);
		if($msm['val']){
			$datos_especificos = [
				//id de la tienda del contrato
				'numero_1' => $request->id_tienda,
				//
				'dato_1' => null,
				//fecha del cierre
				'fecha_1' => Carbon::now(),

				//código del contrato
				'numero_2' => $request->id,
				//
				'dato_2' => null,
				//
				'fecha_2' => null,
				
				//id estado del contrato
				'numero_3' => env('ESTADO_CONTRATO_CERRADO'),
				//
				'dato_3' => null,
				//
				'fecha_3' => null,

				'transaccion' => "update",
				'operacion' => "Cerrar contrato",
				'log' => null,
			];
			CrudContrato::crearAuditoria($datos_especificos);
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
        }
		return redirect('/contrato/index');
		
	}

	public function ReversarCierreUpdate(request $request)
	{	
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/index',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'contrato/index',
				'text'=>'Gestionar Contratos'
			],
		);
		$msm=CrudCerrarContrato::ReversarCierreUpdate($request);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
        }
		return redirect('/contrato/index');
	}
	
	public function SolicitudCerrarUpdate(request $request)
	{
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/index',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'contrato/index',
				'text'=>'Gestionar Contratos'
			],
		);
		$file1 = $request->file_certificado;
		$file2 = $request->file_denuncia;
		$file3 = $request->file_incautacion;

		if($file1 == "") $file1 = 1;
		if($file2 == "") $file2 = 1;
		if($file3 == "") $file3 = 1;

		if($request->file_certificado != ""){
			$up = new FileManagerSingle($request->file_certificado);
			$key = uniqid();
			$id_file1 = $up->moveFile($key,env('RUTA_ARCHIVO')."colombia".DIRECTORY_SEPARATOR."contrato".DIRECTORY_SEPARATOR."cerrar_contrato");
			$file1 = $id_file1['msm'][1];
		}

		if($request->file_denuncia != ""){
			$up = new FileManagerSingle($request->file_denuncia);
			$key = uniqid();	
			$id_file2 = $up->moveFile($key,env('RUTA_ARCHIVO').'colombia/contrato/cerrar_contrato');
			$file2 = $id_file2['msm'][1];
		}

		if($request->file_incautacion != ""){
			$up = new FileManagerSingle($request->file_incautacion);
			$key = uniqid();	
			$id_file3 = $up->moveFile($key,env('RUTA_ARCHIVO').'colombia/contrato/cerrar_contrato');
			$file3 = $id_file3['msm'][1];
		}
		$msm=CrudCerrarContrato::SolicitudCerrarUpdate($request,$file1,$file2,$file3);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/contrato/index');
    }

    public function SolicitudReversarCierreUpdate(request $request)
	{
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/index',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'contrato/index',
				'text'=>'Gestionar Contratos'
			],
		);
		$msm=CrudCerrarContrato::SolicitudReversarCierreUpdate($request);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
        }
		return redirect('/contrato/index');
    }

    public function ListMotivosEstado(Request $request){
		$id = $request->id;
		$data = CrudCerrarContrato::ListMotivosEstado($id);
		return response()->json($data);
	}
	
	public function descargar($id, Request $request)
	{
		$path = env('RUTA_ARCHIVO')."colombia/contrato/cerrar_contrato/";
		$id = $request->file;
		$file = CrudCerrarContrato::consultarArchivo($id);
		$file = $file->nombre;
		$res = "";
		if (is_file($path.$file)) {
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment;filename=".rawurlencode($file));
			header("Content-Transfer-Encoding: binary");
			header("Content-Length: ".filesize($path.$file));
			readfile($path.$file);
		}

		return redirect()->back();
	}

	public function consultarArchivo(Request $request)
	{	
		$id = $request->id;
		$data = CrudCerrarContrato::consultarArchivo($id);
		return response()->json($data);
	}
    
}