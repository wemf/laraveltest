<?php

namespace App\Models\Nutibara\Orden;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
	protected $primaryKey = 'id_orden';
	protected $table = 'tbl_orden';
	public $timestamps  = false;
}
