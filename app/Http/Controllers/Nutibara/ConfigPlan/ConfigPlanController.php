<?php

namespace App\Http\Controllers\Nutibara\ConfigPlan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Nutibara\ConfigPlan\ConfigPlanBL;
use App\BusinessLogic\Nutibara\Clientes\Empleado\CrudEmpleado;
use Illuminate\Support\Facades\Session;
use App\AccessObject\Nutibara\Clientes\PersonaNatural\PersonaNatural;
use dateFormate;


class ConfigPlanController extends Controller {
    
    public function index() {
		$urls = array(
			[
				'href' => 'home',
				'text' => 'home'
			],
			[
				'href' => 'gestionplan/config',
				'text' => 'Gestión de Plan Separe'
			],
			[
				'href' => 'gestionplan/config',
				'text' => 'Configuración de Plan Separe'
			]
		);
		return view( 'GenerarPlan.Configuracion.index', [ 'urls' => $urls ] );
    }

    public function get( Request $request ) {
		$start = ( int ) $request->start;
		$end =( int ) $request->length;
		$draw = ( int ) $request->draw;   
		$colum =$request->columns[ ( int ) $request->order[ 0 ][ 'column' ] ][ 'data' ];
		$order =$request->order[ 0 ][ 'dir' ];
		$search = [];
        $vowels = array( "$", "^" );
        
		$search[ "pais" ] = str_replace( $vowels, "", $request->columns[ 0 ][ 'search' ][ 'value' ] );
		$search[ "departamento" ] = str_replace( $vowels, "", $request->columns[ 1 ][ 'search' ][ 'value' ] );
		$search[ "ciudad" ] = str_replace( $vowels, "", $request->columns[ 2 ][ 'search' ][ 'value' ] );
		$search[ "tienda" ] = str_replace( $vowels, "", $request->columns[ 3 ][ 'search' ][ 'value' ] );
		$search[ "montodesde" ] = str_replace( $vowels, "", $request->columns[ 4 ][ 'search' ][ 'value' ] );
		$search[ "montohasta" ] = str_replace( $vowels, "", $request->columns[ 5 ][ 'search' ][ 'value' ] );
		$search[ "vigente" ] = str_replace( $vowels, "", $request->columns[ 6 ][ 'search' ][ 'value' ] );
        $search[ "estado" ] = str_replace( $vowels, "", $request->columns[ 7 ][ 'search' ][ 'value' ] );
        
        $total = ConfigPlanBL::getCount( $search );
        
		$data = [
			"draw" => $draw,
			"recordsTotal" => $total,
			"recordsFiltered" => $total,
			"data"=>dateFormate::ToArrayInverse(ConfigPlanBL::get($start,$end,$colum, $order,$search)->toArray())
        ];   
        
		return response()->json( $data );
	}

    public function create() {

		$urls = array(
			[
				'href' => 'home',
				'text' => 'home'
			],
			[
				'href' => 'gestionplan/config',
				'text' => 'Gestión de Plan Separe'
			],
			[
				'href' => 'gestionplan/config',
				'text' => 'Configuración de Plan Separe'
            ],
			[
				'href' => 'gestionplan/config/create',
				'text' => 'Nueva Configuración de Plan Separe'
			]
		);
		return view( 'GenerarPlan.Configuracion.create', [ 'urls' => $urls ] );
    }

    public function store( request $request ) {
		$data = [
			'id_pais' => ( trim( $request->pais ) == "" ) ? 0 : trim( $request->pais ),
			'id_departamento' => ( trim( $request->departamento ) == "" ) ? 0 : trim( $request->departamento ),
			'id_ciudad' => ( trim( $request->ciudad ) == "" ) ? 0 : trim( $request->ciudad ),
			'id_tienda' => ( trim( $request->tienda ) == "") ? 0 : trim( $request->tienda ),
			'monto_desde' => ( trim( $request->monto_desde ) == "" ) ? 0 : self::limpiarVal( $request->monto_desde ),
			'monto_hasta' => ( trim( $request->monto_hasta ) == "" ) ? 0 : self::limpiarVal( $request->monto_hasta ),
			'fecha_hora_vigencia_desde' => trim( $request->fecha_hora_vigencia_desde ),
			'fecha_hora_vigencia_hasta' => trim( $request->fecha_hora_vigencia_hasta ),
			'termino_contrato' => trim( $request->termino_contrato ),
			'porcentaje_retroventa' => trim( $request->porcentaje_retroventa ),
			'estado' => 1
        ];
        // dd($data);
        $msm = ConfigPlanBL::store( $data );
        
		if( $msm['val'] == 'Insertado' ) {
			Session::flash( 'message', $msm[ 'msm' ] );
			return redirect( '/gestionplan/config' );	
		}
		elseif( $msm[ 'val' ] == 'Error' ) {
			Session::flash( 'error', $msm[ 'msm' ] );
		}
		elseif( $msm[ 'val' ] == 'ErrorUnico' ) {
			Session::flash( 'warning', $msm[ 'msm' ] );
        }
        
		return redirect()->back();
    }

    public function edit( $id ) {
		$data=dateFormate::ToArrayInverse(ConfigPlanBL::getById($id)->toArray());
		$configplan=(object)$data;
		$urls = array(
			[
				'href' => 'home',
				'text' => 'home'
			],
			[
				'href' => 'gestionplan/config',
				'text' => 'Gestión de Plan Separe'
			],
			[
				'href' => 'gestionplan/config',
				'text' => 'Configuración de Plan Separe'
            ],
			[
				'href' => 'gestionplan/config/edit/' . $id,
				'text' => 'Editar Configuración de Plan Separe'
			]
		);
		return view( 'GenerarPlan.Configuracion.edit', [ 'configplan' => $configplan, 'urls' => $urls ] );
	}

    public function update( request $request ) {
		$id = ( int ) $request->id;
		$data = [
			'id_pais' => ( trim( $request->pais) == "" ) ? 0 : trim( $request->pais ),
			'id_ciudad' => ( trim( $request->ciudad ) == "" ) ? 0 : trim( $request->ciudad ),
			'id_departamento' => ( trim( $request->departamento ) == "" ) ? 0 : trim( $request->departamento ),
			'id_tienda' => ( trim( $request->tienda ) == "" ) ? null : trim( $request->tienda ),
			'monto_desde' => ( trim( $request->monto_desde ) == "" ) ? 0 : self::limpiarVal( $request->monto_desde ),
			'monto_hasta' => ( trim( $request->monto_hasta ) == "" ) ? 0 : self::limpiarVal( $request->monto_hasta ),
			'fecha_hora_vigencia_desde' => trim( $request->fecha_hora_vigencia_desde ),
			'fecha_hora_vigencia_hasta' => trim( $request->fecha_hora_vigencia_hasta ),
			'termino_contrato' => trim( $request->termino_contrato ),
			'porcentaje_retroventa' => trim( $request->porcentaje_retroventa )
		];

        $msm = ConfigPlanBL::update( $id, $data );
        
		if( $msm[ 'val' ] == 'Actualizado' ) {
			Session::flash( 'message', $msm[ 'msm' ] );
			return redirect( '/gestionplan/config' );
		}
		elseif( $msm[ 'val' ] == 'Error' ) {
			Session::flash( 'error', $msm[ 'msm' ] );
		}
		elseif( $msm[ 'val' ] == 'ErrorUnico' ) {
			Session::flash( 'warning', $msm[ 'msm' ] );
        }
        
		return redirect()->back();
	}

    public function inactive( request $request ) {
		$msm = ConfigPlanBL::inactive( $request->id );
		$a = array( 'msm' => $msm );
		return response()->json( $a );
	}

	public function active( request $request ) {
		$msm = ConfigPlanBL::active( $request->id );
		$a = array( 'msm' => $msm );
		return response()->json( $a );
	}

	public function delete( request $request ) {
		$msm=ConfigPlanBL::delete( $request->id );
		$a=array( 'msm' => $msm );
		return response()->json( $a );
	}

	public function limpiarVal( $val ) {
		$valLimpiar = str_replace( '.', '', $val );
		$valLimpiar = str_replace( ',', '.', $valLimpiar );
		$valLimpiar = trim( $valLimpiar );
		return $valLimpiar;
	}

}
