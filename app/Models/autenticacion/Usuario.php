<?php

namespace App\Models\autenticacion;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_usuario';	
}