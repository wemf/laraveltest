<?php

namespace App\Http\Controllers\Nutibara\Inventario;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\BusinessLogic\Nutibara\Inventario\InventarioBL;

class InventarioController extends Controller
{
	  //////////////////////////////////////////
	 /////////////////Index////////////////////
	//////////////////////////////////////////

	/*Vista del index */
    public function Index(){		
        $urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'inventario',
				'text'=>'Gestión Inventario'
			],
			[
				'href'=>'inventario',
				'text'=>'Generar Inventario'
			]
		);
        return view('Inventario.index',['urls'=>$urls]);
	}

	/*Carga la tabla del index */
	public function Get(Request $request)
	{
		return InventarioBL::Get($request);
	}

	/*Carga los estados del fitro de la tabla */
	public function GetEstado()
	{
		$response=InventarioBL::GetEstado();
		return response()->json($response);
	}

	  //////////////////////////////////////////
	 /////////////////Create///////////////////
	//////////////////////////////////////////

	/*Vista del create */
	public function ViewCreate(){
        $urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'inventario',
				'text'=>'Gestión Inventario'
			],
			[
				'href'=>'inventario/nuevo',
				'text'=>'Ingresar Inventario'
			]
		);
        return view('Inventario.create',['urls'=>$urls]);
	}

	/*Post create */
	public function Create(Request $request)
	{		
		$msm=InventarioBL::Create($request->all());
		if($msm['val']){
			Session::flash('message', $msm['msm']);
			return redirect('/inventario');
		}else{
			Session::flash('error', $msm['msm']);
			return redirect()->back();
		}
	}
	
	/*Lista referencias */
	public function GetReference(Request $request)
	{
		$response=InventarioBL::GetReference($request);
		return response()->json($response);
	}

	/*Lista descripcion */
	public function GetDescriptionById(Request $request)
	{
		$response=InventarioBL::GetDescriptionById($request->id);
		return response()->json($response);
	}

	/*Existe el lote */
	public function IsLote(Request $request)
	{
		$response=InventarioBL::IsLote($request->lote);
		return response()->json($response);
	}

	
	  //////////////////////////////////////////
	 /////////////////Update///////////////////
	//////////////////////////////////////////

	/*Vista del Update */
	public function ViewUpdate($id){
        $urls=array(
			[
				'href'=>'home',
				'text'=>'home'
			],
			[
				'href'=>'inventario',
				'text'=>'Gestión Inventario'
			],
			[
				'href'=>'inventario/actualizar',
				'text'=>'Actualizar Inventario'
			]
		);
		$inventario=InventarioBL::FindInventario($id);
		//dd($inventario);
        return view('Inventario.update',['urls'=>$urls,'entity'=>$inventario]);
	}

		/*Post Update */
		public function Update(Request $request)
		{
			$msm=InventarioBL::Update($request->all());
			if($msm['val']){
				Session::flash('message', $msm['msm']);
				return redirect('/inventario');
			}else{
				Session::flash('error', $msm['msm']);
				return redirect()->back();
			}
		}


}