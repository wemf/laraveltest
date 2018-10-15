<?php

// Author		:	<Andrey Higuita>
// Create date	:	<Jueves, 15 de abril de 2018>
// Description	:	<Clase para controlar las peticiones de la resolución en el primer paso (perfeccionamiento de contratos)>


namespace App\Http\Controllers\Nutibara\Resolucion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Resolucion\CrudResolucion;
use App\Http\Middleware\userIpValidated;
use Illuminate\Support\Facades\Session;
use App\BusinessLogic\Nutibara\Contratos\ResolucionarBL;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\BusinessLogic\Nutibara\Inventario\Trazabilidad\TrazabilidadBL;
use PDF;


class ResolucionController extends Controller
{
    public function Index(){
		$ipValidation = new userIpValidated();
		$tienda = CrudResolucion::getTiendaByIp($ipValidation->getRealIP());
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/resolucion',
				'text'=>'Gestión de contratos'
			],
			[
				'href'=>'contrato/resolucion',
				'text'=>'Perfeccionamiento de contratos'
				]
			);

		return view('Resolucion.index',['urls'=>$urls,'tienda' => $tienda]);
    }

    public function get(Request $request){
    	return CrudResolucion::get($request);
    }

    public function resolucionar($id_tienda,$id){
		$idx = explode("-",$id);
		$contratos = CrudResolucion::getIdContratos($id_tienda,$idx);
		$contratos_array =  explode("-",$contratos->codigo_contratos);
		$items = CrudResolucion::getItemOrden($id_tienda,$idx);
		$columnas_items = Contrato::getColumnasItems( $contratos_array, $id_tienda );
		$datos_columnas_items = Contrato::getDatosColumnasItems( $contratos_array, $id_tienda );
		if(count($items) > 0){
			$destinatarios = CrudResolucion::getDestinatariosOrden($id_tienda,$idx);
			if($items[0]->categoria == "Articulo" || $items[0]->categoria == "Artículo" || $items[0]->categoria == "Artículos"){
				$procesos = CrudResolucion::getListProcesoByVitrina();
			}else{
				$procesos = CrudResolucion::getListProceso();
			}
			$urls=array(
				[
					'href' => 'home',
					'text' => 'home'
				],
				[
					'href' => 'contrato/resolucion',
					'text' => 'Gestión de contratos'
				],
				[
					'href' => 'contrato/resolucion',
					'text' => 'Perfeccionamiento de contratos'
				],
				[
					'href' => 'contrato/resolucion/create/'.$id,
					'text' => 'Perfeccionar Contrato'
				],
			);
			return view('Resolucion.create',[
												'urls'=> $urls,
												'procesos' => $procesos,
												'id' => $id,
												'id_tienda_orden' => $id_tienda,
												'items' => $items,
												'destinatarios' => $destinatarios,
												'contratos' => $contratos,
												'columnas_items' => $columnas_items, 
												'datos_columnas_items' => $datos_columnas_items
											]);
		}else{
			ResolucionarBL::eliminarOrdenGuardada($idx);
			return redirect('contrato/resolucion');
		}
    }

    public function procesar( request $request ) {
		$dataSaved = [
			'numero_orden' => $request->numero_orden,
			'id_item' => $request->id_item,
			'id_inventario' => $request->id_inventario,
			'id_hoja_trabajo' => $request->hoja_trabajo,
			'id_tienda_orden' => $request->id_tienda_orden,
			'subdivision' => $request->subdivision,
			'numero_documento' => $request->numero_documento,
			'peso_taller' => $request->peso_taller,
			'destinatario' => $request->destinatario,
			'id_proceso' => $request->id_proceso,
			'sucursales' => $request->sucursales,
			'procesar' => $request->procesar,
			'id_cliente_destinatario' => $request->id_cliente,
			'id_tienda_cliente_destinatario' => $request->id_tienda_cliente,
			'id_tienda_hoja_trabajo' => $request->id_tienda_hoja_trabajo,
			'id_tienda_inventario' => $request->id_tienda_inventario
		];
		$msm = CrudResolucion::Procesar( $dataSaved );
		if( $msm['val'] == 'Actualizado' ){
			Session::flash('message', 'Orden procesada con éxito');
			return $this->generatePDF($msm['ordenes'], $request->id_tienda_orden);
			return redirect('/contrato/resolucion');
		}
		elseif($msm['val']=='Insertado'){
			Session::flash('message', 'Orden sub-dividida con éxito');
			return $this->generatePDF($msm['ordenes'], $request->id_tienda_orden);
			return redirect('/contrato/resolucion');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
	}

	public function generatePDF($ids_ordenes, $id_tienda){
		$user = Auth::user()->name;
		$date = Carbon::now();
		$object = [];
		for ($i=0; $i < count($ids_ordenes); $i++) {
			array_push($object, ResolucionarBL::getOrdenPDF($ids_ordenes[$i], $id_tienda));
		}
		$pdf = PDF::loadView('DocumentosPDF.ordenresolucion', [ 'object' => $object, 'user' => $user, 'date' => $date ]);
		return $pdf->download('orden_resolucion.pdf');
	}

	public function generateExcel($id_orden, $id_tienda){
		return ResolucionarBL::generateExcel($id_orden, $id_tienda);
	}

	public function procesarUpdate($data,$ordenes)
	{
		$msm = CrudResolucion::procesarUpdate($data,$ordenes);
		return $msm;
	}

	public function procesarCrear($data,$ordenes)
	{
		$msm = CrudResolucion::procesarUpdate($data,$ordenes);
		return $msm;
	}

	public function getSelectList()
	{
		$msm = CrudResolucion::getSelectList();
		return  response()->json($msm);
	}

	public function getListProceso()
	{
		$msm = CrudResolucion::getListProceso();
		return  response()->json($msm);
	}

	public function getItemOrden($id_tienda,$id)
	{
		$idx = explode("-",$id);
		$response = CrudResolucion::getItemOrden($id_tienda,$idx);
		return  response()->json($response);
	}

	public function validarItem(request $request)
	{
		$response = CrudResolucion::validarItem($request->id_tienda_inventario,$request->id_inventario,$request->id_contrato);
		return response()->json($response);
	}

	public function quitarItems(request $request)
	{
		$items = explode(",",$request->items);
		$response = CrudResolucion::quitarItems($items);
		return response()->json($response);
	}

	public function getItemsContrato($codigo_orden, $id_tienda){
		$data = CrudResolucion::getItemsContrato($codigo_orden,$id_tienda);
		return response()->json($data);
	}
}
