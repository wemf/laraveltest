<?php

namespace App\Models\Nutibara\Monedas;
use Illuminate\Database\Eloquent\Model;

class Monedas extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_sys_tipo_moneda';
	public $timestamps  = false;
}
