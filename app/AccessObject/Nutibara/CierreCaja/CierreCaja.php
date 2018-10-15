<?php 
 
namespace App\AccessObject\Nutibara\CierreCaja;


class CierreCaja 
{
	public static function getMonedas($pais)
	{
            
		try
		{
            return \DB::table('tbl_sys_denominacion_moneda')
                            ->select('tbl_sys_denominacion_moneda.denominacion',
                                         'tbl_sys_denominacion_moneda.valor'
                            )
                            ->where('tbl_sys_denominacion_moneda.id_pais',$pais->id)
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
                              ->select('fecha_inicio',
                                           'saldo_inicial'
                              )
                              ->where('id_tienda', $id)
                              ->orderby('fecha_final')
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
      public static function registrarAuditoria($dataSaved)
      {
            try
            {
                  return \DB::table('tbl_tes_auditoria_CierreCaja')
                                    ->insert($dataSaved);
            }catch(\Exception $e)
            {
                  dd($e);
            }
      }

      public static function getinfoCierreCaja($id_cierre,$id_tienda)
      {
            try
            {
                  $cierreCaja = \DB::select('CALL sp_s_cierre_caja_informe(?,?)',array($id_cierre,$id_tienda));
                  $DetalleCierreCaja;
                  for ($i=0; $i < count($cierreCaja) ; $i++) 
                  {
                        if($cierreCaja[$i]->id_clases != null)
                        {
                              $DetalleCierreCaja[$cierreCaja[$i]->id_clases.'/'.$cierreCaja[$i]->id_concepto] = $cierreCaja[$i]->valor;
                        }
                  }
                  return $DetalleCierreCaja;
            }catch(\Exception $e)
            {
                  dd($e);
            }
      }
}