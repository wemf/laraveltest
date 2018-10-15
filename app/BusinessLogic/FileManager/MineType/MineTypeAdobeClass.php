<?php
namespace App\BusinessLogic\FileManager\MineType;
use App\BusinessLogic\FileManager\FileTypeInterface;

class MineTypeAdobeClass implements FileTypeInterface 
{  
   function mineType()
   {
        $mime_types = array(
            // adobe
            'application/pdf',
            'image/vnd.adobe.photoshop',
            'application/postscript',
            'application/postscript',
            'application/postscript'
        );
        return $mime_types;
   }
    
}