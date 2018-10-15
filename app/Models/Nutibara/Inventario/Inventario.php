<?php

namespace App\Models\Nutibara\Inventario;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_inventario_producto';
	public $timestamps  = false;
}
