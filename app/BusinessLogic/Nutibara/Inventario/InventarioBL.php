<?php 

namespace App\BusinessLogic\Nutibara\Inventario;
use App\AccessObject\Nutibara\Inventario\InventarioAO;
use config\Messages;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use DB;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\BusinessLogic\Utility\CleanNumberMoney;

class InventarioBL {

	public static function Get($request)
	{
		$select=DB::table('tbl_inventario_producto')
				->select(
					'tbl_inventario_producto.id_inventario AS DT_RowId',
					'tbl_tienda.nombre AS tienda',
					DB::raw("FORMAT(tbl_inventario_producto.precio_venta,0,'de_DE') as precio_venta"),
					DB::raw("FORMAT(tbl_inventario_producto.precio_compra,0,'de_DE') as precio_compra"),
					DB::raw("FORMAT(tbl_inventario_producto.costo_total,0,'de_DE') as costo_total"),
					DB::raw("IF(tbl_inventario_producto.es_nuevo=1, 'Nuevo', 'Usado') AS es_nuevo"),
					'tbl_inventario_producto.cantidad',
					'tbl_inventario_producto.peso',
					'tbl_inventario_producto.fecha_ingreso',
					'tbl_inventario_producto.fecha_salida',
					'tbl_sys_estado_tema.nombre AS estado',
					'tbl_sys_motivo.nombre AS motivo',
					'tbl_prod_catalogo.nombre AS referencia',					
					'tbl_prod_categoria_general.nombre AS categoria_general',
					'tbl_inventario_producto.lote'
				)
				->leftJoin('tbl_tienda','tbl_tienda.id','=','tbl_inventario_producto.id_tienda_inventario')		
				->leftJoin('tbl_ciudad','tbl_ciudad.id','=','tbl_tienda.id_ciudad')	
				->leftJoin('tbl_departamento','tbl_departamento.id','=','tbl_ciudad.id_departamento')	
				->leftJoin('tbl_pais','tbl_pais.id','=','tbl_departamento.id_pais')
				->leftJoin('tbl_sys_estado_tema','tbl_sys_estado_tema.id','=','tbl_inventario_producto.id_estado_producto')				
				->leftJoin('tbl_sys_motivo','tbl_sys_motivo.id','=','tbl_inventario_producto.id_motivo_producto')	
				->leftJoin('tbl_prod_catalogo','tbl_prod_catalogo.id','=','tbl_inventario_producto.id_catalogo_producto')			
				->leftJoin('tbl_prod_categoria_general','tbl_prod_categoria_general.id','=','tbl_prod_catalogo.id_categoria');			
		
		$search = array(
			[
				'tableName' => 'tbl_pais', //tabla de busqueda 
				'field' => 'id', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],
			[
				'tableName' => 'tbl_departamento', //tabla de busqueda 
				'field' => 'id', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],
			[
				'tableName' => 'tbl_ciudad', //tabla de busqueda 
				'field' => 'id', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],
			[
				'tableName' => 'tbl_tienda', //tabla de busqueda 
				'field' => 'id', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],	
			[
				'tableName' => 'tbl_inventario_producto', //tabla de busqueda 
				'field' => 'lote', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],
			[
				'tableName' => 'tbl_prod_categoria_general', //tabla de busqueda 
				'field' => 'nombre', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],
			[
				'tableName' => 'tbl_prod_catalogo', //tabla de busqueda 
				'field' => 'nombre', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],
			[
				'tableName' => 'tbl_inventario_producto', //tabla de busqueda 
				'field' => 'fecha_ingreso', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],
			[
				'tableName' => 'tbl_inventario_producto', //tabla de busqueda 
				'field' => 'fecha_salida', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],
			[
				'tableName' => 'tbl_sys_estado_tema', //tabla de busqueda 
				'field' => 'id', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			]
		);
		$where = array();
		$table=new DatatableBL($select,$search,$where);
		return $table->Run($request);
	}

    public static function GetReference($request)
    {	
		if($request->data=='null'){
			$response = InventarioAO::GetReferenceAll();
		}else{
			$response = InventarioAO::GetReferenceByValue($request->data);
		}
		return $response;
	}

	public static function GetDescriptionById($id)
	{
		return InventarioAO::GetDescriptionById($id);
	}

	public static function GetEstado()
	{
		return InventarioAO::GetEstado();
	}

	public static function IsLote($lote)
	{
		return InventarioAO::IsLote($lote);
	}

	public static function Create($request)
    {
		$response=['msm'=>Messages::$Inventario['ok'],'val'=>true];					
		$id=SecuenciaTienda::getCodigosSecuencia($request['producto']['id_tienda_inventario'],4,1)[0]->response;
		if((int)$id>0){
			$request['producto']['id_inventario']=$id;
			$request['producto']['fecha_ingreso']=date("Y-m-d");
			$request['producto']['precio_venta']=CleanNumberMoney::Get($request['producto']['precio_venta']);
			$request['producto']['precio_compra']=CleanNumberMoney::Get($request['producto']['precio_compra']);
			$request['producto']['costo_total']=CleanNumberMoney::Get($request['producto']['costo_total']);
			
			$request['compra']['lote']=$request['producto']['lote'];
			$request['compra']['id_tienda']=$request['producto']['id_tienda_inventario'];
			$request['compra']['costo_devolucion']=CleanNumberMoney::Get($request['compra']['costo_devolucion']);
			$request['compra']['costo_compra']=CleanNumberMoney::Get($request['compra']['costo_compra']);
			$request['compra']['costo_traslado_entrada']=CleanNumberMoney::Get($request['compra']['costo_traslado_entrada']);

			if($request['producto']['origen']>1){
				//Ingreso por orden de compra
				$request['producto']['id_estado_producto']=79;
				$request['producto']['id_motivo_producto']=29;
			}else{
				//Ingreso por plan separe
				$request['producto']['id_estado_producto']=99;
				$request['producto']['id_motivo_producto']=42;
			}
			unset($request['producto']['origen']);
			if(!InventarioAO::Create($request))
				$response=['msm'=>Messages::$Inventario['error'],'val'=>false];	
		}else
			$response=['msm'=>Messages::$Inventario['error_secuencia'],'val'=>false];	

		return $response;
	}

	public static function FindInventario($id)
	{
		return InventarioAO::FindInventario($id);
	}

	public static function Update($request)
    {
		$response=['msm'=>Messages::$Inventario['ok_update'],'val'=>true];
		$request['producto']['precio_venta']=CleanNumberMoney::Get($request['producto']['precio_venta']);
		if(!InventarioAO::Update($request))
			$response=['msm'=>Messages::$Inventario['error_update'],'val'=>false];	
		return $response;
	}
	
}