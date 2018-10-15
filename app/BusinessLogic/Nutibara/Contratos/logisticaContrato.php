<?php

namespace App\BusinessLogic\Nutibara\Contratos;

use App\AccessObject\Nutibara\Contratos\Logistica as ModelLogistica;
use App\AccessObject\Nutibara\Pais\Pais as ModelPais;
use App\BusinessLogic\Datatable_v2\DatatableBL;
use App\BusinessLogic\Notificacion\Logistica;
use config\messages;
use DB;

class logisticaContrato
{
    public static function get($request)
    {
        $select=ModelLogistica::get();
        $search = array(
			[
				'tableName' => 'tbl_guia', //tabla de busqueda 
				'field' => 'id', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
            ],
            [
				'tableName' => 'tbl_guia', //tabla de busqueda 
				'field' => 'codigo_guia', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
            ],	
            [
				'tableName' => 'tbl_guia', //tabla de busqueda 
				'field' => 'id_tienda', //campo que en el que se va a buscar
				'method' => '=', // metodo a utiliza = o like
				'typeWhere' => 'where', // typo where orwhere wherebetween etc..
				'searchField' => null, // valor de campo siempre se envia null
				'searchDate' => null, // valor de campo 2 siempre se envia null a menos que el typewhere sea = wherebetween se envia = true
            ],
        );
        $where = "";
        $table=new DatatableBL($select,$search,$where);
		return $table->Run($request);	
    }

    public static function getResolucionesById($id)
    {
        $response = ModelLogistica::getResolucionesById($id);
        return $response;
    }

    public static function getSedePrincipal($id)
    {
        $response = ModelLogistica::getSedePrincipal($id);
        return $response;
    }

    public static function getSelectListPrincipal()
    {
        $response = ModelLogistica::getSelectListPrincipal();
        return $response;
    }

    public static function getEmpleadosTienda($id)
    {
        $response = ModelLogistica::getEmpleadosTienda($id);
        return $response;
    }

    public static function createPost($datasaved)
    {
        
        // $nt = new Logistica(47,19,0);
        // $var = $nt->notificarAdminBodega('Solicitud envio','contrato/logistica/seguimiento/93');
        // dd($var);
        
        ///////////////////////////////////////////////
        $estado = env('ESTADO_LOGISTICA_SOLICITUD_ENVIO');
        $pais = ModelLogistica::getPaisTienda($datasaved->id_tienda);
        // dd($datasaved->id_tienda);
        $id_sec_guia = ModelLogistica::sec_guia($datasaved->id_tienda);
        $codigo_guia = $pais->abreviatura.'0'.$datasaved->id_tienda.'0'.$id_sec_guia[0]->response;
        $data = self::adaptadorCrear($datasaved,$id_sec_guia,$estado,$codigo_guia);
        $traza = self::generateLog($datasaved->bodega_envio,$id_sec_guia[0]->response,"Creación de guia ".$codigo_guia);

        $valdestino = ModelLogistica::valdestino($datasaved->id_tienda);
        $valdestino = $valdestino->tipo_bodega;
        // dd($traza);
        $respuesta = ModelLogistica::createPost($data,$traza,$datasaved->datosrelaciones,$datasaved->id_tienda);

		if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Logistica['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
            $nt = new Logistica($id_sec_guia,$datasaved->id_tienda,0);
            $lg = $id_sec_guia[0]->response;
            if($valdestino == 1){
                $var = $nt->notificarAdminBodega('Solicitud envio','contrato/logistica/seguimiento/'.$lg);
            }else{
                $var = $nt->notificarAdminTienda('Solicitud envio','contrato/logistica/seguimiento/'.$lg);
            }

			$msm=['msm'=>Messages::$Logistica['ok'],'val'=>'Insertado'];	
		}
		return $msm;
    }

    public static function generateLog($destino,$id,$observaciones)
    {
        $datasaved = [
            'fecha' => date('Y-m-d H:i:s'),
            'id_estado' => env('ESTADO_LOGISTICA_SOLICITUD_ENVIO'),
            'destino' => $destino,
            'observaciones' => $observaciones,
            'sec_guia' => $id,
            'id_motivo' => env('MOTIVO_LOGISTICA_SOLICITUD_ENVIO')
        ];
 
        return $datasaved;
    }

    public static function adaptadorCrear($datasaved,$id_sec_guia,$estado,$codigo_guia)
    {   

        $data = array();
        for($i = 0; $i < count($datasaved->datosrelaciones); $i++)
        {
            $data[$i] = [
                'id_bodega_envio' => (int)$datasaved->bodega_envio,
                'id_estado' => (int)$estado,
                'id_resolucion' => (int)$datasaved->datosrelaciones[$i],
                'id_tienda' => (int)$datasaved->id_tienda,
                'id_tienda_principal' => (int)$datasaved->id_tienda_envio,
                'id_user_bodega' => (int)$datasaved->user_bodega,
                // 'id_sec_guia' => (int)$id_sec_guia,
                'id_sec_guia' => (int)$id_sec_guia[0]->response,
                'codigo_guia' => $codigo_guia,
                'fecha_creacion' => date('Y-m-d H:i:s'),
                'id_motivo' => env('MOTIVO_LOGISTICA_SOLICITUD_ENVIO')
            ];
        }
        return $data;
    }

    public static function getSelectListByTipe($tipe,$city,$id_tienda)
    {
        $response = ModelLogistica::getSelectListByTipe($tipe,$city,$id_tienda);
        return $response;
    }

    public static function getTrazabilidad($id)
    {
        $info_traza = ModelLogistica::getTrazabilidad($id);
        $traza = array();
        for($i = 0; $i < count($info_traza); $i++)
        {
            $traza[$i] =  [
                    'estado' => ['titulo'=> 'Estado','descripcion' => $info_traza[$i]->estado],
                    'fecha' => ['titulo'=> 'Fecha','descripcion' => $info_traza[$i]->fecha],
                    'codigo' => ['titulo'=> 'Codigo','descripcion' => $info_traza[$i]->codigo],
                    'destino' => ['titulo'=> 'Destino','descripcion' => $info_traza[$i]->destino],
                    'observaciones' => ['titulo'=> 'Observaciones','descripcion' => $info_traza[$i]->observaciones]
            ];
        }
        
        return $traza;
    }

    public static function anularGuia($request,$id)
    {
        $datasaved = [
            'fecha' => date('Y-m-d H:i:s'),
            'id_estado' => 71,
            'destino' => $request->destino,
            'observaciones' => $request->observaciones,
            'sec_guia' => $id
        ];

        $respuesta = ModelLogistica::anularGuia($datasaved,$id);
        if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Logistica['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{
			$msm=['msm'=>Messages::$Logistica['ok_anular'],'val'=>'Insertado'];	
		}
		return $msm;
    }
    public static function seguimientoGuia($request,$id)
    {
        $datasaved = [
            'fecha' => date('Y-m-d H:i:s'),
            'id_estado' => $request->id_estado,
            'id_motivo' => $request->id_motivo,
            'destino' => $request->destino,
            'observaciones' => $request->observaciones,
            'sec_guia' => $id
        ];

        $valdestino = ModelLogistica::valdestino($request->destino);
        $valdestino = $valdestino->tipo_bodega;

        $respuesta = ModelLogistica::seguimientoGuia($datasaved,$id,$request->id_estado,$request->id_motivo);
        if($respuesta=='Error')
        {
			$msm=['msm'=>Messages::$Logistica['error'],'val'=>'Error'];		
		}
		elseif($respuesta=='ErrorUnico')
		{
			$msm=['msm'=>Messages::$ExectionGeneral['error_unique'],'val'=>'ErrorUnico'];	
		}
		elseif($respuesta=='Insertado')
		{   
            $nt = new Logistica($id,$request->destino,0);
            if($valdestino == 1){
                $var = $nt->notificarAdminBodega('Nueva guia','contrato/logistica/seguimiento/'.$id);
            }else{
                $var = $nt->notificarAdminTienda('Nueva guia','contrato/logistica/seguimiento/'.$id);
            }
			$msm=['msm'=>Messages::$Logistica['ok'],'val'=>'Insertado'];	
		}
		return $msm;
    }

    public static function getTiendaByIp($ip){
		return ModelLogistica::getTiendaByIp($ip);
	}
}

?>