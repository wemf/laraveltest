<?php 

namespace App\BusinessLogic\FileManager;
set_time_limit(0);
use App\BusinessLogic\FileManager\FileTypesClass;
use App\AccessObject\FileManager\FileManagerAccessObject;

class FolderReadClass { 
    public function validateType(){
        return  $types = array(
            'png',
            'jpg',
            'jpeg',            
            'gif',
            'bmp',
            'mp4',
            'avi'
        );
    }
  
	public function readFolder($dir,$key_lote,$isHash=false){
        
		$data2=[];        
		$iterator = new \DirectoryIterator($dir); 
        $fecha=date("Y-m-d H:i:s");
		foreach ($iterator as $fileinfo) {
            if ($fileinfo->isFile()) {  
                $name=$fileinfo->getFilename();
                $path=$fileinfo->getPathname();
                $extension=$fileinfo->getExtension();                
                if($isHash){
                    $hash=hash_file('md5', $path);
                    $a=FileManagerAccessObject::buscarHash($hash); 
                    if($a>0){return false;}//retornar array push con los archivos que ya se han subido
                }else{
                    $hash='';
                } 
                if (in_array($extension,$this->validateType())){  
                    $name=$fileinfo->getFilename();
                    $dateSave=array(
                        'name'=>$name,                        
                        'size'=>$fileinfo->getSize(),
                        'extension'=>$extension,
                        'path'=>$path,
                        'date'=>$fecha,
                        'userId'=>\Sentinel::getUser()->id,
                        'hash'=>$hash,
                        'key_lote'=>$key_lote,
                        'state'=>'1'
                    );	
                    array_push($data2,$dateSave);
                }
            }         
		}        
		return $data2;
	}
}