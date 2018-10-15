<?php
namespace App\BusinessLogic\FileManager\MineType;
use App\BusinessLogic\FileManager\FileTypeInterface;

class MineTypeArchiveClass implements FileTypeInterface 
{
  
   function mineType()
   {
       $mime_types = array(
            // archives
            'application/zip',
            'application/x-rar-compressed',
            'application/x-msdownload',
            'application/x-msdownload',
            'application/vnd.ms-cab-compressed'
        );
        return $mime_types;
   }
}