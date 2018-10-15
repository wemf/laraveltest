<?php

namespace App\Models\Nutibara\Regimen;
use Illuminate\Database\Eloquent\Model;

class Regimen extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_clie_regimen_contributivo';
	public $timestamps  = false;
}
