<?php 

namespace App\AccessObject\Datatable_v2;
use DB;

class DatatableAO 
{
	protected $select;
	protected $search;
	protected $where;
	protected $where_rule;

	public function Where($start,$end,$colum, $order){
		$where=$this->where;
		$where_rule=$this->where_rule;
		$search=$this->search;
		$query=$this->select;
		$query->skip($start)->take($end)		
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
									if($searchField != '' && $searchField2 != '')
									{
										$query->$var($search[$i]['tableName'].".".$search[$i]['field'], [$searchField,$searchField2]);
									}
								}else{
									$query->$var($search[$i]['tableName'].".".$search[$i]['field'], $search[$i]['method'],$searchField);
								}
							}
						}		
				});	
			if(count($where_rule) > 0 && $where_rule <> ""){			
				for ($i=0; $i < count($where_rule); $i++) { 
					$typeWhere = $where_rule[$i]['typeWhere'];
					$method=$where_rule[$i]['method'];
					$query->$typeWhere($where_rule[$i]['field'],$method,$where_rule[$i]['value']);
				}
			}
			$query->orderBy($colum, $order);
			// $retorno = $query->toSql();
			$retorno = $query->get();
		  	return $retorno;		
	}

	public function Count($start,$end,$colum, $order){
		$where=$this->where;
		$where_rule=$this->where_rule;
		$search=$this->search;
		$query=$this->select;
		$query->where(function ($query) use ($search){
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
									if($searchField != '' && $searchField2 != '')
									{
										$query->$var($search[$i]['tableName'].".".$search[$i]['field'], [$searchField,$searchField2]);
									}
								}else{
									$query->$var($search[$i]['tableName'].".".$search[$i]['field'], $search[$i]['method'],$searchField);
								}
							}
						}		
				});	
			if(count($where_rule) > 0 && $where_rule <> ""){			
				for ($i=0; $i < count($where_rule); $i++) { 
					$typeWhere = $where_rule[$i]['typeWhere'];
					$method=$where_rule[$i]['method'];
					$query->$typeWhere($where_rule[$i]['field'],$method,$where_rule[$i]['value']);
				}
			}
			$query->orderBy($colum, $order);
			// $retorno = $query->toSql();
			$retorno = $query->get();
			$retorno = count($retorno);
		  	return $retorno;	 
	}

	public function All($start,$end,$colum,$order){
		$where=$this->where;
		$where_rule=$this->where_rule;
		$search=$this->search;
		$query=$this->select;
		$query->skip($start)->take($end)
			  ->orderBy($colum, $order);
		if(count($where) > 0 && $where <> ""){			
			for ($i=0; $i < count($where); $i++) { 
				$typeWhere = $where[$i]['typeWhere'];
				$method=$where[$i]['method'];
				$query->$typeWhere($where[$i]['field'],$method,$where[$i]['value']);
			}
		}
		if(count($where_rule) > 0 && $where_rule <> ""){			
			for ($i=0; $i < count($where_rule); $i++) { 
				$typeWhere = $where_rule[$i]['typeWhere'];
				$method=$where_rule[$i]['method'];
				$query->$typeWhere($where_rule[$i]['field'],$method,$where_rule[$i]['value']);
			}
		}
		$retorno=$query->get();		
		// $retorno = $query->toSql();
		return $retorno;
	}

}