<?php 

namespace App\BusinessLogic\Auditoria;



class CampoAuditoria {

    private $state;
    private $user;
    private $date;   
    private $dataPost;

    public function __construct($dataPost=null)
    {
        $this->user=\Auth::id();
        $this->date=date("Y-m-d H:i:s");        
        $this->state=1;
        $this->dataPost=$dataPost;
    }

    public function setState($state=1)
    {
        $this->state=$state;
        return $this;
    }

    public function getState()
    {
        return $this->state;       
    }

    public function arrayMerge($data2)
    {
       return $this->dataPost=array_merge($this->dataPost,$data2);	
    }

    public function getInsert()
    {
        $data=[
            'id_user_created_at'=>$this->user,
            'created_at'=>$this->date,
            'state'=>$this->state
        ];
        return $this->arrayMerge($data);
    }

    public function getUpdate()
    {
        $data=[
            'id_user_updated_at'=>$this->user,
            'updated_at'=>$this->date,
            'state'=>$this->state
        ];
        return $this->arrayMerge($data);
    }

    public function getDelete()
    {
        $this->setState(0);
        $data=[
            'id_user_deleted_at'=>$this->user,
            'deleted_at'=>$this->date,
            'state'=>$this->state
        ];
        return $data;
    }
    public function getActive()
    {
        $this->setState(1);
        $data=[
            'updated_at'=>$this->date,
            'state'=>$this->state
        ];
        return $data;
    }
}