<?php

namespace App\Models\Nutibara\GestionTesoreria\Causacion;
use Illuminate\Database\Eloquent\Model;

class Causacion extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_tes_causacion';
	public $timestamps  = false;
}