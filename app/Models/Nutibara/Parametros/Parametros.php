<?php

namespace App\Models\Nutibara\Parametros;
use Illuminate\Database\Eloquent\Model;

class Parametros extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_parametro_general';
	public $timestamps  = false;
}
