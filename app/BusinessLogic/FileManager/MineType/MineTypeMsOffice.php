<?php
namespace App\BusinessLogic\FileManager\MineType;
use App\BusinessLogic\FileManager\FileTypeInterface;

class MineTypeMsOffice implements FileTypeInterface 
{  
   function mineType()
   {
        $mime_types = array(
            // ms office
           'application/msword',
           'application/rtf',
           'application/vnd.ms-excel',
           'application/vnd.ms-powerpoint',
        );
        return $mime_types;
   }
}