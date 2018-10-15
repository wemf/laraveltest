<?php

namespace App\Http\Controllers\Nutibara\Contrato;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\BusinessLogic\Nutibara\Clientes\Empleado\CrudEmpleado;
use App\BusinessLogic\Nutibara\Clientes\TipoDocumento\CrudTipoDocumento;
use App\BusinessLogic\Nutibara\Contratos\VerificacionClienteWebService;
use App\BusinessLogic\Nutibara\Clientes\PersonaNatural\CrudPersonaNatural;
use App\AccessObject\Nutibara\Clientes\PersonaNatural\PersonaNatural;
use App\AccessObject\Nutibara\Contratos\Contrato;
use App\AccessObject\Nutibara\Clientes\Confiabilidad\Confiabilidad;
use App\AccessObject\Nutibara\SecuenciaTienda\SecuenciaTienda;
use App\BusinessLogic\Nutibara\Contratos\CrudContrato;
use App\Http\Middleware\userIpValidated;
use Illuminate\Support\Facades\Auth;
use App\BusinessLogic\FileManager\FileManagerSingle;
use App\AccessObject\Nutibara\GestionTesoreria\MovimientosTesoreria\MovimientosTesoreria;
use PDF;
use Carbon\Carbon;
use App\BusinessLogic\NumeroALetras\NumeroALetras;
use config\messages;

class CreacionContratoController extends Controller
{
    public function index( $tipodocumento, $numdocumento, $pa = null, $sa = null, $pn = null, $sn = null, $fn = null, $gen = null, $rh = null ){
        
        $usuario = Contrato::getDocumentoUsuario(Auth::user()->id);
        $tipo_documento_usr = (isset($usuario->tipo_documento)) ? $usuario->tipo_documento : 0;
        $numero_documento_usr = (isset($usuario->numero_documento)) ? $usuario->numero_documento : 0;
        if(Contrato::docGenerCotr($tipodocumento) == "1"){
            if($tipo_documento_usr != $tipodocumento || $numero_documento_usr != $numdocumento)
            {
                $ipValidation = new userIpValidated();
                $tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
                $cliente = PersonaNatural::getClienteByDocumento($tipodocumento, $numdocumento);
                $tipo_parentesco = CrudEmpleado::getSelectList('tipo_parentesco');
                $nombres = (isset($cliente->nombres)) ? explode(" ", $cliente->nombres) : '';
                $confiabilidad = Confiabilidad::Confiabilidad(null, 10, 'nombre', 'DESC');
                $count_cliente = count( $cliente );
                ( $count_cliente > 0 ) ? $ingresoManual = 'readonly' : $ingresoManual = '';
                $ultimo_cod_bolsa = 0;
                $enabletienda = 'disabled';
                $datos_cc = array(
                    'tipo_documento' => $tipodocumento,
                    'numero_documento'=> $numdocumento,
                    'primer_nombre' => ( $count_cliente == 0 ) ? $pn : ((isset($nombres[ 0 ])) ? $nombres[ 0 ] : ''),
                    'segundo_nombre' => ( $count_cliente == 0 ) ? $sn: ((isset($nombres[ 1 ])) ? $nombres[ 1 ] : ''),
                    'primer_apellido' => ( $count_cliente == 0 ) ? $pa : $cliente->primer_apellido,
                    'segundo_apellido' => ( $count_cliente == 0 ) ? $sa : $cliente->segundo_apellido,
                    'fecha_nacimiento' => ( $count_cliente == 0 ) ? (($fn != null)?substr($fn, 0, 4) . "-" . substr($fn, 4, 2) . "-" . substr($fn, 6, 2):$fn) : $cliente->fecha_nacimiento,
                    'genero' => ( $count_cliente == 0 ) ? $gen : $cliente->genero,
                );
                
                if($tienda == null && Auth::user()->role->id == env('ROLE_SUPER_ADMIN')){
                    $tienda = (object) [
                        'id' => 0,
                        'nombre' => ''
                    ];
                    $enabletienda = '';
                } else {
                    $ultimo_cod_bolsa = Contrato::getUltimoCodBolsa($tienda->id);
                    if($ultimo_cod_bolsa == null) $ultimo_cod_bolsa = 0;
                }
                
                if( $tienda->id > 0 ) {
                    $cod_bolsas_bloq = Contrato::getCodBolsasBloq($tienda->id, $ultimo_cod_bolsa);
                } else {
                    $cod_bolsas_bloq = 0;
                }
                if(empty($cliente)){
                    return view('Contrato.generacioncontrato', ["cliente" => $cliente, "tienda" => $tienda, "enabletienda" => $enabletienda, "datos_cc" => $datos_cc, "tipo_parentesco" => $tipo_parentesco, "accion_cliente" => "create", "ultimo_cod_bolsa" => $ultimo_cod_bolsa, "ingresoManual" => $ingresoManual, 'confiabilidad' => $confiabilidad, 'cod_bolsas_bloq' => $cod_bolsas_bloq]);
                }else{
                    return view('Contrato.generacioncontrato', ["cliente" => $cliente, "tienda" => $tienda, "enabletienda" => $enabletienda, "datos_cc" => $datos_cc, "tipo_parentesco" => $tipo_parentesco, "accion_cliente" => "update", "ultimo_cod_bolsa" => $ultimo_cod_bolsa, "ingresoManual" => $ingresoManual, 'confiabilidad' => $confiabilidad, 'cod_bolsas_bloq' => $cod_bolsas_bloq]);
                }
            } else {
                Session::flash('error', Messages::$Notificacion['error_contrato_empleado']);
                return redirect()->back();
            }
        } else {
            Session::flash('warning', 'Tipo de documento no válido para generar contrato');
            return redirect()->back();
        }     
    }


    public function index_old($tipodocumento, $numdocumento, $pa = null, $sa = null, $pn = null, $sn = null, $fn = null, $gen = null, $rh = null){
        $ingresoManual = 'readonly';
        
        $datos_cc = array(
            'tipo_documento' => $tipodocumento,
            'numero_documento'=> $numdocumento,
            'primer_nombre' => $pn,
            'segundo_nombre' => $sn,
            'primer_apellido' => $pa,
            'segundo_apellido' => $sa,
            'fecha_nacimiento' => ($fn != null)?substr($fn, 0, 4) . "-" . substr($fn, 4, 2) . "-" . substr($fn, 6, 2):$fn,
            'genero' => $gen,
            'rh' => str_replace("¡", "+", $rh)
        );
		$tipo_parentesco = CrudEmpleado::getSelectList('tipo_parentesco');
        $cliente = PersonaNatural::getClienteByDocumento($tipodocumento, $numdocumento);
        $nombres = (isset($cliente->nombres)) ? explode(" ", $cliente->nombres) : '';
        if(count($cliente) == 0){
            $ingresoManual = '';
        }else if($pa == null){
            $datos_cc = array(
            'tipo_documento' => $tipodocumento,
            'numero_documento'=> $numdocumento,
            'primer_nombre' => (isset($nombres[ 0 ])) ? $nombres[ 0 ] : '',
            'segundo_nombre' => (isset($nombres[ 1 ])) ? $nombres[ 1 ] : '',
            'primer_apellido' => $cliente->primer_apellido,
            'segundo_apellido' => $cliente->segundo_apellido,
            'fecha_nacimiento' => $cliente->fecha_nacimiento,
            'genero' => $cliente->genero
        );
        }
        $ipValidation = new userIpValidated();
        $tienda = Contrato::getTiendaByIp($ipValidation->getRealIP());
        $enabletienda = 'disabled';

        $confiabilidad = Confiabilidad::Confiabilidad(null, 10, 'nombre', 'DESC');
        
        if($tienda == null && Auth::user()->role->id == env('ROLE_SUPER_ADMIN')){
            $tienda = (object) [
                'id' => 0,
                'nombre' => ''
            ];
            $enabletienda = '';
        }
        $ultimo_cod_bolsa = Contrato::getUltimoCodBolsa($tienda->id);
        if(isset($ultimo_cod_bolsa[0]->sec_siguiente)) $ultimo_cod_bolsa = $ultimo_cod_bolsa[0]->sec_siguiente; 
        else $ultimo_cod_bolsa = 0;

        if( $tienda->id > 0 ) {
            $cod_bolsas_bloq = Contrato::getCodBolsasBloq($tienda->id, $ultimo_cod_bolsa);
        } else {
            $cod_bolsas_bloq = 0;
        }
        
        // $ultimo_cod_bolsa = 0;

        if(empty($cliente)){
            return view('Contrato.generacioncontrato', ["cliente" => $cliente, "tienda" => $tienda, "enabletienda" => $enabletienda, "datos_cc" => $datos_cc, "tipo_parentesco" => $tipo_parentesco, "accion_cliente" => "create", "ultimo_cod_bolsa" => $ultimo_cod_bolsa, "ingresoManual" => $ingresoManual, 'confiabilidad' => $confiabilidad, 'cod_bolsas_bloq' => $cod_bolsas_bloq]);
        }else{
            return view('Contrato.generacioncontrato', ["cliente" => $cliente, "tienda" => $tienda, "enabletienda" => $enabletienda, "datos_cc" => $datos_cc, "tipo_parentesco" => $tipo_parentesco, "accion_cliente" => "update", "ultimo_cod_bolsa" => $ultimo_cod_bolsa, "ingresoManual" => $ingresoManual, 'confiabilidad' => $confiabilidad, 'cod_bolsas_bloq' => $cod_bolsas_bloq]);
        }
        
    }

    public function getTerminoRetroventa(Request $request){
        $data = Contrato::getTerminoRetroventa($request->id_categoria_general, $request->id_tienda_contrato, $request->monto);
        return response()->json($data);
    }

    public function validarBolsaPeso(Request $request){
        $bolsa = Contrato::validarBolsaPeso($request->categoria);
        return response()->json($bolsa);
    }

    public function pesoEstimado(Request $request){
        $peso_estimado = Contrato::pesoEstimado($request->categoria, $request->tienda, $request->valores_atributos);
        return response()->json($peso_estimado);
    }

    public function getItems($codigo, $idtienda, Request $request){
        $start=(int)$request->start;
		$end=$start+(int)$request->length;
		$draw= (int)$request->draw;   
		$order=$request->order[0]['dir'];
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];  
        $total=Contrato::getCountItemsContrato($codigo,$idtienda);
		$data=[
            "draw"=> $draw,
            "recordsTotal"=> $total,
            "recordsFiltered"=> $total,
			"data"=>Contrato::getItem($start,$end,$colum,$order,$codigo,$idtienda)
		];
		return response()->json($data);
    }

    public function getItemsContrato($codigo, $idtienda){
        $data["data"] = Contrato::getItemsContrato($codigo,$idtienda);
        $data["columnas_items"] = Contrato::getColumnasItems( $codigo, $idtienda );
		$data["datos_columnas_items"] = Contrato::getDatosColumnasItems( $codigo, $idtienda );
		return response()->json($data);
    }

    public function crearCliente(Request $request){
        $huella = PersonaNatural::validarVigenciaHuella( $request->tipodocumento, $request->numdocumento );
        $query = -3;
        if(isset($huella)){
            if($huella->minutos_transcurridos <= 15){
                $single_1 = new FileManagerSingle($request->foto_1);
                $single_2 = new FileManagerSingle($request->foto_2);
                $key = uniqid();
                $id_file1 = $single_1->moveFile($key,env('RUTA_ARCHIVO')."colombia".DIRECTORY_SEPARATOR."cliente".DIRECTORY_SEPARATOR."doc_persona_natural");
                $id_file2 = $single_2->moveFile($key,env('RUTA_ARCHIVO')."colombia".DIRECTORY_SEPARATOR."cliente".DIRECTORY_SEPARATOR."doc_persona_natural");
                $data = [
                    'id_tipo_cliente' => 3,
                    'id_tipo_documento' => $request->tipodocumento,
                    'numero_documento' => $request->numdocumento,
                    'fecha_nacimiento' => $request->fechanacimiento,
                    'fecha_expedicion' => $request->fecha_expedicion,
                    'id_pais_expedicion' => $request->pais_expedicion,
                    'id_ciudad_expedicion' => $request->ciudad_expedicion,
                    'id_ciudad_residencia' => $request->ciudad_residencia,
                    'nombres' => $request->primer_nombre.' '.$request->segundo_nombre,
                    'primer_apellido' => $request->primer_apellido,
                    'segundo_apellido' => $request->segundo_apellido,
                    'correo_electronico' => $request->correo,
                    'genero' => $request->genero,
                    'direccion_residencia' => $request->direccion_residencia,
                    'id_regimen_contributivo' => $request->regimen,
                    'telefono_residencia' => trim($request->telefono_residencia),
                    'telefono_celular' => trim($request->telefono_celular),
                    // 'id_confiabilidad' => (int)$request->cliente_confiable,
                    // 'suplantacion' => (int)$request->suplantacion,
                    'id_foto_documento_anterior' => $id_file1['msm'][1],
                    'id_foto_documento_posterior' => $id_file2['msm'][1],
                    'estado' => 1,
                ];

                $query = CrudPersonaNatural::crearClienteContrato($request->id_tienda, $data);
                if($query > 0) self::agregarHuella($request->tipodocumento, $request->numdocumento);
            }
        }
        return json_encode((int)$query);
    }

    public function actualizarCliente(Request $request){
        $huella = PersonaNatural::validarVigenciaHuella( $request->tipodocumento, $request->numdocumento );
        $query = -3;
        if(isset($huella)){
            if($huella->minutos_transcurridos <= 15){
                if(trim($request->hf_guardar_anterior == 1)){
                    $single_1 = new FileManagerSingle($request->foto_1);
                    $key = uniqid();
                    $id_file1 = $single_1->moveFile($key,env('RUTA_ARCHIVO')."colombia".DIRECTORY_SEPARATOR."cliente".DIRECTORY_SEPARATOR."doc_persona_natural");
                }
                if(trim($request->hf_guardar_posterior == 1)){
                    $single_2 = new FileManagerSingle($request->foto_2);
                    $key2 = uniqid();
                    $id_file2 = $single_2->moveFile($key2,env('RUTA_ARCHIVO')."colombia".DIRECTORY_SEPARATOR."cliente".DIRECTORY_SEPARATOR."doc_persona_natural");
                }
                
                $data = [
                    'fecha_nacimiento' => trim($request->fechanacimiento),
                    'correo_electronico' => trim($request->correo),
                    'direccion_residencia' => trim($request->direccion_residencia),
                    'telefono_residencia' => trim($request->telefono_residencia),
                    'telefono_celular' => trim($request->telefono_celular),
                    'nombres' => trim($request->primer_nombre.' '.$request->segundo_nombre),
                    'primer_apellido' => trim($request->primer_apellido),
                    'segundo_apellido' => trim($request->segundo_apellido),
                    'id_confiabilidad' => (int)$request->cliente_confiable, 
                    // 'suplantacion' => (int)$request->suplantacion,
                ];
                if(trim($request->hf_guardar_anterior == 1)){
                    $data += ['id_foto_documento_anterior' => $id_file1['msm'][1]];
                }
                if(trim($request->hf_guardar_posterior == 1)){
                    $data += ['id_foto_documento_posterior' => $id_file2['msm'][1]];
                }
                $query = PersonaNatural::actualizarClientes($request->id_tienda, $request->codigo_cliente, $data, null);
                self::agregarHuella($request->tipodocumento, $request->numdocumento);
            }else{
                $query = -3;
            }
        }
        return json_encode($query);
    }

    public function agregarHuella( $id_tipo_documento, $numero_documento ){
        $result = true;
        try{
            $huella = PersonaNatural::getHuella( $id_tipo_documento, $numero_documento );
            $data = [
                "id_tienda" => $huella->id_tienda,
                "id_cliente" => $huella->codigo_cliente,
                "huella" => $huella->huella,
                "updated_at" => date("Y-m-d H:i:s")
            ];
            PersonaNatural::agregarHuella($data);
        }catch(\Exception $ex){
            $result = false;
        }
        return $result;
    }

    public function getItemsContratoById( Request $request ){
		$msm = CrudContrato::getItemsContratoById($codigo, $tienda);
		return response()->json($msm);
    }
    
    public function getResumen(Request $request){
        $id_tienda_contrato = $request->id_tienda_contrato;
        $id_codigo_contrato = $request->id_codigo_contrato;
        $resumen_contrato = Contrato::getResumen($id_tienda_contrato, $id_codigo_contrato);
        return response()->json($resumen_contrato);
    }

    public function guardarContrato(Request $request){

        //Secuencias de Bolsa de Seguridad(tienda,codigo de bolsa de seguridad, cantidad).
        if($request->numero_bolsa > 0){
            $secuencias = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_contrato,env('SECUENCIA_TIPO_CODIGO_BOLSA_SEGURIDAD'),$request->numero_bolsa);
            //Si solo necesita una bolsa, no es posible hacer el explode.
            //Para no dañar el objeto data, creo un array "secuencia_tienda" e ingreso el valor llamado del procedure.
            if( $request->numero_bolsa > 1  && $secuencias[ 0 ]->response != -1 )
                $secuencia_tienda = explode( ",", $secuencias[ 0 ]->response );

            else if( $request->numero_bolsa == 0 || $request->numero_bolsa == null )
                $secuencia_tienda[ 0 ] = 0;
            
            else
                $secuencia_tienda[ 0 ] = $secuencias[ 0 ]->response;
        }else{
            $secuencia_tienda[ 0 ] = 0;
        }

        $codigo_contrato = SecuenciaTienda::getCodigosSecuencia($request->id_tienda_contrato,env('SECUENCIA_TIPO_CODIGO_CONTRATO'),1);
        
        if( $codigo_contrato[ 0 ]->response > 0 ) {
            $data = [
                'id_tienda_contrato' => $request->id_tienda_contrato,
                'codigo_contrato' => $codigo_contrato[ 0 ]->response,
                'id_tienda_cliente' => $request->id_tienda_cliente,
                'codigo_cliente' => ( int )$request->codigo_cliente,
                'id_categoria_general' => $request->id_categoria_general,
                'porcentaje_retroventa' => $request->porcentaje_retroventa,
                'termino' => $request->termino,
                'dias_gracia' => ($request->dias_gracia == '') ? 0 : $request->dias_gracia,
                'id_estado_contrato' => env( 'ESTADO_CREACION_CONTRATO' ),
                // 'id_motivo_contrato' => env( 'MOTIVO_CREACION_CONTRATO' ),
                'fecha_creacion' => Carbon::parse($request->fecha_creacion),
                'fecha_terminacion' => Carbon::parse( $request->fecha_terminacion )->format( 'Y-m-d' ),
                'cod_bolsa_seguridad_desde' => $secuencia_tienda[ 0 ],
                'cod_bolsa_seguridad_hasta' => end( $secuencia_tienda ),
                'cod_bolsas_seguridad' => $request->codigos_bolsas,
            ];
            $query = Contrato::Create( $data );

            if($query)
            {
                
            }
            $detalleValores = [];
            for ( $i = 0; $i < count( $request->detail_attribute_values ); $i++ ) { 
                array_push( $detalleValores, [
                    'id_tienda' => $request->id_tienda_contrato,
                    'id_codigo_contrato' => $codigo_contrato[ 0 ]->response,
                    'id_linea_item_contrato' => $request->detail_attribute_values[ $i ][ 0 ],
                    'id_atributo_valor' => $request->detail_attribute_values[ $i ][ 1 ],
                ] );
            }
            $queryDetalleValores = Contrato::guardarDetalleValores( $detalleValores );


            if( $query ) {
                $datos_especificos = [
                    //id de la tienda del contrato
                    'numero_1' => $request->id_tienda_contrato,
                    //porcentaje de retroventa del contrato
                    'dato_1' => $request->porcentaje_retroventa,
                    //fecha de creación del contrato
                    'fecha_1' => Carbon::parse( $request->fecha_creacion )->format( 'Y-m-d' ),

                    //código del contrato
                    'numero_2' => $codigo_contrato[ 0 ]->response,
                    //término del contrato
                    'dato_2' => $request->termino,
                    //fecha de terminación del contrato
                    'fecha_2' => Carbon::parse( $request->fecha_terminacion )->format( 'Y-m-d' ),
                    
                    //número de bolsas del contrato
                    'numero_3' => $request->numero_bolsa,
                    //categoría general del contrato
                    'dato_3' => $request->id_categoria_general,
                    //fecha de terminación del contrato
                    'fecha_3' => null,

                    'transaccion' => "create",
                    'operacion' => "Creación de contrato",
                    'log' => null,
                ];

                //(Valor, Tienda, id_movimientocontable (4 CREAR CONTRATO.))
                $referencia = "CREACONTR".$codigo_contrato[ 0 ]->response.'/'.$request->id_tienda_contrato;
                MovimientosTesoreria::registrarMovimientos($request->valor_contrato,$request->id_tienda_contrato,4,NULL,$referencia);
                CrudContrato::crearAuditoria( $datos_especificos );
            }
            if( $request->informacion_tercero == 1 ) {
                $dataTercero = [
                    'id_tienda' => $request->id_tienda_contrato,
                    'id_codigo_contrato' => $codigo_contrato[ 0 ]->response,
                    'id_tipo_documento' => $request->id_tipo_documento_tercero,
                    'numero_documento' => $request->numero_documento_tercero,
                    'nombres' => $request->nombres_tercero,
                    'apellidos' => $request->apellidos_tercero,
                    'telefono' => $request->telefono_tercero,
                    'celular' => $request->celular_tercero,
                    'correo' => $request->correo_tercero,
                    'direccion' => $request->direccion_tercero,
                    'parentesco' => $request->parentesco_tercero
                ];
                $queryTercero = Contrato::guardarTercero( $dataTercero );
            }
        }
        Session::flash('session_tienda_pdf', $request->id_tienda_contrato);
		Session::flash('session_contrato_pdf', $codigo_contrato[ 0 ]->response);
        return response()->json( $codigo_contrato[ 0 ]->response );
    }

    public function generatePDF( Request $request ) {        
        $user = Auth::user()->name;
		$date = Carbon::now();
        $object = Contrato::getContratoPDF( $request->contrato_pdf, $request->tienda_pdf, Auth::user()->id );
        $empleado = Contrato::getInfoEmpleado( Auth::user()->id );
        $moneda = Contrato::getMoneda();
        $columnas_items = Contrato::getColumnasItems( $request->contrato_pdf, $request->tienda_pdf );
        $datos_columnas_items = Contrato::getDatosColumnasItems( $request->contrato_pdf, $request->tienda_pdf );
        $remove = ['.', ',00', '$', ' '];
        $object[ 0 ]->valor_contrato_texto = NumeroALetras::convertir( str_replace( $remove, '', $object[ 0 ]->valor_contrato ) );
        $object[ 0 ]->retroventa_contrato_texto = NumeroALetras::convertir( str_replace( $remove, '', $object[ 0 ]->valor_retroventa ) );
        $copia = (isset($request->copia_pdf)) ? true : false;
        $pdf = PDF::loadView( 'DocumentosPDF.compraventacontrato', [ 'object' => $object, 'empleado' => $empleado,'user' => $user, 'date' => $date, 'moneda' => $moneda, 'columnas_items' => $columnas_items, 'datos_columnas_items' => $datos_columnas_items, 'copia' => $copia ] );
        return $pdf->download( 'retroventacontrato.pdf' );
    }
    
    public function pdfCompraventaContrato($codigo_contrato, $id_tienda){
		$user = Auth::user()->name;
		$date = Carbon::now();
        $object = Contrato::getContratoPDF( $codigo_contrato, $id_tienda, Auth::user()->id );
        $empleado = Contrato::getInfoEmpleado( Auth::user()->id );
        $columnas_items = Contrato::getColumnasItems( $codigo_contrato, $id_tienda );
        $datos_columnas_items = Contrato::getDatosColumnasItems( $codigo_contrato, $id_tienda );
        $moneda = Contrato::getMoneda();
        $remove = [ '.', ',00', '$', ' ' ];
        $object[ 0 ]->valor_contrato_texto = NumeroALetras::convertir( str_replace( $remove, '', $object[ 0 ]->valor_contrato ) );
        $object[ 0 ]->valor_retroventa_texto = NumeroALetras::convertir( str_replace( $remove, '', $object[ 0 ]->valor_retroventa ) );
        $copia = (isset($request->copia_pdf)) ? true : false;
        return view( 'DocumentosPDF.compraventacontrato', [ 'object' => $object, 'empleado' => $empleado,'user' => $user, 'date' => $date, 'columnas_items' => $columnas_items, 'datos_columnas_items' => $datos_columnas_items, 'moneda' => $moneda, 'copia' => $copia ] );
    }

    public function actualizarContrato( Request $request ){
        $data = [
            'id_categoria_general' => $request->id_categoria_general,
            'porcentaje_retroventa' => $request->porcentaje_retroventa,
            'termino' => $request->termino,
            'fecha_creacion' => Carbon::parse( $request->fecha_creacion )->format( 'Y-m-d' ),
            'fecha_terminacion' => Carbon::parse( $request->fecha_terminacion )->format( 'Y-m-d' ),
        ];
        $query = Contrato::actualizarContrato( $request->codigo_contrato, $request->id_tienda_contrato, $data );
        if( $request->informacion_tercero == 1 ){
            $dataTercero = [
                'id_tipo_documento' => $request->id_tipo_documento_tercero,
                'numero_documento' => $request->numero_documento_tercero,
                'nombres' => $request->nombres_tercero,
                'apellidos' => $request->apellidos_tercero,
                'telefono' => $request->telefono_tercero,
                'celular' => $request->celular_tercero,
                'correo' => $request->correo_tercero,
                'direccion' => $request->direccion_tercero,
                'parentesco' => $request->parentesco_tercero
            ];
            $queryTercero = Contrato::actualizarTercero( $request->codigo_contrato, $request->id_tienda_contrato, $dataTercero );
        }
		return response()->json( $query );
    }

    public function guardarItem( Request $request ){
        $id_item_contrato = Contrato::getItemContrato( $request->id_categoria_general );
        $data_items = $request->items;
        for ( $i = 0; $i < count( $data_items ); $i++ ) { 
            $data_items[ $i ] = $id_item_contrato;
        }
        $queryDetalle = Contrato::guardarDetalle( $request->detalles );
        $query = Contrato::guardarItem( $request->items );
		return response()->json( $query );
    }

    public function verificarcliente(){
        $tipos_doc = CrudTipoDocumento::getSelectList2();
        $urls = array(
			[
				'href' => 'home',
				'text' => 'home'
			],
			[
				'href' => 'contrato/index',
				'text' => 'Gestión de Contratos'
			],
			[
				'href' => 'contrato/index',
				'text' => 'Gestionar Contratos'
			],
			[
				'href' => 'creacioncontrato/verificacioncliente',
				'text' => 'Generación de Contrato'
			]
		);
        return view( 'Contrato.verificacioncliente', [ 'tipos_doc' => $tipos_doc ,'urls' => $urls ] );
    }

    public function verificacionclientewebservice( Request $request ) {
        $datos = [
            'action' => $request->action,
            'tipodocumento' => $request->tipodocumento,
            'numdocumento' => $request->numdocumento,
        ];

        // SE COMENTA PORQUE GENERA CONFLICTOS, MIENTRAS SABEMOS CUAL ES EL REAL SERVICIO SE DEJA COMENTADO
        // $objVerifiacion = new VerificacionClienteWebService( $datos );
        // $verificacionCliente = $objVerifiacion->verificacionCliente();
        // return $verificacionCliente;



        $customer=array(
            'state'=>true,
            'msm'=>'NO TIENE ASUNTOS PENDIENTES CON LAS AUTORIDADES JUDICIALES',
            'tipo-documento' => null,
            'num-documento' => null,
            'codigo' => 002
        );
        return json_encode($customer);
    }

    public function deleteItem( Request $request ) {
		$msm = Contrato::deleteItem( $request->id, $request->id_tienda, $request->codigo_contrato );
		$a = array( 'msm' => array( 'msm'=>'Item eliminado correctamente', 'val' => true ) );
        return response()->json( $a );
    }

    public function getItemContratoDetalle( Request $request ){
        $a = Contrato::getItemContratoDetalle( $request->id, $request->id_tienda, $request->codigo_contrato );
        return response()->json( $a );
    }

    public function actualizarItem( Request $request ){
        $where = [
            'id_tienda' => $request->id_tienda,
            'id_codigo_contrato' => $request->codigo_contrato,
            'id_linea_item_contrato' => $request->id
        ];

        $data = [
            'nombre' => $request->nombre,
            'peso_estimado' => $request->peso_estimado,
            'peso_total' => $request->peso_total,
            'precio_sugerido' => $request->precio_sugerido,
            'precio_ingresado' => $request->precio_ingresado,
            'observaciones' => $request->observaciones,
        ];

        $query = Contrato::actualizarItem( $data, $where );
		return response()->json( $query );
    }

    public function getAtributosValoresItem( Request $request ){
        $valores_item = $request->valores_item;
        $atributos_valores = Contrato::getAtributosValoresItem( $valores_item );
        return response()->json( $atributos_valores );
    }
}