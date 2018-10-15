<?php

namespace App\Models\Notificacion;
use Illuminate\Database\Eloquent\Model;

class NotificacionTipoDB extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_sys_notificacion_tipo';
	public $timestamps  = false;
}
