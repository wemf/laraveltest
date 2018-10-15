<?php 

namespace App\BusinessLogic\Nutibara\GestionTesoreria\MovimientosContables;

use App\AccessObject\Nutibara\GestionTesoreria\MovimientosContables\MovimientosContables AS mov_contables;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use  App\BusinessLogic\Nutibara\Excel\MovimientosContables\MovimientosContablesExcel;

class  CrudMovimientosContables{

    public static function get($request,$fecha_inicio){
        $dateA=$request->columns[7]['search']['value'];
        $dateB=$request->columns[8]['search']['value'];
        $search = array(
            [//0
                'tableName' => 'tbl_pais', //tabla de busqueda
                'field' => 'id', //campo que en el que se va a buscar
                'method' => '=', // metodo a utiliza = o like
                'typeWhere' => 'where', // typo where orwhere wherebetween etc...
                'searchField' => null, // valor de campo siempre se envia null
                'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
            ],
            [//1
                'tableName' => 'tbl_departamento',
                'field' => 'id',
                'method' => '=',
                'typeWhere' => 'where',
                'searchField' => null,
                'searchDate' => null
            ],
            [//2
                'tableName' => 'tbl_ciudad',
                'field' => 'id',
                'method' => '=',
                'typeWhere' => 'where',
                'searchField' => null,
                'searchDate' => null
            ],
            [//3
                'tableName' => 'tbl_zona',
                'field' => 'id',
                'method' => '=',
                'typeWhere' => 'where',
                'searchField' => null,
                'searchDate' => null
            ],
            [//4
                'tableName' => 'tbl_tienda',
                'field' => 'id',
                'method' => '=',
                'typeWhere' => 'where',
                'searchField' => null,
                'searchDate' => null
            ],
            [//5
				'tableName' => 'tbl_cont_movimientos_contables',
				'field' => 'id_tipo_documento',
				'method' => '=',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
            ],
            [//6
				'tableName' => 'tbl_cont_movimientos_contables',
				'field' => 'codigo_movimiento',
				'method' => '=',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
            ],
		);
        if(!empty($dateA) && empty($dateB)){
            array_push($search, [//7
				'tableName' => 'tbl_cont_movimientos_contables',
				'field' => 'fecha',
				'method' => '>',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
            ]);
        }else if(empty($dateA) && !empty($dateB)){
            array_push($search, [//7
				'tableName' => 'tbl_cont_movimientos_contables',
				'field' => 'fecha',
				'method' => '<',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
            ]);
        }else{
            array_push($search, [//7 
				'tableName' => 'tbl_cont_movimientos_contables',
				'field' => 'fecha',
				'method' => '=',
				'typeWhere' => 'whereBetween',
				'searchField' => null,
				'searchDate' => 'datetime',
            ]);
            array_push($search, [//8 
				'tableName' => 'tbl_cont_movimientos_contables',
				'field' => 'fecha',
				'method' => '=',
				'typeWhere' => 'whereBetween',
				'searchField' => null,
				'searchDate' => 'datetime',
            ]);
        }
        $select = mov_contables::get();
		$where = array(
			[
				'field' => 'tbl_cont_movimientos_contables.fecha', 
				'method' => '>',
				'typeWhere' => 'where',
				'value' => $fecha_inicio,
			]
		);
        $table=new DatatableBL($select,$search,$where);
		return $table->Run($request);
    }
    
    public static function tipoDocumento(){
        return mov_contables::tipoDocumento();
    }

    public static function paises(){
        return mov_contables::paises();
    }

    public static function exportToExcel($request){
	  	$MovimientosContablesExcel=new MovimientosContablesExcel();
      	$getExcel =mov_contables::getExcel($request);
        return $MovimientosContablesExcel->ExportExcel($getExcel);
    }

    public static function logMovimientosContables($codigo_cierre,$numero_orden,$id_tienda,$id_tipo_documento){
        return mov_contables::logMovimientosContables($codigo_cierre,$numero_orden,$id_tienda,$id_tipo_documento);
    }
}