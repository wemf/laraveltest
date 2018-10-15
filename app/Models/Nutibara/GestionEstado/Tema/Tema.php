<?php

namespace App\Models\Nutibara\GestionEstado\Tema;
use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_sys_tema';
	public $timestamps  = false;
}
