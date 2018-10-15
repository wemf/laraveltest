<?php
namespace App\BusinessLogic\FileManager\MineType;
use App\BusinessLogic\FileManager\FileTypeInterface;

class MineTypeOpenOffice implements FileTypeInterface 
{ 
   function mineType()
   {
        $mime_types = array(
            // open office
            'application/vnd.oasis.opendocument.text',
            'application/vnd.oasis.opendocument.spreadsheet',
        );
        return $mime_types;
   }

  
    
}