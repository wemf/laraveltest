<?php 

namespace App\AccessObject\Nutibara\Tienda;

use App\Models\Nutibara\Tienda\Tienda AS ModelTienda;
use App\Models\Nutibara\Tienda\TiendaHorario AS ModelTiendaHorario;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;

class Tienda 
{
	public static function TiendaWhere($start,$end,$colum, $order,$search){
		return ModelTienda::join('tbl_ciudad','tbl_ciudad.id','tbl_tienda.id_ciudad')		
						->join('tbl_zona','tbl_zona.id','tbl_tienda.id_zona')
						->join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')						
						->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
						->join('tbl_franquicia','tbl_franquicia.id','tbl_tienda.id_franquicia')
						->join('tbl_sociedad','tbl_sociedad.id','tbl_tienda.id_sociedad')
						->select(
								'tbl_tienda.id AS DT_RowId',
								'tbl_tienda.nombre AS nombre',
								'tbl_tienda.ip_fija',
								'tbl_tienda.direccion',
								'tbl_tienda.telefono',
								'tbl_tienda.codigo_tienda',
								'tbl_franquicia.nombre AS franquicia',
								'tbl_sociedad.nombre AS sociedad',
								'tbl_zona.nombre AS zona',
								'tbl_ciudad.nombre AS ciudad',
								'tbl_departamento.nombre AS departamento',
								'tbl_pais.nombre AS pais',
								'tbl_tienda.ip_fija AS ip_tienda',
								'tbl_pais.codigo_telefono AS indicativo',
								\DB::raw("IF(tbl_tienda.estado = 1, 'SI', 'NO') AS estado"),
								\DB::raw("IF(tbl_tienda.festivo = 1, 'SI', 'NO') AS festivo"),
								\DB::raw("IF(tbl_tienda.todoeldia = 1, 'SI', 'NO') AS todoeldia")
								)
						->where(function ($query) use ($search){
								$query->where('tbl_pais.id', 'like', "%".$search['pais']."%");
								$query->where('tbl_departamento.id', 'like', "%".$search['departamento']."%");
								$query->where('tbl_ciudad.id', 'like', "%".$search['ciudad']."%");								
								$query->where('tbl_zona.id', 'like', "%".$search['zona']."%");
								$query->where('tbl_tienda.nombre', 'like', "%".$search['tienda']."%");
								$query->where('tbl_tienda.codigo_tienda', 'like', "%".$search['codigo_tienda']."%");								
								$query->where('tbl_franquicia.nombre', 'like', "%".$search['franquicia']."%");
								$query->where('tbl_sociedad.nombre', 'like', "%".$search['sociedad']."%");
								$query->where('tbl_tienda.ip_fija', 'like', "%".$search['ip_tienda']."%");
								$query->where('tbl_tienda.estado', '=', $search['estado']);
							})
						->skip($start)->take($end)						
						->orderBy($colum, $order)
						->get();
	}

	public static function Tienda($start,$end,$colum,$order){
		return ModelTienda::join('tbl_ciudad','tbl_ciudad.id','tbl_tienda.id_ciudad')
						->join('tbl_zona','tbl_zona.id','tbl_tienda.id_zona')
						->join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')						
						->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
						->join('tbl_franquicia','tbl_franquicia.id','tbl_tienda.id_franquicia')
						->join('tbl_sociedad','tbl_sociedad.id','tbl_tienda.id_sociedad')
						->select(
								'tbl_tienda.id AS DT_RowId',
								'tbl_tienda.nombre AS nombre',
								'tbl_tienda.ip_fija',
								'tbl_tienda.direccion',
								'tbl_tienda.codigo_tienda',
								'tbl_tienda.telefono',
								'tbl_ciudad.nombre AS ciudad',
								'tbl_franquicia.nombre AS franquicia',
								'tbl_sociedad.nombre AS sociedad',
								'tbl_zona.nombre AS zona',
								'tbl_tienda.ip_fija AS ip_tienda',								
								'tbl_departamento.nombre AS departamento',
								'tbl_pais.codigo_telefono AS indicativo',
								'tbl_pais.nombre AS pais',
								\DB::raw("IF(tbl_tienda.estado = 1, 'SI', 'NO') AS estado"),
								\DB::raw("IF(tbl_tienda.festivo = 1, 'SI', 'NO') AS festivo"),
								\DB::raw("IF(tbl_tienda.todoeldia = 1, 'SI', 'NO') AS todoeldia")
								)
						->where('tbl_tienda.estado',1)	
						->skip($start)->take($end)
						->orderBy($colum, $order)
						->get();
	}

	public static function getCountTienda($search){
		return ModelTienda::join('tbl_ciudad','tbl_ciudad.id','tbl_tienda.id_ciudad')		
						->join('tbl_zona','tbl_zona.id','tbl_tienda.id_zona')
						->join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')						
						->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
						->join('tbl_franquicia','tbl_franquicia.id','tbl_tienda.id_franquicia')
						->join('tbl_sociedad','tbl_sociedad.id','tbl_tienda.id_sociedad')
						->where(function ($query) use ($search){
							$query->where('tbl_pais.id', 'like', "%".$search['pais']."%");
							$query->where('tbl_departamento.id', 'like', "%".$search['departamento']."%");
							$query->where('tbl_ciudad.id', 'like', "%".$search['ciudad']."%");								
							$query->where('tbl_zona.id', 'like', "%".$search['zona']."%");
							$query->where('tbl_tienda.nombre', 'like', "%".$search['tienda']."%");
							$query->where('tbl_tienda.codigo_tienda', 'like', "%".$search['codigo_tienda']."%");								
							$query->where('tbl_franquicia.nombre', 'like', "%".$search['franquicia']."%");
							$query->where('tbl_sociedad.nombre', 'like', "%".$search['sociedad']."%");
							$query->where('tbl_tienda.estado', '=', $search['estado']);
							})->count();
	}

	public static function getTiendaByZona($zona){
		return ModelTienda::select('id', 'nombre', 'nombre as name')->where('id_ciudad', $zona)->orderBy('nombre', 'asc')->get();
	}

	public static function getTiendaByZona2($zona){
		return ModelTienda::select('id', 'nombre', 'nombre as name')
							->where('id_ciudad', $zona)
							->where('sede_principal', 0)
							->where('tipo_bodega', 0)
							->orderBy('nombre', 'asc')
							->get();
	}

	public static function getTiendaById($id){
		return ModelTienda::join('tbl_ciudad','tbl_ciudad.id','tbl_tienda.id_ciudad')
						->join('tbl_zona','tbl_zona.id','tbl_tienda.id_zona')
						->join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
						->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
						->join('tbl_franquicia','tbl_franquicia.id','tbl_tienda.id_franquicia')
						->join('tbl_sociedad','tbl_sociedad.id','tbl_tienda.id_sociedad')
						->select(
								'tbl_tienda.id',
								'tbl_tienda.nombre AS nombre',
								'tbl_tienda.ip_fija',
								'tbl_tienda.direccion',
								'tbl_tienda.telefono',
								'tbl_tienda.codigo_tienda',
								'tbl_tienda.festivo',
								'tbl_tienda.todoeldia',
								'tbl_ciudad.id AS id_ciudad',
								'tbl_franquicia.id AS id_franquicia',
								'tbl_sociedad.id AS id_sociedad',
								'tbl_zona.id AS id_zona',
								'tbl_departamento.id AS id_departamento',
								'tbl_ciudad.codigo_dane AS indicativo',
								'tbl_pais.id AS id_pais',
								'tbl_tienda.tienda_padre',
								'tbl_tienda.sede_principal',
								'tbl_tienda.tipo_bodega',
								'tbl_tienda.monto_max'
								)
						->where('tbl_tienda.id',$id)
						->first();
	}
	public static function getHorarioByIdTienda($id)
	{
		return ModelTiendaHorario::join('tbl_sys_dias','tbl_sys_dias.id','tbl_tienda_horario.id_dia')
								  ->select(
											'tbl_sys_dias.dias',
											'tbl_tienda_horario.hora_inicio',
											'tbl_tienda_horario.hora_cierre'
											)
								  ->where('tbl_tienda_horario.id_tienda',$id)
								  ->orderBy('tbl_tienda_horario.id')
								  ->get();
	}

	public static function Create($dataSaved,$horario,$saldo_cierre_caja){
			$result="Insertado";
		try{
			\DB::beginTransaction();
			$id = \DB::table('tbl_tienda')->insertGetId($dataSaved);
			self::insertSecuenciaTienda($id);
			if ($horario !== null) 
			self::insertarHorarios($id,$horario);
			self::insertarCierredeCaja($id,$saldo_cierre_caja);
			\DB::commit();
		}catch(\Exception $e){
			if($e->getCode() == 23000)
			{
				$result='ErrorUnico';
			}
			else
			{
				$result = 'Error';
			}
			\DB::rollback();
			dd($e);			
		}
		return $result;
	}
	public static function insertSecuenciaTienda($id)
	{
		$tipos = \DB::table('tbl_sys_secuencia_tipo')->select('sec_tipo')->get();
		for($i = 0; $i < count($tipos); $i++)
		{	
			\DB::table('tbl_secuencia_tienda_x')->insert([
					'id_tienda' => $id,
					'sec_tipo' => $tipos[$i]->sec_tipo,
					'sec_desde' => 1,
					'sec_hasta' => 1000000,
					'sec_siguiente' => 1,
					'estado' => 1
			]);
		}
		return true;
	}
	public static function insertarHorarios($id,$horario)
	{
		$tablaHorarios = array();
		$iddialunes = env('ID_DIA_LUNES');
		for ($i=0; $i < count($horario) ; $i++) 
		{ 
			
			$tablaHorarios[$i]['id_tienda']=$id;
			$tablaHorarios[$i]['id_dia']=$iddialunes;
			$tablaHorarios[$i]['hora_inicio']=$horario[$i]['hora_inicio'];
			$tablaHorarios[$i]['hora_cierre']=$horario[$i]['hora_cierre'];
			$iddialunes ++;
		}
		ModelTiendaHorario::where('id_tienda',$id)
							->delete();
		ModelTiendaHorario::insert($tablaHorarios);

	}
	public static function getSelectList(){
		return ModelTienda::select('id', 'nombre', 'nombre as name')->orderBy('nombre', 'asc')->get();
	}

	public static function Update($id,$dataSaved,$horario){	
		$result="Actualizado";
		try
		{
			\DB::beginTransaction();			
			ModelTienda::where('id',$id)->update($dataSaved);
			if ($horario !== null) 
			{
			 self::insertarHorarios($id,$horario);
			}
			\DB::commit();
		}catch(\Exception $e)
		{
			if($e->getCode() == 23000)
			{
				$result='ErrorUnico';
			}
			else
			{
				$result = 'Error';
			}
		}
		return $result;	
	}

	public static function IsIp($ip)
	{
		return ModelTienda::where('ip_fija',$ip)->where('estado',1)->count();
	}

	public static function getTiendaByCiudad($id)
    {
		return ModelTienda::select('id', 'nombre AS name')->where('estado',1)->where('id_ciudad',$id)->orderBy('nombre', 'asc')->get();
	}

	public static function getTiendaBySociedad($id)
    {
		return ModelTienda::select('id', 'nombre AS name')->where('estado',1)->where('id_sociedad',$id)->orderBy('nombre', 'asc')->get();
	}

	public static function getTiendaByDepartamento($id)
    {
		return ModelTienda::join('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_tienda.id_ciudad')->select('tbl_tienda.id', 'tbl_tienda.nombre AS name')->where('tbl_tienda.estado',1)->where('tbl_ciudad.id_departamento',$id)->orderBy('tbl_tienda.nombre', 'asc')->get();
	}

	public static function getTiendaByPais($id)
    {
		return ModelTienda::join('tbl_ciudad', 'tbl_ciudad.id', '=', 'tbl_tienda.id_ciudad')
							->join('tbl_departamento', 'tbl_departamento.id', '=', 'tbl_ciudad.id_departamento')
							->select('tbl_tienda.id', 'tbl_tienda.nombre AS name')
							->where('tbl_tienda.estado',1)
							->where('tbl_departamento.id_pais',$id)
							->orderBy('tbl_tienda.nombre', 'asc')
							->get();
	}

	public static function getTiendaisnt($id)
    {
		return ModelTienda::select('id', 'nombre AS name')
							->where('estado',1)
							->where('id','<>',$id)
							->orderBy('nombre', 'asc')
							->get();		
	}

	public static function selectTiendaBySociedad($id)
    {
		return ModelTienda::select('id', 'nombre AS name')->where('estado',1)->where('id_sociedad',$id)->get();
	}

	public static function ValidateMarket($campo,$data)
    {
		return ModelTienda::where($campo,$data)->count();
	}

	public static function getPDC($id_tienda)
	{
		return ModelTienda::join('tbl_ciudad','tbl_ciudad.id','tbl_tienda.id_ciudad')
						  ->join('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
						  ->join('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
						  ->where('tbl_tienda.id',$id_tienda)
						  ->select(
							  	'tbl_tienda.id as id_tienda',
							  	'tbl_tienda.nombre as nombre_tienda',
								'tbl_ciudad.id as id_ciudad',
								'tbl_ciudad.nombre as nombre_ciudad',
								'tbl_departamento.id as id_departamento',
								'tbl_departamento.nombre as nombre_departamento',
								'tbl_pais.id as id_pais',
								'tbl_pais.nombre as nombre_pais'
						  )
						  ->first();
	}

	public static function getTiendaByIp($ip){
		return ModelTienda::select(
								'tbl_tienda.id',
								'tbl_tienda.codigo_tienda',
								'tbl_tienda.nombre',
								'tbl_tienda.direccion',
								'tbl_tienda.telefono',
								'tbl_sociedad.nit',
								'tbl_sociedad.nombre as nombre_sociedad',
								'tbl_clie_regimen_contributivo.nombre as nombre_regimen',
								'tbl_ciudad.id AS id_ciudad',
								'tbl_ciudad.nombre AS nombre_ciudad',
								'tbl_departamento.id AS id_departamento',
								'tbl_departamento.nombre AS nombre_departamento',
								'tbl_pais.id AS id_pais',
								'tbl_pais.nombre AS nombre_pais',
								'tbl_zona.id AS id_zona',
								'tbl_zona.nombre AS nombre_zona',
								'tbl_franquicia.nombre as nombre_franquicia',
								'tbl_franquicia.correo_habeas'
							)
							->leftJoin('tbl_ciudad','tbl_ciudad.id','tbl_tienda.id_ciudad')
							->leftJoin('tbl_departamento','tbl_departamento.id','tbl_ciudad.id_departamento')
							->leftJoin('tbl_pais','tbl_pais.id','tbl_departamento.id_pais')
							->leftJoin('tbl_zona','tbl_zona.id', 'tbl_tienda.id_zona')
							->leftJoin('tbl_sociedad','tbl_sociedad.id','tbl_tienda.id_sociedad')
							->leftJoin('tbl_franquicia','tbl_franquicia.id','tbl_tienda.id_franquicia')
							->leftJoin('tbl_clie_regimen_contributivo','tbl_clie_regimen_contributivo.id','tbl_sociedad.id_regimen')
							->where('tbl_tienda.ip_fija', $ip)
							->first();
	}

	public static function Abrir($id){
		$result="Abierto";
		try
		{
			\DB::beginTransaction();			
			ModelTienda::where('id',$id)->update(['abierto'=>1]);			
			
			\DB::commit();
		}catch(\Exception $e)
		{
			$result = 'Error';
			\DB::rollback();
			dd($e);				
		}
		return $result;	
	}
	
	public static function getMontoMax($id)
	{
		return ModelTienda::select('id', 'nombre AS name','monto_max')
							->where('id',$id)
							->first();
	}

	private static function insertarCierredeCaja($id,$saldo_inicial)
	{
		$secuencias = SecuenciaTienda::getCodigosSecuencia($id,env('SECUENCIA_TIPO_CODIGO_CIERRE_CAJA'),1);
		$codigoCierre = $secuencias[0]->response;
		$dataCierre=
		[
			'id_cierre' => $codigoCierre,
			'id_tienda' => $id,
			'fecha_inicio' => date("Y-m-d H:i:s"),
			'saldo_inicial' => $saldo_inicial,
			'cliclo' => 0
		];
		\DB::table('tbl_tes_cierre_caja')->insert($dataCierre);
	}
}