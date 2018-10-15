<?php

namespace App\Models\Nutibara\Clientes\DenominacionMoneda;
use Illuminate\Database\Eloquent\Model;

class DenominacionMoneda extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_sys_denominacion_moneda';
	public $timestamps  = false;
}
