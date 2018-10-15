<?php
namespace App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria;

use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda AS SecuenciaTienda;
use DB;

class MovimientosTesoreria 
{
	public static function registrarMovimientos($valor,$tienda,$id_movimientocontable,$codigo_movimiento = NULL,$referencia = NULL){
        $result = true;
        try
        {
            DB::beginTransaction();   
            $CierreActual = self::getCierreCaja($tienda);
            $datosMovimiento = self::movimientoCierreCaja($CierreActual,$valor,$tienda,$id_movimientocontable);
            self::detalleMovimientoCierreCaja($datosMovimiento,$valor,$tienda,$id_movimientocontable);
            self::MovimientoContable($CierreActual,$valor,$tienda,$id_movimientocontable,$codigo_movimiento,$referencia); 
            DB::commit();
        }catch(\Exception $e )
        {
            $result = false;
            DB::rollback();
            dd($e);
        };
        return $result;		    
    }

    public static function registrarMovimientosPlanSepare($valor,$abono,$tienda,$id_movimientocontable,$codigo_movimiento = null,$referencia)
    {
        $result = true;
        try
        {
            $cierreActual = self::getCierreCaja($tienda);
            $result = self::MovimientoContableCreate($cierreActual,$valor,$abono,$tienda,$id_movimientocontable,$codigo_movimiento,$referencia);
        }catch(\Exception $e)
        {
            $result = false;
            dd($e);
        };
        return $result;
    }

    public static function getCierreCaja($tienda)
    {
        return DB::table('tbl_tes_cierre_caja')
                    ->select('id_cierre',
                                 'id_tienda')
                    ->where('id_tienda', $tienda)
                    ->orderBy('id_cierre', 'desc')
                    ->limit(1)
                    ->get();
    }

    public static function movimientoCierreCaja($CierreActual,$valor,$tienda,$id_movimientocontable)
    {
        /*SubClase asociada a este MovimientoContable*/
        $subclase = DB::table('tbl_cont_configuracioncontable')
        ->select('id_subclase')
        ->where('id',$id_movimientocontable)
        ->first();
        
        $secuencias = SecuenciaTienda::getCodigosSecuencia($tienda,env('SECUENCIA_TIPO_MOVIMIENTO_CIERRE_CAJA'),1);
		$codigoMovimiento = $secuencias[0]->response;
        DB::table('tbl_tes_movimientos_cierre_caja')->insert([
            'id_movimiento' => $codigoMovimiento,
            'id_tienda_movimiento' => $tienda,
            'id_cierre' => $CierreActual[0]->id_cierre,
            'id_tienda_cierre' => $CierreActual[0]->id_tienda,
            'id_subclase' => $subclase->id_subclase,
            'valor' => $valor,
            'fecha' => date("Y-m-d H:i:s")
        ]);
        $datosMovimiento['codigoMovimiento'] = (int)$codigoMovimiento;
        $datosMovimiento['subClase'] = $subclase->id_subclase;
        return $datosMovimiento;
    }

    public static function detalleMovimientoCierreCaja($datosMovimiento,$valor,$tienda,$id_movimientocontable)
    {
        /*Impuestos del id_movimientocontable*/
        $impuestoConcepto = DB::table('tbl_cont_configuracioncontable_impuestos')
                            ->where('id_configuracioncontable',$id_movimientocontable)
                            ->get();
        if(isset($impuestoConcepto))
        {
            $secuencias = SecuenciaTienda::getCodigosSecuencia($tienda,env('SECUENCIA_TIPO_DETALLE_MOVIMIENTO_CIERRE_CAJA'),1);
            $codigoDetalleMovimiento = $secuencias[0]->response;
            DB::table('tbl_tes_detalle_movimientos_cierre_caja')
            ->insert([
                    'id_detalle' => $codigoDetalleMovimiento,
                    'id_tienda_detalle' => $tienda,
                    'id_movimiento' => $datosMovimiento['codigoMovimiento'],
                    'id_tienda_movimiento' => $tienda,
                    'id_subclase' => $datosMovimiento['subClase'],
                    'valor' => $valor      
                    ]);
        }
    }

    public static function MovimientoContable($CierreActual,$valor,$tienda,$id_movimientocontable,$codigo_movimiento,$referencia)
    {
        /*Datos generales del concepto*/
        $datosGenerales = DB::table('tbl_cont_configuracioncontable')
                            ->join('tbl_cont_tipo_documento_contable','tbl_cont_tipo_documento_contable.id','tbl_cont_configuracioncontable.id_tipo_documento_contable')
                            ->select(
                                'tbl_cont_tipo_documento_contable.id AS id_tipo_documento'
                            )
                            ->where('tbl_cont_configuracioncontable.id',$id_movimientocontable)
                            ->first();
        /*Impuestos del Concepto*/
        $impuestoConcepto = DB::table('tbl_cont_configuracioncontable_impuestos')
                            ->where('id_configuracioncontable',$id_movimientocontable)
                            ->get();
        /*Movimientos del concepto*/
        $movimientoscontables = DB::table('tbl_cont_movimientos_configuracioncontable')
        ->join('tbl_plan_unico_cuenta','tbl_plan_unico_cuenta.id','tbl_cont_movimientos_configuracioncontable.id_cod_puc')
        ->select(
            'cuenta',
            'descripcion',
            'tbl_cont_movimientos_configuracioncontable.naturaleza'
        )
        ->where('id_configuracioncontable',$id_movimientocontable)
        ->get();
        /*Si no tiene impuestos...*/
        if(isset($impuestoConcepto))
        {
            if($codigo_movimiento==NULL)
            {
                $secuencias = SecuenciaTienda::getCodigosSecuencia($tienda,env('SECUENCIA_TIPO_CODIGO_COMPROBANTE_CONTABLE'),1);
                $codigoComprobante = $secuencias[0]->response;
            }
            else
            {
                $codigoComprobante = $codigo_movimiento;
            }
            for ($i=0; $i < count($movimientoscontables) ; $i++) 
            { 
                $secuencias = SecuenciaTienda::getCodigosSecuencia($tienda,env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE'),1);
                $codigoMovimiento = $secuencias[0]->response;
                $movimientoContable[$i]['id_movimiento'] = $codigoMovimiento;
                $movimientoContable[$i]['id_cierre'] = $CierreActual[0]->id_cierre;
                $movimientoContable[$i]['id_tienda'] = $tienda;
                $movimientoContable[$i]['codigo_movimiento'] = $codigoComprobante;                
                $movimientoContable[$i]['fecha'] = date("Y-m-d H:i:s");
                $movimientoContable[$i]['id_tipo_documento'] = $datosGenerales->id_tipo_documento;
                $movimientoContable[$i]['cuenta'] = $movimientoscontables[$i]->cuenta;
                $movimientoContable[$i]['descripcion'] = $movimientoscontables[$i]->descripcion;
                $movimientoContable[$i]['referencia'] = $referencia;
                $movimientoContable[$i]['id_configuracion_contable'] = $id_movimientocontable;
                $movimientoContable[$i]['valor'] = $valor;
                if($movimientoscontables[$i]->naturaleza == 1)
                {
                    $movimientoContable[$i]['debito'] = $valor;
                    $movimientoContable[$i]['credito'] = 0;
                }
                else
                {   
                    $movimientoContable[$i]['credito'] = $valor;
                    $movimientoContable[$i]['debito'] = 0;
                }
            }
            DB::table('tbl_cont_movimientos_contables')->insert($movimientoContable);
        }

        return $codigoComprobante;
    }

    private static function movimientoContableNominas($CierreActual,$datosContables,$datosEmpleados)
    {
            /*Movimientos de la causación*/
            $movimientocausacion = DB::table('tbl_cont_movimientos_configuracioncontable')
            ->join('tbl_plan_unico_cuenta','tbl_plan_unico_cuenta.id','tbl_cont_movimientos_configuracioncontable.id_cod_puc')
            ->select(
                'cuenta',
                'descripcion',
                'tbl_cont_movimientos_configuracioncontable.naturaleza'
            )
            ->where('tbl_cont_movimientos_configuracioncontable.id',$datosContables['causacion'])
            ->where('tbl_cont_movimientos_configuracioncontable.causacion',1)
            ->first();

            //Codigo Comprobante
            $secuencias = SecuenciaTienda::getCodigosSecuencia($datosContables['id_tienda'],env('SECUENCIA_TIPO_CODIGO_COMPROBANTE_CONTABLE'),1);
            $codigoComprobante = $secuencias[0]->response;

            //Empleado Inicial Valores Iniciales
            $id_empleado = $datosEmpleados[0]['id_empleado'];
            
            //Registro de la causacion
            $Causacion['id_cierre'] = $CierreActual[0]->id_cierre;
            $Causacion['id_tienda'] = $datosContables['id_tienda'];
            $Causacion['codigo_movimiento'] = $codigoComprobante;     
            $Causacion['fecha'] = date("Y-m-d H:i:s");
            $Causacion['id_tipo_documento'] = $datosContables['id_tipo_documento_contable'];
            $Causacion['cuenta'] = $movimientocausacion->cuenta;
            $Causacion['descripcion'] = $movimientocausacion->descripcion;
            $Causacion['referencia'] = $datosContables['referencia'];
            $Causacion['id_configuracion_contable'] = $datosContables['id_tipo_configuracion_contable'];
            $valor = 0;
            //si Existe otro registro.
            $cont=0;
            //Causar por empleado
            for ($i=0; $i < count($datosEmpleados) ; $i++) 
            {
                //Codigo Movimiento
                $secuencias = SecuenciaTienda::getCodigosSecuencia($datosContables['id_tienda'],env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE'),1);
                $codigoMovimiento = $secuencias[0]->response;
                //Total Causación por Empleado
                if(($datosEmpleados[$i]['id_empleado'] == $id_empleado) && $i != count($datosEmpleados)-1)
                {
                    $valor += $datosEmpleados[$i]['valor'];
                    $movimientoEmpleado[$cont]['id_movimiento'] = $codigoMovimiento;
                    $movimientoEmpleado[$cont]['id_cierre'] = $CierreActual[0]->id_cierre;
                    $movimientoEmpleado[$cont]['id_tienda'] = $datosContables['id_tienda'];
                    $movimientoEmpleado[$cont]['codigo_movimiento'] = $codigoComprobante;     
                    $movimientoEmpleado[$cont]['fecha'] = date("Y-m-d H:i:s");
                    $movimientoEmpleado[$cont]['id_tipo_documento'] = $datosContables['id_tipo_documento_contable'];
                    $movimientoEmpleado[$cont]['cuenta'] = $datosEmpleados[$i]['cuenta'];
                    $movimientoEmpleado[$cont]['descripcion'] = $datosEmpleados[$i]['descripcion'];
                    $movimientoEmpleado[$cont]['referencia'] = $datosContables['referencia'];
                    $movimientoEmpleado[$cont]['id_configuracion_contable'] = $datosContables['id_tipo_configuracion_contable'];
                    
                    //Solo re registran valores Positivos
                    if((int)$datosEmpleados[$i]['valor']<0)
                    $datosEmpleados[$i]['valor'] = ((int)$datosEmpleados[$i]['valor']*(-1));

                    if($datosEmpleados[$i]['naturaleza'] == 1)
                    {
                        $movimientoEmpleado[$cont]['debito'] = $datosEmpleados[$i]['valor'];
                        $movimientoEmpleado[$cont]['credito'] = 0;
                    }
                    else
                    {   
                        $movimientoEmpleado[$cont]['credito'] = $datosEmpleados[$i]['valor'];
                        $movimientoEmpleado[$cont]['debito'] = 0;
                    }
                    $cont++;                    
                }
                else
                {
                    //Si llega a la ultima posición la registre.
                    if($i == count($datosEmpleados)-1)
                    {
                        
                        $valor += $datosEmpleados[$i]['valor'];
                        $movimientoEmpleado[$cont]['id_movimiento'] = $codigoMovimiento;
                        $movimientoEmpleado[$cont]['id_cierre'] = $CierreActual[0]->id_cierre;
                        $movimientoEmpleado[$cont]['id_tienda'] = $datosContables['id_tienda'];
                        $movimientoEmpleado[$cont]['codigo_movimiento'] = $codigoComprobante;     
                        $movimientoEmpleado[$cont]['fecha'] = date("Y-m-d H:i:s");
                        $movimientoEmpleado[$cont]['id_tipo_documento'] = $datosContables['id_tipo_documento_contable'];
                        $movimientoEmpleado[$cont]['cuenta'] = $datosEmpleados[$i]['cuenta'];
                        $movimientoEmpleado[$cont]['descripcion'] = $datosEmpleados[$i]['descripcion'];
                        $movimientoEmpleado[$cont]['referencia'] = $datosContables['referencia'];
                        $movimientoEmpleado[$cont]['id_configuracion_contable'] = $datosContables['id_tipo_configuracion_contable'];
                        //Solo re registran valores Positivos
                        if((int)$datosEmpleados[$i]['valor']<0)
                        $datosEmpleados[$i]['valor'] = ((int)$datosEmpleados[$i]['valor']*(-1));

                        if($datosEmpleados[$i]['naturaleza'] == 1)
                        {
                            $movimientoEmpleado[$cont]['debito'] = $datosEmpleados[$i]['valor'];
                            $movimientoEmpleado[$cont]['credito'] = 0;
                        }
                        else
                        {   
                            $movimientoEmpleado[$cont]['credito'] = $datosEmpleados[$i]['valor'];
                            $movimientoEmpleado[$cont]['debito'] = 0;
                        }

                        //Codigo Movimiento
                        $secuencias = SecuenciaTienda::getCodigosSecuencia($datosContables['id_tienda'],env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE'),1);
                        $codigoMovimiento = $secuencias[0]->response;
                    }
                    //Si no es el mismo empleado se realiza la casuacion
                    //Se registran los movimientos del empleado
                    DB::table('tbl_cont_movimientos_contables')->insert($movimientoEmpleado);

                    $Causacion['id_movimiento'] = $codigoMovimiento;
                    if($movimientocausacion->naturaleza == 1)
                    {
                        $Causacion['debito'] = $valor;
                        $Causacion['credito'] = 0;
                    }
                    else
                    {   
                        $Causacion['credito'] = $valor;
                        $Causacion['debito'] = 0;
                    }
                    //Se registra la causacion del empleado
                    DB::table('tbl_cont_movimientos_contables')->insert($Causacion);
                    
                    //Se relaciona el movimiento con el cierre
                    $movimientoCierre['codigo_movimiento'] = $codigoComprobante;
                    $movimientoCierre['id_configuracion_contable'] = $datosContables['id_tipo_configuracion_contable'];
                    $movimientoCierre['codigo_movimiento_cierre'] = $codigoMovimiento;
                    $movimientoCierre['id_tienda'] = $datosContables['id_tienda'];
                    DB::table('tbl_cont_movimientos_contables_movimientos_cierre')->insert($movimientoCierre);
                    
                    //Nuevo empleado a analizar
                    $id_empleado = $datosEmpleados[$i]['id_empleado'];
                    //Vuelve a analizar el nuevo empleado
                    unset($movimientoEmpleado);
                    $movimientoEmpleado=array();
                    $cont=0;
                    $valor=0;
                    $valor += $datosEmpleados[$i]['valor'];
                    $secuencias = SecuenciaTienda::getCodigosSecuencia($datosContables['id_tienda'],env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE'),1);
                    $codigoMovimiento = $secuencias[0]->response;
                    $movimientoEmpleado[$cont]['id_movimiento'] = $codigoMovimiento;
                    $movimientoEmpleado[$cont]['id_cierre'] = $CierreActual[0]->id_cierre;
                    $movimientoEmpleado[$cont]['id_tienda'] = $datosContables['id_tienda'];
                    $movimientoEmpleado[$cont]['codigo_movimiento'] = $codigoComprobante;     
                    $movimientoEmpleado[$cont]['fecha'] = date("Y-m-d H:i:s");
                    $movimientoEmpleado[$cont]['id_tipo_documento'] = $datosContables['id_tipo_documento_contable'];
                    $movimientoEmpleado[$cont]['cuenta'] = $datosEmpleados[$i]['cuenta'];
                    $movimientoEmpleado[$cont]['descripcion'] = $datosEmpleados[$i]['descripcion'];
                    $movimientoEmpleado[$cont]['referencia'] = $datosContables['referencia'];
                    $movimientoEmpleado[$cont]['id_configuracion_contable'] = $datosContables['id_tipo_configuracion_contable'];

                    //Solo re registran valores Positivos
                    if($datosEmpleados[$i]['valor']<0)
                    $datosEmpleados[$i]['valor'] = ($datosEmpleados[$i]['valor']*(-1)); 

                    if($datosEmpleados[$i]['naturaleza'] == 1)
                    {
                        $movimientoEmpleado[$cont]['debito'] = $datosEmpleados[$i]['valor'];
                        $movimientoEmpleado[$cont]['credito'] = 0;
                    }
                    else
                    {   
                        $movimientoEmpleado[$cont]['credito'] = $valor;
                        $movimientoEmpleado[$cont]['debito'] = 0;
                    }
                    $cont++;               
                }   
            }
            DB::table('tbl_tes_causacion')->where('id',$datosContables['id_causacion'])->update(['comprobante_contable'=>$codigoComprobante]);            
    }
    
    public static function causarSalario($datosContables,$datosEmpleados)
    {
        $result = true;
        try
        {
            DB::beginTransaction();   
            $CierreActual = self::getCierreCaja($datosContables['id_tienda']);
            self::movimientoContableNominas($CierreActual,$datosContables,$datosEmpleados);
            DB::commit();
        }catch(\Exception $e )
        {
            $result = false;
            DB::rollback();
            dd($e);
        };
        return $result;	
    }

    public static function registrarCausacion($valor,$tienda,$id_movimientocontable,$codigo_movimiento = NULL,$referencia = NULL)
    {
        $result = true;
        try
        {
            DB::beginTransaction();
            $CierreActual = self::getCierreCaja($tienda);
            self::MovimientoContable($CierreActual,$valor,$tienda,$id_movimientocontable,$codigo_movimiento,$referencia);
            $result = $codigo_movimiento;
            DB::commit();
        }catch(\Exception $e )
        {
            $result = false;
            DB::rollback();
            dd($e);
        };
        return $result;
    }

    public static function registrarMovimientosVenta($valor,$tienda,$id_movimientocontable,$dataMov)
    {
        $result = true;
        try
        {
            // $cierreActual = self::getCierreCaja($tienda);
            // $datosMovimiento = self::movimientoCierreCaja($cierreActual,$valor,$tienda,$id_movimientocontable);
            // self::detalleMovimientoCierreCaja($datosMovimiento,$valor,$tienda,$id_movimientocontable);
            // dd($dataMov);
            DB::table('tbl_cont_movimientos_contables')->insert($dataMov);
        }catch(\Exception $e)
        {
            $result = false;
            dd($e);
        };
        return $result;
    }

    public static function registrarMovimientosAbono($abono,$tienda,$id_movimientocontable,$codigo_movimiento = null,$referencia,$tipo,$comprabante,$observaciones,$val,$id_tema = null,$id_abono = null,$tercero = null)
    {
        $result = true;
        try
        {
            $cierreActual = self::getCierreCaja($tienda);
            for($i = 0; $i < count($id_movimientocontable); $i++){
                $datosMovimiento = self::movimientoCierreCaja($cierreActual,$val[$i],$tienda,$id_movimientocontable[$i]);
                self::detalleMovimientoCierreCaja($datosMovimiento,$val[$i],$tienda,$id_movimientocontable[$i]);
            }
            self::MovimientoContableAbono($cierreActual,$abono,$tienda,$id_movimientocontable,$codigo_movimiento,$referencia,$tipo,$comprabante,$observaciones,$val,$id_tema,$id_abono,$tercero);
        }catch(\Exception $e)
        {
            $result = false;
            dd($e);
        };
        return $result;
    }

    public static function MovimientoContableAbono($CierreActual,$abono,$tienda,$id_movimientocontable,$codigo_movimiento,$referencia,$tipo,$comprabante,$observaciones,$val,$id_tema = null,$id_abono = null,$tercero = null)
    {
        $secuencias = SecuenciaTienda::getCodigosSecuencia($tienda,env('SECUENCIA_TIPO_CODIGO_COMPROBANTE_CONTABLE'),1);
        $codigo_movimiento = $secuencias[0]->response;
        for($j = 0; $j < count($id_movimientocontable); $j++){
            /*Datos generales del concepto*/
            $datosGenerales = DB::table('tbl_cont_configuracioncontable')
                                ->join('tbl_cont_tipo_documento_contable','tbl_cont_tipo_documento_contable.id','tbl_cont_configuracioncontable.id_tipo_documento_contable')
                                ->select(
                                    'tbl_cont_tipo_documento_contable.id AS id_tipo_documento'
                                )
                                ->where('tbl_cont_configuracioncontable.id',$id_movimientocontable[$j])
                                ->first();
            /*Impuestos del Concepto*/
            $impuestoConcepto = DB::table('tbl_cont_configuracioncontable_impuestos')
                                ->where('id_configuracioncontable',$id_movimientocontable[$j])
                                ->get();
            /*Movimientos del concepto*/
            $movimientoscontables = DB::table('tbl_cont_movimientos_configuracioncontable')
            ->join('tbl_plan_unico_cuenta','tbl_plan_unico_cuenta.id','tbl_cont_movimientos_configuracioncontable.id_cod_puc')
            ->select(
                'cuenta',
                'descripcion',
                'tienetercero',
                'nombre_cliente',
                'tbl_cont_movimientos_configuracioncontable.naturaleza'
            )
            ->where('id_configuracioncontable',$id_movimientocontable[$j])
            ->get();
            /*Si no tiene impuestos...*/
            if(isset($impuestoConcepto))
            {
                for ($i=0; $i < count($movimientoscontables) ; $i++) 
                { 
                    $secuencias = SecuenciaTienda::getCodigosSecuencia($tienda,env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE'),1);
                    $id_movimiento = $secuencias[0]->response;
                    $movimientoContable['id_movimiento'] = $id_movimiento;
                    $movimientoContable['id_cierre'] = $CierreActual[0]->id_cierre;
                    $movimientoContable['id_tienda'] = $tienda;
                    $movimientoContable['codigo_movimiento'] = $codigo_movimiento;                
                    $movimientoContable['fecha'] = date("Y-m-d H:i:s");
                    $movimientoContable['id_tipo_documento'] = $datosGenerales->id_tipo_documento;
                    $movimientoContable['cuenta'] = $movimientoscontables[$i]->cuenta;
                    $movimientoContable['descripcion'] = $movimientoscontables[$i]->descripcion;
                    $movimientoContable['referencia'] = $referencia;
                    $movimientoContable['id_configuracion_contable'] = $id_movimientocontable[$j];
                    $movimientoContable['valor'] = $abono;
                    $movimientoContable['tipo'] = $tipo[$j];
                    $movimientoContable['comprobante'] = $comprabante[$j];
                    $movimientoContable['observaciones'] = $observaciones[$j];
                    if($movimientoscontables[$i]->naturaleza == 1)
                    {
                        $movimientoContable['debito'] = $val[$j];
                        $movimientoContable['credito'] = 0;
                    }
                    else
                    {   
                        $movimientoContable['credito'] = $val[$j];
                        $movimientoContable['debito'] = 0;
                    }
                    
                    if($movimientoscontables[$i]->tienetercero == 1){
                        $movimientoContable['tercero'] = explode(" ",$movimientoscontables[$i]->nombre_cliente)[0];
                    }elseif($tercero != null){
                        $movimientoContable['tercero'] = $tercero;
                    }
                    DB::table('tbl_cont_movimientos_contables')->insertGetId($movimientoContable);
                    if($i < 1){
                        DB::table('tbl_cont_relacion_movimientos')->insert([
                                                                        'id_tema' => $id_tema,
                                                                        'id_tienda' => $tienda,
                                                                        'id_movimiento' => $id_movimiento,
                                                                        'id_abono' => $id_abono
                                                                    ]);
                    }
                }
            }
        }
        return $codigo_movimiento;
    }
    
    public static function AnularCausacionConPago($Comprobante,$idTienda,$Referencia,$QueAnular)
    {
        $CierreActual = self::getCierreCaja($idTienda);
        $Movimientos = self::getMovimientosContablesAndAnular($Comprobante,$Referencia,$QueAnular);
        self::AnularCierreDeCaja($CierreActual,$Movimientos['MovimientosCierre']);
    }

    private static function AnularCierreDeCaja($CierreActual,$Movimientos)
    {
        $MovimientosCierre = [];
        $DetalleMovimientosCierre = [];
        $AuxMovimientosCierre = \DB::table('tbl_tes_movimientos_cierre_caja')
        ->select()
        ->where('id_tienda_movimiento',$CierreActual[0]->id_tienda)
        ->whereIn('id_movimiento',$Movimientos)
        ->get();
        
        $AuxDetalleMovimientosCierre =  \DB::table('tbl_tes_detalle_movimientos_cierre_caja')
        ->select()
        ->where('id_tienda_movimiento',$CierreActual[0]->id_tienda)
        ->whereIn('id_movimiento',$Movimientos)
        ->get();
        
        for ($i=0; $i < count($AuxMovimientosCierre) ; $i++) 
        {
            //Movimiento del Cierre
            $secuencias = SecuenciaTienda::getCodigosSecuencia($CierreActual[0]->id_tienda,env('SECUENCIA_TIPO_MOVIMIENTO_CIERRE_CAJA'),1);
            $codigoMovimientoCierre = $secuencias[0]->response;
            $MovimientosCierre[$i]['id_movimiento'] = $codigoMovimientoCierre;
            $MovimientosCierre[$i]['id_tienda_movimiento'] = $AuxMovimientosCierre[$i]->id_tienda_movimiento;
            $MovimientosCierre[$i]['id_cierre'] = $AuxMovimientosCierre[$i]->id_cierre;
            $MovimientosCierre[$i]['id_tienda_cierre'] = $AuxMovimientosCierre[$i]->id_tienda_cierre;
            $MovimientosCierre[$i]['id_subclase'] = $AuxMovimientosCierre[$i]->id_subclase;
            $MovimientosCierre[$i]['valor'] = (-1)*$AuxMovimientosCierre[$i]->valor;
            $MovimientosCierre[$i]['fecha'] = date("Y-m-d H:i:s");
            
            //Detalle del Cierre
            for ($j=0; $j < count($AuxDetalleMovimientosCierre) ; $j++) 
            { 
                if($AuxMovimientosCierre[$i]->id_movimiento == $AuxDetalleMovimientosCierre[$i]->id_movimiento)
                {
                    //Movimiento del Cierre
                    $secuencias = SecuenciaTienda::getCodigosSecuencia($CierreActual[0]->id_tienda,env('SECUENCIA_TIPO_DETALLE_MOVIMIENTO_CIERRE_CAJA'),1);
                    $codigoDetalleMovimientoCierre = $secuencias[0]->response;
                    $DetalleMovimientosCierre[$j]['id_detalle'] = $codigoDetalleMovimientoCierre;
                    $DetalleMovimientosCierre[$j]['id_tienda_detalle'] = $AuxDetalleMovimientosCierre[$i]->id_tienda_detalle;
                    $DetalleMovimientosCierre[$j]['id_movimiento'] =$codigoMovimientoCierre ;
                    $DetalleMovimientosCierre[$j]['id_tienda_movimiento'] = $AuxDetalleMovimientosCierre[$i]->id_tienda_movimiento;
                    $DetalleMovimientosCierre[$j]['id_subclase'] = $AuxDetalleMovimientosCierre[$i]->id_subclase;
                    $DetalleMovimientosCierre[$j]['id_impuesto'] = $AuxDetalleMovimientosCierre[$i]->id_impuesto;
                    $DetalleMovimientosCierre[$j]['valor'] = (-1)*$AuxDetalleMovimientosCierre[$i]->valor;
                }
            }   
        }
        \DB::table('tbl_tes_movimientos_cierre_caja')->insert($MovimientosCierre);
        $resp = \DB::table('tbl_tes_detalle_movimientos_cierre_caja')->insert($DetalleMovimientosCierre);
        return ($resp);
    }

    private static function getMovimientosContablesAndAnular($Comprobante,$Referencia,$QueAnular)
    {
        if($QueAnular == "CauPago")
        {
            $AuxIdConfiguracion = \DB::table('tbl_cont_movimientos_contables')
                                        ->select('id_configuracion_contable')
                                        ->where('codigo_movimiento',$Comprobante)
                                        ->distinct()
                                        ->get();

            for ($i=0; $i < count($AuxIdConfiguracion) ; $i++) 
            {
                $IdConfiguraciones[$i] = $AuxIdConfiguracion[$i]->id_configuracion_contable;
            }
        }
        elseif($QueAnular == "Pago")
        {
            // obtener la configuracion contable del pago
            $AuxIdConfiguracion = \DB::table('tbl_cont_movimientos_contables')
                                        ->select('id_configuracion_contable')
                                        ->where('codigo_movimiento',$Comprobante)
                                        ->distinct()
                                        ->orderBy('id_configuracion_contable','desc')
                                        ->limit(1)
                                        ->get();
            for ($i=0; $i < count($AuxIdConfiguracion) ; $i++) 
            {
                $IdConfiguraciones[$i] = $AuxIdConfiguracion[$i]->id_configuracion_contable;
            }
        }
        elseif($QueAnular == "Cau")
        {
            $AuxIdConfiguracion = \DB::table('tbl_cont_movimientos_contables')
                                        ->select('id_configuracion_contable')
                                        ->where('codigo_movimiento',$Comprobante)
                                        ->distinct()
                                        ->orderBy('id_configuracion_contable','asc')
                                        ->limit(1)
                                        ->get();
            for ($i=0; $i < count($AuxIdConfiguracion) ; $i++) 
            {
                $IdConfiguraciones[$i] = $AuxIdConfiguracion[$i]->id_configuracion_contable;
            }
        }
        // obtener cierres de caja asociados al comprobante y al pago
        $Movimientos['MovimientosCierre'] = [];
        $AuxMovimientosCierre = \DB::table('tbl_cont_movimientos_contables_movimientos_cierre')
                                    ->select('codigo_movimiento_cierre')
                                    ->where('codigo_movimiento',$Comprobante)
                                    ->whereIn('id_configuracion_contable',$IdConfiguraciones)
                                    ->get();

        for ($i=0; $i < count($AuxMovimientosCierre) ; $i++) 
        { 
            $Movimientos['MovimientosCierre'][$i] = $AuxMovimientosCierre[$i]->codigo_movimiento_cierre;
        }

        $AuxMovimientos = \DB::table('tbl_cont_movimientos_contables')
                                        ->where('codigo_movimiento',$Comprobante)
                                        ->whereIn('id_configuracion_contable',$IdConfiguraciones)
                                        ->get();
        for ($i=0; $i < count($AuxMovimientos) ; $i++) 
        { 
            $secuencias = SecuenciaTienda::getCodigosSecuencia($AuxMovimientos[$i]->id_tienda,env('SECUENCIA_TIPO_CODIGO_MOVIMIENTO_CONTABLE'),1);
            $codigoMovimiento = $secuencias[0]->response;
            $Movimientos['Movimientos'][$i]['id_movimiento'] = $codigoMovimiento;
            $Movimientos['Movimientos'][$i]['id_cierre'] = $AuxMovimientos[$i]->id_cierre;            
            $Movimientos['Movimientos'][$i]['id_tienda'] = $AuxMovimientos[$i]->id_tienda;            
            $Movimientos['Movimientos'][$i]['codigo_movimiento'] = $AuxMovimientos[$i]->codigo_movimiento;            
            $Movimientos['Movimientos'][$i]['fecha'] =  date("Y-m-d H:i:s");            
            $Movimientos['Movimientos'][$i]['id_tipo_documento'] = $AuxMovimientos[$i]->id_tipo_documento;            
            $Movimientos['Movimientos'][$i]['cuenta'] = $AuxMovimientos[$i]->cuenta;
            $Movimientos['Movimientos'][$i]['descripcion'] = $AuxMovimientos[$i]->descripcion;
            $Movimientos['Movimientos'][$i]['referencia'] = $Referencia;
            $Movimientos['Movimientos'][$i]['debito'] = $AuxMovimientos[$i]->credito;
            $Movimientos['Movimientos'][$i]['credito'] = $AuxMovimientos[$i]->debito;
            $Movimientos['Movimientos'][$i]['id_configuracion_contable'] = $AuxMovimientos[$i]->id_configuracion_contable;
            $Movimientos['Movimientos'][$i]['valor'] = $AuxMovimientos[$i]->valor;
            $Movimientos['Movimientos'][$i]['automatico'] = $AuxMovimientos[$i]->automatico;
        }
        $AuxMovimientos = \DB::table('tbl_cont_movimientos_contables')->insert($Movimientos['Movimientos']);
        
        return $Movimientos;
    }
}
