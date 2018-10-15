<?php 

namespace App\AccessObject\Nutibara\ConfigPlan;

use App\Models\Nutibara\ConfigPlan\ConfigPlan;
use App\Models\Nutibara\Clientes\Cliente AS ModelCliente;
use DB;

class ConfigPlanAO {
    
    public static function get($start,$end,$colum,$order){
		return ConfigPlan::leftJoin( 'tbl_tienda', 'tbl_plan_separe_config.id_tienda', '=', 'tbl_tienda.id' )
					->leftJoin('tbl_ciudad', 'tbl_plan_separe_config.id_ciudad', '=', 'tbl_ciudad.id')
					->leftJoin('tbl_departamento', 'tbl_plan_separe_config.id_departamento', '=', 'tbl_departamento.id')
					->join('tbl_pais', 'tbl_plan_separe_config.id_pais', '=', 'tbl_pais.id')
					->select('tbl_plan_separe_config.id AS DT_RowId',
							 'tbl_pais.nombre as pais',
							 'tbl_departamento.nombre as departamento',
							 'tbl_ciudad.nombre as ciudad',
							 'tbl_tienda.nombre as tienda',
							 "tbl_plan_separe_config.termino_contrato as termino_contrato",
							 "tbl_plan_separe_config.porcentaje_retroventa as porcentaje_retroventa",
							 DB::raw("FORMAT(tbl_plan_separe_config.monto_desde,2,'de_DE') as monto_desde"),
							 DB::raw("FORMAT(tbl_plan_separe_config.monto_hasta,2,'de_DE') as monto_hasta"),
							 'tbl_plan_separe_config.fecha_hora_vigencia_desde as vigencia_desde',
							 'tbl_plan_separe_config.fecha_hora_vigencia_hasta as vigencia_hasta',
							 \DB::raw("IF(tbl_plan_separe_config.estado = 1, 'SI', 'NO') AS estado"))
					->where('tbl_plan_separe_config.estado', '1')
					->where('tbl_plan_separe_config.fecha_hora_vigencia_desde', '<=', DB::raw('NOW()'))
					->where('tbl_plan_separe_config.fecha_hora_vigencia_hasta', '>=', DB::raw('NOW()'))
					->skip($start)->take($end)									
					->orderBy('tbl_pais.nombre', 'asc')
					->orderBy('tbl_departamento.nombre', 'asc')
					->orderBy('tbl_ciudad.nombre', 'asc')
					->orderBy('tbl_tienda.nombre', 'asc')
					->distinct()->get();
	}

    public static function getWhere($start,$end,$colum, $order,$search){
		

		return ConfigPlan::leftJoin( 'tbl_tienda', 'tbl_plan_separe_config.id_tienda', '=', 'tbl_tienda.id' )
					->leftJoin('tbl_ciudad', 'tbl_plan_separe_config.id_ciudad', '=', 'tbl_ciudad.id')
					->leftJoin('tbl_departamento', 'tbl_plan_separe_config.id_departamento', '=', 'tbl_departamento.id')
					->join('tbl_pais', 'tbl_plan_separe_config.id_pais', '=', 'tbl_pais.id')
					->select('tbl_plan_separe_config.id AS DT_RowId',
							 'tbl_pais.nombre as pais',
							 'tbl_departamento.nombre as departamento',
							 'tbl_ciudad.nombre as ciudad',
							 'tbl_tienda.nombre as tienda',
							 "tbl_plan_separe_config.termino_contrato as termino_contrato",
							 "tbl_plan_separe_config.porcentaje_retroventa as porcentaje_retroventa",
							 DB::raw("FORMAT(tbl_plan_separe_config.monto_desde,2,'de_DE') as monto_desde"),
							 DB::raw("FORMAT(tbl_plan_separe_config.monto_hasta,2,'de_DE') as monto_hasta"),
							 'tbl_plan_separe_config.fecha_hora_vigencia_desde as vigencia_desde',
							 'tbl_plan_separe_config.fecha_hora_vigencia_hasta as vigencia_hasta',
							 \DB::raw("IF(tbl_plan_separe_config.estado = 1, 'SI', 'NO') AS estado"))
					->where(function ($query) use ($search){

                        $query->where('tbl_plan_separe_config.estado', '=', $search["estado"]);
                        
						if($search['pais'] != ""){
							$query->where('tbl_pais.id', '=', $search['pais']);
						}
                        
						if($search['departamento'] != ""){
							$query->where('tbl_departamento.id', '=', $search['departamento']);
                        }
						
						if($search['ciudad'] != ""){
							$query->where('tbl_ciudad.id', '=', $search['ciudad']);
                        }

						if($search['tienda'] != ""){
							$query->where('tbl_plan_separe_config.id_tienda', '=', $search['tienda']);
						}
                        
                        $query->where('tbl_plan_separe_config.monto_desde', '>=', $search['montodesde']);
                        
						if($search['montohasta'] != ""){
							$query->where('tbl_plan_separe_config.monto_hasta', '<=', $search['montohasta']);
						}

						if($search['vigente'] != "0"){
							$query->where('tbl_plan_separe_config.fecha_hora_vigencia_desde', '<=', DB::raw('NOW()'));
							$query->where('tbl_plan_separe_config.fecha_hora_vigencia_hasta', '>=', DB::raw('NOW()'));
						}
					})
					->orderBy('tbl_pais.nombre', 'asc')
					->orderBy('tbl_departamento.nombre', 'asc')
					->orderBy('tbl_ciudad.nombre', 'asc')
					->orderBy('tbl_tienda.nombre', 'asc')
					->skip($start)->take($end)	
					->distinct()->get();
	}

	public static function getCount($search){
		return ConfigPlan::leftJoin( 'tbl_tienda', 'tbl_plan_separe_config.id_tienda', '=', 'tbl_tienda.id' )
					->leftJoin('tbl_ciudad', 'tbl_plan_separe_config.id_ciudad', '=', 'tbl_ciudad.id')
					->leftJoin('tbl_departamento', 'tbl_plan_separe_config.id_departamento', '=', 'tbl_departamento.id')
					->join('tbl_pais', 'tbl_plan_separe_config.id_pais', '=', 'tbl_pais.id')
					->where(function ($query) use ($search){

                        $query->where('tbl_plan_separe_config.estado', '=', $search["estado"]);
                        
						if($search['pais'] != ""){
							$query->where('tbl_pais.id', '=', $search['pais']);
						}
                        
						if($search['departamento'] != ""){
							$query->where('tbl_departamento.id', '=', $search['departamento']);
                        }
						
						if($search['ciudad'] != ""){
							$query->where('tbl_ciudad.id', '=', $search['ciudad']);
                        }

						if($search['tienda'] != ""){
							$query->where('tbl_plan_separe_config.id_tienda', '=', $search['tienda']);
						}
                        
                        $query->where('tbl_plan_separe_config.monto_desde', '>=', $search['montodesde']);
                        
						if($search['montohasta'] != ""){
							$query->where('tbl_plan_separe_config.monto_hasta', '<=', $search['montohasta']);
						}

						if($search['vigente'] != "0"){
							$query->where('tbl_plan_separe_config.fecha_hora_vigencia_desde', '<=', DB::raw('NOW()'));
							$query->where('tbl_plan_separe_config.fecha_hora_vigencia_hasta', '>=', DB::raw('NOW()'));
						}
					})
					->distinct()->count();
	}

    public static function getById($id){
		return ConfigPlan::leftJoin( 'tbl_tienda', 'tbl_plan_separe_config.id_tienda', '=', 'tbl_tienda.id' )
					->leftJoin('tbl_ciudad', 'tbl_plan_separe_config.id_ciudad', '=', 'tbl_ciudad.id')
					->leftJoin('tbl_departamento', 'tbl_plan_separe_config.id_departamento', '=', 'tbl_departamento.id')
					->join('tbl_pais', 'tbl_plan_separe_config.id_pais', '=', 'tbl_pais.id')
                    ->select('tbl_plan_separe_config.id AS DT_RowId',
                            'tbl_plan_separe_config.id',
                            'tbl_pais.nombre as pais',
                            'tbl_departamento.nombre as departamento',
                            'tbl_ciudad.nombre as ciudad',
                            'tbl_tienda.nombre as tienda',
                            'tbl_pais.id as id_pais',
                            'tbl_departamento.id as id_departamento',
                            'tbl_ciudad.id as id_ciudad',
                            'tbl_tienda.id as id_tienda',
                            "tbl_plan_separe_config.termino_contrato as termino_contrato",
                            "tbl_plan_separe_config.porcentaje_retroventa as porcentaje_retroventa",
                            DB::raw("FORMAT(tbl_plan_separe_config.monto_desde,2,'de_DE') as monto_desde"),
                            DB::raw("FORMAT(tbl_plan_separe_config.monto_hasta,2,'de_DE') as monto_hasta"),
                            'tbl_plan_separe_config.fecha_hora_vigencia_desde as vigencia_desde',
                            'tbl_plan_separe_config.fecha_hora_vigencia_hasta as vigencia_hasta',
                            \DB::raw("IF(tbl_plan_separe_config.estado = 1, 'SI', 'NO') AS estado"))
						->where('tbl_plan_separe_config.id',$id)->first();
	}

    public static function store($table,$dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table($table)->insert($dataSaved);
			\DB::commit();
		}catch(\Exception $e){
			if($e->getCode() == 23000)
			{
				$result='ErrorUnico';
			}
			else
			{
				$result = 'Error';
			}
			\DB::rollback();
		}
		return $result;
	}

    public static function update($id,$data){	
		$result="Actualizado";
		try
		{
			ConfigPlan::where('id',$id)->update($data);	
		}catch(\Exception $e)
		{
            dd($e);
			if($e->getCode() == 23000)
			{
				$result='ErrorUnico';
			}
			else
			{
				$result = 'Error';
			}
		}
		return $result;
	}

	public static function delete($id){	
		return ConfigPlan::where('id',$id)->delete();	
	}

}