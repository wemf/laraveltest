<?php 

namespace App\BusinessLogic\Nutibara\Master;
use App\AccessObject\FormMotor\MotorQuery;
use App\AccessObject\Persistence\FormPersistenceAccessObject;
use config\messages;


class MasterBusinessLogic {

	public static function Categories ($start,$end,$colum, $order,$search){
		if(empty($search)){
			$result = AdminCategoryAccessObject::Categories($start,$end,$colum, $order);
		}else{
			$result = AdminCategoryAccessObject::CategoriesWhere($colum, $order,$search);
		}
		return $result;
	}

	public static function getCountCategories()
	{
		return (int)AdminCategoryAccessObject::getCountCategories();
	}

	public static function getCategoriesById($id)
	{
		return AdminCategoryAccessObject::getCategoriesById($id);
	}

	public static function getForms(){
		$msm = MotorQuery::getForms();
		return $msm;
	}

	public static function getFormsWithPersistence(){
		$msm = FormPersistenceAccessObject::getFormsWithPersistence();
		return $msm;
	}
}