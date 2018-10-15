<?php 

namespace App\AccessObject\Nutibara\AsociarCliente\AsociarSociedad;

use App\Models\Nutibara\AsociarCliente\AsociarSociedad\AsociarSociedad AS ModelAsociarSociedad;
use App\Models\Nutibara\AsociarCliente\TipoCliente\TipoCliente AS ModelTipoCliente;
use App\Models\Nutibara\AsociarCliente\SociedadesporCliente\SociedadesporCliente AS ModelSociedadesporClientes;

class AsociarSociedad 
{
	public static function AsociarSociedadWhere($start,$end,$colum, $order,$search){
		return ModelAsociarSociedad::join('tbl_tienda','tbl_tienda.id','tbl_cliente.id_tienda')
						->join('tbl_clie_tipo','tbl_clie_tipo.id','tbl_cliente.id_tipo_cliente')
						->join('tbl_clie_tipo_documento','tbl_clie_tipo_documento.id','tbl_cliente.id_tipo_documento')
						->select(	
								'tbl_clie_tipo.nombre AS tipodocliente',
								'tbl_clie_tipo_documento.nombre_abreviado AS tipodocumento',
								'tbl_cliente.numero_documento AS documento',
								'tbl_cliente.nombres AS nombre',
								'tbl_cliente.primer_apellido AS primerapellido',
								'tbl_cliente.segundo_apellido AS segundoapellido',
								'tbl_cliente.correo_electronico AS correo',
								\DB::raw("IF(tbl_cliente.estado = 1, 'SI', 'NO') AS estado"),
								\DB::raw("CONCAT(tbl_cliente.codigo_cliente,'/',tbl_tienda.id) AS DT_RowId")
								)
						->where(function ($query) use ($search){
							$query->where('tbl_clie_tipo.nombre', 'like', "%".$search['tipodocliente']."%");
							$query->where('tbl_clie_tipo_documento.nombre_abreviado', 'like', "%".$search['tipodocumento']."%");
							$query->where('tbl_cliente.numero_documento', 'like', "%".$search['documento']."%");
							$query->where('tbl_cliente.nombres', 'like', "%".$search['nombre']."%");
							$query->where('tbl_cliente.primer_apellido', 'like', "%".$search['primerapellido']."%");
							$query->where('tbl_cliente.segundo_apellido', 'like', "%".$search['segundoapellido']."%");
							$query->where('tbl_cliente.estado', '=', $search['estado']);
							})
						->skip($start)->take($end)							
						->whereNotIn('tbl_cliente.id_tipo_cliente',[3,4])
						->orderBy($colum, $order)
						->get();
	}

	public static function AsociarSociedad($start,$end,$colum,$order){
		return ModelAsociarSociedad::join('tbl_tienda','tbl_tienda.id','tbl_cliente.id_tienda')
							->join('tbl_clie_tipo','tbl_clie_tipo.id','tbl_cliente.id_tipo_cliente')
							->join('tbl_clie_tipo_documento','tbl_clie_tipo_documento.id','tbl_cliente.id_tipo_documento')
							->select(
								'tbl_clie_tipo.nombre AS tipodocliente',
								'tbl_clie_tipo_documento.nombre_abreviado AS tipodocumento',
								'tbl_cliente.numero_documento AS documento',
								'tbl_cliente.nombres AS nombre',
								'tbl_cliente.primer_apellido AS primerapellido',
								'tbl_cliente.segundo_apellido AS segundoapellido',
								'tbl_cliente.correo_electronico AS correo',
								\DB::raw("IF(tbl_cliente.estado = 1, 'SI', 'NO') AS estado"),
								\DB::raw("CONCAT(tbl_cliente.codigo_cliente,'/',tbl_tienda.id) AS DT_RowId")
								)
							->where('tbl_cliente.estado',1)	
							->whereNotIn('tbl_cliente.id_tipo_cliente',[3,4])	
							->skip($start)->take($end)
							->orderBy($colum, $order)						
						    ->get();
	}

	public static function getCountAsociarSociedad($search){
		return ModelAsociarSociedad::join('tbl_tienda','tbl_tienda.id','tbl_cliente.id_tienda')
		->join('tbl_clie_tipo','tbl_clie_tipo.id','tbl_cliente.id_tipo_cliente')
		->join('tbl_clie_tipo_documento','tbl_clie_tipo_documento.id','tbl_cliente.id_tipo_documento')
		->where(function ($query) use ($search){
			if($search['tipodocliente'] != "")
			{
				$query->where('tbl_clie_tipo.nombre', 'like', "%".$search['tipodocliente']."%");
			}
			
			if($search['tipodocumento'] != "")
			{
				$query->where('tbl_clie_tipo_documento.nombre_abreviado', 'like', "%".$search['tipodocumento']."%");
			}
			
			if($search['documento'] != "")
			{
				$query->where('tbl_cliente.numero_documento', 'like', "%".$search['documento']."%");
			}
			
			if($search['nombre'] != "")
			{
				$query->where('tbl_cliente.nombres', 'like', "%".$search['nombre']."%");
			}
			
			if($search['primerapellido'] != "")
			{
				$query->where('tbl_cliente.primer_apellido', 'like', "%".$search['primerapellido']."%");
			}
			
			if($search['segundoapellido'] != "")
			{
				$query->where('tbl_cliente.segundo_apellido', 'like', "%".$search['segundoapellido']."%");
			}
			if($search['estado'] =="")
			{
				$search['estado'] = 1;
			}
			$query->where('tbl_cliente.estado', '=', $search['estado']);
			})
		->whereNotIn('tbl_cliente.id_tipo_cliente',[3,4])
		->count();
	}

	public static function getAsociarSociedadById($id,$id_Tienda){
		return ModelAsociarSociedad::where('codigo_cliente',$id)->where('id_tienda',$id_Tienda)->first();
	}

	public static function Create($dataSaved){
		$result=true;
		try{
			\DB::beginTransaction();
			\DB::table('tbl_clie_area_trabajo')->insert($dataSaved);		
			\DB::commit();
		}catch(\Exception $e){
			$result=false;			
			\DB::rollback();
		}
		return $result;
	}

	public static function CreateAsociacion($dataSaved,$asociaciones)
	{
		$result="Insertado";		
		$asociacionesXCliente = array();
		foreach ($asociaciones as $key => $value) {
			$asociacionesXCliente[$key]['id_tienda_cliente']=$dataSaved['id_tienda'];
			$asociacionesXCliente[$key]['codigo_cliente']=$dataSaved['codigo_cliente'];
			$asociacionesXCliente[$key]['id_sociedad']=$asociaciones[$key];
		}
		try
			{
			\DB::beginTransaction();
			self::DeleteasociacionesPasadas($dataSaved['codigo_cliente'],$dataSaved['id_tienda']);
			if($asociaciones[0]!='Objetovacio')
			{
			\DB::table('tbl_clie_sociedad')->insert($asociacionesXCliente);
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
	public static function SociedadesSeleccionadas($id,$idtienda)
	{
	 return	ModelSociedadesporClientes::join('tbl_sociedad','tbl_sociedad.id','tbl_clie_sociedad.id_sociedad')
	 								->select(
										'tbl_clie_sociedad.id_sociedad AS id',
										'tbl_sociedad.nombre'
									 	)
									->where('tbl_clie_sociedad.codigo_cliente',$id)
									->where('tbl_clie_sociedad.id_tienda_cliente',$idtienda)
									->get();
	}
	public static function DeleteasociacionesPasadas($id,$idtienda)
	{
		\DB::table('tbl_clie_sociedad')->where('id_tienda_cliente',$idtienda)->where('codigo_cliente',$id)->delete();
	}
	public static function Update($id,$dataSaved){	
		return ModelAsociarSociedad::where('id',$id)->update($dataSaved);	
	}
	public static function getSelectListTipoCliente()
	{
		return ModelTipoCliente::select('id','nombre AS name')->where('estado', 1)->whereIn('id',[1,2])->get();
	}
}