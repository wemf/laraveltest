<?php

namespace App\Models\Nutibara\Clientes\Empleado;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_clie_empleado';
	public $timestamps  = false;
}
