<?php

namespace App\Http\Controllers\Nutibara\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Products\AdminReferenceBusinessLogic;
use Illuminate\Support\Facades\Session;
use dateFormate;


class ReferenceController extends Controller
{
    public function index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'products/references',
				'text'=>'Gestión De Productos'
			],
			[
				'href'=>'products/references',
				'text'=>'Administrar Catálogo de Productos'
			]
		);
    	return view('Products.References.index',['urls'=>$urls]);
    }

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data']; 
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["catName"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["refName"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$total=AdminReferenceBusinessLogic::getCountReferences($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(AdminReferenceBusinessLogic::References($start,$end,$colum, $order,$search)->toArray())
		];
		return response()->json($data);
    }

    public function getReference(Request $request){
		$msm = AdminReferenceBusinessLogic::getReference();
		return response()->json($msm);
    }

    public function getReferenceValueById(request $request) 
	{
		$response = AdminReferenceBusinessLogic::getReferenceValueById($request->id);
		return response()->json($response);
	}

    public function create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'products/references',
				'text'=>'Gestión De Productos'
			],
			[
				'href'=>'products/references',
				'text'=>'Administrar Catálogo de Productos'
			],
			[
				'href' => 'products/references/create',
				'text' => 'Nueva Referencia de Producto'
			],
		);
    	return view('Products.References.create', ['urls'=>$urls]);
    }

    public function store(request $request){
		$dataSaved=[
			'codigo' => trim($request->datareference["code"]),
			'descripcion' => trim($request->datareference["description"]),
			'vigencia_desde' => trim($request->valid_since),
			'vigencia_hasta' => trim($request->valid_until),
			'id_categoria' => trim($request->idcategory),
			'nombre' => trim($request->name_reference),
			'genera_contrato' => ($request->genera_contrato == null)?0:$request->genera_contrato,
			'genera_venta' => ($request->genera_venta == null)?0:$request->genera_venta,
			'estado' => 1
		];

		$attributes = $request->datareference["attributes"];

		$msm=AdminReferenceBusinessLogic::Create($dataSaved, $attributes);
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

    public function inactive(request $request){
		$msm=AdminReferenceBusinessLogic::inactive($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function delete(request $request){
		$msm=AdminReferenceBusinessLogic::delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=AdminReferenceBusinessLogic::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function getbyid(Request $request){
		$data = AdminReferenceBusinessLogic::getbyid($request->id_referencia);
		return response()->json($data);
	}

	public function edit( $id ) {
		$data=dateFormate::ToArrayInverse(AdminReferenceBusinessLogic::getReferenceById($id)->toArray());
		$reference=(object)$data;
		$data=dateFormate::ToArrayInverse(AdminReferenceBusinessLogic::getAttributesValuesById($id)->toArray());
		$attributes_values=(object)$data;
		$urls = array(
			[
				'href' => 'home',
				'text' => 'home'
			],
			[
				'href' => 'products/references',
				'text' => 'Gestión De Productos'
			],
			[
				'href' => 'products/references',
				'text' => 'Administrar Catálogo de Productos'
			],
			[
				'href' => 'products/references/edit/'.$id,
				'text' => 'Editar Referencia de Producto'
			]
		);
       	return view( 'Products.References.edit' , [ 'reference' => $reference, 'attributes_values' => $attributes_values, 'urls' => $urls ] );
	}

	public function update(request $request){
		$id = (int)$request->id_update;
		$dataSaved=[			
			'codigo' => trim($request->datareference["code"]),
			'descripcion' => trim($request->datareference["description"]),
			'vigencia_desde' => trim($request->valid_since),
			'vigencia_hasta' => trim($request->valid_until),
			'id_categoria' => trim($request->idcategory),
			'nombre' => trim($request->name_reference),
			'genera_contrato' => ($request->genera_contrato == null)?0:$request->genera_contrato,
			'genera_venta' => ($request->genera_venta == null)?0:$request->genera_venta,
		];
		$attributes = $request->datareference["attributes"];

		$msm=AdminReferenceBusinessLogic::update($id,$dataSaved, $attributes);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return response()->json(true);
	}
}
