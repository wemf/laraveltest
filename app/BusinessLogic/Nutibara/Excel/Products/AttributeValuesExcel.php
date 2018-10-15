<?php 
namespace App\BusinessLogic\Nutibara\Excel\Products;
use Excel;
use App\AccessObject\Nutibara\GestionHumana\Empleado\Reporte AS ReporteAccess;



class AttributeValuesExcel 
{
	protected $dataAttributeValues;

	public function __construct()
	{
		$this->dataAttributeValues = array(
			array(
				'Categoría',
				'Atributo',
				'Valor padre',				
				'Valor',		
				'Activo',
			),			
		);
	}

	
	public function ExportExcel($dataGet)
	{
        $limitDataGet = count($dataGet);
        for($i = 0; $i < $limitDataGet; $i++){
            $dataTemp=array(
				$dataGet[$i]->categoria,
				$dataGet[$i]->atributo,
				$dataGet[$i]->valorpadre,
				$dataGet[$i]->nombre,
				$dataGet[$i]->estado,
			);
			array_push($this->dataAttributeValues,$dataTemp);
        }
		return $this->Download();
	}

	public function Download()
	{	
		$dataAttributeValues=$this->dataAttributeValues;
		Excel::create('Valores de Atributos', function($excel) use($dataAttributeValues) {		
			//Cargando los datos Empleado
			$excel->sheet('Valores', function($sheet) use($dataAttributeValues) {		
				$sheet->fromArray($dataAttributeValues, null, 'A0', true);	
				//Negrilla la primera fila
				$sheet->cells('A1:E1', function($cells) {				
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