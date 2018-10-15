<?php

namespace App\Http\Controllers\Nutibara\Products;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\Products\AdminCategoryBusinessLogic;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use dateFormate;


class CategoryController extends Controller
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
				'href'=>'products/categories',
				'text'=>'Administrar Categorías'
			]
		);
    	return view('Products.Categories.index',['urls'=>$urls]);
    }

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$vowels = array("$", "^");
		$search["catName"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$total=AdminCategoryBusinessLogic::getCountCategories($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(AdminCategoryBusinessLogic::Categories($start,$end,$colum, $order,$search)->toArray())
		];
		return response()->json($data);
    }

    public function getCategory(){
    	$msm = AdminCategoryBusinessLogic::getCategory();
		return response()->json($msm);
	}
	
	public function getCategoryNullItem(){
    	$msm = AdminCategoryBusinessLogic::getCategoryNullItem();
		return response()->json($msm);
    }

    public function getAttributeCategoryById(request $request) 
	{
		$response = AdminCategoryBusinessLogic::getAttributeCategoryById($request->id);
		return response()->json($response);
	}

	public function getFirstAttributeCategoryById(request $request) 
	{
		$response = AdminCategoryBusinessLogic::getFirstAttributeCategoryById($request->id);
		return response()->json($response);
	}

	public function create(){
		$medida = AdminCategoryBusinessLogic::getMedida();
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
				'href'=>'products/categories',
				'text'=>'Administrar Categorías'
			],
			[
				'href' => 'products/categories/create',
				'text' => 'Nueva Categoría'
			],
		);
		return view('Products.Categories.create',['medida' => $medida,'urls' => $urls]);
	}

    public function store(request $request){
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'id_medida_peso' => trim($request->id_medida_peso),
			'vigencia_desde' => trim($request->valid_since),
			'vigencia_hasta' => trim($request->valid_until),
			'aplica_refaccion' => (int)($request->aplica_refaccion),
			'aplica_vitrina' => (int)($request->aplica_vitrina),
			'aplica_fundicion' => (int)($request->aplica_fundicion),
			'aplica_joya_preciosa' => (int)($request->aplica_joya),
			'aplica_maquila' => (int)($request->aplica_maquila),
			'aplica_bolsa' => (int)($request->aplica_bolsa),
			'se_fabrica' => (int)($request->se_fabrica),
			'control_peso_contrato' => (int)($request->control_peso_contrato),
			'estado' => 1
		];

		if( AdminCategoryBusinessLogic::validateUnique( $dataSaved ) ) {
			$msm=AdminCategoryBusinessLogic::Create($dataSaved);
			if($msm['val']=='Insertado'){
				Session::flash('message', $msm['msm']);
				return redirect('/products/categories');		
			}
			elseif($msm['val']=='Error'){
				Session::flash('error', $msm['msm']);
			}
			elseif($msm['val']=='ErrorUnico'){
				Session::flash('warning', $msm['msm']);
			}
		} else {
			Session::flash('warning', 'Ya existe una categoría con configuración de vigencia similar');
		}
		return redirect()->back();
    }

	public function inactive(request $request){
		$msm=AdminCategoryBusinessLogic::inactive($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function delete(request $request){
		$msm=AdminCategoryBusinessLogic::delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=AdminCategoryBusinessLogic::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function edit($id){
		$data=dateFormate::ToArrayInverse(AdminCategoryBusinessLogic::getCategoryById($id)->toArray());
		$category=(object)$data;
		$medida = AdminCategoryBusinessLogic::getMedida();
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
				'href'=>'products/categories',
				'text'=>'Administrar Categorías'
			],
			[
				'href' => 'products/categories/edit/'.$category->id,
				'text' => 'Editar Categoría'
			],
		);
       	return view('Products.Categories.edit' , ['category' => $category,'medida' => $medida,'urls' => $urls]);
	}

	public function update(request $request){
		$id = (int)$request->id;
		$dataSaved=[
			'nombre' => trim($request->nombre),
			'id_medida_peso' => trim($request->id_medida_peso),
			'vigencia_desde' => trim($request->valid_since),
			'vigencia_hasta' => trim($request->valid_until),
			'aplica_refaccion' => (int)$request->aplica_refaccion,
			'aplica_vitrina' => (int)$request->aplica_vitrina,
			'aplica_fundicion' => (int)$request->aplica_fundicion,
			'aplica_joya_preciosa' => (int)$request->aplica_joya,
			'aplica_maquila' => (int)$request->aplica_maquila,
			'aplica_bolsa' => (int)($request->aplica_bolsa),
			'se_fabrica' => (int)($request->se_fabrica),
			'control_peso_contrato' => (int)($request->control_peso_contrato),
		];
		
		if( AdminCategoryBusinessLogic::validateUnique( $dataSaved, $id ) ) {
			$msm=AdminCategoryBusinessLogic::update($id,$dataSaved);
			if($msm['val']=='Actualizado'){
				Session::flash('message', $msm['msm']);		
				return redirect('/products/categories');
			}
			elseif($msm['val']=='Error'){
				Session::flash('error', $msm['msm']);
			}
			elseif($msm['val']=='ErrorUnico'){
				Session::flash('warning', $msm['msm']);
			}
		} else {
			Session::flash('warning', 'Ya existe una categoría con configuración de vigencia similar');
		}
		return redirect()->back();
	}
}
