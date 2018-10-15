<?php 

namespace App\AccessObject\Nutibara\ConfigContrato;

use App\Models\Nutibara\ConfigContrato\General;
use DB;

class GeneralAccessObject {

    public static function General($start,$end,$colum,$order){
		return General::join('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_dato_general.id_pais')
					->join('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_contr_dato_general.id_categoria_general')
					->select('tbl_contr_dato_general.id AS DT_RowId',
							 'tbl_contr_dato_general.termino_contrato',
							 'tbl_contr_dato_general.porcentaje_retroventa',
							 "tbl_contr_dato_general.dias_gracia as dias_gracia",
							 'tbl_contr_dato_general.cantidad_aplazos_contrato',
							 'tbl_contr_dato_general.vigencia_desde',
							 'tbl_contr_dato_general.vigencia_hasta',
							 'tbl_pais.nombre as pais',
							 'tbl_prod_categoria_general.nombre as categoria',
							 \DB::raw("IF(tbl_contr_dato_general.estado = 1, 'SI', 'NO') AS estado"))
					->where('tbl_contr_dato_general.estado', '1')
					->skip($start)->take($end)									
					->orderBy($colum, $order)
					->get();
	}

    public static function GeneralWhere($start,$end,$colum, $order,$search){
		

		return General::join('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_dato_general.id_pais')
					->join('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_contr_dato_general.id_categoria_general')
					->select('tbl_contr_dato_general.id AS DT_RowId',
							 'tbl_contr_dato_general.termino_contrato',
							 'tbl_contr_dato_general.porcentaje_retroventa',
							 "tbl_contr_dato_general.dias_gracia as dias_gracia",
							 'tbl_contr_dato_general.cantidad_aplazos_contrato',
							 'tbl_contr_dato_general.vigencia_desde',
							 'tbl_contr_dato_general.vigencia_hasta',
							 'tbl_pais.nombre as pais',
							 'tbl_prod_categoria_general.nombre as categoria',
							 \DB::raw("IF(tbl_contr_dato_general.estado = 1, 'SI', 'NO') AS estado"))
					->where(function ($query) use ($search){
						$query->where('tbl_contr_dato_general.estado', '=', $search["estado"]);
						$query->where('tbl_pais.id', 'LIKE', '%'.$search['pais'].'%');
						$query->where('tbl_contr_dato_general.id_categoria_general', 'LIKE', '%'.$search['categoria'].'%');
					})
					->orderBy($colum, $order)
					->skip($start)->take($end)	
					->get();
	}

	public static function getCountGeneral($search){
		
		return General::join('tbl_pais', 'tbl_pais.id', '=', 'tbl_contr_dato_general.id_pais')
					->join('tbl_prod_categoria_general', 'tbl_prod_categoria_general.id', '=', 'tbl_contr_dato_general.id_categoria_general')
					->where(function ($query) use ($search){
						$query->where('tbl_contr_dato_general.estado', '=', $search["estado"]);
						if($search['pais']!=""||$search['pais']!=null){$query->where('tbl_pais.id', '=', $search['pais']);}
						if($search['categoria']!=""||$search['categoria']!=null){$query->where('tbl_contr_dato_general.id_categoria_general', '=', $search['categoria']);}
					})->count();
					
	}

    public static function getGeneralById($id){
		return General::where('id',$id)->first();
	}

	public static function getGeneral(){
		return General::where('estado', '1')->get();
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
			General::where('id',$id)->update($dataSaved);	
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

	public static function UpdateEspecifica($id_categoria_general, $termino_contrato, $porcentaje_retroventa){
		try{
			return DB::select('CALL u_especifica_with_general(?, ?, ?)', array($id_categoria_general, $termino_contrato, $porcentaje_retroventa));
		}
		catch(\Exception $e){
			
		}
	}

	public static function delete($id){	
		return General::where('id',$id)->delete();	
	}

	public static function validateUnique( $data, $id ) {
		return General::where( function( $query ) use( $data, $id ) {
			$query->where( 'tbl_contr_dato_general.id', '<>', $id );
			( $data[ 'id_pais' ] != '' ) ? $query->where( 'tbl_contr_dato_general.id_pais', '=', $data[ 'id_pais' ] ) : null;
			( $data[ 'id_categoria_general' ] != '' ) ? $query->where( 'tbl_contr_dato_general.id_categoria_general', '=', $data[ 'id_categoria_general' ] ) : null;
			( $data[ 'vigencia_desde' ] != '' ) ? $query->where( 'tbl_contr_dato_general.vigencia_desde', '<=', $data[ 'vigencia_desde' ] ) : null;
			( $data[ 'vigencia_desde' ] != '' ) ? $query->where( 'tbl_contr_dato_general.vigencia_hasta', '>=', $data[ 'vigencia_desde' ] ) : null;
		} )
		->orWhere( function( $query ) use( $data, $id ) {
			$query->where( 'tbl_contr_dato_general.id', '<>', $id );
			( $data[ 'id_pais' ] != '' ) ? $query->where( 'tbl_contr_dato_general.id_pais', '=', $data[ 'id_pais' ] ) : null;
			( $data[ 'id_categoria_general' ] != '' ) ? $query->where( 'tbl_contr_dato_general.id_categoria_general', '=', $data[ 'id_categoria_general' ] ) : null;
			( $data[ 'vigencia_hasta' ] != '' ) ? $query->where( 'tbl_contr_dato_general.vigencia_desde', '<=', $data[ 'vigencia_hasta' ] ) : null;
			( $data[ 'vigencia_hasta' ] != '' ) ? $query->where( 'tbl_contr_dato_general.vigencia_hasta', '>=', $data[ 'vigencia_hasta' ] ) : null;
		} )
		->orWhere( function( $query ) use( $data, $id ) {
			$query->where( 'tbl_contr_dato_general.id', '<>', $id );
			( $data[ 'id_pais' ] != '' ) ? $query->where( 'tbl_contr_dato_general.id_pais', '=', $data[ 'id_pais' ] ) : null;
			( $data[ 'id_categoria_general' ] != '' ) ? $query->where( 'tbl_contr_dato_general.id_categoria_general', '=', $data[ 'id_categoria_general' ] ) : null;
			( $data[ 'vigencia_desde' ] != '' ) ? $query->where( 'tbl_contr_dato_general.vigencia_desde', '>=', $data[ 'vigencia_desde' ] ) : null;
			( $data[ 'vigencia_hasta' ] != '' ) ? $query->where( 'tbl_contr_dato_general.vigencia_desde', '<=', $data[ 'vigencia_hasta' ] ) : null;
		} )
		->orWhere( function( $query ) use( $data, $id ) {
			$query->where( 'tbl_contr_dato_general.id', '<>', $id );
			( $data[ 'id_pais' ] != '' ) ? $query->where( 'tbl_contr_dato_general.id_pais', '=', $data[ 'id_pais' ] ) : null;
			( $data[ 'id_categoria_general' ] != '' ) ? $query->where( 'tbl_contr_dato_general.id_categoria_general', '=', $data[ 'id_categoria_general' ] ) : null;
			( $data[ 'vigencia_desde' ] != '' ) ? $query->where( 'tbl_contr_dato_general.vigencia_hasta', '>=', $data[ 'vigencia_desde' ] ) : null;
			( $data[ 'vigencia_hasta' ] != '' ) ? $query->where( 'tbl_contr_dato_general.vigencia_hasta', '<=', $data[ 'vigencia_hasta' ] ) : null;
		} )->count();
	}

}