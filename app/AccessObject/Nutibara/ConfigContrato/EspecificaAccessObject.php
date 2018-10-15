<?php 

namespace App\AccessObject\Nutibara\ConfigContrato;

use App\Models\Nutibara\ConfigContrato\Especifica;
use DB;

class EspecificaAccessObject {

    public static function Especifica($start,$end,$colum,$order){
		return Especifica::leftJoin('tbl_tienda', 'tbl_contr_configuracion.id_tienda', '=', 'tbl_tienda.id')
					->leftJoin('tbl_ciudad', 'tbl_contr_configuracion.id_ciudad', '=', 'tbl_ciudad.id')
					->leftJoin('tbl_departamento', 'tbl_contr_configuracion.id_departamento', '=', 'tbl_departamento.id')
					->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_configuracion.id_pais')
					->leftJoin('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_contr_configuracion.id_categoria_general')
					->leftJoin('tbl_calificacion', 'tbl_calificacion.id', '=', 'tbl_contr_configuracion.id_calificacion_cliente')
					->select('tbl_contr_configuracion.id AS DT_RowId',
							 'tbl_calificacion.nombre as calificacion',
							 'tbl_contr_configuracion.fecha_hora_vigencia_desde as vigencia_desde',
							 'tbl_contr_configuracion.fecha_hora_vigencia_hasta as vigencia_hasta',
							 "tbl_contr_configuracion.termino_contrato as termino_contrato",
							 "tbl_contr_configuracion.porcentaje_retroventa as porcentaje_retroventa",
							 "tbl_contr_configuracion.dias_gracia as dias_gracia",
							 DB::raw("FORMAT(tbl_contr_configuracion.monto_desde,2,'de_DE') as monto_desde"),
							 DB::raw("FORMAT(tbl_contr_configuracion.monto_hasta,2,'de_DE') as monto_hasta"),
							 'tbl_tienda.nombre as tienda',
							 'tbl_ciudad.nombre as ciudad',
							 'tbl_pais.nombre as pais',
							 'tbl_prod_categoria_general.nombre as categoria', 
							 'tbl_departamento.nombre as departamento',
							 \DB::raw("IF(tbl_contr_configuracion.estado = 1, 'SI', 'NO') AS estado"))
					->where('tbl_contr_configuracion.estado', '1')
					->skip($start)->take($end)	
					->orderBy('tbl_pais.nombre', 'asc')
					->orderBy('tbl_departamento.nombre', 'asc')
					->orderBy('tbl_ciudad.nombre', 'asc')
					->orderBy('tbl_tienda.nombre', 'asc')								
					->orderBy($colum, $order)
					->distinct()->get();
	}

    public static function EspecificaWhere($start,$end,$colum, $order,$search){
		

		return Especifica::leftJoin('tbl_tienda', 'tbl_contr_configuracion.id_tienda', '=', 'tbl_tienda.id')
					->leftJoin('tbl_zona', 'tbl_zona.id', '=', 'tbl_tienda.id_zona')
					->leftJoin('tbl_ciudad', 'tbl_contr_configuracion.id_ciudad', '=', 'tbl_ciudad.id')
					->leftJoin('tbl_departamento', 'tbl_contr_configuracion.id_departamento', '=', 'tbl_departamento.id')
					->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_configuracion.id_pais')
					->leftJoin('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_contr_configuracion.id_categoria_general')
					->leftJoin('tbl_calificacion', 'tbl_calificacion.id', '=', 'tbl_contr_configuracion.id_calificacion_cliente')
					->select('tbl_contr_configuracion.id AS DT_RowId',
							 'tbl_calificacion.nombre as calificacion',
							 'tbl_contr_configuracion.fecha_hora_vigencia_desde as vigencia_desde',
							 'tbl_contr_configuracion.fecha_hora_vigencia_hasta as vigencia_hasta',
							 'tbl_contr_configuracion.termino_contrato',
							 'tbl_contr_configuracion.porcentaje_retroventa',
							 "tbl_contr_configuracion.dias_gracia as dias_gracia",
							 DB::raw("FORMAT(tbl_contr_configuracion.monto_desde,2,'de_DE') as monto_desde"),
							 DB::raw("FORMAT(tbl_contr_configuracion.monto_hasta,2,'de_DE') as monto_hasta"),
							 'tbl_tienda.nombre as tienda',
							 'tbl_ciudad.nombre as ciudad',
							 'tbl_pais.nombre as pais',
							 'tbl_departamento.nombre as departamento',
							 'tbl_prod_categoria_general.nombre as categoria', 
							 'tbl_contr_configuracion.termino_contrato as termino_contrato',
							 'tbl_contr_configuracion.porcentaje_retroventa as porcentaje_retroventa',
							 \DB::raw("IF(tbl_contr_configuracion.estado = 1, 'SI', 'NO') AS estado"))
					->where(function ($query) use ($search){
						$query->where('tbl_contr_configuracion.estado', '=', $search["estado"]);
						if($search['tienda'] != ""){
							$query->where('tbl_contr_configuracion.id_tienda', '=', $search['tienda']);
						}

						if($search['zona'] != ""){
							$query->where('tbl_tienda.id_zona', '=', $search['zona']);
						}

						if($search['pais'] != ""){
							$query->where('tbl_pais.id', '=', $search['pais']);
						}
						
						if($search['ciudad'] != ""){
							$query->where('tbl_ciudad.id', '=', $search['ciudad']);
						}

						if($search['calificacion'] != ""){
							$query->where('tbl_contr_configuracion.id_calificacion_cliente', '=', $search['calificacion']);
						}
						if($search['departamento'] != ""){
							$query->where('tbl_departamento.id', '=', $search['departamento']);
						}
						$query->where('tbl_contr_configuracion.monto_desde', '>=', $search['montodesde']);
						if($search['categoria'] != ""){
							$query->where('tbl_contr_configuracion.id_categoria_general', '=', $search['categoria']);
						}
						if($search['montohasta'] != ""){
							$query->where('tbl_contr_configuracion.monto_hasta', '<=', $search['montohasta']);
						}

						if($search['vigente'] == "1"){
							$query->where('tbl_contr_configuracion.fecha_hora_vigencia_desde', '<=', DB::raw('NOW()'));
							$query->where('tbl_contr_configuracion.fecha_hora_vigencia_hasta', '>=', DB::raw('NOW()'));
						}elseif($search['vigente'] == "0"){
							// $query->where('tbl_contr_configuracion.fecha_hora_vigencia_desde', '>=', DB::raw('NOW()'));
							// $query->where('tbl_contr_configuracion.fecha_hora_vigencia_hasta', '<=', DB::raw('NOW()'));
						}
					})
					->orderBy('tbl_pais.nombre', 'asc')
					->orderBy('tbl_departamento.nombre', 'asc')
					->orderBy('tbl_ciudad.nombre', 'asc')
					->orderBy('tbl_tienda.nombre', 'asc')
					->orderBy($colum, $order)
					->skip($start)->take($end)	
					->distinct()->get();
	}

	public static function getCountEspecifica($search){
		return Especifica::leftJoin('tbl_tienda', 'tbl_contr_configuracion.id_tienda', '=', 'tbl_tienda.id')
						->leftJoin('tbl_ciudad', 'tbl_contr_configuracion.id_ciudad', '=', 'tbl_ciudad.id')
						->leftJoin('tbl_departamento', 'tbl_contr_configuracion.id_departamento', '=', 'tbl_departamento.id')
						->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_configuracion.id_pais')
						->leftJoin('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_contr_configuracion.id_categoria_general')
						->leftJoin('tbl_calificacion', 'tbl_calificacion.id', '=', 'tbl_contr_configuracion.id_calificacion_cliente')
						->where(function ($query) use ($search){
							$query->where('tbl_contr_configuracion.estado', '=', $search["estado"]);
							if($search['tienda'] != ""){
								$query->where('tbl_tienda.nombre', 'LIKE', '%'.$search['tienda'].'%');
							}
							if($search['pais'] != ""){
								$query->where('tbl_pais.id', '=', $search['pais']);
							}
							if($search['departamento'] != ""){
								$query->where('tbl_departamento.id', 'LIKE', '%'.$search['departamento'].'%');
							}
							if($search['ciudad'] != ""){
								$query->where('tbl_ciudad.id', '=', $search['ciudad']);
							}
							if($search['calificacion'] != ""){
								$query->where('tbl_contr_configuracion.id_calificacion_cliente', '=', $search['calificacion']);
							}
							$query->where('tbl_contr_configuracion.monto_desde', '>=', $search['montodesde']);
							if($search['categoria'] != ""){
								$query->where('tbl_contr_configuracion.id_categoria_general', '=', $search['categoria']);
							}
							if($search['montohasta'] != ""){
								$query->where('tbl_contr_configuracion.monto_hasta', '<=', $search['montohasta']);
							}
	
							if($search['vigente'] == "1"){
								$query->where('tbl_contr_configuracion.fecha_hora_vigencia_desde', '<=', DB::raw('NOW()'));
								$query->where('tbl_contr_configuracion.fecha_hora_vigencia_hasta', '>=', DB::raw('NOW()'));
							}elseif($search['vigente'] == "0"){
								// $query->where('tbl_contr_configuracion.fecha_hora_vigencia_desde', '>=', DB::raw('NOW()'));
								// $query->where('tbl_contr_configuracion.fecha_hora_vigencia_hasta', '<=', DB::raw('NOW()'));
							}
						})
						->distinct()->count();
	}

    public static function getEspecificaById($id){
		return Especifica::leftJoin('tbl_tienda', 'tbl_contr_configuracion.id_tienda', '=', 'tbl_tienda.id')
						->leftJoin('tbl_ciudad', 'tbl_contr_configuracion.id_ciudad', '=', 'tbl_ciudad.id')
						->leftJoin('tbl_departamento', 'tbl_contr_configuracion.id_departamento', '=', 'tbl_departamento.id')
						->join('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_configuracion.id_pais')
						->leftJoin('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_contr_configuracion.id_categoria_general')
						->leftJoin('tbl_calificacion', 'tbl_calificacion.id', '=', 'tbl_contr_configuracion.id_calificacion_cliente')
						->leftJoin('tbl_contr_dato_general', 'tbl_contr_dato_general.id_categoria_general', '=', 'tbl_contr_configuracion.id_categoria_general')
						->select(
							'tbl_contr_configuracion.id',
							'tbl_pais.id AS id_pais',
							'tbl_departamento.id AS id_departamento',
							'tbl_tienda.id AS id_tienda',
							'tbl_ciudad.id AS id_ciudad',
							'tbl_prod_categoria_general.id AS id_categoria_general',
							'tbl_calificacion.id AS id_calificacion_cliente',
							DB::raw("FORMAT(tbl_contr_configuracion.monto_desde,2,'de_DE') as monto_desde"),
							DB::raw("FORMAT(tbl_contr_configuracion.monto_hasta,2,'de_DE') as monto_hasta"),
							'tbl_contr_configuracion.fecha_hora_vigencia_desde',
							'tbl_contr_configuracion.fecha_hora_vigencia_hasta',
							'tbl_contr_configuracion.termino_contrato',
							'tbl_contr_configuracion.porcentaje_retroventa',
							"tbl_contr_configuracion.dias_gracia as dias_gracia"
						)
						->where('tbl_contr_configuracion.id',$id)->first();
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
			Especifica::where('id',$id)->update($dataSaved);	
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
		return Especifica::where('id',$id)->delete();	
	}

	public static function validateUniqueMonto( $data, $id ) {
		return Especifica::where( function( $query ) use( $data, $id ) {
			$query->where( 'tbl_contr_configuracion.id', '<>', $id );
			( $data[ 'id_pais' ] != '' ) ? $query->where( 'tbl_contr_configuracion.id_pais', '=', $data[ 'id_pais' ] ) : null;
			( $data[ 'id_departamento' ] != '' ) ? $query->where( 'tbl_contr_configuracion.id_departamento', '=', $data[ 'id_departamento' ] ) : null;
			( $data[ 'id_ciudad' ] != '' ) ? $query->where( 'tbl_contr_configuracion.id_ciudad', '=', $data[ 'id_ciudad' ] ) : null;
			( $data[ 'id_tienda' ] != '' ) ? $query->where( 'tbl_contr_configuracion.id_tienda', '=', $data[ 'id_tienda' ] ) : null;
			( $data[ 'id_categoria_general' ] != '' ) ? $query->where( 'tbl_contr_configuracion.id_categoria_general', '=', $data[ 'id_categoria_general' ] ) : null;
		} )
		->where( function( $query ) use( $data, $id ) {
			$query->where( function( $query2 ) use( $data ) {
				( $data[ 'monto_desde' ] != '' ) ? $query2->where( 'tbl_contr_configuracion.monto_desde', '<=', $data[ 'monto_desde' ] ) : null;
				( $data[ 'monto_desde' ] != '' ) ? $query2->where( 'tbl_contr_configuracion.monto_hasta', '>=', $data[ 'monto_desde' ] ) : null;
			} );

			$query->orWhere( function( $query2 ) use( $data ) {
				( $data[ 'monto_hasta' ] != '' ) ? $query2->where( 'tbl_contr_configuracion.monto_desde', '<=', $data[ 'monto_hasta' ] ) : null;
				( $data[ 'monto_hasta' ] != '' ) ? $query2->where( 'tbl_contr_configuracion.monto_hasta', '>=', $data[ 'monto_hasta' ] ) : null;
			} );

			$query->orWhere( function( $query2 ) use( $data ) {
				( $data[ 'monto_desde' ] != '' ) ? $query2->where( 'tbl_contr_configuracion.monto_desde', '>=', $data[ 'monto_desde' ] ) : null;
				( $data[ 'monto_hasta' ] != '' ) ? $query2->where( 'tbl_contr_configuracion.monto_desde', '<=', $data[ 'monto_hasta' ] ) : null;
			} );

			$query->orWhere( function( $query2 ) use( $data ) {
				( $data[ 'monto_desde' ] != '' ) ? $query2->where( 'tbl_contr_configuracion.monto_hasta', '>=', $data[ 'monto_desde' ] ) : null;
				( $data[ 'monto_hasta' ] != '' ) ? $query2->where( 'tbl_contr_configuracion.monto_hasta', '<=', $data[ 'monto_hasta' ] ) : null;
			} );
		} )->count();
	}

	public static function validateUniqueVigencia( $data, $id ) {
		return Especifica::where( function( $query ) use( $data, $id ) {
			$query->where( 'tbl_contr_configuracion.id', '<>', $id );
			( $data[ 'id_pais' ] != '' ) ? $query->where( 'tbl_contr_configuracion.id_pais', '=', $data[ 'id_pais' ] ) : null;
			( $data[ 'id_departamento' ] != '' ) ? $query->where( 'tbl_contr_configuracion.id_departamento', '=', $data[ 'id_departamento' ] ) : null;
			( $data[ 'id_ciudad' ] != '' ) ? $query->where( 'tbl_contr_configuracion.id_ciudad', '=', $data[ 'id_ciudad' ] ) : null;
			( $data[ 'id_tienda' ] != '' ) ? $query->where( 'tbl_contr_configuracion.id_tienda', '=', $data[ 'id_tienda' ] ) : null;
			( $data[ 'id_categoria_general' ] != '' ) ? $query->where( 'tbl_contr_configuracion.id_categoria_general', '=', $data[ 'id_categoria_general' ] ) : null;
		} )
		->where( function( $query ) use( $data, $id ) {
			$query->where( function( $query2 ) use( $data ) {
				( $data[ 'fecha_hora_vigencia_desde' ] != '' ) ? $query2->where( 'tbl_contr_configuracion.fecha_hora_vigencia_desde', '<=', $data[ 'fecha_hora_vigencia_desde' ] ) : null;
				( $data[ 'fecha_hora_vigencia_desde' ] != '' ) ? $query2->where( 'tbl_contr_configuracion.fecha_hora_vigencia_hasta', '>=', $data[ 'fecha_hora_vigencia_desde' ] ) : null;
			} );

			$query->orWhere( function( $query2 ) use( $data ) {
				( $data[ 'fecha_hora_vigencia_hasta' ] != '' ) ? $query2->where( 'tbl_contr_configuracion.fecha_hora_vigencia_desde', '<=', $data[ 'fecha_hora_vigencia_hasta' ] ) : null;
				( $data[ 'fecha_hora_vigencia_hasta' ] != '' ) ? $query2->where( 'tbl_contr_configuracion.fecha_hora_vigencia_hasta', '>=', $data[ 'fecha_hora_vigencia_hasta' ] ) : null;
			} );

			$query->orWhere( function( $query2 ) use( $data ) {
				( $data[ 'fecha_hora_vigencia_desde' ] != '' ) ? $query2->where( 'tbl_contr_configuracion.fecha_hora_vigencia_desde', '>=', $data[ 'fecha_hora_vigencia_desde' ] ) : null;
				( $data[ 'fecha_hora_vigencia_hasta' ] != '' ) ? $query2->where( 'tbl_contr_configuracion.fecha_hora_vigencia_desde', '<=', $data[ 'fecha_hora_vigencia_hasta' ] ) : null;
			} );

			$query->orWhere( function( $query2 ) use( $data ) {
				( $data[ 'fecha_hora_vigencia_desde' ] != '' ) ? $query2->where( 'tbl_contr_configuracion.fecha_hora_vigencia_hasta', '>=', $data[ 'fecha_hora_vigencia_desde' ] ) : null;
				( $data[ 'fecha_hora_vigencia_hasta' ] != '' ) ? $query2->where( 'tbl_contr_configuracion.fecha_hora_vigencia_hasta', '<=', $data[ 'fecha_hora_vigencia_hasta' ] ) : null;
			} );
		} )->count();
	}

	

}