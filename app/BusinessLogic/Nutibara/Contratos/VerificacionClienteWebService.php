<?php

namespace App\BusinessLogic\Nutibara\Contratos;
use config\messages;

class VerificacionClienteWebService 
{
    private $datos = [];

    public function __construct($datos){
        $this->datos = $datos;
    }


    public function verificacionCliente(){
        //url que se consume 
        $dir = curl_init("http://dws.solutions/nutibara/servicios_php/index.php?action=".$this->datos['action']."&tipo-documento=".$this->datos['tipodocumento']."&num-documento=".$this->datos['numdocumento']);
        //obtine la respuesta del otro lado, true si es correcto o false si no lo es
        curl_setopt($dir, \CURLOPT_RETURNTRANSFER,true);
        //Verbo http se utilizar la petición
        curl_setopt($dir, \CURLOPT_CUSTOMREQUEST,"GET");
        //obtiene la respuesta
        $response = curl_exec($dir);
        //cierra el recurso curl y libera los recursos del sistema
        curl_close($dir);
        echo $response;
        // $response = explode(",",$response);
        // foreach ($response as $key => $value) {
        //     $respuesta[$key]=explode(":",$value);
        // }
        // return $respuesta;   
    }
}

?>