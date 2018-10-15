<?php

namespace App\Http\Controllers\Nutibara\ConfigContrato;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use dateFormate;

use App\BusinessLogic\Nutibara\ConfigContrato\ItemContratoBusinessLogic;

class ItemContratoController extends Controller
{

    public function index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'configcontrato/itemcontrato',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'configcontrato/itemcontrato',
				'text'=>'Configuración de Contrato'
			],
			[
				'href'=>'configcontrato/itemcontrato',
				'text'=>'Configuración de Items para Contrato'
			]
		);
		return view('ConfigContrato.ItemContrato.index',['urls'=>$urls]);
    }

    public function get(request $request){
        $start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["categoria"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["estado"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$total=ItemContratoBusinessLogic::getCountItemContrato($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(ItemContratoBusinessLogic::ItemContrato($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

	public function getByCategoria(request $request){
		$id=$request->id;  
		$data=ItemContratoBusinessLogic::getItemContratoByCategoria($id);
		return response()->json($data);
	}

	public function getAtributosEdit( request $request ){
		$id = $request->id;
		$data=ItemContratoBusinessLogic::getAtributosEdit($id);
		return response()->json($data);
	}

	public function getAtributosContrato( request $request ){
		$categoria = $request->id;
		$data = ItemContratoBusinessLogic::getAtributosContrato($categoria);
		return response()->json($data);
	}

	public function getAtributosHijosContrato( request $request ){
		$data = ItemContratoBusinessLogic::getAtributosHijosContrato($request->id, $request->padre);
		return response()->json($data);
	}

    public function create(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'configcontrato/itemcontrato',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'configcontrato/itemcontrato',
				'text'=>'Configuración de Contrato'
			],
			[
				'href'=>'configcontrato/itemcontrato',
				'text'=>'Configuración de Items para Contrato'
			],
			[
				'href' => 'configcontrato/itemcontrato/create',
				'text' => 'Nueva Configuración de Items para Contrato'
			],
		);
		return view('ConfigContrato.ItemContrato.create',['urls'=>$urls]);
    }

    public function store(request $request){
		// $this->validate($request, [
		// 	'nombre' => 'unique:tbl_contr_item'
		// ]);
		if(trim($request->categoria) == null){
			$msm=['msm'=>'Seleccione una categoría para continuar','val'=>false];
		}else{
			$dataSaved=[
				'id_categoria_general' => trim($request->categoria),
				// 'nombre' => trim($request->nombre),
				'estado' => 1
			];
			$id_item=ItemContratoBusinessLogic::Create($dataSaved, "tbl_contr_item");
			
			$itemconfig = array();
			$id_atributo = $request->atributos;
			$posicion = $request->posiciones;
			$requerido = $request->requeridos;
			try{
				foreach ($id_atributo as $key => $value) {
					$itemconfig[$key]['id_item'] = $id_item;
					$itemconfig[$key]['id_atributo'] = $id_atributo[$key];
					$itemconfig[$key]['orden_posicion'] = $posicion[$key];
					$itemconfig[$key]['obligatorio'] = (int)$requerido[$key];
				}
				$msm=ItemContratoBusinessLogic::Create($itemconfig, "tbl_contr_item_config");
			}catch(\Exception $ex){
				$msm=['msm'=>'Debe seleccionar por lo menos un atributo','val'=>false];
			}
	
			
		}
		
		return response()->json($msm);
    }

    public function edit($id){
		$data=ItemContratoBusinessLogic::getItemContratoById($id);
		$itemcontrato=(object)$data;
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'configcontrato/itemcontrato',
				'text'=>'Gestión de Contrato'
			],
			[
				'href'=>'configcontrato/itemcontrato',
				'text'=>'Configuración de Contrato'
			],
			[
				'href'=>'configcontrato/itemcontrato',
				'text'=>'Configuración de Items para Contrato'
			],
			[
				'href' => 'configcontrato/itemcontrato/edit/'.$id,
				'text' => 'Editar configuración de Items para Contrato'
			],
		);
		return view('ConfigContrato.ItemContrato.edit',['itemcontrato' => $itemcontrato,'urls'=>$urls]);
	}

    public function update(request $request){
		$id = (int)$request->id;
		$dataSaved=[
			'id_categoria_general' => trim($request->categoria),
			// 'nombre' => trim($request->nombre)
		];
		$id_item=ItemContratoBusinessLogic::update($id, $dataSaved);
		
		$itemconfig = array();
		$id_atributo = $request->atributos;
		$posicion = $request->posiciones;
		$requerido = $request->requeridos;
		try{
			foreach ($id_atributo as $key => $value) {
				$itemconfig[$key]['id_item'] = $id;
				$itemconfig[$key]['id_atributo'] = $id_atributo[$key];
				$itemconfig[$key]['orden_posicion'] = $posicion[$key];
				$itemconfig[$key]['obligatorio'] = (int)$requerido[$key];
			}
		}catch(\Exception $ex){

		}

		$msm=ItemContratoBusinessLogic::Create($itemconfig, "tbl_contr_item_config");
		return response()->json($msm);
	}

    public function inactive(request $request){
		$msm=ItemContratoBusinessLogic::inactive($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=ItemContratoBusinessLogic::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function delete(request $request){
		$msm=ItemContratoBusinessLogic::delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

}