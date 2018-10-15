<?php 

namespace App\BusinessLogic\Nutibara\Cotizacion;
use App\AccessObject\Nutibara\Cotizacion\CotizacionAO;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use config\messages;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use App\BusinessLogic\Notificacion\PlanSepare as planSepareMensaje;


class CotizacionBL {

    public static function get($request)
    {
		$select = CotizacionAO::get();
		$search = array(
			[
				'tableName' => 'tbl_plan_cotizacion',
				'field' => 'estado',
				'method' => '=',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			]
		);
		$where = array(
			[
				'field' => 'tbl_plan_cotizacion.estado', 
				'method' => '=', 
				'typeWhere' => 'where',
				'value' => 1, 
			]
		);
		$table=new DatatableBL($select,$search,$where);
		return $table->Run($request);
    }
	
	public static function store($data,$id_tienda,$id_usuario,$id_cotizacion){
		$result = CotizacionAO::store($data,$id_tienda,$id_usuario,$id_cotizacion);
		$dataSaved = [
			'codigo_plan' => $id_cotizacion,
			'id_tienda' => $id_tienda,
			'idRemitente' => $id_usuario,
			'codigo_abono' => null
		];
		
		if(!$result)
        {
			$msm=['msm'=>Messages::$GenerarPlan['error_cotizacion'],'val'=>False];
		}
		else
		{
			$msm=['msm'=>Messages::$GenerarPlan['ok_cotizacion'],'val'=>true];
			$planSepareMensaje =new planSepareMensaje((object)$dataSaved);
			try{
				$mensaje=$planSepareMensaje->Cotizacion();
			}catch(\Exception $e){
				$msm=['msm'=>Messages::$GenerarPlan['ok_cotizacion'].' '.$e->getMessage(),'val'=>true];
			}
		}
		return $msm;
    }
    
    public static function cotizacionById($id_tienda,$id_cotizacion)
    {
        return CotizacionAO::cotizacionById($id_tienda,$id_cotizacion);
    }

    public static function storeUpdate($request){
		// dd($request);
		$result = CotizacionAO::storeUpdate($request);
		$dataSaved = [
			'codigo_plan' => $request->id_cotizacion,
			'id_tienda' => $request->id_tienda,
			'idRemitente' => $request->id_usuario,
			'codigo_abono' => null
		];
		
		if(!$result)
        {
			$msm=['msm'=>Messages::$GenerarPlan['error_cotizacion'],'val'=>False];
		}
		else
		{
			$msm=['msm'=>Messages::$GenerarPlan['ok_cotizacion'],'val'=>true];
			$planSepareMensaje =new planSepareMensaje((object)$dataSaved);
			$mensaje=$planSepareMensaje->CotizacionRes();
		}
		return $msm;
    }

}