<?php
namespace App\BusinessLogic\FileManager\MineType;
use App\BusinessLogic\FileManager\FileTypeInterface;

class MineTypeTextImgClass implements FileTypeInterface 
{
   function mineType()
   {
       $mime_types = array(        
            'text/plain',
            'image/png',
            'image/jpeg',
            'image/jpeg',
            'image/jpeg',
            'image/gif',
            'image/bmp',
        );

        return $mime_types;
   }
    
}