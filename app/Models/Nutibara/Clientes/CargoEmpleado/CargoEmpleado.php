<?php

namespace App\Models\Nutibara\Clientes\CargoEmpleado;
use Illuminate\Database\Eloquent\Model;

class CargoEmpleado extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_empl_cargo';
	public $timestamps  = false;
}
