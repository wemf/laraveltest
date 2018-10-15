<?php

namespace App\Models\Nutibara\Products;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_prod_atributo';
	public $timestamps  = false;
}
