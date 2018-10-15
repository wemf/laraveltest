<?
/*
| ----------------------------------------------------------------- |
MEGAPINTURAS LTDA
Desarrollado por Comprandofacil
http://www.comprandofacil.com/
Copyright (c) 2000 - 2009
Medellin - Colombia
=====================================================================
  Autores:
  Juan Fernando Fernández <consultorweb@comprandofacil.com>
  Juan Felipe Sánchez <graficoweb@comprandofacil.com>
  José Fernando Peña <soporteweb@comprandofacil.com>
=====================================================================
| ----------------------------------------------------------------- |
 Traer los datos de retenciones y descuento del cliente

*/
session_start();
include("../../incluidos_modulos/varconexion.php");
include("../../incluidos_modulos/comunes.php");
include("../../incluidos_modulos/modulos.funciones.php");
include("../../incluidos_modulos/sql.injection.php");
include("../../incluidos_modulos/validacion.campos.php");
//include("../../incluidos_modulos/class.rc4crypt.php");
 $param=$_REQUEST['param'];

		$sqlz="select nombre_o_razn_social,apellido_o_nombre_comercial,id,cdula_o_nit from  crm_clientes a ";
		$sqlz.="where a.idactivo=1 and CONCAT_WS(' ',nombre_o_razn_social,apellido_o_nombre_comercial) like '%".$param."%'  ORDER BY a.nombre_o_razn_social ASC ";
		//echo $sqlz;
		$result = $db->Execute($sqlz);
		if (!$result->EOF) {
		$data.="<select onclick='selectlista()' style='width:455px' size='10' class='text1' name='lista' id='lista'>";
		//$data.="<option value=''> --- Seleccionar --- </option>";
		$cont=1;
		while(!$result->EOF) {
		        $nombres=$result->fields[0];
		        $apellidos=reemplazar($result->fields[1]);
		        $idcliente=reemplazar($result->fields[2]);
		      	$cdula_o_nit=$result->fields[3];


		        // aqui se pintan los valores de los option
				$data.="<option value='$idcliente' ";
				//if($dsmciudad==$valor) $data.=" selected='selected'";
				$data.=">".$nombres." ".$apellidos." (".$cdula_o_nit.")"."</option>";
		        //$data.="<li>".$dsnombre1." ".$dsnombre2." ".$dsapell."</li>";

				$cont=$cont+1;
			$result->MoveNext();
     	}
			$data.="</select>";

		  }
		$result->Close();


echo $data;
?>