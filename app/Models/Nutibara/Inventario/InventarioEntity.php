<?php

namespace App\Models\Nutibara\Inventario;
use Illuminate\Database\Eloquent\Model;

class InventarioEntity extends Model
{
	protected $primaryKey = 'id_inventario';
	protected $table = 'tbl_inventario_producto';
	public $timestamps  = false;
}
