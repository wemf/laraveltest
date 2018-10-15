<?php

namespace App\Models\Nutibara\DiasFestivos;
use Illuminate\Database\Eloquent\Model;

class DiasFestivos extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_sys_dias_festivos';
	public $timestamps  = false;
}
