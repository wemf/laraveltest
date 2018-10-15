<?php
namespace App\BusinessLogic\FileManager\MineType;
use App\BusinessLogic\FileManager\FileTypeInterface;

class MineTypeImageClass implements FileTypeInterface 
{
   function mineType()
   {
       $mime_types = array(
            // images
            'image/png',         
            'image/jpeg'           
        );
        return $mime_types;
   }
    
}