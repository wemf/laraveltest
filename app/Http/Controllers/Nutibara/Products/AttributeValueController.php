<?php

namespace App\Http\Controllers\Nutibara\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Products\AdminAttributeValueBusinessLogic;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use App\AccessObject\Nutibara\Products\AdminCategoryAccessObject;
use App\AccessObject\Nutibara\Products\AdminAttributeAccessObject;
use dateFormate;

class AttributeValueController extends Controller
{
    public function index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'products/attributevalues',
				'text'=>'Gestión De Productos'
			],
			[
				'href'=>'products/attributevalues',
				'text'=>'Administrar Valores de Atributos'
			]
		);
    	return view('Products.AttributeValues.index',['urls'=>$urls]);
    }

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["attrValName"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["catName"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["attrName"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[3]['search']['value']);
		$total=AdminAttributeValueBusinessLogic::getCountAttributeValues($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(AdminAttributeValueBusinessLogic::AttributeValues($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function create(){
		$categorias = AdminCategoryAccessObject::getCategory();
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'products/attributevalues',
				'text'=>'Gestión De Productos'
			],
			[
				'href'=>'products/attributevalues',
				'text'=>'Administrar Valores de Atributos'
			],
			[
				'href' => 'products/attributevalues/create',
				'text' => 'Nuevo Valor de Atributo'
			],
		);
    	return view('Products.AttributeValues.create', ['categorias' => $categorias,'urls'=>$urls]);
    }

    public function store(request $request){
    	$this->validate($request, [
			'nombre' => [
							'required', 
							Rule::unique('tbl_prod_atributo_valores')->where(function ($query) use ($request) {
								$query->where('id_atributo', $request->attribute);
								$query->where('id_atributo_padre', $request->parentValue);
							})
						]
		]);
		$dataSaved=array();
		if(count($request->category) > 1){
			$id_atributo_padre = 0;
		}else{
			$id_atributo_padre = trim($request->parentValue);
		}

		for($i = 0; $i < count($request->category); $i++){
			$id_atributo = AdminAttributeAccessObject::getIdByNombre($request->category[$i], $request->attribute);
			$row = array(
				'nombre' => trim($request->nombre),
				'peso_igual_contrato' => ((int)($request->peso_igual_contrato) == 1) ? 0 : 1,
				'valor_defecto' => (int)($request->valor_defecto),
				'id_atributo' => $id_atributo[0]->id,
				'id_atributo_padre' => $id_atributo_padre,
				'abreviatura' => trim($request->abreviatura),
				'estado' => 1
			);
			array_push($dataSaved, $row);
		}

		$msm=AdminAttributeValueBusinessLogic::Create($dataSaved);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/products/attributevalues');
    }

    public function inactive(request $request){
		if ( !AdminAttributeValueBusinessLogic::countAttrValByParent($request->id) ) {
			$msm=AdminAttributeValueBusinessLogic::inactive($request->id);
			$a=array('msm'=>$msm);
			return response()->json($a);
		} else {
			$a=array('msm'=>['msm'=>'No se puede desactivar el valor de atributo porque tiene dependecias activas', 'val'=>false]);
			return response()->json( $a );
		}
		
	}

	public function Active(request $request){
		$msm=AdminAttributeValueBusinessLogic::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function delete(request $request){
		$msm=AdminAttributeValueBusinessLogic::delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function edit($id){
		$data=dateFormate::ToArrayInverse(AdminAttributeValueBusinessLogic::getAttributeValueById($id)->toArray());
		$attributeValue=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'products/attributevalues',
				'text'=>'Gestión De Productos'
			],
			[
				'href'=>'products/attributevalues',
				'text'=>'Administrar Valores de Atributos'
			],
			[
				'href' => 'products/attributevalues/edit/'.$id,
				'text' => 'Editar Valor de Atributo'
			],
		);
       	return view('Products.AttributeValues.edit' , ['attributeValue' => $attributeValue,'urls' => $urls]);
	}

	public function update(request $request){
		$this->validate($request, [
			'nombre' => [
							'required', 
							Rule::unique('tbl_prod_atributo_valores')->where(function ($query) use ($request) {
								$query->where('id_atributo', $request->attribute);
								$query->where('id', '<>', $request->id);
							})
						]
		]);
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'peso_igual_contrato' => ((int)($request->peso_igual_contrato) == 1) ? 0 : 1,
			'valor_defecto' => (int)($request->valor_defecto),
			'id_atributo' => trim($request->attribute),
			'id_atributo_padre' => trim($request->parentValue),
			'abreviatura' => trim($request->abreviatura),
		];

		$msm=AdminAttributeValueBusinessLogic::update($request->id,$dataSaved);
		if($msm['val']){
			Session::flash('message', $msm['msm']);
		}else{
			Session::flash('error', $msm['msm']);
		}
		return redirect('/products/attributevalues');
	}

	public function exportToExcel(){
		return AdminAttributeValueBusinessLogic::exportToExcel();
	}

	public function storeFromContr(request $request){
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'id_atributo' => trim($request->id_atributo),
			'peso_igual_contrato' => 1,
			'valor_defecto' => 0,
			'id_atributo_padre' => 0,
			'estado' => 1
		];

		$response=AdminAttributeValueBusinessLogic::storeFromContr($dataSaved);
		return response()->json($response);
    }
}
