<?php

namespace App\Models\Nutibara\GenerarPlan;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_plan_cotizacion';
	public $timestamps  = false;
}
