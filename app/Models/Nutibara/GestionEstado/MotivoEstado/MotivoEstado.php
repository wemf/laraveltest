<?php

namespace App\Models\Nutibara\GestionEstado\MotivoEstado;
use Illuminate\Database\Eloquent\Model;

class MotivoEstado extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_sys_motivo_estado';
	public $timestamps  = false;
}
