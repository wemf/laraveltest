<?php

namespace App\Models\Nutibara\GestionTesoreria\ConfiguracionContable;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionContable extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_cont_configuracioncontable';
	public $timestamps  = false;
}