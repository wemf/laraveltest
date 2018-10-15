<?php 

namespace App\AccessObject\Nutibara\GestionEstado\Estado;

use App\Models\Nutibara\GestionEstado\Estado\Estado AS ModelEstado;
use App\Models\Nutibara\GestionEstado\Tema\Tema AS ModelTema;
use App\Models\Nutibara\GestionEstado\MotivoEstado\MotivoEstado AS ModelMotivoEstado;

class Estado 
{
	public static function EstadoWhere($start,$end,$colum, $order,$search){

		return ModelEstado::join('tbl_sys_tema','tbl_sys_tema.id','tbl_sys_estado_tema.id_tema')
						->select(
								'tbl_sys_estado_tema.id AS DT_RowId',
								'tbl_sys_tema.nombre AS tema',
								'tbl_sys_estado_tema.nombre AS nombre',
								\DB::raw("IF(tbl_sys_estado_tema.estado = 1, 'SI', 'NO') AS estado")
								)
						->where(function ($query) use ($search){
							   if($search['id_tema'] =! "")
								$query->where('tbl_sys_tema.id', '=', $search['id_tema']);
								$query->where('tbl_sys_estado_tema.estado', '=', $search['estado']);
						})
						->where('tbl_sys_estado_tema.nombre', 'like', "%".$search['nombre']."%")
						->skip($start)->take($end)							
						->orderBy($colum, $order)
						->get();
	}
	public static function Estado($start,$end,$colum,$order){
		
		return ModelEstado::join('tbl_sys_tema','tbl_sys_tema.id','tbl_sys_estado_tema.id_tema')
							->select(
									'tbl_sys_estado_tema.id AS DT_RowId',
									'tbl_sys_tema.nombre AS tema',
									'tbl_sys_estado_tema.nombre AS nombre',
									\DB::raw("IF(tbl_sys_estado_tema.estado = 1, 'SI', 'NO') AS estado")
									)
							->where('tbl_sys_estado_tema.estado',1)
							->skip($start)->take($end)
							->orderBy($colum, $order)
						    ->get();
	}
	public static function MotivosDeEstado($id_estado){
		
		return ModelMotivoEstado::select(
									'id_motivo AS id_asociar',
									'id_estado'
									)
							->where('id_estado',$id_estado)
						    ->get();
	}

	public static function getEstadosByTema($id_tema){
		
		return ModelTema::join('tbl_sys_estado_tema','tbl_sys_estado_tema.id_tema','tbl_sys_tema.id')
						->select(
								'tbl_sys_estado_tema.id',
								'tbl_sys_estado_tema.nombre AS name'
								)
						->where('id_tema',$id_tema)
						->where('tbl_sys_estado_tema.estado','1')
						->get();
	}

	public static function ActualizarMotivosEstado($id_estado,$Motivos,$dataSaved)
    {
		$result="Actualizado";		
		try{
			\DB::beginTransaction();
			\DB::table('tbl_sys_estado_tema')->where('id',$id_estado)->update($dataSaved);
			\DB::table('tbl_sys_motivo_estado')->where('id_estado',$id_estado)->delete();		
			self::CreateEstadosMotivos($id_estado,$Motivos);
			\DB::commit();
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
			\DB::rollback();
		}
		
		return $result;
	}

	public static function getCountEstado($search)
	{
		return ModelEstado::join('tbl_sys_tema','tbl_sys_tema.id','tbl_sys_estado_tema.id_tema')
								->where(function ($query) use ($search){
										if($search['id_tema'] =! "")
										$query->where('tbl_sys_tema.id', '=', $search['id_tema']);
										$query->where('tbl_sys_estado_tema.estado', '=', $search['estado']);
								})
								->where('tbl_sys_estado_tema.nombre', 'like', "%".$search['nombre']."%")
	 							->count();
	}

	public static function getEstadoById($id){
		return ModelEstado::where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result=true;
		try{
			\DB::beginTransaction();
			\DB::table('tbl_clie_Estado')->insert($dataSaved);		
			\DB::commit();
		}catch(\Exception $e){
			$result=false;			
			\DB::rollback();
		}
		return $result;
	}

	public static function CreateEstados($dataSaved,$Motivos){
		$result="Insertado";		
		try{
			\DB::beginTransaction();
			$id_estado = \DB::table('tbl_sys_estado_tema')->insertGetId($dataSaved);	
			self::CreateEstadosMotivos($id_estado,$Motivos);
			\DB::commit();
		}
			catch(\Exception $e)
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
				\DB::rollback();
			}
		return $result;
	}

	public static function CreateEstadosMotivos($id_Estado,$Motivos){

		\DB::table('tbl_sys_motivo_estado')
		->where('id_estado',$id_Estado)
		->delete();

		if($Motivos[0]!='Objetovacio')
		{	
			$MotivosEstado = array();
			foreach ($Motivos as $key => $value) 
			{
				$MotivosEstado[$key]['id_estado']=$id_Estado;
				$MotivosEstado[$key]['id_motivo']=$Motivos[$key];
			}
			\DB::table('tbl_sys_motivo_estado')->insert($MotivosEstado);
		}		
	} 

	public static function getSelectList(){
		return ModelTema::select('id','nombre AS name')->where('estado','1')->get();
	}
	
	public static function Update($id,$dataSaved){	
		return ModelEstado::where('id',$id)->update($dataSaved);	
	}

}