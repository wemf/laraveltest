<?php

namespace App\Models\autenticacion;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_usuario_role';
	
}