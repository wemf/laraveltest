<?php 

namespace App\BusinessLogic\Nutibara\Inventario\Trazabilidad;

use App\AccessObject\Nutibara\Inventario\Trazabilidad\TrazabilidadAO;
use App\AccessObject\Nutibara\Contratos\Contrato;
use config\Messages;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use App\BusinessLogic\Nutibara\Tema\CrudTema;
use App\BusinessLogic\Nutibara\GestionEstado\Estado\CrudEstado;
use App\BusinessLogic\Nutibara\Inventario\InventarioBL;
use DB;
use App\Http\Middleware\userIpValidated;
use Illuminate\Support\Facades\Auth;

class TrazabilidadBL {

	public static function Get($request)
	{
		
		$select=DB::table('tbl_trazabilidad')
			->select(
				'tbl_trazabilidad.id_trazabilidad',
				'tbl_tienda.nombre as tienda',
				'tbl_trazabilidad.id_tienda as id_tienda',
				'tbl_trazabilidad.id',
				'tbl_trazabilidad.id_origen',
				'tbl_trazabilidad.movimiento',
				'tbl_trazabilidad.fecha_ingreso',
				'tbl_trazabilidad.fecha_salida',
				'tbl_trazabilidad.ubicacion',
				'tbl_trazabilidad.categoria',
				'tbl_trazabilidad.motivo',
				'tbl_trazabilidad.estado',
				'tbl_trazabilidad.numero_contrato',
				'tbl_trazabilidad.numero_item',
				'tbl_trazabilidad.numero_orden',
				'tbl_trazabilidad.numero_referente',
				'tbl_usuario.name as usuario_registro'
			)
			->leftJoin('tbl_tienda','tbl_tienda.id','=','tbl_trazabilidad.id_tienda')
			->leftJoin('tbl_usuario','tbl_usuario.id','=','tbl_trazabilidad.usuario_registro')
			->orderBy('tbl_trazabilidad.fecha_ingreso', 'DESC');
		$search = array();
		$where = array();
		if($request->columns[3]["search"]["value"] != null){
			array_push($where, [
				'field' => 'tbl_trazabilidad.id_tienda',
				'method' => '=', 
				'typeWhere' => 'where',
				'value' => ($request->columns[3]["search"]["value"]), 
			]);
			/*array_push($search, [
				'tableName' => 'tbl_trazabilidad',
				'field' => 'id_tienda',
				'method' => '=',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			]);*/
		}
		if($request->columns[4]["search"]["value"] != null){
			array_push($where, [
				'field' => 'tbl_trazabilidad.id',
				'method' => '=', 
				'typeWhere' => 'where',
				'value' => ($request->columns[4]["search"]["value"]), 
			]);
			/*array_push($search, [
				'tableName' => 'tbl_trazabilidad',
				'field' => 'id',
				'method' => '=',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			]);*/
		}
		if($request->columns[5]["search"]["value"] != null){
			array_push($where, [
				'field' => 'tbl_trazabilidad.movimiento',
				'method' => 'like',
				'typeWhere' => 'where',
				'value' => '%'.($request->columns[5]["search"]["value"]).'%',
			]);
			/*array_push($search, [
				'tableName' => 'tbl_trazabilidad',
				'field' => 'movimiento',
				'method' => 'like',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			]);*/
		}
		if($request->columns[6]["search"]["value"] != null){
			array_push($where, [
				'field' => 'tbl_trazabilidad.fecha_ingreso',
				'method' => 'like',
				'typeWhere' => 'where',
				'value' => '%'.($request->columns[6]["search"]["value"]).'%',
			]);
			/*array_push($search, [
				'tableName' => 'tbl_trazabilidad',
				'field' => 'fecha_ingreso',
				'method' => '=',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			]);*/
		}
		if($request->columns[7]["search"]["value"] != null){
			array_push($where, [
				'field' => 'tbl_trazabilidad.fecha_salida',
				'method' => 'like',
				'typeWhere' => 'where',
				'value' => '%'.($request->columns[7]["search"]["value"]).'%',
			]);
			/*array_push($search, [
				'tableName' => 'tbl_trazabilidad',
				'field' => 'fecha_salida',
				'method' => '=',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			]);*/
		}
		if($request->columns[8]["search"]["value"] != null){
			array_push($where, [
				'field' => 'tbl_trazabilidad.ubicacion',
				'method' => 'like',
				'typeWhere' => 'where',
				'value' => '%'.($request->columns[8]["search"]["value"]).'%',
			]);
			/*array_push($search, [
				'tableName' => 'tbl_trazabilidad',
				'field' => 'ubicacion',
				'method' => '=',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			]);*/
		}
		if($request->columns[9]["search"]["value"] != null){
			array_push($where, [
				'field' => 'tbl_trazabilidad.categoria',
				'method' => 'like',
				'typeWhere' => 'where',
				'value' => '%'.($request->columns[9]["search"]["value"]).'%',
			]);
			/*array_push($search, [
				'tableName' => 'tbl_trazabilidad',
				'field' => 'categoria',
				'method' => '=',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			]);*/
		}
		if($request->columns[10]["search"]["value"] != null){
			array_push($where, [
				'field' => 'tbl_trazabilidad.motivo',
				'method' => 'like',
				'typeWhere' => 'where',
				'value' => '%'.($request->columns[10]["search"]["value"]).'%',
			]);
			/*array_push($search, [
				'tableName' => 'tbl_trazabilidad',
				'field' => 'motivo',
				'method' => '=',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			]);*/
		}
		$table=new DatatableBL($select,$search,$where);
		return $table->Run($request);
	}

	public static function Create($traza)
    {
		$response=['msm'=>Messages::$Trazabilidad['ok'],'val'=>true];
		// obtener información de la tienda
		$ipValidation = new userIpValidated();
		$Tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());	
		$id=(int)TrazabilidadAO::getCountTrazabilidad()+1;
		
		// obtener nombre módulo que llama
		/*$currentAction = \Route::currentRouteAction();
		list($controller, $method) = explode('@', $currentAction);
		$controller = preg_replace('/.*\\\/', '', $controller);
		$controller = str_replace('Controller', '', $controller);*/
		
		$tema=CrudTema::getTemaById($traza['trazabilidad']['movimiento']);
		$estado=CrudEstado::getEstadoById($traza['trazabilidad']['estado']);
		$categoria=InventarioBL::FindInventario($traza['trazabilidad']['id']);

		if((int)$id>0){
			$traza['trazabilidad']['id_trazabilidad']=$id;
			$traza['trazabilidad']['id_tienda']=($traza['trazabilidad']['id_tienda']!=null?$traza['trazabilidad']['id_tienda']:$Tienda->id);
			$traza['trazabilidad']['movimiento']=($tema!=null?$tema->nombre:null);
			$traza['trazabilidad']['estado']=($estado!=null?$estado->nombre:null);
			$traza['trazabilidad']['categoria']=($categoria!=null?$categoria->nombre:null);
			$traza['trazabilidad']['fecha_registro']=date("Y-m-d H:m:s");
			$traza['trazabilidad']['usuario_registro']=Auth::user()->id;
			if(!TrazabilidadAO::Create($traza))
				$response=['msm'=>Messages::$Trazabilidad['error'],'val'=>false];
		}else
			$response=['msm'=>Messages::$Trazabilidad['error_secuencia'],'val'=>false];
	}

}