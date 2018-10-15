<?php 

namespace App\BusinessLogic\Nutibara\GenerarPlan;
use App\AccessObject\Nutibara\GenerarPlan\GenerarPlan;
use App\BusinessLogic\Auditoria\CampoAuditoria;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use config\messages;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use App\BusinessLogic\Notificacion\PlanSepare as planSepareMensaje;
use App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria\MovimientosTesoreria;


class CrudGenerarPlan {
	
	public static function get($request,$tienda){	
		$id_tienda = 0;
		if($tienda != null) $id_tienda = $tienda->id;
		$select = GenerarPlan::get();
		$search = array(
			[
				'tableName' => 'tbl_plan_separe',
				'field' => 'id_tienda',
				'method' => '=',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			],
			[
				'tableName' => 'tbl_plan_separe',
				'field' => 'codigo_plan_separe',
				'method' => 'like',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			],
			[
				'tableName' => 'tbl_cliente',
				'field' => 'id_tipo_documento',
				'method' => '=',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			],
			[
				'tableName' => 'tbl_cliente',
				'field' => 'numero_documento',
				'method' => 'like',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			],
			[
				'tableName' => 'tbl_plan_separe',
				'field' => 'estado',
				'method' => '=',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			],
			[
				'tableName' => 'tbl_plan_separe',
				'field' => 'fecha_creacion',
				'method' => '=',
				'typeWhere' => 'whereBetween',
				'searchField' => null,
				'searchDate' => true,
			],
			[
				'tableName' => 'tbl_plan_separe',
				'field' => 'fecha_creacion',
				'method' => '=',
				'typeWhere' => 'whereBetween',
				'searchField' => null,
				'searchDate' => true,
			],
			[
				'tableName' => 'tbl_plan_separe',
				'field' => 'fecha_limite',
				'method' => '=',
				'typeWhere' => 'whereBetween',
				'searchField' => null,
				'searchDate' => true,
			]
		);
		$where = "";
		$table=new DatatableBL($select,$search,$where);
		return $table->Run($request);
	}

	public static function getEstados()
	{
		return GenerarPlan::getEstados();
	}

	public static function buscarReverso($id_tienda,$codigo_plan)
	{
		return GenerarPlan::buscarReverso($id_tienda,$codigo_plan);
	}

    public static function Create ($request,$codigo_cliente,$id_tienda,$id_tienda_cliente,$forma_pago){
		$secuencias = SecuenciaTienda::getCodigosSecuencia($id_tienda,(int)5,(int)1);
		$codigo_plan = $secuencias[0]->response;
		$secuenciasX = SecuenciaTienda::getCodigosSecuencia($id_tienda,(int)28,(int)1);
		$codigo_abono = $secuenciasX[0]->response;
		$adaptador = new AdaptadorCrear($request,$codigo_cliente,$id_tienda,$codigo_plan,$codigo_abono);
		$dataSaved = $adaptador->returnCreate();

		$msm = [
			'msm'=>Messages::$GenerarPlan['ok'],
			'val'=>true,
			'codigo_plan' => $codigo_plan,
			'codigo_abono' => $codigo_abono,
			'monto_total' => $request->monto,
			'saldo_abonar' => $request->abono,
			'saldo_pendiente' => $request->deuda,
			'tipo_documento' => $request->tipo_documento,
			'numero_documento' => $request->numero_documento,
			'id_tienda' => $id_tienda
		];

		if($codigo_plan != "-1" && $codigo_abono != "-1"){
			if(!GenerarPlan::Create($dataSaved,$codigo_cliente,$id_tienda,$codigo_plan,$id_tienda_cliente,$forma_pago)){
				$msm = ['msm'=>Messages::$GenerarPlan['error'],'val'=>false];
			}
		}
		return $msm;
	}

	public static function getConfig($id_pais,$id_departamento,$id_ciudad,$id_tienda,$monto){
		return GenerarPlan::getConfig($id_pais,$id_departamento,$id_ciudad,$id_tienda,$monto);
	}

	public static function GenerarPlan ($start,$end,$colum, $order,$search){
		if($search['estado']=="")
        {
			$result = GenerarPlan::GenerarPlan($start,$end,$colum, $order);
		}else
        {
			$result = GenerarPlan::GenerarPlanWhere($colum, $order,$search);
		}
		return $result;
	}

	public static function getGenerarPlan(){
		$msm = GenerarPlan::getGenerarPlan();
		return $msm;
	}

	public static function getCliente($iden,$id_tipo){
		$response = GenerarPlan::getCliente($iden,$id_tipo);
		return $response;
	}

	public static function getCountGenerarPlan(){
		return (int)GenerarPlan::getCountGenerarPlan();
	}

	public static function getGenerarPlanById($id){
		return GenerarPlan::getGenerarPlanById($id);
	}

	public static function Delete($id){
		$dataSaved = array();
		$dataSaved['estado'] = 0;
		$msm=['msm'=>Messages::$GenerarPlan['delete_ok'],'val'=>true];
		if(!GenerarPlan::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$GenerarPlan['error_delete'],'val'=>false];		
		}	
		return $msm;
	}

	public static function Active($id){
		$dataSaved = array();
		$dataSaved['estado'] = 1;
		$msm=['msm'=>Messages::$GenerarPlan['active_ok'],'val'=>true];
		if(!GenerarPlan::Update($id,$dataSaved))
        {
			$msm=['msm'=>Messages::$GenerarPlan['active_error'],'val'=>false];		
		}	
		return $msm;
	}

	public static function getSelectList(){
		return GenerarPlan::getSelectList();
	}

	public static function getSelectListById($table,$filter,$id){	
		$tabla = self::getTabla($table);
		return GenerarPlan::getSelectListById($tabla,$filter,$id);
	}

	public static function getInventarioById($id){
		return GenerarPlan::getInventarioById($id);
	}

	public static function getInventarioByIdB2($referencia,$id_tienda,$array_in){
		$response = GenerarPlan::getInventarioByIdB2($referencia,$id_tienda,$array_in);
		return $response;
	}

	public static function getInfoPrecio($id_referencia, $id_tienda){
		$response = GenerarPlan::getInfoPrecio($id_referencia, $id_tienda);
		return $response;
	}

	public static function getInventarioById2($referencia){
		$response = GenerarPlan::getInventarioById2($referencia);
		return $response;
	}

	public static function getTabla($table){
		$tbl = '';
		switch ($table) {
			case 'pais':
				$tbl = 'tbl_pais';
				break;
			case 'tienda':
				$tbl = 'tbl_tienda';
				break;
			case 'ciudad':
				$tbl = 'tbl_ciudad';
				break;	
			case 'departamento':
				$tbl = 'tbl_departamento';
				break;	
			
			default:
				'No se encontro la tabla';
				break;
		}

		return $tbl;
	}

	public static function getPlanById($id_tienda,$codigo_plan){

		return GenerarPlan::getPlanById($id_tienda,$codigo_plan);
	}

	public static function getPlanEstadosAbonos($id_tienda,$codigo_plan){

		return GenerarPlan::getPlanEstadosAbonos($id_tienda,$codigo_plan);
	}

	public static function getTiendaByIp($ip){
		return GenerarPlan::getTiendaByIp($ip);
	}

	public static function getCodigosSecuencia($id_tienda){
		
		return GenerarPlan::getCodigosSecuencia($id_tienda);
	}

	public static function getInfoAbono($id_tienda,$codigo_plan){

		return GenerarPlan::getInfoAbono($id_tienda,$codigo_plan);
	}

	public static function getSaldoFavor($id_tienda,$codigo_plan){

		return GenerarPlan::getSaldoFavor($id_tienda,$codigo_plan);
	}

	public static function getNuevoSaldoFavor($id_tienda,$codigo_plan){

		return GenerarPlan::getNuevoSaldoFavor($id_tienda,$codigo_plan);
	}

	public static function getInfoAbonosX($id_tienda,$codigo_plan){

		return GenerarPlan::getInfoAbonosX($id_tienda,$codigo_plan);
	}

	public static function valDocumento($tipodocumento, $numdocumento,$id_tienda){

		return GenerarPlan::valDocumento($tipodocumento, $numdocumento,$id_tienda);
	}

	public static function getInfoAbonos($request,$id_tienda,$codigo_plan){
        $search = array(
			[
				'tableName' => 'tbl_plan_separe',
				'field' => 'id_tienda',
				'method' => '=',
				'typeWhere' => 'where',
				'searchField' => null,
				'searchDate' => null,
			]);
        $select = GenerarPlan::getInfoAbonos($id_tienda,$codigo_plan);
		$where = "";
        $table=new DatatableBL($select,$search,$where);
		return $table->Run($request);
	}

	public static function guardar($data,$id_tienda_act){
		// dd($data);
		if($id_tienda_act != $data->id_tienda && self::limpiarVal($data->saldo_abonar) == self::limpiarVal($data->saldo_pendiente)){
			$msm=['msm'=>Messages::$GenerarPlan['error_abonado3'],'val'=>'Error'];
		}elseif(self::limpiarVal($data->saldo_abonar) <= self::limpiarVal($data->saldo_pendiente) && self::limpiarVal($data->saldo_abonar) > 0){
			//función restar abono de la deuda total del plan al guardar el abono
			$abonos = [
				'codigo_plan_separe' => $data->codigo_planS,
				'id_tienda' => $data->id_tienda,
				'saldo_abonado' => self::limpiarVal($data->saldo_abonar),
				'fecha' => date('Y-m-d H:i:s'),
				'saldo_pendiente' => self::limpiarVal($data->saldo_pendiente) - self::limpiarVal($data->saldo_abonar),
				'descripcion' => $data->descripcion,
				'codigo_abono' => $data->codigo_abono
			];
			
			$planSepare = [
				'codigo_plan_separe' => $data->codigo_planS,
				'id_tienda' => $data->id_tienda,
				'deuda' => self::limpiarVal($data->saldo_pendiente) - self::limpiarVal($data->saldo_abonar)
			];
			
			if(self::limpiarVal($data->saldo_abonar) == self::limpiarVal($data->saldo_pendiente)){
				$planSepare['motivo'] = env('PLAN_MOTIVO_FACTURAR');
				$planSepare['estado'] = env('PLAN_ESTADO_FACTURAR');
			}
			$dataSaved['abonos'] = $abonos;
			$dataSaved['planSepare'] = $planSepare;

			// MovimientosTesoreria::registrarMovimientos($data->saldo_abonar,26,$data->id_tienda,19);
			GenerarPlan::mov_contablesAbono($data);
			if(!GenerarPlan::guardar($dataSaved)){
				$msm=['msm'=>Messages::$GenerarPlan['error'],'val'=>false];
			}else{
				$msm=['msm'=>Messages::$GenerarPlan['ok_abono'],'val'=>true];
			}
		}
		else{
			if($data->saldo_abonar == "0" || $data->saldo_abonar < "0")
			{
				$msm=['msm'=>Messages::$GenerarPlan['error_abonado2'],'val'=>false];
			}else{
				$msm=['msm'=>Messages::$GenerarPlan['error_abonado'],'val'=>false];
			}
		}
		return $msm;
	}

	public static function solicitudAnulacion($data){
		$result = GenerarPlan::solicitudAnulacion($data->id_tienda,$data->codigo_plan,$data->codigo_abono);
		if(!$result)
        {
			$msm=['msm'=>Messages::$GenerarPlan['error_anulacion'],'val'=>False];
		}
		else
		{
			$planSepareMensaje =new planSepareMensaje($data);
			$msm=$planSepareMensaje->SolicitudAnular();
			dd($msm);
		}
		return $msm;
	}

	public static function anular($data){
		$anular = [
			'codigo_plan_separe' => $data->codigo_plan,
			'id_tienda' => $data->id_tienda			
		];
		$anular['estado'] = env('CERRAR_PLAN_SEPARE_ANULACION');
		$anular['motivo'] = env('CERRAR_PLAN_SEPARE_ANULACION_MOTIVO');

		$dataSaved['anular'] = $anular;

		// dd($dataSaved);

		// MovimientosTesoreria::registrarMovimientos($data->abono,40,$data->id_tienda,20);
		if(!GenerarPlan::anular($dataSaved)){
			$msm=['msm'=>Messages::$GenerarPlan['error_anulacion'],'val'=>'Error'];
		}else{
			$msm=['msm'=>Messages::$GenerarPlan['ok_anulacion'],'val'=>'Insertado'];
		}
		return $msm;
	}

	public static function solicitarReversarAbono($data){			
		$result = GenerarPlan::solicitarReversarAbono($data);
		if($result)
		{
			$planSepareMensaje = new planSepareMensaje($data);
			$msm = ['msm' => Messages::$GenerarPlan['ok_reversar'],'val' => true,'var' => $planSepareMensaje->SolicitarAbono()];
		}else{
			$msm = ['msm' => Messages::$GenerarPlan['error_solicitud'],'val' => false];
		}
		return $msm;
	}
	
	public static function reversarAbono($data){
		$secuenciasX = SecuenciaTienda::getCodigosSecuencia($data->id_tienda,(int)28,(int)1);
		$reversarAbono = [
			'codigo_plan_separe' => $data->codigo_plan,
			'id_tienda' => $data->id_tienda,
			'saldo_abonado' => self::limpiarVal($data->saldo_abono),
			'fecha' => date('Y-m-d H:i:s'),
			'descripcion' => 'Reverso abono',
			'codigo_abono' => $secuenciasX[0]->response,
			'saldo_pendiente' => self::limpiarVal($data->saldo_pendiente) + self::limpiarVal($data->saldo_abono),
			'estado' => (int)1
		];
		$dataSaved['reversarAbono'] = $reversarAbono;	
		$dataSaved['abonorever'] = $data->abonorever;	

		// MovimientosTesoreria::registrarMovimientos($data->saldo_abono,40,$data->id_tienda,20);
		$result = GenerarPlan::reversarAbono($dataSaved,$data->id_tienda,$data->codigo_plan);
		if(!$result){
			$msm= ['msm'=>Messages::$GenerarPlan['error_reversar'],'val'=> false];
		}else{
			$msm = ['msm' => Messages::$GenerarPlan['ok_reverso'],'val' => true];
		}
		return $msm;
	}
		
	public static function rechazarReversar($data){
		$result = GenerarPlan::rechazarReversar($data->id_tienda,$data->codigo_plan,$data->codigo_abono);
		if(!$result)
        {
			$msm=['msm'=>Messages::$GenerarPlan['rechazar_error'],'val'=>False];
		}
		else
		{
			$msm=['msm'=>Messages::$GenerarPlan['ok_rechazar_reversar'],'val'=>True];
		}
		return $msm;
	}

	public static function getTransferirPlan($codigo_cliente,$id_tienda,$codigo_plan){
		return GenerarPlan::getTransferirPlan($codigo_cliente,$id_tienda,$codigo_plan);
	}

	public static function getTransferirContrato($codigo_cliente,$id_tienda){
		return GenerarPlan::getTransferirContrato($codigo_cliente,$id_tienda);
	}
	
	public static function getTransferPlanH($codigo_cliente,$codigo_plan){
		return GenerarPlan::getTransferPlanH($codigo_cliente,$codigo_plan);	
	}

	public static function transferirGuardarX($data){
		$secuencias = SecuenciaTienda::getCodigosSecuencia($data->id_tienda,(int)28,(int)1);
		$codigo_abono = $secuencias[0]->response;
		$transfeAbonos = [
			'codigo_plan_separe' => $data->codigo_plan_separe,
			'id_tienda' => $data->id_tienda_plan,
			'saldo_abonado' => self::limpiarVal($data->saldo_favor),
			'fecha' => $data->fecha_prorroga,
			'saldo_pendiente' => (int)0,
			'descripcion' => 'Devolución por transferencia',
			'codigo_abono' => $codigo_abono,
			'estado' => (int)1
		];

		$transfePlan = [
				'estado' => env('CERRAR_PLAN_SEPARE_ESTADO'),
				'motivo' => env('CERRAR_PLAN_SEPARE_MOTIVO'),
				'id_tienda' => $data->id_tienda_plan,
				'codigo_plan_separe' => $data->codigo_plan_separe,
				'deuda' => 0
			];
		$dataSaved['transfePlan'] = $transfePlan;
		$dataSaved['transfeAbonos'] = $transfeAbonos;
		if(!GenerarPlan::transferirGuardarX($dataSaved)){
			$msm=['msm'=>Messages::$GenerarPlan['error_transferencia'],'val'=>'Error'];
		}else{
			$msm=['msm'=>Messages::$GenerarPlan['ok_transferencia'],'val'=>'Insertado'];
		}
	}

	public static function transferirGuardar($data){
			// dd($data);
			$sal = $data->saldo_favor;		
			$abono = 0;
			$deudaFin = 0;
			$valor_abono = $data->saldo_favor;
			if(self::limpiarVal($data->saldo_favor) > self::limpiarVal($data->deuda2)){
				$deudaX = 0;
				$data->saldo_favor =  self::limpiarVal($data->saldo_favor) - self::limpiarVal($data->deuda2);
				$deudaFin = self::limpiarVal($data->saldo_favor) + self::limpiarVal($data->saldo_pendiente_plan);
				$abono = self::limpiarVal($data->deuda2);
				$data->deuda2 = 0;
			}else if(self::limpiarVal($data->saldo_favor) < self::limpiarVal($data->deuda2)){
				$deudaX = self::limpiarVal($data->deuda2) - self::limpiarVal($data->saldo_favor);
				$deudaFin = self::limpiarVal($data->saldo_favor) + self::limpiarVal($data->saldo_pendiente_plan);
				$abono = self::limpiarVal($valor_abono);
				$data->deuda2 = self::limpiarVal($data->deuda2) - self::limpiarVal($data->saldo_favor);
				$data->saldo_favor = 0;
			}else{
				$deudaX = 0;
				$deudaFin = self::limpiarVal($data->saldo_favor) + self::limpiarVal($data->saldo_pendiente_plan);
				$abono = self::limpiarVal($valor_abono);
				$data->deuda2 = 0;
				$data->saldo_favor = 0;
			}

			$transfePlan = [
				'estado' => env('CERRAR_PLAN_SEPARE_ANULACION'),
				'motivo' => env('CERRAR_PLAN_SEPARE_MOTIVO'),
				'id_tienda' => $data->id_tienda,
				'codigo_plan_separe' => $data->codigo_plan_separe,
				'deuda' => 0
			];

			$transfePlanX = [
				'id_tienda' => $data->id_tienda_plan,
				'codigo_plan_separe' => $data->transferirA,
				'deuda' => $deudaX
			];
			if($data->saldo_favor == 0){
				$transfePlan['motivo'] = env('CERRAR_PLAN_SEPARE_ESTADO');
				$transfePlan['estado'] = env('CERRAR_PLAN_SEPARE_MOTIVO');
			}elseif($data->saldo_favor > 0){
				$transfePlan['motivo'] = env('CERRAR_PLAN_TRANS_PENDIENTE_MOTIVO');
				$transfePlan['estado'] = env('CERRAR_PLAN_SEPARE_MOTIVO');
			}
			$dataSaved['transfePlan'] = $transfePlan;
			$dataSaved['transfePlanX'] = $transfePlanX;
			
			$transfeAbonos = [
				'codigo_plan_separe' => $data->codigo_plan_separe,
				'id_tienda' => $data->id_tienda,
				'saldo_abonado' => $abono,
				'fecha' => date('Y-m-d H:i:s'),
				'saldo_pendiente' => self::limpiarVal($data->saldo_favor),
				'descripcion' => 'Devolución por transferencia',
				'codigo_abono' => $data->codigo_abono,
				'estado' => (int)1
			];

			$transfeAbonosX = [
				'codigo_plan_separe' => $data->transferirA,
				'id_tienda' => $data->id_tienda_plan,
				'saldo_abonado' => $abono,
				'fecha' => date('Y-m-d H:i:s'),
				'saldo_pendiente' => self::limpiarVal($data->deuda2) - self::limpiarVal($data->saldo_favor),
				'descripcion' => 'Abono por transferencia',
				'codigo_abono' => $data->codigo_abono,
				'estado' => (int)0
			];
			if($data->estado == 1){
				$transfeAbonos['estado'] = env('CERRAR_PLAN_SEPARE_PENDIENTE_CIERRE');
			}
			$dataSaved['transfeAbonos'] = $transfeAbonos;
			$dataSaved['transfeAbonosX'] = $transfeAbonosX;
			// dd($dataSaved);
		// MovimientosTesoreria::registrarMovimientos(self::limpiarVal($sal),40,$data->id_tienda,20);
		if(!GenerarPlan::transferirGuardar($dataSaved)){
			$msm=['msm'=>Messages::$GenerarPlan['error_transferencia'],'val'=>'Error'];
		}else{
			$msm=['msm'=>Messages::$GenerarPlan['ok_transferencia'],'val'=>'Insertado','data' => $transfeAbonosX];
		}
		return $msm;
	}

	public static function createPostTransferir($dataSaved){
		if(!GenerarPlan::createPostTransferir($dataSaved)){
			$msm=['msm'=>Messages::$GenerarPlan['error_transferencia'],'val'=>'Error'];
		}else{
			$msm=['msm'=>Messages::$GenerarPlan['ok_transferencia'],'val'=>'Insertado'];
		}
		return $msm;
	}

	public static function codigoPlanPostTransferir($id_tienda,$codigo_cliente){
		return GenerarPlan::codigoPlanPostTransferir($id_tienda,$codigo_cliente);
	}

	public static function limpiarVal($val)
	{
		$valLimpiar = str_replace('.','',$val);
		$valLimpiar = str_replace(',','.',$valLimpiar);
		$valLimpiar = trim($valLimpiar);
		return $valLimpiar;
	}

	public static function getSelectListCotizacion($id_tienda)
	{
		return GenerarPlan::getSelectListCotizacion($id_tienda);
	}

	public static function getCotizacionById($id_cotizacion,$id_tienda)
	{
		return GenerarPlan::getCotizacionById($id_cotizacion,$id_tienda);
	}

	public static function updateInventario($id_inventario,$id_tienda,$id_estado,$id_motivo)
	{
		return GenerarPlan::updateInventario($id_inventario,$id_tienda,$id_estado,$id_motivo);
	}

	public static function validarFecha($id_tienda,$id_plan)
	{
		return GenerarPlan::validarFecha($id_tienda,$id_plan);
	}

	public static function getItemsPlan($id_tienda,$codigo_plan)
	{
		return GenerarPlan::getItemsPlan($id_tienda,$codigo_plan);
	}

	public static function docGenerCotr($tipodocumento)
	{
		return GenerarPlan::docGenerCotr($tipodocumento);
	}

	public static function detalleAbono($id_tienda,$id_abono)
	{
		return GenerarPlan::detalleAbono($id_tienda,$id_abono);
	}
}