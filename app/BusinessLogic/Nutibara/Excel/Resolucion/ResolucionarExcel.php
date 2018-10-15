<?php 
namespace App\BusinessLogic\Nutibara\Excel\Resolucion;
use Excel;



class ResolucionarExcel 
{
	protected $dataResolucion;

	public function __construct()
	{
		$this->dataResolucion = array(
			array(
				'ID orden',
				'Tienda',
				'Categoría',
				'Código contrato',
				'Fecha de perfeccionamiento',
				'Fecha de contratación',
				'Nro ID',
				'Atributos',
				'Descripción',
				'Peso total',
				'Peso estimado',
				'Valor compra ítem',
				'Valor total contrato',
				'Cantidad',
			),			
		);
	}

	
	public function generateExcel($dataGet)
	{
        $limitDataGet = count($dataGet);
        for($i = 0; $i < $limitDataGet; $i++){
            $dataTemp=array(
				$dataGet[$i]->DT_RowId,
				$dataGet[$i]->tienda_orden,
				$dataGet[$i]->categoria,
				$dataGet[$i]->codigo_contrato,
				$dataGet[$i]->fecha_perfeccionamiento,
				$dataGet[$i]->fecha_contratacion,
				$dataGet[$i]->id_inventario,
				$dataGet[$i]->nombre,
				$dataGet[$i]->observaciones,
				$dataGet[$i]->peso_total,
				$dataGet[$i]->peso_estimado,
				$dataGet[$i]->precio_ingresado,
				$dataGet[$i]->Suma_contrato,
				1,
			);
			array_push($this->dataResolucion,$dataTemp);
        }
		return $this->Download();
	}

	public function Download()
	{	
		$dataResolucion=$this->dataResolucion;
		Excel::create('Orden de perfeccionamiento', function($excel) use($dataResolucion) {		
			//Cargando los datos Empleado
			$excel->sheet('Orden de perfeccionamiento', function($sheet) use($dataResolucion) {		
				$sheet->fromArray($dataResolucion, null, 'A0', true);	
				//Negrilla la primera fila
				$sheet->cells('A1:N1', function($cells) {				
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