<?php

namespace App\Http\Controllers\Autenticacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\autenticacion\Modulo;
use App\Models\autenticacion\Role;
use App\Models\autenticacion\RoleFuncionalidad;
use App\Models\autenticacion\Funcionalidad;
use Illuminate\Support\Facades\Validator;
use DB;

class ModuleController extends Controller
{
    public function showModuleForm()
    {
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'users/roles/module',
				'text'=>'Gestión de Usuarios'
			],
			[
				'href'=>'users/roles/module',
				'text'=>'Asignar Roles'
			]
		);
		return view('autenticacion.administrator.modules',['urls'=>$urls]);
    } 

	public function update(Request $request)
	{
		$msm=array(
			'state'=>true,
			'msm'=>'Rol actualizado correctamente.'
		);
		if(!$this->Create($request)){
			$msm['state']=false;
			$msm['msm']='Rol no actualizado.';
		}		
		return response()->json($msm)->header('Content-Type', 'application/json');		
	}

	public function Create($request){	
		$result=true;
		try{
			DB::beginTransaction();
			$isFuncion=DB::table('tbl_usuario_role_funcionalidad')->where($request->all())->count();
			if($isFuncion>0){
				DB::table('tbl_usuario_role_funcionalidad')->where($request->all())->delete();
			}else{
				DB::table('tbl_usuario_role_funcionalidad')->insert($request->all());
			}	
			DB::commit();
		}catch(\Exception $e){
			$result=false;
			DB::rollback();
		}
		return $result;
	}

	public function viewFunction($id)
	{
		$modulo=Modulo::join('tbl_usuario_funcionalidad', 'tbl_usuario_funcionalidad.id_modulo','=','tbl_usuario_modulo.id')
						->select(
							'tbl_usuario_modulo.nombre as modulo',
							'tbl_usuario_funcionalidad.ocultar_menu',
							'tbl_usuario_funcionalidad.id_padre',
							DB::raw("GROUP_CONCAT(tbl_usuario_funcionalidad.id) AS id_funcionalidad"), 
							DB::raw("GROUP_CONCAT(tbl_usuario_funcionalidad.nombre)  as funcionalidad") 
						)
						->groupBy('tbl_usuario_modulo.nombre')
						->groupBy('tbl_usuario_funcionalidad.ocultar_menu')
						->groupBy('tbl_usuario_funcionalidad.id_padre')
						->orderBy('tbl_usuario_modulo.nombre')
						->orderBy('tbl_usuario_funcionalidad.ocultar_menu','DESC')
						->get();

		$funcionalidades=Funcionalidad::select('id','nombre')->get();

		$roles=Role::join('tbl_usuario_role_funcionalidad', 'tbl_usuario_role_funcionalidad.id_role','=','tbl_usuario_role.id')
					->select(
						'tbl_usuario_role_funcionalidad.id_funcionalidad',
						'tbl_usuario_role.nombre as role'
					)
					->distinct()
					->where('tbl_usuario_role.id',$id)
					->get();

		$nameRole=Role::find($id);

		$arrayModulo=array(
			'data'=>array(),
			'idRole'=>$id,
			'role'=>(!empty($nameRole))?$nameRole->nombre:'Error',
		);
		$arrayModuloTemp=array();

		foreach ($modulo as $key => $db) {
			if($db->ocultar_menu==1)
				continue;		
			
			$a=array(
				"modulo"=> $db->modulo,
				"funcionalidad"=>array(
									'id'=>explode(',',$db->id_funcionalidad),
									'value'=>explode(',',$db->funcionalidad),
									'isChecked'=>$this->isChecked($roles, $db->id_funcionalidad),
								)
			);

			if($db->id_padre==0){
				for ($i=0; $i <count($a["funcionalidad"]["id"]) ; $i++) { 
					$aTemp=array(
						"modulo"=> $a["funcionalidad"]["value"][$i],
						"funcionalidad"=>array(
											'id'=>$a["funcionalidad"]["id"][$i],
											'value'=>$a["funcionalidad"]["value"][$i],
											'isChecked'=>$a["funcionalidad"]["isChecked"][$i],
										)
					);
					array_push($arrayModuloTemp,$aTemp);
				}
			}else{
				$a["modulo"]=$funcionalidades->find($db->id_padre)->nombre;
				array_push($arrayModuloTemp,$a);
			}

			$arrayModulo['data'][$db->modulo]=$arrayModuloTemp;	

			if(count($modulo)-1==$key){
				break;
			}

			if($db->modulo!=$modulo[$key+1]->modulo){
				$arrayModuloTemp=[];							
			}
		}
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'users/roles/module',
				'text'=>'Gestión de Usuarios'
			],
			[
				'href'=>'users/roles/module',
				'text'=>'Asignar Roles'
			],
			[
				'href' => 'users/roles/module/view/function/'.$id,
				'text' => 'Asignar Funcionalidades'
			],
		);
		return view('autenticacion.administrator.modulesFunction',['urls'=>$urls], $arrayModulo);
	}

	public function isChecked($roles, $idFuncionalidad)
	{
		$array=array();
		$idFuncionalidadArray=explode(',',$idFuncionalidad);		
		for ($i=0; $i <count($idFuncionalidadArray) ; $i++) 
		{ 
			$id=$idFuncionalidadArray[$i];
			if($this->findIdFuncion($roles,$id)){
				array_push($array,true);
			}else{
				array_push($array,false);
			}
		}
		return $array;
	}

	public function findIdFuncion($roles,$id)
	{
		foreach ($roles as $key => $db) {
			if($db->id_funcionalidad==$id){
				return true;
			}
		}
		return false;
	}
}
 