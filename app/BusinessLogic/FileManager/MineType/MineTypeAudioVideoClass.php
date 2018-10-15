<?php
namespace App\BusinessLogic\FileManager\MineType;
use App\BusinessLogic\FileManager\FileTypeInterface;

class MineTypeAudioVideoClass implements FileTypeInterface 
{
   function mineType()
   {
        $mime_types = array(
            // audio/video           
            'video/mp4',
            'video/avi'
        );
        return $mime_types;
   }    
}