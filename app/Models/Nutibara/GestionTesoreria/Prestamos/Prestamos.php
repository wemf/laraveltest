<?php

namespace App\Models\Nutibara\GestionTesoreria\Prestamos;
use Illuminate\Database\Eloquent\Model;

class Prestamos extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_tes_prestamos';
	public $timestamps  = false;
}
