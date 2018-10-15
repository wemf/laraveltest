<?php

namespace App\Models\Nutibara\GestionPlan;
use Illuminate\Database\Eloquent\Model;

class GestionPlan extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_plan_separe';
	public $timestamps  = false;
}
