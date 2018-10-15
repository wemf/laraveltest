<?php

namespace App\Models\Nutibara\Clientes\TipoDocumento;
use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_clie_tipo_documento';
	public $timestamps  = false;
}
