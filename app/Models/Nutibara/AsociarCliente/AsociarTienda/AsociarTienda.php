<?php

namespace App\Models\Nutibara\AsociarCliente\AsociarTienda;
use Illuminate\Database\Eloquent\Model;

class AsociarTienda extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_cliente';
	public $timestamps  = false;
}
