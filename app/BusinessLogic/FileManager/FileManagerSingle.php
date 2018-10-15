<?php 

namespace App\BusinessLogic\FileManager;
use App\BusinessLogic\FileManager\FileManagerBusinessLogic;
use App\AccessObject\FileManager\FileManagerAccessObject;

class FileManagerSingle extends FileManagerBusinessLogic { 

	public function __construct($file)
	{      
       parent::__construct($file);
	}

    public function save($key_lote){
        $id=FileManagerAccessObject::Create($this->pushFile($key_lote));
        return $id;
    }
}