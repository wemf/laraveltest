<?php 

namespace App\BusinessLogic\Nutibara\ReporteRotacion;
use App\AccessObject\Nutibara\ReporteRotacion\ReporteRotacionAO as reporteAO;

class ReporteRotacionBL
{
    public static function getTiendaByIp($ip){
		return reporteAO::getTiendaByIp($ip);
    }
    
    public static function get($request)
	{
		$start=(int)$request->start;
		$end=(int)$request->length;
		$draw= (int)$request->draw;
		$colum=$request->columns[(int)$request->order[0]['column']]['data'];
		$order=$request->order[0]['dir'];
		$vowels = array("$", "^");
		$search["id_pais"] = 		($request->columns[0]['search']['value'] != null) ? str_replace($vowels, "", $request->columns[0]['search']['value']) : "null";
		$search["id_departamento"] =($request->columns[1]['search']['value'] != null) ? str_replace($vowels, "", $request->columns[1]['search']['value']) : "null";
		$search["id_ciudad"] = 		($request->columns[2]['search']['value'] != null) ? str_replace($vowels, "", $request->columns[2]['search']['value']) : "null";
		$search["id_sociedad"] = 	($request->columns[3]['search']['value'] != null) ? str_replace($vowels, "", $request->columns[3]['search']['value']) : "null";
		$search["id_zona"] = 		($request->columns[4]['search']['value'] != null) ? str_replace($vowels, "", $request->columns[4]['search']['value']) : "null";
		$search["id_tienda"] = 		($request->columns[5]['search']['value'] != null) ? str_replace($vowels, "", $request->columns[5]['search']['value']) : "null";
		$search["id_categoria"] = 	($request->columns[6]['search']['value'] != null) ? str_replace($vowels, "", $request->columns[6]['search']['value']) : "null";
		$search["referencia"] = 	($request->columns[7]['search']['value'] != null) ? str_replace($vowels, "", $request->columns[7]['search']['value']) : "null";
		$search["fecha_inicio"] = 	($request->columns[8]['search']['value'] != null) ? str_replace($vowels, "", $request->columns[8]['search']['value']) : "null";
		$search["fecha_fin"] = 		($request->columns[9]['search']['value'] != null) ? str_replace($vowels, "", $request->columns[9]['search']['value']) : "null";
		$total=reporteAO::getCount($start, $end, $colum, $order, $search);
		$data=[
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>reporteAO::get($start, $end, $colum, $order, $search)
		];
		return response()->json($data);
	}
}


?>