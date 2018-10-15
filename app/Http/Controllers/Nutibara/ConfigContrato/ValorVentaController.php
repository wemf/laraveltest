<?php

namespace App\Http\Controllers\Nutibara\ConfigContrato;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use config\messages;
use dateFormate;

use App\BusinessLogic\Nutibara\ConfigContrato\ValorVentaBusinessLogic;

class ValorVentaController extends Controller
{

    public function index(){
		$medida_peso = ValorVentaBusinessLogic::getMedidaPeso();
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
				'href'=>'configcontrato/valorventa',
				'text'=>'Precio venta'
			]
		);
        return view('ConfigContrato.ValorVenta.index', ['medida_peso' => $medida_peso,'urls'=>$urls]);
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
		$total=ValorVentaBusinessLogic::getCountValorVenta($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>dateFormate::ToArrayInverse(ValorVentaBusinessLogic::ValorVenta($start,$end,$colum, $order,$search)->toArray())
		];   
		return response()->json($data);
    }

    public function create(){
		$medida_peso = ValorVentaBusinessLogic::getMedidaPeso();
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
				'href'=>'configcontrato/valorventa',
				'text'=>'Precio venta'
			],
			[
				'href' => 'configcontrato/valorventa/create',
				'text' => 'Nuevo precio venta'
			],
		);
        return view('ConfigContrato.ValorVenta.create', ['medida_peso' => $medida_peso ,  'urls'=>$urls]);
    }

    public function store(request $request){
		$dataSaved=[
			'id_categoria_general' => trim($request->categoria),
			'id_medida_peso' => trim($request->id_medida_peso),
			'valor_venta_x_1' => self::limpiarVal($request->valor_venta_x_1),
			'id_pais' => trim($request->pais),
			'id_departamento' => (trim($request->departamento) == ''?0: trim($request->departamento)),
			'id_ciudad' => (trim($request->ciudad) == ''?0: trim($request->ciudad)),
			'id_tienda' => (trim($request->tienda) == ''?0: trim($request->tienda)),
			'estado' => 1,
			'valor_compra' => self::limpiarVal($request->valor_compra),
			'costo' => self::limpiarVal($request->costo),
			'autoriza' => (int)$request->autoriza,
			'valores_especificos' => 0,
		];
		if($request->valores_atributos != null){
			$dataSaved['valores_especificos'] = 1;
		}
		if(ValorVentaBusinessLogic::validarUnico($dataSaved, $request->valores_atributos)){
			$msm=ValorVentaBusinessLogic::Create($dataSaved, $request->valores_atributos);
			if($msm['val']=='Insertado'){
				Session::flash('message', $msm['msm']);
				return redirect('/configcontrato/valorventa');
			}
			elseif($msm['val']=='Error'){
				Session::flash('error', $msm['msm']);
			}
			elseif($msm['val']=='ErrorUnico'){
				Session::flash('warning', $msm['msm']);
			}
		}else{
			Session::flash('warning', Messages::$ExectionGeneral['error_unique']);
		}
		
		return redirect()->back();
    }

    public function edit($id){
		$medida_peso = ValorVentaBusinessLogic::getMedidaPeso();
		$data=dateFormate::ToArrayInverse(ValorVentaBusinessLogic::getValorVentaById($id)->toArray());
		$valorventa=(object)$data;	
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
				'href'=>'configcontrato/valorventa',
				'text'=>'Precio venta'
			],
			[
				'href' => 'configcontrato/valorventa/edit/'.$id,
				'text' => 'Editar precio venta'
			],
		);
       	return view('ConfigContrato.ValorVenta.edit' , ['valorventa' => $valorventa, 'medida_peso' => $medida_peso, 'urls'=>$urls]);
	}

    public function update(request $request){
		$id = (int)$request->id;
		$dataSaved=[
			'id_categoria_general' => trim($request->categoria),
			'id_medida_peso' => trim($request->id_medida_peso),
			'valor_venta_x_1' => self::limpiarVal($request->valor_venta_x_1),
			'id_pais' => trim($request->pais),
			'id_departamento' => (trim($request->departamento) == ''?0: trim($request->departamento)),
			'id_ciudad' => (trim($request->ciudad) == ''?0: trim($request->ciudad)),
			'id_tienda' => (trim($request->tienda) == ''?0: trim($request->tienda)),
			'valor_compra' => self::limpiarVal($request->valor_compra),
			'costo' => self::limpiarVal($request->costo),
			'autoriza' => (int)$request->autoriza
		];

		$msm=ValorVentaBusinessLogic::update($id,$dataSaved);
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/configcontrato/valorventa');
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
		$msm=ValorVentaBusinessLogic::inactive($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function Active(request $request){
		$msm=ValorVentaBusinessLogic::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function delete(request $request){
		$msm=ValorVentaBusinessLogic::delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function getValById(request $request)
	{
		$id = $request->id;
		$datos = ValorVentaBusinessLogic::getValById($id);
		return response()->json($datos);
	}

	public function limpiarVal($val)
	{
		$valLimpiar = str_replace('.','',$val);
		$valLimpiar = str_replace(',','.',$valLimpiar);
		$valLimpiar = trim($valLimpiar);
		return $valLimpiar;
	}

}