<?php

namespace App\Http\Controllers\Nutibara\GestionTesoreria\ConfiguracionContable;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\GestionTesoreria\ConfiguracionContable\CrudConfiguracionContable;
use Illuminate\Support\Facades\Session;


class ConfiguracionContableController extends Controller
{
    public function Index(){
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contabilidad/configuracioncontable',
				'text'=>'Gestión de Contabilidad'
			],
			[
				'href'=>'contabilidad/configuracioncontable',
				'text'=>'Configuración Contable'
			]
		);
		return view('GestionTesoreria.ConfiguracionContable.index',['urls'=>$urls]);
    }

	public function get(Request $request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["id_tipo_documento_contable"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
		$search["nombre"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["nombreproducto"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
		$total=CrudConfiguracionContable::getCountConfiguracionContable($search);
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>CrudConfiguracionContable::ConfiguracionContable($start,$end,$colum, $order,$search)
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
				'href'=>'contabilidad/configuracioncontable',
				'text'=>'Gestión de Contabilidad'
			],
			[
				'href'=>'contabilidad/configuracioncontable',
				'text'=>'Configuración Contable'
			],
			[
				'href' => 'contabilidad/configuracioncontable/create',
				'text' => 'Crear Configuración Contable'
			],
		);
		return view('GestionTesoreria.ConfiguracionContable.create',['urls'=>$urls]);
    }

    public function Delete(request $request){
		$msm=CrudConfiguracionContable::Delete($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}
	public function Active(request $request){
		$msm=CrudConfiguracionContable::Active($request->id);
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function View($id){
		$data=CrudConfiguracionContable::getConfiguracionContableById($id);
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contabilidad/configuracioncontable',
				'text'=>'Gestión de Contabilidad'
			],
			[
				'href'=>'contabilidad/configuracioncontable',
				'text'=>'Configuración Contable'
			],
			[
				'href' => 'contabilidad/configuracioncontable/update/'.$id,
				'text' => 'Ver Configuración Contable'
			]
		);
		return view('GestionTesoreria.ConfiguracionContable.view',['configuracioncontable' => $data['configuracioncontable'],
																	'movimientos' => $data['movimientos'],
																	'impuestos' => $data['impuestos'],
																	'urls'=>$urls]);
	}

	public function Update($id){
		$data=CrudConfiguracionContable::getConfiguracionContableById($id);
		//dd($data);
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'contabilidad/configuracioncontable',
				'text'=>'Gestión de Contabilidad'
			],
			[
				'href'=>'contabilidad/configuracioncontable',
				'text'=>'Configuración Contable'
			],
			[
				'href' => 'contabilidad/configuracioncontable/update/'.$id,
				'text' => 'Actualizar Configuración Contable'
			]
		);
		return view('GestionTesoreria.ConfiguracionContable.update',['configuracioncontable' => $data['configuracioncontable'],
																	'movimientos' => $data['movimientos'],
																	'impuestos' => $data['impuestos'],
																	'urls'=>$urls]);
	}

	public function UpdatePost(request $request){
		$id = $request->idconfiguracion;

		$datosGenerales=[
			'id_tipo_documento_contable' => $request->id_tipo_documento_contable,
			'nombre' => $request->nombre,
			'atributos' => $request->valores_atributos_principal,
			'nombreproducto' => $request->producto,
			'id_categoria' => $request->category,			
			'id_subclase' => $request->id_subclase,
			'es_borrable' => $request->es_borrable
		];

		$movimientos =
		[
			'id' => $request->id,
			'cod_puc' => $request->cod_puc,
			'id_naturaleza' => $request->id_naturaleza,
			'descripcion' => $request->descripcion,
			'tienetercero' => $request->tienetercero,
			'nombre_cliente' => $request->terceros,
			'id_cliente' => $request->cod_tercero,
			'id_tienda' => $request->cod_tienda_tercero,
		];

		$impuestos =[
			'id' => $request->idImpuesto,
			'descripcion' => $request->impuesto_nombre,
			'id_cod_puc' => $request->select_puc_impuesto,
			'porcentaje' => $request->porcentaje_impuesto,
			'naturaleza' => $request->id_naturaleza_impuesto,
		];

		$msm=CrudConfiguracionContable::Update($id,$datosGenerales,$movimientos,$impuestos);
		
		if($msm['val']=='Actualizado'){
			Session::flash('message', $msm['msm']);
			return redirect('/contabilidad/configuracioncontable');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
		
	}

	public function CreatePost(request $request)
	{
		$datosGenerales=[
			'id_tipo_documento_contable' => $request->id_tipo_documento_contable,
			'nombre' => $request->nombre,
			'atributos' => $request->valores_atributos_principal,
			'nombreproducto' => $request->producto,
			'id_categoria' => $request->category,
			'id_subclase' => $request->id_subclase,
			'es_borrable' => 1
		];

		$movimientos =
		[
			'cod_puc' => $request->cod_puc,
			'id_naturaleza' => $request->id_naturaleza,
			'descripcion' => $request->descripcion,
			'tienetercero' => $request->tienetercero,
			'nombre_cliente' => $request->terceros,
			'id_cliente' => $request->cod_tercero,
			'id_tienda' => $request->cod_tienda_tercero,
		];

		$impuestos =[
			'descripcion' => $request->impuesto_nombre,
			'id_cod_puc' => $request->select_puc_impuesto,
			'porcentaje' => $request->porcentaje_impuesto,
			'naturaleza' => $request->id_naturaleza_impuesto,
		];
		$msm=CrudConfiguracionContable::Create($datosGenerales,$movimientos,$impuestos);
		
		if($msm['val']=='Insertado'){
			Session::flash('message', $msm['msm']);
			return redirect('/contabilidad/configuracioncontable');
		}
		elseif($msm['val']=='Error'){
			Session::flash('error', $msm['msm']);
		}
		elseif($msm['val']=='ErrorUnico'){
			Session::flash('warning', $msm['msm']);
		}
		return redirect()->back();
		
	}

	public function getPuc(request $request)
	{
		$response = CrudConfiguracionContable::getPuc($request->busqueda);
		return response()->json($response);
	}

	public function getPucImp(request $request)
	{
		$response = CrudConfiguracionContable::getPucImp($request->busqueda);
		return response()->json($response);
	}

	public function getProveedores(request $request)
	{
		$response = CrudConfiguracionContable::getProveedores($request->busqueda);
		return response()->json($response);
	}

	public function getSelectListClase()
	{
		$msm = CrudConfiguracionContable::getSelectListClase();
		return  response()->json($msm);
	}

	public function getSelectListSubClase()
	{
		$msm = CrudConfiguracionContable::getSelectListSubClase();
		return  response()->json($msm);
	}

	public function getSelectListSubclaseByClase(request $request)
	{
		$msm = CrudConfiguracionContable::getSelectListSubclaseByClase($request->id);
		return  response()->json($msm);
	}

	public function getSelectListClaseBySubclase(request $request)
	{
		$msm = CrudConfiguracionContable::getSelectListClaseBySubclase($request->id);
		return  response()->json($msm);
	}

	public function ValidarBorrable(request $request)
	{
		$msm = CrudConfiguracionContable::ValidarBorrable($request->id);
		return response()->json($msm);
	}

	public function ValidarRepetido(request $request)
	{
		$msm = CrudConfiguracionContable::ValidarRepetido($request->producto,$request->id_tipo_documento_contable,$request->id_sub_clase,$request->id_categoria);
		return response()->json($msm);
	}

	public function selectlistByIdTipoDocumento(request $request)
	{
		$msm = CrudConfiguracionContable::selectlistByIdTipoDocumento($request->id);
		return  response()->json($msm);
	}

	public function selectlistMovimientosContablesById(request $request)
	{
		$msm = CrudConfiguracionContable::selectlistMovimientosContablesById($request->id);
		return  response()->json($msm);
	}

	public function getcxc(request $request)
	{
		$msm = CrudConfiguracionContable::getcxc($request->id);
		return  response()->json($msm);
	}

	public function getImpuestosXConfiguracion(request $request)
	{
		$msm = CrudConfiguracionContable::getImpuestosXConfiguracion($request->id);
		return response()->json($msm);
	}
}
