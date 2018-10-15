<?php 

namespace App\BusinessLogic\Nutibara\ConfigPlan;
use App\AccessObject\Nutibara\ConfigPlan\ConfigPlanAO;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;


class ConfigPlanBL {
    
    public static function get($start,$end,$colum, $order,$search){
        if($search['estado']==""){
			$result = ConfigPlanAO::get($start,$end,$colum, $order);
		}else{
			$result = ConfigPlanAO::getWhere($start,$end,$colum, $order,$search);
		}
		return $result;
    }

    public static function getCount($search)
	{
		if($search["estado"] == "" || $search["estado"] == null){
			$search["estado"] = 1;
		}
		return (int)ConfigPlanAO::getCount($search);
	}

    public static function getById( $id ) {
		return ConfigPlanAO::getById( $id );
	}

    public static  function store ( $data ) {
        $response = ConfigPlanAO::store( "tbl_plan_separe_config", $data );
        
		if( $response == 'Error' ) {
			$msm = [ 'msm' => Messages::$ConfigPlan[ 'error' ], 'val' => 'Error' ];		
		}
		elseif( $response == 'ErrorUnico' ) {
			$msm = [ 'msm' => Messages::$ExectionGeneral[ 'error_unique' ], 'val' => 'ErrorUnico' ];	
		}
		elseif( $response == 'Insertado' ) {
			$msm = [ 'msm' => Messages::$ConfigPlan[ 'ok' ], 'val' => 'Insertado' ];	
        }
        
		return $msm;
	}

    public static function update( $id, $data ){
        $response = ConfigPlanAO::update( $id, $data );
        
		if( $response == 'Error' ) {
			$msm = [ 'msm' => Messages::$ConfigPlan[ 'update_error' ], 'val' => 'Error' ];		
		}
		elseif( $response == 'ErrorUnico' ) {
			$msm = [ 'msm' => Messages::$ExectionGeneral[ 'error_unique' ], 'val' => 'ErrorUnico' ];	
		}
		elseif( $response == 'Actualizado' ) {
			$msm = [ 'msm' => Messages::$ConfigPlan[ 'update_ok' ], 'val' => 'Actualizado' ];	
        }
        
		return $msm;
	}

    public static function active( $id )
    {
		$data = array();
		$data [ 'estado' ] = 1;
        $msm = [ 'msm' => Messages::$ConfigPlan[ 'active_ok' ], 'val' => true ];
        
		if( !ConfigPlanAO::update( $id, $data ) ) {
			$msm = [ 'msm' => Messages::$ConfigPlan[ 'active_error' ], 'val' => false ];		
        }	
        
		return $msm;
	}

    public static function inactive( $id ) {
		$data = array();
		$data[ 'estado' ] = 0;
		$msm=[ 'msm' => Messages::$ConfigPlan[ 'inactive_ok' ], 'val' => true ];
		if( !ConfigPlanAO::update( $id, $data ) ) {
			$msm=[ 'msm' => Messages::$sysMultibd[ 'error_inactive' ], 'val' => false ];
		}	
		return $msm;
	}

	public static function delete( $id ) {
        $msm = [ 'msm' => Messages::$ConfigPlan[ 'delete_ok' ], 'val' => true ];
        
		if( !ConfigPlanAO::delete( $id ) ) {
			$msm = [ 'msm' => Messages::$sysMultibd[ 'error_delete' ], 'val' => false ];
        }
        
		return $msm;
	}

	

}