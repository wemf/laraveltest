<?php 

namespace App\BusinessLogic\Nutibara\Excel\MovimientosContables;

use Excel;

class MovimientosContablesExcel
{
    protected $MovimientosContablesExcel;

	public function __construct()
	{
		$this->MovimientosContablesExcel = array(
			array(
				'Código Cierre',
				'Código Tienda',
				'Código Movimiento',
				'Fecha Creación Documento',
                'Tipo Documento',
                'Número Cuenta',
                'Descripción Documento',
                'Valor Débito',
				'Valor Crédito',
				//'Fecha Inicio Cierre',
				//'Fecha Fina Cierre',
				//'Nombre Documento Log',
				//'Fecha Log',
				//'Ubicación Documento Log'
			)
		);
	}


	public function ExportExcel($dataGet)
	{
		$limitDataGet = count($dataGet);
        for($i = 0; $i < $limitDataGet; $i++){
            $dataTemp=array(
				$dataGet[$i]->id_cierre,
				$dataGet[$i]->id_tienda,
				$dataGet[$i]->codigo_movimiento,
				$dataGet[$i]->fecha,
                $dataGet[$i]->tipo_documento,
                $dataGet[$i]->cuenta,
                $dataGet[$i]->descripcion,
                $dataGet[$i]->debito,
                $dataGet[$i]->credito,
			);
			array_push($this->MovimientosContablesExcel,$dataTemp);
        }
		return $this->Download();
	}

	public function Download()
	{
		$MovimientosContablesExcel=$this->MovimientosContablesExcel;
		Excel::create('Movimientos Contables', function($excel) use($MovimientosContablesExcel){
			//Cargando los datos Empleado
			$excel->sheet('Valores', function($sheet) use($MovimientosContablesExcel){
				$sheet->fromArray($MovimientosContablesExcel, null, 'A0', true);
				//Negrilla la primera fila
				//$sheet->cells('A1:N1', function($cells){
				$sheet->cells('A1:I1', function($cells){
					$cells->setFontSize(14);
					$cells->setAlignment('center');
					$cells->setFontColor('#73879C');
					$cells->setFontWeight('bold');
					$cells->setBackground('#EDEDED');
				});
            });
		})->export('xls');
	}
}