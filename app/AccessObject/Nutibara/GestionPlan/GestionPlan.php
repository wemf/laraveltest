<?php 

namespace App\AccessObject\Nutibara\GestionPlan;

use App\Models\Nutibara\GestionPlan\GestionPlan AS ModelGestionPlan;
use App\Models\Nutibara\Clientes\Cliente AS ModelCliente;
use DB;

class GestionPlan 
{
	public static function GestionPlanWhere($colum, $order,$search){
		return ModelGestionPlan::select(
									'id AS DT_RowId',
									'nombre',
									'descripcion',
									DB::raw("IF(estado = 1, 'SI', 'NO') AS estado")
								)
					->where(function ($query) use ($search){
						$query->where('nombre', 'like', "%".$search['name']."%");
						$query->where('estado','=', $search['estado']);
					})	
					->orderBy($colum, $order)
					->get();
	}

	public static function GestionPlan($start,$end,$colum,$order){
		return ModelGestionPlan::select(
									'id AS DT_RowId',
									'nombre',
									'descripcion',
									DB::raw("IF(estado = 1, 'SI', 'NO') AS estado"))
						->where('estado',1)
						->get();
	}

	public static function getCliente($iden)
	{
		return ModelCliente::select(
									'codigo_cliente',
									'fecha_nacimiento',
									'fecha_expedicion',
									'nombres',
									DB::raw('concat(primer_apellido," ",segundo_apellido) as apellidos'),
									'correo_electronico',
									'id_confiabilidad',
									'foto',
									'id_tienda'
									)
							->where('numero_documento',$iden)
							->first();		
	}

	public static function getCountGestionPlan(){
		return ModelGestionPlan::where('estado', '1')->count();
	}

	public static function getGestionPlanById($id){
		return ModelGestionPlan::where('id',$id)->first();
	}

	public static function Create($dataSaved){
		return $response = ModelGestionPlan::insertGetId($dataSaved);	
	}

	public static function Update($id,$dataSaved){	
		$result="Actualizado";
		try
		{
			ModelGestionPlan::where('id',$id)->update($dataSaved);	
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

	public static function getGestionPlan(){
		return ModelGestionPlan::select('id','nombre AS name')->where('estado','1')->get();
	}

	public static function getSelectList($table){
		return DB::table($table)->select('id','nombre AS name')
								->where('estado','1')
								->orderBy('nombre','ASC')
								->get();
	}

}