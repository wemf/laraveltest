<?php
namespace App\BusinessLogic\Utility\DateFormat;

class Date
{ 
    private function Create($item)
    {
        return preg_replace("/^([0-9]{2})([\/|\-])([0-9]{2})([\/|\-])([0-9]{4})/i","$5-$3-$1",$item);
    }

    public function CreateInverse($item)
    {
        if(preg_match("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})( [0-9]{2}:[0-9]{2}:[0-9]{2})/i",$item))
            return preg_replace("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})( [0-9]{2}:[0-9]{2}:[0-9]{2})/i","$3-$2-$1$4",$item);
        else
            return preg_replace("/([0-9]{4})\-([0-9]{2})\-([0-9]{2})/i","$3-$2-$1",$item);
    }
    
    public function ToJson($input)
    {
        if (!empty($input) && is_array($input)){           
            $input=json_encode($this->ToArray($input));
        }
        return $input;
    }

    public function ToJsonInverse($input)
    {
        if (!empty($input) && is_array($input)){           
            $input=json_encode($this->ToArrayInverse($input));
        }
        return $input;
    }

    public function ToArray($input)
    {
        if (!empty($input) && is_array($input)){
            array_walk_recursive($input, function (&$item) {
                $item = $this->Create($item);
            });
        }
        return $input;
    }

    public function ToArrayInverse($input)
    {
        if (!empty($input) && is_array($input)){            
            $input = $this->objectToArray($input);
        }
        return $input;
    }

    public function objectToArray($input){
        array_walk_recursive($input, function (&$item) {
                if(is_object($item)) {
                    $item = $this->objectToArray($item);
                }else{
                    $item = $this->CreateInverse($item);
                }
        });
        return $input;
    }

    public function ToFormat($input)
    {
        if(!empty($input))
            $input = $this->Create($input);  
        return $input;
    }

    public function ToFormatInverse($input)
    {
        if(!empty($input))
            $input = $this->CreateInverse($input);  
        return $input;
    }

}