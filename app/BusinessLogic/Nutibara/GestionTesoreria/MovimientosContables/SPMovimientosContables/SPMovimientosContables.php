<?php 

namespace App\BusinessLogic\Nutibara\GestionTesoreria\MovimientosContables\SPMovimientosContables;

use DB;

class SPMovimietnosContables{
    //  Función para llamar el procedimiento almacenado, el cúal recive 2 parametros id_cierre y id_tienda
    public static function spMovimietnosContables($id_cierre, $id_tienda){
        $spMoviContables = DB::select('CALL generar_archivo_contable(?,?)',array($id_cierre,$id_tienda));
        if($spMoviContables == 1){
            return true;
        }else{
            return false;
        }
    }
}