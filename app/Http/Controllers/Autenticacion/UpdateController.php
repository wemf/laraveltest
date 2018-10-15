<?php

namespace App\Http\Controllers\Autenticacion;

use App\Usuario;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\autenticacion\Role;
use Illuminate\Support\Facades\Validator;
use App\AccessObject\Nutibara\Clientes\Empleado\Empleado;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use DB;

class UpdateController extends Controller
{
    public function users()
    {
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'users',
				'text'=>'Gestión de Usuarios '
			],
			[
				'href'=>'users',
				'text'=>'Administrar Usuarios'
			]
		);
		return view('autenticacion.administrator.users',['urls'=>$urls]);
    }   

    public function Roles (){
        return response()->json(Role::select('id', 'nombre as name')->where('estado',1)->orderBy('nombre', 'asc')->get());
	} 

	public function getCountUsers(){
		return Usuario::count();
	}

	public function listUser(Request $request)
	{
		$select=DB::table('tbl_usuario')
			    ->join('tbl_usuario_role', 'tbl_usuario_role.id', '=', 'tbl_usuario.id_role')
				->select(
					'tbl_usuario.id AS DT_RowId',
					'tbl_usuario_role.nombre AS Role',
					'tbl_usuario.name',
					'tbl_usuario.email',
					'tbl_usuario.modo_ingreso',
					DB::raw("IF(tbl_usuario.estado = 1, 'SI', 'NO') AS estado")                                               
				);

		$search = array(
			[
				'tableName' => 'tbl_usuario_role', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where',
				'searchField' => null, 
				'searchDate' => null, 
			],
			[
				'tableName' => 'tbl_usuario', //tabla de busqueda 
				'field' => 'name', //campo que en el que se va a buscar
				'method' => 'like', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],	
			[
				'tableName' => 'tbl_usuario', 
				'field' => 'email', 
				'method' => 'like', 
				'typeWhere' => 'where',
				'searchField' => null, 
				'searchDate' => null, 
			],
			[
				'tableName' => 'tbl_usuario', 
				'field' => 'estado', 
				'method' => '=', 
				'typeWhere' => 'where',
				'searchField' => null, 
				'searchDate' => null, 
			]
		);

		$where = array(
			[
				'field' => 'tbl_usuario.estado', 
				'method' => '=', 
				'typeWhere' => 'where',
				'value' => 1, 
			]
		);
		$table=new DatatableBL($select,$search,$where);
		return $table->Run($request);
	}

	public function isActivated(Request $request)
	{		
		$state=0;	
		$msm['val']=true;
		$user=Usuario::where('id',$request->id)->first();
		if((int)$user->estado>0){
			$state=Usuario::where('id',$request->id)->update(['estado'=>0]);
			$msm['msm']='Usuario '.$user->name.' desactivado correctamente.';		
		}else{
			$state=Usuario::where('id',$request->id)->update(['estado'=>1]);
			$msm['msm']='Usuario '.$user->name.' activado correctamente.';
		}

		if(!$state){
			$msm['val']=false;
			$msm['msm']='Usuario'.$user->name.' no se actualizado';
		}
		$a=array('msm'=>$msm);
		return response()->json($a);
	}

	public function showUpdateForm($id)
	{		
		$user=Usuario::where('id',$id)->first();
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'users',
				'text'=>'Gestión de Usuarios '
			],
			[
				'href'=>'users',
				'text'=>'Administrar Usuarios'
			],
			[
				'href' => 'users/update/'.$id,
				'text' => 'Actualizar Usuario'
			],
		);
		return view('autenticacion.administrator.update',['user' => $user,'urls'=>$urls]);
	}

	protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

	protected function validator2(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);
    }

	public function update(Request $data)
	{
		 $response=array(
            'msm'=>array(),
            'state'=>true,
            'user'=>array()
		);
		$pass=(isset($data['password']))?$data['password']:(Str::random(40));
        $isUser=Usuario::where(['email'=>$data['email'],'estado'=>1])->where('id', '<>', $data->id)->count();
        if($isUser==0){
			Empleado::updateUserClient($data['id'],$data['email']);
            $msm=ucwords(strtolower($data['name'])).' Actualizado correctamente!'.' con el Email: '.strtolower($data['email']);
            $response['msm']=['message'=>$msm];
			if(empty($data['password']) &&  empty($data['password_confirmation']) ){
		 		$this->validator2($data->all())->validate();				
				$response['user']= Usuario::where('id', $data->id)->update([
					'name' => $data['name'],
					'email' => $data['email'],
					'id_role'=>$data['id_role'],
					'modo_ingreso' => $data['modo_ingreso'],
				]);
			}else{
		 		$this->validator($data->all())->validate();				
				$response['user']= Usuario::where('id', $data->id)->update([
					'name' => $data['name'],
					'modo_ingreso' => $data['modo_ingreso'],
					'email' => $data['email'],
					'password' => bcrypt($pass),
					'id_role'=>$data['id_role'],
				]);
			}
           
        }else{
            $msm='Hola '.ucwords(strtolower($data['name'])).' el email: '.strtolower($data['email'].' ya se encuentra en uso.');            
            $response['msm']=['error'=>$msm];
            $response['state']=false;
        }

		//Retornar
        if($response['state']!=false){
            return redirect('/users')->with($response['msm']);
        }else{
            return redirect()->back()->with($response['msm']);          
        }
	}

	public function updateAjax(Request $data)
	{
		 $response=array(
            'msm'=>array(),
            'state'=>true,
            'user'=>array()
        );
		$isUser=Usuario::where(['email'=>$data['email'],'estado'=>1])->where('id', '<>', $data->id)->count();
        if($isUser==0){
			Empleado::updateUserClient($data['id'],$data['email']);
            $msm=ucwords(strtolower($data['name'])).' Actualizado correctamente!'.' con el Email: '.strtolower($data['email']);
            $response['msm']=$msm;
			if(empty($data['password']) &&  empty($data['password_confirmation']) ){
		 		$this->validator2($data->all())->validate();				
				$response['user']= Usuario::where('id', $data->id)->update([
					'name' => $data['name'],
					'email' => $data['email'],
					'id_role'=>$data['id_role'],
					'modo_ingreso' => $data['modo_ingreso'],
				]);
			}else{
		 		$this->validator($data->all())->validate();				
				$response['user']= Usuario::where('id', $data->id)->update([
					'name' => $data['name'],
					'modo_ingreso' => $data['modo_ingreso'],
					'email' => $data['email'],
					'password' => bcrypt($pass),
					'id_role'=>$data['id_role'],
				]);
			}
           
        }else{
            $msm='Hola '.ucwords(strtolower($data['name'])).' el email: '.strtolower($data['email'].' ya se encuentra en uso.');            
            $response['msm']=$msm;
            $response['state']=false;
        }

		//Retornar
        $a=array(
            'msm'=>$response['msm'],
            'val'=>$response['state']
         );
         return response()->json(['msm'=>$a]);
	}
}
 