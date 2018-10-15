<?php

namespace App\Models\Nutibara\Archivo;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_sys_archivo';
	public $timestamps  = false;
}
