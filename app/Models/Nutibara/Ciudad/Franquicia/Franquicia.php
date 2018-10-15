<?php 

namespace app\AccessObject\Nutibara\Franquicia;

use App\Models\Nutibara\Franquicia\Franquicia AS ModelFranquicia;

class Franquicia 
{
	public static function FranquiciaWhere($colum, $order,$search){
		return ModelFranquicia::select('id AS DT_RowId','nombre')
					->where('state', '1')
					->where(function ($query) use ($search){
						$query->orWhere('nombre', 'like', "%$search%");
					})
					->orderBy($colum, $order)
					->get();
	}

	public static function Franquicia($start,$end,$colum,$order){
		return ModelFranquicia::select('id AS DT_RowId','nombre','descripcion')
						->where('state',1)
						->get();
	}

	public static function getCountFranquicia(){
		return ModelFranquicia::where('state', '1')->count();
	}

	public static function getFranquiciaById($id){
		return ModelFranquicia::where('state', '1')->where('id',$id)->first();
	}

	public static function Create($dataSaved){
		$result=true;
		try{
			\DB::beginTransaction();
			\DB::table('tbl_franquicia')->insert($dataSaved);		
			\DB::commit();
		}catch(\Exception $e){
			dd($e);
			$result=false;			
			\DB::rollback();
		}
		return $result;
	}

	public static function Update($id,$dataSaved){	
		return ModelFranquicia::where('id',$id)->update($dataSaved);	
	}

	public static function getFranquicia(){
		return ModelFranquicia::select('id','nombre AS name')->where('state','1')->get();
	}

	public static function getSelectList()
	{
		return ModelFranquicia::select('id','nombre AS name')->where('state','1')->get();
	}
}