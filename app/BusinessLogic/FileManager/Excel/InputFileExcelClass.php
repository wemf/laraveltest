<?php
namespace App\BusinessLogic\FileManager\Excel;

class InputFileExcelClass 
{  
   static function type()
   {
        $type = array(
                'Excel5',
                'Excel2007',
                'Excel2003XML',
                'OOCalc',
                'Gnumeric',
        );
        return $type;
   }
    
}