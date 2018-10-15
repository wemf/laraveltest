<?php

namespace App\Models\Nutibara\Clientes\MotivoRetiro;
use Illuminate\Database\Eloquent\Model;

class MotivoRetiro extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_empl_motivo_retiro';
	public $timestamps  = false;
}
