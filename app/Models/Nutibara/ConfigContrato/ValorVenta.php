<?php

namespace App\Models\Nutibara\ConfigContrato;
use Illuminate\Database\Eloquent\Model;

class ValorVenta extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_contr_val_venta';
	public $timestamps  = false;
}