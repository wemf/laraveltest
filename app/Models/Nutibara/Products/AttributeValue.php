<?php

namespace App\Models\Nutibara\Products;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
	protected $primaryKey = 'id';
	protected $table = 'tbl_prod_atributo_valores';
	public $timestamps  = false;
}
