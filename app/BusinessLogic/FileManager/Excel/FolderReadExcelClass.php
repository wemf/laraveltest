<?php 

namespace App\BusinessLogic\FileManager\Excel;
use App\BusinessLogic\FileManager\FolderReadClass;

class FolderReadExcelClass extends FolderReadClass { 
    public function validateType(){
        return  $types = array(
            'xlsx',           
        );
    }
}