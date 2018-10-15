<?php
namespace App\BusinessLogic\FileManager;

class DownloadTxt{
    /**
     * Arma y retorna la cabecera con un Archivo de texto con el nombre que recibe
     * @param  string  $filename
     * @return \Response::make($content, 200, $headers)
     */   
    public static function Export ($fileName)
    {   
            $content = '';
            $filename = $fileName."_".date("Y-m-d").".txt";
            $headers = array(
                'Content-Type' => 'text/html',
                'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
            );
            return \Response::make($content, 200, $headers);
    }


}
