<?php

namespace App\Models\Nutibara\GestionTesoreria\Concepto;
use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_tes_concepto';
	public $timestamps  = false;
}