<?php

namespace App\Http\Controllers\Autenticacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\autenticacion\Role;
use Illuminate\Support\Facades\Validator;
use App\Usuario;
use Illuminate\Validation\Rule;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use DB;

class RolesController extends Controller
{
    public function showRoles()
    {
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'users/roles',
				'text'=>'Gestión de Usuarios'
			],
			[
				'href'=>'users/roles',
				'text'=>'Administrar Roles'
			]
		);
        return view('autenticacion.administrator.roles',['urls'=>$urls]);
    }  


	public function list(Request $request)
	{
		$select=DB::table('tbl_usuario_role')
					->select(
						'tbl_usuario_role.id AS DT_RowId',
						'tbl_usuario_role.nombre as Rol',
						'tbl_usuario_role.descripcion',						
						 DB::raw("IF(tbl_usuario_role.estado = 1, 'Activo', 'Inactivo ') AS estado")						
					);
					
		$search = array(
			[
				'tableName' => 'tbl_usuario_role', 
				'field' => 'nombre', 
				'method' => 'like', 
				'typeWhere' => 'where',
				'searchField' => null, 
				'searchDate' => null, 
			],
			[
				'tableName' => 'tbl_usuario_role', //tabla de busqueda 
				'field' => 'estado', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			]
		);

		$where = array(
			[
				'field' => 'tbl_usuario_role.estado', 
				'method' => '=', 
				'typeWhere' => 'where',
				'value' => 1, 
			]
		);
		$table=new DatatableBL($select,$search,$where);
		return $table->Run($request);
	}

	public function showCreateForm()
	{
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'users/roles',
				'text'=>'Gestión de Usuarios'
			],
			[
				'href'=>'users/roles',
				'text'=>'Administrar Roles'
			],
			[
				'href'=>'users/roles/create',
				'text'=>'Nuevo Rol'
			]
		);
        return view('autenticacion.roles',['urls'=>$urls]);
	}

	public function create(Request $request)
	{
		$this->validate($request, [
        	'nombre' => 'required|max:50|unique:tbl_usuario_role',
        	'descripcion' => 'max:200',
    	]);		 
		$isRole=Role::insert([
			'nombre'=>$request->nombre,
			'descripcion'=>$request->descripcion,
			'created_at'=>date("Y-m-d H:i:s") 
			]);
		if($isRole){
			$msm=ucwords(strtolower($request['nombre'])).' Creado correctamente!';			 
			return redirect('/users/roles')->with(['message'=>$msm]);			
		}else{
			$msm=ucwords(strtolower($request['nombre'])).' No se creo!';			 
			return redirect()->back()->with(['error'=>$msm]);
		}
	}

	public function delete(Request $request)
	{
		$isUser=Usuario::where('estado',1)->where('id_role',$request->id)->count();
		$rol=Role::where('id',$request->id)->first();
		if($isUser===0){
			$msm['val']=true;				
			$isrol=Role::where('id',$request->id)->update(['estado'=>0]);	
			if(!$isrol){
				$msm['val']=false;
				$msm['msm']='Rol '.$rol->nombre.' no desactivo.';
			}else{
				$msm['msm']='Rol '.$rol->nombre.' desactivado correctamente.';			
			}
		}else{
			$msm['val']=false;
			$msm['msm']='Rol '.$rol->nombre.' no se puede borrar, porque tiene usuarios asignados.';
		}
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function activateRol(Request $request)
	{
		$isUser=Usuario::where('estado',0)->where('id_role',$request->id)->count();
		$rol=Role::where('id',$request->id)->first();
		if($isUser===0){
			$msm['val']=true;				
			$isrol=Role::where('id',$request->id)->update(['estado'=>1]);	
			if(!$isrol){
				$msm['val']=false;
				$msm['msm']='Rol '.$rol->nombre.' no se activo.';
			}else{
				$msm['msm']='Rol '.$rol->nombre.' se activo correctamente.';			
			}
		}else{
			$msm['val']=false;
			$msm['msm']='Rol '.$rol->nombre.' no se puede borrar, porque tiene usuarios asignados.';
		}
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function showUpdateForm($id)
	{	
		$rol=Role::where('id',$id)->first();	
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'users/roles',
				'text'=>'Gestión de Usuarios'
			],
			[
				'href'=>'users/roles',
				'text'=>'Administrar Roles'
			],
			[
				'href'=>"users/roles/update/".$rol->id,
				'text'=>'Actualizar Rol'
			]
		);
        return view('autenticacion.administrator.rolesUpdate')->with(['rol'=>$rol,'urls'=>$urls]);	
	}

	public function update(Request $request)
	{
		$this->validate($request, [
        	'nombre' => [
				'required',
				 'max:50',
 				 Rule::unique('tbl_usuario_role')->ignore($request->id),
				],		
        	'descripcion' => 'max:200',
    	]);		 
		$isRole=Role::where('id',$request->id)->update(['nombre'=>$request->nombre,'descripcion'=>$request->descripcion]);
		if($isRole){
			$msm=ucwords(strtolower($request['nombre'])).' Actualizado correctamente!';			 
			return redirect(route('admin.roles'))->with(['message'=>$msm]);	
		}else{
			$msm=ucwords(strtolower($request['nombre'])).' No se creo!';			 
			return redirect()->back()->with(['error'=>$msm]);
		}
	}

	

}
 