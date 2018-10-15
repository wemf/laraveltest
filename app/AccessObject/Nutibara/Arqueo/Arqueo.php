<?php 

namespace App\AccessObject\Nutibara\Arqueo;


class Arqueo 
{
	public static function getMonedas($pais)
	{
            
		try
		{
            return \DB::table('tbl_sys_denominacion_moneda')
                            ->select('tbl_sys_denominacion_moneda.denominacion',
                                         'tbl_sys_denominacion_moneda.valor')
                            ->where('tbl_sys_denominacion_moneda.id_pais',$pais->id)
                            ->where('estado',1)
                            ->orderby('tbl_sys_denominacion_moneda.valor','asc')
                            ->get();
		}catch(\Exception $e)
		{
            return false;
		}
      }
      
      public static function getTiendaInfo($id)
	{
            
		try
		{
            return \DB::table('tbl_tienda')
                        ->join('tbl_ciudad','tbl_tienda.id_ciudad','tbl_ciudad.id')
                        ->join('tbl_sociedad','tbl_tienda.id_sociedad','tbl_sociedad.id')
                        ->join('tbl_franquicia','tbl_tienda.id_franquicia','tbl_franquicia.id')
                        ->join('tbl_clie_regimen_contributivo','tbl_sociedad.id_regimen','tbl_clie_regimen_contributivo.id')
                        ->select('tbl_tienda.direccion AS Direccion',
                                    'tbl_tienda.telefono AS Telefono',
                                    'tbl_ciudad.nombre AS Ciudad',
                                    'tbl_sociedad.nombre AS Sociedad',
                                    'tbl_franquicia.nombre AS Franquicia',
                                    'tbl_clie_regimen_contributivo.nombre AS Regimen'
                        )
                        ->where('tbl_tienda.id',$id)
                        ->first();
		}catch(\Exception $e)
		{
            return false;
		}
      }

      public static function getCierreCaja($id)
      {
            try
            {
                  return \DB::table('tbl_tes_cierre_caja')
                              ->select(\DB::Raw("FORMAT(saldo_inicial,(select decimales from tbl_parametro_general limit 1),'de_DE') as saldo_inicial"),
                                    'id_cierre',
                                    'id_tienda',
                                    'fecha_inicio'
                                    )
                              ->where('id_tienda', $id)
                              ->orderby('id_cierre','desc')
                              ->first();
            }catch(\Exception $e)
            {
                  dd($e);
            }
      }

      public static function cerrarTienda($id)
      {
            try
            {
                  return \DB::table('tbl_tienda')
                              ->where('id', $id)
                              ->update(['abierto'=>0]);
            }catch(\Exception $e)
            {
                  dd($e);
            }
      }
      public static function registrarAuditoria($dataSaved,$idTienda)
      {
            $result = true;
            try
            {
                  if(\DB::table('tbl_tes_auditoria_arqueo')->insert($dataSaved))
                  {
                        \DB::table('tbl_tienda')->where('id',$idTienda)->update(['abierto' => 1]);
                  }
                  else
                  {
                        $result = false;     
                  }
                                    
            }catch(\Exception $e)
            {
                  $result = false;                  
                  dd($e);
            }
            return $result;
      }

      public static function nuevoCierre($idTienda,$codigoCierre,$saldo)
      {
            $request = true;
            try
            {
                 $CierreCaja = \DB::table('tbl_tes_cierre_caja')
                              ->select(   
                                    'id_cierre',
                                    'id_tienda',
                                    'fecha_inicio', 
                                    'saldo_inicial'
                                    )
                              ->where('id_tienda', $idTienda)
                              ->orderby('fecha_inicio','desc')
                              ->first();
                  \DB::table('tbl_tes_cierre_caja')
                        ->where('id_cierre',$CierreCaja->id_cierre)
                        ->where('id_tienda',$CierreCaja->id_tienda)
                        ->update(['fecha_final' =>Date('Y-m-d H:i:s'),'saldo_final' => $saldo ]);
                  
                  if(\DB::table('tbl_tes_cierre_caja')->insert(['id_cierre'=>$codigoCierre,'id_tienda'=>$idTienda,'fecha_inicio' => Date('Y-m-d H:i:s'), 'saldo_inicial' => $saldo]))
                  \DB::table('tbl_tienda')->where('id',$idTienda)->update(['abierto' => 1]);
                  
            }catch(\Exception $e)
            {
                  $request = false;                  
            }
            return $request;
      }

      public static function getUltimoArqueo($Tienda)
      {
            $request= false;
            try
            {
                  $request= \DB::table('tbl_tes_auditoria_arqueo')
                  ->select('id_arqueo')
                  ->where('id_tienda',$Tienda)
                  ->orderby('id_arqueo','desc')
                  ->first();
            }catch(\Exception $e)
            {
                  $request = false;
            }
            return $request;
      }
}