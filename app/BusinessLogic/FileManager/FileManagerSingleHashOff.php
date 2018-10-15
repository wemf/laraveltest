<?php 

namespace App\BusinessLogic\FileManager;
use App\BusinessLogic\FileManager\FileManagerSingle;

class FileManagerSingleHashOff extends FileManagerSingle { 

	public function __construct($file)
	{      
       parent::__construct($file);
	}

    public function getHash(){
        return 0;
    }
}