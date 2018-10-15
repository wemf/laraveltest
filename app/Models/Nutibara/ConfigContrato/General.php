<?php

namespace App\Models\Nutibara\ConfigContrato;
use Illuminate\Database\Eloquent\Model;

class General extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_contr_dato_general';
	public $timestamps  = false;
}
