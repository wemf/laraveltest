<?php

namespace App\Models\Notificacion;
use Illuminate\Database\Eloquent\Model;

class NotificacionDB extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_sys_notificacion';
	public $timestamps  = false;
}
