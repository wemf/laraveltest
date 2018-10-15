<?php

namespace App\Models\Nutibara\Clientes\TipoTrabajo;
use Illuminate\Database\Eloquent\Model;

class TipoTrabajo extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_clie_tipo_trabajo';
	public $timestamps  = false;
}
