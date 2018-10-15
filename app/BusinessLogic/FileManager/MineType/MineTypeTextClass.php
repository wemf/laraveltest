<?php
namespace App\BusinessLogic\FileManager\MineType;
use App\BusinessLogic\FileManager\FileTypeInterface;

class MineTypeTextClass implements FileTypeInterface 
{
   function mineType()
   {
       $mime_types = array(
           //text
            'text/plain',
            'text/html',
            'text/html',
            'text/html',
            'text/css',
            'application/javascript',
            'application/json',
            'application/xml',
            'application/x-shockwave-flash',
            'video/x-flv'
        );

        return $mime_types;
   }
    
}