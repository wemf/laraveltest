<?php

namespace App\Models\Nutibara\AsociarCliente\TipoCliente;
use Illuminate\Database\Eloquent\Model;

class TipoCliente extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_clie_tipo';
	public $timestamps  = false;
}
