<?php 

namespace App\BusinessLogic\Datatable;
use App\AccessObject\Datatable\DatatableAO;
use config\messages;
use Exception;

class DatatableBL extends DatatableAO
{   

	public function __construct($select,$search,$nameTable,$join,$where)
	{
		$this->SelectException($select);
		$this->NameTableException($select);
		$this->SearchException($select);
		parent::__construct($select,$search,$nameTable,$join,$where);
	}

	private function SelectException($select)
	{
		if(empty($select)){
			$select="id AS DT_RowId,";
			$select.="\nnombre,";
			$select.="\nIF(estado = 1, 'SI', 'NO') AS estado";
			throw new Exception("Query (primer parametro) del select no puede estar vació.\nEjemplo:\n $select");
		}
		return true;
	}

	private function NameTableException($nameTable)
	{
		if(empty($nameTable)){
			
			throw new Exception("NameTable (tercer parametro) no puede estar vació.");
		}
		return true;
	}

	private function SearchException($search)
	{
		if(empty($search)){
			$searchExample=array(	
				[
					'tableName'=>'tbl_clie_eps',
					'field'=>'nombre',
					'method'=>'like',
					'typeWhere'=>'AND',//solo acapta AND o OR
					'searchField'=>null			
				],	
				[
					'tableName'=>'tbl_clie_eps',
					'field'=>'estado',
					'method'=>'=',
					'typeWhere'=>'AND',
					'searchField'=>null			
				]
			);
			if(!empty($search) && is_array($search) && array_key_exists('tableName',$searchExample) && array_key_exists('field',$searchExample) && array_key_exists('method',$searchExample) && array_key_exists('typeWhere',$searchExample) && array_key_exists('searchField',$searchExample)){
				throw new Exception("Search (segundo parametro) no cumple con la estructura.\nEjemplo:\n".var_dump($searchExample));
			}
			
			
		}
		return true;
	}

	private function Example()
	{
		$select = array( //parametros se busqueda select $select from
			'tien.nombre AS Tienda',
			'tipd.nombre AS Tipo_Dumento',
			'clie.numero_documento AS Numero_Documento',
			"CONCAT(	clie.nombres,	' ',clie.primer_apellido	) Nombres",
			'clie.telefono_celular AS Celular',
			'clie.direccion_residencia AS Direccion',
			'clie.correo_electronico',
			"IF(clie.estado = 1, 'Activo','Inactivo') AS estado"
		);
		$join = array(
		[
			'tabla' => 'tbl_tienda AS tien', //tabla a la que va el join
			'id_tabla' => 'clie.id_tienda', // campo de relacion de la tabla 
			'on' => 'tien.id' // campo con que se asocia join tabla.id_tabla on on
		],
		[
			'tabla' => 'tbl_clie_tipo_documento AS tipd',
			'id_tabla' => 'clie.id_tipo_documento',
			'on' => 'tipd.id'
		],
		[
			'tabla' => 'tbl_ciudad AS ciud',
			'id_tabla' => 'tien.id_ciudad',
			'on' => 'ciud.id'
		],
		[
			'tabla' => 'tbl_departamento AS depar',
			'id_tabla' => 'ciud.id_departamento',
			'on' => 'depar.id'
		],
		[
			'tabla' => 'tbl_pais AS pai',
			'id_tabla' => 'depar.id_pais',
			'on' => 'pai.id'
		],		
		[
			'extraJoin'=>array(
			[
				'tabla' => 'tbl_zona AS zon',
				'id_tabla' => 'pai.id',
				'on' => 'zon.id_pais'
			],
			[
				'tabla' => 'tbl_zona AS zon',
				'id_tabla' => 'tien.id_zona',
				'on' => 'zon.id'
			]
		)			
		]
		);

		$search = array(
			[
				'tableName' => 'pai', //tabla de busqueda 
				'field' => 'id', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],	
			[
				'tableName' => 'depar', //tabla de busqueda 
				'field' => 'nombre', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],
		);

		$where = array(
			[
				'field' => 'clie.estado',
				'value' => 1
			]
		);
		$nameTable="tbl_cliente AS clie"; //tabla
		$table=new DatatableBL($select,$search,$nameTable,$join,$where);
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
		for ($i=0; $i <count($arrayTemp) ; $i++) { 
			$a=str_replace($vowels, "", $request->columns[$i]['search']['value']);
			
			if($this->search[$i]['searchDate'] == true){
				$b = str_replace($vowels, "", $request->columns[$i + 1]['search']['value']);
			}
			if($a!='' && !$isSearch){
				$isSearch=true;
			}

			$this->search[$i]['searchField']=($a!='')?$a:null;
			$this->search[$i]['searchDate']=($b!='')?$b:null;
		}
		
		/////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////	
		$makeData2=$this->MakeData($start,$end,$colum, $order,$isSearch);
		$total=count($makeData2);
		
		$data=[     
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>$makeData2
		];
		return response()->json($data);
    }
	
}