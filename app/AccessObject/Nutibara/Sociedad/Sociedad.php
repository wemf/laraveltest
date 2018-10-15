<?php 

namespace App\AccessObject\Nutibara\Sociedad;

use App\Models\Nutibara\Sociedad\Sociedad AS ModelSociedad;
use App\Models\Nutibara\Regimen\Regimen AS ModelRegimen;
use App\Models\Nutibara\Franquicia\FranquiciaSociedad AS ModelFranquiciaSociedad;

class Sociedad 
{
	public static function SociedadWhere($start,$end,$colum, $order,$search){
		return ModelSociedad::join('tbl_pais','tbl_pais.id','tbl_sociedad.id_pais')
							->join('tbl_clie_regimen_contributivo','tbl_clie_regimen_contributivo.id','tbl_sociedad.id_regimen')
							->select(
									'tbl_sociedad.id AS DT_RowId',
									'tbl_sociedad.nombre AS nombre',
									'tbl_sociedad.nit',
									'tbl_sociedad.digito_verificacion',
									'tbl_sociedad.direccion',
									'tbl_sociedad.codigo_sociedad',
									'tbl_clie_regimen_contributivo.nombre AS regimen',
									'tbl_pais.nombre AS pais',
									\DB::raw("IF(tbl_sociedad.estado = 1, 'SI', 'NO') AS estado")
									)
							->where(function ($query) use ($search){
								$query->where('tbl_pais.id', 'like', "%".$search['pais']."%");
								$query->where('tbl_sociedad.nombre', 'like', "%".$search['sociedad']."%");
								$query->where('tbl_sociedad.estado', '=', $search['estado']);
							})
							->skip($start)->take($end)							
							->orderBy($colum, $order)
							->get();
	}

	public static function Sociedad($start,$end,$colum,$order){
		return ModelSociedad::join('tbl_pais','tbl_pais.id','tbl_sociedad.id_pais')
							->join('tbl_clie_regimen_contributivo','tbl_clie_regimen_contributivo.id','tbl_sociedad.id_regimen')
							->select(
									'tbl_sociedad.id AS DT_RowId',
									'tbl_sociedad.nombre AS nombre',
									'tbl_sociedad.nit',
									'tbl_sociedad.direccion',
									'tbl_sociedad.digito_verificacion',
									'tbl_sociedad.codigo_sociedad',
									'tbl_clie_regimen_contributivo.nombre AS regimen',
									'tbl_pais.nombre AS pais',
									\DB::raw("IF(tbl_sociedad.estado = 1, 'SI', 'NO') AS estado")
									)
							->where('tbl_sociedad.estado',1)
							->skip($start)->take($end)
							->orderBy($colum, $order)
							->get();
	}

	public static function getCountSociedad($search){
		return ModelSociedad::join('tbl_pais','tbl_pais.id','tbl_sociedad.id_pais')
		->join('tbl_clie_regimen_contributivo','tbl_clie_regimen_contributivo.id','tbl_sociedad.id_regimen')
		->where(function ($query) use ($search){
			if($search['pais'] != "")
			{
			$query->where('tbl_pais.id', 'like', "%".$search['pais']."%");
			}
			if($search['sociedad'] != "")
			{
			$query->where('tbl_sociedad.nombre', 'like', "%".$search['sociedad']."%");
			}
			if($search['estado'] == "")
			{
				$search['estado']  = 1;
			}
			$query->where('tbl_sociedad.estado', '=', $search['estado']);
		})
		->count();
	}

	public static function getSociedadById($id){
		return ModelSociedad::join('tbl_pais','tbl_pais.id','tbl_sociedad.id_pais')
							->select(
								'tbl_sociedad.id',
								'tbl_sociedad.nombre AS nombre',
								'tbl_sociedad.nit',
								'tbl_sociedad.digito_verificacion',
								'tbl_sociedad.codigo_sociedad',
								'tbl_sociedad.id_regimen',
								'tbl_sociedad.direccion',
								'tbl_sociedad.id_pais AS id_pais'
							)
							->where('tbl_sociedad.id',$id)->first();
	}

	public static function Create($dataSaved){
		$result="Insertado";
		try{
			\DB::beginTransaction();
			\DB::table('tbl_sociedad')->insert($dataSaved);		
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

	public static function Update($id,$dataSaved)
	{	
			$result="Actualizado";
			try
			{
				ModelSociedad::where('id',$id)->update($dataSaved);	
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

	public static function getSelectList()
	{
		return ModelSociedad::select('id','nombre AS name')->where('estado','1')->get();
	}

	public static function getSelectListRegimen()
	{
		return ModelRegimen::select('id','nombre AS name')->where('estado','1')->get();
	}

	public static function getSelectListSociedadesPais($id)
	{
		return ModelSociedad::select('id',
									 'nombre AS name'
									)
							->where('estado','1')
							->where('id_pais',$id)->get();
	}

	public static function getSelectSociedadByTienda($id)
	{
		return ModelSociedad::join('tbl_tienda','tbl_tienda.id_sociedad','tbl_sociedad.id')
							->select('tbl_sociedad.id',
									 'tbl_sociedad.nombre AS name'
									)
							->where('tbl_sociedad.estado','1')
							->where('tbl_tienda.id',$id)->get();
	}

}