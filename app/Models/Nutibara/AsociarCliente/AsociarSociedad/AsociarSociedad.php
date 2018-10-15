<?php

namespace App\Models\Nutibara\AsociarCliente\AsociarSociedad;
use Illuminate\Database\Eloquent\Model;

class AsociarSociedad extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_cliente';
	public $timestamps  = false;
}
