<?php 

namespace App\AccessObject\Nutibara\Franquicia;

use App\Models\Nutibara\Franquicia\Franquicia AS ModelFranquicia;
use App\Models\Nutibara\Franquicia\FranquiciaSociedad AS ModelFranquiciaSociedad;

class Franquicia 
{
	public static function FranquiciaWhere($start,$end,$colum, $order,$search){
		return ModelFranquicia::join('tbl_pais','tbl_pais.id','tbl_franquicia.id_pais')
					->select(
								'tbl_franquicia.id AS DT_RowId',
								'tbl_franquicia.nombre',
								'tbl_pais.nombre AS pais',
								'tbl_franquicia.descripcion',
								'tbl_franquicia.linea_atencion',
								'tbl_franquicia.correo_habeas',
								'tbl_franquicia.correo_pedidos',
								'tbl_franquicia.correo_denuncias',
								'tbl_franquicia.whatsapp',
								'tbl_franquicia.facebook',
								'tbl_franquicia.instagram',
								'tbl_franquicia.otros1',
								'tbl_franquicia.otros2',
								'tbl_franquicia.codigo_franquicia',
								\DB::raw("IF(tbl_franquicia.estado = 1, 'SI', 'NO') AS estado")
							)
					->where(function ($query) use ($search){
						if($search['nombre'] != "")
						{
							$query->where('tbl_franquicia.nombre', 'like', "%".$search['nombre']."%");
						}
						if($search['pais'] != "")
						{
							$query->where('tbl_pais.id','=', $search['pais']);		
						}
						if($search['codigo_franquicia'] != "")
						{
							$query->where('tbl_franquicia.codigo_franquicia','like', "%".$search['codigo_franquicia']."%");		
						}
						if($search['estado'] == "")
						{
							$search['estado'] = 1;
						}
						$query->where('tbl_franquicia.estado','=', $search['estado']);					
					})
					->skip($start)->take($end)					
					->orderBy($colum, $order)
					->get();
	}

	public static function Franquicia($start,$end,$colum,$order){
		return ModelFranquicia::join('tbl_pais','tbl_pais.id','tbl_franquicia.id_pais')
						->select(
								'tbl_franquicia.id AS DT_RowId',
								'tbl_franquicia.nombre',
								'tbl_pais.nombre AS pais',
								'tbl_franquicia.descripcion',
								'tbl_franquicia.linea_atencion',
								'tbl_franquicia.correo_habeas',
								'tbl_franquicia.correo_pedidos',
								'tbl_franquicia.correo_denuncias',
								'tbl_franquicia.whatsapp',
								'tbl_franquicia.facebook',
								'tbl_franquicia.instagram',
								'tbl_franquicia.otros1',
								'tbl_franquicia.otros2',
								'tbl_franquicia.codigo_franquicia',
								\DB::raw("IF(tbl_franquicia.estado = 1, 'SI', 'NO') AS estado")
								)
						->where('tbl_franquicia.estado',1)
						->skip($start)->take($end)
						->orderBy($colum, $order)
						->get();
	}

	public static function getCountFranquicia($search){
		return ModelFranquicia::join('tbl_pais','tbl_pais.id','tbl_franquicia.id_pais')
					->where(function ($query) use ($search){
						if($search['nombre'] != "")
						{
							$query->where('tbl_franquicia.nombre', 'like', "%".$search['nombre']."%");
						}
						if($search['pais'] != "")
						{
							$query->where('tbl_pais.id','like', "%".$search['pais']."%");		
						}
						if($search['estado'] == "")
						{
							$search['estado'] = 1;
						}
						$query->where('tbl_franquicia.estado','=', $search['estado']);					
					})
					->count();
	}

	public static function getFranquiciaById($id){
		return ModelFranquicia::where('id',$id)->first();
	}

	public static function getFranquiciaByIdUpdate($id)
	{
		return ModelFranquicia::leftjoin('tbl_sys_archivo','tbl_sys_archivo.id','tbl_franquicia.id_logo')
								->select(
									'tbl_franquicia.id',
									'tbl_franquicia.nombre',
									'tbl_franquicia.id_pais',
									'tbl_franquicia.descripcion',
									'tbl_franquicia.linea_atencion',
									'tbl_franquicia.correo_habeas',
									'tbl_franquicia.correo_pedidos',
									'tbl_franquicia.correo_denuncias',
									'tbl_franquicia.pagina_web',
									'tbl_franquicia.whatsapp',
									'tbl_franquicia.facebook',
									'tbl_franquicia.instagram',
									'tbl_franquicia.otros1',
									'tbl_franquicia.otros2',
									'tbl_franquicia.estado',
									'tbl_franquicia.id_logo',
									'tbl_franquicia.codigo_franquicia', 
									'tbl_sys_archivo.nombre as logo',
									'tbl_sys_archivo.ruta as ruta_logo'
									)
								->where('tbl_franquicia.id',$id)->first();
	}

	public static function CreateAsociacion($dataSaved,$asociaciones)
	{
		$result="Insertado";
		$asociacionesXFranquicia = array();
		try
			{
			\DB::beginTransaction();
			$id_franquicia = \DB::table('tbl_franquicia')->insertGetId($dataSaved);
			self::DeleteasociacionesPasadas($id_franquicia);
			if($asociaciones[0]!='Objetovacio')
			{
				foreach ($asociaciones as $key => $value) {
					$asociacionesXFranquicia[$key]['id_franquicia']=$id_franquicia;
					$asociacionesXFranquicia[$key]['id_sociedad']=$asociaciones[$key];
				}
				\DB::table('tbl_franquicia_sociedades')->insert($asociacionesXFranquicia);
			}	
			\DB::commit();
			}
		catch(\Exception $e)
		{	
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

	public static function DeleteasociacionesPasadas($id_franquicia)
	{
		\DB::table('tbl_franquicia_sociedades')
			 ->where('id_franquicia',$id_franquicia)
			 ->delete();
	}

	public static function Update($id,$dataSaved)
	{
		$result="Actualizado";
		try
		{
			ModelFranquicia::where('id',$id)->update($dataSaved);	
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

	public static function UpdateAsociacion($id_franquicia,$dataSaved,$asociaciones){	

		$result="Actualizado";
		$asociacionesXFranquicia = array();
		try
			{
			\DB::beginTransaction();
			 ModelFranquicia::where('id',$id_franquicia)->update($dataSaved);
			self::DeleteasociacionesPasadas($id_franquicia);
			if($asociaciones[0]!='Objetovacio')
			{
				foreach ($asociaciones as $key => $value) {
					$asociacionesXFranquicia[$key]['id_franquicia']=$id_franquicia;
					$asociacionesXFranquicia[$key]['id_sociedad']=$asociaciones[$key];
				}
				\DB::table('tbl_franquicia_sociedades')->insert($asociacionesXFranquicia);
			}	
			\DB::commit();
			}
		catch(\Exception $e)
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

	public static function SociedadesDeFranquicia($id_franquicia){
		
		return ModelFranquiciaSociedad::select(
									'id_franquicia',
									'id_sociedad AS id_asociar'
									)
							->where('id_franquicia',$id_franquicia)
						    ->get();
	}

	public static function getFranquicia(){
		return ModelFranquicia::select('id','nombre AS name')->where('estado','1')->get();
	}

	public static function getSelectList()
	{
		return ModelFranquicia::select('id','nombre AS name')->where('estado','1')->get();
	}

	public static function getSelectListFranquiciaPais($id)
	{
		return ModelFranquicia::select('id',
									   'nombre AS name'
									  )
									  ->where('estado','1')
									  ->where('id_pais',$id)
									  ->get();
	}
	public static function getSelectFranquiciaByTienda($id)
	{
		return ModelFranquicia::join('tbl_tienda','tbl_tienda.id_franquicia','tbl_franquicia.id')
								->select('tbl_franquicia.id',
										'tbl_franquicia.nombre AS name'
										)
									->where('tbl_franquicia.estado','1')
									->where('tbl_tienda.id',$id)
									->get();
	}
}