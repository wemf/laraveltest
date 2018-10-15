<?php

namespace App\Models\Nutibara\Clientes\EstadoCivil;
use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_clie_estado_civil';
	public $timestamps  = false;
}

?>