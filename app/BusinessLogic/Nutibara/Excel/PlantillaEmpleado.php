<?php 
namespace App\BusinessLogic\Nutibara\Excel;
use Excel;
use App\AccessObject\Nutibara\GestionHumana\Empleado\Reporte AS ReporteAccess;



class PlantillaEmpleado 
{
	protected $informacion_general;
	protected $localizacion_tienda;
	protected $informacion_contractual;
	protected $familiares_en_nutibara;
	protected $grupo_familiar;
	protected $contacto_emergencia;
	protected $informacion_academica;
	protected $dias_estudio;
	protected $informacion_laboral;
	protected $novedad_empleado;
	// filtros viejos
	protected $dataHijo;
	protected $dataPersonasCargo;
	protected $dataLabNutibara;

	private $tipo_documento;
	private $numero_documento;
	
	public function __construct()
	{
		$this->tipo_documento="null";
		$this->numero_documento="null";
		$this->informacion_general = array(
			array(
				'Tipo Documento Empleado',
				'Número Documento Empleado',
				'Fecha Expedición',
				'País de Expedición',
				'Departamento de Expedición',
				'Ciudad de Expedición',
				'Nombre Completo',
				'Apellidos',
				'Género',
				'Fecha de Nacimiento',
				'País de Nacimiento',
				'Departamento de Nacimiento',
				'Ciudad de Nacimiento',
				'País de Residencia',
				'Departamento de Residencia',
				'Ciudad de Residencia',
				'Dirección Residencia',
				'Barrio Residencia',
				'Teléfono Residencia',
				'Teléfono Celular',
				'Grupo Sanguíneo',
				'Estado Civil',
				'Correo Electrónico',
				'Libreta Militar',
				'Distrito Militar',
				'Tipo de Vivienda',
				'Tenencia Vivienda',
				'Talla Camisa',
				'Talla Pantalón',
				'Talla Zapatos'
			),			
		);
		$this->localizacion_tienda = array (
			array(
				'Tipo Documento',
				'Número de Documento',
				'Tipo Empleado',
				'Nombre Comercial',
				'Sociedad',
				'Tienda',
				'Cargo',
				'País en donde desempeña',
				'Departamento en donde desempeña',
				'Ciudad en donde desempeña'
			),
		);
		$this->informacion_contractual = array(
			array(
				'Tipo Documento',
				'Número Documento',
				'Tipo Contrato',
				'Fecha Ingreso',
				'Salario',
				'Valor auxilio vivienda',
				'Valor auxilio transporte',
				'Fondo de Cesantías',
				'Fondo de Pensiones',
				'EPS',
				'Caja de compensación familiar'
			),
		);
		$this->familiares_en_nutibara = array(
			array(
				'Tipo Documento Empleado',
				'Número Documento Empleado',
				'Tipo de Documento Familiar',
				'Número de Documento Familiar',
				'Nombres Familiar',
				'Fecha de Nacimiento Familiar',
				'Parentesco Familiar',
				'Cargo Actual Familiar',
				'Ciudad donde labora Familiar'
			),
		);
		$this->grupo_familiar = array(
			array(
				'Tipo Documento Empleado',
				'Número Documento Empleado',
				'Tipo de Documento Familiar',
				'Número de Documento Familiar',
				'Nombre Completo',
				'Parentesco',
				'Fecha de Nacimiento',
				'Género',
				'Beneficiario(Eps)',
				'Ocupación Actual',
				'Grado de Escolaridad',
				'studio Actual',
				'Año o semestre que cursa',
				'A cargo de esta persona',
				'Vive con esta persona'
			),
		);
		$this->contacto_emergencia = array(
			array(
				'Tipo Documento Empleado',
				'Número Documento Empleado',
				'Tipo de Documento Familiar',
				'Número de Documento Familiar',
				'Nombres',
				'Primer Apellido',
				'Segundo Apellido',
				'Parentesco',
				'Dirección',
				'Ciudad',
				'Teléfono'
			),
		);
		$this->informacion_academica = array(
			array(
				'Tipo Documento Empleado',
				'Número Documento Empleado',
				'Nombre Estudio',
				'Años Cursados',
				'Fecha Inicio',
				'Fecha Terminación',
				'Institución',
				'Título Obtenido',
				'Estado'
			),
		);
		$this->dias_estudio = array(
			array(
				'Tipo Documento Empleado',
				'Número Documento Empleado',
				'Lunes',
				'Martes',
				'Miércoles',
				'Jueves',
				'Viernes',
				'Sábado',
				'Domingo'
			),
		);
		$this->informacion_laboral = array(
			array(
				'Tipo Documento Empleado',
				'Número Documento Empleado',
				'Empresa',	
				'Cargo',
				'Nombre Jefe Inmediato',
				'Fecha Ingreso',
				'Fecha Retiro',
				'Personas a Cargo',
				'Último Salario Devengado',
				'Horario de Trabajo',
				'Tipo de Contrato'
			),
		);
		$this->novedad_empleado = array(
			array(
				'Tipo Documento Empleado',
				'Número Documento Empleado',
				'Fecha de retiro',
				'Motivo de retiro',
				'Observaciones',
			),
		);
		// filtros viejos 
		$this->dataHijo=array(
			array(
				'Tipo Documento Empleado',
				'Número Documento Empleado',
				'Nombres y Apellidos del empleado',	
				'Nombres y Apellidos del hijo',
				'Fecha de nacimiento del hijo',
				'Ciudad del hijo'		
			),
		);
		$this->dataPersonasCargo=array(
			array(
				'Tipo Documento Empleado',
				'Número Documento Empleado',
				'Nombres y Apellidos del empleado',
				'Nombres y Apellidos de la persona',
				'Fecha de nacimiento de la persona',
				'Ciudad de nacimiento de la persona',
				'Parentesco'					
			),
		);
		$this->dataLabNutibara=array(
			array(
				'Tipo Documento Empleado',
				'Número Documento Empleado',
				'Nombres y Apellidos del empleado',
				'Nombres y Apellidos de la persona',
				'Fecha de nacimiento de la persona',
				'Ciudad de la persona',
				'Parentesco'
			)
		);
	}

	
	public function ExportExcel($dataGet)
	{	
		$data=$this->GenerateReport($dataGet);

		foreach ($data['info'] as $key => $db) {
			if($key===0){
				$tipo_documento=$db->tipo_documento;
				$numero_documento=$db->cedula;
			}
			//Pestaña Información Generales			
			$dataTemp=array(
				$db->tipo_documento,
				$db->cedula,
				$db->fecha_expedicion,
				$db->nombre_pais_expedicion,
				$db->departamento_expedicion,
				$db->ciudad_expedicion,
				$db->nombres,
				$db->apellidos,
				$db->genero,
				$db->fechaNacimiento,
				$db->pais_nacimiento,
				$db->departamento_nacimiento,
				$db->ciudad_nacimiento,
				$db->pais_residencia,
				$db->departamento_residencia,
				$db->ciudad_residencia,
				$db->direccion_residencia,
				$db->barrio_residencia,
				$db->telefono_residencia,
				$db->celular,
				$db->grupo_sanguineo,
				$db->estado_civil,
				$db->correo,
				$db->libreta_militar,
				$db->distrito_militar,
				$db->tipo_vivienda,
				$db->nombre_Vivienda,
				$db->talla_camisa,
				$db->talla_pantalon,
				$db->talla_zapatos
			);
			array_push($this->informacion_general,$dataTemp);
			// pestaña localización tienda
			$dataTemp=array(
				$db->tipo_documento,
				$db->cedula,
				$db->tipo_cliente,
				$db->nombre_comercial,
				$db->sociedad,
				$db->nombre_tienda,
				$db->cargo,
				$db->pais_residencia,
				$db->departamento_residencia,
				$db->ciudad_trabajo,
			);
			array_push($this->localizacion_tienda,$dataTemp);
			// pestaña informacion contractual
			$dataTemp=array(
				$db->tipo_documento,
				$db->cedula,
				$db->tipo_contrato,
				$db->fecha_ingreso,
				$db->salario,
				$db->valor_auxilio_vivenda,
				$db->auxilio_transporte,
				$db->fondo_cesantias,
				$db->fondo_pensiones,
				$db->eps,
				$db->caja_compensacion,
			);
			array_push($this->informacion_contractual,$dataTemp);
			// pestaña familiares en nutibara
			// grupo_familiar;
			// contacto_emergencia;

			// pestaña informacion academica - 1 cursando - 2 suspendido - 3 finalizado
			$search  = array('1', '2', '3');
			$replace = array('Cursando', 'Suspendido', 'Finalizado');
			$estado= str_replace($search, $replace, (string)$db->finalizado);
			$dataTemp=array(
				$db->tipo_documento,
				$db->cedula,
				$db->nombre,
				$db->años_cursados,
				$db->fecha_inicio,
				$db->fecha_terminacion,
				$db->institucion,
				$db->titulo_obtenido,
				$estado
			);
			array_push($this->informacion_academica,$dataTemp);
			// pestaña dias estudio
			$dataTemp=array(
				$db->tipo_documento,
				$db->cedula,
				$db->lunes,
				$db->martes,
				$db->miercoles,
				$db->jueves,
				$db->viernes,
				$db->sabado,
				$db->domingo,
			);
			array_push($this->dias_estudio,$dataTemp);
			// pestaña informacion_laboral
			$dataTemp=array(
				$db->tipo_documento,
				$db->cedula,
				$db->Empresa_anterior,
				$db->Cargo_anterior,
				$db->jefe_anterior,
				$db->fecha_ingreso_empleo_anetrior,
				$db->fecha_retiro_empleo_anetrior,
				$db->personas_a_cargo_empleo_anterior,
				$db->ultimo_salario,
				$db->horario_trabajo_anterior,
				$db->tipo_contrato_anterior,
			);
			array_push($this->informacion_laboral,$dataTemp);
			// novedad_empleado;
			$dataTemp=array(
				$db->tipo_documento,
				$db->cedula,
				$db->fecha_retiro,
				$db->motivo_retiro,
				$db->observaciones,
			);
			array_push($this->novedad_empleado,$dataTemp);
		}
		if(isset($data['children']) && count($data['children'])>0){
			foreach ($data['children'] as $key => $db) {
				$dataTemp=array(
					$tipo_documento,
					$numero_documento,
					$data['children'][$key]["name_employee"].' '.$data['children'][$key]["last_name_employee"],	
					$data['children'][$key]["name_son"].' '.$data['children'][$key]["last_name_son"],
					$data['children'][$key]["fecha_nacimiento"],
					$data['children'][$key]["ciudad"]
				);
				array_push($this->dataHijo,$dataTemp);
			}
		}
		if(isset($data['dependents']) && count($data['dependents'])>0){
			foreach ($data['dependents'] as $key => $db) {
				$dataTemp=array(
					$tipo_documento,
					$numero_documento,
					$data['dependents'][$key]["name_employee"].' '.$data['dependents'][$key]["last_name_employee"],
					$data['dependents'][$key]["name_dependents"]. ' '.$data['dependents'][$key]["last_name_dependents"],
					$data['dependents'][$key]["fecha_nacimiento"],
					$data['dependents'][$key]["ciudad"],
					$data['dependents'][$key]["parentesco"]
				);
				array_push($this->dataPersonasCargo,$dataTemp);
			}
		}
		if(isset($data['nutyFamily']) && count($data['nutyFamily'])>0){			
			foreach ($data['nutyFamily'] as $key => $db) {
				$dataTemp=array(
					$tipo_documento,
					$numero_documento,
					$data['nutyFamily'][$key]["name_employee"].' '.$data['nutyFamily'][$key]["last_name_employee"],
					$data['nutyFamily'][$key]["name_nutyFamily"].' '.$data['nutyFamily'][$key]["last_name_nutyFamily"],
					$data['nutyFamily'][$key]["fecha_nacimiento"],
					$data['nutyFamily'][$key]["ciudad"],
					$data['nutyFamily'][$key]["parentesco"]
				);
				array_push($this->dataLabNutibara,$dataTemp);
			}
		}
		return $this->Download();
	}

	public function GenerateReport($dataGet)
	{
		$dataQuery = $dataGet;		
        $retorno = [];
        //Comparar fechas contra las edades, auxilio de transporte
        if($dataGet['nulo'] == 2){
			$info= ReporteAccess::getAll();
			$retorno['info']=$info;
			if ($dataGet['infoDetalladaHijos'] == 'Si'){
				$temp= ReporteAccess::getInfoChildren(null,null,null,null,true);
				if(count($temp)>0)
					$retorno['children']=$temp->toArray();
			}
			if ($dataGet['infoDetalladaPersonasCargo'] == 'Si'){
				$temp= $retorno['dependents']= ReporteAccess::getInfoDependents(null,null,null,null,true);
				if(count($temp)>0)
					$retorno['dependents']=$temp->toArray();
			}
			if ($dataGet['infoDetalladaFamiliaEmpresa'] == 'Si'){
				$temp= $retorno['nutyFamily']= ReporteAccess::getInfoNutiFamily(null,null,null,null,true);
				if(count($temp)>0)
					$retorno['nutyFamily']=$temp->toArray();
			}
        }else{
			$info = ReporteAccess::getAllFull($dataQuery);
			$retorno['info']=$info;
			for ($i=0;$i<count($info);$i++){
				$id_tienda=$info[$i]->id_tienda;
				$id_cliente=$info[$i]->id_cliente;
				$name_employee=$info[$i]->nombres;
				$last_name_employee=$info[$i]->apellidos;
				if ($dataGet['infoDetalladaHijos'] == 'Si'){
					$temp= ReporteAccess::getInfoChildren($id_tienda,$id_cliente,$name_employee,$last_name_employee);
					if(count($temp)>0)
						$retorno['children'][$i]=$temp->toArray()[0];
					else
						unset($retorno['children'][$i]);
				}
				if ($dataGet['infoDetalladaPersonasCargo'] == 'Si'){
					$temp= $retorno['dependents'][$i]= ReporteAccess::getInfoDependents($id_tienda,$id_cliente,$name_employee,$last_name_employee);
					if(count($temp)>0)
						$retorno['dependents'][$i]=$temp->toArray()[0];
					else
						unset($retorno['dependents'][$i]);
				}
				if ($dataGet['infoDetalladaFamiliaEmpresa'] == 'Si'){
					$temp= $retorno['nutyFamily'][$i]= ReporteAccess::getInfoNutiFamily($id_tienda,$id_cliente,$name_employee,$last_name_employee);
					if(count($temp)>0)
						$retorno['nutyFamily'][$i]=$temp->toArray()[0];
					else
						unset($retorno['nutyFamily'][$i]);	
				}
			}
		}
		return $retorno;		
	}
 
	public function Download()
	{
		$informacion_general = $this->informacion_general;
		$localizacion_tienda = $this->localizacion_tienda;
		$informacion_contractual = $this->informacion_contractual;
		$familiares_en_nutibara = $this->familiares_en_nutibara;
		$grupo_familiar = $this->grupo_familiar;
		$contacto_emergencia = $this->contacto_emergencia;
		$informacion_academica = $this->informacion_academica;
		$dias_estudio = $this->dias_estudio;
		$informacion_laboral = $this->informacion_laboral;
		$novedad_empleado = $this->novedad_empleado;
		// FILTROS VIEJOS
		$dataHijo=$this->dataHijo;
		$dataPersonasCargo=$this->dataPersonasCargo;
		$dataLabNutibara=$this->dataLabNutibara;
		
		Excel::create('Reporte de empleados', function($excel) use($informacion_general,$localizacion_tienda,$informacion_contractual,$familiares_en_nutibara,$grupo_familiar,$contacto_emergencia,$informacion_academica,$dias_estudio,$informacion_laboral,$novedad_empleado,$dataHijo,$dataPersonasCargo,$dataLabNutibara)
		{
			//Cargando los datos del Empleado
			$excel->sheet('Información General', function($sheet) use($informacion_general){
				$sheet->fromArray($informacion_general, null, 'A0', true);
				//Negrilla la primera fila
				$sheet->cells('A1:AD1', function($cells){
					$cells->setFontSize(14);
					$cells->setAlignment('center');
					$cells->setFontColor('#73879C');
					$cells->setFontWeight('bold');
					$cells->setBackground('#EDEDED');
				});
			});
			
			//Cargando la localización de la tienda
			$excel->sheet('Localización Tienda', function($sheet) use($localizacion_tienda){
				$sheet->fromArray($localizacion_tienda, null, 'A0', true);
				//Negrilla la primera fila
				$sheet->cells('A1:J1', function($cells){
					$cells->setFontSize(14);
					$cells->setAlignment('center');
					$cells->setFontColor('#73879C');
					$cells->setFontWeight('bold');
					$cells->setBackground('#EDEDED');
				});
			});
			
			//Cargando la Información contractual
			$excel->sheet('Información contractual', function($sheet) use($informacion_contractual){
				$sheet->fromArray($informacion_contractual, null, 'A0', true);
				//Negrilla la primera fila
				$sheet->cells('A1:K1', function($cells){
					$cells->setFontSize(14);
					$cells->setAlignment('center');
					$cells->setFontColor('#73879C');
					$cells->setFontWeight('bold');
					$cells->setBackground('#EDEDED');
				});
			});

			//Cargando la Información de los familiares que laboran en Nutibara
			//$excel->sheet('Laboran en Nutibara', function($sheet) use($familiares_en_nutibara){
				//$sheet->fromArray($familiares_en_nutibara, null, 'A0', true);
				//Negrilla la primera fila
				//$sheet->cells('A1:I1', function($cells) {
					//$cells->setFontSize(14);
					//$cells->setAlignment('center');
					//$cells->setFontColor('#73879C');
					//$cells->setFontWeight('bold');
					//$cells->setBackground('#EDEDED');
				//});
			//});
			
			// Cargando la información del grupo familiar
			//$excel->sheet('Grupo Familiar', function($sheet) use($grupo_familiar){
				//$sheet->fromArray($grupo_familiar, null, 'A0', true);
				//Negrilla la primera fila
				//$sheet->cells('A1:O1', function($cells){
					//$cells->setFontSize(14);
					//$cells->setAlignment('center');
					//$cells->setFontColor('#73879C');
					//$cells->setFontWeight('bold');
					//$cells->setBackground('#EDEDED');
				//});
			//});
			
			//Cargando la información del contacto de emergencía
			//$excel->sheet('Contacto Emergencía', function($sheet) use($contacto_emergencia){
				//$sheet->fromArray($contacto_emergencia, null, 'A0', true);
				//Negrilla la primera fila
				//$sheet->cells('A1:K1', function($cells){
					//$cells->setFontSize(14);
					//$cells->setAlignment('center');
					//$cells->setFontColor('#73879C');
					//$cells->setFontWeight('bold');
					//$cells->setBackground('#EDEDED');
				//});
			//});
			
			// Cargando la información académica
			$excel->sheet('Información Académica', function($sheet) use($informacion_academica){
				$sheet->fromArray($informacion_academica, null, 'A0', true);
				//Negrilla la primera fila
				$sheet->cells('A1:I1', function($cells){
					$cells->setFontSize(14);
					$cells->setAlignment('center');
					$cells->setFontColor('#73789C');
					$cells->setFontWeight('bold');
					$cells->setBackground('#EDEDED');
				});
			});
			
			//Cargando la información de los días de estudio
			$excel->sheet('Días Estudio', function($sheet) use($dias_estudio){
				$sheet->fromArray($dias_estudio, null, 'A0', true);
				//Negrilla la primera fila
				$sheet->cells('A1:I1', function($cells){
					$cells->setFontSize(14);
					$cells->setAlignment('center');
					$cells->setFontColor('#73789C');
					$cells->setFontWeight('bold');
					$cells->setBackground('#EDEDED');
				});
			});
			
			//Cargando la información laboral
			$excel->sheet('Información Laboral', function($sheet) use($informacion_laboral){
				$sheet->fromArray($informacion_laboral, null, 'A0', true);
				//Negrilla la primera fila
				$sheet->cells('A1:K1', function($cells){
					$cells->setFontSize(14);
					$cells->setAlignment('center');
					$cells->setFontColor('#73789C');
					$cells->setFontWeight('bold');
					$cells->setBackground('#EDEDED');
				});
			});
			
			//Cargando la novedad del empleado
			$excel->sheet('Novedad Empleado', function($sheet) use($novedad_empleado){
				$sheet->fromArray($novedad_empleado, null, 'A0', true);
				//Negrilla la primera fila
				$sheet->cells('A1:E1', function($cells){
					$cells->setFontSize(14);
					$cells->setAlignment('center');
					$cells->setFontColor('#73789C');
					$cells->setFontWeight('bold');
					$cells->setBackground('#EDEDED');
				});
			});

			// FILTROS VIEJOS
						//Cargando los datos Información detallado de los hijos
						$excel->sheet('Detalles Hijos', function($sheet) use($dataHijo) {		
							$sheet->fromArray($dataHijo, null, 'A0', true);	
							//Negrilla la primera fila
							$sheet->cells('A1:H1', function($cells) {				
								$cells->setFontSize(14);	
								$cells->setAlignment('center');		
								$cells->setFontColor('#73879C');	
								$cells->setFontWeight('bold');
								$cells->setBackground('#EDEDED');			
							});		
						});	
						//Cargando los datos Información detallado de las personas a cargo
						$excel->sheet('Personas a Cargo', function($sheet) use($dataPersonasCargo) {		
							$sheet->fromArray($dataPersonasCargo, null, 'A0', true);	
							//Negrilla la primera fila
							$sheet->cells('A1:I1', function($cells) {				
								$cells->setFontSize(14);	
								$cells->setAlignment('center');		
								$cells->setFontColor('#73879C');	
								$cells->setFontWeight('bold');
								$cells->setBackground('#EDEDED');	
							});		
						});	
						//Cargando los datos Información detallado de los familiares que laboran en Nutibara
						$excel->sheet('Laboran en Nutibara', function($sheet) use($dataLabNutibara) {		
							$sheet->fromArray($dataLabNutibara, null, 'A0', true);	
							//Negrilla la primera fila
							$sheet->cells('A1:I1', function($cells) {				
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