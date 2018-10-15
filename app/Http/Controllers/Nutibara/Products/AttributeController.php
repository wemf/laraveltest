<?php

namespace App\Http\Controllers\Nutibara\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Products\AdminAttributeBusinessLogic;
use Illuminate\Support\Facades\Session;
use App\AccessObject\Nutibara\Products\AdminCategoryAccessObject;
use dateFormate;


class AttributeController extends Controller
{
    public function index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'products/attributes',
				'text'=>'Gestión De Productos'
			],
			[
				'href'=>'products/attributes',
				'text'=>'Administrar Atributos'
			]
		);
    	return view('Products.Attributes.index',['urls'=>$urls]);
    }

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["attrName"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["catName"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$total=AdminAttributeBusinessLogic::getCountAttributes($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(AdminAttributeBusinessLogic::Attributes($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function getAttribute(Request $request){
		$msm = AdminAttributeBusinessLogic::getAttribute();
		return response()->json($msm);
    }

    public function getAttributeValueById(request $request) 
	{
		$response = AdminAttributeBusinessLogic::getAttributeValueById($request->id);
		return response()->json($response);
	}

	public function getAttributesByCategories(request $request) 
	{
		$response = AdminAttributeBusinessLogic::getAttributesByCategories($request->categories);
		return response()->json($response);
	}

	public function getAttributeAttributesById(request $request){
		$response = AdminAttributeBusinessLogic::getAttributeAttributesById($request->id, $request->padre);
		return response()->json($response);
	}

	public function getAttributeColumnByCategory(request $request){
		$response = AdminAttributeBusinessLogic::getAttributeColumnByCategory($request->id_categoria);
		return response()->json($response);
	}

    public function create(){
		$categorias = AdminCategoryAccessObject::getCategory();
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'products/attributes',
				'text'=>'Gestión De Productos'
			],
			[
				'href'=>'products/attributes',
				'text'=>'Administrar Atributos'
			],
			[
				'href' => 'products/attributes/create',
				'text' => 'Nuevo Atributo'
			],
		);
    	return view('Products.Attributes.create', ['categorias' => $categorias,'urls'=>$urls]);
    }

    public function store(request $request){
    	$this->validate($request, [
			'name' => 'required'
		]);
		$dataSaved=array();

		if(count($request->category) > 1){
			$id_atributo_padre = 0;
		}else{
			$id_atributo_padre = trim($request->parentAttribute);
		}

		for($i = 0; $i < count($request->category); $i++){
			$row = array(
				'nombre' => trim($request->name),
				'id_cat_general' => trim($request->category[$i]),
				'id_atributo_padre' => $id_atributo_padre,
				'valor_desde_contrato' => (int)$request->valor_desde_contrato,
				'concatenar_nombre' => (int)$request->concatenar_nombre,
				'columna_independiente_contrato' => (int)$request->columna_independiente_contrato,
				'atributo_referencia' => (int)$request->atributo_referencia,
				'tiene_abreviatura' => (int)$request->tiene_abreviatura,
				'estado' => 1
			);
			array_push($dataSaved, $row);
		}

		$msm=AdminAttributeBusinessLogic::Create($dataSaved);
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/products/attributes');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
    }

    public function inactive(request $request){
		$msm=AdminAttributeBusinessLogic::inactive($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function delete(request $request){
		$msm=AdminAttributeBusinessLogic::delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=AdminAttributeBusinessLogic::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function edit($id){
		$data=dateFormate::ToArrayInverse(AdminAttributeBusinessLogic::getAttributeById($id)->toArray());
		$attribute=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'products/attributes',
				'text'=>'Gestión De Productos'
			],
			[
				'href'=>'products/attributes',
				'text'=>'Administrar Atributos'
			],
			[
				'href' => 'products/attributes/edit/'.$id,
				'text' => 'Editar Atributo'
			],
		);
       	return view('Products.Attributes.edit' , ['attribute' => $attribute,'urls' => $urls]);
	}

	public function update(request $request){
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => trim($request->name),
			'id_cat_general' => trim($request->category),
			'id_atributo_padre' => trim($request->parentAttribute),
			'valor_desde_contrato' => (int)$request->valor_desde_contrato,
			'concatenar_nombre' => (int)$request->concatenar_nombre,
			'columna_independiente_contrato' => (int)$request->columna_independiente_contrato,
			'atributo_referencia' => (int)$request->atributo_referencia,
			'tiene_abreviatura' => (int)$request->tiene_abreviatura
		];

		$msm=AdminAttributeBusinessLogic::update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/products/attributes');;
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
	}

	public function getAttributeValueUpdate(request $request){
		$response = AdminAttributeBusinessLogic::getAttributeValueUpdate($request->id);
		return response()->json($response);
	}

	public function getAttributeValueByName( request $request ){
		$response = AdminAttributeBusinessLogic::getAttributeValueByName($request->id_atributo, $request->valor);
		return response()->json($response);
	}
}
