<?php

namespace App\Models\Nutibara\MedidasPeso;
use Illuminate\Database\Eloquent\Model;

class MedidasPeso extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_sys_medida_peso';
	public $timestamps  = false;
}
