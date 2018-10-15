<?php

namespace App\Models\Nutibara\OrdenResolucion;
use Illuminate\Database\Eloquent\Model;

class OrdenResolucion extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_orden_hoja_trabajo_cabecera';
	public $timestamps  = false;
}
