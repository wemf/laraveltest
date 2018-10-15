<?php 

namespace App\BusinessLogic\Nutibara\Excel\PlanUnicoCuenta;
use App\BusinessLogic\Nutibara\Clientes\PlanUnicoCuenta\CrudPlanUnicoCuenta;
use Excel;
class PlanUnicoCuentaExcel

{
    protected $PlanUnicoCuentaExcel;
	
	public function __construct()
	{
        $this->PlanUnicoCuentaExcel = array(
			array(
					'Id',
					'Cuenta',
					'Nombre',
					'Naturaleza'
				)
		);
	}


	public function ExportExcel()
	{
		$data=CrudPlanUnicoCuenta::PlanUnicoCuentaExcel();
		$limitDataGet = count($data);
		for($i = 0; $i < $limitDataGet; $i++)
		{
            $dataTemp=array(
				$data[$i]->id,
				$data[$i]->cuenta,
				$data[$i]->nombre,
				$data[$i]->naturaleza
			);
				array_push($this->PlanUnicoCuentaExcel,$dataTemp);
		}
		return $this->Download();		
	}

	private function Download()
	{
		$PlanUnicoCuentaExcel=$this->PlanUnicoCuentaExcel;
		Excel::create('PUC', function($excel) use($PlanUnicoCuentaExcel){
			//Cargando los datos Empleado
			$excel->sheet('Valores', function($sheet) use($PlanUnicoCuentaExcel){
				$sheet->fromArray($PlanUnicoCuentaExcel, null, 'A0', true);
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