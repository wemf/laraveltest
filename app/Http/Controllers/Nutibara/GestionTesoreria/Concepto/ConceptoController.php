<?php

namespace App\Http\Controllers\Nutibara\GestionTesoreria\Concepto;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\GestionTesoreria\Concepto\CrudConcepto;
use Illuminate\Support\Facades\Session;
use dateFormate;


class ConceptoController extends Controller
{
    public function Index(){ 
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tesoreria/concepto',
				'text'=>'Gestión De Contabilidad'
			],
			[
				'href'=>'tesoreria/concepto',
				'text'=>'Gestion De Tesoreria'
			],
			[
				'href'=>'tesoreria/concepto',
				'text'=>'Concepto'
			]
		);
		return view('GestionTesoreria.Concepto.index',['urls'=>$urls]);
    }

	public function get(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["id_pais"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["codigo"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["nombre"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[3]['search']['value']);
		$total=CrudConcepto::getCountConcepto($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(CrudConcepto::Concepto($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function Create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tesoreria/concepto',
				'text'=>'Gestión De Contabilidad'
			],
			[
				'href'=>'tesoreria/concepto',
				'text'=>'Gestion De Tesoreria'
			],
			[
				'href'=>'tesoreria/concepto',
				'text'=>'Concepto'
			],
			[
				'href' => 'tesoreria/concepto',
				'text' => 'Crear Concepto'
			],
		);
		return view('GestionTesoreria.Concepto.create',['urls'=>$urls]);
    }

    public function CreatePost(request $request){
		
		$data=[
			'id_tipo_documento_contable' => trim($request->id_tipo_documento_contable),			
			'id_pais' => (int)$request->id_pais,
			'codigo' => (int)$request->concepto,						
			'nombre' => trim($request->nombre),
			'naturaleza' => $request->naturaleza,
			'id_contracuenta' => $request->id_contracuenta,
			'impuesto' => 0,
			'estado' => 1,
		];
		$msm=CrudConcepto::Create($data, $request->asociaciones);
		$a=array('msm'=>$msm);
		return response()->json($a);
    }

    public function Delete(request $request){
		$msm=CrudConcepto::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	public function Active(request $request){
		$msm=CrudConcepto::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Update($id){
		$data=dateFormate::ToArrayInverse(CrudConcepto::getConceptoById($id)->toArray());
		$data=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'tesoreria/concepto',
				'text'=>'Gestión De Contabilidad'
			],
			[
				'href'=>'tesoreria/concepto',
				'text'=>'Gestion De Tesoreria'
			],
			[
				'href'=>'tesoreria/concepto',
				'text'=>'Concepto'
			],
			[
				'href' => 'tesoreria/concepto/update/'.$data->id,
				'text' => 'Actualizar Concepto'
			]
		);
		return view('GestionTesoreria.Concepto.update',['attribute' => $data,'urls'=>$urls]);
	}

	public function ActualizarImpuestoConcepto(Request $request){
		$id_concepto = (int)$request->id;
		$dataSaved=[
			'id_tipo_documento_contable' => $request->id_tipo_documento_contable,
			'nombre' => trim($request->nombre),
			'naturaleza' => $request->naturaleza,
			'id_contracuenta' => $request->id_contracuenta,
			'impuesto' => 0,
		];
		$msm = CrudConcepto::ActualizarImpuestoConcepto($id_concepto,$request->asociaciones,$dataSaved);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	
	public function ImpuestoConcepto(Request $request){
		$id_concepto = $request->id;
		$objetoImpuestos = CrudConcepto::ImpuestoConcepto($id_concepto);
		return response()->json($objetoImpuestos);
	}
	
	public function getSelectListImpuesto()
	{
		$msm = CrudConcepto::getSelectListImpuesto();
		return  response()->json($msm);
	}

	public function getSelectListTipoDocumentoContable()
	{
		$msm = CrudConcepto::getSelectListTipoDocumentoContable();
		return  response()->json($msm);
	}

	public function getSelectListCodigo(request $request)
	{
		$msm = CrudConcepto::getSelectListCodigo($request->id);
		return  response()->json($msm);
	}

	public function getSelectListNombre(request $request)
	{
		$msm = CrudConcepto::getSelectListNombre($request->id);
		return  response()->json($msm);
	}

}
