<?php

namespace App\Models\Nutibara\GestionEstado\Motivo;
use Illuminate\Database\Eloquent\Model;

class Motivo extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_sys_motivo';
	public $timestamps  = false;
}
