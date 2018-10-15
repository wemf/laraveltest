<?php 

namespace App\AccessObject\Nutibara\Clientes\Cliente;

use App\Models\Nutibara\Clientes\Cliente\Cliente AS ModelCliente;

class Cliente 
{
	public static function ClienteWhere($colum, $order,$search){
		return ModelCliente::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								'descripcion AS descripcion'
								)
						->where('estado',1)
						->where(function ($query) use ($search){
								$query->where('nombre', 'like', "%".$search['nombre']."%");
							})
						->orderBy($colum, $order)
						->get();
	}

	public static function Cliente($start,$end,$colum,$order){
		return ModelCliente::select(
								'id AS DT_RowId',
								'nombre AS nombre',
								'descripcion AS descripcion'
								)
						        ->where('estado',1)	
						        ->get();
	}

	public static function getCountCliente(){
		return ModelCliente::where('estado', '1')->count();
	}

	public static function getClienteById($id){
		return ModelCliente::where('estado', '1')->where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result=true;
		try{
			\DB::beginTransaction();
			\DB::table('tbl_cliente')->insert($dataSaved);		
			\DB::commit();
		}catch(\Exception $e){
			$result=false;			
			\DB::rollback();
		}
		return $result;
	}

	public static function Update($id,$dataSaved){	
		return ModelCliente::where('id',$id)->update($dataSaved);	
	}

}