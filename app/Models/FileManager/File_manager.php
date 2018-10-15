<?php

namespace App\Models\FileManager;
use Illuminate\Database\Eloquent\Model;

class File_manager extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_sys_archivo';
	public $timestamps  = false;
}
