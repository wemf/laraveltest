<?php 

namespace App\AccessObject\Nutibara\AsociarCliente\AsociarTienda;

use App\Models\Nutibara\AsociarCliente\AsociarTienda\AsociarTienda AS ModelAsociarTienda;
use App\Models\Nutibara\AsociarCliente\TipoCliente\TipoCliente AS ModelTipoCliente;
use App\Models\Nutibara\AsociarCliente\TiendasporCliente\TiendasporCliente AS ModelTiendasporClientes;

class AsociarTienda 
{
	public static function AsociarTiendaWhere($start,$end,$colum, $order,$search){
		if($search['estado'] == "")
		$search['estado'] = 1;
		
		return ModelAsociarTienda::join('tbl_tienda','tbl_tienda.id','tbl_cliente.id_tienda')
						->join('tbl_clie_tipo','tbl_clie_tipo.id','tbl_cliente.id_tipo_cliente')
						->join('tbl_clie_tipo_documento','tbl_clie_tipo_documento.id','tbl_cliente.id_tipo_documento')
						->join("tbl_ciudad AS ciud","tbl_tienda.id_ciudad", "=", "ciud.id")
						->join("tbl_departamento AS depar","ciud.id_departamento","=", "depar.id")
						->join("tbl_pais AS pai" , "depar.id_pais", "=", "pai.id")
						->join("tbl_clie_empleado", function ($join) {
							$join->on("tbl_cliente.codigo_cliente", "=", "tbl_clie_empleado.codigo_cliente");
							$join->on("tbl_cliente.id_tienda", "=" ,"tbl_clie_empleado.id_tienda");
						})
						->join("tbl_zona AS zon", function ($join) {
							$join->on("pai.id", "=" ,"zon.id_pais");
							$join->on("tbl_tienda.id_zona", "=", "zon.id");
						})
						->leftJoin("tbl_empl_cargo","tbl_empl_cargo.id","=","tbl_clie_empleado.id_cargo_empleado")
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
							if($search['tipodocliente'] != "")									
							$query->where('tbl_clie_tipo.nombre', 'like', "%".$search['tipodocliente']."%");
							if($search['tipodocumento'] != "")							
							$query->where('tbl_clie_tipo_documento.nombre_abreviado', 'like', "%".$search['tipodocumento']."%");
							if($search['documento'] != "")														
							$query->where('tbl_cliente.numero_documento', 'like', "%".$search['documento']."%");
							if($search['nombre'] != "")														
							$query->where('tbl_cliente.nombres', 'like', "%".$search['nombre']."%");
							if($search['primerapellido'] != "")														
							$query->where('tbl_cliente.primer_apellido', 'like', "%".$search['primerapellido']."%");
							if($search['segundoapellido'] != "")														
							$query->where('tbl_cliente.segundo_apellido', 'like', "%".$search['segundoapellido']."%");
																					
							$query->where('tbl_cliente.estado', '=', $search['estado']);
							})					
						->whereNotIn('tbl_cliente.id_tipo_cliente',[2,3,4,5,6])
						->skip($start)->take($end)		
						->orderBy($colum, $order)	
						->orderBy('tbl_cliente.nombres', 'asc')	
						->orderBy('tbl_cliente.primer_apellido', 'asc')	
						->orderBy('tbl_cliente.segundo_apellido', 'asc')
						->distinct()
						->get();
	}

	public static function AsociarTienda($start,$end,$colum,$order){
		return ModelAsociarTienda::join('tbl_tienda','tbl_tienda.id','tbl_cliente.id_tienda')
							->join('tbl_clie_tipo','tbl_clie_tipo.id','tbl_cliente.id_tipo_cliente')
							->join('tbl_clie_tipo_documento','tbl_clie_tipo_documento.id','tbl_cliente.id_tipo_documento')
							->join("tbl_ciudad AS ciud","tbl_tienda.id_ciudad", "=", "ciud.id")
							->join("tbl_departamento AS depar","ciud.id_departamento","=", "depar.id")
							->join("tbl_pais AS pai" , "depar.id_pais", "=", "pai.id")
							->join("tbl_clie_empleado", function ($join) {
								$join->on("tbl_cliente.codigo_cliente", "=", "tbl_clie_empleado.codigo_cliente");
								$join->on("tbl_cliente.id_tienda", "=" ,"tbl_clie_empleado.id_tienda");
							})
							->join("tbl_zona AS zon", function ($join) {
								$join->on("pai.id", "=" ,"zon.id_pais");
								$join->on("tbl_tienda.id_zona", "=", "zon.id");
							})
							->leftJoin("tbl_empl_cargo","tbl_empl_cargo.id","=","tbl_clie_empleado.id_cargo_empleado")
							->select(
								'tbl_cliente.codigo_cliente AS DT_RowId',
								'tbl_tienda.id AS id_tienda',
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
							->whereNotIn('tbl_cliente.id_tipo_cliente',[2,3,4,5,6])
							->skip($start)->take($end)
							->orderBy($colum, $order)
							->orderBy('tbl_cliente.nombres', 'asc')	
							->orderBy('tbl_cliente.primer_apellido', 'asc')	
							->orderBy('tbl_cliente.segundo_apellido', 'asc')
							->distinct()
						    ->get();
	}

	public static function getCountAsociarTienda($start,$end,$colum, $order,$search)
	{
		if($search['estado'] == "")
		$search['estado'] = 1;
		return ModelAsociarTienda::join('tbl_tienda','tbl_tienda.id','tbl_cliente.id_tienda')
		->join('tbl_clie_tipo','tbl_clie_tipo.id','tbl_cliente.id_tipo_cliente')
		->join('tbl_clie_tipo_documento','tbl_clie_tipo_documento.id','tbl_cliente.id_tipo_documento')
		->join("tbl_ciudad AS ciud","tbl_tienda.id_ciudad", "=", "ciud.id")
		->join("tbl_departamento AS depar","ciud.id_departamento","=", "depar.id")
		->join("tbl_pais AS pai" , "depar.id_pais", "=", "pai.id")
		->join("tbl_clie_empleado", function ($join) {
			$join->on("tbl_cliente.codigo_cliente", "=", "tbl_clie_empleado.codigo_cliente");
			$join->on("tbl_cliente.id_tienda", "=" ,"tbl_clie_empleado.id_tienda");
		})
		->join("tbl_zona AS zon", function ($join) {
			$join->on("pai.id", "=" ,"zon.id_pais");
			$join->on("tbl_tienda.id_zona", "=", "zon.id");
		})
		->leftJoin("tbl_empl_cargo","tbl_empl_cargo.id","=","tbl_clie_empleado.id_cargo_empleado")
		->where(function ($query) use ($search){
			if($search['tipodocliente'] != "")									
				$query->where('tbl_clie_tipo.nombre', 'like', "%".$search['tipodocliente']."%");
			if($search['tipodocumento'] != "")							
				$query->where('tbl_clie_tipo_documento.nombre_abreviado', 'like', "%".$search['tipodocumento']."%");
			if($search['documento'] != "")														
				$query->where('tbl_cliente.numero_documento', 'like', "%".$search['documento']."%");
			if($search['nombre'] != "")														
				$query->where('tbl_cliente.nombres', 'like', "%".$search['nombre']."%");
			if($search['primerapellido'] != "")														
				$query->where('tbl_cliente.primer_apellido', 'like', "%".$search['primerapellido']."%");
			if($search['segundoapellido'] != "")														
				$query->where('tbl_cliente.segundo_apellido', 'like', "%".$search['segundoapellido']."%");
																	
			$query->where('tbl_cliente.estado', '=', $search['estado']);
			})					
		->whereNotIn('tbl_cliente.id_tipo_cliente',[2,3,4,5,6])
		->count();
	}

	public static function getAsociarTiendaById($id,$id_tienda){
		return ModelAsociarTienda::where('codigo_cliente',$id)->where('id_tienda',$id_tienda)->first();
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

	public static function CreateTiendas($dataSaved,$asociaciones)
	{
		$result="Insertado";
		$asociacionesXCliente = array();
		foreach ($asociaciones as $key => $value) {
			$asociacionesXCliente[$key]['id_tienda_cliente']=$dataSaved['id_tienda'];
			$asociacionesXCliente[$key]['codigo_cliente']=$dataSaved['codigo_cliente'];
			$asociacionesXCliente[$key]['id_tienda']=$asociaciones[$key];
		}
		try
			{
			\DB::beginTransaction();
			self::DeleteasociacionesPasadas($dataSaved['codigo_cliente'],$dataSaved['id_tienda']);
			if($asociaciones[0]!='Objetovacio')
			{
			\DB::table('tbl_clie_tienda')->insert($asociacionesXCliente);
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
	public static function TiendasSeleccionadas($id,$idtienda)
	{
	 return	ModelTiendasporClientes::join('tbl_tienda','tbl_tienda.id','tbl_clie_tienda.id_tienda')
	 								->select(
										'tbl_clie_tienda.id_tienda AS id',
										'tbl_tienda.nombre'
									 	)
									->where('tbl_clie_tienda.codigo_cliente',$id)
									->where('tbl_clie_tienda.id_tienda_cliente',$idtienda)
									->where('tbl_clie_tienda.tienda_principal', 0)
									->get();
	}
	public static function DeleteasociacionesPasadas($id,$idtienda)
	{
		\DB::table('tbl_clie_tienda')->where('id_tienda_cliente',$idtienda)->where('codigo_cliente',$id)->delete();
	}
	public static function Update($id,$dataSaved){	
		return ModelAsociarTienda::where('id',$id)->update($dataSaved);	
	}
	public static function getSelectListTipoCliente()
	{
		return ModelTipoCliente::select('id','nombre AS name')->where('estado', 1)->whereNotIn('id',[2,3,4,5,6])->get();
	}

	
}