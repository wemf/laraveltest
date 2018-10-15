<?php

namespace App\AccessObject\FileManager;
use App\Models\FileManager\File_manager;

class FileManagerAccessObject {	

	public  static function buscarHash($hash){
		return File_manager::where('hash',$hash)->where('estado', '1')->count();
	}

	public  static function buscarIdHash($hash){
		return File_manager::select('id')->where('hash',$hash)->where('estado', '1')->first();
	}

	public static function FileManagers(){
		return File_manager::where('estado', '1')->get();
	}

	public static function Create($guardar){
		$id = File_manager::insertGetId($guardar);
		return $id;
	}

	public static function Create2($guardar){	
		$result=true;
		try{
			\DB::beginTransaction();
			\DB::table('tbl_sys_archivo')->insert($guardar);
			\DB::commit();
		}catch(\Exception $e){
			$result=false;
			\DB::rollback();
		}
		return $result;
	}

	public static function Find($id_FileManager){
		return File_manager::find($id_FileManager);
	}

	public static function Delete($id){
		$fileManager = File_manager::find($id);
		$fileManager->estado=0;
		$fileManager->delete_at=date("Y-m-d H:i:s");
		$fileManager->id_user_delete_at=\Auth::id();
		return $result=$fileManager->save();

	}

	public static function DeleteFiles($ids){
		return File_manager::whereIn('id',$ids)
							->update([
								'estado' => '0'
							]);
	}

	public static function Rollback($key_lote){
		return File_manager::where('key_lote',$key_lote)->delete();

	}

}
