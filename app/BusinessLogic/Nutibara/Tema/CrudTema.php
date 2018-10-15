<?php 

namespace App\BusinessLogic\Nutibara\Tema;
use App\AccessObject\Nutibara\Tema\Tema;
use config\messages;

class CrudTema {

	public static function Tema ($start,$end,$colum, $order,$search)
    {
		if($search['estado']=="")
        {
			$result = Tema::Tema($start,$end,$colum, $order);
		}else
        {
			$result = Tema::TemaWhere($start,$end,$colum, $order,$search);
		}
		return $result;
	}

	public static function getCountTema()
	{
		return (int)Tema::getCountTema();
	}

	public static function getTemaById($id)
	{
		return Tema::getTemaById($id);
	}

	public static function getSelectList()
	{
		return Tema::getSelectList();
	}

	public static function getEstadosByTema($id_tema)
	{
		return Tema::getEstadosByTema($id_tema);
	}
}