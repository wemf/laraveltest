<?php

namespace App\Http\Controllers\Notificacion;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BusinessLogic\Notificacion\NotificacionBase as NotificacionBL;

class NotificacionController extends Controller
{
    protected $base;

    public function __construct()
    {
        $this->base=new NotificacionBL();
    }
  
    public function index()
    {
        return view('Notificacion.index');
    }

    public function get(Request $request){
    	$start=(int)$request->start;
		$end=$start+(int)$request->length;
		$draw= (int)$request->draw;   
        $colum=$request->columns[(int)$request->order[0]['column']]['data'];    
		$order=$request->order[0]['dir'];
		$search = [];
		$vowels = array("$", "^");
		$search["FechaInicial"] = str_replace($vowels, "", $request->columns[0]['search']['value']);
        $search["FechaFinal"] = str_replace($vowels, "", $request->columns[1]['search']['value']);
		$search["Emisor"] = str_replace($vowels, "", $request->columns[2]['search']['value']);
        $search["SinLeer"] = str_replace($vowels, "", $request->columns[3]['search']['value']);
        $search["EstadoResuelto"] = str_replace($vowels, "", $request->columns[4]['search']['value']);
        $total=$this->base->getCountMensajes();
		$data=[           
			"draw"=> $draw,
			"recordsTotal"=> $total,
			"recordsFiltered"=> $total,
			"data"=>$this->base->Mensajes($start,$end,$colum, $order,$search)
		];   
		return response()->json($data);
    }

    public function GetMensaje(Request $request)
    {
        $mensaje=$this->base->GetMensaje($request->id);
		return response()->json($mensaje);
    }
  
    public function Matricular(Request $request)
    {
        $mensaje=$this->base->Matricular($request);
		return response()->json($mensaje);
    }

    


    
}
