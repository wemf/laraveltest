<?php 

namespace App\AccessObject\Nutibara\ConfigContrato;

use App\Models\Nutibara\ConfigContrato\ApliRetroventa;
use DB;

class ApliRetroventaAccessObject {

    public static function ApliRetroventa($start,$end,$colum,$order){
		return ApliRetroventa::leftJoin('tbl_tienda', 'tbl_tienda.id', '=', 'tbl_contr_aplicacion_retroventa.id_tienda')
					->leftJoin('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_contr_aplicacion_retroventa.id_ciudad')
					->leftJoin('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_contr_aplicacion_retroventa.id_departamento')
					->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_aplicacion_retroventa.id_pais')
					->select('tbl_contr_aplicacion_retroventa.id AS DT_RowId',
							 'tbl_contr_aplicacion_retroventa.dias_desde', 
							 'tbl_contr_aplicacion_retroventa.dias_hasta', 
							 'tbl_contr_aplicacion_retroventa.meses_transcurridos', 
							 'tbl_contr_aplicacion_retroventa.meses_desde',
							 'tbl_contr_aplicacion_retroventa.meses_hasta',
							 'tbl_contr_aplicacion_retroventa.dias_transcurridos', 
							 'tbl_contr_aplicacion_retroventa.menos_meses', 
							 'tbl_contr_aplicacion_retroventa.menos_porcentaje_retroventas', 
							 DB::raw("FORMAT(tbl_contr_aplicacion_retroventa.monto_desde,2,'de_DE') as monto_desde"),
							 DB::raw("FORMAT(tbl_contr_aplicacion_retroventa.monto_hasta,2,'de_DE') as monto_hasta"),
							 'tbl_tienda.nombre as tienda', 
							 'tbl_pais.nombre as pais',
							 'tbl_departamento.nombre as departamento',
							 'tbl_ciudad.nombre as ciudad',
							 \DB::raw("IF(tbl_contr_aplicacion_retroventa.estado = 1, 'SI', 'NO') AS estado"))
					->where('tbl_contr_aplicacion_retroventa.estado', '1')
					->skip($start)->take($end)
					->orderBy('tbl_pais.nombre', 'asc')
					->orderBy('tbl_departamento.nombre', 'asc')
					->orderBy('tbl_ciudad.nombre', 'asc')
					->orderBy('tbl_tienda.nombre', 'asc')
					->orderBy($colum, $order)
					->get();
	}

    public static function ApliRetroventaWhere($start,$end,$colum, $order,$search){
		return ApliRetroventa::leftJoin('tbl_tienda', 'tbl_tienda.id', '=', 'tbl_contr_aplicacion_retroventa.id_tienda')
					->leftJoin('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_contr_aplicacion_retroventa.id_ciudad')
					->leftJoin('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_contr_aplicacion_retroventa.id_departamento')
					->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_aplicacion_retroventa.id_pais')
					->select('tbl_contr_aplicacion_retroventa.id AS DT_RowId',
							 'tbl_contr_aplicacion_retroventa.dias_desde', 
							 'tbl_contr_aplicacion_retroventa.dias_hasta', 
							 'tbl_contr_aplicacion_retroventa.meses_transcurridos', 
							 'tbl_contr_aplicacion_retroventa.meses_desde',
							 'tbl_contr_aplicacion_retroventa.meses_hasta',
							 'tbl_contr_aplicacion_retroventa.dias_transcurridos', 
							 'tbl_contr_aplicacion_retroventa.menos_meses', 
							 'tbl_contr_aplicacion_retroventa.menos_porcentaje_retroventas', 
							 DB::raw("FORMAT(tbl_contr_aplicacion_retroventa.monto_desde,2,'de_DE') as monto_desde"),
							 DB::raw("FORMAT(tbl_contr_aplicacion_retroventa.monto_hasta,2,'de_DE') as monto_hasta"),
							 'tbl_tienda.nombre as tienda',
							 'tbl_pais.nombre as pais',
							 'tbl_departamento.nombre as departamento',
							 'tbl_ciudad.nombre as ciudad',
							 \DB::raw("IF(tbl_contr_aplicacion_retroventa.estado = 1, 'SI', 'NO') AS estado"))
					->where(function ($query) use ($search){
						if($search['estado'] != "")
						{
						$query->where('tbl_contr_aplicacion_retroventa.estado', '=', $search["estado"]);
						}

						if($search['tienda'] != "")
						{
						$query->where('tbl_tienda.nombre', 'like', "%".$search['tienda']."%");
						}

						if($search['zona'] != "")
						{
						$query->where('tbl_tienda.id_zona', 'like', "%".$search['zona']."%");								
						}

						if($search['ciudad'] != "")
						{
						$query->where('tbl_ciudad.id', 'like', "%".$search['ciudad']."%");
						}

						if($search['montodesde'] != "")
						{
						$query->where('tbl_contr_aplicacion_retroventa.monto_desde', '>=', $search['montodesde']);
						}

						if($search['montohasta'] != "")
						{
							$query->where('tbl_contr_aplicacion_retroventa.monto_hasta', '<=', $search['montohasta']);
						}
						
						if($search['departamento'] != "")
						{
						$query->where('tbl_departamento.id', 'like', "%".$search['departamento']."%");
						}

						if($search['pais'] != "")
						{
							$query->where('tbl_pais.id', '=', $search['pais']);
						}
					})			
					->orderBy('tbl_pais.nombre', 'asc')
					->orderBy('tbl_departamento.nombre', 'asc')
					->orderBy('tbl_ciudad.nombre', 'asc')
					->orderBy('tbl_tienda.nombre', 'asc')					
					->orderBy($colum, $order)
					->skip($start)->take($end)	
					->get();
	}

	public static function getCountApliRetroventa($search){
		return ApliRetroventa::leftJoin('tbl_tienda', 'tbl_tienda.id', '=', 'tbl_contr_aplicacion_retroventa.id_tienda')
							->leftJoin('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_contr_aplicacion_retroventa.id_ciudad')
							->leftJoin('tbl_zona', 'tbl_zona.id', '=', 'tbl_tienda.id_zona')
							->leftJoin('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_contr_aplicacion_retroventa.id_departamento')
							->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_aplicacion_retroventa.id_pais')
							->where(function ($query) use ($search){
								if($search['estado'] != "")
								{
								$query->where('tbl_contr_aplicacion_retroventa.estado', '=', $search["estado"]);
								}

								if($search['tienda'] != "")
								{
								$query->where('tbl_tienda.nombre', 'like', "%".$search['tienda']."%");
								}

								if($search['zona'] != "")
								{
								$query->where('tbl_tienda.id_zona', 'like', "%".$search['zona']."%");								
								}

								if($search['ciudad'] != "")
								{
								$query->where('tbl_ciudad.id', 'like', "%".$search['ciudad']."%");
								}

								if($search['montodesde'] != "")
								{
								$query->where('tbl_contr_aplicacion_retroventa.monto_desde', '>=', $search['montodesde']);
								}

								if($search['montohasta'] != "")
								{
									$query->where('tbl_contr_aplicacion_retroventa.monto_hasta', '<=', $search['montohasta']);
								}
								
								if($search['departamento'] != "")
								{
								$query->where('tbl_departamento.id', 'like', "%".$search['departamento']."%");
								}

								if($search['pais'] != "")
								{
									$query->where('tbl_pais.id', '=', $search['pais']);
								}
							})
							->count();
	}

    public static function getApliRetroventaById($id){
		return ApliRetroventa::leftJoin('tbl_tienda', 'tbl_tienda.id', '=', 'tbl_contr_aplicacion_retroventa.id_tienda')
							->leftJoin('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_contr_aplicacion_retroventa.id_ciudad')
							->leftJoin('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_contr_aplicacion_retroventa.id_departamento')
							->leftJoin('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_aplicacion_retroventa.id_pais')
							->select(
								'tbl_tienda.id as id_tienda',
								'tbl_pais.id as id_pais',
								'tbl_departamento.id as id_departamento',
								'tbl_ciudad.id as id_ciudad',
								'tbl_contr_aplicacion_retroventa.id',
								'tbl_contr_aplicacion_retroventa.id_zona',
								'tbl_contr_aplicacion_retroventa.id_tienda',
								'tbl_contr_aplicacion_retroventa.dias_desde', 
								'tbl_contr_aplicacion_retroventa.dias_hasta', 
								'tbl_contr_aplicacion_retroventa.meses_transcurridos',
								'tbl_contr_aplicacion_retroventa.meses_desde',
								'tbl_contr_aplicacion_retroventa.meses_hasta',
								'tbl_contr_aplicacion_retroventa.dias_transcurridos',
								'tbl_contr_aplicacion_retroventa.menos_meses',
								'tbl_contr_aplicacion_retroventa.menos_porcentaje_retroventas',
								DB::raw("FORMAT(tbl_contr_aplicacion_retroventa.monto_desde,2,'de_DE') as monto_desde"),
								DB::raw("FORMAT(tbl_contr_aplicacion_retroventa.monto_hasta,2,'de_DE') as monto_hasta"),
								'tbl_contr_aplicacion_retroventa.estado',
								'tbl_contr_aplicacion_retroventa.id_pais',
								'tbl_contr_aplicacion_retroventa.id_departamento',
								'tbl_contr_aplicacion_retroventa.id_ciudad'
							)
							->where('tbl_contr_aplicacion_retroventa.id',$id)->first();
	}

    public static function Create($table,$dataSaved){
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

    public static function update($id,$dataSaved){	
		$result="Actualizado";
		try
		{
			ApliRetroventa::where('id',$id)->update($dataSaved);	
		}catch(\Exception $e)
		{
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
		return ApliRetroventa::where('id',$id)->delete();	
	}

	public static function validateUnique( $data, $id ) {
		return ApliRetroventa::where( function( $query ) use( $data, $id ) {
			$query->where( 'tbl_contr_aplicacion_retroventa.id', '<>', $id );
			( $data[ 'id_pais' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.id_pais', '=', $data[ 'id_pais' ] ) : null;
			( $data[ 'id_departamento' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.id_departamento', '=', $data[ 'id_departamento' ] ) : null;
			( $data[ 'id_ciudad' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.id_ciudad', '=', $data[ 'id_ciudad' ] ) : null;
			( $data[ 'id_tienda' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.id_tienda', '=', $data[ 'id_tienda' ] ) : null;
			( $data[ 'monto_desde' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.monto_desde', '<=', $data[ 'monto_desde' ] ) : null;
			( $data[ 'monto_desde' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.monto_hasta', '>=', $data[ 'monto_desde' ] ) : null;
			( $data[ 'meses_desde' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.meses_desde', '<=', $data[ 'meses_desde' ] ) : null;
			( $data[ 'meses_desde' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.meses_hasta', '>=', $data[ 'meses_desde' ] ) : null;
			( $data[ 'dias_desde' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.dias_desde', '<=', $data[ 'dias_desde' ] ) : null;
			( $data[ 'dias_desde' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.dias_hasta', '>=', $data[ 'dias_desde' ] ) : null;
		} )
		->orWhere( function( $query ) use( $data, $id ) {
			$query->where( 'tbl_contr_aplicacion_retroventa.id', '<>', $id );
			( $data[ 'id_pais' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.id_pais', '=', $data[ 'id_pais' ] ) : null;
			( $data[ 'id_departamento' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.id_departamento', '=', $data[ 'id_departamento' ] ) : null;
			( $data[ 'id_ciudad' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.id_ciudad', '=', $data[ 'id_ciudad' ] ) : null;
			( $data[ 'id_tienda' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.id_tienda', '=', $data[ 'id_tienda' ] ) : null;
			( $data[ 'monto_hasta' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.monto_desde', '<=', $data[ 'monto_hasta' ] ) : null;
			( $data[ 'monto_hasta' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.monto_hasta', '>=', $data[ 'monto_hasta' ] ) : null;
			( $data[ 'meses_hasta' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.meses_desde', '<=', $data[ 'meses_hasta' ] ) : null;
			( $data[ 'meses_hasta' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.meses_hasta', '>=', $data[ 'meses_hasta' ] ) : null;
			( $data[ 'dias_hasta' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.dias_desde', '<=', $data[ 'dias_hasta' ] ) : null;
			( $data[ 'dias_hasta' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.dias_hasta', '>=', $data[ 'dias_hasta' ] ) : null;
		} )
		->orWhere( function( $query ) use( $data, $id ) {
			$query->where( 'tbl_contr_aplicacion_retroventa.id', '<>', $id );
			( $data[ 'id_pais' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.id_pais', '=', $data[ 'id_pais' ] ) : null;
			( $data[ 'id_departamento' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.id_departamento', '=', $data[ 'id_departamento' ] ) : null;
			( $data[ 'id_ciudad' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.id_ciudad', '=', $data[ 'id_ciudad' ] ) : null;
			( $data[ 'id_tienda' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.id_tienda', '=', $data[ 'id_tienda' ] ) : null;
			( $data[ 'monto_desde' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.monto_desde', '>=', $data[ 'monto_desde' ] ) : null;
			( $data[ 'monto_hasta' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.monto_desde', '<=', $data[ 'monto_hasta' ] ) : null;
			( $data[ 'meses_desde' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.meses_desde', '>=', $data[ 'meses_desde' ] ) : null;
			( $data[ 'meses_hasta' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.meses_desde', '<=', $data[ 'meses_hasta' ] ) : null;
			( $data[ 'dias_desde' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.dias_desde', '>=', $data[ 'dias_desde' ] ) : null;
			( $data[ 'dias_hasta' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.dias_desde', '<=', $data[ 'dias_hasta' ] ) : null;
		} )
		->orWhere( function( $query ) use( $data, $id ) {
			$query->where( 'tbl_contr_aplicacion_retroventa.id', '<>', $id );
			( $data[ 'id_pais' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.id_pais', '=', $data[ 'id_pais' ] ) : null;
			( $data[ 'id_departamento' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.id_departamento', '=', $data[ 'id_departamento' ] ) : null;
			( $data[ 'id_ciudad' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.id_ciudad', '=', $data[ 'id_ciudad' ] ) : null;
			( $data[ 'id_tienda' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.id_tienda', '=', $data[ 'id_tienda' ] ) : null;
			( $data[ 'monto_desde' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.monto_hasta', '>=', $data[ 'monto_desde' ] ) : null;
			( $data[ 'monto_hasta' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.monto_hasta', '<=', $data[ 'monto_hasta' ] ) : null;
			( $data[ 'meses_desde' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.meses_hasta', '>=', $data[ 'meses_desde' ] ) : null;
			( $data[ 'meses_hasta' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.meses_hasta', '<=', $data[ 'meses_hasta' ] ) : null;
			( $data[ 'dias_desde' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.dias_hasta', '>=', $data[ 'dias_desde' ] ) : null;
			( $data[ 'dias_hasta' ] != '' ) ? $query->where( 'tbl_contr_aplicacion_retroventa.dias_hasta', '<=', $data[ 'dias_hasta' ] ) : null;
		} )->count();
	}
}