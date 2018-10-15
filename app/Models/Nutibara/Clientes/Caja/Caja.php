<?php

namespace App\Models\Nutibara\Clientes\Caja;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_clie_caja_compensacion';
	public $timestamps  = false;
}
