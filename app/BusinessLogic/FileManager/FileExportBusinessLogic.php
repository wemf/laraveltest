<?php

namespace App\BusinessLogic\FileManager;
use Config\messages;


class FileExportBusinessLogic{
    public static function Exports ($dataExport)
    {   
        for ($i=0; $i < count($dataExport); $i++) { 
            echo $dataExport[$i] . PHP_EOL; 
        }
        $msn = ['msm' => Messages::$exportrunt['ok'] , 'val' => true];
        return $msn;
    }

    public static function Exports2 ($dataExport)
    {   
        foreach ($dataExport as $key => $value) {
            echo $value . PHP_EOL; 
        }
        $msn = ['msm' => Messages::$exportrunt['ok'] , 'val' => true];
        return $msn;
    }


}