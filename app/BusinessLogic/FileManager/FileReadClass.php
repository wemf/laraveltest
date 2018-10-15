<?php 

namespace App\BusinessLogic\FileManager;
set_time_limit(0);

class FileReadClass {

    function __destruct() {
       unset($fp); 
   }

    public static function readFile($space=false,$path)
	{
        $format=array();
        //Lectura del archivo plano
        $fp = fopen($path, "r");
        while(!feof($fp)) {
            $linea = fgets($fp);   
            if(!empty($linea) && $linea!=PHP_EOL){
                if($space!=false){
                    $linea=explode($space, trim($linea));
                }else{
                    $linea=trim($linea);
                }
                array_push($format,$linea);
            }   
        }
        fclose($fp); 
        return $format;
	}
}