<?php 

namespace App\AccessObject\Datatable;
use DB;

class DatatableAO 
{
	protected $select;
	protected $search;
	protected $nameTable;
	protected $join;

	public function __construct($select,$search,$nameTable,$join,$where)
	{
		$this->select=$select;
		$this->search=$search;
		$this->nameTable=$nameTable;
		$this->join=$join;
		$this->where=$where;
	}

	public function Where($start,$end,$colum, $order){
		
		$search=$this->search;
		$join=$this->join;
		$querySelect = $this->DataSelect($this->select);
		$queryWhere = DB::table($this->nameTable);
		$this->MakeJoin($queryWhere,$join);
		$queryWhere->select(DB::raw($querySelect))		
					->skip($start)->take($end)		
					->where(function ($query) use ($search){
						for ($i=0; $i <count($search) ; $i++) { 
							$var = $search[$i]['typeWhere'];
							//searchField
							if($search[$i]['method']=='like' && $search[$i]['searchField']!=''){
								$searchField="%".$search[$i]['searchField']."%";
							}else{
								$searchField=$search[$i]['searchField'];									
							}
							$searchField2=$search[$i]['searchDate'];									
							//type consult
							if($searchField!=''){
								if($search[$i]['typeWhere']=='whereBetween'){
									if($searchField != '' && $searchField2 != ''){
										$query->$var($search[$i]['tableName'].".".$search[$i]['field'], [$searchField,$searchField2]);
									}
								}else{
									$query->$var($search[$i]['tableName'].".".$search[$i]['field'], $search[$i]['method'],$searchField);
								}
							}
						}		
					});	
			$queryWhere->orderBy($colum, $order);
			$retorno = $queryWhere->get();
		  	return $retorno;		
	}

	public function All($start,$end,$colum,$order){
		$join=$this->join;
		$where=$this->where;
		$querySelect = $this->DataSelect($this->select);
		$query = DB::table($this->nameTable)				
					->select(DB::raw($querySelect))
					->skip($start)->take($end)
					->orderBy($colum, $order);
					if(count($where) > 0 && $where <> ""){
						for ($i=0; $i < count($where); $i++) { 
							$query->where($where[$i]['field'],'=',$where[$i]['value']);
						}
					}
					$this->MakeJoin($query,$join);
		$retorno=$query->get();		
		return $retorno;
				//->toSql();//get();
	}

	public function MakeJoin(&$query,$join)
	{
		if(count($join) > 0 && $join <> ""){
			for ($i=0; $i < count($join); $i++) {
				if(isset($join[$i]['extraJoin'])){
					$extra=$join[$i]['extraJoin'];							
					$query->join($extra[0]['tabla'], function ($join2) use ($extra){
						for ($j=0; $j <count($extra); $j++) { 
							$join2->on($extra[$j]['id_tabla'],'=',$extra[$j]['on']);								
						}
					});	
				}else{
					$query->join($join[$i]['tabla'],$join[$i]['id_tabla'],'=',$join[$i]['on']);
				} 
			}
		}		
	}

	public function DataSelect($var){
		$sel = "";
		for ($i=0; $i < count($var); $i++) {
			$sel.= $var[$i].",";
		}
		$sel = substr($sel, 0, -1);
		return $sel;
	}
}