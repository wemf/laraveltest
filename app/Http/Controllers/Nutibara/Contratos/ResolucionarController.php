<?php

// Author				:	<Andrey Higuita>
// Create date	:	<Jueves, 15 de febrero de 2018>
// Description	:	<Clase para controlar las peticiones de la resolución en el primer paso (perfeccionamiento de contratos)>

namespace App\Http\Controllers\Nutibara\Contratos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\BusinessLogic\FileManager\FileManagerSingle;
use App\Http\Middleware\userIpValidated;
use App\BusinessLogic\Nutibara\Contratos\ResolucionarBL;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\BusinessLogic\Nutibara\Refaccion\CrudRefaccion;
use PDF;
use Carbon\Carbon;
use config\messages;

class ResolucionarController extends Controller
{
  public function index(){
    $ipValidation = new userIpValidated();
    $tienda = ResolucionarBL::getTiendaByIp($ipValidation->getRealIP());
    $urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contrato/index',
				'text'=>'Gestión de contratos'
			],
			[
				'href'=>'contratos/resolucionar',
				'text'=>'Perfeccionamiento de contratos vencidos'
			]
		);
    	return view('Contratos.resolucionar.resolucionarconsulta', [ 'urls' => $urls, 'tienda' => $tienda]);
	}

	public function hojaTrabajo($id_tienda, $id_contratos){
		$array_contratos = explode("-",$id_contratos);
		$items = ResolucionarBL::getItemsContrato($id_tienda,$array_contratos);
		$cat_gen = (isset($items[0]->id_categoria)) ? $items[0]->id_categoria : 0;
		$procesos = ResolucionarBL::getListProceso( $cat_gen );
		$exist_perfeccionamiento = ResolucionarBL::validarPerfeccionamiento( $cat_gen, $id_tienda );
		if(!$exist_perfeccionamiento){
			$urls=array(
				[
					'href'=>'home',
					'text'=>'home'
				],
				[
					'href'=>'contrato/index',
					'text'=>'Gestion de contrato'
				],
				[
					'href'=>'contratos/resolucionar',
					'text'=>'Resolución de contratos'
				],
				[
					'href' => 'contratos/resolucionar',
					'text' => 'Resolucionar contratos'
				],
			);

			return view('Contratos.resolucionar.hojatrabajo',[
												'urls'=>$urls,
												'procesos'=>$procesos,
												'id' => $id_contratos,
												'id_tienda_orden' => $id_tienda,
												'items'=>$items
											]);
		}else{
			Session::flash('warning', Messages::$Resolucion['exist_perfeccion']);
			return redirect()->back();
		}

	}

	public function procesarHojaTrabajo(Request $request){
		$msm=ResolucionarBL::procesarHojaTrabajo($request);
		if($msm['val']==true){
			Session::flash('message', 'Contratos resolucionados con éxito');
			return $this->generatePDF($msm['ids_ordenes'], $msm['id_tienda']);
			// dd("A");
			return redirect('contratos/resolucionar');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect('contrato/resolucion');
	}

	public function guardarHojaTrabajo( Request $request ){
		$msm=ResolucionarBL::guardarHojaTrabajo($request);
        Session::flash('print_reporte', true);
		return redirect('/contrato/resolucion/resolucionar/'.$msm);
	}

	public function guardarHojaTrabajo2( Request $request ){
		$msm=ResolucionarBL::guardarHojaTrabajo($request);
		return redirect('/contrato/resolucion/resolucionar/'.$msm);
	}

	public function actualizarHojaTrabajo( Request $request ){
		$msm=ResolucionarBL::actualizarHojaTrabajo($request);
		return redirect()->back();
	}

	public function agregarContrato( Request $request ){
		Session::flash('message', 'Contrato agregado correctamente');
		return ResolucionarBL::agregarContrato($request);
	}

	public function quitarContrato( Request $request ){
		Session::flash('message', 'Contrato removido correctamente');
		return ResolucionarBL::quitarContrato($request);
	}

	public function getContratos(Request $request){
		return ResolucionarBL::getContratos($request);
	}

	public function generatePDF($ids_ordenes, $id_tienda){
		$user = Auth::user()->name;
		$date = Carbon::now();
		$items = CrudRefaccion::getItemOrden($id_tienda,$ids_ordenes);
		$destinatarios = CrudRefaccion::getDestinatariosOrdenPadre($id_tienda,$ids_ordenes);
		$contratos = array();
		foreach ($items as $key => $value){
			array_push($contratos, $value->id_contrato);
		}
		$columnas_items = Contrato::getColumnasItems( $contratos, $id_tienda );
        $datos_columnas_items = Contrato::getDatosColumnasItems( $contratos, $id_tienda );
		$object = [];
		for ($i=0; $i < count($ids_ordenes); $i++) {
			array_push($object, ResolucionarBL::getOrdenPDF($ids_ordenes[$i], $id_tienda));
		}
		$pdf = PDF::loadView('DocumentosPDF.ordenresolucion',[ 
			'object' => $object,
			'user' => $user,
			'date' => $date,
			'columnas_items' => $columnas_items,
			'datos_columnas_items' => $datos_columnas_items,
			'contratos' => $contratos,
			'destinatarios' => $destinatarios
		]);
		return $pdf->download('orden_resolucion.pdf');
	}

	public function pdfOrdenResolucion(Request $request){
		$id_tienda = 19;
		$ids_ordenes = [ 999 ];
		$user = Auth::user()->name;
		$date = Carbon::now();
		$items = CrudRefaccion::getItemOrden($id_tienda,$ids_ordenes);
		$destinatarios = CrudRefaccion::getDestinatariosOrden($id_tienda,$ids_ordenes);
		$contratos = array();
		foreach ($items as $key => $value){
			array_push($contratos, $value->id_contrato);
		}
		$columnas_items = Contrato::getColumnasItems( $contratos, $id_tienda );
        $datos_columnas_items = Contrato::getDatosColumnasItems( $contratos, $id_tienda );
		$object = [];
		for ($i=0; $i < count($ids_ordenes); $i++) {
			array_push($object, ResolucionarBL::getOrdenPDF($ids_ordenes[$i], $id_tienda));
		}
		// dd($object);
		return view('DocumentosPDF.ordenresolucion', 
			[ 
				'object' => $object,
				'user' => $user,
				'date' => $date,
				'columnas_items' => $columnas_items,
				'datos_columnas_items' => $datos_columnas_items,
				'contratos' => $contratos,
				'destinatarios' => $destinatarios
			]
		);
	}

	public function pdfCertificadoMineria(){
		return view('DocumentosPDF.certificadomineria');
	}

	public function pdfReporteResolucion(Request $request){
		$codigos_contratos = explode("-", $request->codigos_contratos);
		$id_tienda = $request->id_tienda_contrato;
		$user = Auth::user()->name;
		$date = Carbon::now();
		$object = [];
		array_push($object, ResolucionarBL::getReportePDFOrdenGuardada($codigos_contratos, $id_tienda));
		$pdf = PDF::loadView('DocumentosPDF.ordenresolucion', [ 'object' => $object, 'user' => $user, 'date' => $date ]);
		return $pdf->download('reporte_resolucion.pdf');
	}

	public function pdfPerfeccionamiento( Request $request ){
		$codigos_contratos = explode("-", $request->codigos_contratos);
		$codigos_contratos = (array_unique($codigos_contratos));
		$id_tienda = $request->id_tienda_contrato;
		$user = Auth::user()->name;
		$date = Carbon::now();
		$columnas_items = Contrato::getColumnasItems( $codigos_contratos, $id_tienda );
        $datos_columnas_items = Contrato::getDatosColumnasItems( $codigos_contratos, $id_tienda );
		$object = [];
		array_push($object, ResolucionarBL::getReportePDFOrdenGuardada($codigos_contratos, $id_tienda));
		$pdf = PDF::loadView('DocumentosPDF.perfeccionamiento', 
			[ 
				'object' => $object,
				'user' => $user,
				'date' => $date,
				'codigos_contratos' => $codigos_contratos,
				'columnas_items' => $columnas_items,
				'datos_columnas_items' => $datos_columnas_items
			]
		);
		return $pdf->download('perfeccionamiento tienda '. $object[0][0]->nombre_tienda .'.pdf');
		// return view('DocumentosPDF.perfeccionamiento', 
		// 	[ 
		// 		'object' => $object,
		// 		'user' => $user,
		// 		'date' => $date,
		// 		'codigos_contratos' => $codigos_contratos,
		// 		'columnas_items' => $columnas_items,
		// 		'datos_columnas_items' => $datos_columnas_items
		// 	]
		// );
	}
}
