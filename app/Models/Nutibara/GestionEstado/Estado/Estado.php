<?php

namespace App\Models\Nutibara\GestionEstado\Estado;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_sys_estado_tema';
	public $timestamps  = false;
}
