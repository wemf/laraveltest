<?php 

namespace App\BusinessLogic\Datatable_v2;
use App\AccessObject\Datatable_v2\DatatableAO;
use config\messages;
use Exception;
USE DB;
use dateFormate;

class DatatableBL extends DatatableAO
{   
	protected $select;
	protected $search;
	protected $where;


	public function __construct($select,$search,$where)
	{
	   $this->select=$select;
	   $this->search=$search;
	   $this->where=$where;
	}

	private function Example()
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

	private function MakeData($start,$end,$colum, $order,$isSearch)
    {
		if($isSearch)
        {
			$result = $this->Where($start,$end,$colum, $order);
		}else
        {
			$result = $this->All($start,$end,$colum,$order);
		}
		return $result;
	}

	public function Run($request){
    	$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;   
		$colum=$request->columns[(int)$request->order[0]['column']]['data']; 
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		/////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////
		$arrayTemp=$this->search;
		$isSearch=false;
		$b = '';
		$a = '';
		for ($i=0; $i <count($arrayTemp) ; $i++) { 
			// dd($this->search[8]);
			if($this->search[$i]['searchDate'] == 'datetime'){
				$a=str_replace($vowels, "", $request->columns[$i]['search']['value'].' 00:00:00');
				$this->search[$i]['searchField'] = ($a != ' 00:00:00') ? $a : null;
				
				$b = str_replace($vowels, "", $request->columns[$i + 1]['search']['value'].' 23:59:59');
				$this->search[$i]['searchDate']=($b!=' 23:59:59')?$b:null;
				$i++;
			}else{
				$a=str_replace($vowels, "", $request->columns[$i]['search']['value']);
				$this->search[$i]['searchField'] = ($a != '') ? $a : null;

				if($this->search[$i]['searchDate'] == true){
					$b = str_replace($vowels, "", $request->columns[$i + 1]['search']['value']);
					$this->search[$i]['searchDate']=($b!='')?$b:null;
					$i++;
				}

			}

			if($a!='' && $a != ' 00:00:00' && !$isSearch){
				$isSearch=true;
			}
		}
		 
		/////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////
		$totalFiltered = $this->Count($start,$end,$colum, $order,$isSearch);
		$makeData2= dateFormate::ToArrayInverse($this->MakeData($start,$end,$colum, $order,$isSearch)->toArray());
		$total=count($makeData2);
		$data=[     
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $totalFiltered,
			"data"=> $makeData2
		];
		return response()->json($data);
    }
	
}