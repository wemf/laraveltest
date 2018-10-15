<?php

namespace App\Models\Nutibara\GestionTesoreria\Impuesto;
use Illuminate\Database\Eloquent\Model;

class Impuesto extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_tes_impuesto';
	public $timestamps  = false;
}
