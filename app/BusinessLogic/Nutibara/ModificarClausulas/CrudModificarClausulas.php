<?php 

namespace App\BusinessLogic\Nutibara\ModificarClausulas;

use App\AccessObject\Nutibara\ModificarClausulas\ModificarClausulas AS modClausulas;
use App\Models\Nutibara\SecuenciaTienda\SecuenciaTienda AS ModelSecuenciaTienda;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\BusinessLogic\Datatable_v2\DatatableBL;

class CrudModificarClausulas 
{
    public static function get($request)
    {
		$select=modClausulas::get();
		
        $search = array(
			[
				'tableName' => 'tbl_sys_modificar_clausulas', //tabla de busqueda 
				'field' => 'pais', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],
			[
				'tableName' => 'tbl_sys_modificar_clausulas', //tabla de busqueda 
				'field' => 'departamento', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],
			[
				'tableName' => 'tbl_sys_modificar_clausulas', //tabla de busqueda 
				'field' => 'ciudad', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],
			
			[
				'tableName' => 'tbl_sys_modificar_clausulas', //tabla de busqueda 
				'field' => 'tienda', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
            ],
			[
				'tableName' => 'tbl_sys_modificar_clausulas',
				'field' => 'nombre_clausula', 
				'method' => 'like', 
				'typeWhere' => 'where', 
				'searchField' => null, 
				'searchDate' => null,
			],
			[
				'tableName' => 'tbl_sys_detalle_modificarclausula',
				'field' => 'vigencia_desde', 
				'method' => 'like', 
				'typeWhere' => 'where', 
				'searchField' => null, 
				'searchDate' => null,
			]
			
           
        );
        $where = array(
		);
		$table=new DatatableBL($select,$search,$where);
		
		
		return $table->Run($request);
	}
	public static function paises(){
		return modClausulas::paises();
	}

	public static function getById($id,$vigencia){
		return modClausulas::getById($id,$vigencia);
	}
	public static function getViewId($id){
		return modClausulas::getViewId($id);
	}

	public static function create($dataSaved){
		return modClausulas::create($dataSaved);
	}
	public static function createDetalle($dataSaved){
		return modClausulas::createDetalle($dataSaved);
	}
	public static function updateDetalle($id,$detalleSaved){
		return modClausulas::updateDetalle($id,$detalleSaved);
	}

	public static function FindId($clausula){
		return modClausulas::FindId($clausula);
	}

	public static function FindClausula($data){
		return modClausulas::FindClausula($data);
	}
}