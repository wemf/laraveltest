<?php

namespace App\AccessObject\Notificacion;
use Illuminate\Support\Facades\Auth;
use App\Models\Notificacion\NotificacionDB;
use DB;
use App\Models\autenticacion\Usuario;

class NotificacionAO 
{	
	public static function getMensajes()
    {
        return NotificacionDB::join('tbl_sys_notificacion_tipo','tbl_sys_notificacion_tipo.id','=','tbl_sys_notificacion.id_tipo_notificacion')
                             ->join('tbl_usuario','tbl_usuario.id','=','tbl_sys_notificacion.id_usuario_emisor')
                             ->select(
                                'tbl_sys_notificacion.id',
                                'tbl_sys_notificacion.id_grupo_notificacion',
                                'tbl_sys_notificacion.id_usuario_receptor',
                                'tbl_sys_notificacion.id_usuario_emisor',
                                'tbl_sys_notificacion.id_tipo_notificacion',
                                'tbl_sys_notificacion.estado_visto',
                                'tbl_sys_notificacion.estado_notificacion',
                                 DB::raw("DATE_FORMAT(Fecha, '%Y-%m-%d') as Fecha"),
                                'tbl_sys_notificacion.mensaje',
                                'tbl_usuario.name AS Nombre_Usurio_Emisor',
                                'tbl_sys_notificacion_tipo.tipo',
                                'tbl_sys_notificacion.accion'
                             )
							 ->where('tbl_sys_notificacion.id_usuario_receptor',Auth::id())
							 ->where('tbl_sys_notificacion.estado_visto',0)
                             ->limit(5)
                             ->orderBy('tbl_sys_notificacion.id','desc')
                             ->get();
    }
    
    public static function MensajesWhere($colum, $order,$search){
		return NotificacionDB::join('tbl_sys_notificacion_tipo','tbl_sys_notificacion_tipo.id','=','tbl_sys_notificacion.id_tipo_notificacion')
                        ->join('tbl_usuario','tbl_usuario.id','=','tbl_sys_notificacion.id_usuario_emisor')
                        ->select(
                            'tbl_sys_notificacion.id AS DT_RowId',
                            'tbl_sys_notificacion.mensaje',
                            DB::raw("IF(tbl_sys_notificacion.estado_notificacion = 1, 'Resuelto', 'Pendiente') AS estado_notificacion"),
                            'tbl_usuario.name AS Nombre_Usurio_Emisor',
                            DB::raw("DATE_FORMAT(tbl_sys_notificacion.fecha, '%Y-%m-%d %H:%i:%s') as Fecha"),
                            DB::raw("IF(tbl_sys_notificacion.estado_visto = 1, 'Visto', 'Sin leer') AS estado_visto")
                        )
                        ->where('tbl_sys_notificacion.id_usuario_receptor',Auth::id())
                        ->where(function ($query) use ($search){
                            if(!empty($search['FechaInicial']) && !empty($search['FechaFinal'])){
                                $query->whereBetween('tbl_sys_notificacion.fecha', [$search['FechaInicial'], $search['FechaFinal']]);
                            }else if(!empty($search['FechaInicial']) && empty($search['FechaFinal'])){
                                $query->where('tbl_sys_notificacion.fecha',$search['FechaInicial']);
                            }else if(empty($search['FechaInicial']) && !empty($search['FechaFinal'])){
                                $query->where('tbl_sys_notificacion.fecha', $search['FechaFinal']);
                            }
                            if(!empty($search['EstadoResuelto'])){
                                $query->where('tbl_sys_notificacion.estado_notificacion', 1);
                            }
                            $query->where('tbl_usuario.name','like', "%".$search['Emisor']."%");
                            if(!empty($search['SinLeer'])){
                                $query->where('tbl_sys_notificacion.estado_visto',0);
                            }
                        })								
                        ->orderBy($colum, $order)
                        ->get();
	}

	public static function Mensajes($start,$end,$colum,$order){
		return NotificacionDB::join('tbl_sys_notificacion_tipo','tbl_sys_notificacion_tipo.id','=','tbl_sys_notificacion.id_tipo_notificacion')
                        ->join('tbl_usuario','tbl_usuario.id','=','tbl_sys_notificacion.id_usuario_emisor')
                        ->select(
                            'tbl_sys_notificacion.id AS DT_RowId',
                            'tbl_sys_notificacion.mensaje',
                            DB::raw("IF(tbl_sys_notificacion.estado_notificacion = 1, 'Resuelto', 'Pendiente') AS estado_notificacion"),
                            'tbl_usuario.name AS Nombre_Usurio_Emisor',
                            DB::raw("DATE_FORMAT(tbl_sys_notificacion.fecha, '%Y-%m-%d %H:%i:%s') as Fecha"),
                            DB::raw("IF(tbl_sys_notificacion.estado_visto = 1, 'Visto', 'Sin leer') AS estado_visto")
                        )
                        ->where('tbl_sys_notificacion.id_usuario_receptor',Auth::id())
                        ->skip($start)->take($end)									
                        ->orderBy($colum, $order)
                        ->get();
    }
    
    public static function GetAdministradorTienda($idTienda)
    {
        return Usuario::join('tbl_cliente','tbl_cliente.id_usuario','=','tbl_usuario.id')
                        ->join('tbl_clie_tienda', function ($join) {
                            $join->on('tbl_clie_tienda.codigo_cliente', '=' ,'tbl_cliente.codigo_cliente' )
                                ->on('tbl_clie_tienda.id_tienda_cliente', '=' ,'tbl_cliente.id_tienda' );
                        })
                      ->select(
                          'tbl_usuario.id',
                           DB::raw("CONCAT(tbl_cliente.nombres, ' ',tbl_cliente.primer_apellido,' ',tbl_cliente.segundo_apellido) as nombre"),
                           'tbl_usuario.email'
                        )
                        ->whereRaw('tbl_cliente.id_tienda ='.$idTienda.' OR tbl_clie_tienda.id_tienda = '.$idTienda)
                        ->where('tbl_usuario.id_role', 45)//Jefe de Zona tabla tbl_usuario_role
                        ->get();
    }

	public static function getCountMensajes(){
		return NotificacionDB::where('tbl_sys_notificacion.id_usuario_receptor',Auth::id())->count();
    }

    public static function GetMensaje($id){
		return NotificacionDB::where('id',$id)->first();
    }
    
    public static function EstadoVistoOn($id){
        $estadoVisto=NotificacionDB::where('id',$id)->where('estado_visto',1)->count();
        if($estadoVisto){
            return true;
        }else{
		    return NotificacionDB::where('id',$id)->update(['estado_visto'=>1]);        
        }
	}
	
    public static function Matricular($request)
    {
        return NotificacionDB::insert($request);
    }

    public static function GetJefeZona($idTienda)
    {
        $zona = \DB::table('tbl_tienda')
        ->select('tbl_tienda.id_zona')
        ->where('tbl_tienda.id',$idTienda)
        ->first();
        return Usuario::join('tbl_cliente','tbl_cliente.id_usuario','=','tbl_usuario.id')
                        ->join('tbl_clie_empleado', function ($join) {
                            $join->on('tbl_clie_empleado.codigo_cliente', '=' ,'tbl_cliente.codigo_cliente' )
                                ->on('tbl_clie_empleado.id_tienda', '=' ,'tbl_cliente.id_tienda' );
                        })
                      ->select(
                          'tbl_usuario.id',
                           DB::raw("CONCAT(tbl_cliente.nombres, ' ',tbl_cliente.primer_apellido,' ',tbl_cliente.segundo_apellido) as nombre"),
                           'tbl_usuario.email'
                        )
                        ->where('id_zona_encargado',$zona->id_zona)
                        ->where('tbl_usuario.id_role',env('ROL_JESE_ZONA'))//Jefe de Zona tabla tbl_usuario_role
                        ->get();
    }

    public static function GetTesorero()
    {
        return Usuario::leftjoin('tbl_cliente','tbl_cliente.id_usuario','=','tbl_usuario.id')
                      ->select(
                          'tbl_usuario.id',
                           DB::raw("CONCAT(tbl_cliente.nombres, ' ',tbl_cliente.primer_apellido,' ',tbl_cliente.segundo_apellido) as nombre"),
                           'tbl_usuario.email'
                        )
                        ->whereIn('tbl_usuario.id_role',[env('ROL_TESORERIA'),env('ROLE_SUPER_ADMIN')])//Tesorero tabla tbl_usuario_role
                        ->get();
    }

    public static function GetAdministradordeTienda($idTienda)
    {
        return Usuario::join('tbl_cliente','tbl_cliente.id_usuario','=','tbl_usuario.id')
                      ->select(
                          'tbl_usuario.id',
                           DB::raw("CONCAT(tbl_cliente.nombres, ' ',tbl_cliente.primer_apellido,' ',tbl_cliente.segundo_apellido) as nombre"),
                           'tbl_usuario.email'
                        )
                        ->where('tbl_usuario.id_role',env('ROL_ADMINISTRADOR_JOYERIA'))//Tesorero tabla tbl_usuario_role
                        ->where('tbl_cliente.id_tienda',$idTienda)
                        ->get();
    }

    public static function GetAdminBodega($idTienda)
    {
        return Usuario::join('tbl_cliente','tbl_cliente.id_usuario','=','tbl_usuario.id')
                      ->select(
                          'tbl_usuario.id',
                           DB::raw("CONCAT(tbl_cliente.nombres, ' ',tbl_cliente.primer_apellido,' ',tbl_cliente.segundo_apellido) as nombre"),
                           'tbl_usuario.email'
                        )
                      ->where('tbl_cliente.id_tienda',$idTienda)
                      ->where('tbl_usuario.id_role',env('ROL_ADMIN_BOD'))//Jefe de Zona tabla tbl_usuario_role
                      ->get();
    }

    public static function GetAdminTienda($idTienda)
    {
        return Usuario::join('tbl_cliente','tbl_cliente.id_usuario','=','tbl_usuario.id')
                      ->select(
                          'tbl_usuario.id',
                           DB::raw("CONCAT(tbl_cliente.nombres, ' ',tbl_cliente.primer_apellido,' ',tbl_cliente.segundo_apellido) as nombre"),
                           'tbl_usuario.email'
                        )
                      ->where('tbl_cliente.id_tienda',$idTienda)
                      ->whereIn('tbl_usuario.id_role',[env('ROL_AUXILIAR_TIENDA'),env('ROL_JESE_ZONA')])
                      ->get();
    }

}
