<?php 

namespace App\BusinessLogic\Nutibara\Contratos;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use config\messages;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria\MovimientosTesoreria;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\userIpValidated;
use Carbon\Carbon;


class CrudContrato {

	public static function get($request){
		$select=Contrato::get();
		$search = array(
			[
				'tableName' => 'tbl_pais', //tabla de busqueda 
				'field' => 'id', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
			],	
			[
				'tableName' => 'tbl_departamento', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_ciudad', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_zona', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_tienda', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_contr_cabecera', 
				'field' => 'fecha_creacion', 
				'method' => '=', 
				'typeWhere' => 'whereBetween', 
				'searchField' => null,
				'searchDate' => true
			],
			[
				'tableName' => 'tbl_sys_estado_tema', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_sys_estado_tema', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_sys_motivo', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_tienda', 
				'field' => 'codigo_tienda', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_contr_cabecera', 
				'field' => 'codigo_contrato', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_cliente', 
				'field' => 'id_tipo_documento', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_cliente', 
				'field' => 'numero_documento', 
				'method' => 'like', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_cliente', 
				'field' => 'nombres', 
				'method' => 'like', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_cliente', 
				'field' => 'primer_apellido', 
				'method' => 'like', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_cliente', 
				'field' => 'segundo_apellido', 
				'method' => 'like', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			],
			[
				'tableName' => 'tbl_prod_categoria_general', 
				'field' => 'id', 
				'method' => '=', 
				'typeWhere' => 'where', 
				'searchField' => null,
				'searchDate' => null
			]
		);
		$where = array(
			[
				'field' => 'tbl_cliente.estado',
				'value' => 1,
				'typeWhere'=>'where',
				'method'=>'='
			]
		);
		$where_rule = array();
		// if(Auth::user()->role->id != env('ROLE_SUPER_ADMIN')){
		// 	$ipValidation = new userIpValidated();
		// 	$tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
		// 	array_push($where_rule, [
		// 		'field' => 'tbl_contr_cabecera.id_tienda_contrato',
		// 		'value' => $tienda->id,
		// 		'typeWhere'=>'where',
		// 		'method'=>'='
		// 	]);
		// }
		$table=new DatatableBL($select,$search,$where,$where_rule);
		return $table->Run($request);
	}

    public static function Create ($dataSaved)
    {				
		$msm=['msm'=>Messages::$Contrato['ok'],'val'=>true];	
		if(!Contrato::Create($dataSaved))
        {
			$msm=['msm'=>Messages::$Contrato['error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function crearAuditoria ($datos_especificos)
    {				
		$result=true;
		$datos_basicos = [
			'fecha_transaccion' => Carbon::now(),
			'id_modulo' => 9,
			'id_usuario' => Auth::id(),
		];
		$datos = $datos_basicos + $datos_especificos;
		if(!Contrato::crearAuditoria($datos))
			$result=false;
		return $result;
	}

	public static function Contrato ($start,$end,$colum, $order,$search)
    {
		if(empty($search))
        {
			$result = Contrato::Contrato($start,$end,$colum, $order);
		}else
        {
			$result = Contrato::ContratoWhere($colum, $order,$search);
		}
		return $result;
	}

	public static function getItemsContratoById($codigo, $tienda){
		$msm = Contrato::getItemsContratoById($codigo, $tienda);
		return $msm;
	}

	public static function getInfoTercero($codigo, $tienda){
		$msm = Contrato::getInfoTercero($codigo, $tienda);
		return $msm;
	}

	public static function getContratoByPais($id)
    {
		$msm = Contrato::getContratoByPais($id);
		return $msm;
	}

	public static function getCountContrato()
	{
		return (int)Contrato::getCountContrato();
	}

	public static function getAplazosById($id)
	{
		return Contrato::getAplazosById($id);
	}

	public static function Update($id,$dataSaved)
    {
		$msm=['msm'=>Messages::$Contrato['update_ok'],'val'=>true];
		if(!Contrato::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Contrato['update_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Delete($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$Contrato['delete_ok'],'val'=>true];
		if(!Contrato::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Contrato['error_delete'],'val'=>false];		
		}	
		return $msm;
	}


	public static function Active($id)
    {
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$Contrato['active_ok'],'val'=>true];
		if(!Contrato::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$Contrato['active_error'],'val'=>false];		
		}	
		return $msm;
	}
	

	public static function getSelectList()
	{
		return Contrato::getSelectList();
	}

	public static function getSelectListContrato($id)
	{
		return Contrato::getSelectListContrato($id);
	}

	public static function RetroventaPost($codigoContrato,$idTiendaContrato,$valor)
    {	
		$msm=['msm'=>Messages::$RetroventaContrato['ok'],'val'=>true];	
		if(!Contrato::RetroventaPost($codigoContrato,$idTiendaContrato))
        {
			$msm=['msm'=>Messages::$RetroventaContrato['error'],'val'=>false];		
		}			
		else
		{
			//(Valor, Tienda, id_movimientocontable (2 RETROVENTA.) )
			$referencia = "RETROCONTR-".$idTiendaContrato.'/'.$codigoContrato;
			MovimientosTesoreria::registrarMovimientos($valor,$idTiendaContrato,2,NULL,$referencia);
		}
		return $msm;
	}

	public static function reversarRetroventaPost($codigoContrato,$idTiendaContrato,$valor)
    {				
		$msm=['msm'=>Messages::$RetroventaContrato['ok'],'val'=>true];	
		if(!Contrato::reversarRetroventaPost($codigoContrato,$idTiendaContrato))
        {
			$msm=['msm'=>Messages::$RetroventaContrato['error'],'val'=>false];		
		}	
		else
		{
            //(Valor, Tienda, id_movimientocontable (3 DEVOLUCION DE RETROVENTA.) )						
			MovimientosTesoreria::registrarMovimientos($valor,$idTiendaContrato,3);								
		}
		return $msm;
	}

	
	public static function AplazarById ($start,$end,$colum, $order,$search)
    {
		if(empty($search))
        {
			$result = Contrato::AplazarById($start,$end,$colum, $order);
		}else
        {
			$result = Contrato::AplazarByIdWhere($colum, $order,$search);
		}
		return $result;
	}

	public static function getCountAplazarById()
	{
		return (int)Contrato::getCountAplazarById();
	}

	public static function deleteItem($id, $id_tienda, $codigo_contrato){
		$msm=['msm'=>Messages::$itemcontrato['delete_ok'],'val'=>true];		
		Contrato::deleteItem($id, $id_tienda, $codigo_contrato);
		return $msm;
	}

	public static function actualizarTercero($codigo, $tienda, $data){
		$msm=['msm'=>Messages::$terceroContrato['ok'],'val'=>true];	
		if(!Contrato::actualizarTercero($codigo,$tienda, $data))
        {
			$msm=['msm'=>Messages::$terceroContrato['error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function guardarTercero($data){
		$msm=['msm'=>Messages::$terceroContrato['ok'],'val'=>true];	
		if(!Contrato::guardarTercero($data))
        {
			$msm=['msm'=>Messages::$terceroContrato['error'],'val'=>false];		
		}	
		return $msm;
	}

	// Función para actualizar campo <extraviado> de la cabecera del contrato
	public static function contratoExtraviado($codigo_contrato, $tienda_contrato, $valor_extraviado){
		$response = true;
		if(!Contrato::contratoExtraviado($codigo_contrato, $tienda_contrato, (int)$valor_extraviado)){
			$response = false;
		}
		return $response;
	}

}