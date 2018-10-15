<?php 
namespace App\BusinessLogic\Nutibara\Excel\Resolucion;
use Excel;



class StikersExcel 
{
    protected $dataResolucion;
    protected $process;

	public function __construct($process)
	{
		$this->dataResolucion = array(
			array(
				'NOMBRE COMERCIAL',
				'CODIGO DE LA JOYERIA',
				'NUMERO DE CONTRATO',
				'ORDEN DE COMPRA',
				'ORDEN DE TRASLADO',
				'ORDEN DE MAQUILA',
				'CALIDAD (atributo)',
				'ORIGEN (atributo)',
				'ID',
				'GRAMOS'
			),			
        );
        $this->process = $process;
	}

	
	public function generateExcel($dataGet)
	{
        $limitDataGet = count($dataGet);
        for($i = 0; $i < $limitDataGet; $i++){
            $dataTemp=array(
				$dataGet[$i]->nombre_comercial,
				$dataGet[$i]->codigo,
				$dataGet[$i]->numero_contrato,
				$dataGet[$i]->orden_compra,
				$dataGet[$i]->orden_traslado,
				$dataGet[$i]->orden_maquila,
				$dataGet[$i]->calidad,
				$dataGet[$i]->origen,
				$dataGet[$i]->id,
				$dataGet[$i]->gramos,
			);
			array_push($this->dataResolucion,$dataTemp);
        }
		return $this->Download();
	}
	
	public function Download()
	{	
		$dataResolucion=$this->dataResolucion;
		Excel::create('Stikers de '. $this->process, function($excel) use($dataResolucion) {		
			//Cargando los datos Empleado
			$excel->sheet('Archivo', function($sheet) use($dataResolucion) {		
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
			$excel->sheet('Diseno', function ($sheet) use ($dataResolucion) {
				$sheet->loadView('Vitrina.excel')->with('dataResolucion',$dataResolucion);
            	$sheet->setOrientation('landscape');
            });
		})->export('xls');
	}
}