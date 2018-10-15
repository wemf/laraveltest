<?php

namespace App\Models\Nutibara\GestionTesoreria\TipoImpuesto;
use Illuminate\Database\Eloquent\Model;

class TipoImpuesto extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_tes_tipo_impuesto';
	public $timestamps  = false;
}
