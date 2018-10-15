<?php 

namespace App\AccessObject\Autenticacion;

use App\Models\Nutibara\Clientes\Cliente as ModelCliente;
use App\Models\autenticacion\UsuarioHuella;
use DB;
use App\Models\Nutibara\Clientes\TipoDocumento\TipoDocumento AS ModelTipoDocumento;

class LoginAO 
{
	/*Modulo Login con Token*/
	public static function WhoIsUser($idTypeDocument,$document){	
		return ModelCliente::join('tbl_usuario','tbl_usuario.id','=','tbl_cliente.id_usuario')
						   ->LeftJoin('tbl_usuario_huella','tbl_usuario_huella.id_cliente','=','tbl_cliente.codigo_cliente')
						   ->select(
							'tbl_usuario.id',
							'tbl_usuario.name',
							'tbl_usuario.email',
							'tbl_usuario.updated_at',
							'tbl_usuario.verify_token',
							 DB::raw("IF(tbl_usuario_huella.huella is not null, 'true', 'false') AS isHuella")
						   )
						  ->where('tbl_cliente.id_tipo_documento',$idTypeDocument)
						  ->where('tbl_cliente.numero_documento',$document)
						  ->where('tbl_usuario.estado',1)
						  ->first();
	}

	/*Modulo Login con Token Huella*/
	public static function WhoIsUserByHuella($idTypeDocument,$document){	
		return ModelCliente::join('tbl_usuario','tbl_usuario.id','=','tbl_cliente.id_usuario')
						   ->join('tbl_usuario_huella','tbl_usuario_huella.id_cliente','=','tbl_cliente.codigo_cliente')
						   ->select(
							'tbl_usuario.id',
							'tbl_usuario.name',
							'tbl_usuario.email',
							'tbl_usuario.updated_at',
							'tbl_usuario.verify_token',
							'tbl_usuario_huella.huella',
							'tbl_usuario.modo_ingreso' //0=>biometrico
						   )
						  ->where('tbl_cliente.id_tipo_documento',$idTypeDocument)
						  ->where('tbl_cliente.numero_documento',$document)
						  ->where('tbl_usuario.estado',1)
						  ->first();
	}

	/*Modulo Registar Huella*/
	public static function WhoIsClient($idTypeDocument,$document){	
		return ModelCliente::join('tbl_usuario','tbl_usuario.id','=','tbl_cliente.id_usuario')
							->select(
								'tbl_cliente.codigo_cliente AS id_cliente',
								'tbl_cliente.id_tienda'
							)
							->where('tbl_cliente.id_tipo_documento',$idTypeDocument)
							->where('tbl_cliente.numero_documento',$document)
							->where('tbl_usuario.estado',1)
							->first();
	}

	/*Valida si tiene Huella registrada*/
	public static function IsHuella($userHuellaEntity){	
		return UsuarioHuella::where('id_tienda',$userHuellaEntity['id_tienda'])
									->where('id_cliente',$userHuellaEntity['id_cliente'])
									->count();
	}

	/*Modulo Registar Huella*/
	public static function CreateHuella($userHuellaEntity){	
		return UsuarioHuella::insert($userHuellaEntity);
	}

	//Modulo Contracto
	public static function getTipoDocumentoByContrato(){
		return ModelTipoDocumento::select('id','nombre AS name')
								->where('estado','1')
								->where('contrato','1')
								->get();
	}

	public static function WhoIsUserByHuellaByContracto($idTypeDocument,$document){	
		return ModelCliente::join('tbl_usuario_huella','tbl_usuario_huella.id_cliente','=','tbl_cliente.codigo_cliente')
						   ->select(
							'tbl_cliente.nombres AS name',
							'tbl_usuario_huella.huella'
						   )
						  ->where('tbl_cliente.id_tipo_documento',$idTypeDocument)
						  ->where('tbl_cliente.numero_documento',$document)
						  ->first();
	}

	public static function ValidateIsUserByHuellaByContracto($idTypeDocument,$document){	
		return ModelCliente::join('tbl_usuario_huella','tbl_usuario_huella.id_cliente','=','tbl_cliente.codigo_cliente')
						  ->where('tbl_cliente.id_tipo_documento',$idTypeDocument)
						  ->where('tbl_cliente.numero_documento',$document)
						  ->count();
	}

	public static function WhoIsClientByContrato($idTypeDocument,$document){	
		return DB::table("tbl_usuario_huella_cola")
				 ->where('tbl_usuario_huella_cola.id_tipo_documento',$idTypeDocument)
				 ->where('tbl_usuario_huella_cola.documento',$document)
				 ->first();
	}

	public static function createHuellaByContrato($userHuellaEntity){	
		return DB::table("tbl_usuario_huella_cola")->insert($userHuellaEntity);
	}

	public static function updateHuellaByContrato($userHuellaEntity){	
		return DB::table("tbl_usuario_huella_cola")
				->where('tbl_usuario_huella_cola.id_tipo_documento',$userHuellaEntity["id_tipo_documento"])
				->where('tbl_usuario_huella_cola.documento',$userHuellaEntity["documento"])
				->update($userHuellaEntity);
	}

	public static function ValidateClient($idTypeDocument,$document){	
		return ModelCliente::select(
							'tbl_cliente.codigo_cliente as id_cliente',
							'tbl_cliente.id_tienda'
						   )
						  ->where('tbl_cliente.id_tipo_documento',$idTypeDocument)
						  ->where('tbl_cliente.numero_documento',$document)
						  ->first();
	}


}