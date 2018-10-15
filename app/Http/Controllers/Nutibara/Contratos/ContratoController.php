<?php

namespace App\Http\Controllers\Nutibara\Contratos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\BusinessLogic\Nutibara\Contratos\CrudContrato;
use App\BusinessLogic\Nutibara\Clientes\Empleado\CrudEmpleado;
use App\BusinessLogic\Nutibara\Contratos\AplazarContrato;
use App\BusinessLogic\Nutibara\Contratos\RetroventaContrato;
use App\BusinessLogic\Nutibara\Contratos\ProrrogarContrato;
use App\BusinessLogic\Nutibara\Contratos\CrudCerrarContrato;
Use App\BusinessLogic\Nutibara\GenerarPlan\CrudGenerarPlan AS plansepare;
use Illuminate\Support\Facades\Session;
use App\AccessObject\Nutibara\Pais\Pais;
use App\AccessObject\Nutibara\Departamento\Departamento;
use App\AccessObject\Nutibara\Ciudad\Ciudad;
use App\AccessObject\Nutibara\Zona\Zona;
use App\Mail\generteMail as generateMail;
use App\Http\Middleware\userIpValidated;
use Mail;
use Carbon\Carbon;
use config\messages;
use Illuminate\Support\Facades\Auth;
use App\BusinessLogic\NumeroALetras\NumeroALetras;
use App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria\MovimientosTesoreria;
use PDF;

use App\Mail\notificarUsuario as EmailNotificacion;

class ContratoController extends Controller
{
    public function index(){
		$pais = Pais::getSelectList();
		$departamento = Departamento::getSelectList();
		$ciudad = Ciudad::getSelectList();
		$zona = Zona::getSelectList();
		$ipValidation = new userIpValidated();
		//dd($ipValidation->getRealIP());
		$tienda_actual = Contrato::getTiendaByIp($ipValidation->getRealIP());
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
			]
		);
        return view('Contratos.index',['pais' => $pais,'departamento' => $departamento,'ciudad' => $ciudad,'zona' => $zona,'urls' => $urls, 'tienda_actual' => $tienda_actual]);
    }

    public function get(Request $request){
		return CrudContrato::get($request);
	}

	public function get2(Request $request){
    	$start=(int)$request->start;
		$end=$start+(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["pais"] = str_replace($vowels, "", $request->columns[5]['search']['value']);
		$search["departamento"] = str_replace($vowels, "", $request->columns[6]['search']['value']);
		$search["ciudad"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["zona"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["tienda"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[3]['search']['value']);
		$search["motivo"] = str_replace($vowels, "", $request->columns[4]['search']['value']);
		$total=CrudContrato::getCountContrato();
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>CrudContrato::Contrato($start,$end,$colum, $order,$search)
		];   
		return response()->json($data);
	}
	
	public function Create(){
    	return view('/Clientes/CargoEmpleado.create');
    }

    public function CreatePost(request $request){
    	$this->validate($request, [
			'nombre' => 'required|unique:tbl_empl_cargo',
        ]);
		$dataSaved=[
			'nombre' => $request->nombre,
			'descripcion' => $request->descripcion,
			'estado' => 1
		];
		$msm=CrudContrato::Create($dataSaved);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/Clientes/CargoEmpleado');
    }

    public function Delete(request $request){
		$msm=CrudContrato::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=CrudContrato::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Aplazar($codigo,$id_tienda){
		$ipValidation = new userIpValidated();
		$tienda_actual = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$id_tienda_actual = (isset($tienda_actual->id)) ? $tienda_actual->id : 0;
		$contrato=CrudCerrarContrato::getInfoCerrarContrato($codigo,$id_tienda);
		if($id_tienda_actual == $id_tienda && $contrato[0]->Id_Estado_Contrato == env('ESTADO_CREACION_CONTRATO'))
		{
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
					'href'=>'contrato/aplazar/'.$codigo.'/'.$id_tienda,
					'text'=>'Aplazar contrato'
				]
			);
			$aplazo = new AplazarContrato(NULL,$codigo,$id_tienda);
			$data=$aplazo->getContratoById();
			$historial = $aplazo->getAplazosById();
			$items = $aplazo->getItemsContratoById();
			$aplicacion_retroventa = Contrato::aplicacionRetroventa($codigo, $id_tienda);
			$var_menos_porcentaje = (isset($aplicacion_retroventa->menos_porcentaje)) ? $aplicacion_retroventa->menos_porcentaje : 0;
			$var_menos_porcentaje = ($var_menos_porcentaje != null) ? $var_menos_porcentaje : 0;

			$var_menos_meses = (isset($aplicacion_retroventa->menos_meses)) ? $aplicacion_retroventa->menos_meses : 0;
			$var_menos_meses = ($var_menos_meses != null) ? $var_menos_meses : 0;

			$infoActualContrato = Contrato::infoActualContrato($codigo, $id_tienda, $var_menos_porcentaje, $var_menos_meses, 0);
			$retroventa_menos = $infoActualContrato[0]->valor_retroventa;
			$descuento_retroventa = 0;
			$precio_total = 0;
			$porcentaje_retroventa = $data->porcentaje_retroventa;
			$fecha_terminacion_cabecera = $data->fecha_terminacion;
			$tercero = CrudContrato::getInfoTercero($codigo, $id_tienda);
			$tipo_parentesco = CrudEmpleado::getSelectList('tipo_parentesco');
			
			return view('Contratos.aplazar' , 
				[
					'attribute' => $data,
					'historial' => $historial,
					'items' => $items,
					"id" => $codigo,
					"id_tienda" => $id_tienda,
					'urls' => $urls,
					'infoActualContrato' => $infoActualContrato,
					'precio_total' => $precio_total,
					'porcentaje_retroventa' => $porcentaje_retroventa,
					'fecha_terminacion_cabecera' => $fecha_terminacion_cabecera,
					'tercero' => $tercero,
					'tipo_parentesco' => $tipo_parentesco,
					'contrato' => $contrato,
					'retroventa_menos' => $retroventa_menos,
					'descuento_retroventa' => $descuento_retroventa,
				]
			);
		} else {
			Session::flash('warning', Messages::$aplazarContrato['invalid']);
			return redirect()->back();
		}
	}
	public function Cerrar($codigo,$id_tienda){
		$ipValidation = new userIpValidated();
		$tienda_actual = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$id_tienda_actual = (isset($tienda_actual->id)) ? $tienda_actual->id : 0;
		$contrato=CrudCerrarContrato::getInfoCerrarContrato($codigo,$id_tienda);
		if($id_tienda_actual == $id_tienda && $contrato[0]->Id_Estado_Contrato == env('ESTADO_CREACION_CONTRATO'))
		{
			$aplazo = new AplazarContrato(NULL,$codigo,$id_tienda);
			$data=$aplazo->getContratoById();
			$aplicacion_retroventa = Contrato::aplicacionRetroventa($codigo, $id_tienda);
			$var_menos_porcentaje = (isset($aplicacion_retroventa->menos_porcentaje)) ? $aplicacion_retroventa->menos_porcentaje : 0;
			$var_menos_porcentaje = ($var_menos_porcentaje != null) ? $var_menos_porcentaje : 0;

			$var_menos_meses = (isset($aplicacion_retroventa->menos_meses)) ? $aplicacion_retroventa->menos_meses : 0;
			$var_menos_meses = ($var_menos_meses != null) ? $var_menos_meses : 0;

			$infoActualContrato = Contrato::infoActualContrato($codigo, $id_tienda, $var_menos_porcentaje, $var_menos_meses,0);
			$retroventa_menos = $infoActualContrato[0]->valor_retroventa;
			$descuento_retroventa = 0;
			$historial = $aplazo->getAplazosById();
			$items = $aplazo->getItemsContratoById();
			// dd($historial);
		   return view('Contratos.cerrar' , ['attribute' => $data, 'historial' => $historial, 'items' => $items, "id" => $codigo, "id_tienda" => $id_tienda, "infoActualContrato" => $infoActualContrato, 'retroventa_menos' => $retroventa_menos, 'descuento_retroventa' => $descuento_retroventa]);
		} else {
			Session::flash('warning', Messages::$CerrarContrato['invalid']);
			return redirect()->back();
		}
	}


	public function getAplazarById(Request $request,$id){
		dd(3);
    	$start=(int)$request->start;
		$end=$start+(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$total=CrudContrato::getCountAplazarById();
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>CrudContrato::AplazarById($start,$end,$colum, $order,$search)
		];   
		return response()->json($data);
	}

	public function AplazarPost(request $request){
		$this->validate($request, [
			'fecha_aplazo' => 'required',
		]);
		$codigo = (int)$request->id;
		$id_tienda = (int)$request->id_tienda;
		$fecha = $request->fecha_aplazo;
		$suject = "Aplazamiento de contrato";
		$items = Contrato::getItemsContratoById($codigo,$id_tienda);
		$body = self::createBody($items,$codigo,$fecha);
		$todayh = getdate();
		$dataSaved=[
			'codigo_contrato' => $request->id,	
			'id_tienda_contrato' => $request->id_tienda,
			'fecha_aplazo' => $request->fecha_aplazo.' '.$todayh['hours'].':'.$todayh['minutes'].':'.$todayh['seconds'],
			'comentario' => $request->comentario,
		];
		$aplazo = new AplazarContrato($dataSaved,$codigo,$id_tienda);
		$msm = $aplazo->CrearAplazo($dataSaved,$codigo,$id_tienda);
		if($msm['val']){
			$datos_especificos = [
				//id de la tienda del contrato
				'numero_1' => $id_tienda,
				//comentario
				'dato_1' => $request->comentario,
				//fecha del aplazo
				'fecha_1' => $fecha,

				//código del contrato
				'numero_2' => $codigo,
				//
				'dato_2' => null,
				//
				'fecha_2' => null,
				//
				'numero_3' => null,
				//
				'dato_3' => null,
				//
				'fecha_3' => null,

				'transaccion' => "update",
				'operacion' => "Aplazar contrato",
				'log' => null,
			];
			CrudContrato::crearAuditoria($datos_especificos);
			Session::flash('message', $msm['msm']);
			Mail::to($request->correo_email)->send(new generateMail($suject,$request->tienda,$body));
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('contrato/aplazar/'.$codigo."/".$id_tienda);
	}

	public function createBody($items,$codigo,$fecha)
	{
		$body = "";
		$body.= "<p>Codigo contrato: ".$codigo."</p>";
		$body.= "<p>Fecha de aplazo: ".$fecha."</p>";
		$body.= "<table>";
		$body.= "<thead>
					<tr>
					<th>Línea Item</th>
					<th>Categoría</th>
					<th>Nombre</th>
					<th>Descripción</th>
					<th>Precio</th>
					<th>Peso Estimado</th> 
					</tr>
				</thead>";
		foreach ($items AS $item) {
			$body.= "<tr>";
			$body.= "<td>".$item->id_linea_item_contrato."</td>";
			$body.= "<td>".$item->categoria_general."</td>";
			$body.= "<td>".$item->nombre_item."</td>";
			$body.= "<td>".$item->descripcion_item."</td>";
			$body.= "<td>".$item->Descripcion_Item."</td>";
			$body.= "<td>".$item->peso_estimado."</td>";
			$body.= "</tr>";
		}
		$body.= "</table>";

		return $body;
	}

	public function VerContrato($codigo, $id_tienda){
		$tipo_parentesco = CrudEmpleado::getSelectList('tipo_parentesco');
		$items = Contrato::getItemsContratoById($codigo,$id_tienda);
		$data = Contrato::getContratoById($codigo,$id_tienda);
		$aplicacion_retroventa = Contrato::aplicacionRetroventa($codigo, $id_tienda);
		$var_menos_porcentaje = (isset($aplicacion_retroventa->menos_porcentaje)) ? $aplicacion_retroventa->menos_porcentaje : 0;
		$var_menos_porcentaje = ($var_menos_porcentaje != null) ? $var_menos_porcentaje : 0;

		$var_menos_meses = (isset($aplicacion_retroventa->menos_meses)) ? $aplicacion_retroventa->menos_meses : 0;
		$var_menos_meses = ($var_menos_meses != null) ? $var_menos_meses : 0;

		$infoActualContrato = Contrato::infoActualContrato($codigo, $id_tienda, $var_menos_porcentaje, $var_menos_meses,0);
		$retroventa_menos = $infoActualContrato[0]->valor_retroventa;
		$descuento_retroventa = 0;
		$precio_total = 0;
		$porcentaje_retroventa = $data->porcentaje_retroventa;
		$fecha_terminacion_cabecera = $data->fecha_terminacion;
		for($i = 0; $i < count($items); $i++){
			$precio_total += $items[$i]->precio_ingresado;
		}
		$contrato=CrudCerrarContrato::getInfoCerrarContrato($codigo,$id_tienda);
		$tercero = CrudContrato::getInfoTercero($codigo, $id_tienda);
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
				'href'=>'contrato/ver/'.$codigo.'/'.$id_tienda,
				'text'=>'Ver contrato'
			]
		);
		return view(
			'Contratos.vercontrato',
			[
				'attribute' => $data,
				'items' => $items,
				'id' => $codigo,
				'id_tienda' => $id_tienda,
				'precio_total' => $precio_total,
				'porcentaje_retroventa' => $porcentaje_retroventa,
				'fecha_terminacion_cabecera' => $fecha_terminacion_cabecera,
				'contrato'=>$contrato,
				'tipo_parentesco' => $tipo_parentesco,
				'tercero' => $tercero,
				'urls' => $urls,
				'infoActualContrato' => $infoActualContrato,
				'retroventa_menos' => $retroventa_menos,
				'descuento_retroventa' => $descuento_retroventa,
				'autorizarTercero' => 'autorizarTercero'
			]
		);
	}


	// Registro de auditoría de contratos

	public function crearAuditoria(){

	}

	
	// Funciones para prorroga de contrato

	public function Prorrogar($codigo, $id_tienda){
		$contrato=CrudCerrarContrato::getInfoCerrarContrato($codigo,$id_tienda);
		if($contrato[0]->Id_Estado_Contrato == env('ESTADO_CREACION_CONTRATO'))
		{
			$prorroga = new ProrrogarContrato(NULL,NULL,$codigo,$id_tienda,NULL,NULL);
			$data=$prorroga->getContratoById();
			$aplicacion_retroventa = Contrato::aplicacionRetroventa($codigo, $id_tienda);
			$var_menos_porcentaje = (isset($aplicacion_retroventa->menos_porcentaje)) ? $aplicacion_retroventa->menos_porcentaje : 0;
			$var_menos_porcentaje = ($var_menos_porcentaje != null) ? $var_menos_porcentaje : 0;

			$var_menos_meses = (isset($aplicacion_retroventa->menos_meses)) ? $aplicacion_retroventa->menos_meses : 0;
			$var_menos_meses = ($var_menos_meses != null) ? $var_menos_meses : 0;

			$infoActualContrato = Contrato::infoActualContrato($codigo, $id_tienda, $var_menos_porcentaje, $var_menos_meses,0);
			$retroventa_menos = $infoActualContrato[0]->valor_retroventa;
			$descuento_retroventa = ( 0 );
			$historial = $prorroga->getProrrogasById();
			$items = $prorroga->getItemsContratoById();
			$precio_total = 0;
			$valor_abonado = Contrato::getAbonoProrroga($codigo, $id_tienda);
			$porcentaje_retroventa = $data->porcentaje_retroventa;
			$fecha_terminacion_cabecera = $data->fecha_terminacion;
			$tercero = CrudContrato::getInfoTercero($codigo, $id_tienda);
			$tipo_parentesco = CrudEmpleado::getSelectList('tipo_parentesco');
			for($i = 0; $i < count($items); $i++){
				$precio_total += str_replace('.', '', $items[$i]->precio_ingresado);
			}
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
					'href'=>'contrato/prorrogar/'.$codigo.'/'.$id_tienda,
					'text'=>'Prorrogar contrato'
				]
			);

			return view(
				'Contratos.prorrogar',
				[
					'contrato'=>$contrato,
					'attribute' => $data,
					'historial' => $historial,
					'items' => $items,
					'id' => $codigo,
					'id_tienda' => $id_tienda,
					'precio_total' => $precio_total,
					'porcentaje_retroventa' => $porcentaje_retroventa,
					'fecha_terminacion_cabecera' => $fecha_terminacion_cabecera,
					'urls' => $urls,
					'valor_abonado' => $valor_abonado,
					'infoActualContrato' => $infoActualContrato,
					'tercero' => $tercero,
					'tipo_parentesco' => $tipo_parentesco,
					'retroventa_menos' => $retroventa_menos,
					'descuento_retroventa' => $descuento_retroventa,
				]
			);
		} else {
			Session::flash('warning', Messages::$prorrogaContrato['invalid']);
			return redirect()->back();
		}
	}

	public function ProrrogarPost(request $request){
		//dd($request->all());
		$codigo = (int)$request->id;
		$id_tienda = (int)$request->id_tienda;
		$efectivo = ($request->var_efectivo != "") ? (int) $request->var_efectivo : 0;
		$debito = ($request->var_debito != "") ? (int) $request->var_debito : 0;
		$credito = ($request->var_credito != "") ? (int) $request->var_credito : 0;
		$otros = ($request->var_otros != "") ? (int) $request->var_otros : 0;
		$valor_ingresado = ( $efectivo + $debito + $credito + $otros );
		$fecha_terminacion_cabecera = $request->fecha_terminacion_cabecera;
		
		$prorroga = new ProrrogarContrato($fecha_terminacion_cabecera,NULL,$codigo,$id_tienda, $request->meses_prorroga, $request->nuevo_valor_abonado);
		$fecha_terminacion = $prorroga->getFechaProrroga();
		$dataSaved=[
			'codigo_contrato' => $request->id,	
			'id_tienda_contrato' => $request->id_tienda,
			'fecha_prorroga' => $request->fecha_prorroga,
			'fecha_terminacion' => $fecha_terminacion,
			'valor_ingresado' => $valor_ingresado,
			'meses_ingresados' => $request->meses_prorroga
		];
		$msm = $prorroga->CrearProrroga($dataSaved,$codigo,$id_tienda);
		if($msm['val']){
			if($efectivo > 0)
			{
				$movimiento_contable[0] = env('CUENTA_EFECTIVO');
				$tipo[0] = 'EFECTIVO';
				$comprabante[0] = 0;
				$observaciones[0] = "";
				$valor[0] = $efectivo;
			}
			if($debito > 0)
			{
				$movimiento_contable[1] = env('CUENTA_DEBITO');
				$tipo[1] = 'DEBITO';
				$comprabante[1] = $request->aprobacion_debito;
				$observaciones[1] = "";
				$valor[1] = $debito;
			}
			if($credito > 0)
			{
				$movimiento_contable[2] = env('CUENTA_CREDITO');
				$tipo[2] = 'CREDITO';
				$comprabante[2] = $request->aprobacion_credito;
				$observaciones[2] = "";
				$valor[2] = $credito;
			}
			if($otros > 0)
			{
				$movimiento_contable[3] = env('CUENTA_OTROS');
				$tipo[3] = 'OTROS';
				$comprabante[3] = $request->aprobacion_otro;
				$observaciones[3] = $request->observacion_otros;
				$valor[3] = $otros;
			}

			$movimiento_contable = array_values($movimiento_contable);	
			$tipo = array_values($tipo);	
			$comprabante = array_values($comprabante);	
			$observaciones = array_values($observaciones);
			$valor = array_values($valor);

			try{
				$msms = MovimientosTesoreria::registrarMovimientosAbono($valor_ingresado,$id_tienda,$movimiento_contable,null,'PRORR-'.$id_tienda.'/'.$codigo,$tipo,$comprabante,$observaciones,$valor,2,1);
			}catch(\Exception $e){
				dd($e);
				DB::rollback();
				$msms = false;
			}



			$datos_especificos = [
				//id de la tienda del contrato
				'numero_1' => $id_tienda,
				//valor ingresado para la prórroga
				'dato_1' => $valor_ingresado,
				//fecha de la prórroga
				'fecha_1' => $request->fecha_prorroga,

				//código del contrato
				'numero_2' => $request->id,
				//meses de prórroga
				'dato_2' => $request->meses_prorroga,
				//nueva fecha de terminación del contrato
				'fecha_2' => $request->fecha_terminacion,
				
				//número de bolsas del contrato
				'numero_3' => null,
				//categoría general del contrato
				'dato_3' => null,
				//fecha de terminación del contrato
				'fecha_3' => null,

				'transaccion' => "create",
				'operacion' => "Prorrogar contrato",
				'log' => null,
			];
			CrudContrato::crearAuditoria($datos_especificos);
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return self::prorrogaGeneratePDF( $codigo, $id_tienda );

		
	}



	public function ProrrogarPostAjax(request $request){
		
		$codigo = (int)$request->id;
		$id_tienda = (int)$request->id_tienda;
		$valor_ingresado = $request->valor_ingresado;
		$fecha_terminacion_cabecera = $request->fecha_terminacion_cabecera;
		
		$prorroga = new ProrrogarContrato($fecha_terminacion_cabecera,NULL,$codigo,$id_tienda, $request->meses_prorroga, $request->nuevo_valor_abonado);
		$fecha_terminacion = $prorroga->getFechaProrroga();
		$dataSaved=[
			'codigo_contrato' => $request->id,	
			'id_tienda_contrato' => $request->id_tienda,
			'fecha_prorroga' => $request->fecha_prorroga,
			'fecha_terminacion' => $fecha_terminacion,
			'valor_ingresado' => $request->valor_ingresado,
			'meses_ingresados' => $request->meses_prorroga
		];
		$msm = $prorroga->CrearProrroga($dataSaved,$codigo,$id_tienda);
		if($msm['val']){
			$transfeContrato = plansepare::transferirGuardarX($request);  
			$datos_especificos = [
				//id de la tienda del contrato
				'numero_1' => $id_tienda,
				//valor ingresado para la prórroga
				'dato_1' => $valor_ingresado,
				//fecha de la prórroga
				'fecha_1' => $request->fecha_prorroga,

				//código del contrato
				'numero_2' => $request->id,
				//meses de prórroga
				'dato_2' => $request->meses_prorroga,
				//nueva fecha de terminación del contrato
				'fecha_2' => $request->fecha_terminacion,
				
				//número de bolsas del contrato
				'numero_3' => null,
				//categoría general del contrato
				'dato_3' => null,
				//fecha de terminación del contrato
				'fecha_3' => null,

				'transaccion' => "create",
				'operacion' => "Prorrogar contrato",
				'log' => null,
			];
			CrudContrato::crearAuditoria($datos_especificos);
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return response()->json($msm);
	}

	// Funciones para prorroga de contrato

	public function Retroventa($codigo, $id_tienda){

		
		$ipValidation = new userIpValidated();
		$tienda_actual = Contrato::getTiendaByIp($ipValidation->getRealIP());
		$id_tienda_actual = (isset($tienda_actual->id)) ? $tienda_actual->id : 0;
		$contrato=CrudCerrarContrato::getInfoCerrarContrato($codigo,$id_tienda);
		if($id_tienda_actual == $id_tienda && $contrato[0]->Id_Estado_Contrato == env('ESTADO_CREACION_CONTRATO'))
		{
			$retroventa = new RetroventaContrato(NULL,NULL,$codigo,$id_tienda);
			$data=$retroventa->getContratoById();
			$aplicacion_retroventa = Contrato::aplicacionRetroventa($codigo, $id_tienda);
			$var_menos_porcentaje = (isset($aplicacion_retroventa->menos_porcentaje)) ? $aplicacion_retroventa->menos_porcentaje : 0;
			$var_menos_porcentaje = ($var_menos_porcentaje != null) ? $var_menos_porcentaje : 0;

			$dias_gracia = Contrato::getTerminoRetroventa($data->id_categoria_general, $id_tienda, $data->monto);
			$dias_gracia = (isset($dias_gracia[0]->dias_gracia)) ? $dias_gracia[0]->dias_gracia : 0;
			$infoActualContrato = Contrato::infoActualContrato($codigo, $id_tienda, $var_menos_porcentaje, 0, $dias_gracia);
			$descuento_dias_gracia = $infoActualContrato[0]->descuento_dias_gracia;
			$valor_contrato = $infoActualContrato[0]->valor_contrato;
			// $retroventa_menos =  $infoActualContrato[0]->valor_retroventa_descuento;

			// adicional
			$retroventa_menos =  $infoActualContrato[0]->valor_retroventa;

			$descuento_retroventa = ( $infoActualContrato[0]->valor_retroventa - $retroventa_menos );
			$descuento_retroventa += $descuento_dias_gracia;

			
			// $retroventa_menos -= $descuento_dias_gracia;

			// if($retroventa_menos < $valor_contrato){
			// 	$descuento_retroventa -= ($valor_contrato - $retroventa_menos);
			// 	$retroventa_menos = $valor_contrato;
			// }

			$historial = $retroventa->getRetroventasById();
			$items = $retroventa->getItemsContratoById();
			$precio_total = 0;
			$porcentaje_retroventa = $data->porcentaje_retroventa;
			$fecha_terminacion_cabecera = $data->fecha_terminacion;
			$tercero = CrudContrato::getInfoTercero($codigo, $id_tienda);
			$tipo_parentesco = CrudEmpleado::getSelectList('tipo_parentesco');
			for($i = 0; $i < count($items); $i++){
				$precio_total += (int)str_replace('.', '', $items[$i]->precio_ingresado);
			}
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
					'href'=>'contrato/retroventa/'.$codigo.'/'.$id_tienda,
					'text'=>'Retroventa contrato'
				]
			);
			
			return view(
				'Contratos.retroventa',
				[
					'attribute' => $data,
					'historial' => $historial,
					'items' => $items,
					'id' => $codigo,
					'id_tienda' => $id_tienda,
					'precio_total' => $precio_total,
					'porcentaje_retroventa' => $porcentaje_retroventa,
					'fecha_terminacion_cabecera' => $fecha_terminacion_cabecera,
					'contrato'=>$contrato,
					'urls' => $urls,
					'infoActualContrato' => $infoActualContrato,
					'tercero' => $tercero,
					'tipo_parentesco' => $tipo_parentesco,
					'retroventa_menos' => $retroventa_menos,
					'descuento_retroventa' => $descuento_retroventa,
				]
			);
		} else {
			Session::flash('warning', Messages::$RetroventaContrato['invalid']);
			return redirect()->back();
		}
	}

	public function RetroventaPost($codigoContrato,$idTiendaContrato,$valor)
	{
		$msm=CrudContrato::RetroventaPost($codigoContrato,$idTiendaContrato,$valor);
		if($msm['val']){
			$datos_especificos = [
				//id de la tienda del contrato
				'numero_1' => $idTiendaContrato,
				//
				'dato_1' => null,
				//fecha de la retroventa
				'fecha_1' => Carbon::now(),

				//código del contrato
				'numero_2' => $codigoContrato,
				//
				'dato_2' => null,
				//
				'fecha_2' => null,
				
				//
				'numero_3' => null,
				//
				'dato_3' => null,
				//
				'fecha_3' => null,

				'transaccion' => "create",
				'operacion' => "Retroventa contrato",
				'log' => null,
			];
			CrudContrato::crearAuditoria($datos_especificos);
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return self::retroventaGeneratePDF( $codigoContrato, $idTiendaContrato );
        // return redirect()->back();
	}
	
	public function reversarRetroventaPost($codigoContrato,$idTiendaContrato,$valor)
	{
		$msm=CrudContrato::reversarRetroventaPost($codigoContrato,$idTiendaContrato,$valor);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
        }
        return redirect()->back();
    }
	
	public function CerrarUpdate(request $request)
	{
		//dd($request->all());
		$this->validate($request, [
			'Motivo_Cierre' => 'required',
        ]);
		$msm=CrudCerrarContrato::CerrarUpdate($request->id,$request->idtienda);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/Clientes/CargoEmpleado');

	}

	public function guardarTercero(Request $request){
		$tienda = $request->tienda_contrato;
		$codigo = $request->codigo_contrato;
        $data = [
			'id_tienda' => $tienda,
			'id_codigo_contrato' => $codigo,
            'id_tipo_documento' => $request->tipodocumentotercero,
            'numero_documento' => $request->numero_documeto_tercero,
            'nombres' => $request->nombres_tercero,
            'apellidos' => $request->apellidos_tercero,
            'telefono' => $request->telefono_tercero,
            'celular' => $request->celular_tercero,
            'correo' => $request->correo_tercero,
            'direccion' => $request->direccion_tercero,
            'parentesco' => $request->parentesco_tercero[0],
		];
		$msm=CrudContrato::guardarTercero($data);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
        }
        return redirect()->back();
	}
	
	public function actualizarTercero(Request $request){
		$tienda = $request->tienda_contrato;
		$codigo = $request->codigo_contrato;
        $data = [
            'id_tipo_documento' => $request->tipodocumentotercero,
            'numero_documento' => $request->numero_documeto_tercero,
            'nombres' => $request->nombres_tercero,
            'apellidos' => $request->apellidos_tercero,
            'telefono' => $request->telefono_tercero,
            'celular' => $request->celular_tercero,
            'correo' => $request->correo_tercero,
            'direccion' => $request->direccion_tercero,
            'parentesco' => $request->parentesco_tercero[0],
		];
		$msm=CrudContrato::actualizarTercero($codigo,$tienda, $data);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
        }
        return redirect()->back();
	}
	
	// Función para actualizar campo <extraviado> de la cabecera del contrato
	public function contratoExtraviado(Request $request){
		$response = CrudContrato::contratoExtraviado($request->codigo_contrato, $request->tienda_contrato, $request->valor_extraviado);
		if(isset($request->session_pdf)){
			Session::flash('session_tienda_pdf', $request->tienda_contrato);
			Session::flash('session_contrato_pdf', $request->codigo_contrato);
		}
		return response()->json($response);
	}

	public function prorrogaGeneratePDF( $codigo_contrato, $id_tienda ){
		$user = Auth::user()->name;
		$date = Carbon::now();
        $object = Contrato::getContratoPDF( $codigo_contrato, $id_tienda, Auth::user()->id );
        $empleado = Contrato::getInfoEmpleado( Auth::user()->id );
        $columnas_items = Contrato::getColumnasItems( $codigo_contrato, $id_tienda );
        $datos_columnas_items = Contrato::getDatosColumnasItems( $codigo_contrato, $id_tienda );
        $moneda = Contrato::getMoneda();
        $remove = [ '.', ',00', '$', ' ' ];
        
        $copia = (isset($request->copia_pdf)) ? true : false;
		// return view( 'DocumentosPDF.prorroga', [ 'object' => $object, 'empleado' => $empleado,'user' => $user, 'date' => $date, 'columnas_items' => $columnas_items, 'datos_columnas_items' => $datos_columnas_items, 'moneda' => $moneda, 'copia' => $copia ] );
		
		$pdf = PDF::setPaper('A4', 'landscape');
		$pdf->loadView( 'DocumentosPDF.prorroga', [ 'object' => $object, 'empleado' => $empleado,'user' => $user, 'date' => $date, 'columnas_items' => $columnas_items, 'datos_columnas_items' => $datos_columnas_items, 'moneda' => $moneda, 'copia' => $copia ] );
        return $pdf->download( 'prorroga.pdf' );
	}

	public function retroventaGeneratePDF( $codigo_contrato, $id_tienda ){
		$user = Auth::user()->name;
		$date = Carbon::now();
        $object = Contrato::getContratoPDF( $codigo_contrato, $id_tienda, Auth::user()->id );
        $empleado = Contrato::getInfoEmpleado( Auth::user()->id );
        $columnas_items = Contrato::getColumnasItems( $codigo_contrato, $id_tienda );
        $datos_columnas_items = Contrato::getDatosColumnasItems( $codigo_contrato, $id_tienda );
        $moneda = Contrato::getMoneda();
		$remove = [ '.', ',00', '$', ' ' ];
		$object[ 0 ]->valor_contrato_texto = NumeroALetras::convertir( str_replace( $remove, '', $object[ 0 ]->valor_contrato ) );
        $object[ 0 ]->retroventa_contrato_texto = NumeroALetras::convertir( str_replace( $remove, '', $object[ 0 ]->valor_retroventa ) );
        
        $copia = (isset($request->copia_pdf)) ? true : false;
		// return view( 'DocumentosPDF.retroventa', [ 'object' => $object, 'empleado' => $empleado,'user' => $user, 'date' => $date, 'columnas_items' => $columnas_items, 'datos_columnas_items' => $datos_columnas_items, 'moneda' => $moneda, 'copia' => $copia ] );
		
		$pdf = PDF::setPaper('A4', 'landscape');
		$pdf->loadView( 'DocumentosPDF.retroventa', [ 'object' => $object, 'empleado' => $empleado,'user' => $user, 'date' => $date, 'columnas_items' => $columnas_items, 'datos_columnas_items' => $datos_columnas_items, 'moneda' => $moneda, 'copia' => $copia ] );
        return $pdf->download( 'retroventa.pdf' );
	}
}
