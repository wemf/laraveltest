<?php

namespace App\Models\Nutibara\Products;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_prod_catalogo';
	public $timestamps  = false;
}
