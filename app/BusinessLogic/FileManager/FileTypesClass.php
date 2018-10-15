<?php
namespace App\BusinessLogic\FileManager;

use App\BusinessLogic\FileManager\FileTypeInterface;

use App\BusinessLogic\FileManager\MineType\MineTypeAdobeClass;
use App\BusinessLogic\FileManager\MineType\MineTypeArchiveClass;
use App\BusinessLogic\FileManager\MineType\MineTypeAudioVideoClass;
use App\BusinessLogic\FileManager\MineType\MineTypeImageClass;
use App\BusinessLogic\FileManager\MineType\MineTypeMsOffice;
use App\BusinessLogic\FileManager\MineType\MineTypeOpenOffice;
use App\BusinessLogic\FileManager\MineType\MineTypeTextClass;
use App\BusinessLogic\FileManager\MineType\MineTypeTextImgClass;

class FileTypesClass  
{ 
        
    private static function mineType(FileTypeInterface $class){       
        return $class->mineType();        
    } 

    private static function mineTypeClass()
    {       
       return $mineType=array(
            'adobe'=>new MineTypeAdobeClass(), 
            'archives'=>new MineTypeArchiveClass(), 
            'audioVideo'=>new MineTypeAudioVideoClass(), 
            'images'=>new MineTypeImageClass(), 
            'msOffice'=>new MineTypeMsOffice(), 
            'openOffice'=>new MineTypeOpenOffice(), 
            'text'=>new MineTypeTextClass(),
            'imgText'=>new MineTypeTextImgClass(),
        );
    }

    public static function val($mineType,$type)
    {               
        $classArray=self::mineTypeClass();         
        if (array_key_exists($mineType,$classArray))
        {             
            $val=self::mineType($classArray[$mineType]);
            if (in_array((string)$type,$val)) {           
                return true;          
            }  
            else{
                return false; 
            }  
        }
    }

    public static function getType($mineType)
    {
        $classArray=self::mineTypeClass(); 
        foreach ($classArray as $type => $class) {
           $val=self::mineType($class);
           if (in_array($mineType,$val)) {           
                return $type;          
            } 
        } 
        return false; 
    }
}