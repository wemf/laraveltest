<?php 

namespace App\BusinessLogic\FileManager;

use config\messages;
use App\BusinessLogic\FileManager\FileReadClass;
use App\BusinessLogic\FileManager\FileTypesClass;
use App\AccessObject\FileManager\FileManagerAccessObject;

class FileManagerBusinessLogic {  
    
    private $file;
    private $type;
    private $name;   
    private $size;
    private $extension;
    private $date;   
    private $userId;
    private $hash;
    private $path;


	public function __construct($file)
	{      
        $this->file=$file;	  
        $this->type=$file->getMimeType();
        $this->size=$file->getSize(); 
        $this->name=$file->getClientOriginalName(); 
        $this->extension=$file->getClientOriginalExtension(); 
        $this->hash=hash_file('md5', $file);      
        $this->userId=\Auth::id();       
        $this->date = date("Y-m-d H:i:s"); 
	}

    public function getHash(){
        return FileManagerAccessObject::buscarHash($this->hash);
    }

    public function getIdHash(){
        return FileManagerAccessObject::buscarIdHash($this->hash);
    }

	public function moveFile($key_lote,$path,$mineType='false')
    { 
        
        $this->path=$path;
        $msm=array('msm'=>array(),'val'=>false); 
        $controlLoad=$this->getIdHash();
        if($controlLoad == NULL){
            //Validation type archive  
            if($mineType!='false'){
                $val_mineType=FileTypesClass::val($mineType,$this->type);
            }else{
                 $val_mineType=true;
            }     
                        
            if($this->size>0 && $val_mineType){           
                try {
                    if (!file_exists($this->path)) {
                        mkdir($this->path, 0777, true); 
                    } 
                    if(!file_exists($this->path.DIRECTORY_SEPARATOR.$this->name)) {           
                        $name=$this->name;
                    }else{
                        $name=uniqid().'_'.$this->name; 
                    }
                    $this->name=$name;
                    $this->file->move($this->path,$name);
                    $isSaved=$this->save($key_lote);
                    if($isSaved==true || $isSaved>0 )
                    {
                        $msm['val']=$isSaved; 
                        array_push($msm['msm'],Messages::$fileManager['copy']);  
                        array_push($msm['msm'],$isSaved);  
                    }else{
                        array_push($msm['msm'],Messages::$fileManager['error']);  
                    }
                } catch (Exception  $e) {  
                    $msm['val']=false; 
                    $msm['msm']=array();
                    array_push($msm['msm'],Messages::$fileManager['error']); 
                }
            }else{            
                array_push($msm['msm'],Messages::$fileManager['error']); 
                if (empty($this->size)){ 
                    array_push($msm['msm'],Messages::$fileManager['empty']); 
                }
                if (!$val_mineType){  
                    array_push($msm['msm'],Messages::$fileManager['ext']);  
                }
            }        

        }else{               
            array_push($msm['msm'],Messages::$fileManager['duplicated']); 
            array_push($msm['msm'],$controlLoad->id); 
        }
        return $msm;
	}
  

    public function pushFile($key_lote)
    { 
       return $dateSave=array(
				'nombre'=>$this->name,				
                'tamanho'=>$this->size,
				'extension'=>$this->extension,
				'ruta'=>realpath($this->path.DIRECTORY_SEPARATOR.$this->name),
                'fecha'=>$this->date,
                'id_usuario'=>$this->userId,
                'hash'=>$this->hash,
                'key_lote'=>$key_lote,
				'estado'=>'1'
			);
    }

    public function save($key_lote){
        if(FileManagerAccessObject::Create2($this->pushFile($key_lote))){
           return true;
        }else{
            return false;  
        }
    }

}