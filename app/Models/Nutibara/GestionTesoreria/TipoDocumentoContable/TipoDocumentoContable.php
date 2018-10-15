<?php

namespace App\Models\Nutibara\GestionTesoreria\TipoDocumentoContable;
use Illuminate\Database\Eloquent\Model;

class TipoDocumentoContable extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_cont_tipo_documento_contable';
	public $timestamps  = false;
}
