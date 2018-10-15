<?php 

namespace App\BusinessLogic\FileManager\Excel;
set_time_limit(0);
use PHPExcel; 
use PHPExcel_IOFactory;
use App\BusinessLogic\FileManager\Excel\MyReadFilter;

class ReadExcelClass {
    public static function read($inputFileName,$sheetname,$rowEnd=0,$leterEnd=0,$inputFileType = 'Excel2007')
    {           
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setLoadSheetsOnly($sheetname);
        if(!empty($rowEnd) && !empty($leterEnd)){
            $filterSubset = new MyReadFilter(1,$rowEnd,range('A',$leterEnd));
            $objReader->setReadFilter($filterSubset);
        }      
        $objPHPExcel = $objReader->load($inputFileName);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
        return $sheetData;     
    }
}