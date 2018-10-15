<?php

namespace App\Http\Controllers\Nutibara\ModificarClausulas;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Http\Middleware\userIpValidated;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\BusinessLogic\Nutibara\ModificarClausulas\CrudModificarClausulas AS modClausulas;
use App\BusinessLogic\Nutibara\Pais\CrudPais AS Pais;

class ModificarClausulasController extends Controller
{
    public function Index(){
        $ipValidation = new userIpValidated();
		$TiendaActual = Contrato::getTiendaByIp($ipValidation->getRealIP());
        $urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'modificarClausulas',
				'text'=>'Gestionar Cláusulas'
			]
			
        );
        return view('ModificarClausulas.index',['urls'=>$urls,
												'TiendaActual' => $TiendaActual
												]);
	}
	public function get(Request $request)
    {
    	return modClausulas::get($request);
	}

	
	
	public function create(){
		$paises=modClausulas::paises();
		
		$urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'modificarClausulas',
				'text'=>'Gestionar Cláusulas'
			],
			[
				'href' => 'modificarClausulas/create',
				'text' => 'Nueva Cláusula'
			],
		);
		return view('ModificarClausulas.create',
		[
			'urls'=>$urls,
			'paises'=>$paises
		]
	);
	}
	public function CreatePost(Request $request){
		//VALIDAR INFO REQUEST
		
		$this->validate($request, [
			'pais' => 'required',
			'fecha_cracionD' => 'required',
			'nombreclausula'=>'required|min:5|max:250',
			'clausula'=>'required|min:5|max:500',
		]);
		
		$clausulaSaved=[
			'id_pais' => $request->pais,
			'id_departamento' => ($request->departamento==0)?null:$request->departamento ,
			'id_ciudad' => ($request->ciudad==0)?null:$request->ciudad ,
			'id_tienda' => ($request->tienda==0)?null:$request->tienda ,
			'nombre_clausula'=> $request->nombreclausula,
		];
		

		$id=modClausulas::FindId($request->nombreclausula);
		
		if($id=="" || $id==null){
			
			$msm=modClausulas::create($clausulaSaved);	
		}
		else{
			$msm="El registro ya existe, por favor intentelo de nuevo";
		}
		
		//recuperar el id
		if($msm=="Insertado")
		{
			$id=modClausulas::FindId($request->nombreclausula);
			
			$detalleSaved=[
			'id_clausula'=> $id->id,
			'descripcion_clausula'=> $request->clausula,
			'vigencia_desde' => $request->fecha_cracionD ,
			];
			$msd=modClausulas::createDetalle($detalleSaved);
		}elseif($msm!=null || $msm!=""){
			Session::flash('error',$msm);
			return redirect('/modificarClausulas/create');
		}

		if($msm =='Insertado' && $msd =='Insertado'){
			Session::flash('message','El registro ha sido guardado');
			return redirect('/modificarClausulas');
		}
		else{
			Session::flash('error','El registro no fue guardado');
			return redirect('/modificarClausulas');
		}
		//return redirect('/modificarClausulas');

	}

	public function update(request $request,$id){
		
		if($id!=""){
			//seleccionamos la clausula vigente
			$clausulavigente=modClausulas::getViewId($id);
			//v
			
			if($clausulavigente!=null){
				//si clausula es vigente
				$clausula=modClausulas::getById($id,$clausulavigente->vigencia_desde);
			}else{
				//busca si la clausula tiene fecha posterior
				$clausula=modClausulas::getById($id,date('Y-m-d'));
			}
			
			if(count($clausula)>0){
				$urls=array(
					[
						'href'=>'home',
						'text'=>'home'
					],
					[
						'href'=>'modificarClausulas',
						'text'=>'Gestionar Cláusulas'
					],
					[
						'href' => 'modificarClausulas/update',
						'text' => 'Actualizar Cláusula'
					],
				);
				return view('ModificarClausulas.update',
					['urls'=>$urls,'clausula'=>$clausula]
					);
			}else{
				Session::flash('warning','No se encontró ningún registro');
			return redirect('/modificarClausulas');
			}
		
		}else{
			Session::flash('error','Se necesita más información');
			return redirect('/modificarClausulas');
		}
		
	}

	public function updatePost(Request $request){
		
		//VALIDAR INFO REQUEST
		$this->validate($request, [
			'id'=>'required',
			'pais' => 'required',
			
			'fecha_cracionD' => 'required',
			'nombreclausula'=>'required|min:5|max:250',
			'clausula'=>'required|min:5|max:500',
		]);
		
		if($request->id != ""){
			$clausula=modClausulas::getById($request->id,$request->vigencia_desde);
				if(count($clausula)>1 && $request->id_detalle!=""){
					
					$detalleSaved=[
						'descripcion_clausula'=> $request->clausula,
						'vigencia_desde' => $request->fecha_cracionD ,
						];
						
					$msd=modClausulas::updateDetalle($request->id_detalle,$detalleSaved);
				}else{
					//dd($request->all());
					$detalleSaved=[
						'id_clausula'=> $request->id,
						'descripcion_clausula'=> $request->clausula,
						'vigencia_desde' => $request->fecha_cracionD ,
						];
					$msd=modClausulas::createDetalle($detalleSaved);
				}
				
				
		}
		
		if($msd =='Insertado'){
			Session::flash('message','El registro ha sido guardado');
			return redirect('/modificarClausulas');
		}
		else{
			Session::flash('error','El registro no fue guardado');
			return redirect('/modificarClausulas');
		}
		return redirect('/modificarClausulas');
		

	}

	public function view($id){
		$clausula=modClausulas::getViewId($id);
		
		if(count($clausula)>0){
			$urls=array(
				[
					'href'=>'home',
					'text'=>'home'
				],
				[
					'href'=>'modificarClausulas',
					'text'=>'Gestionar Cláusulas'
				],
				[
					'href' => 'modificarClausulas/view',
					'text' => 'Ver Cláusula'
				],
			);
			return view('ModificarClausulas.view',
			['urls'=>$urls,
			'clausula'=>$clausula		]);
		}else{
			Session::flash('warning','La Cláusula no esta vigente');
			return redirect('/modificarClausulas');
		}
		
	}

	public function FindClausula(){
		$data=[
			'id'=>'8',
			'id_pais'=>'12',
			'id_departamento'=>'19',
			'id_ciudad'=>null,
			'id_tienda'=>null,
		];
		$clausula=modClausulas::FindClausula($data);
		
		dd($clausula);
	}

	public function delete(){
		return modClausulas::delete($request);
	}
}