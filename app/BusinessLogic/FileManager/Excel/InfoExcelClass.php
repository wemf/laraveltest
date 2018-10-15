<?php 

namespace App\BusinessLogic\FileManager\Excel;
set_time_limit(0);
use PHPExcel; 
use PHPExcel_IOFactory;
use App\BusinessLogic\FileManager\Excel\InputFileExcelClass;

class InfoExcelClass {
    public static function info( $dir,$inputFileType = 'Excel2007')
    {       
        if(in_array($inputFileType,InputFileExcelClass::type())){
            $inputFileName =$dir ;     
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $worksheetData = $objReader->listWorksheetInfo($inputFileName);        
            return $worksheetData;
        }        
    }
}